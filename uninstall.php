<?php
// If uninstall not called from WordPress, exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

// Optionally delete plugin options and custom tables.
// delete_option('wp_chatbot_options');
// global $wpdb;
// $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}wp_chatbot_logs");
