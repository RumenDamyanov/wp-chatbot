<?php

namespace Rumenx\WpChatbot\Public;

use Rumenx\PhpChatbot\PhpChatbot;

class WpChatbotPublic
{
    private $plugin_name;
    private $version;
    private $chatbot;

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        // Provide a default model for test/dev context
        $config = [
            'model' => \Rumenx\PhpChatbot\Models\DefaultAiModel::class,
        ];
        $model = \Rumenx\PhpChatbot\Models\ModelFactory::make($config);
        $this->chatbot = new PhpChatbot($model, $config);
    }

    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, WP_CHATBOT_PLUGIN_URL . 'public/css/wp-chatbot-public.css', [], $this->version, 'all');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, WP_CHATBOT_PLUGIN_URL . 'public/js/wp-chatbot-public.js', ['jquery'], $this->version, false);
        wp_localize_script($this->plugin_name, 'wp_chatbot_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_chatbot_nonce'),
            'settings' => $this->get_settings(),
        ]);
    }

    public function display_chatbot()
    {
        $options = get_option('wp_chatbot_options');
        if (!$options || !$options['enabled']) {
            return;
        }
        $options = apply_filters('wp_chatbot_display_options', $options);
        include WP_CHATBOT_PLUGIN_PATH . 'public/partials/wp-chatbot-public-display.php';
    }

    public function handle_chat_message()
    {
        if (!wp_verify_nonce($_POST['nonce'], 'wp_chatbot_nonce')) {
            wp_die(__('Security check failed', 'wp-chatbot'));
        }
        $message = sanitize_text_field($_POST['message']);
        $session_id = sanitize_text_field($_POST['session_id']);
        if (empty($message)) {
            wp_send_json_error(__('Message cannot be empty', 'wp-chatbot'));
        }
        try {
            $response = $this->chatbot->ask($message);
            $response = apply_filters('wp_chatbot_response', $response, $message, $session_id);
            $this->log_interaction($message, $response, $session_id);
            wp_send_json_success([
                'response' => $response,
            ]);
        } catch (\Exception $e) {
            wp_send_json_error($e->getMessage());
        }
    }

    private function get_settings()
    {
        return get_option('wp_chatbot_options', []);
    }

    private function log_interaction($message, $response, $session_id)
    {
        // Logging logic here
    }
}
