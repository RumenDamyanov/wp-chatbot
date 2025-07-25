<?php

namespace Rumenx\WpChatbot;

// Defensive: ensure Composer autoloader is loaded for PSR-4 classes
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/RumenDamyanov/wp-chatbot
 * @since      1.0.0
 *
 * @package    WpChatbot
 * @subpackage WpChatbot/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WpChatbot
 * @subpackage WpChatbot/includes
 * @author     Rumen Damyanov <hey@rumenx.com>
 */
class WpChatbot
{
    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct()
    {
        if (defined('WP_CHATBOT_VERSION')) {
            $this->version = WP_CHATBOT_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'wp-chatbot';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies()
    {
        require_once WP_CHATBOT_PLUGIN_PATH . 'includes/WpChatbotLoader.php';
        require_once WP_CHATBOT_PLUGIN_PATH . 'includes/WpChatbotI18n.php';
        $this->loader = new WpChatbotLoader();
    }

    private function set_locale()
    {
        $plugin_i18n = new WpChatbotI18n();
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    private function define_admin_hooks()
    {
        $plugin_admin = new \Rumenx\WpChatbot\Admin\WpChatbotAdmin($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_admin_menu');
        $this->loader->add_action('admin_init', $plugin_admin, 'options_update');
        // $this->loader->add_filter('plugin_action_links_' . plugin_basename(WP_CHATBOT_PLUGIN_FILE), $plugin_admin, 'add_action_links');
    }

    private function define_public_hooks()
    {
        $plugin_public = new \Rumenx\WpChatbot\Public\WpChatbotPublic($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_action('wp_footer', $plugin_public, 'display_chatbot');
        $this->loader->add_action('wp_ajax_wp_chatbot_send_message', $plugin_public, 'handle_chat_message');
        $this->loader->add_action('wp_ajax_nopriv_wp_chatbot_send_message', $plugin_public, 'handle_chat_message');
        $this->loader->add_shortcode('wp_chatbot', $plugin_public, 'chatbot_shortcode');
    }

    public function run()
    {
        $this->loader->run();
    }

    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    public function get_loader()
    {
        return $this->loader;
    }

    public function get_version()
    {
        return $this->version;
    }
}
