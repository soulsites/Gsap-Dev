<?php

namespace GsapDev;

class EnqueueScripts {
    private $js_files = [
        'gsap.min.js',
        'CSSRulePlugin.min.js',
        'CustomEase.min.js',
        'Draggable.min.js',
        'EaselPlugin.min.js',
        'EasePack.min.js',
        'Flip.min.js',
        'MotionPathPlugin.min.js',
        'Observer.min.js',
        'PixiPlugin.min.js',
        'ScrollToPlugin.min.js',
        'ScrollTrigger.min.js',
        'TextPlugin.min.js',
    ];

    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_selected_scripts']);
    }

    public function enqueue_selected_scripts() {
        foreach ($this->js_files as $file) {
            $field_name = 'crb_' . str_replace(['.', '-'], '_', strtolower($file));
            $option = carbon_get_theme_option($field_name);
            if ($option) {
                wp_enqueue_script(
                    'gsapdev-' . $file,
                    plugin_dir_url(dirname(__FILE__)) . 'src/Public/js/gsap/' . $file,
                    array(),
                    null,
                    true
                );
            }
        }
    }
}