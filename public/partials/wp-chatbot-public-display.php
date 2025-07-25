<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/RumenDamyanov/wp-chatbot
 * @since      1.0.0
 *
 * @package    WpChatbot
 * @subpackage WpChatbot/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div id="wp-chatbot-container"
     class="wp-chatbot-container wp-chatbot-<?php echo esc_attr($options['theme']); ?> wp-chatbot-<?php echo esc_attr($options['position']); ?>"
     data-animation="<?php echo esc_attr($options['animation']); ?>"
     style="--wp-chatbot-primary-color: <?php echo esc_attr($options['primary_color']); ?>">

    <!-- Chatbot Toggle Button -->
    <button id="wp-chatbot-toggle" class="wp-chatbot-toggle" aria-label="<?php esc_attr_e('Open chat', 'wp-chatbot'); ?>">
        <svg class="wp-chatbot-icon-chat" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4l4 4 4-4h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
        </svg>
        <svg class="wp-chatbot-icon-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
        </svg>
    </button>

    <!-- Chatbot Window -->
    <div id="wp-chatbot-window" class="wp-chatbot-window">
        <!-- Header -->
        <div class="wp-chatbot-header">
            <div class="wp-chatbot-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </div>
            <div class="wp-chatbot-info">
                <h4><?php _e('Chat Assistant', 'wp-chatbot'); ?></h4>
                <span class="wp-chatbot-status"><?php _e('Online', 'wp-chatbot'); ?></span>
            </div>
            <button class="wp-chatbot-minimize" aria-label="<?php esc_attr_e('Minimize chat', 'wp-chatbot'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 13H5v-2h14v2z"/>
                </svg>
            </button>
        </div>

        <!-- Messages Container -->
        <div id="wp-chatbot-messages" class="wp-chatbot-messages">
            <div class="wp-chatbot-message wp-chatbot-message-bot">
                <div class="wp-chatbot-message-content">
                    <?php echo esc_html($options['greeting_message']); ?>
                </div>
                <div class="wp-chatbot-message-time">
                    <?php echo esc_html(current_time('H:i')); ?>
                </div>
            </div>
        </div>

        <!-- Typing Indicator -->
        <div id="wp-chatbot-typing" class="wp-chatbot-typing" style="display: none;">
            <div class="wp-chatbot-typing-content">
                <div class="wp-chatbot-typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <span class="wp-chatbot-typing-text"><?php _e('Assistant is typing...', 'wp-chatbot'); ?></span>
            </div>
        </div>

        <!-- Input Area -->
        <div class="wp-chatbot-input-area">
            <form id="wp-chatbot-form" class="wp-chatbot-form">
                <input type="text"
                       id="wp-chatbot-input"
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
</div>
