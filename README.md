# Gotry Theme

**Coming Soon сторінка з Heartbeat ефектом 💗**

## Опис

Кастомна WordPress тема для antongotry.dev з унікальним heartbeat ефектом на головній сторінці:
- 💓 Пульсація в ритмі серця (72 BPM)
- 📈 Біла ECG кардіограма по центру
- 🖼️ THREE.js glass distortion з вашим зображенням
- 🖱️ Інтерактивність - все реагує на мишу
- ⚡ Smooth 60fps анімації

## Структура

```
gotry/
├── style.css                          # Мета-інформація + базові стилі
├── functions.php                      # Підключення assets
├── header.php                         # Порожній header
├── footer.php                         # Порожній footer
├── front-page.php                     # Головна з canvas
├── index.php                          # Для інших сторінок
├── screenshot.png                     # Превью теми
├── assets/
│   ├── css/
│   │   ├── glass-distortion.css      # Canvas стилі
│   │   └── heartbeat.css             # Heartbeat стилі
│   └── js/
│       ├── glass-distortion.js       # THREE.js ефект
│       ├── heartbeat-controller.js   # Контролер heartbeat
│       └── ...
└── README.md                          # Документація
```

## Настройка развертывания на Hostinger

**Репозиторій:** `https://github.com/Antongotry/gotrydev`  
**Гілка:** `main`  
**Шлях встановлення:** `wp-content/themes/gotry`

При развертывании Hostinger скопирует файлы из корня репозитория в `wp-content/themes/gotry/`:
- `style.css` → `wp-content/themes/gotry/style.css` ✅
- `functions.php` → `wp-content/themes/gotry/functions.php` ✅
- `assets/` → `wp-content/themes/gotry/assets/` ✅

## Обновление темы

```bash
git add .
git commit -m "Update theme: описание изменений"
git push origin main
```

## Автор

**Anton Gotry**  
📧 Telegram: [@notarikon](https://t.me/notarikon)  
🌐 Website: [antongotry.dev](https://antongotry.dev)
