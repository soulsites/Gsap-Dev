<?php
/**
 * Plugin Name: Basic WP Plugin
 * Description: A basic WordPress plugin.
 * Version: 1.0
 * Author: Your Name
 */

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

use BasicWpPlugin\DatabaseHandler;
use BasicWpPlugin\Init;

// Function to handle plugin activation
function basic_wp_plugin_activate() {
    $db_handler = new DatabaseHandler();
    $db_handler->check_and_create_table();
    add_option('basic_wp_plugin_db_created', true); // Set option for admin notice
}
register_activation_hook(__FILE__, 'basic_wp_plugin_activate');

// Initialize the plugin
function initialize_basic_wp_plugin() {
    $init = new Init();
    $init->run();
}
initialize_basic_wp_plugin();