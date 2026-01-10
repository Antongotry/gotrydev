<?php
/**
 * Plugin Name: Universal License Manager
 * Plugin URI: https://t.me/notarikon
 * Description: Універсальна система ліцензування для всіх плагінів
 * Version: 1.0.1
 * Author: AntonGotry
 * Author URI: https://t.me/notarikon
 * Text Domain: universal-license-manager
 * License: GPL v2 or later
 */

if (!defined('ABSPATH')) {
    exit;
}

// Константи плагіну
define('ULM_VERSION', '1.0.1'); // Обновлено: тестовая версия для коммита
define('ULM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ULM_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Головний клас плагіну
 */
class Universal_License_Manager {
    
    /**
     * Конструктор
     */
    public function __construct() {
        add_action('init', array($this, 'init'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    /**
     * Ініціалізація
     */
    public function init() {
        // Підключаємо файли
        if (file_exists(ULM_PLUGIN_DIR . 'includes/class-database.php')) {
            require_once ULM_PLUGIN_DIR . 'includes/class-database.php';
        }
        if (file_exists(ULM_PLUGIN_DIR . 'includes/class-rest-api.php')) {
            require_once ULM_PLUGIN_DIR . 'includes/class-rest-api.php';
        }
        if (file_exists(ULM_PLUGIN_DIR . 'includes/class-admin-menu.php')) {
            require_once ULM_PLUGIN_DIR . 'includes/class-admin-menu.php';
        }
        if (file_exists(ULM_PLUGIN_DIR . 'includes/class-license-generator.php')) {
            require_once ULM_PLUGIN_DIR . 'includes/class-license-generator.php';
        }
        
        // Ініціалізуємо компоненти
        if (is_admin() && class_exists('ULM_Admin_Menu')) {
            new ULM_Admin_Menu();
        }
        
        if (class_exists('ULM_REST_API')) {
            new ULM_REST_API();
        }
    }
    
    /**
     * Активація плагіна
     */
    public function activate() {
        // Підключаємо файл БД для активації
        if (file_exists(ULM_PLUGIN_DIR . 'includes/class-database.php')) {
            require_once ULM_PLUGIN_DIR . 'includes/class-database.php';
            
            if (class_exists('ULM_Database')) {
                try {
                    ULM_Database::create_tables();
                    ULM_Database::add_default_product();
                } catch (Exception $e) {
                    error_log('ULM Activation Error: ' . $e->getMessage());
                }
            }
        }
        
        flush_rewrite_rules();
    }
    
    /**
     * Деактивація плагіна
     */
    public function deactivate() {
        flush_rewrite_rules();
    }
}

// Ініціалізація плагіну
new Universal_License_Manager();
