<?php
/**
 * Plugin Name: WP Chatbot
 * Plugin URI: https://github.com/RumenDamyanov/wp-chatbot
 * Description: A WordPress plugin that integrates advanced chatbot functionality using the rumenx/php-chatbot package. Provides seamless chat integration for your WordPress site.
 * Version: 1.0.0
 * Author: Rumen Damyanov
 * Author URI: https://rumenx.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-chatbot
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * Network: false
 *
 * @package WpChatbot
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('WP_CHATBOT_VERSION', '1.0.0');
define('WP_CHATBOT_PLUGIN_FILE', __FILE__);
define('WP_CHATBOT_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('WP_CHATBOT_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Autoloader for the plugin.
 */
require_once WP_CHATBOT_PLUGIN_PATH . 'vendor/autoload.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-chatbot-activator.php
 */
function activate_wp_chatbot() {
    require_once WP_CHATBOT_PLUGIN_PATH . 'includes/class-wp-chatbot-activator.php';
    Rumenx\WpChatbot\WpChatbotActivator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-chatbot-deactivator.php
 */
function deactivate_wp_chatbot() {
    require_once WP_CHATBOT_PLUGIN_PATH . 'includes/class-wp-chatbot-deactivator.php';
    Rumenx\WpChatbot\WpChatbotDeactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wp_chatbot');
register_deactivation_hook(__FILE__, 'deactivate_wp_chatbot');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require WP_CHATBOT_PLUGIN_PATH . 'includes/class-wp-chatbot.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_chatbot() {
    $plugin = new Rumenx\WpChatbot\WpChatbot();
    $plugin->run();
}

run_wp_chatbot();
