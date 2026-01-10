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

// Путь к git репозиторию (если используется git на сервере)
// Если нет git на сервере, оставьте null и будет использован метод загрузки через GitHub API
define('GIT_PATH', WP_ROOT);

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

// Метод 1: Используем git (если доступен на сервере)
if (GIT_PATH && is_dir(GIT_PATH . '/.git')) {
    log_message('Attempting to update via git pull');
    $result['method'] = 'git';
    
    // Переходим в корень репозитория
    chdir(GIT_PATH);
    
    // Выполняем git pull только для папки темы (если поддерживается sparse checkout)
    // Или просто git pull, если вся папка является репозиторием
    exec('git pull origin main 2>&1', $output, $return_code);
    $result['output'] = $output;
    $result['return_code'] = $return_code;
    
    if ($return_code === 0) {
        log_message('Success: Theme updated via git pull');
        echo json_encode($result);
        exit;
    } else {
        log_message('Warning: Git pull failed, trying alternative method');
    }
}

// Метод 2: Загрузка через GitHub API (fallback)
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
        // Удаляем старую папку темы (кроме uploads, если есть)
        if (is_dir(THEME_PATH)) {
            // Копируем только файлы темы
            exec('cp -r ' . escapeshellarg($extracted_path) . '/* ' . escapeshellarg(THEME_PATH) . '/ 2>&1', $output, $return_code);
            $result['output'] = $output;
            $result['return_code'] = $return_code;
            
            if ($return_code === 0) {
                log_message('Success: Theme updated via GitHub API');
            } else {
                log_message('Error: Failed to copy theme files');
            }
        } else {
            log_message('Error: Theme directory does not exist: ' . THEME_PATH);
            $result['error'] = 'Theme directory does not exist';
        }
    } else {
        log_message('Error: Extracted theme directory not found');
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
