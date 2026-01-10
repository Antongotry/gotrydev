<?php
/**
 * Gotry Theme Functions
 */

// Підключення стилів та скриптів
function gotry_enqueue_styles() {
    // Автоматичне версіонування через filemtime для cache busting
    $style_version = file_exists(get_stylesheet_directory() . '/style.css') 
        ? filemtime(get_stylesheet_directory() . '/style.css') 
        : '3.1.0';
    
    // Google Fonts - Manrope (отличная кириллица для креативной студии)
    wp_enqueue_style(
        'google-fonts-manrope',
        'https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap',
        array(),
        null
    );
    
    // Lenis CSS для smooth scroll
    wp_enqueue_style(
        'lenis-css',
        'https://cdn.jsdelivr.net/npm/lenis@1.2.3/dist/lenis.css',
        array(),
        '1.2.3'
    );
    
    // Основні стилі теми
    wp_enqueue_style(
        'gotry-style',
        get_stylesheet_uri(),
        array('google-fonts-manrope', 'lenis-css'),
        $style_version
    );
    
    // Lenis smooth scroll library (потрібен для всіх сторінок)
    wp_enqueue_script(
        'lenis',
        'https://cdn.jsdelivr.net/npm/lenis@1.2.3/dist/lenis.min.js',
        array(),
        '1.2.3',
        true
    );
    
    // Main JS для Lenis ініціалізації (для всіх сторінок)
    $main_js_version = file_exists(get_stylesheet_directory() . '/assets/js/main.js')
        ? filemtime(get_stylesheet_directory() . '/assets/js/main.js')
        : '3.1.0';
    
    wp_enqueue_script(
        'gotry-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array('lenis'),
        $main_js_version,
        true
    );
    
    // Page Loader JS - только для главной страницы
    if (is_front_page()) {
        $loader_js_version = file_exists(get_stylesheet_directory() . '/assets/js/page-loader.js')
            ? filemtime(get_stylesheet_directory() . '/assets/js/page-loader.js')
            : '1.0.0';
        
        wp_enqueue_script(
            'gotry-page-loader',
            get_template_directory_uri() . '/assets/js/page-loader.js',
            array(),
            $loader_js_version,
            false // Загружаем в header для раннего запуска
        );
    }
    
    // Lens-effect прибрано для оптимізації
}
add_action('wp_enqueue_scripts', 'gotry_enqueue_styles');

// Очищення кешу при збереженні теми
function gotry_clear_cache() {
    // Спроба очистити різні типи кешу
    if (function_exists('wp_cache_flush')) {
        wp_cache_flush();
    }
    if (function_exists('w3tc_flush_all')) {
        w3tc_flush_all();
    }
    if (function_exists('wp_super_cache_flush')) {
        wp_super_cache_flush();
    }
}
add_action('after_switch_theme', 'gotry_clear_cache');

// Підтримка основних WordPress функцій
function gotry_setup() {
    // Title tag
    add_theme_support('title-tag');
    
    // HTML5 підтримка
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    // Post thumbnails
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'gotry_setup');

// Прибрати admin bar на головній для чистого вигляду
add_filter('show_admin_bar', function($show) {
    if (is_front_page() && !is_admin()) {
        return false;
    }
    return $show;
});

