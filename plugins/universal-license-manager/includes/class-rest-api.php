<?php
/**
 * REST API endpoints
 * 
 * @package Universal_License_Manager
 * @author AntonGotry (@notarikon)
 */

if (!defined('ABSPATH')) {
    exit;
}

class ULM_REST_API {
    
    /**
     * Конструктор
     */
    public function __construct() {
        add_action('rest_api_init', array($this, 'register_routes'));
    }
    
    /**
     * Реєстрація маршрутів
     */
    public function register_routes() {
        register_rest_route('ulm/v1', '/verify', array(
            'methods' => 'POST',
            'callback' => array($this, 'verify_license'),
            'permission_callback' => '__return_true'
        ));
        
        register_rest_route('ulm/v1', '/activate', array(
            'methods' => 'POST',
            'callback' => array($this, 'activate_license'),
            'permission_callback' => '__return_true'
        ));
        
        register_rest_route('ulm/v1', '/deactivate', array(
            'methods' => 'POST',
            'callback' => array($this, 'deactivate_license'),
            'permission_callback' => '__return_true'
        ));
    }
    
    /**
     * Перевірка ліцензії
     */
    public function verify_license($request) {
        $product_slug = sanitize_text_field($request->get_param('product_slug'));
        $license_key = sanitize_text_field($request->get_param('license_key'));
        $domain = sanitize_text_field($request->get_param('domain'));
        
        // Логування запиту
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        
        // Валідація параметрів
        if (empty($product_slug) || empty($license_key) || empty($domain)) {
            ULM_Database::add_log(null, 'verify', $domain, $ip, 'failed', 'Missing parameters');
            return new WP_REST_Response(array(
                'valid' => false,
                'message' => 'Missing required parameters'
            ), 400);
        }
        
        // Отримати продукт
        $product = ULM_Database::get_product_by_slug($product_slug);
        if (!$product) {
            ULM_Database::add_log(null, 'verify', $domain, $ip, 'failed', 'Product not found');
            return new WP_REST_Response(array(
                'valid' => false,
                'message' => 'Product not found'
            ), 404);
        }
        
        // Отримати ліцензію
        $license = ULM_Database::get_license_by_key($license_key);
        if (!$license) {
            ULM_Database::add_log(null, 'verify', $domain, $ip, 'failed', 'License not found');
            return new WP_REST_Response(array(
                'valid' => false,
                'message' => 'Invalid license key'
            ), 404);
        }
        
        // Перевірити чи ліцензія належить продукту
        if ($license->product_id != $product->id) {
            ULM_Database::add_log($license->id, 'verify', $domain, $ip, 'failed', 'License not for this product');
            return new WP_REST_Response(array(
                'valid' => false,
                'message' => 'License not valid for this product'
            ), 403);
        }
        
        // Перевірити статус ліцензії
        if ($license->status !== 'active') {
            ULM_Database::add_log($license->id, 'verify', $domain, $ip, 'failed', 'License not active');
            return new WP_REST_Response(array(
                'valid' => false,
                'message' => 'License is not active'
            ), 403);
        }
        
        // Перевірити термін дії
        if ($license->expires_at && strtotime($license->expires_at) < time()) {
            ULM_Database::add_log($license->id, 'verify', $domain, $ip, 'failed', 'License expired');
            return new WP_REST_Response(array(
                'valid' => false,
                'message' => 'License has expired'
            ), 403);
        }
        
        // Перевірити чи домен активований
        $activations = ULM_Database::get_license_activations($license->id);
        $is_activated = false;
        
        foreach ($activations as $activation) {
            if ($activation->domain === $domain) {
                $is_activated = true;
                // Оновити час останньої перевірки
                global $wpdb;
                $table = $wpdb->prefix . 'ulm_activations';
                $wpdb->update($table, array('last_check' => current_time('mysql')), array('id' => $activation->id));
                break;
            }
        }
        
        if (!$is_activated) {
            ULM_Database::add_log($license->id, 'verify', $domain, $ip, 'failed', 'Domain not activated');
            return new WP_REST_Response(array(
                'valid' => false,
                'message' => 'Domain not activated for this license'
            ), 403);
        }
        
        // Успішна перевірка
        ULM_Database::add_log($license->id, 'verify', $domain, $ip, 'success', 'License verified');
        
        return new WP_REST_Response(array(
            'valid' => true,
            'message' => 'License is valid',
            'expires_at' => $license->expires_at,
            'activations_count' => $license->activations_count,
            'activations_limit' => $license->activations_limit
        ), 200);
    }
    
