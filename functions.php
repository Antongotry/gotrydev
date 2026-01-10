<?php
/**
 * Gotry Theme Functions
 */

// Підключення стилів та скриптів
function gotry_enqueue_styles() {
    // Glass distortion стилі ТІЛЬКИ на головній (подключаем ПЕРВЫМИ)
    if (is_front_page()) {
        wp_enqueue_style('gotry-glass-distortion', 
            get_template_directory_uri() . '/assets/css/glass-distortion.css',
            array(), '2.0.1');
    }
    
    // Основні стилі теми (подключаем ПОСЛЕ glass-distortion)
    wp_enqueue_style('gotry-style', get_stylesheet_uri(), 
        is_front_page() ? array('gotry-glass-distortion') : array(), 
        '2.0.0');
    
    // Скрипты ТІЛЬКИ на головній
    if (is_front_page()) {
        // THREE.js library
        wp_enqueue_script('threejs', 
            'https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.min.js',
            array(), '0.160.0', false);
        
        // Glass distortion (без heartbeat)
        wp_enqueue_script('gotry-glass-three', 
            get_template_directory_uri() . '/assets/js/glass-distortion.js',
            array('threejs'), '2.0.1', true);
    }
}
add_action('wp_enqueue_scripts', 'gotry_enqueue_styles');

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

