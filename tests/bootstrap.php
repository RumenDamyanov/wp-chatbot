<?php

// Signal test context for plugin code
define('WP_CHATBOT_TESTS', true);

/**
 * PHPUnit bootstrap file for WP Chatbot plugin tests
 *
 * @package WpChatbot
 */

// Define plugin constants
define('WP_CHATBOT_PLUGIN_PATH', dirname(__DIR__) . '/');
define('WP_CHATBOT_PLUGIN_URL', 'http://localhost/wp-content/plugins/wp-chatbot/');
define('WP_CHATBOT_VERSION', '1.0.0');

// Define WordPress constants for testing
if (!defined('ABSPATH')) {
    define('ABSPATH', '/tmp/wordpress/');
}

if (!defined('WP_CONTENT_DIR')) {
    define('WP_CONTENT_DIR', ABSPATH . 'wp-content');
}

if (!defined('WP_PLUGIN_DIR')) {
    define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');
}

if (!defined('WPINC')) {
    define('WPINC', 'wp-includes');
}

// Composer autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Initialize Brain Monkey
\Brain\Monkey\setUp();

// WordPress function mocking
\Brain\Monkey\Functions\when('add_action')->justReturn(true);
\Brain\Monkey\Functions\when('add_filter')->justReturn(true);
\Brain\Monkey\Functions\when('add_shortcode')->justReturn(true);
\Brain\Monkey\Functions\when('load_plugin_textdomain')->justReturn(true);
\Brain\Monkey\Functions\when('plugin_basename')->returnArg();
\Brain\Monkey\Functions\when('wp_enqueue_style')->justReturn(true);
\Brain\Monkey\Functions\when('wp_enqueue_script')->justReturn(true);
\Brain\Monkey\Functions\when('wp_localize_script')->justReturn(true);
\Brain\Monkey\Functions\when('admin_url')->returnArg();
\Brain\Monkey\Functions\when('wp_create_nonce')->justReturn('test-nonce');
\Brain\Monkey\Functions\when('add_options_page')->justReturn(true);
\Brain\Monkey\Functions\when('register_setting')->justReturn(true);
\Brain\Monkey\Functions\when('get_option')->alias(function($option, $default = false) {
    static $options = [];
    return $options[$option] ?? $default;
});
\Brain\Monkey\Functions\when('add_option')->alias(function($option, $value) {
    static $options = [];
    $options[$option] = $value;
    return true;
});
\Brain\Monkey\Functions\when('sanitize_text_field')->returnArg();
\Brain\Monkey\Functions\when('sanitize_textarea_field')->returnArg();
\Brain\Monkey\Functions\when('sanitize_hex_color')->returnArg();
\Brain\Monkey\Functions\when('__')->returnArg();
\Brain\Monkey\Functions\when('_e')->justReturn(true);
\Brain\Monkey\Functions\when('esc_attr')->returnArg();
\Brain\Monkey\Functions\when('esc_html')->returnArg();
\Brain\Monkey\Functions\when('esc_attr_e')->justReturn(true);
\Brain\Monkey\Functions\when('wp_verify_nonce')->justReturn(true);
\Brain\Monkey\Functions\when('wp_die')->justReturn(true);
\Brain\Monkey\Functions\when('wp_send_json_error')->justReturn(true);
\Brain\Monkey\Functions\when('wp_send_json_success')->justReturn(true);
\Brain\Monkey\Functions\when('current_time')->justReturn('12:00');
\Brain\Monkey\Functions\when('apply_filters')->returnArg();
\Brain\Monkey\Functions\when('get_current_user_id')->justReturn(1);
\Brain\Monkey\Functions\when('shortcode_atts')->returnArg();
\Brain\Monkey\Functions\when('get_admin_page_title')->justReturn('WP Chatbot Settings');
\Brain\Monkey\Functions\when('settings_fields')->justReturn(true);
\Brain\Monkey\Functions\when('do_settings_sections')->justReturn(true);
\Brain\Monkey\Functions\when('checked')->justReturn('checked="checked"');
\Brain\Monkey\Functions\when('selected')->justReturn('selected="selected"');
\Brain\Monkey\Functions\when('submit_button')->justReturn('<button type="submit">Save</button>');
\Brain\Monkey\Functions\when('wp_clear_scheduled_hook')->justReturn(true);
\Brain\Monkey\Functions\when('get_role')->justReturn(new stdClass());
\Brain\Monkey\Functions\when('dbDelta')->justReturn(true);

// Global WordPress variables
global $wpdb;
$wpdb = Mockery::mock('wpdb');
$wpdb->prefix = 'wp_';
$wpdb->shouldReceive('get_charset_collate')->andReturn('DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
$wpdb->shouldReceive('insert')->andReturn(true);

// Cleanup after tests
register_shutdown_function(function() {
    \Brain\Monkey\tearDown();
});
