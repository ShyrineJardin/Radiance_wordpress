<?php

namespace AiosInitialSetup\App\Controllers;

use AiosInitialSetup\App\Http\Request;
use AiosInitialSetup\Config\Assets;

class FrontendController
{
	use Assets;

	private $enqueue_cdn;
	private $quick_search;
	private $handlers;
	private $global_assets = null;

	/**
	 * FrontendEnqueue constructor.
	 */
	public function __construct()
	{
		$this->enqueue_cdn = $this->enqueue_options();
		$this->quick_search = $this->quick_search_options();
		$this->handlers = $this->enqueue_separated_names($this->enqueue_cdn);

		add_action('wp_default_scripts', [$this, 'replace_scripts'], -1);
		add_action('wp_enqueue_scripts', [$this, 'enqueueCdnLibraries']);
		add_action('wp_enqueue_scripts', [$this, 'pagesAssets']);
		add_filter('script_loader_tag', [$this, 'scriptFilter'], 10, 2);
		add_action('wp_print_styles', [$this, 'initialSetupInlineStyles']);
		add_filter('body_class', [$this, 'navigateOnSameDomainAndPostTypeSlug'], 11);
		add_action('wp_footer', [$this, 'append_html_footer'], 10);
		add_filter('wp_lazy_loading_enabled', '__return_false');
		add_action('init', [$this, 'removeParentThemeActions'], 99);

		if (! shortcode_exists('wp_nav_menu')) {
			add_shortcode( 'wp_nav_menu', [$this, 'navShortCode']);
		}

		add_filter('wp_nav_menu_objects', [$this, 'subMenuLimitShortCode'], 10, 2);
		add_action('template_redirect', [$this, 'redirect_attachment_page'], 2);
		add_filter('template_include', [$this, 'page_not_found_template'], 11);
		add_action('wp_footer', [$this, 'append_html_head'], 100);

		if (get_option('aios_auto_p_metabox') !== false) {
			add_action('the_post', [$this, 'remove_auto_paragraph']);
		}

		add_action('wp_head', [$this, 'addSchemaNavigationAndEmbedScripts']);
		add_action('after_setup_theme', [$this, 'remove_rest_api_link']);
	}

	/**
	 * Replace jQuery Scripts
	 */
	public function replace_scripts($scripts)
	{
		$jQueryMigrate = get_option('aios-jquery-migrate', []);

		if ((is_admin() && (isset($jQueryMigrate['admin']) && $jQueryMigrate['admin'] === '1')) || (!is_admin() && (!isset($jQueryMigrate['frontend']) || ($jQueryMigrate['frontend'] !== '1')))) {
			$this->jquery_assets($scripts);
		}
	}

	/**
	 * Enqueue CDN libraries.
	 */
	public function enqueueCdnLibraries() {
		// Is migrated?
		$jQueryMigrate = get_option('aios-jquery-migrate', []);
		$useLegacyJquery = ! isset($jQueryMigrate['frontend']) || $jQueryMigrate['frontend'] !== '1';

		// Enqueue Required Assets
		$this->enqueue_required_assets($this->enqueue_cdn);
		$this->enqueue_default_assets($useLegacyJquery);
		$this->enqueue_separated_assets($this->handlers, $this->quick_search);

		if ($this->quick_search['enabled'] ?? '' !== '') {
			$localize_handler_name = is_null($this->global_assets) ? 'aios-quick-search-js' : 'aios-merged-resources';
			wp_localize_script($localize_handler_name, 'aios_qs_ajax', [get_home_url() . '/31jislt2xAmlqApY8aDhWbCzmonLuOZp']);
		}

		// Disable comments
		wp_dequeue_script('comment-reply');
	}

	/**
	 * Enqueue CDN libraries.
	 */
	public function pagesAssets() {
		// Enqueue generate page css
		$generatePages = get_option('aios-generate-pages', []);

		if (! empty($generatePages)) {
			if (isset($generatePages['about'])) {
				wp_enqueue_style('aios-generated-about-page', AIOS_INITIAL_SETUP_RESOURCES . "css/{$generatePages['about']}.min.css");
			}

			if (isset($generatePages['contact'])) {
				wp_enqueue_style('aios-generated-contact-page', AIOS_INITIAL_SETUP_RESOURCES . "css/{$generatePages['contact']}.min.css");
			}
		}
	}

