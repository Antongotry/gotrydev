# Gotry WordPress Project

Репозиторий для темы Gotry и плагина Universal License Manager.

## Структура репозитория

```
gotrydev/
├── README.md
├── .gitignore
├── HOW-TO-COMMIT.md
├── themes/
│   └── gotry/              # Тема Gotry
│       ├── style.css
│       ├── functions.php
│       ├── header.php
│       ├── footer.php
│       ├── index.php
│       ├── front-page.php
│       ├── screenshot.png
│       ├── assets/
│       └── README.md
└── plugins/
    └── universal-license-manager/  # Плагин Universal License Manager
        ├── universal-license-manager.php
        ├── includes/
        ├── assets/
        └── README.md
```

**Важно:** В репозитории НЕТ папки `wp-content/`. Файлы темы и плагина находятся напрямую в `themes/` и `plugins/` в корне репозитория.

## Настройка развертывания на Hostinger

**Репозиторий:** `https://github.com/Antongotry/gotrydev`  
**Гілка:** `main`  
**Шлях встановлення:** `wp-content`

При развертывании на Hostinger в `wp-content`, файлы из репозитория попадут правильно:
- `themes/gotry/` → `wp-content/themes/gotry/` ✅
- `plugins/universal-license-manager/` → `wp-content/plugins/universal-license-manager/` ✅

## Обновление кода

### Обновление темы:
```bash
git add themes/gotry/
git commit -m "Update theme: описание изменений"
git push origin main
```

### Обновление плагина:
```bash
git add plugins/universal-license-manager/
git commit -m "Update plugin: описание изменений"
git push origin main
```

### Обновление обоих:
```bash
git add themes/ plugins/
git commit -m "Update theme and plugin: описание изменений"
git push origin main
```

## Webhook

Webhook настроен для автоматического обновления при push в GitHub:
- Проверяет какие папки изменились (тема или плагин)
- Обновляет только измененные папки на хостинге

Подробная инструкция: `HOW-TO-COMMIT.md`
