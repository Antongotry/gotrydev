<?php
/**
 * Database management class
 * 
 * @package Universal_License_Manager
 * @author AntonGotry (@notarikon)
 */

if (!defined('ABSPATH')) {
    exit;
}

class ULM_Database {
    
    /**
     * Створити таблиці БД
     */
    public static function create_tables() {
        global $wpdb;
        
        // Перевірка чи WordPress завантажений
        if (!function_exists('dbDelta')) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        }
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // Таблиця продуктів
        $table_products = $wpdb->prefix . 'ulm_products';
        $sql_products = "CREATE TABLE $table_products (
            id int(11) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            slug varchar(100) NOT NULL UNIQUE,
            version varchar(20) DEFAULT '1.0.0',
            price decimal(10,2) DEFAULT 0.00,
            description text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        // Таблиця ліцензій
        $table_licenses = $wpdb->prefix . 'ulm_licenses';
        $sql_licenses = "CREATE TABLE $table_licenses (
            id int(11) NOT NULL AUTO_INCREMENT,
            product_id int(11) NOT NULL,
            license_key varchar(64) NOT NULL UNIQUE,
            customer_email varchar(255) NOT NULL,
            customer_name varchar(255) NOT NULL,
            status enum('active', 'inactive', 'expired', 'blocked') DEFAULT 'active',
            activations_limit int(11) DEFAULT 1,
            activations_count int(11) DEFAULT 0,
            expires_at datetime NULL,
            notes text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY product_id (product_id),
            FOREIGN KEY (product_id) REFERENCES $table_products(id) ON DELETE CASCADE
        ) $charset_collate;";
        
        // Таблиця активацій
        $table_activations = $wpdb->prefix . 'ulm_activations';
        $sql_activations = "CREATE TABLE $table_activations (
            id int(11) NOT NULL AUTO_INCREMENT,
            license_id int(11) NOT NULL,
            domain varchar(255) NOT NULL,
            ip varchar(45) NOT NULL,
            activated_at datetime DEFAULT CURRENT_TIMESTAMP,
            last_check datetime DEFAULT CURRENT_TIMESTAMP,
            site_data json,
            PRIMARY KEY (id),
            KEY license_id (license_id),
            KEY domain (domain),
            FOREIGN KEY (license_id) REFERENCES $table_licenses(id) ON DELETE CASCADE
        ) $charset_collate;";
        
        // Таблиця логів
        $table_logs = $wpdb->prefix . 'ulm_logs';
        $sql_logs = "CREATE TABLE $table_logs (
            id int(11) NOT NULL AUTO_INCREMENT,
            license_id int(11) NULL,
            action varchar(50) NOT NULL,
            domain varchar(255) NOT NULL,
            ip varchar(45) NOT NULL,
            response varchar(20) NOT NULL,
            message text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY license_id (license_id),
            KEY action (action),
            KEY domain (domain),
            FOREIGN KEY (license_id) REFERENCES $table_licenses(id) ON DELETE SET NULL
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        
        $result1 = dbDelta($sql_products);
        $result2 = dbDelta($sql_licenses);
        $result3 = dbDelta($sql_activations);
        $result4 = dbDelta($sql_logs);
        
        // Логування результатів
        error_log('ULM Tables created: ' . print_r(array($result1, $result2, $result3, $result4), true));
    }
    
    /**
     * Додати дефолтний продукт GMC
     */
    public static function add_default_product() {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ulm_products';
        
        // Перевірити чи вже існує
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table WHERE slug = %s",
            'gmc'
        ));
        
        if (!$exists) {
            $wpdb->insert($table, array(
                'name' => 'Green Mop Calculator',
                'slug' => 'gmc',
                'version' => '2.0.0',
                'price' => 0.00,
                'description' => 'Інтерактивний калькулятор вартості послуг прибирання та хімчистки'
            ));
        }
    }
    
    /**
     * Отримати всі продукти
     */
    public static function get_products() {
        global $wpdb;
        $table = $wpdb->prefix . 'ulm_products';
        
        return $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC");
    }
    
    /**
     * Отримати продукт по slug
     */
    public static function get_product_by_slug($slug) {
        global $wpdb;
        $table = $wpdb->prefix . 'ulm_products';
        
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table WHERE slug = %s",
            $slug
        ));
    }
    
    /**
     * Отримати всі ліцензії
     */
    public static function get_licenses() {
        global $wpdb;
        $table_licenses = $wpdb->prefix . 'ulm_licenses';
        $table_products = $wpdb->prefix . 'ulm_products';
        
        return $wpdb->get_results("
            SELECT l.*, p.name as product_name, p.slug as product_slug 
            FROM $table_licenses l 
            LEFT JOIN $table_products p ON l.product_id = p.id 
            ORDER BY l.created_at DESC
        ");
    }
    
    /**
     * Отримати ліцензію по ключу
     */
    public static function get_license_by_key($license_key) {
        global $wpdb;
        $table_licenses = $wpdb->prefix . 'ulm_licenses';
        $table_products = $wpdb->prefix . 'ulm_products';
        
        return $wpdb->get_row($wpdb->prepare("
            SELECT l.*, p.name as product_name, p.slug as product_slug 
            FROM $table_licenses l 
            LEFT JOIN $table_products p ON l.product_id = p.id 
            WHERE l.license_key = %s
        ", $license_key));
    }
    
    /**
     * Отримати активації ліцензії
     */
    public static function get_license_activations($license_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'ulm_activations';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table WHERE license_id = %d ORDER BY activated_at DESC",
            $license_id
        ));
    }
    
    /**
     * Отримати всі активації
     */
    public static function get_all_activations() {
        global $wpdb;
        $table_activations = $wpdb->prefix . 'ulm_activations';
        $table_licenses = $wpdb->prefix . 'ulm_licenses';
        $table_products = $wpdb->prefix . 'ulm_products';
        
        return $wpdb->get_results("
            SELECT a.*, l.license_key, p.name as product_name 
            FROM $table_activations a 
            LEFT JOIN $table_licenses l ON a.license_id = l.id 
            LEFT JOIN $table_products p ON l.product_id = p.id 
            ORDER BY a.activated_at DESC
        ");
    }
    
    /**
     * Отримати логи
     */
    public static function get_logs($limit = 100) {
        global $wpdb;
        $table_logs = $wpdb->prefix . 'ulm_logs';
        $table_licenses = $wpdb->prefix . 'ulm_licenses';
        $table_products = $wpdb->prefix . 'ulm_products';
        
        return $wpdb->get_results($wpdb->prepare("
            SELECT log.*, l.license_key, p.name as product_name 
            FROM $table_logs log 
            LEFT JOIN $table_licenses l ON log.license_id = l.id 
            LEFT JOIN $table_products p ON l.product_id = p.id 
            ORDER BY log.created_at DESC 
            LIMIT %d
        ", $limit));
    }
    
    /**
     * Створити ліцензію
     */
    public static function create_license($data) {
        global $wpdb;
        $table = $wpdb->prefix . 'ulm_licenses';
        
        return $wpdb->insert($table, array(
            'product_id' => $data['product_id'],
            'license_key' => $data['license_key'],
            'customer_email' => $data['customer_email'],
            'customer_name' => $data['customer_name'],
            'status' => $data['status'] ?? 'active',
            'activations_limit' => $data['activations_limit'] ?? 1,
            'expires_at' => $data['expires_at'] ?? null,
            'notes' => $data['notes'] ?? ''
        ));
    }
    
    /**
     * Оновити ліцензію
     */
    public static function update_license($id, $data) {
        global $wpdb;
        $table = $wpdb->prefix . 'ulm_licenses';
        
        return $wpdb->update($table, $data, array('id' => $id));
    }
    
    /**
     * Видалити ліцензію
     */
    public static function delete_license($id) {
        global $wpdb;
        $table = $wpdb->prefix . 'ulm_licenses';
        
        return $wpdb->delete($table, array('id' => $id));
    }
    
    /**
     * Додати активацію
     */
    public static function add_activation($license_id, $domain, $ip, $site_data = null) {
        global $wpdb;
        $table = $wpdb->prefix . 'ulm_activations';
        
        return $wpdb->insert($table, array(
            'license_id' => $license_id,
            'domain' => $domain,
            'ip' => $ip,
            'site_data' => $site_data ? json_encode($site_data) : null
        ));
    }
    
    /**
     * Видалити активацію
     */
    public static function remove_activation($license_id, $domain) {
        global $wpdb;
        $table = $wpdb->prefix . 'ulm_activations';
        
        return $wpdb->delete($table, array(
            'license_id' => $license_id,
            'domain' => $domain
        ));
    }
    
    /**
     * Оновити лічильник активацій
     */
    public static function update_activations_count($license_id) {
        global $wpdb;
        $table_licenses = $wpdb->prefix . 'ulm_licenses';
        $table_activations = $wpdb->prefix . 'ulm_activations';
        
        $count = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table_activations WHERE license_id = %d",
            $license_id
        ));
        
        $wpdb->update($table_licenses, array('activations_count' => $count), array('id' => $license_id));
        
        return $count;
    }
    
    /**
     * Додати лог
     */
    public static function add_log($license_id, $action, $domain, $ip, $response, $message = '') {
        global $wpdb;
        $table = $wpdb->prefix . 'ulm_logs';
        
        return $wpdb->insert($table, array(
            'license_id' => $license_id,
            'action' => $action,
            'domain' => $domain,
            'ip' => $ip,
            'response' => $response,
            'message' => $message
        ));
    }
}
