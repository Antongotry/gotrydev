# Развертывание только темы Gotry

## 🔥 Проблема: WordPress пытается установиться заново

**Причина:** При развертывании всего проекта через GitHub, Hostinger удаляет все файлы (включая `wp-config.php`), и WordPress не может подключиться к базе данных.

**Решение:** Настроить webhook для обновления **ТОЛЬКО** папки темы.

## ✅ Решение 1: Webhook для обновления только темы (РЕКОМЕНДУЕТСЯ)

### Шаг 1: Настройка на GitHub

1. Перейдите в **Settings → Webhooks** вашего репозитория
2. Нажмите **"Add webhook"**
3. Заполните:
   - **Payload URL:** `https://ваш-сайт.com/wp-content/webhook-receiver.php` (создадим ниже)
   - **Content type:** `application/json`
   - **Events:** Выберите **"Just the push event"**
   - **Active:** ✓

### Шаг 2: Создайте webhook receiver на хостинге

Создайте файл `wp-content/webhook-receiver.php` на хостинге:

```php
<?php
// webhook-receiver.php для обновления только темы
// Разместите в: public_html/wp-content/webhook-receiver.php

// Безопасность - проверка secret key
define('WEBHOOK_SECRET', 'ваш-секретный-ключ-здесь'); // Измените на случайный ключ

// Получаем данные от GitHub
$payload = file_get_contents('php://input');
$headers = getallheaders();

// Проверка secret (если настроен в GitHub)
if (isset($headers['X-Hub-Signature-256'])) {
    $signature = 'sha256=' . hash_hmac('sha256', $payload, WEBHOOK_SECRET);
    if (!hash_equals($signature, $headers['X-Hub-Signature-256'])) {
        http_response_code(401);
        die('Unauthorized');
    }
}

// Парсим данные от GitHub
$data = json_decode($payload, true);

// Проверяем, что это push event
if (!isset($data['ref']) || $data['ref'] !== 'refs/heads/main') {
    http_response_code(200);
    die('Not a push to main branch');
}

// Путь к папке темы
$theme_path = __DIR__ . '/themes/gotry';

// Список измененных файлов темы
$theme_files_changed = false;
foreach ($data['commits'] as $commit) {
    foreach ($commit['added'] as $file) {
        if (strpos($file, 'wp-content/themes/gotry/') === 0) {
            $theme_files_changed = true;
            break 2;
        }
    }
    foreach ($commit['modified'] as $file) {
        if (strpos($file, 'wp-content/themes/gotry/') === 0) {
            $theme_files_changed = true;
            break 2;
        }
    }
}

if (!$theme_files_changed) {
    http_response_code(200);
    die('No theme files changed');
}

// Выполняем git pull только для темы
exec('cd ' . escapeshellarg(__DIR__ . '/..') . ' && git pull origin main 2>&1', $output, $return_var);

// Возвращаем результат
http_response_code(200);
header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'message' => 'Theme updated',
    'output' => implode("\n", $output)
]);
```

### Шаг 3: Альтернатива - PHP скрипт для клонирования только темы

Если у вас нет доступа к git на хостинге, создайте `wp-content/update-theme.php`:

```php
<?php
// update-theme.php - обновление темы из GitHub
// Запускайте вручную через браузер: https://ваш-сайт.com/wp-content/update-theme.php

// Безопасность - добавьте проверку доступа
// define('UPDATE_SECRET', 'ваш-секретный-ключ');
// if (!isset($_GET['secret']) || $_GET['secret'] !== UPDATE_SECRET) {
//     die('Unauthorized');
// }

$theme_path = __DIR__ . '/themes/gotry';
$repo_url = 'https://github.com/Antongotry/gotrydev.git';
$temp_path = sys_get_temp_dir() . '/gotry-theme-' . time();

// Создаем временную папку
mkdir($temp_path, 0755, true);

// Клонируем только папку темы (используя sparse checkout)
exec("cd $temp_path && git clone --filter=blob:none --sparse $repo_url . 2>&1", $output, $return);
exec("cd $temp_path && git sparse-checkout init --cone 2>&1");
exec("cd $temp_path && git sparse-checkout set wp-content/themes/gotry 2>&1");

// Копируем файлы темы
if (is_dir("$temp_path/wp-content/themes/gotry")) {
    exec("cp -r $temp_path/wp-content/themes/gotry/* $theme_path/ 2>&1", $output2);
    echo "Theme updated!<br>";
    echo "<pre>" . implode("\n", array_merge($output, $output2)) . "</pre>";
} else {
    echo "Error: Theme folder not found";
}

// Удаляем временную папку
exec("rm -rf $temp_path");
```

## ✅ Решение 2: Обновление только темы вручную (ПРОСТОЕ)

### Через File Manager на Hostinger:

1. Зайдите в **File Manager** на Hostinger
2. Перейдите в `public_html/wp-content/themes/gotry`
3. Загрузите обновленные файлы темы вручную
4. Или используйте FTP клиент (FileZilla и т.д.)

### Через Git (если есть SSH доступ):

```bash
# Подключитесь к серверу через SSH
ssh ваш-юзер@antongotry.dev

# Перейдите в папку сайта
cd public_html

# Обновите только папку темы
cd wp-content/themes/gotry
git pull origin main

# Или скопируйте из репозитория
rm -rf /tmp/gotry-theme
git clone https://github.com/Antongotry/gotrydev.git /tmp/gotry-theme
cp -r /tmp/gotry-theme/wp-content/themes/gotry/* .
rm -rf /tmp/gotry-theme
```

## ✅ Решение 3: Использовать GitHub Actions для автоматического деплоя

Создайте `.github/workflows/deploy-theme.yml`:

```yaml
name: Deploy Theme Only

on:
  push:
    branches: [ main ]
    paths:
      - 'wp-content/themes/gotry/**'

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Deploy to Hostinger
        uses: SamKirkland/FTP-Deploy-Action@4.3.0
        with:
          server: ftp.antongotry.dev
          username: ${{ secrets.FTP_USERNAME }}
          password: ${{ secrets.FTP_PASSWORD }}
          local-dir: ./wp-content/themes/gotry/
          server-dir: /public_html/wp-content/themes/gotry/
```

## 🚨 Важно! Решение проблемы с установщиком WordPress

Если WordPress все равно пытается установиться:

1. **Проверьте наличие `wp-config.php` на хостинге:**
   - Должен быть в `public_html/wp-config.php`
   - Проверьте права: `chmod 644 wp-config.php`

2. **Проверьте настройки базы данных в `wp-config.php`:**
   ```php
   define('DB_NAME', 'имя_базы_данных');
   define('DB_USER', 'пользователь_бд');
   define('DB_PASSWORD', 'пароль_бд');
   define('DB_HOST', 'localhost');
   ```

3. **Проверьте, что база данных существует и таблицы созданы**

4. **Не используйте развертывание всего проекта через Hostinger Git!**
   - Это удалит `wp-config.php` и другие важные файлы
   - Используйте только ручную загрузку темы или webhook для темы

## 📝 Рекомендация

**Лучший вариант:** Обновляйте тему вручную через File Manager или FTP, когда нужно внести изменения. Это безопаснее и проще.

Для автоматизации используйте **Решение 1** (webhook) или **Решение 3** (GitHub Actions).
