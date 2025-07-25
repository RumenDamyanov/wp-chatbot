<?php

namespace Rumenx\WpChatbot\Tests;

use PHPUnit\Framework\TestCase;
use Rumenx\WpChatbot\WpChatbot;
use Brain\Monkey;

/**
 * Test case for the main WpChatbot class
 *
 * @package WpChatbot
 */
class WpChatbotTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();
    }

    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }

    /**
     * Test plugin instantiation
     */
    public function test_plugin_instantiation()
    {
        $plugin = new WpChatbot();

        $this->assertInstanceOf(WpChatbot::class, $plugin);
        $this->assertEquals('wp-chatbot', $plugin->get_plugin_name());
        $this->assertEquals('1.0.0', $plugin->get_version());
    }

    /**
     * Test plugin loader
     */
    public function test_plugin_loader()
    {
        $plugin = new WpChatbot();
        $loader = $plugin->get_loader();

        $this->assertInstanceOf('Rumenx\WpChatbot\WpChatbotLoader', $loader);
    }

    /**
     * Test plugin run method
     */
    public function test_plugin_run()
    {
        \Brain\Monkey\Functions\expect('add_shortcode')->once()->andReturn(true);
        $plugin = new WpChatbot();

        // Should not throw any exceptions
        $this->assertNull($plugin->run());
    }
}
