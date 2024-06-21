<?php

namespace BasicWpPlugin;

use BasicWpPlugin\Settings\SettingsPage;


class Init {

    public function run() {
        add_action('plugins_loaded', [$this, 'load_dependencies']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_public_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    public function load_dependencies() {
        // Initialize Settings Page
        new SettingsPage();

    }

    public function enqueue_public_assets() {
        wp_enqueue_style('basic-wp-plugin-public-styles', plugin_dir_url(dirname(__FILE__)) . 'src/Public/css/public-styles.css');
        wp_enqueue_script('basic-wp-plugin-public-scripts', plugin_dir_url(dirname(__FILE__)) . 'src/Public/js/public-scripts.min.js', ['jquery'], null, true);
    }

    public function enqueue_admin_assets() {
        wp_enqueue_style('basic-wp-plugin-admin-styles', plugin_dir_url(dirname(__FILE__)) . 'src/Admin/css/admin-styles.css');
        wp_enqueue_script('basic-wp-plugin-admin-scripts', plugin_dir_url(dirname(__FILE__)) . 'src/Admin/js/admin-scripts.js', ['jquery'], null, true);
    }
}