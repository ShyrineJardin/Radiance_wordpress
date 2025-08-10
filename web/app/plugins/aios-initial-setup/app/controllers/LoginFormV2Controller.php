<?php

namespace AiosInitialSetup\App\Controllers;

use AiosInitialSetup\Helpers\Classes\InternetProtocol;
use WP_Error;

class LoginFormV2Controller
{
	/**
	 * LoginFormV2Controller constructor.
	 */
	public function __construct()
	{
		if ( IS_LOGIN_PAGE ) {
			// Assets
			add_action('login_init', [$this, 'enqueue_assets']);

			// Header content
			add_action('login_head', [$this, 'head_content'], 8);

			// Add captcha
			add_filter('login_form', [$this, 'add_captcha']);

			// Verify captcha
			add_filter('wp_authenticate_user', [$this, 'verify_captcha'], 30, 2);

			// Error messages
			add_filter('login_errors', [$this, 'errors'], 500);

			// Password Strength
			add_action('login_init', [$this, 'strength_meter_localize_script'], 20);
		}
	}

	/**
	 * Enqueue Assets
	 */
	public function enqueue_assets() {
    	$cdnUrl = cdnDomainSwitcher();

		// Recaptcha
		$captchaScreen = get_option('aios_custom_login_captcha', 'default');

		if ($captchaScreen !== 'default' && $captchaScreen !== 'show') {
			$captchaScreenRecaptcha = get_option('aios_custom_login_recaptcha', '');

			// Check if there's a key
			if (isset($captchaScreenRecaptcha['site_key']) && isset($captchaScreenRecaptcha['secret_key'])) {
				$isRecaptchaV3 = $captchaScreen === 'google-recaptcha-v3' ? "?render={$captchaScreenRecaptcha['site_key']}" : '';
				wp_enqueue_script('recatpcha', "https://www.google.com/recaptcha/api.js{$isRecaptchaV3}");
			}
		}

		$productSelected = get_option('aios_custom_login_screen');
		if ( $productSelected != 'default' ){
			// Default Assets
			wp_deregister_style('login');
			wp_enqueue_style( 'dashicons' );

			if ((int) get_option('aios_tdp_labs', 0) === 1) {
				wp_enqueue_style('google-mulish', 'https://fonts.googleapis.com/css2?family=Mulish:wght@400;700&display=swap');
				wp_enqueue_style('google-playfair', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&display=swap');
			} else {
				wp_enqueue_style('google-montserrat', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap');
			}

			wp_enqueue_style('agentimage-font', "$cdnUrl/font-icons/agentimage.font.icons.css");
			wp_enqueue_script('login-runtime', "$cdnUrl/libraries/js/runtime.min.js");
			wp_enqueue_style('login-custom', AIOS_INITIAL_SETUP_URL . 'resources/css/login.min.css');
			wp_enqueue_script('login-custom', AIOS_INITIAL_SETUP_URL . 'resources/js/login.min.js');
			wp_localize_script('login-custom', 'login_object', [
				'url' => wp_login_url(),
				'action' => ! is_null($_GET['checkemail']) ? $_GET['checkemail'] : $_GET['action'],
				'is_tdp' => (int) get_option('aios_tdp_labs', 0) === 1
			]);
		}
	}

	/**
	 * Add UI style such as background-image depends on the product type
	 */
	public function head_content()
	{
    	$cdnUrl = cdnDomainSwitcher();
		$cdn = "$cdnUrl/images";

		if ((int) get_option('aios_tdp_labs', 0) === 1) {
			$productType = 'thedesignpeople';
		} else {
			$productType = get_option('aios_custom_login_screen');
			$productType = ! empty($productType) ? $productType : 'semicustom';
		}

		switch ($productType) {
			case 'imaginestudio':
			case 'semicustom':
				$backgroundImage = 'wp-login-sc-is.jpg';
				break;
			case 'thedesignpeople':
				$backgroundImage = 'wp-login-reduxlabs-pattern.jpg';
				break;
			case 'true-custom':
				$backgroundImage = 'wp-login-custom.jpg';
				break;
			default:
				$backgroundImage = 'wp-login-aix-ap.jpg';
				break;
		}

		
		echo "<style type=\"text/css\">
		" . ($productType !== 'thedesignpeople' ? '@font-face {
  font-family: \'Termina Demi\';
  src: url(\'' . $cdnUrl . '/marketing/fonts/termina-demi-webfont.woff2\') format(\'woff2\'),
  url(\'' . $cdnUrl . '/marketing/fonts/termina-demi-webfont.woff\') format(\'woff\');
  font-weight: normal;
  font-style: normal;
  font-display: swap;
}' : '') . "

:root {
  --brand-color: " . ($productType !== 'thedesignpeople' ? '#009BBB' : '#011c53') . ";
  --brand-color-hover: " . ($productType !== 'thedesignpeople' ? '#008EAB' : '#44a1e7') . ";
  --font-default: " . ($productType !== 'thedesignpeople' ? '\'Montserrat\', sans-serif' : '\'Mulish\', sans-serif') . ";
  --font-title: " . ($productType !== 'thedesignpeople' ? '\'Montserrat\', sans-serif' : '\'Playfair Display\', sans') . ";
  --font-button: " . ($productType !== 'thedesignpeople' ? '\'Termina Demi\', sans-serif' : '\'Mulish\', sans-serif') . ";
}
#cover-photo {
	background-image: url({$cdn}/{$backgroundImage}) !important;
}	
</style>";


		if ( $productType === 'default' ) {
			echo "<style type=\"text/css\">
				#continue-with-facebook{
					width: 100% !important;
				}

				#continue-with-facebook #continue-with-fb{
					font-size: 16px !important;
				}
				#continue-with-facebook #continue-with-fb #aidash-facebook {
					width: 20px !important;
					height: 20px !important;
				}
				#continue-with-facebook .hr-text em{
					font-size: 16px !important;
				}
			</style>";
		}

		// Destroy cookies on login page
		echo '<script>
	var date = new Date();
	date.setTime( date.getTime() + (-1000 * 60 * 60 * 1000) );
	expires = "; expires=" + date.toUTCString();
	document.cookie = "aioswp_6c6f63616c2d69702d61646472657373=" + false + expires + "; path=/";