	/**
	 * Add custom attributes to enqueued scripts
	 *
	 * @param $tag
	 * @param $handle
	 * @return mixed
	 */
	public function scriptFilter($tag, $handle) {
		if ($handle === 'aios-picturefill') {
			$tag = str_replace(' src', ' async src', $tag);
		} elseif ($handle === 'aios-lazysizes') {
			$tag = str_replace(' src', ' async src', $tag);
		}

		return $tag;
	}

	/**
	 * Enqueue scripts and styles for initial setup sub page
	 */
	public function initialSetupInlineStyles() {
		$cf7_style = '';
		$cf7_bg = get_option('cf7_bg', '');
		$cf7_bg_hover = get_option('cf7_bg_hover', '');
		$cf7_text = get_option('cf7_text', '');
		$cf7_text_hover = get_option('cf7_text_hover', '');
		$cf7_response_style = get_option('cf7_response_style', '');

		$focus_indicator = (empty($cf7_response_style['focus-indicator']) ? '#66afe9' : $cf7_response_style['focus-indicator']);

		$cf7_style .= '<style>';
			$cf7_style .= '.ai-contact-wrap input.wpcf7-submit,
			    .ai-default-cf7wrap input.wpcf7-submit,
			    .error-forms input.wpcf7-submit {
			      background: '. (empty($cf7_bg) ? '#444444' : $cf7_bg) .' !important;
			      color: '. (empty($cf7_text) ? '#ffffff' : $cf7_text) .' !important;
			    }
			    
			    .ai-contact-wrap input.wpcf7-submit:hover,
			    .ai-default-cf7wrap input.wpcf7-submit:hover,
			    .error-forms input.wpcf7-submit:hover {
			      background: '. (empty($cf7_bg_hover) ? '#444444' : $cf7_bg_hover) .' !important;
			      color: '. (empty($cf7_text_hover) ? '#ffffff' : $cf7_text_hover) .' !important;
			    }';

			if (! empty($cf7_response_style)) {
				$cf7_style .= 'div.wpcf7-response-output,
					.wpcf7 form .wpcf7-response-output {
						color: ' . $cf7_response_style['text-color'] . ' !important;
						border: 2px solid ' . $cf7_response_style['border-color'] . ' !important;
					}
					
					div.wpcf7-mail-sent-ok,
						.wpcf7 form.sent .wpcf7-response-output {
						border: 2px solid ' . $cf7_response_style['success-border-color'] . ' !important;
					}
					
					div.wpcf7-mail-sent-ng,
					div.wpcf7-aborted,
					.wpcf7 form.failed .wpcf7-response-output,
					.wpcf7 form.aborted .wpcf7-response-output{
						border: 2px solid ' . $cf7_response_style['border-color'] . ' !important;
					}
					
					div.wpcf7-spam-blocked,
					.wpcf7 form.spam .wpcf7-response-output{
						border: 2px solid ' . $cf7_response_style['spam-border-color'] . ' !important;
					}
					
					div.wpcf7-validation-errors,
					div.wpcf7-acceptance-missing,
					.wpcf7 form.invalid .wpcf7-response-output,
					.wpcf7 form.unaccepted .wpcf7-response-output{
						border: 2px solid ' . $cf7_response_style['error-border-color'] . ' !important;
					}
					
					span.wpcf7-not-valid-tip {
						color: ' . $cf7_response_style['border-color'] . ' !important;
					}
					
					
					.use-floating-validation-tip span.wpcf7-not-valid-tip {
						border: 1px solid ' . $cf7_response_style['validation-tip-border-color'] . ' !important;
						background: ' . $cf7_response_style['validation-tip-background-color'] . ' !important;
						color: ' . $cf7_response_style['validation-tip-text-color'] . ' !important;
					}';
			}
				$cf7_style .= '
					.ai-default-cf7wrap input[type="text"]:focus, 
					.ai-default-cf7wrap input[type="tel"]:focus, 
					.ai-default-cf7wrap input[type="email"]:focus,
					.ai-default-cf7wrap select:focus,
					.ai-default-cf7wrap textarea:focus,
					.error-page-content-wrapper .error-forms input[type=text]:focus, 
					.error-page-content-wrapper .error-forms input[type=email]:focus, 
					.error-page-content-wrapper .error-forms input[type=phone]:focus,
					.error-page-content-wrapper .error-forms textarea:focus{
						border-color: '.$focus_indicator.';
						outline: 0;
						-webkit-box-shadow: inset 0 1px 1px '.$focus_indicator.', 0 0 8px '.$focus_indicator.';
						box-shadow: inset 0 0 1px '.$focus_indicator.', 0 0 8px '.$focus_indicator.';
					}';
		$cf7_style .= '</style>';
		echo $cf7_style;
	}

