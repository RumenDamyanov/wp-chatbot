<?php

namespace Rumenx\WpChatbot\Tests;

use PHPUnit\Framework\TestCase;
use Rumenx\WpChatbot\WpChatbotActivator;
use Brain\Monkey;

/**
 * Test case for the WpChatbotActivator class
 *
 * @package WpChatbot
 */
class WpChatbotActivatorTest extends TestCase
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
     * Test plugin activation
     */
    public function test_plugin_activation()
    {
        // Ensure get_option returns false so add_option is called
        Monkey\Functions\when('get_option')->justReturn(false);

        // Allow add_option to be called any number of times
        Monkey\Functions\when('add_option')->justReturn(true);

        // Mock get_role to always return a mock object with add_cap method
        $roleMock = \Mockery::mock();
        $roleMock->shouldReceive('add_cap')->atLeast()->once();
        Monkey\Functions\when('get_role')->alias(function() use ($roleMock) {
            return $roleMock;
        });

        // Should not throw any exceptions
        $this->assertNull(WpChatbotActivator::activate());
    }
}
