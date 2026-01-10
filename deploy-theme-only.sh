#!/bin/bash
# Скрипт для развертывания только темы gotry
# Используется для webhook на Hostinger

echo "=== Развертывание только темы Gotry ==="

# Путь к папке темы на сервере
THEME_PATH="wp-content/themes/gotry"

# Проверка существования папки темы
if [ ! -d "$THEME_PATH" ]; then
    echo "Создание папки темы: $THEME_PATH"
    mkdir -p "$THEME_PATH"
fi

# Копирование файлов темы из репозитория
echo "Обновление файлов темы..."

# Список файлов темы для копирования
FILES_TO_COPY=(
    "style.css"
    "functions.php"
    "header.php"
    "footer.php"
    "front-page.php"
    "index.php"
    "screenshot.png"
    "README.md"
    "USAGE.md"
)

# Копирование файлов
for file in "${FILES_TO_COPY[@]}"; do
    if [ -f "wp-content/themes/gotry/$file" ]; then
        cp "wp-content/themes/gotry/$file" "$THEME_PATH/$file"
        echo "✓ Обновлен: $file"
    fi
done

# Копирование папки assets
if [ -d "wp-content/themes/gotry/assets" ]; then
    echo "Копирование папки assets..."
    cp -r wp-content/themes/gotry/assets/* "$THEME_PATH/assets/" 2>/dev/null || true
    echo "✓ Обновлена папка assets"
fi

echo ""
echo "=== Готово! Тема обновлена ==="
echo "Проверьте сайт: https://antongotry.dev"
