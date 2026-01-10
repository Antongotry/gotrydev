<?php
/**
 * Admin menu and pages
 * 
 * @package Universal_License_Manager
 * @author AntonGotry (@notarikon)
 */

if (!defined('ABSPATH')) {
    exit;
}

class ULM_Admin_Menu {
    
    /**
     * Конструктор
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_ulm_create_product', array($this, 'ajax_create_product'));
        add_action('wp_ajax_ulm_create_license', array($this, 'ajax_create_license'));
        add_action('wp_ajax_ulm_update_license', array($this, 'ajax_update_license'));
        add_action('wp_ajax_ulm_delete_license', array($this, 'ajax_delete_license'));
        add_action('wp_ajax_ulm_toggle_license_status', array($this, 'ajax_toggle_license_status'));
    }
    
    /**
     * Додати меню в адміністраторській панелі
     */
    public function add_admin_menu() {
        add_menu_page(
            'License Manager',
            'License Manager',
            'manage_options',
            'ulm-dashboard',
            array($this, 'dashboard_page'),
            'dashicons-admin-network',
            30
        );
        
        add_submenu_page(
            'ulm-dashboard',
            'Products',
            'Products',
            'manage_options',
            'ulm-products',
            array($this, 'products_page')
        );
        
        add_submenu_page(
            'ulm-dashboard',
            'Licenses',
            'Licenses',
            'manage_options',
            'ulm-licenses',
            array($this, 'licenses_page')
        );
        
        add_submenu_page(
            'ulm-dashboard',
            'Activations',
            'Activations',
            'manage_options',
            'ulm-activations',
            array($this, 'activations_page')
        );
        
        add_submenu_page(
            'ulm-dashboard',
            'Logs',
            'Logs',
            'manage_options',
            'ulm-logs',
            array($this, 'logs_page')
        );
    }
    
    /**
     * Підключення скриптів та стилів
     */
    public function enqueue_scripts($hook) {
        if (strpos($hook, 'ulm-') === false) {
            return;
        }
        
        wp_enqueue_style('ulm-admin', ULM_PLUGIN_URL . 'assets/css/admin.css', array(), ULM_VERSION);
        wp_enqueue_script('ulm-admin', ULM_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), ULM_VERSION, true);
        
