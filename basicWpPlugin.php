<?php
/**
 * Plugin Name: Basic WP Plugin
 * Description: A standard WordPress plugin using Carbon Fields for settings
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: basic-wp-plugin
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Autoload classes
require_once __DIR__ . '/vendor/autoload.php';

// Use namespaces
use BasicWpPlugin\Init;

// Initialize the plugin
function run_basic_wp_plugin() {
    $plugin = new Init();
    $plugin->run();
}

run_basic_wp_plugin();