	/**
	 * Add class of post type and post name
	 * Add class if http referrer is same domain
	 *
	 * @param $classes
	 * @return array
	 */
	public function navigateOnSameDomainAndPostTypeSlug($classes)
	{
		global $post;
		if (isset($post)) {
			$classes[] = "post-{$post->post_type}-{$post->post_name}";
		}

		if (isset($_SERVER['HTTP_REFERER'])) {
			if (strpos($_SERVER['HTTP_REFERER'], home_url()) !== false) {
				$classes[] = 'user-navigated-from-a-page-on-the-site';
			}
		}

		return $classes;
	}

	/**
	 * Add fallback for caching enabled "if site referer same domain"
	 */
	public function append_html_footer()
	{
		echo '<script>
			var docRef = (  document.referrer == undefined ? "" :  document.referrer );
			if ( document.referrer.indexOf( "' . home_url() . '" ) !== -1 && !document.body.classList.contains( "user-navigated-from-a-page-on-the-site" ) ) document.body.className += " user-navigated-from-a-page-on-the-site";
		</script>';

		// Back to top
		$option = get_option('aios-back-top', []);
		if (isset($option['enabled']) && $option['enabled'] === "1") {
			$displayOnPageOnly = isset($option['pages']) ? $option['pages'] : 'all';

			$text = isset($option['text']) 
				? $option['text'] : "<span style=\"position: absolute;width: 1px;height: 1px;padding: 0;margin: -1px;overflow: hidden;clip: rect(0, 0, 0, 0);white-space: nowrap;border-width: 0;\">Back to Top</span>";

			$icon = "";

			if (isset($option['icon'])) {
				switch ($option['icon']) {
					case 'arrow-1':
						$icon = "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\">
							<path d=\"M7 14.5L12 9.5L17 14.5\" stroke=\"currentColor\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>
						</svg>";
						break;
						
					case 'arrow-2':
						$icon = "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\" >
							<g id=\"aios-back-top-arrow\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\">
								<g id=\"add\" fill=\"currentColor\" transform=\"translate(134.186667, 172.586667)\">
									<polygon id=\"arrowhead-up\" points=\"213.333333 151.893333 121.813333 60.16 30.2933333 151.893333 2.84217094e-14 121.6 121.813333 0 243.626667 121.6\"></polygon>
								</g>
							</g>
						</svg>";
						break;
						
					case 'arrow-3':
						$icon = "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\">
							<path d=\"M17 18L12 13L7 18M17 11L12 6L7 11\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>
						</svg>";
						break;
						
					case 'image':
						$icon = "<img src=\"" . $option['image-icon'] . "\" alt=\"back to top\" width=\"" . $option['width'] . "\" height=\"" . $option['height'] . "\" />";
						break;
						
					case 'hide':
						$icon = "";
						break;
					
					default:
						$icon = "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\">
							<path d=\"M6 15L12 9L18 15\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>
						</svg>";
						break;
				}
			}

			$output = "<button type=\"button\" id=\"aios-btt-btn\" class=\"btt-hide\">$icon $text</button>
			<script type=\"text/javascript\">
    var scrollToTopButton = document.getElementById('aios-btt-btn');
    var scrollOffset = " . (isset($option['offset-y']) ? $option['offset-y'] : "100") . ";
    var scrollTransition = " . (isset($option['transition']) ? $option['transition'] : "5") . ";

    var scrollFunc = () => {
        let y = window.scrollY;
        if (y > scrollOffset) {
            scrollToTopButton.className = \"btt-show\";
        } else {
            scrollToTopButton.className = \"btt-hide\";
        }
    };

    window.addEventListener(\"scroll\", scrollFunc);

    var scrollToTopAnimation = null;
    var isScrollingToTop = false;

    function stopScrollToTop() {
        if (scrollToTopAnimation !== null) {
            cancelAnimationFrame(scrollToTopAnimation);
            scrollToTopAnimation = null;
            isScrollingToTop = false;
        }
    }

    ['wheel', 'touchstart', 'keydown'].forEach(function(evt) {
        window.addEventListener(evt, function(e) {
            // Only stop if animation is running
            if (isScrollingToTop) stopScrollToTop();
        }, {passive:true});
    });

    function scrollToTop() {
        isScrollingToTop = true;
        var c = document.documentElement.scrollTop || document.body.scrollTop;
        if (c > 0) {
            scrollToTopAnimation = window.requestAnimationFrame(scrollToTop);
            window.scrollTo(0, c - c / scrollTransition);
        } else {
            stopScrollToTop();
        }
    }

    scrollToTopButton.onclick = function(e) {
        e.preventDefault();
        stopScrollToTop();
        scrollToTop();
    };
</script>";

			if ($displayOnPageOnly === "all") {
				echo $output;
			} else {
				if ($displayOnPageOnly === "home" && is_home()) {
					echo $output;
				} else if ($displayOnPageOnly === "innerpages" && !is_home()) {
					echo $output;
				}
			}
		}
	}

	/**
	 * Remove Breadcrumb from Content
	 */
	public function removeParentThemeActions()
	{
		$aios_metaboxes_breadcrumb = get_option('aios-metaboxes-breadcrumb', 0);

		if ($aios_metaboxes_breadcrumb) {
			global $aios_starter_theme_hook_action;
			remove_filter('aios_starter_theme_before_inner_page_content_filter', [$aios_starter_theme_hook_action, 'aios_starter_theme_add_breadcrumbs']);
		}
	}

	/**
	 * Create shortcode of wp_nav_menu()
	 *
	 * @param $atts
	 * @return false|string
	 */
	public function navShortCode($atts)
	{
		ob_start();
		wp_nav_menu($atts);
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/**
	 * Add 'submenu' option to wp_nav_menu
	 *
	 * @param $items
	 * @param $args
	 * @return mixed
	 */
	public function subMenuLimitShortCode($items, $args)
	{
		if (empty($args->submenu)) {
			return $items;
		}

		$object_list = wp_filter_object_list($items, ['title' => $args->submenu], 'and', 'ID');
		$parent_id = array_pop($object_list);
		$children  = $this->subMenuGetChildrenID($parent_id, $items);

		foreach ($items as $key => $item) {
			if (! in_array($item->ID, $children)) {
				unset($items[$key]);
			}
		}

		return $items;
	}

	/**
	 * callback: subMenuLimitShortCode
	 *
	 * @param $id
	 * @param $items
	 * @return array
	 */
	public function subMenuGetChildrenID($id, $items)
	{
		$ids = wp_filter_object_list($items, ['menu_item_parent' => $id], 'and', 'ID');
		foreach ($ids as $id) {
			$ids = array_merge($ids, $this->subMenuGetChildrenID($id, $items));
		}
		return $ids;
	}

	/**
	 * Add Actions.
	 * @return bool
	 */
	public function redirect_attachment_page()
	{
		if (! is_attachment()) {
			return false;
		}

		$url = wp_get_attachment_url(get_queried_object_id());

		if (! empty($url)) {
			$this->do_attachment_redirect($url);
			return true;
		}

		return false;
	}

	/**
	 * Performs the redirect from the attachment page to the image file itself.
	 * @param string $attachment_url The attachment image url.
	 */
	public function do_attachment_redirect($attachment_url)
	{
	  header('X-Redirect-By: AgentImage');
	  wp_redirect($attachment_url, 301);
	  exit;
	}

	/**
	 * Call 404 Page
	 */
	public function page_not_found_template($template)
	{
		if (is_404()) {
			$settings = get_option('404_settings');
			if (empty($settings['disabled_404'])) {
				return AIOS_INITIAL_SETUP_VIEWS . 'initial-setup' . DIRECTORY_SEPARATOR . 'elements' . DIRECTORY_SEPARATOR . '404-page.php';
			}
		}

		return $template;
	}

	/**
	 * Add inline scripts from modules
	 */
	public function append_html_head()
	{
		// Back to top
		$backtotop = get_option('aios-back-top', []);
		$backtotophtml = "";

		if (isset($backtotop['enabled']) && $backtotop['enabled'] === "1") {
			$displayOnPageOnly = isset($option['pages']) ? $option['pages'] : 'all';
			$backtotophtml =  "<style>
				#aios-btt-btn {
					appearance: none !important;
					outline: 0 !important;
					display: inline-flex;
					align-items: center;
					justify-content: center;
					gap: " . (isset($backtotop['text-gap']) ? $backtotop['text-gap'] : "10") . "px;
					padding: " . (isset($backtotop['padding-y']) ? $backtotop['padding-y'] : "0") . "px " . (isset($backtotop['padding-x']) ? $backtotop['padding-x'] : "0") . "px;
					width: " . (isset($backtotop['width']) ? ($backtotop['width'] === "1" ? "auto" : $backtotop['width'] . "px") : "60px") . ";
					height: " . (isset($backtotop['height']) ? ($backtotop['height'] === "1" ? "auto" : $backtotop['height'] . "px") : "60px") . ";
					background-color: " . (isset($backtotop['background-color']) ? $backtotop['background-color'] : "#000") . ";
					position: fixed;
					right: " . (isset($backtotop['right']) ? $backtotop['right'] : "15") . "px;
					bottom: " . (isset($backtotop['bottom']) ? $backtotop['bottom'] : "15") . "px;
					z-index: 500;
					border-radius: " . (isset($backtotop['border-radius']) ? $backtotop['border-radius'] : "0") . "px;
					border: " . (isset($backtotop['border-size']) ? $backtotop['border-style'] . " " . $backtotop['border-color'] . " " . $backtotop['border-size'] . "px" : "0") . ";
					font-size: " . (isset($backtotop['font-size']) ? $backtotop['font-size'] : "15") . "px;
					text-align: center;
					color: " . (isset($backtotop['text-color']) ? $backtotop['text-color'] : "#fff") . ";
					transition: all 150ms;
					box-shadow: 0px 0px 15px -3px " . (isset($backtotop['shadow-color']) ? $backtotop['shadow-color'] : "rgba(0,0,0,0)") . ";
				}
				#aios-btt-btn.btt-show {
					visibility: visible;
					opacity: 1;
				}
				#aios-btt-btn.btt-hide {
					visibility: hidden;
					opacity: 0;
				}
				#aios-btt-btn svg,
				#aios-btt-btn img {
					width: " . (isset($backtotop['svg-width']) ? $backtotop['svg-width'] : "32") . "px;
					height: auto;
				}
				@media (hover: hover) and (pointer: fine) {
					#aios-btt-btn:hover {
						background-color: " . (isset($backtotop['hover-background-color']) ? $backtotop['hover-background-color'] : "#000") . ";
						color: " . (isset($backtotop['hover-text-color']) ? $backtotop['hover-text-color'] : "#fff") . ";
						border-color: " . (isset($backtotop['hover-border-color']) ? $backtotop['hover-border-color'] : "#fff") . ";
					}
				}
			</style>";

			if ($displayOnPageOnly === "all") {
				echo $backtotophtml;
			} else {
				if ($displayOnPageOnly === "home" && is_home()) {
					echo $backtotophtml;
				} else if ($displayOnPageOnly === "innerpages" && !is_home()) {
					echo $backtotophtml;
				}
			}
		}

		// Add classes to dead links
		echo "<script type=\"text/javascript\">
