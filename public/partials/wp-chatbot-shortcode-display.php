<?php
/**
 * Provide a shortcode view for the plugin
 *
 * This file is used to markup the shortcode display of the plugin.
 *
 * @link       https://github.com/RumenDamyanov/wp-chatbot
 * @since      1.0.0
 *
 * @package    WpChatbot
 * @subpackage WpChatbot/public/partials
 */
?>

<!-- Inline Chatbot Display -->
<div class="wp-chatbot-shortcode wp-chatbot-<?php echo esc_attr($atts['theme']); ?>"
     style="height: <?php echo esc_attr($atts['height']); ?>; width: <?php echo esc_attr($atts['width']); ?>; --wp-chatbot-primary-color: <?php echo esc_attr($this->get_settings()['primary_color']); ?>">

    <div class="wp-chatbot-shortcode-header">
        <div class="wp-chatbot-avatar">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
        </div>
        <div class="wp-chatbot-info">
            <h4><?php _e('Chat Assistant', 'wp-chatbot'); ?></h4>
            <span class="wp-chatbot-status"><?php _e('Online', 'wp-chatbot'); ?></span>
        </div>
    </div>

    <div class="wp-chatbot-shortcode-messages" id="wp-chatbot-shortcode-messages-<?php echo uniqid(); ?>">
        <div class="wp-chatbot-message wp-chatbot-message-bot">
            <div class="wp-chatbot-message-content">
                <?php echo esc_html($atts['greeting'] ?: $this->get_settings()['greeting_message']); ?>
            </div>
            <div class="wp-chatbot-message-time">
                <?php echo esc_html(current_time('H:i')); ?>
            </div>
        </div>
    </div>

    <div class="wp-chatbot-shortcode-input">
        <form class="wp-chatbot-form wp-chatbot-shortcode-form">
            <input type="text"
                   class="wp-chatbot-input"
                   placeholder="<?php esc_attr_e('Type your message...', 'wp-chatbot'); ?>"
                   autocomplete="off">
            <button type="submit" class="wp-chatbot-send" aria-label="<?php esc_attr_e('Send message', 'wp-chatbot'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>
            </button>
        </form>
    </div>
</div>
