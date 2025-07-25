<?php

namespace Rumenx\WpChatbot;

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/RumenDamyanov/wp-chatbot
 * @since      1.0.0
 *
 * @package    WpChatbot
 * @subpackage WpChatbot/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WpChatbot
 * @subpackage WpChatbot/includes
 * @author     Rumen Damyanov <hey@rumenx.com>
 */
class WpChatbotActivator
{
    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        // Create default options
        $default_options = [
            'enabled' => true,
            'position' => 'bottom-right',
            'theme' => 'light',
            'greeting_message' => __('Hello! How can I help you today?', 'wp-chatbot'),
            'primary_color' => '#007cba',
            'show_on_mobile' => true,
            'animation' => 'slide',
        ];

        add_option('wp_chatbot_options', $default_options);

        // Create chatbot logs table
        self::create_chatbot_table();

        // Set default capabilities
        self::set_default_capabilities();
    }

    /**
     * Create the chatbot logs table
     *
     * @since    1.0.0
     */
    private static function create_chatbot_table()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'wp_chatbot_logs';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) DEFAULT NULL,
            session_id varchar(255) NOT NULL,
            message text NOT NULL,
            response text NOT NULL,
            timestamp datetime DEFAULT CURRENT_TIMESTAMP,
            user_ip varchar(45) DEFAULT NULL,
            user_agent text DEFAULT NULL,
            PRIMARY KEY (id),
            KEY user_id (user_id),
            KEY session_id (session_id),
            KEY timestamp (timestamp)
        ) $charset_collate;";

        // Only require upgrade.php if not running tests
        if (!defined('WP_CHATBOT_TESTS') || !WP_CHATBOT_TESTS) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        }
        dbDelta($sql);
    }

    /**
     * Set default capabilities for managing the chatbot
     *
     * @since    1.0.0
     */
    private static function set_default_capabilities()
    {
        $role = get_role('administrator');
        if ($role) {
            $role->add_cap('manage_wp_chatbot');
            $role->add_cap('view_wp_chatbot_logs');
        }
    }
}
