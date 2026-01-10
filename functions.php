<?php
/**
 * Gotry Theme Functions
 */

// Підключення стилів та скриптів
function gotry_enqueue_styles() {
    // Основні стилі теми
    wp_enqueue_style('gotry-style', get_stylesheet_uri(), array(), '3.0.0');
    
    // JavaScript для lens-effect (тільки на головній сторінці)
    if (is_front_page()) {
        wp_enqueue_script(
            'gotry-lens-effect',
            get_template_directory_uri() . '/assets/js/lens-effect.js',
            array(), // Залежності
            '3.0.0',
            true // В footer
        );
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

