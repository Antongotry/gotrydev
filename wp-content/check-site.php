<?php
/**
 * Скрипт для проверки состояния сайта
 * Разместите на хостинге: public_html/wp-content/check-site.php
 * Откройте в браузере: https://antongotry.dev/wp-content/check-site.php
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Проверка сайта</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        h1 { color: #333; }
        .check { margin: 10px 0; padding: 10px; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .warning { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        pre { background: #f8f9fa; padding: 10px; border-radius: 4px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Проверка состояния сайта</h1>
        
        <?php
        $wp_root = dirname(dirname(__FILE__));
        $theme_path = $wp_root . '/wp-content/themes/gotry';
        
        // Проверка 1: wp-config.php
        echo '<div class="check ' . (file_exists($wp_root . '/wp-config.php') ? 'success' : 'error') . '">';
        echo '<strong>1. wp-config.php:</strong> ';
        if (file_exists($wp_root . '/wp-config.php')) {
            echo '✅ Найден';
            $config_size = filesize($wp_root . '/wp-config.php');
            echo " (размер: {$config_size} байт)";
        } else {
            echo '❌ НЕ НАЙДЕН! Это критическая проблема.';
        }
        echo '</div>';
        
        // Проверка 2: Папка темы
        echo '<div class="check ' . (is_dir($theme_path) ? 'success' : 'error') . '">';
        echo '<strong>2. Папка темы:</strong> ';
        if (is_dir($theme_path)) {
            echo '✅ Существует: ' . $theme_path;
        } else {
            echo '❌ НЕ СУЩЕСТВУЕТ: ' . $theme_path;
        }
        echo '</div>';
        
        // Проверка 3: Файлы темы
        if (is_dir($theme_path)) {
            echo '<div class="check info">';
            echo '<strong>3. Файлы темы:</strong><br>';
            $required_files = ['style.css', 'functions.php', 'index.php', 'front-page.php', 'header.php', 'footer.php'];
            foreach ($required_files as $file) {
                $file_path = $theme_path . '/' . $file;
                $exists = file_exists($file_path);
                echo ($exists ? '✅' : '❌') . ' ' . $file;
                if ($exists) {
                    $size = filesize($file_path);
                    echo " ({$size} байт)";
                }
                echo '<br>';
            }
            echo '</div>';
            
            // Проверка index.php темы
            $theme_index = $theme_path . '/index.php';
            if (file_exists($theme_index)) {
                $content = file_get_contents($theme_index);
                echo '<div class="check ' . (strpos($content, 'WP_USE_THEMES') !== false ? 'error' : 'success') . '">';
                echo '<strong>4. index.php темы:</strong> ';
                if (strpos($content, 'WP_USE_THEMES') !== false) {
                    echo '❌ ОШИБКА! Файл содержит WP_USE_THEMES - это корневой файл WordPress!';
                    echo '<br><small>Нужно заменить на правильный index.php темы.</small>';
                } else {
                    echo '✅ Правильный файл темы (без WP_USE_THEMES)';
                }
                echo '</div>';
            }
            
            // Проверка папки assets
            $assets_path = $theme_path . '/assets';
            echo '<div class="check ' . (is_dir($assets_path) ? 'success' : 'warning') . '">';
            echo '<strong>5. Папка assets:</strong> ';
            if (is_dir($assets_path)) {
                echo '✅ Существует';
                $css_dir = $assets_path . '/css';
                $js_dir = $assets_path . '/js';
                if (is_dir($css_dir)) {
                    $css_files = glob($css_dir . '/*.css');
                    echo ' (CSS файлов: ' . count($css_files) . ')';
                }
                if (is_dir($js_dir)) {
                    $js_files = glob($js_dir . '/*.js');
                    echo ' (JS файлов: ' . count($js_files) . ')';
                }
            } else {
                echo '⚠️ Не найдена';
            }
            echo '</div>';
        }
        
        // Проверка 6: Webhook скрипт
        $webhook_file = $wp_root . '/wp-content/webhook-theme-deploy.php';
        echo '<div class="check ' . (file_exists($webhook_file) ? 'success' : 'warning') . '">';
        echo '<strong>6. Webhook скрипт:</strong> ';
        if (file_exists($webhook_file)) {
            echo '✅ Найден';
        } else {
            echo '⚠️ Не найден (не критично, если не используете webhook)';
        }
        echo '</div>';
        
        // Проверка 7: Логи webhook
        $log_file = $wp_root . '/wp-content/webhook-theme-deploy.log';
        echo '<div class="check ' . (file_exists($log_file) ? 'info' : 'warning') . '">';
        echo '<strong>7. Логи webhook:</strong> ';
        if (file_exists($log_file)) {
            $log_size = filesize($log_file);
            echo '✅ Найден (размер: ' . $log_size . ' байт)';
            echo '<br><small>Последние 5 строк:</small><pre>';
            $lines = file($log_file);
            echo htmlspecialchars(implode('', array_slice($lines, -5)));
            echo '</pre>';
        } else {
            echo '⚠️ Не найден (webhook еще не запускался)';
        }
        echo '</div>';
        
        // Проверка 8: Права на файлы
        if (is_dir($theme_path)) {
            echo '<div class="check info">';
            echo '<strong>8. Права на папку темы:</strong> ';
            $perms = fileperms($theme_path);
            echo decoct($perms & 0777);
            echo '</div>';
        }
        
        // Проверка 9: PHP версия
        echo '<div class="check info">';
        echo '<strong>9. PHP версия:</strong> ' . PHP_VERSION;
        echo '</div>';
        
        // Проверка 10: Пути
        echo '<div class="check info">';
        echo '<strong>10. Пути:</strong><br>';
        echo 'WP Root: ' . $wp_root . '<br>';
        echo 'Theme Path: ' . $theme_path . '<br>';
        echo 'Current File: ' . __FILE__ . '<br>';
        echo '</div>';
        ?>
        
        <div class="check warning">
            <strong>⚠️ Важно:</strong> После проверки удалите этот файл для безопасности!
        </div>
    </div>
</body>
</html>
