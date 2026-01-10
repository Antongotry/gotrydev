<?php
/**
 * License generator utility
 * 
 * @package Universal_License_Manager
 * @author AntonGotry (@notarikon)
 */

if (!defined('ABSPATH')) {
    exit;
}

class ULM_License_Generator {
    
    /**
     * Генерація унікального ключа ліцензії
     */
    public static function generate_key() {
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
    
    /**
     * Перевірка унікальності ключа
     */
    public static function is_key_unique($key) {
        global $wpdb;
        $table = $wpdb->prefix . 'ulm_licenses';
        
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table WHERE license_key = %s",
            $key
        ));
        
        return !$exists;
    }
    
    /**
     * Генерація унікального ключа
     */
    public static function generate_unique_key() {
        do {
            $key = self::generate_key();
        } while (!self::is_key_unique($key));
        
        return $key;
    }
}
