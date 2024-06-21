<?php

namespace BasicWpPlugin\Settings;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class SettingsPage {
    public function __construct() {
        add_action('carbon_fields_register_fields', [$this, 'create_settings_page']);
        add_action('after_setup_theme', [$this, 'load']);
    }

    public function load() {
        \Carbon_Fields\Carbon_Fields::boot();
    }

    public function create_settings_page() {
        Container::make('theme_options', __('Basic WP Plugin Settings', 'basic-wp-plugin'))
            ->add_fields(array(
                Field::make('text', 'crb_text', 'Text Field'),
            ));
    }
}