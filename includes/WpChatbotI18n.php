<?php

namespace Rumenx\WpChatbot;

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/RumenDamyanov/wp-chatbot
 * @since      1.0.0
 *
 * @package    WpChatbot
 * @subpackage WpChatbot/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    WpChatbot
 * @subpackage WpChatbot/includes
 * @author     Rumen Damyanov <hey@rumenx.com>
 */
class WpChatbotI18n
{
    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain(
            'wp-chatbot',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}
