<?php

namespace AiosInitialSetup\App\Modules\HideBackend;

class Module
{
	private $disable_filters = false;
	private $token_var = 'aios-login-token';

	public function __construct()
	{
		add_action('setup_theme', [$this, 'handle_specific_page_requests']);

		add_filter('site_url', [$this, 'filter_generated_url'], 100, 2 );
		add_filter('admin_url', [$this, 'filter_admin_url'], 100, 2 );
		add_filter('wp_redirect', [$this, 'filter_redirect']);
		add_filter('comment_moderation_text', [$this, 'filter_comment_moderation_text']);

		remove_action( 'template_redirect', 'wp_redirect_admin_locations', 1000 );
	}

	/**
	 * handle page request
	 */
	public function handle_specific_page_requests()
	{
		if (is_api_request()) {
			return;
		}

		$request_path = get_request_path();

		if ( strpos( $request_path, '/' ) !== false ) {
			list( $request_path ) = explode( '/', $request_path );
		}

		$check = array_unique(array(
			$request_path,
			urldecode($request_path),
			ltrim(substr($_SERVER['SCRIPT_FILENAME'], strlen(ABSPATH)), '/')
		));

		foreach ($check as $path) {
			$this->handle_request_path($path);
		}
	}

	private function handle_request_path($request_path) {
		if ($request_path === AIOS_LOGIN_URL) {
			$this->do_redirect_with_token( 'login', 'wp-login.php' );
		} elseif ( in_array( $request_path, array( 'wp-login', 'wp-login.php' ) ) ) {
			$this->handle_canonical_login_page();
		} elseif ('wp-admin' === $request_path || strpos( $request_path, 'wp-admin/' ) === 0) {
			$this->handle_wp_admin_page();
		} elseif ( 'wp-signup.php' === $request_path ) {
			$this->handle_canonical_signup_page();
		}
	}

	private function handle_canonical_login_page() {
		$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

		if ('postpass' === $action) {
			return;
		}

		if ('register' === $action) {
			return;
		}

		$this->block_access('login');
	}

	private function handle_wp_admin_page() {
		$request_path = get_request_path();

		if ('wp-admin/maint/repair.php' === $request_path && defined('WP_ALLOW_REPAIR')) {
			return;
		}

		$this->block_access( 'login' );
	}

	private function handle_canonical_signup_page() {
		$this->block_access( 'register' );
	}

	public function block_access( $type = 'login' ) {
		if (is_user_logged_in() || $this->is_validated($type)) {
			return;
		}

		wp_redirect( get_home_root() . 'not-found', 302 );
		exit;
	}

	private function is_validated($type) {
		if ( isset( $_REQUEST[ $this->token_var ] ) && wp_verify_nonce($_GET[ $this->token_var ], 'aios-login') ) {
			$this->set_cookie( $type, $_GET[ $this->token_var ] );

			return true;
		} elseif ( isset( $_COOKIE[ "aios-$type-" . COOKIEHASH ] ) ) {
			return true;
		}

		return false;
	}

	private function set_cookie( $type, $token, $duration = 1440 ) {
		$expires = time() + $duration;
		setcookie( "aios-$type-" . COOKIEHASH, $token, $expires, get_home_root(), COOKIE_DOMAIN, is_ssl(), true );
	}

	public function filter_generated_url( $url, $path ) {
		if ( $this->disable_filters ) {
			return $url;
		}

		list($clean_path) = explode('?', $path);

		if ('wp-login.php' === $clean_path && 'wp-login.php' !== AIOS_LOGIN_URL) {

			$request_path = get_request_path();

			if ( false !== strpos( $path, 'action=postpass' ) ) {
				// No special handling is needed for a password-protected post.
				return $url;
			} elseif ( false !== strpos( $path, 'action=register' ) ) {
				$url = $this->add_token_to_url( $url, 'register' );
			} elseif ( false !== strpos( $path, 'action=rp' ) ) {
				$url = $this->add_token_to_url( $url, 'login' );
			} elseif ( 'wp-login.php' !== $request_path || empty( $_REQUEST['action'] ) || 'register' !== $_REQUEST['action'] ) {
				$url = $this->add_token_to_url( $url, 'login' );
			}
		} elseif ( 'wp-signup.php' === $clean_path && 'wp-signup.php' !== 'wp-signup.php' ) {
			$url = $this->add_token_to_url( $url, 'register' );
		}

		return $url;
	}

	private function add_token_to_url( $url, $type ) {
		$url .= ( false === strpos( $url, '?' ) ) ? '?' : '&';
		$url .= $this->token_var . '=' . urlencode($_GET[ $this->token_var ] ?? '');

		return $url;
	}

	public function filter_admin_url( $url, $path ) {
		if ( 0 === strpos( $path, 'profile.php?newuseremail=' ) ) {
			$url = $this->add_token_to_url( $url, 'login' );
		}

		return $url;
	}

	public function filter_redirect( $location ) {
		return $this->filter_generated_url( $location, $location );
	}

	public function filter_comment_moderation_text( $text ) {
		if ( $this->disable_filters ) {
			return $text;
		}

		// The email is plain text and the links are at the end of lines, so a lazy match can be used.
		if ( preg_match_all( '|(https?:\/\/((.*)wp-admin(.*)))|', $text, $urls ) ) {
			foreach ( $urls[0] as $url ) {
				$url  = trim( $url );
				$text = str_replace( $url, $this->get_login_url( '', $url ), $text );
			}
		}

		return $text;
	}

	private function get_login_url( $action = '', $redirect = '', $scheme = 'login' ) {
		if ( 'login_post' === $scheme || ( $action && 'login' !== $action ) ) {
			$url = 'wp-login.php';

			if ( $action ) {
				$url = add_query_arg( 'action', urlencode( $action ), $url );
			}

			if ( $redirect ) {
				$url = add_query_arg( 'redirect_to', urlencode( $redirect ), $url );
			}

			$url = site_url( $url, $scheme );
		} else {
			$url = wp_login_url( $redirect );

			if ( $action ) {
				$url = add_query_arg( 'action', urlencode( $action ), $url );
			}
		}

		return apply_filters( 'aios_login_url', $url, $action, $redirect, $scheme );
	}

	private function do_redirect_with_token( $type, $path ) {
		$nonce = wp_create_nonce('aios-login');

		$this->set_cookie( $type, $nonce );

		// Preserve existing query vars and add access token query arg.
		$query_vars = $_GET;
		$query_vars[ $this->token_var ] = $nonce;
		$query = http_build_query( $query_vars, '', '&' );

		// Disable the Hide Backend URL filters to prevent infinite loops when calling site_url().
		$this->disable_filters = true;

		if ( false === strpos( $path, '?' ) ) {
			$url = site_url( "$path?$query" );
		} else {
			$url = site_url( "$path&$query" );
		}

		wp_redirect( $url );
		exit;
	}

}

new Module();
