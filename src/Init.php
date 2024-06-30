<?php

namespace GsapDev;

use GsapDev\Settings\SettingsPage;
use GsapDev\DatabaseHandler;
use GsapDev\EnqueueScripts;

class Init {

    public function run() {
        add_action('plugins_loaded', [$this, 'load_dependencies']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_public_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('admin_notices', [$this, 'admin_notices']); // Add admin notices action
    }

    public function load_dependencies() {
        // Initialize Settings Page
        new SettingsPage();
        new EnqueueScripts();
    }

    public function enqueue_public_assets() {
        wp_enqueue_style('basic-wp-plugin-public-styles', plugin_dir_url(dirname(__FILE__)) . 'src/Public/css/public-styles.css');
        wp_enqueue_script('basic-wp-plugin-public-scripts', plugin_dir_url(dirname(__FILE__)) . 'src/Public/js/public-scripts.js', ['jquery'], null, true);
    }

    public function enqueue_admin_assets() {
        wp_enqueue_style('basic-wp-plugin-admin-styles', plugin_dir_url(dirname(__FILE__)) . 'src/Admin/css/admin-styles.css');
        wp_enqueue_script('basic-wp-plugin-admin-scripts', plugin_dir_url(dirname(__FILE__)) . 'src/Admin/js/admin-scripts.js', ['jquery'], null, true);
    }

    public function admin_notices() {
        if (get_option('basic_wp_plugin_db_created')) {
            echo '<div class="notice notice-success is-dismissible">';
            echo '<p>' . __('Database table created successfully.', 'basic-wp-plugin') . '</p>';
            echo '</div>';
            delete_option('basic_wp_plugin_db_created'); // Remove the option after displaying the notice
        }
    }
}