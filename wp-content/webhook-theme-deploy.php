<?php
/**
 * Webhook для обновления только темы Gotry из GitHub
 * Разместите этот файл на хостинге в: public_html/wp-content/webhook-theme-deploy.php
 * 
 * Настройте в GitHub: Settings → Webhooks → Add webhook
 * Payload URL: https://antongotry.dev/wp-content/webhook-theme-deploy.php?secret=ВАШ_СЕКРЕТНЫЙ_КЛЮЧ
 * Content type: application/json
 * Events: Just the push event
 */

// ============================================================================
// НАСТРОЙКИ - ИЗМЕНИТЕ ЭТИ ЗНАЧЕНИЯ!
// ============================================================================

// Секретный ключ для безопасности (измените на свой!)
define('WEBHOOK_SECRET', 'your-secret-key-here-change-me');

// Путь к корню WordPress на сервере
define('WP_ROOT', dirname(dirname(__FILE__))); // public_html

// Путь к папке темы
define('THEME_PATH', WP_ROOT . '/wp-content/themes/gotry');

// Путь к git репозиторию - ОТКЛЮЧЕНО для безопасности
// Git pull копирует весь репозиторий, что не нужно для обновления только темы
// Если нужен git pull, используйте sparse checkout, но лучше использовать GitHub API метод ниже
define('GIT_PATH', null); // Отключено

// GitHub репозиторий (owner/repo)
define('GITHUB_REPO', 'Antongotry/gotrydev');

// GitHub Personal Access Token (опционально, для приватных репозиториев)
// Получите здесь: https://github.com/settings/tokens
// Нужны права: repo (для приватных репозиториев)
define('GITHUB_TOKEN', ''); // Оставьте пустым для публичных репозиториев

// ============================================================================
// НЕ ИЗМЕНЯЙТЕ КОД НИЖЕ БЕЗ ПОНИМАНИЯ!
// ============================================================================

// Установка заголовков
header('Content-Type: application/json');
http_response_code(200);

// Логирование (опционально)
$log_file = WP_ROOT . '/wp-content/webhook-theme-deploy.log';
function log_message($message) {
    global $log_file;
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$timestamp] $message\n", FILE_APPEND);
}

log_message('Webhook triggered');

// Проверка метода запроса
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    log_message('Error: Not a POST request');
    echo json_encode(['error' => 'Only POST requests allowed']);
    exit;
}

