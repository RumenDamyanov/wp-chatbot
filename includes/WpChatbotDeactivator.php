<?php

namespace Rumenx\WpChatbot;

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/RumenDamyanov/wp-chatbot
 * @since      1.0.0
 *
 * @package    WpChatbot
 * @subpackage WpChatbot/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    WpChatbot
 * @subpackage WpChatbot/includes
 * @author     Rumen Damyanov <hey@rumenx.com>
 */
class WpChatbotDeactivator
{
    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate()
    {
        // Clear any scheduled events
        wp_clear_scheduled_hook('wp_chatbot_cleanup_logs');

        // Optionally clean up temporary data
        // Note: We don't delete the options or database tables
        // in case the user wants to reactivate the plugin later
    }
}