        wp_localize_script('ulm-admin', 'ulm_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => function_exists('wp_create_nonce') ? wp_create_nonce('ulm_nonce') : ''
        ));
    }
    
    /**
     * Dashboard сторінка
     */
    public function dashboard_page() {
        $products_count = count(ULM_Database::get_products());
        $licenses_count = count(ULM_Database::get_licenses());
        $activations_count = count(ULM_Database::get_all_activations());
        $logs_count = count(ULM_Database::get_logs(10));
        
        ?>
        <div class="wrap">
            <h1>License Manager Dashboard</h1>
            
            <div class="ulm-dashboard-stats">
                <div class="ulm-stat-box">
                    <h3>Products</h3>
                    <div class="ulm-stat-number"><?php echo $products_count; ?></div>
                </div>
                
                <div class="ulm-stat-box">
                    <h3>Licenses</h3>
                    <div class="ulm-stat-number"><?php echo $licenses_count; ?></div>
                </div>
                
                <div class="ulm-stat-box">
                    <h3>Active Domains</h3>
                    <div class="ulm-stat-number"><?php echo $activations_count; ?></div>
                </div>
                
                <div class="ulm-stat-box">
                    <h3>Recent Logs</h3>
                    <div class="ulm-stat-number"><?php echo $logs_count; ?></div>
                </div>
            </div>
            
            <div class="ulm-dashboard-content">
                <div class="ulm-dashboard-section">
                    <h2>Recent Activity</h2>
                    <?php $this->render_recent_logs(); ?>
                </div>
                
                <div class="ulm-dashboard-section">
                    <h2>Quick Actions</h2>
                    <p>
                        <a href="<?php echo admin_url('admin.php?page=ulm-products'); ?>" class="button button-primary">Manage Products</a>
                        <a href="<?php echo admin_url('admin.php?page=ulm-licenses'); ?>" class="button">Manage Licenses</a>
                        <a href="<?php echo admin_url('admin.php?page=ulm-activations'); ?>" class="button">View Activations</a>
                    </p>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Products сторінка
     */
    public function products_page() {
        $products = ULM_Database::get_products();
        
        ?>
        <div class="wrap">
            <h1>Products 
                <button type="button" class="button button-primary" id="ulm-add-product-btn">Add Product</button>
            </h1>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Version</th>
                        <th>Price</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><strong><?php echo esc_html($product->name); ?></strong></td>
                            <td><code><?php echo esc_html($product->slug); ?></code></td>
                            <td><?php echo esc_html($product->version); ?></td>
                            <td>$<?php echo number_format($product->price, 2); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($product->created_at)); ?></td>
                            <td>
                                <button type="button" class="button button-small ulm-edit-product" data-id="<?php echo $product->id; ?>">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Add Product Modal -->
        <div id="ulm-add-product-modal" class="ulm-modal" style="display: none;">
            <div class="ulm-modal-content">
                <div class="ulm-modal-header">
                    <h2>Add Product</h2>
                    <span class="ulm-modal-close">&times;</span>
                </div>
                <div class="ulm-modal-body">
                    <form id="ulm-add-product-form">
                        <table class="form-table">
                            <tr>
                                <th><label for="product_name">Name:</label></th>
                                <td><input type="text" name="name" id="product_name" class="regular-text" required></td>
                            </tr>
                            <tr>
                                <th><label for="product_slug">Slug:</label></th>
                                <td><input type="text" name="slug" id="product_slug" class="regular-text" required></td>
                            </tr>
                            <tr>
                                <th><label for="product_version">Version:</label></th>
                                <td><input type="text" name="version" id="product_version" class="regular-text" value="1.0.0"></td>
                            </tr>
                            <tr>
                                <th><label for="product_price">Price:</label></th>
                                <td><input type="number" name="price" id="product_price" class="regular-text" step="0.01" value="0.00"></td>
                            </tr>
                            <tr>
                                <th><label for="product_description">Description:</label></th>
                                <td><textarea name="description" id="product_description" class="large-text" rows="3"></textarea></td>
                            </tr>
                        </table>
                        <p class="submit">
                            <button type="submit" class="button button-primary">Add Product</button>
                            <button type="button" class="button ulm-modal-close">Cancel</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Licenses сторінка
     */
    public function licenses_page() {
        $licenses = ULM_Database::get_licenses();
        
        ?>
        <div class="wrap">
            <h1>Licenses 
                <button type="button" class="button button-primary" id="ulm-generate-license-btn">Generate License</button>
            </h1>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>License Key</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Activations</th>
                        <th>Expires</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($licenses as $license): ?>
                        <tr>
                            <td><code><?php echo esc_html(substr($license->license_key, 0, 12) . '...'); ?></code></td>
                            <td><?php echo esc_html($license->product_name); ?></td>
                            <td>
                                <?php echo esc_html($license->customer_name); ?><br>
                                <small><?php echo esc_html($license->customer_email); ?></small>
                            </td>
                            <td>
                                <span class="ulm-status ulm-status-<?php echo $license->status; ?>">
                                    <?php echo ucfirst($license->status); ?>
                                </span>
                            </td>
                            <td><?php echo $license->activations_count . '/' . $license->activations_limit; ?></td>
                            <td><?php echo $license->expires_at ? date('Y-m-d', strtotime($license->expires_at)) : 'Never'; ?></td>
                            <td>
                                <button type="button" class="button button-small ulm-edit-license" data-id="<?php echo $license->id; ?>">Edit</button>
                                <button type="button" class="button button-small ulm-toggle-license" data-id="<?php echo $license->id; ?>" data-status="<?php echo $license->status; ?>">
                                    <?php echo $license->status === 'active' ? 'Block' : 'Activate'; ?>
                                </button>
                                <button type="button" class="button button-small ulm-copy-license" data-key="<?php echo esc_attr($license->license_key); ?>">Copy</button>
                                <button type="button" class="button button-small button-link-delete ulm-delete-license" data-id="<?php echo $license->id; ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Generate License Modal -->
        <div id="ulm-generate-license-modal" class="ulm-modal" style="display: none;">
            <div class="ulm-modal-content">
                <div class="ulm-modal-header">
                    <h2>Generate License</h2>
                    <span class="ulm-modal-close">&times;</span>
                </div>
                <div class="ulm-modal-body">
                    <form id="ulm-generate-license-form">
                        <table class="form-table">
                            <tr>
                                <th><label for="license_product">Product:</label></th>
                                <td>
                                    <select name="product_id" id="license_product" class="regular-text" required>
                                        <option value="">Select Product</option>
                                        <?php foreach (ULM_Database::get_products() as $product): ?>
                                            <option value="<?php echo $product->id; ?>"><?php echo esc_html($product->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="license_email">Email:</label></th>
                                <td><input type="email" name="customer_email" id="license_email" class="regular-text" required></td>
                            </tr>
                            <tr>
                                <th><label for="license_name">Name:</label></th>
                                <td><input type="text" name="customer_name" id="license_name" class="regular-text" required></td>
                            </tr>
                            <tr>
                                <th><label for="license_limit">Activations Limit:</label></th>
                                <td><input type="number" name="activations_limit" id="license_limit" class="regular-text" value="1" min="1"></td>
                            </tr>
                            <tr>
                                <th><label for="license_expires">Expires:</label></th>
                                <td>
                                    <input type="date" name="expires_at" id="license_expires" class="regular-text">
                                    <p class="description">Leave empty for never expires</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="license_notes">Notes:</label></th>
                                <td><textarea name="notes" id="license_notes" class="large-text" rows="2"></textarea></td>
                            </tr>
                        </table>
                        <p class="submit">
                            <button type="submit" class="button button-primary">Generate License</button>
                            <button type="button" class="button ulm-modal-close">Cancel</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Activations сторінка
     */
    public function activations_page() {
        $activations = ULM_Database::get_all_activations();
        
        ?>
        <div class="wrap">
            <h1>Active Domains</h1>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Domain</th>
                        <th>Product</th>
                        <th>License Key</th>
                        <th>IP Address</th>
                        <th>Activated</th>
                        <th>Last Check</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activations as $activation): ?>
                        <tr>
                            <td><strong><?php echo esc_html($activation->domain); ?></strong></td>
                            <td><?php echo esc_html($activation->product_name); ?></td>
                            <td><code><?php echo esc_html(substr($activation->license_key, 0, 12) . '...'); ?></code></td>
                            <td><?php echo esc_html($activation->ip); ?></td>
                            <td><?php echo date('Y-m-d H:i', strtotime($activation->activated_at)); ?></td>
                            <td><?php echo date('Y-m-d H:i', strtotime($activation->last_check)); ?></td>
                            <td>
                                <button type="button" class="button button-small button-link-delete ulm-deactivate-domain" 
                                        data-license-id="<?php echo $activation->license_id; ?>" 
                                        data-domain="<?php echo esc_attr($activation->domain); ?>">
                                    Deactivate
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    
    /**
     * Logs сторінка
     */
    public function logs_page() {
        $logs = ULM_Database::get_logs(100);
        
        ?>
        <div class="wrap">
            <h1>Verification Logs</h1>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Action</th>
                        <th>Domain</th>
                        <th>License</th>
                        <th>IP</th>
                        <th>Result</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?php echo date('Y-m-d H:i:s', strtotime($log->created_at)); ?></td>
                            <td><?php echo esc_html($log->action); ?></td>
                            <td><?php echo esc_html($log->domain); ?></td>
                            <td>
                                <?php if ($log->license_key): ?>
                                    <code><?php echo esc_html(substr($log->license_key, 0, 12) . '...'); ?></code>
                                <?php else: ?>
                                    <em>N/A</em>
                                <?php endif; ?>
                            </td>
                            <td><?php echo esc_html($log->ip); ?></td>
                            <td>
                                <span class="ulm-log-result ulm-log-<?php echo $log->response; ?>">
                                    <?php echo $log->response === 'success' ? '✅ Success' : '❌ Failed'; ?>
                                </span>
                            </td>
                            <td><?php echo esc_html($log->message); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    
    /**
     * Рендер останніх логів для dashboard
     */
    private function render_recent_logs() {
        $logs = ULM_Database::get_logs(5);
        
        if (empty($logs)) {
            echo '<p>No recent activity</p>';
            return;
        }
        
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>Time</th><th>Action</th><th>Domain</th><th>Result</th></tr></thead>';
        echo '<tbody>';
        
        foreach ($logs as $log) {
            echo '<tr>';
            echo '<td>' . date('H:i:s', strtotime($log->created_at)) . '</td>';
            echo '<td>' . esc_html($log->action) . '</td>';
            echo '<td>' . esc_html($log->domain) . '</td>';
            echo '<td><span class="ulm-log-result ulm-log-' . $log->response . '">';
            echo $log->response === 'success' ? '✅' : '❌';
            echo '</span></td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
    }
    
    /**
     * AJAX: Створення продукту
     */
    public function ajax_create_product() {
        if (!function_exists('check_ajax_referer')) {
            wp_die('WordPress not loaded');
        }
        
        check_ajax_referer('ulm_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Access denied');
        }
        
        $name = sanitize_text_field($_POST['name']);
        $slug = sanitize_title($_POST['slug']);
        $version = sanitize_text_field($_POST['version']);
        $price = floatval($_POST['price']);
        $description = sanitize_textarea_field($_POST['description']);
        
        global $wpdb;
        $table = $wpdb->prefix . 'ulm_products';
        
        $result = $wpdb->insert($table, array(
            'name' => $name,
            'slug' => $slug,
            'version' => $version,
            'price' => $price,
            'description' => $description
        ));
        
        if ($result) {
            wp_send_json_success(array('message' => 'Product created successfully'));
        } else {
            wp_send_json_error(array('message' => 'Failed to create product'));
        }
    }
    
    /**
     * AJAX: Створення ліцензії
     */
    public function ajax_create_license() {
        check_ajax_referer('ulm_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Access denied');
        }
        
        $product_id = intval($_POST['product_id']);
        $customer_email = sanitize_email($_POST['customer_email']);
        $customer_name = sanitize_text_field($_POST['customer_name']);
        $activations_limit = intval($_POST['activations_limit']);
        $expires_at = !empty($_POST['expires_at']) ? sanitize_text_field($_POST['expires_at']) : null;
        $notes = sanitize_textarea_field($_POST['notes']);
        
        // Генерувати унікальний ключ
        $license_key = $this->generate_license_key();
        
        $result = ULM_Database::create_license(array(
            'product_id' => $product_id,
            'license_key' => $license_key,
            'customer_email' => $customer_email,
            'customer_name' => $customer_name,
            'activations_limit' => $activations_limit,
            'expires_at' => $expires_at,
            'notes' => $notes
        ));
        
        if ($result) {
            wp_send_json_success(array(
                'message' => 'License created successfully',
                'license_key' => $license_key
            ));
        } else {
            wp_send_json_error(array('message' => 'Failed to create license'));
        }
    }
    
    /**
     * AJAX: Оновлення ліцензії
     */
    public function ajax_update_license() {
        check_ajax_referer('ulm_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Access denied');
        }
        
        $id = intval($_POST['id']);
        $data = array();
        
        if (isset($_POST['customer_email'])) {
            $data['customer_email'] = sanitize_email($_POST['customer_email']);
        }
        if (isset($_POST['customer_name'])) {
            $data['customer_name'] = sanitize_text_field($_POST['customer_name']);
        }
        if (isset($_POST['activations_limit'])) {
            $data['activations_limit'] = intval($_POST['activations_limit']);
        }
        if (isset($_POST['expires_at'])) {
            $data['expires_at'] = !empty($_POST['expires_at']) ? sanitize_text_field($_POST['expires_at']) : null;
        }
        if (isset($_POST['notes'])) {
            $data['notes'] = sanitize_textarea_field($_POST['notes']);
        }
        
        $result = ULM_Database::update_license($id, $data);
        
        if ($result !== false) {
            wp_send_json_success(array('message' => 'License updated successfully'));
        } else {
            wp_send_json_error(array('message' => 'Failed to update license'));
        }
    }
    
    /**
     * AJAX: Видалення ліцензії
     */
    public function ajax_delete_license() {
        check_ajax_referer('ulm_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Access denied');
        }
        
        $id = intval($_POST['id']);
        $result = ULM_Database::delete_license($id);
        
        if ($result) {
            wp_send_json_success(array('message' => 'License deleted successfully'));
        } else {
            wp_send_json_error(array('message' => 'Failed to delete license'));
        }
    }
    
    /**
     * AJAX: Перемикання статусу ліцензії
     */
    public function ajax_toggle_license_status() {
        check_ajax_referer('ulm_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Access denied');
        }
        
        $id = intval($_POST['id']);
        $current_status = sanitize_text_field($_POST['current_status']);
        
        $new_status = $current_status === 'active' ? 'blocked' : 'active';
        
        $result = ULM_Database::update_license($id, array('status' => $new_status));
        
        if ($result !== false) {
            wp_send_json_success(array(
                'message' => 'License status updated',
                'new_status' => $new_status
            ));
        } else {
            wp_send_json_error(array('message' => 'Failed to update license status'));
        }
    }
    
    /**
     * Генерація ключа ліцензії
     */
    private function generate_license_key() {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $key = '';
        
        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 4; $j++) {
                $key .= $chars[rand(0, strlen($chars) - 1)];
            }
            if ($i < 3) $key .= '-';
        }
        
        return $key;
    }
}