// Проверка секретного ключа
if (!isset($_GET['secret']) || $_GET['secret'] !== WEBHOOK_SECRET) {
    log_message('Error: Invalid secret key');
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Получение данных от GitHub
$payload = file_get_contents('php://input');
$data = json_decode($payload, true);

if (!$data) {
    log_message('Error: Invalid JSON payload');
    echo json_encode(['error' => 'Invalid JSON payload']);
    exit;
}

// Проверка, что это push event
if (!isset($data['ref']) || $data['ref'] !== 'refs/heads/main') {
    log_message('Info: Not a push to main branch (ref: ' . ($data['ref'] ?? 'unknown') . ')');
    echo json_encode(['status' => 'ignored', 'reason' => 'Not a push to main branch']);
    exit;
}

// Проверка, есть ли изменения в папке темы
$theme_files_changed = false;
$changed_files = [];

if (isset($data['commits']) && is_array($data['commits'])) {
    foreach ($data['commits'] as $commit) {
        // Проверяем добавленные файлы
        if (isset($commit['added']) && is_array($commit['added'])) {
            foreach ($commit['added'] as $file) {
                if (strpos($file, 'wp-content/themes/gotry/') === 0) {
                    $theme_files_changed = true;
                    $changed_files[] = $file;
                }
            }
        }
        
        // Проверяем измененные файлы
        if (isset($commit['modified']) && is_array($commit['modified'])) {
            foreach ($commit['modified'] as $file) {
                if (strpos($file, 'wp-content/themes/gotry/') === 0) {
                    $theme_files_changed = true;
                    $changed_files[] = $file;
                }
            }
        }
        
        // Проверяем удаленные файлы
        if (isset($commit['removed']) && is_array($commit['removed'])) {
            foreach ($commit['removed'] as $file) {
                if (strpos($file, 'wp-content/themes/gotry/') === 0) {
                    $theme_files_changed = true;
                    $changed_files[] = $file;
                }
            }
        }
    }
}

if (!$theme_files_changed) {
    log_message('Info: No theme files changed');
    echo json_encode([
        'status' => 'ignored',
        'reason' => 'No theme files changed',
        'changed_files' => []
    ]);
    exit;
}

log_message('Theme files changed: ' . implode(', ', array_unique($changed_files)));

// ============================================================================
// ОБНОВЛЕНИЕ ТЕМЫ
// ============================================================================

$result = ['status' => 'success', 'method' => '', 'output' => []];

// ОТКЛЮЧЕН: Git pull копирует весь репозиторий, что не нужно
// Метод 1: Git pull - ОТКЛЮЧЕН для безопасности (не копировать весь репозиторий)
// Используем только GitHub API для загрузки только темы

// Метод 1: Загрузка через GitHub API (единственный безопасный метод)
log_message('Attempting to update via GitHub API');
$result['method'] = 'github_api';

// Создаем временную папку
$temp_dir = sys_get_temp_dir() . '/gotry-theme-' . time();
mkdir($temp_dir, 0755, true);

// URL для скачивания архива репозитория
$archive_url = 'https://github.com/' . GITHUB_REPO . '/archive/refs/heads/main.zip';
if (GITHUB_TOKEN) {
    $archive_url .= '?token=' . GITHUB_TOKEN;
}

// Скачиваем архив
$zip_file = $temp_dir . '/repo.zip';
$zip_content = file_get_contents($archive_url);

if ($zip_content === false) {
    log_message('Error: Failed to download archive from GitHub');
    rmdir($temp_dir);
    http_response_code(500);
    echo json_encode(['error' => 'Failed to download from GitHub']);
    exit;
}

file_put_contents($zip_file, $zip_content);

// Распаковываем архив
$zip = new ZipArchive();
if ($zip->open($zip_file) === TRUE) {
    $zip->extractTo($temp_dir);
    $zip->close();
    
    // Копируем только папку темы
    $extracted_path = $temp_dir . '/gotrydev-main/wp-content/themes/gotry';
    
    if (is_dir($extracted_path)) {
        // Убедимся, что папка темы существует
        if (!is_dir(THEME_PATH)) {
            log_message('Creating theme directory: ' . THEME_PATH);
            mkdir(THEME_PATH, 0755, true);
        }
        
        // Создаем список файлов темы для копирования (исключаем ненужные)
        $exclude_files = ['.DS_Store', '.git', '.gitignore'];
        
        // Копируем файлы и папки темы по одному (более безопасно)
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($extracted_path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        
        $copied_files = [];
        $errors = [];
        
        foreach ($iterator as $item) {
            $source_path = $item->getPathname();
            $relative_path = str_replace($extracted_path . DIRECTORY_SEPARATOR, '', $source_path);
            
            // Пропускаем исключенные файлы
            if (in_array(basename($relative_path), $exclude_files)) {
                continue;
            }
            
            // Пропускаем файлы из корня WordPress, которые не должны быть в теме
            // Проверяем содержимое index.php - если там WP_USE_THEMES, значит это корневой файл
            if (basename($relative_path) === 'index.php') {
                $file_content = file_get_contents($source_path);
                if (strpos($file_content, "define( 'WP_USE_THEMES', true )") !== false || 
                    strpos($file_content, 'define("WP_USE_THEMES", true)') !== false) {
                    log_message('Skipping root WordPress index.php (contains WP_USE_THEMES)');
                    continue;
                }
            }
            
            // Пропускаем другие файлы из корня WordPress
            $root_wp_files = ['wp-load.php', 'wp-blog-header.php', 'wp-config-sample.php', 
                             'wp-activate.php', 'wp-cron.php', 'wp-login.php', 'wp-signup.php'];
            if (in_array(basename($relative_path), $root_wp_files) && 
                strpos($relative_path, '/') === false) {
                log_message('Skipping root WordPress file: ' . $relative_path);
                continue;
            }
            
            $dest_path = THEME_PATH . DIRECTORY_SEPARATOR . $relative_path;
            
            if ($item->isDir()) {
                // Создаем директорию если не существует
                if (!is_dir($dest_path)) {
                    mkdir($dest_path, 0755, true);
                }
            } else {
                // Копируем файл
                if (copy($source_path, $dest_path)) {
                    $copied_files[] = $relative_path;
                    // Устанавливаем права на файл
                    chmod($dest_path, 0644);
                } else {
                    $errors[] = 'Failed to copy: ' . $relative_path;
                }
            }
        }
        
        $result['copied_files'] = count($copied_files);
        $result['files'] = $copied_files;
        
        if (!empty($errors)) {
            $result['errors'] = $errors;
            log_message('Errors during copy: ' . implode(', ', $errors));
        }
        
        if (count($copied_files) > 0) {
            log_message('Success: Theme updated via GitHub API. Copied ' . count($copied_files) . ' files');
        } else {
            log_message('Warning: No files were copied');
            $result['error'] = 'No files were copied';
        }
    } else {
        log_message('Error: Extracted theme directory not found: ' . $extracted_path);
        $result['error'] = 'Extracted theme directory not found';
    }
    
    // Очищаем временные файлы
    exec('rm -rf ' . escapeshellarg($temp_dir));
} else {
    log_message('Error: Failed to extract ZIP archive');
    $result['error'] = 'Failed to extract ZIP archive';
    rmdir($temp_dir);
}

// Возвращаем результат
echo json_encode($result);
log_message('Webhook completed: ' . json_encode($result));
