<?php

namespace Rumenx\WpChatbot\Admin;

class WpChatbotAdmin
{
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, WP_CHATBOT_PLUGIN_URL . 'admin/css/wp-chatbot-admin.css', [], $this->version, 'all');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, WP_CHATBOT_PLUGIN_URL . 'admin/js/wp-chatbot-admin.js', ['jquery'], $this->version, false);
        wp_localize_script($this->plugin_name, 'wp_chatbot_admin', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_chatbot_admin_nonce'),
        ]);
    }

    public function add_plugin_admin_menu()
    {
        add_options_page(
            __('WP Chatbot Settings', 'wp-chatbot'),
            __('WP Chatbot', 'wp-chatbot'),
            'manage_options',
            $this->plugin_name,
            [$this, 'display_plugin_setup_page']
        );
    }

    public function add_action_links($links)
    {
        $settings_link = [
            '<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', 'wp-chatbot') . '</a>',
        ];
        return array_merge($settings_link, $links);
    }

    public function display_plugin_setup_page()
    {
        include_once 'partials/wp-chatbot-admin-display.php';
    }

    public function options_update()
    {
        register_setting($this->plugin_name, $this->plugin_name, [$this, 'validate']);
    }

    public function validate($input)
    {
        // Validation logic here
        return $input;
    }
}
