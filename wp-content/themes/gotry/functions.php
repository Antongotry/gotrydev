<?php
/**
 * Gotry Theme Functions
 */

// Підключення стилів та скриптів
function gotry_enqueue_styles() {
    // Основні стилі теми
    wp_enqueue_style('gotry-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Glass distortion + Heartbeat ТІЛЬКИ на головній
    if (is_front_page()) {
        // Стилі
        wp_enqueue_style('gotry-glass-distortion', 
            get_template_directory_uri() . '/assets/css/glass-distortion.css',
            array(), '1.0.3');
        
        wp_enqueue_style('gotry-heartbeat', 
            get_template_directory_uri() . '/assets/css/heartbeat.css',
            array(), '1.0.0');
        
        // THREE.js library
        wp_enqueue_script('threejs', 
            'https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.min.js',
            array(), '0.160.0', false);
        
        // Heartbeat Controller (першим)
        wp_enqueue_script('gotry-heartbeat-controller', 
            get_template_directory_uri() . '/assets/js/heartbeat-controller.js',
            array(), '1.0.0', true);
        
        // ECG Line
        wp_enqueue_script('gotry-ecg-line', 
            get_template_directory_uri() . '/assets/js/ecg-line.js',
            array('gotry-heartbeat-controller'), '1.0.0', true);
        
        // Glass distortion з heartbeat
        wp_enqueue_script('gotry-glass-three', 
            get_template_directory_uri() . '/assets/js/glass-distortion.js',
            array('threejs', 'gotry-heartbeat-controller'), '1.0.3', true);
        
        // Main heartbeat init script
        wp_enqueue_script('gotry-heartbeat-init', 
            get_template_directory_uri() . '/assets/js/heartbeat-init.js',
            array('gotry-heartbeat-controller', 'gotry-ecg-line', 'gotry-glass-three'), '1.0.0', true);
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

