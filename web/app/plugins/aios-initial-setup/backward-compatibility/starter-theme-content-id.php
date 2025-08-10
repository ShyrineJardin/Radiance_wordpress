<?php

class AI_Starter_Theme_Compatibility {
    public static function ai_starter_theme_get_content_id($default_class) {
        if (is_active_sidebar('primary-sidebar') || get_option("ai_starter_theme_force_sidebar_visibility")) {
            return $default_class;
        } else {
            return 'content-full';
        }
    }
}

add_action('after_setup_theme', function() {
    if (!function_exists('ai_starter_theme_get_content_id')) {
        function ai_starter_theme_get_content_id($default_class) {
            return AI_Starter_Theme_Compatibility::ai_starter_theme_get_content_id($default_class);
        }
    }
});