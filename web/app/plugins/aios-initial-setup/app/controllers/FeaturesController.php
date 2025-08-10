<?php

namespace AiosInitialSetup\App\Controllers;

class FeaturesController
{
  public function __construct()
  {
    $optimizeFeatures = get_option('aios_optimize_features', []);

		if (isset($optimizeFeatures['remove-version-tag']) && $optimizeFeatures['remove-version-tag'] === "yes") {
			remove_action('wp_head', 'wp_generator');
			add_filter('style_loader_src', [$this, 'removeWpVersion'], 10, 2);
			add_filter('script_loader_src', [$this, 'removeWpVersion'], 10, 2);
		}

		if (isset($optimizeFeatures['remove-shortlink']) && $optimizeFeatures['remove-shortlink'] === "yes") {
			remove_action('wp_head', 'wp_shortlink_wp_head', 10);
			remove_action('template_redirect', 'wp_shortlink_header', 11);
		}

		if (isset($optimizeFeatures['disable-emojis']) && $optimizeFeatures['disable-emojis'] === "yes") {
			remove_action('wp_head', 'print_emoji_detection_script', 7);
			remove_action('wp_print_styles', 'print_emoji_styles');
		}

		if (isset($optimizeFeatures['disable-embeds']) && $optimizeFeatures['disable-embeds'] === "yes") {
			add_action('init', [$this, 'removeEmbeds']);
		}

		if (isset($optimizeFeatures['disable-xmlrpc']) && $optimizeFeatures['disable-xmlrpc'] === "yes") {
			add_filter('wp_xmlrpc_server_class', [$this, 'disableXmlRpcfunction']);
		}

		if (isset($optimizeFeatures['disable-self-pingback']) && $optimizeFeatures['disable-self-pingback'] === "yes") {
			add_action('pre_ping', [$this, 'disableSelfPingback'], 10, 3);
		}

		if (isset($optimizeFeatures['disable-rsd-link']) && $optimizeFeatures['disable-rsd-link'] === "yes") {
			remove_action('wp_head', 'rsd_link');
		}

		if (isset($optimizeFeatures['disable-rss-feed']) && $optimizeFeatures['disable-rss-feed'] === "yes") {
			add_action('do_feed', [$this, 'disableAllFeeds'], 1);
			add_action('do_feed_rdf', [$this, 'disableAllFeeds'], 1);
			add_action('do_feed_rss', [$this, 'disableAllFeeds'], 1);
			add_action('do_feed_rss2', [$this, 'disableAllFeeds'], 1);
			add_action('do_feed_atom', [$this, 'disableAllFeeds'], 1);
			add_action('do_feed_rss2_comments', [$this, 'disableAllFeeds'], 1);
			add_action('do_feed_atom_comments', [$this, 'disableAllFeeds'], 1);
		}

		if (isset($optimizeFeatures['remove-rss-links']) && $optimizeFeatures['remove-rss-links'] === "yes") {
			remove_action('wp_head', 'feed_links', 2);
			remove_action('wp_head', 'feed_links_extra', 3);
		}
		
		if (isset($optimizeFeatures['remove-wlw-manifest']) && $optimizeFeatures['remove-wlw-manifest'] === "yes") {
			remove_action('wp_head', 'wlwmanifest_link');
		}
		
		if (isset($optimizeFeatures['disable-rest-api']) && $optimizeFeatures['disable-rest-api'] === "yes") {
			add_filter('rest_authentication_errors', [$this, 'disableRestApi']);
		}
		
		if (isset($optimizeFeatures['remove-rest-api-link']) && $optimizeFeatures['remove-rest-api-link'] === "yes") {
			remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
			remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
		}
  }

	public function removeWpVersion($src, $handle) {
    return $this->removeAssetVersion($src);
	}

	private function removeAssetVersion($src)
	{
		$parsed = parse_url($src);

		if (empty($parsed['scheme'])) {
			$src = htmlspecialchars_decode($src);
		} else {
			// Decoding HTML Characters and replacing double slash to single
			$src = preg_replace('/(?<!:)\/\//', '/', htmlspecialchars_decode($src));
		}

		if (strpos($src, 'ver=')) {
			$src = remove_query_arg('ver', $src);
		}

		return $src;
	}

	public function disableXmlRpcfunction ($data) {
		http_response_code(403);
		exit('You dont have permission to access this file!');
	}

	public function disableSelfPingback (&$post_links, &$pung, int $post_ID) {
		foreach ($post_links as $key => $link) {
			if (0 === strpos($link, home_url())) {
				unset($post_links[$key]);
			}
		}
	}

	public function removeEmbeds() {
		remove_action('rest_api_init', 'wp_oembed_register_route');
		add_filter('embed_oembed_discover', '__return_false');
		remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
		remove_action('wp_head', 'wp_oembed_add_discovery_links');
		remove_action('wp_head', 'wp_oembed_add_host_js');
		add_filter('rewrite_rules_array', [$this, 'disable_embeds_rewrites']);
		remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);
	}

	public function disable_embeds_rewrites($rules) {
    foreach($rules as $rule => $rewrite) {
        if(false !== strpos($rewrite, 'embed=true')) {
            unset($rules[$rule]);
        }
    }
    return $rules;
	}

	public function disableAllFeeds() {
		wp_die( __( 'No feed available, please visit the <a href="'. esc_url( home_url( '/' ) ) .'">homepage</a>!' ) );
	}

	public function disableRestApi($access) { 
		if (!is_user_logged_in()) {		
			$message = apply_filters('disable_wp_rest_api_error', __('REST API restricted to logged in users.', 'disable-wp-rest-api'));
			return new \WP_Error('rest_login_required', $message, ['status' => rest_authorization_required_code()]);		
		}	
		
		return $access;	
	}
}

new FeaturesController();
