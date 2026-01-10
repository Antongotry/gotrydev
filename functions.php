<?php
/**
 * Gotry Theme Functions
 */

// Підключення стилів та скриптів
function gotry_enqueue_styles() {
    // Версія теми для cache busting (змінюємо при оновленнях)
    $theme_version = '3.0.1';
    
    // Основні стилі теми
    wp_enqueue_style('gotry-style', get_stylesheet_uri(), array(), $theme_version);
    
    // JavaScript для lens-effect (тільки на головній сторінці)
    if (is_front_page()) {
        wp_enqueue_script(
            'gotry-lens-effect',
            get_template_directory_uri() . '/assets/js/lens-effect.js',
            array(), // Залежності
            $theme_version,
            true // В footer
        );
    }
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

