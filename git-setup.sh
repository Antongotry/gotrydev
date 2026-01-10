#!/bin/bash
# Скрипт для подключения репозитория к GitHub

echo "=== Настройка Git репозитория для GitHub ==="
echo ""

# Проверка существования remote
if git remote get-url origin >/dev/null 2>&1; then
    echo "Remote 'origin' уже настроен:"
    git remote -v
    echo ""
    read -p "Хотите изменить? (y/n): " change_remote
    if [ "$change_remote" = "y" ]; then
        read -p "Введите URL GitHub репозитория: " repo_url
        git remote set-url origin "$repo_url"
        echo "Remote обновлен!"
    fi
else
    echo "Remote 'origin' не настроен."
    read -p "Введите URL GitHub репозитория (https://github.com/username/repo.git): " repo_url
    
    if [ -n "$repo_url" ]; then
        git remote add origin "$repo_url"
        echo "Remote добавлен: $repo_url"
    else
        echo "URL не введен. Пропускаем..."
        exit 1
    fi
fi

echo ""
echo "=== Проверка настроек Git ==="
echo "User name: $(git config user.name)"
echo "User email: $(git config user.email)"
echo ""
read -p "Изменить user.name и user.email? (y/n): " change_user

if [ "$change_user" = "y" ]; then
    read -p "Введите user.name: " user_name
    read -p "Введите user.email: " user_email
    git config user.name "$user_name"
    git config user.email "$user_email"
    echo "Настройки обновлены!"
fi

echo ""
echo "=== Текущий статус ==="
git status --short | head -10
echo ""

read -p "Запушить на GitHub? (y/n): " push_now
if [ "$push_now" = "y" ]; then
    echo "Pushing to GitHub..."
    git push -u origin main
    echo "Готово! Проверьте репозиторий на GitHub."
fi

echo ""
echo "=== Готово! ==="
