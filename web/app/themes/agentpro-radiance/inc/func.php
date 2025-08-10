<?php 

/*
* Truncate string
* @since 1.0.0
* @param string $string - string to be truncated
* @param int $length - length in characters
* @param $end - (optional) Trailing phrase
*
* @return string
*/
function ai_starter_theme_truncate_string($string,$length,$end="...") {
    if ( strlen($string) > $length ) {
        return substr($string,0,$length) . $end;
    }
    return $string;
}

/*
* Get content area class. Automatically uses 'content-full' if sidebar is empty.
* Assumes that sidebar id is 'primary-sidebar'.
* @since 1.0.0
* @param string $default_class - class to use if overriding is unnecessary
*
* @return string
*/

function ai_starter_theme_get_content_id( $default_class ) {

    if ( is_active_sidebar( 'primary-sidebar' ) || get_option("ai_starter_theme_force_sidebar_visibility") ) {
            return $default_class;
    }
    else {
            return 'content-full';
    }
}

/**
 * Before Inner Content
 * @since 1.0.0
*/
function aios_starter_theme_before_inner_page_content() {
    do_action( 'aios_starter_theme_before_inner_page_content' );
}

/**
 * Starter Entry Content
 * @since 1.0.0
*/
function aios_starter_theme_before_entry() {
    do_action( 'aios_starter_theme_before_entry' );
}
/**
 * After Inner Content
 * @since 1.0.0
*/
function aios_starter_theme_after_entry_content() {
    do_action( 'aios_starter_theme_after_entry_content' );
}