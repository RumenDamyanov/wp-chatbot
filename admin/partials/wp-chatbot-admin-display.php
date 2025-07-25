<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/RumenDamyanov/wp-chatbot
 * @since      1.0.0
 *
 * @package    WpChatbot
 * @subpackage WpChatbot/admin/partials
 */

// Get current options
$options = get_option($this->plugin_name);
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

    <div class="wp-chatbot-admin-container">
        <div class="wp-chatbot-admin-main">
            <form method="post" name="wp_chatbot_options" action="options.php">

                <?php
                // Output security fields for the registered setting "wp_chatbot"
                settings_fields($this->plugin_name);
                do_settings_sections($this->plugin_name);
                ?>

                <div class="wp-chatbot-settings-section">
                    <h3><?php _e('General Settings', 'wp-chatbot'); ?></h3>

                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="<?php echo $this->plugin_name; ?>-enabled"><?php _e('Enable Chatbot', 'wp-chatbot'); ?></label>
                            </th>
                            <td>
                                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-enabled" name="<?php echo $this->plugin_name; ?>[enabled]" value="1" <?php checked($options['enabled'] ?? false, 1); ?> />
                                <label for="<?php echo $this->plugin_name; ?>-enabled"><?php _e('Enable the chatbot on your website', 'wp-chatbot'); ?></label>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="<?php echo $this->plugin_name; ?>-position"><?php _e('Position', 'wp-chatbot'); ?></label>
                            </th>
                            <td>
                                <select id="<?php echo $this->plugin_name; ?>-position" name="<?php echo $this->plugin_name; ?>[position]">
                                    <option value="bottom-right" <?php selected($options['position'] ?? 'bottom-right', 'bottom-right'); ?>><?php _e('Bottom Right', 'wp-chatbot'); ?></option>
                                    <option value="bottom-left" <?php selected($options['position'] ?? 'bottom-right', 'bottom-left'); ?>><?php _e('Bottom Left', 'wp-chatbot'); ?></option>
                                    <option value="top-right" <?php selected($options['position'] ?? 'bottom-right', 'top-right'); ?>><?php _e('Top Right', 'wp-chatbot'); ?></option>
                                    <option value="top-left" <?php selected($options['position'] ?? 'bottom-right', 'top-left'); ?>><?php _e('Top Left', 'wp-chatbot'); ?></option>
                                </select>
                                <p class="description"><?php _e('Choose where the chatbot should appear on your website.', 'wp-chatbot'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="<?php echo $this->plugin_name; ?>-theme"><?php _e('Theme', 'wp-chatbot'); ?></label>
                            </th>
                            <td>
                                <select id="<?php echo $this->plugin_name; ?>-theme" name="<?php echo $this->plugin_name; ?>[theme]">
                                    <option value="light" <?php selected($options['theme'] ?? 'light', 'light'); ?>><?php _e('Light', 'wp-chatbot'); ?></option>
                                    <option value="dark" <?php selected($options['theme'] ?? 'light', 'dark'); ?>><?php _e('Dark', 'wp-chatbot'); ?></option>
                                    <option value="auto" <?php selected($options['theme'] ?? 'light', 'auto'); ?>><?php _e('Auto (follows system)', 'wp-chatbot'); ?></option>
                                </select>
                                <p class="description"><?php _e('Choose the chatbot theme.', 'wp-chatbot'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="<?php echo $this->plugin_name; ?>-greeting_message"><?php _e('Greeting Message', 'wp-chatbot'); ?></label>
                            </th>
                            <td>
                                <textarea id="<?php echo $this->plugin_name; ?>-greeting_message" name="<?php echo $this->plugin_name; ?>[greeting_message]" rows="3" cols="50"><?php echo esc_textarea($options['greeting_message'] ?? __('Hello! How can I help you today?', 'wp-chatbot')); ?></textarea>
                                <p class="description"><?php _e('The initial message displayed when the chatbot opens.', 'wp-chatbot'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="<?php echo $this->plugin_name; ?>-primary_color"><?php _e('Primary Color', 'wp-chatbot'); ?></label>
                            </th>
                            <td>
                                <input type="color" id="<?php echo $this->plugin_name; ?>-primary_color" name="<?php echo $this->plugin_name; ?>[primary_color]" value="<?php echo esc_attr($options['primary_color'] ?? '#007cba'); ?>" />
                                <p class="description"><?php _e('Choose the primary color for the chatbot interface.', 'wp-chatbot'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="<?php echo $this->plugin_name; ?>-show_on_mobile"><?php _e('Show on Mobile', 'wp-chatbot'); ?></label>
                            </th>
                            <td>
                                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-show_on_mobile" name="<?php echo $this->plugin_name; ?>[show_on_mobile]" value="1" <?php checked($options['show_on_mobile'] ?? true, 1); ?> />
                                <label for="<?php echo $this->plugin_name; ?>-show_on_mobile"><?php _e('Display chatbot on mobile devices', 'wp-chatbot'); ?></label>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="<?php echo $this->plugin_name; ?>-animation"><?php _e('Animation', 'wp-chatbot'); ?></label>
                            </th>
                            <td>
                                <select id="<?php echo $this->plugin_name; ?>-animation" name="<?php echo $this->plugin_name; ?>[animation]">
                                    <option value="slide" <?php selected($options['animation'] ?? 'slide', 'slide'); ?>><?php _e('Slide', 'wp-chatbot'); ?></option>
                                    <option value="fade" <?php selected($options['animation'] ?? 'slide', 'fade'); ?>><?php _e('Fade', 'wp-chatbot'); ?></option>
                                    <option value="bounce" <?php selected($options['animation'] ?? 'slide', 'bounce'); ?>><?php _e('Bounce', 'wp-chatbot'); ?></option>
                                    <option value="none" <?php selected($options['animation'] ?? 'slide', 'none'); ?>><?php _e('None', 'wp-chatbot'); ?></option>
                                </select>
                                <p class="description"><?php _e('Choose the animation style for the chatbot.', 'wp-chatbot'); ?></p>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php submit_button(__('Save Settings', 'wp-chatbot'), 'primary', 'submit', true); ?>

            </form>
        </div>

        <div class="wp-chatbot-admin-sidebar">
            <div class="wp-chatbot-admin-box">
                <h3><?php _e('Usage Instructions', 'wp-chatbot'); ?></h3>
                <p><?php _e('The chatbot will automatically appear on your website when enabled. You can also use the following shortcode to display it in specific locations:', 'wp-chatbot'); ?></p>
                <code>[wp_chatbot]</code>

                <h4><?php _e('Shortcode Parameters', 'wp-chatbot'); ?></h4>
                <ul>
                    <li><strong>theme</strong>: light, dark, auto</li>
                    <li><strong>position</strong>: inline, bottom-right, bottom-left, top-right, top-left</li>
                    <li><strong>greeting</strong>: Custom greeting message</li>
                    <li><strong>height</strong>: Height for inline display (e.g., 400px)</li>
                </ul>

                <p><?php _e('Example:', 'wp-chatbot'); ?></p>
                <code>[wp_chatbot theme="dark" position="inline" height="500px"]</code>
            </div>

            <div class="wp-chatbot-admin-box">
                <h3><?php _e('Support & Documentation', 'wp-chatbot'); ?></h3>
                <p><?php _e('Need help? Check out our documentation and support resources:', 'wp-chatbot'); ?></p>
                <ul>
                    <li><a href="https://github.com/RumenDamyanov/wp-chatbot/wiki" target="_blank"><?php _e('Documentation', 'wp-chatbot'); ?></a></li>
                    <li><a href="https://github.com/RumenDamyanov/wp-chatbot/issues" target="_blank"><?php _e('Report Issues', 'wp-chatbot'); ?></a></li>
                    <li><a href="mailto:hey@rumenx.com"><?php _e('Contact Support', 'wp-chatbot'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
