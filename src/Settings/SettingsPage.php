<?php

namespace GsapDev\Settings;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class SettingsPage {
    private $js_files = [
        'gsap.min.js',
        'CSSRulePlugin.min.js',
        'CustomBounce.min.js',
        'CustomEase.min.js',
        'CustomWiggle.min.js',
        'Draggable.min.js',
        'DrawSVGPlugin.min.js',
        'EaselPlugin.min.js',
        'EasePack.min.js',
        'Flip.min.js',
        'GSDevTools.min.js',
        'InertiaPlugin.min.js',
        'MorphSVGPlugin.min.js',
        'MotionPathHelper.min.js',
        'MotionPathPlugin.min.js',
        'Observer.min.js',
        'Physics2DPlugin.min.js',
        'PhysicsPropsPlugin.min.js',
        'PixiPlugin.min.js',
        'ScrambleTextPlugin.min.js',
        'ScrollSmoother.min.js',
        'ScrollToPlugin.min.js',
        'ScrollTrigger.min.js',
        'SplitText.min.js',
        'TextPlugin.min.js',
        'p5.min.js',
    ];

    public function __construct() {
        add_action('carbon_fields_register_fields', [$this, 'create_settings_page']);
        add_action('after_setup_theme', [$this, 'load']);
    }

    public function load() {
        \Carbon_Fields\Carbon_Fields::boot();
    }

    public function create_settings_page() {
        $fields = [];
        foreach ($this->js_files as $file) {
            $field_name = 'crb_' . str_replace(['.', '-'], '_', strtolower($file));
            $fields[] = Field::make('checkbox', $field_name, $file);
        }

        Container::make('theme_options', __('Gsap Dev Plugin Settings', 'gsap-dev-plugin'))
            ->add_fields($fields);
    }
}