    /**
     * Активація ліцензії
     */
    public function activate_license($request) {
        $product_slug = sanitize_text_field($request->get_param('product_slug'));
        $license_key = sanitize_text_field($request->get_param('license_key'));
        $domain = sanitize_text_field($request->get_param('domain'));
        $email = sanitize_email($request->get_param('email'));
        $site_data = $request->get_param('site_data');
        
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        
        // Валідація параметрів
        if (empty($product_slug) || empty($license_key) || empty($domain) || empty($email)) {
            ULM_Database::add_log(null, 'activate', $domain, $ip, 'failed', 'Missing parameters');
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Missing required parameters'
            ), 400);
        }
        
        // Отримати продукт та ліцензію
        $product = ULM_Database::get_product_by_slug($product_slug);
        $license = ULM_Database::get_license_by_key($license_key);
        
        if (!$product || !$license || $license->product_id != $product->id) {
            ULM_Database::add_log($license ? $license->id : null, 'activate', $domain, $ip, 'failed', 'Invalid license');
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Invalid license key'
            ), 404);
        }
        
        // Перевірити статус ліцензії
        if ($license->status !== 'active') {
            ULM_Database::add_log($license->id, 'activate', $domain, $ip, 'failed', 'License not active');
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'License is not active'
            ), 403);
        }
        
        // Перевірити термін дії
        if ($license->expires_at && strtotime($license->expires_at) < time()) {
            ULM_Database::add_log($license->id, 'activate', $domain, $ip, 'failed', 'License expired');
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'License has expired'
            ), 403);
        }
        
        // Перевірити чи домен вже активований
        $activations = ULM_Database::get_license_activations($license->id);
        foreach ($activations as $activation) {
            if ($activation->domain === $domain) {
                ULM_Database::add_log($license->id, 'activate', $domain, $ip, 'success', 'Domain already activated');
                return new WP_REST_Response(array(
                    'success' => true,
                    'message' => 'Domain already activated'
                ), 200);
            }
        }
        
        // Перевірити ліміт активацій
        if ($license->activations_count >= $license->activations_limit) {
            ULM_Database::add_log($license->id, 'activate', $domain, $ip, 'failed', 'Activation limit reached');
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Activation limit reached'
            ), 403);
        }
        
        // Додати активацію
        $activation_result = ULM_Database::add_activation($license->id, $domain, $ip, $site_data);
        
        if ($activation_result) {
            // Оновити лічильник активацій
            ULM_Database::update_activations_count($license->id);
            
            ULM_Database::add_log($license->id, 'activate', $domain, $ip, 'success', 'Domain activated');
            
            return new WP_REST_Response(array(
                'success' => true,
                'message' => 'Domain activated successfully'
            ), 200);
        } else {
            ULM_Database::add_log($license->id, 'activate', $domain, $ip, 'failed', 'Database error');
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Activation failed'
            ), 500);
        }
    }
    
    /**
     * Деактивація ліцензії
     */
    public function deactivate_license($request) {
        $product_slug = sanitize_text_field($request->get_param('product_slug'));
        $license_key = sanitize_text_field($request->get_param('license_key'));
        $domain = sanitize_text_field($request->get_param('domain'));
        
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        
        // Валідація параметрів
        if (empty($product_slug) || empty($license_key) || empty($domain)) {
            ULM_Database::add_log(null, 'deactivate', $domain, $ip, 'failed', 'Missing parameters');
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Missing required parameters'
            ), 400);
        }
        
        // Отримати продукт та ліцензію
        $product = ULM_Database::get_product_by_slug($product_slug);
        $license = ULM_Database::get_license_by_key($license_key);
        
        if (!$product || !$license || $license->product_id != $product->id) {
            ULM_Database::add_log($license ? $license->id : null, 'deactivate', $domain, $ip, 'failed', 'Invalid license');
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Invalid license key'
            ), 404);
        }
        
        // Видалити активацію
        $result = ULM_Database::remove_activation($license->id, $domain);
        
        if ($result) {
            // Оновити лічильник активацій
            ULM_Database::update_activations_count($license->id);
            
            ULM_Database::add_log($license->id, 'deactivate', $domain, $ip, 'success', 'Domain deactivated');
            
            return new WP_REST_Response(array(
                'success' => true,
                'message' => 'Domain deactivated successfully'
            ), 200);
        } else {
            ULM_Database::add_log($license->id, 'deactivate', $domain, $ip, 'failed', 'Domain not found');
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Domain not found'
            ), 404);
        }
    }
}
