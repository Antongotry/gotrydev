# WordPress Project

WordPress проект с кастомной темой gotry.

## Настройка

### 1. Git конфигурация (если нужно изменить)
```bash
git config user.name "Ваше имя"
git config user.email "ваш@email.com"
```

### 2. Подключение к GitHub

Если у вас еще нет репозитория на GitHub:
1. Создайте новый репозиторий на GitHub
2. Выполните команды:
```bash
git remote add origin https://github.com/ВАШ_USERNAME/ВАШ_РЕПОЗИТОРИЙ.git
git push -u origin main
```

Если репозиторий уже существует:
```bash
git remote add origin https://github.com/ВАШ_USERNAME/ВАШ_РЕПОЗИТОРИЙ.git
git branch -M main
git push -u origin main
```

### 3. Настройка Webhook на GitHub

1. Перейдите в Settings → Webhooks вашего репозитория
2. Нажмите "Add webhook"
3. Payload URL: укажите URL вашего сервера для получения webhook
4. Content type: application/json
5. Выберите события: push, pull_request (или другие по необходимости)
6. Save webhook

## Структура проекта

- `wp-content/themes/gotry/` - кастомная тема
- `wp-content/plugins/` - плагины
- `.gitignore` - исключает чувствительные файлы (wp-config.php, uploads, cache и т.д.)

## Важно

⚠️ Файлы `wp-config.php`, `.htaccess`, `.private/` и `wp-content/uploads/` исключены из репозитория по соображениям безопасности.
