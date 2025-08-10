<?php

function get_home_root()
{
	if (isset($GLOBALS['aios_get_home_root'])) {
		return $GLOBALS['aios_get_home_root'];
	}

	$url_parts = parse_url(home_url());
	$path = isset($url_parts['path']) ? trailingslashit( $url_parts['path'] ) : '/';

	// Set to global variable
	$GLOBALS['aios_get_home_root'] = $path;

	return $path;
}

function get_url_path( $url, $prefix = '' )
{
	$path = (string) parse_url($url, PHP_URL_PATH);
	$path = untrailingslashit($path);

	return ! empty($prefix) && 0 === strpos($path, $prefix) ? substr($path, strlen($prefix)) : '';
}

function get_request_path()
{
	if ( ! isset( $GLOBALS['aios_get_request_path'] ) ) {
		$request_uri = preg_replace( '|//+|', '/', $_SERVER['REQUEST_URI']);
		$GLOBALS['aios_get_request_path'] = get_url_path( $request_uri, get_home_root() );
	}

	return $GLOBALS['aios_get_request_path'];
}

function is_api_request($include_ajax = true, $include_admin_post_php = true)
{
	if ( $include_ajax && is_ajax_request() ) {
		return true;
	}

	if ( $include_admin_post_php && is_admin_post_php_request() ) {
		return true;
	}

	if ( is_rest_api_request() || is_xmlrpc_request() ) {
		return true;
	}

	return false;
}

function is_ajax_request()
{
	if ( function_exists( 'wp_doing_ajax' ) ) {
		return wp_doing_ajax();
	}

	return defined( 'DOING_AJAX' ) && DOING_AJAX;
}

function is_admin_post_php_request()
{
	if ( 'wp-admin/admin-post.php' === get_request_path() ) {
		return true;
	}

	return false;
}

function is_rest_api_request() {
	if (isset($GLOBALS['aios_is_rest_api_request'])) {
		return $GLOBALS['aios_is_rest_api_request'];
	}

	if (! function_exists('rest_get_url_prefix')) {
		$GLOBALS['aios_is_rest_api_request'] = false;

		return false;
	}

	if (defined('REST_REQUEST') && REST_REQUEST) {
		$GLOBALS['aios_is_rest_api_request'] = true;

		return true;
	}

	$home_path = parse_url(get_option('home'), PHP_URL_PATH);
	$home_path = is_null($home_path) ? "" : trim( $home_path, '/' );

	$rest_api_path = $home_path === '' ? '/' . rest_get_url_prefix() . '/' : "/$home_path/" . rest_get_url_prefix() . '/';

	$GLOBALS['aios_is_rest_api_request'] = strpos( $_SERVER['REQUEST_URI'], $rest_api_path ) === 0;

	return $GLOBALS['aios_is_rest_api_request'];
}

function is_xmlrpc_request() {
	return defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST;
}
