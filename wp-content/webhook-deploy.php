<?php
/**
 * Webhook для обновления темы Gotry и плагина Universal License Manager из GitHub
 * Разместите этот файл на хостинге в: public_html/wp-content/webhook-deploy.php
 * 
 * Настройте в GitHub: Settings → Webhooks → Add webhook
 * Payload URL: https://antongotry.dev/wp-content/webhook-deploy.php?secret=ВАШ_СЕКРЕТНЫЙ_КЛЮЧ
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

// Путь к папке плагина
define('PLUGIN_PATH', WP_ROOT . '/wp-content/plugins/universal-license-manager');

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
$log_file = WP_ROOT . '/wp-content/webhook-deploy.log';
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

// Проверка, есть ли изменения в папке темы или плагина
$theme_files_changed = false;
$plugin_files_changed = false;
$theme_changed_files = [];
$plugin_changed_files = [];

if (isset($data['commits']) && is_array($data['commits'])) {
    foreach ($data['commits'] as $commit) {
        $all_changes = array_merge(
            $commit['added'] ?? [],
            $commit['modified'] ?? [],
            $commit['removed'] ?? []
        );
        
        foreach ($all_changes as $file) {
            // Проверяем изменения в теме
            if (strpos($file, 'wp-content/themes/gotry/') === 0) {
                $theme_files_changed = true;
                $theme_changed_files[] = $file;
            }
            
            // Проверяем изменения в плагине
            if (strpos($file, 'wp-content/plugins/universal-license-manager/') === 0) {
                $plugin_files_changed = true;
                $plugin_changed_files[] = $file;
            }
        }
    }
}

if (!$theme_files_changed && !$plugin_files_changed) {
    log_message('Info: No theme or plugin files changed');
    echo json_encode([
        'status' => 'ignored',
        'reason' => 'No theme or plugin files changed',
        'changed_files' => []
    ]);
    exit;
}

if ($theme_files_changed) {
    log_message('Theme files changed: ' . implode(', ', array_unique($theme_changed_files)));
}
if ($plugin_files_changed) {
    log_message('Plugin files changed: ' . implode(', ', array_unique($plugin_changed_files)));
}

// ============================================================================
// ОБНОВЛЕНИЕ ТЕМЫ
// ============================================================================

$result = ['status' => 'success', 'method' => '', 'output' => []];

// ОТКЛЮЧЕН: Git pull копирует весь репозиторий, что не нужно
// Метод 1: Git pull - ОТКЛЮЧЕН для безопасности (не копировать весь репозиторий)
// Используем только GitHub API для загрузки только темы

// ============================================================================
// ОБНОВЛЕНИЕ ТЕМЫ И/ИЛИ ПЛАГИНА
// ============================================================================

$result = [
    'status' => 'success', 
    'method' => 'github_api',
    'theme' => ['updated' => false, 'files' => 0],
    'plugin' => ['updated' => false, 'files' => 0],
    'errors' => []
];

// Создаем временную папку
$temp_dir = sys_get_temp_dir() . '/gotry-deploy-' . time();
mkdir($temp_dir, 0755, true);

// URL для скачивания архива репозитория
$archive_url = 'https://github.com/' . GITHUB_REPO . '/archive/refs/heads/main.zip';
if (GITHUB_TOKEN) {
    $archive_url .= '?token=' . GITHUB_TOKEN;
}

// Скачиваем архив
$zip_file = $temp_dir . '/repo.zip';
$zip_content = @file_get_contents($archive_url);

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
    
    $extracted_root = $temp_dir . '/gotrydev-main';
    $exclude_files = ['.DS_Store', '.git', '.gitignore'];
    
    // Функция для копирования папки
    function copyDirectory($source, $dest, $exclude_files, $log_prefix) {
        if (!is_dir($source)) {
            return ['files' => 0, 'errors' => ["Source directory not found: $source"]];
        }
        
        if (!is_dir($dest)) {
            mkdir($dest, 0755, true);
        }
        
        $copied_files = [];
        $errors = [];
        
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $item) {
            $source_path = $item->getPathname();
            $relative_path = str_replace($source . DIRECTORY_SEPARATOR, '', $source_path);
            
            // Пропускаем исключенные файлы
            if (in_array(basename($relative_path), $exclude_files)) {
                continue;
            }
            
            $dest_path = $dest . DIRECTORY_SEPARATOR . $relative_path;
            
            if ($item->isDir()) {
                if (!is_dir($dest_path)) {
                    mkdir($dest_path, 0755, true);
                }
            } else {
                if (copy($source_path, $dest_path)) {
                    $copied_files[] = $relative_path;
                    chmod($dest_path, 0644);
                } else {
                    $errors[] = "Failed to copy: $relative_path";
                }
            }
        }
        
        return ['files' => $copied_files, 'errors' => $errors];
    }
    
    // Обновляем тему, если есть изменения
    if ($theme_files_changed) {
        $theme_source = $extracted_root . '/wp-content/themes/gotry';
        if (is_dir($theme_source)) {
            $theme_result = copyDirectory($theme_source, THEME_PATH, $exclude_files, 'Theme');
            $result['theme']['updated'] = true;
            $result['theme']['files'] = count($theme_result['files']);
            $result['theme']['file_list'] = $theme_result['files'];
            if (!empty($theme_result['errors'])) {
                $result['errors'] = array_merge($result['errors'], $theme_result['errors']);
            }
            log_message("Theme updated: {$result['theme']['files']} files copied");
        } else {
            log_message('Warning: Theme directory not found in archive');
            $result['errors'][] = 'Theme directory not found in archive';
        }
    }
    
    // Обновляем плагин, если есть изменения
    if ($plugin_files_changed) {
        $plugin_source = $extracted_root . '/wp-content/plugins/universal-license-manager';
        if (is_dir($plugin_source)) {
            $plugin_result = copyDirectory($plugin_source, PLUGIN_PATH, $exclude_files, 'Plugin');
            $result['plugin']['updated'] = true;
            $result['plugin']['files'] = count($plugin_result['files']);
            $result['plugin']['file_list'] = $plugin_result['files'];
            if (!empty($plugin_result['errors'])) {
                $result['errors'] = array_merge($result['errors'], $plugin_result['errors']);
            }
            log_message("Plugin updated: {$result['plugin']['files']} files copied");
        } else {
            log_message('Warning: Plugin directory not found in archive');
            $result['errors'][] = 'Plugin directory not found in archive';
        }
    }
    
    // Очищаем временные файлы
    exec('rm -rf ' . escapeshellarg($temp_dir));
} else {
    log_message('Error: Failed to extract ZIP archive');
    $result['error'] = 'Failed to extract ZIP archive';
    $result['status'] = 'error';
    @rmdir($temp_dir);
}

// Возвращаем результат
echo json_encode($result);
log_message('Webhook completed: ' . json_encode($result));
