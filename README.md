# WP Chatbot

A WordPress plugin that integrates advanced chatbot functionality using the [rumenx/php-chatbot](https://github.com/RumenDamyanov/php-chatbot) package. This plugin provides seamless chat integration for your WordPress site with modern UI and powerful backend capabilities.

[![Tests](https://github.com/RumenDamyanov/wp-chatbot/actions/workflows/tests.yml/badge.svg)](https://github.com/RumenDamyanov/wp-chatbot/actions/workflows/tests.yml)
[![License](https://img.shields.io/badge/license-GPL--2.0%2B-red.svg)](https://github.com/RumenDamyanov/wp-chatbot/blob/master/LICENSE.md)

## Features

- 🤖 **Advanced Chatbot Integration** - Powered by the robust rumenx/php-chatbot package
- 🎨 **Modern UI** - Clean, responsive chat interface that adapts to your theme
- ⚙️ **Easy Configuration** - Simple admin interface for chatbot setup
- 🔧 **Customizable** - Hooks and filters for developers to extend functionality
- 🌐 **Multilingual Ready** - Translation-ready with WordPress i18n
- 📱 **Mobile Responsive** - Works perfectly on all devices
- 🚀 **Performance Optimized** - Minimal impact on site performance
- 🔒 **Secure** - Follows WordPress security best practices

## Requirements

- WordPress (latest version recommended)
- PHP 8.3 or higher
- Composer (for development)

## Installation

### From WordPress Admin

TBD

### Via Composer

```bash
composer require rumenx/wp-chatbot
```

### Manual Installation

1. Clone this repository:
   ```bash
   git clone https://github.com/RumenDamyanov/wp-chatbot.git
   ```

2. Install dependencies:
   ```bash
   cd wp-chatbot
   composer install --no-dev
   ```

3. Upload the entire `wp-chatbot` folder to your `/wp-content/plugins/` directory
4. Activate the plugin through the WordPress admin interface

## Related Projects

- **Core Chatbot Package:** [rumenx/php-chatbot](https://github.com/RumenDamyanov/php-chatbot)
- **Drupal AI Chatbot Plus (GitHub):** [drupal_ai_chatbot_plus](https://github.com/RumenDamyanov/drupal_ai_chatbot_plus)
- **Drupal AI Chatbot Plus (Drupal.org):** [ai_chatbot_plus](https://www.drupal.org/project/ai_chatbot_plus)

## Quick Start

### Basic Usage

Once installed and activated, the chatbot will automatically appear on your site with default settings. To customize:

1. Go to **Settings → WP Chatbot** in your WordPress admin
2. Configure your chatbot settings
3. Save changes

### Shortcode Usage

Display the chatbot anywhere using the shortcode:

```php
[wp_chatbot]
```

With custom parameters:

```php
[wp_chatbot theme="dark" position="bottom-right" greeting="Hello! How can I help you?"]
```

### Template Integration

Add the chatbot directly to your theme templates:

```php
<?php
if (function_exists('wp_chatbot_display')) {
    wp_chatbot_display([
        'theme' => 'light',
        'position' => 'bottom-left',
        'greeting' => 'Welcome! Ask me anything.'
    ]);
}
?>
```

## Configuration

### Admin Settings

The plugin provides a comprehensive admin interface located at **Settings → WP Chatbot**:

- **General Settings**: Basic chatbot configuration
- **Appearance**: Customize colors, themes, and positioning
- **Messages**: Set greeting messages and responses
- **Advanced**: API keys, custom integrations, and developer options

### Programmatic Configuration

You can also configure the chatbot programmatically using WordPress hooks:

```php
// Customize default settings
add_filter('wp_chatbot_default_settings', function($settings) {
    $settings['greeting_message'] = 'Hello! Welcome to our site!';
    $settings['theme'] = 'custom';
    return $settings;
});

// Add custom chat responses
add_filter('wp_chatbot_responses', function($responses, $message) {
    if (strpos(strtolower($message), 'price') !== false) {
        return 'Please contact our sales team for pricing information.';
    }
    return $responses;
}, 10, 2);
```

## Hooks and Filters

### Actions

```php
// Before chatbot initialization
do_action('wp_chatbot_before_init');

// After chatbot is loaded
do_action('wp_chatbot_loaded');

// When a message is sent
do_action('wp_chatbot_message_sent', $message, $user_id);

// When a response is generated
do_action('wp_chatbot_response_generated', $response, $message);
```

### Filters

```php
// Modify chatbot settings
apply_filters('wp_chatbot_settings', $settings);

// Customize chat messages
apply_filters('wp_chatbot_messages', $messages);

// Filter responses before sending
apply_filters('wp_chatbot_response', $response, $message, $context);

// Modify the chat UI
apply_filters('wp_chatbot_ui_config', $ui_config);
```

## Examples

### Custom Theme Integration

```php
// In your theme's functions.php
function my_theme_chatbot_setup() {
    add_filter('wp_chatbot_settings', function($settings) {
        $settings['primary_color'] = get_theme_mod('primary_color', '#007cba');
        $settings['font_family'] = get_theme_mod('body_font', 'Arial, sans-serif');
        return $settings;
    });
}
add_action('after_setup_theme', 'my_theme_chatbot_setup');
```

### Adding Custom Commands

```php
// Add a custom command handler
add_filter('wp_chatbot_commands', function($commands) {
    $commands['hours'] = function() {
        return 'Our business hours are Monday-Friday, 9 AM - 6 PM EST.';
    };

    $commands['contact'] = function() {
        return 'You can reach us at contact@example.com or call (555) 123-4567.';
    };

    return $commands;
});
```

### Integration with WooCommerce

```php
// Add product search functionality
add_filter('wp_chatbot_responses', function($response, $message) {
    if (strpos(strtolower($message), 'search product') !== false) {
        $product_name = trim(str_ireplace('search product', '', $message));
        $products = wc_get_products([
            'search' => $product_name,
            'limit' => 1,
        ]);

        if (!empty($products)) {
            $product = $products[0];
            return sprintf(
                'I found this product: %s - %s. View it here: %s',
                $product->get_name(),
                wc_price($product->get_price()),
                $product->get_permalink()
            );
        }

        return 'Sorry, I couldn\'t find any products matching your search.';
    }

    return $response;
}, 10, 2);
```

## Development

### Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/RumenDamyanov/wp-chatbot.git
   cd wp-chatbot
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Run tests:
   ```bash
   composer test
   npm test
   ```

### Building Assets

```bash
# Development build
npm run dev

# Production build
npm run build

# Watch for changes
npm run watch
```

### Testing

The plugin includes comprehensive test coverage:

```bash
# Run PHP tests
composer test

# Run tests with coverage
composer coverage

# Run coding standards check
composer cs

# Fix coding standards issues
composer cbf

# Run static analysis
composer analyze

# Run JavaScript tests
npm test
```

### Code Quality

We maintain high code quality standards:

- **PHP_CodeSniffer** with WordPress Coding Standards
- **PHPUnit** for unit testing

## Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for release history.

## Support

- **Documentation**: [GitHub Wiki](https://github.com/RumenDamyanov/wp-chatbot/wiki)
- **Issues**: [GitHub Issues](https://github.com/RumenDamyanov/wp-chatbot/issues)

## License

This project is licensed under the GPL v2 or later - see the [LICENSE](LICENSE.MD) file for details.

## Configuration (Upgrade-Proof & Safe)

> **Never edit files in `vendor/rumenx/php-chatbot/`!**

To safely configure the chatbot and ensure your settings are never overwritten by Composer updates:

1. **Copy the config file:**
   - Copy `vendor/rumenx/php-chatbot/src/Config/phpchatbot.php` to a safe location, e.g.:
     - `wp-content/uploads/wp-chatbot-config.php` (recommended, writable)
     - or `wp-content/plugins/wp-chatbot/config/phpchatbot.php`

2. **Edit your config:**
   - Set your provider, model, API keys, prompt, and any other options in your copy.
   - Example:
     ```php
     return [
         'provider' => 'openai',
         'model' => 'gpt-4o',
         'openai_api_key' => getenv('OPENAI_API_KEY'),
         'prompt' => 'You are a helpful assistant for a WordPress site.',
         // ...other options...
     ];
     ```

3. **Load your config in the plugin:**
   - The plugin will look for your config in this order:
     1. `PHPCHATBOT_CONFIG_PATH` environment variable (if set)
     2. `wp-content/uploads/wp-chatbot-config.php`
     3. `wp-content/plugins/wp-chatbot/config/phpchatbot.php`
     4. Fallback: the default in `vendor/rumenx/php-chatbot/src/Config/phpchatbot.php`
   - Example loader:
     ```php
     $configPath = getenv('PHPCHATBOT_CONFIG_PATH') ?: WP_CONTENT_DIR . '/uploads/wp-chatbot-config.php';
     if (!file_exists($configPath)) {
         $configPath = WP_PLUGIN_DIR . '/wp-chatbot/config/phpchatbot.php';
     }
     if (!file_exists($configPath)) {
         $configPath = WP_PLUGIN_DIR . '/wp-chatbot/vendor/rumenx/php-chatbot/src/Config/phpchatbot.php';
     }
     $config = require $configPath;
     ```

4. **Use environment variables for secrets:**
   - Set API keys in your `.env` or server config, not in the codebase.

5. **Document your config location** for your team or future you.

---

## Usage Example: Integrating rumenx/php-chatbot in WordPress

```php
add_action('wp_ajax_wp_chatbot_message', 'my_wp_chatbot_message_handler');
add_action('wp_ajax_nopriv_wp_chatbot_message', 'my_wp_chatbot_message_handler');

function my_wp_chatbot_message_handler() {
    $configPath = getenv('PHPCHATBOT_CONFIG_PATH') ?: WP_CONTENT_DIR . '/uploads/wp-chatbot-config.php';
    if (!file_exists($configPath)) {
        $configPath = WP_PLUGIN_DIR . '/wp-chatbot/config/phpchatbot.php';
    }
    if (!file_exists($configPath)) {
        $configPath = WP_PLUGIN_DIR . '/wp-chatbot/vendor/rumenx/php-chatbot/src/Config/phpchatbot.php';
    }
    $config = require $configPath;

    $model = \Rumenx\PhpChatbot\Models\ModelFactory::make($config);
    $chatbot = new \Rumenx\PhpChatbot\PhpChatbot($model, $config);

    $message = sanitize_text_field($_POST['message'] ?? '');
    $reply = $chatbot->ask($message);

    wp_send_json_success(['reply' => $reply]);
}
```

- This ensures your config is never overwritten by Composer updates.
- You can use the same approach in custom REST endpoints, shortcodes, or other plugin integrations.

---

## Best Practices for Using rumenx/php-chatbot in WordPress

- **Never edit files in `vendor/rumenx/php-chatbot/`** – always copy config to your own directory.
- **Store your config outside the vendor directory** (e.g., in `uploads/` or your plugin’s own `config/` folder).
- **Use environment variables for API keys and secrets** (e.g., `OPENAI_API_KEY`).
- **Document your config location** for your team or future you.
- **Override views and styles in your own plugin/theme** – do not edit package files directly.
- **For advanced configuration, supported models, and middleware, see the [php-chatbot documentation](https://github.com/RumenDamyanov/php-chatbot).**

---