</script>';
	}

	/**
	 * Add captcha
	 */
	public function add_captcha()
	{
		// Recaptcha
		$captchaScreen = get_option('aios_custom_login_captcha', 'default');

		if ($captchaScreen !== 'default' && $captchaScreen !== 'show') {
			$captchaScreenRecaptcha = get_option('aios_custom_login_recaptcha', '');

			if (isset($captchaScreenRecaptcha['site_key']) && isset($captchaScreenRecaptcha['secret_key'])) {
				if ($captchaScreen === 'google-recaptcha-v3') {
					echo "<input type=\"hidden\" name=\"g-recaptcha-response\" id=\"g-recaptcha\" data-sitekey=\"{$captchaScreenRecaptcha['site_key']}\" data-version=\"3\">";
				} else {
					echo "<div id=\"g-recaptcha\" data-sitekey=\"{$captchaScreenRecaptcha['site_key']}\" data-callback=\"recaptchaCallback\"></div>
						<script type='text/javascript'>
							function recaptchaCallback() {
								document.getElementById('user_login').dispatchEvent(new Event('keyup'))
							}
						</script>
					";
				}
			}
		} else {
			$uniqueId = $this->unique_id();

			echo "<p class=\"basic-captcha\">
	<input type=\"checkbox\" name=\"session_token\" id=\"session_token\" value=\"{$uniqueId}\" size=\"20\" required>
	<label for=\"session_token\">I'm not a robot</label>
</p>";
		}
	}

	/**
	 * Verify captcha
	 *
	 * @param $user
	 * @param $password
	 * @return WP_Error
	 */
	public function verify_captcha($user, $password)
	{
		$captchaScreen = get_option('aios_custom_login_captcha', 'default');
		$message = 'Please verify that you are not a robot!';

		if ($captchaScreen !== 'default' && $captchaScreen !== 'show') {
			$captchaScreenRecaptcha = get_option('aios_custom_login_recaptcha', '');
			$recaptchaResponse = $_POST['g-recaptcha-response'];
			$recaptchaSecret = $captchaScreenRecaptcha['secret_key'] ?? '';
			$response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}");
			$response = json_decode($response['body'], true);

			if (true == $response['success']) {
				return $user;
			}
		} else {
			// Verify manual robot
			$sessionToken = $_POST['session_token'];
			$rememberMe = $_POST['remember_me'];

			if (isset($sessionToken)) {
				if ($this->unique_id($sessionToken, $rememberMe)) {
					return $user;
				}
			}
		}

		return new WP_Error('user_not_verified', $message);
	}

	/**
	 * Creates and gets unique ID for login user.
	 *
	 * This will prevent a race condition if multiple people try to login at the same time.
	 *
	 * @access private
	 * @param string $session_token optional If set, it will get unique id from transients. If
	 *     not set, it will generate one.
	 * @param bool $remember_me
	 * @return bool|string
	 */
	private function unique_id($session_token = '', $remember_me = false)
	{
		if (! isset($session_token)) {
			$session_token = '';
		}

		$key_length   = 12;
		$uniqid_length = 64;
		$transient_expires = $remember_me ? YEAR_IN_SECONDS : 10 * 60 * 60;

		if (! $session_token) {
			// generate new uniqid. This should be unique for all users who request wp-login form.
			$key = bin2hex(openssl_random_pseudo_bytes($key_length));
			$uniqid = bin2hex(openssl_random_pseudo_bytes($uniqid_length));

			$transient_name = 'auth_uniqid_' . $key;
			$transient_value = $key . $uniqid;

			set_transient($transient_name, $transient_value, $transient_expires);

			return $transient_value;
		} else {
			// need to get the uniqid
			// bin2hex doubles the key length
			$transient_name = 'auth_uniqid_' . substr($session_token, 0, ($key_length * 2));
			$transient_value = get_transient($transient_name);

			if ($transient_value == $session_token) {
				return true;
			} else {
				// transient is either wrong or expired. Either way, let's clean it up.
				delete_transient($transient_name);
				return false;
			}
		}
	}

	/**
	 * Display error
	 *
	 * @param $error
	 * @return string
	 */
	public function errors($error)
	{
		global $errors;

		// Return if error is null and login is correct for custom plugins
		if (is_null($errors)) {
			return $error;
		}

		$err_codes = $errors->get_error_codes();
		$internetProtocol = new InternetProtocol();
		$tries = 5;

		if (! $internetProtocol->whitelist_ip()) {
			$post = get_posts( array( 'title' => $internetProtocol->isp(), 'post_type' => 'aios-login-attempts' ));
			if (! empty($post[0]->ID)) {
				$attempts = get_post_meta($post[0]->ID, 'attempts', true);
				$attempts = ! empty($attempts) ? $attempts : 0;
				$attempts = 5 - $attempts;
				$tries = $attempts < 0 ? 0 : $attempts;
			}
		}

		if (
			in_array('invalid_username', $err_codes) ||
			in_array('incorrect_password', $err_codes) ||
			in_array('authentication_failed', $err_codes)
		) {
			$error = "<strong>ERROR</strong>: Invalid Credentials. {$tries} attempts left.<br><br> 
			<a href=".get_home_url()."/wp-login.php?action=lostpassword><strong>Lost your password?</strong></a> You can contact our support for assistance 1.877.317.4111<br>";
		}

		return $error;
	}

	/**
	 * Password Meter
	 */
	public function strength_meter_localize_script() {
		wp_localize_script('password-strength-meter', 'pwsL10n', [
			'unknown'    => 'Empty',
			'empty'    => 'Empty',
			'short'    => 'Too weak',
			'bad'      => 'Weak',
			'good'     => 'Could be stronger',
			'strong'   => 'Strong password',
			'mismatch' => 'Mismatch',
		]);
	}
}

new LoginFormV2Controller();