jQuery(document).ready( function() {
	jQuery(\"a[href='#']\").each( function(i,v) {
		jQuery(v).addClass(\"aios-initial-setup-dead-link\");
	});
	jQuery(\"a[href='#']\").click( function(e) {
		if ( jQuery(e.currentTarget).attr(\"href\") == \"#\" ) {
			e.preventDefault();
		}
	});
});
</script>";
	}

	/**
	 * Remove auto paragraph
	 *
	 * @param $post
	 */
	public function remove_auto_paragraph($post)
	{
		if (get_post_meta($post->ID, 'ai_post_page_p', true) === "on" && !is_archive()) {
			remove_filter('the_content', 'wpautop');
		}
	}

	/**
	 * Add schema embed
	 */
	public function addSchemaNavigationAndEmbedScripts()
	{
		$registeredMenus = get_registered_nav_menus();
		$menu_name = 'primary-menu';
		$locations = get_nav_menu_locations();

		if (isset($locations[$menu_name]) && in_array('Primary Menu', $registeredMenus)) {
			$menu = wp_get_nav_menu_object($locations[$menu_name]);
			$menuItems = wp_get_nav_menu_items($menu->term_id, ['order' => 'ASC', 'orderby' => 'menu']);
			$navDecode = json_decode(json_encode($menuItems), true);

			$navItems = [];
			foreach ($navDecode as $item_list) {
				$navItems[] = [
					'@type' => 'SiteNavigationElement',
					'name' => $item_list['title'],
					'url' => $item_list['url']
				];
			}

			$arr_nav_schema = json_encode([
				'@context' => 'https://schema.org',
				'@graph' => [[$navItems]]
			], JSON_PRETTY_PRINT);

			echo '<script type="application/ld+json">' . $arr_nav_schema . '</script>';
		}

		if ($this->quick_search['enabled'] ?? '' !== '') {
			echo "<style>.qs-field.bootstrap-select.btn-group .dropdown-menu.inner{max-height: 300px !important;min-width: 100% !important}</style>";
		}
	}

	/**
	 * Disable Rest API
	 */
	public function remove_rest_api_link()
	{
		remove_action('wp_head', 'rest_output_link_wp_head', 10);
	}
}

new FrontendController();
