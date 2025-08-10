<?php

namespace AiosInitialSetup\App\Integrations;

// Submenu and render: app/InitialSetup.php
// FUB: trait Leads and FrontendControll->append_html_head

use AiosInitialSetup\Config\Config;
use AiosInitialSetup\Config\Assets;

class Controller {
    use Config;
	use Assets;

    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_submenu'], 10);
		add_action('wp_head', [$this, 'append_html_head'], 10);
		add_action('wp_footer', [$this, 'append_html_footer'], 20);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);

        // Shortcodes
        add_shortcode('aios_realscout', [$this, 'aios_realscout']);
        add_shortcode('aios_realscout_banner', [$this, 'aios_realscout_banner']);
        add_shortcode('aios_realscout_v2', [$this, 'aios_realscout_beta']);
        add_shortcode('aios_realscout_banners', [$this, 'rs_banners']);
    }

    /**
     * Add sub menu
	 *
	 * @since 6.8.5
	 * @return null
     */
    public function add_submenu()
    {
		$productSelected = get_option('aios_custom_login_screen');
		$prefix = '';

		if($productSelected != 'default'){
			$prefix = ((int) get_option('aios_tdp_labs', 0) === 1) ? 'TDP' : 'AIOS';
		}

		add_submenu_page(
			'aios-all-in-one',
			'Integrations - ' . $prefix . ' All in One',
			'Integrations',
			'manage_options',
			'aios-integrations',
			[$this, 'render']
		);
    }

    /**
     * Render
	 *
	 * @since 6.8.5
	 * @return string
     */
    public function render() 
    {
		// Get array of options
		$tabs = $this->integrationsTabs();

		// real scout
		$realscout = get_option('aios_realscout');
		$realscout_v2 = get_option('aios_realscout_v2');
		$aios_realscout_search = get_option('aios_realscout_search');
		$aios_realscout_agent = get_option('aios_realscout_agent');
		$aios_realscout_office = get_option('aios_realscout_office');

		// honely
		$honely = get_option('aios_honely');

		// FUB
		$fub = get_option('aios_fub');

		// SEO
        $seo = get_option('aios_seo_settings', []);

		// SEO
        $mailchimp = get_option('aios_mailchimp', []);

		require_once AIOS_INITIAL_SETUP_VIEWS . 'integrations' . DIRECTORY_SEPARATOR . 'index.php';
    }

	/**
	 * Enqueue Assets
	 *
	 * @since 6.8.5
	 * @return null
	 */
	public function enqueue_assets()
    {
		// Enqueue Honely
    	$honely = get_option('aios_honely', []);
		$honelyApiKey = $honely['api-key'] ? true : false;
		$honelyDisabled = $honely['disabled'] ? true : false;

		if ($honelyApiKey && ! $honelyDisabled) {
			wp_enqueue_script('honely-widget-code', 'https://developers.honely.com/widget/load-script?api-key=' . $honely['api-key'], [], false, true);
		}

		// Real Scout Beta
        $realscout_v2 = get_option('aios_realscout_v2', []);
        $enabled = $realscout_v2['enabled'] ?? '';

        if (! empty($enabled) && $enabled === "1") {
			wp_enqueue_script( 'rs-shortcode', AIOS_INITIAL_SETUP_RESOURCES . 'vite/js/frontend-integrations.js', [ 'jquery-core' ], null, [] );
		}

		// Enqeueue AIOS_INITIAL_SETUP_RESOURCES . 'vite/css/real-scout.css' when working locally
    }

	/**
	 * Append to Head
	 *
	 * @since 6.8.5
	 * @return null
	 */
	public function append_html_head()
    {
        // Real Scout
		$realscout = get_option('aios_realscout');
		$enabled = $realscout['enabled'] ?? '';

		if (! empty($enabled) && $enabled === "1") {
			echo "<script id=\"rs-embedded\">
				!function(){var e=document.createElement(\"script\");e.className=\"rs-embedded-script\",e.async=!0,e.src=\"https://em.realscout.com/assets/em/v3/all.js\";var s=document.getElementsByTagName(\"script\")[0];s.parentNode.insertBefore(e,s)}();
			</script>
			<style type=\"text/css\">
				#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne .search--widget{margin:0}#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne .search--advanced{padding:0}#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne .twitter-typeahead .tt-dropdown-menu .empty-location,#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne .twitter-typeahead .tt-dropdown-menu .tt-suggestion{height:auto;line-height:1.25}#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne a{cursor:pointer}#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne .home--listings{max-width:100%;min-width:0}#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne .home--listings__page.active{display:grid;grid-template-columns:repeat(1,1fr);gap:20px}#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne .realscout--listings:not(.restricted__layout) .realscout--listing{margin:0!important;width:100%!important}#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne .list__view:not(.restricted__layout) .home--listings__page.active{grid-template-columns:repeat(1,1fr)!important}#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne .list__view:not(.restricted__layout) .home--listings__page.active .realscout--listing{display:flex}#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne .list__view:not(.restricted__layout) .home--listings__page.active .realscout--listing .listing--image__container{float:none;width:34%;height:100%}#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne .list__view:not(.restricted__layout) .home--listings__page.active .realscout--listing .listing--image__container img{object-fit:cover;object-position:center;max-height:100%}#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne .list__view:not(.restricted__layout) .home--listings__page.active .realscout--listing .listing--header{float:none;width:66%}#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne .listing--description{white-space:normal}#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne .listing--description .attributes{padding:0 .5rem}@media (min-width:30em){#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne .home--listings__page.active{grid-template-columns:repeat(2,1fr)}}@media (min-width:52.5em){#realscout--kingdom #realscout--kingdom__castle #kingdom--castle #kingdom--castle__throne .home--listings__page.active{grid-template-columns:repeat(3,1fr)}}
			</style>";
		}

		// Real Scout Beta
        $realscout_v2 = get_option('aios_realscout_v2', []);
        $enabled = $realscout_v2['enabled'] ?? '';

        if (! empty($enabled) && $enabled === "1") {
			// enqueue script as module
			echo "<script src=\"https://em.realscout.com/widgets/realscout-web-components.umd.js\" type=\"module\"></script>";

			$theme = $realscout_v2['theme'] ?? '';
			$dark_mode = "";

			if (! empty($theme) && $theme === "1") {
				$dark_mode = ".rs-wrapper {
					--rs-background-color: #000;
				}
				.rsb-content h2,
				.rsb-content p,
				.rsb-powered-by span  {
					--rs-default-color: #f0f0f0;
				}
				.rsb-btn {
					color: var(--rs-button-text-color, #1C1E26);
					background: var(--rs-button-color, #ffff);
				}
				.rsb-powered-by img {
					filter: invert(1)
				}";
			} 
			
			$rshtml = "<style>
				realscout-simple-search {
					--rs-ss-font-primary-color: " . (empty( $realscout_v2['ss-font-color'] ) ? '#6A6D72' : $realscout_v2['ss-font-color']) . ";
					--rs-ss-searchbar-border-color: " . (empty( $realscout_v2['ss-border-color'] ) ? '#9B9B9B' : $realscout_v2['ss-border-color']) . ";
					--rs-ss-box-shadow: none;
					--rs-ss-widget-width: 100%;
				}

				realscout-advanced-search {
					--rs-as-background-color: " . (empty( $realscout_v2['as-form-bg-color'] ) ? '#FFFFFF' : $realscout_v2['as-form-bg-color']) . ";
					--rs-as-button-text-color: " . (empty( $realscout_v2['as-btn-text-color'] ) ? '#FFFFFF' : $realscout_v2['as-btn-text-color']) . ";
					--rs-as-button-color: " . (empty( $realscout_v2['as-btn-bg-color'] ) ? '#4A4A4A' : $realscout_v2['as-btn-bg-color']) . ";
					--rs-ss-widget-width: 100%;
				}
				
				realscout-your-listings,
				realscout-office-listings {
					--rs-listing-divider-color: " . (empty( $realscout_v2['as-listings-color'] ) ? '#93BEE6' : $realscout_v2['as-listings-color']) . ";
					width: 100%;
				}

				realscout-home-value {
					--rs-hvw-background-color: " . (empty( $realscout_v2['hv-background-color'] ) ? '#FFFFFF' : $realscout_v2['hv-background-color'] ) . ";
					--rs-hvw-title-color: " . (empty( $realscout_v2['hv-title-color'] ) ? '#000000' : $realscout_v2['hv-title-color'] ) . ";
					--rs-hvw-subtitle-color: " . (empty( $realscout_v2['hv-subtitle-color'] ) ? '#7c7c7c' : $realscout_v2['hv-subtitle-color'] ) . ";
					--rs-hvw-primary-button-color: " . (empty( $realscout_v2['hv-primary-button-color'] ) ? '#1e73be' : $realscout_v2['hv-primary-button-color'] ) . ";
					--rs-hvw-primary-button-text-color: " . (empty( $realscout_v2['hv-primary-button-text-color'] ) ? '#FFFFFF' : $realscout_v2['hv-primary-button-text-color'] ) . ";
					--rs-hvw-secondary-button-color: " . (empty( $realscout_v2['hv-secondary-button-color'] ) ? '#FFFFFF' : $realscout_v2['hv-secondary-button-color'] ) . ";
					--rs-hvw-secondary-button-text-color: " . (empty( $realscout_v2['hv-secondary-button-text-color'] ) ? '#1e73be' : $realscout_v2['hv-secondary-button-text-color'] ) . ";
					--rs-hvw-widget-width: auto;
				}

				.rs-wrapper {
					display: block;
					background-color: var(--rs-background-color, transparent);
					padding: 32px 16px;
					overflow: hidden;
				}
				.rsb-banner {
					display: block;
					max-width: 1440px;
					width: 100%;
					margin: 0 auto;
				}
				.rsb-container {
					position: relative;
					min-height: 418px;
				}
				.rsb-content h2 {
					margin: 0 0 8px;
					font-family: var(--rs-font-family, \"Poppins\", sans-serif);
					font-weight: var(--rs-heading-font-weight, 900);
					font-size: 24px;
					line-height: 32px;
					color: var(--rs-default-color, #1C1E26);
				}
				.rsb-content p {
					margin: 0 0 24px;
					font-family: var(--rs-font-family, \"Poppins\", sans-serif);
					font-weight: var(--rs-paragraph-font-weight, 300);
					font-size: 12px;
					line-height: 18px;
					letter-spacing: -0.02em;
					color: var(--rs-default-color, #1C1E26);
				}
				.rsb-btn {
					display: inline-flex;
					justify-content: center;
					align-items: center;
					padding: 12px 16px;
					margin: 0 0 16px;
					min-width: 152px;
					min-height: 42px;
					border-radius: 10px;

					font-family: var(--rs-font-family, \"Poppins\", sans-serif);
					font-weight: var(--rs-btn-font-weight, 600);
					font-size: 12px;
					line-height: 18px;
					text-align: center;
					text-transform: uppercase;

					color: var(--rs-button-text-color, #ffff);
					background: var(--rs-button-color, #1C1E26);
				}
				.rsb-powered-by {
					display: inline-flex;
					align-items: flex-end;
					gap: 15px;
					margin-top: 16px;
				}
				.rsb-powered-by span {
					font-family: var(--rs-font-family, \"Poppins\", sans-serif);
					font-weight: var(--rs-powered-font-weight, 400);
					font-size: 11px;
					line-height: 18px;
					color: var(--rs-default-color, #1C1E26);
					text-transform: uppercase;
				}
				.rsb-powered-by img {
					max-width: 112px;
					width: 100%;
					height: auto;
				}
				.rsb-desktop {
					display: none;
				}
				.rsb-img-content {
					position: relative;
					overflow: hidden;
					display: block;
					width: 100%;
				}
				.rsb-img-content canvas {
					display: block;
					width: 100%;
					height: auto;
				}
				.rsb-img-content img {
					position: absolute;
					top: 50%;
					left: 50%;
					width: 125%;
					height: 118%;
					transform: translate(-41%, -56%);
					object-fit: cover;
					object-position: center;
				}
				$dark_mode
				@media (min-width:744px) {
					.rs-wrapper {
						padding: 0 0 0 40px;
					}
					.rsb-container {
						display: flex;
						align-items: center;
						max-width: 400px;
						padding: 40px 0;
						margin: 0;
					}
					.rsb-content h2 {
						font-size: 32px;
						line-height: 40px;
					}
					.rsb-btn {
						margin-bottom: 36px;
					}
					.rsb-powered-by {
						margin-top: 0;
					}
					.rsb-img-content {
						width: 0;
						overflow: visible;
						position: static;
					}
					.rsb-img-content img {
						position: absolute;
						top: -36%;
						left: calc(100% + 8px);
						width: 174%;
						height: auto;
						object-fit: initial;
						object-position: initial;
						transform: none;
					}
					.rsb-img-content canvas {
						display: none;
					}
					.rsb-mobile {
						display: none;
					}
					.rsb-desktop {
						display: flex;
					}
				}
				@media (min-width:1024px) {
					.rsb-container {
						max-width: 470px;
					}
					.rsb-content h2 {
						font-size: 44px;
						line-height: 53px;
					}
					.rsb-content p {
						font-size: 14px;
						line-height: 24px;
					}
					.rsb-btn {
						min-width: 184px;
						min-height: 56px;
						font-size: 16px;
						line-height: 24px;
					}
					.rsb-img-content img {
						top: -41%;
						width: 159%;
					}
				}
				@media (min-width:1280px) {
					.rs-wrapper {
						padding-left: 88px;
					}
					.rsb-container {
						max-width: 656px;
					}
					.rsb-img-content img {
						top: -35%;
						width: 107%;
					}
				}
			</style>";

			displaySelectedPage( isset( $realscout_v2['pages'] ) ? $realscout_v2['pages'] : 'all', $rshtml, true );
		}

        // Follow up boss
		$fub = get_option('aios_fub');

		if ( $fub['enabled'] ?? '' === "1" && ! empty( $fub['pixel'] ?? '' ) ) {
			echo "<!-- begin Widget Tracker Code -->
				<script>
					(function(w,i,d,g,e,t){w[\"WidgetTrackerObject\"]=g;(w[g]=w[g]||function()
					{(w[g].q=w[g].q||[]).push(arguments);}),(w[g].ds=1*new Date());(e=\"script\"),
					(t=d.createElement(e)),(e=d.getElementsByTagName(e)[0]);t.async=1;t.src=i;
					e.parentNode.insertBefore(t,e);})
					(window,\"https://widgetbe.com/agent\",document,\"widgetTracker\");
					window.widgetTracker(\"create\", \"" . $fub['pixel'] . "\");
					window.widgetTracker(\"send\", \"pageview\");
				</script>
			<!-- end Widget Tracker Code -->";
		}
    }

	/**
	 * Append to Footer
	 *
	 * @since 6.8.5
	 * @return null
	 */
	public function append_html_footer()
    {
		// SEO - Tag Manager
        $seo_settings = get_option('aios_seo_settings', []);
        $gtmFormSubmissions = $seo_settings['gtm-form-submissions'] ?? '';

		if (! empty($gtmFormSubmissions) && $gtmFormSubmissions === "1") {
			// update src/js/gtm-form-submissions.js and copy the compiled js intead of editing this directly
			echo '<script>function t(a){var e=new RegExp("[?&]"+a+"=([^&]*)").exec(window.location.search);return e?decodeURIComponent(e[1]):""}function i(){return{event:"form_submission",gclid:t("gclid"),gbraid:t("gbraid"),wbraid:t("wbraid"),utm_source:t("utm_source"),utm_medium:t("utm_medium"),utm_campaign:t("utm_campaign"),utm_term:t("utm_term"),utm_content:t("utm_content")}}document.addEventListener("wpcf7mailsent",function(a){window.dataLayer=window.dataLayer||[],window.dataLayer.push({...i(),event_from:"AIOS Submission CF7",form_id:a.detail.contactFormId,form_title:a.target.getAttribute("aria-label")?a.target.getAttribute("aria-label"):"Unknown Form"})});</script>';
		}
    }
    
	/**
	 * Real Scout
	 *
	 * @since 6.8.2
	 * @return string
	 */
	public function aios_realscout($atts) {
        $atts = shortcode_atts([
          'type' => "",
        ], $atts);
    
        $realscout = get_option('aios_realscout', []);
        $enabled = $realscout['enabled'] ?? '';

        if (! empty($enabled) && $enabled === "1") {
            $id = $realscout['id'] ?? '';
        
            if ($atts["type"] === "simple-search" || $atts["type"] === "advanced-search") {
                $type = $atts["type"] === "advanced-search" ? "advanced" : "simple";
                $search = get_option('aios_realscout_search', []);
                $button_color = isset( $search['button-color'] ) ? $search['button-color'] : '#235D89';
                $text_color = isset( $search['text-color'] ) ? $search['text-color'] : '#FFFFFF';
                $background_color = isset( $search['background-color'] ) ? $search['background-color'] : '#EEEEEE';
        
                return "<div class=\"realscout-search $type\" data-rep=\"$id\" data-button-color=\"$button_color\" data-button-font=\"$text_color\" data-background-color=\"$background_color\"></div>";
            } else if ($atts["type"] === "agent-listings") {
                $agent = get_option('aios_realscout_agent', []);
                $statuses = [
                isset( $agent['active'] ) && $agent['active'] === "1" ? 'active' : '',
                isset( $agent['pending'] ) && $agent['pending'] === "1" ? 'pending' : '',
                isset( $agent['sold'] ) && $agent['sold'] === "1" ? 'sold' : '',
                ];
                $view = isset( $agent['display'] ) ? $agent['display'] : 'grid';
                
                return "<div class=\"realscout-listings agent\" data-rep=\"$id\" data-status=\"" . implode(",", array_filter($statuses)) . "\" data-view=\"" . $view . "__view\"></div>";
            } else if ($atts["type"] === "office-listings") {
                $office = get_option('aios_realscout_office', []);
                $statuses = [
                isset( $office['active'] ) && $office['active'] === "1" ? 'active' : '',
                isset( $office['pending'] ) && $office['pending'] === "1" ? 'pending' : '',
                isset( $office['sold'] ) && $office['sold'] === "1" ? 'sold' : '',
                ];
                $view = isset( $office['display'] ) ? $office['display'] : 'grid';
                
                return "<div class=\"realscout-listings office\" data-rep=\"$id\" data-status=\"" . implode(",", array_filter($statuses)) . "\" data-view=\"" . $view . "__view\"></div>";
            } else {
                return wp_unslash($realscout['tag']);
            }
        }
    
        return "";
    }

	/**
	 * Real Scout Banner
	 *
	 * @since 6.8.5
	 * @return string
	 */
	public function aios_realscout_banner() 
	{
        $realscout_v2 = get_option('aios_realscout_v2', []);
        $enabled = $realscout_v2['enabled'] ?? '';

        if (! empty($enabled) && $enabled === "1") {
			$containerid = $realscout_v2['containerid'] ?? 'realscout-banner';
			$title = $realscout_v2['title'] ?? 'Discover new listings right when they hit the market.';
			$description = $realscout_v2['description'] ?? 'RealScout is the ulitimate tool when searching for your new home!';
			$btntext = $realscout_v2['btntext'] ?? 'search all';
			$btnurl = $realscout_v2['btnurl'] ?? 'https://amyagent.realscout.com/';
			$btnclass = $realscout_v2['btnclass'] ?? 'rsb-btn';
			$img = $realscout_v2['image'] ?: 'https://resources.agentimage.com/images/real-scout-beta.png';

			if ( $img === 'https://resources.agentimage.com/images/real-scout-beta.png' ) {
				$image = "<img src=\"https://resources.agentimage.com/images/real-scout-beta.png\" width=\"1096\" height=\"1115\" class=\"rsb-image\">";
			} else {
				$image = wp_get_attachment_image( $realscout_v2['image'], 'full', false, [ 'class' => 'rsb-image' ] );
			}

			$rshtml = "<div id=\"$containerid\" class=\"rs-wrapper\">
				<div class=\"rsb-banner\">
					<div class=\"rsb-container\">
						<div class=\"rsb-content\">
							<h2>$title</h2>
							<p>$description</p>
							<a href=\"$btnurl\" target=\"_blank\" class=\"$btnclass\">$btntext</a>

							<div class=\"rsb-powered-by rsb-desktop\">
								<span>Powered By</span>
								<img src=\"https://resources.agentimage.com/images/sm-real-scout.png\" width=\"170\" height=\"36\">
							</div>
						</div>
						<div class=\"rsb-img-content\">
							<canvas width=\"340\" height=\"218\"></canvas>
							$image
						</div>
						<div class=\"rsb-powered-by rsb-mobile\">
							<span>Powered By</span>
							<img src=\"https://resources.agentimage.com/images/sm-real-scout.png\" width=\"170\" height=\"36\">
						</div>
					</div>
				</div>
			</div>";

			displaySelectedPage( isset( $realscout_v2['pages'] ) ? $realscout_v2['pages'] : 'all', $rshtml, true );
		}
	}
    
	/**
	 * Real Scout
	 *
	 * @since 6.8.9
	 * @return string
	 */
	public function aios_realscout_beta($atts, $content) {
		$pairs = [
			'type' => "",
			'append-to-id' => "",
			'limit' => 10
		];

        $defaultAtts = shortcode_atts($pairs, $atts);

		// Remove default pairs
		foreach ($pairs as $k => $v) {
			unset($atts[$k]);
		}

		// Real Scout Atts
		$rsAtts = "";

		foreach ($atts as $k => $v) {
			if ( is_string( $k ) ) {
				$rsAtts .= " $k=\"$v\"";
			} else {
				$rsAtts .= " $v";
			}
		}
    
        $realscout_v2 = get_option('aios_realscout_v2', []);
        $enabled = $realscout_v2['enabled'] ?? '';

        if (! empty($enabled) && $enabled === "1") {
			$encodedId = $realscout_v2['encodedid'] ?? '';
			$widgetClass = $realscout_v2['widget-class'] ?? '';
			$listingClass = "";
			$html = "";

			if ( $defaultAtts['type'] === "home-value" ) {
				if ( $realscout_v2['hv-remove-title'] ?? '' === 1 ) {
					$rsAtts .= " remove-title";
				}
				
				if ( $realscout_v2['hv-remove-subtitle'] ?? '' === 1 ) {
					$rsAtts .= " remove-subtitle";
				}

				if ( $realscout_v2['hv-include-name'] ?? '' === 1 ) {
					$rsAtts .= " include-name";
				}
				
				if ( $realscout_v2['hv-include-phone'] ?? '' === 1 ) {
					$rsAtts .= " include-phone";
				}
				
				if ( $realscout_v2['hv-disable-shadow'] ?? '' === 1 ) {
					$rsAtts .= " disable-shadow-dom";
				}
			}

			switch ($defaultAtts['type']) {
				case 'listing':
					$listingClass = ! empty($defaultAtts['append-to-id']) ? "aios-rs-listings" : "";
					$html = "<realscout-your-listings agent-encoded-id=\"$encodedId\" $rsAtts></realscout-your-listings>";
					break;

				case 'office':
					$listingClass = ! empty($defaultAtts['append-to-id']) ? "aios-rs-listings" : "";
					$html = "<realscout-office-listings agent-encoded-id=\"$encodedId\" $rsAtts></realscout-office-listings>";
					break;
				
				case 'home-value':
					$html = "<realscout-home-value agent-encoded-id=\"$encodedId\" $rsAtts></realscout-home-value>";
					break;
				
				case 'advanced-search':
					$html = "<realscout-advanced-search agent-encoded-id=\"$encodedId\" disable-shadow-dom></realscout-advanced-search>";
					break;

				default:
					$html = "<realscout-simple-search agent-encoded-id=\"$encodedId\" disable-shadow-dom></realscout-simple-search>";
					break;
			}

			$containerAtts = [];
			$containerAtts[] = "class=\"" . trim("$widgetClass $listingClass") . "\"";

			if (! empty($defaultAtts['append-to-id'])) {
				$containerAtts[] = "style=\"display: none\"";
				$containerAtts[] = "data-append=\"" . $defaultAtts['append-to-id'] . "\"";
				$containerAtts[] = ! empty($defaultAtts['limit']) ? "data-limit=\"" . $defaultAtts['limit'] . "\"" : "";
			}

			$containerAtts = implode(" ", array_filter($containerAtts));

			return "<div $containerAtts>$html</div>";
        }
    
        return "";
    }

	/**
	 * Shortcode Banner
	 *
	 * @since 6.8.8
	 * @return string
	 */
	public function rs_banners($atts) {
        $defaultAtts = shortcode_atts([
    		"type" => "default",

			// Single Values
    		"href" => "#",
			"href_text" => "Get Started",

			// Only applicable for simple-default simple-one, simple-two, simple-three
			"removed_shared_style" => false,
			// Only applicable for simple-default simple-one, simple-three
			"logo_image" => "",
			"background_image" => "",
			// Only applicable for simple-two
			"accent_image" => "",
			// Only applicable for wmhw
			"accent_image_alt" => "",
			"main_image" => "",
			// Only applicable for wmhw
			"subtitle" => "",
			"title" => "",
			"description" => "",

			// Combined - Marketing or properties
			"market_title" => "",
			"market_description" => "",
			"market_href" => "",
			"market_href_text" => "Get Started",
			"market_background_image" => "",
			"market_device_image" => "",
			"market_logo_image" => "",

			// Combined - Whats my home worth
			"wmhw_title" => "",
			"wmhw_description" => "",
			"wmhw_href" => "",
			"wmhw_href_text" => "Get My Home Value",
			"wmhw_background_image" => "",
			"wmhw_device_image" => "",
			"wmhw_logo_image" => "",
        ], $atts);
		
		$style = "";
		$html = "";
    
        $realscout_v2 = get_option('aios_realscout_v2', []);
        $enabled = $realscout_v2['enabled'] ?? '';

		if (! empty($enabled) && $enabled === "1") {
			switch ($defaultAtts['type']) {
				case 'default':
					$style = $this->rs_assets('default', $defaultAtts['removed_shared_style']);
					$background_image = $defaultAtts['background_image'] ?: '';
					$title = $defaultAtts['title'] ?: 'Discover new listings right when they hit the market.';
					$description = $defaultAtts['description'] ?: 'RealScout is the ulitimate tool when searching for your new home!';
					$alt = strip_tags($title);
					$hrefText = $defaultAtts['href_text'];
					$main_image = $defaultAtts['main_image'] ?: 'https://resources.agentimage.com/images/real-scout-beta.png';
					$background_style = $background_image ? "style=\"background-image: url($background_image);\"" : "";
					$logo_image = $defaultAtts['logo_image'] ?: 'https://resources.agentimage.com/realscout/banner-three/logo.png';
					$html = "<div class=\"rs-single-default\" $background_style>
	<div class=\"rs-single-container\">
		<div class=\"rs-single-inner\">
			<div class=\"rs-single-content\">
				<h2 class=\"rs-single-heading\">$title</h2>
				<p class=\"rs-single-paragraph\">$description</p>
				<a target=\"_blank\" href=\"" . $defaultAtts['href'] ."\" class=\"rs-single-btn\">$hrefText</a>
			</div>
			<div class=\"rs-single-pby rs-single-desktop-only-flex\">
				<span>Powered By</span>
				<img src=\"$logo_image\" alt=\"Real Scout Logo\">
			</div>
		</div>
		<div class=\"rs-single-device\">
			<canvas width=\"340\" height=\"218\"></canvas>
			<img src=\"$main_image\" alt=\"$alt\">
		</div>
		<div class=\"rs-single-pby rs-single-mobile-only-flex\">
			<span>Powered By</span>
			<img src=\"$logo_image\" alt=\"Real Scout Logo\">
		</div>
	</div>
</div>";
					break;

				case 'simple-one':
					$style = $this->rs_assets('simple-one', $defaultAtts['removed_shared_style']);
					$background_image = $defaultAtts['background_image'] ?: 'https://resources.agentimage.com/realscout/banner-one/banner.jpg';
					$logo_image = $defaultAtts['logo_image'] ?: 'https://resources.agentimage.com/realscout/banner-one/logo.png';
					$main_image = $defaultAtts['main_image'] ?: 'https://resources.agentimage.com/realscout/banner-one/device.png';
					$title = $defaultAtts['title'] ?: 'Discover new listings right when they <br />hit the market.';
					$description = $defaultAtts['description'] ?: 'RealScout is the ulitimate tool when searching for your new home!';
					$alt = strip_tags($title);
					$hrefText = $defaultAtts['href_text'];
					$html = "<div class=\"rs-single-vone rs-single-bg\" style=\"background-image: url($background_image);\">
	<div class=\"rs-single-container\">
		<div class=\"rs-single-inner\">
			<div class=\"rs-single-content\">
				<h2 class=\"rs-single-heading\">$title</h2>
				<p class=\"rs-single-paragraph\">$description</p>
				<a target=\"_blank\" href=\"" . $defaultAtts['href'] ."\" class=\"rs-single-btn\">$hrefText</a>
			</div>
			<div class=\"rs-single-pby rs-single-desktop-only-flex\">
				<span>Powered By</span>
				<img src=\"$logo_image\" alt=\"Real Scout Logo\">
			</div>
		</div>
		<div class=\"rs-single-device\">
			<img src=\"$main_image\" alt=\"$alt\">
		</div>
		<div class=\"rs-single-pby rs-single-mobile-only-flex\">
			<span>Powered By</span>
			<img src=\"$logo_image\" alt=\"Real Scout Logo\">
		</div>
	</div>
</div>";

					break;

				case 'simple-two':
					$style = $this->rs_assets('simple-two', $defaultAtts['removed_shared_style']);
					$background_image = $defaultAtts['background_image'] ?: 'https://resources.agentimage.com/realscout/banner-two/banner.jpg';
					$accent_image = $defaultAtts['accent_image'] ?: 'https://resources.agentimage.com/realscout/banner-two/banner-accent.jpg';
					$main_image = $defaultAtts['main_image'] ?: 'https://resources.agentimage.com/realscout/banner-two/device.png';
					$title = $defaultAtts['title'] ?: 'Discover new listings right when they <br />hit the market.';
					$description = $defaultAtts['description'] ?: 'RealScout is the ulitimate tool when searching for your new home!';
					$alt = strip_tags($title);
					$hrefText = $defaultAtts['href_text'];
					$html = "<div class=\"rs-single-vtwo\">
	<div class=\"rs-single-bg rs-single-bg-default\" style=\"background-image: url($background_image);\"></div>
	<div class=\"rs-single-bg rs-single-bg-accent\" style=\"background-image: url($accent_image);\"></div>
	<div class=\"rs-single-container\">
		<div class=\"rs-single-device\">
			<img src=\"$main_image\" alt=\"$alt\">
		</div>
		<div class=\"rs-single-inner\">
			<div class=\"rs-single-content\">
				<h2 class=\"rs-single-heading\">$title</h2>
				<p class=\"rs-single-paragraph\">$description</p>
				<a target=\"_blank\" href=\"" . $defaultAtts['href'] ."\" class=\"rs-single-btn\">$hrefText</a>
			</div>
		</div>
	</div>
</div>";

					break;

				case 'simple-three':
					$style = $this->rs_assets('simple-three', $defaultAtts['removed_shared_style']);
					$background_image = $defaultAtts['background_image'] ?: 'https://resources.agentimage.com/realscout/banner-three/banner.jpg';
					$accent_image = $defaultAtts['accent_image'] ?: 'https://resources.agentimage.com/realscout/banner-three/banner-accent.jpg';
					$main_image = $defaultAtts['main_image'] ?: 'https://resources.agentimage.com/realscout/banner-three/device.png';
					$title = $defaultAtts['title'] ?: 'Discover new listings right when they <br />hit the market.';
					$description = $defaultAtts['description'] ?: 'RealScout is the ulitimate tool when searching for your new home!';
					$alt = strip_tags($title);
					$hrefText = $defaultAtts['href_text'];
					$html = "<div class=\"rs-single-vthree\">
	<div class=\"rs-single-bg rs-single-bg-default\" style=\"background-image: url($background_image);\"></div>
	<div class=\"rs-single-bg rs-single-bg-accent\" style=\"background-image: url($accent_image);\"></div>
	<div class=\"rs-single-container\">
		<div class=\"rs-single-inner\">
			<div class=\"rs-single-content\">
				<h2 class=\"rs-single-heading\">$title</h2>
				<p class=\"rs-single-paragraph\">$description</p>
				<a target=\"_blank\" href=\"" . $defaultAtts['href'] ."\" class=\"rs-single-btn\">$hrefText</a>
			</div>
			<div class=\"rs-single-pby\">
				<span>Powered By</span>
				<img src=\"https://resources.agentimage.com/realscout/banner-three/logo.png\" alt=\"Real Scout Logo\">
			</div>
		</div>
		<div class=\"rs-single-device\">
			<img src=\"$main_image\" alt=\"$alt\">
		</div>
	</div>
</div>";

					break;

				case 'wmhw':
					$style = $this->rs_assets('wmhw');
					$background_image = $defaultAtts['background_image'] ?: 'https://resources.agentimage.com/realscout/banner-four/logo-overlay.png';
					$accent_image = $defaultAtts['accent_image'] ?: 'https://resources.agentimage.com/realscout/banner-four/background-accent.png';
					$accent_image_alt = $defaultAtts['accent_image_alt'] ?: 'https://resources.agentimage.com/realscout/banner-four/background-accent.png';
					$main_image = $defaultAtts['main_image'] ?: 'https://resources.agentimage.com/realscout/banner-four/device-v2.png';
					$subtitle = $defaultAtts['subtitle'] ?: 'What\'s my';
					$title = $defaultAtts['title'] ?: 'Home <br />Worth?';
					$description = $defaultAtts['description'] ?: 'Stay ahead with automatic home value alerts and market updates, designed to keep you informed and ready for every opportunity.';
					$alt = strip_tags($title);
					$hrefText = $defaultAtts['href_text'];
					$html = "<div class=\"rs-wmhw-vone\">
	<div class=\"rs-wmhw-section\">
		<img src=\"$background_image\" class=\"rs-wmhw-img-overlay\" alt=\"Banner Image\" />
		<img src=\"$accent_image\" class=\"rs-wmhw-img-accent rs-wmhw-desktop-only\" alt=\"Banner Accent Desktop\" />

		<div class=\"rs-wmhw-container\">
			<div class=\"rs-wmhw-content\">
				<div class=\"rs-wmhw-subtitle\">
					<span>$subtitle</span>
                    <span></span>
                </div>
                <h2>$title</h2>
                <p>$description</p>
                <a target=\"_blank\" href=\"" . $defaultAtts['href'] ."\" class=\"rs-wmhw-btn\">Get Started</a>
            </div>
            <div class=\"rs-wmhw-device\">
                <img src=\"$accent_image_alt\" class=\"rs-wmhw-img-accent rs-wmhw-mobile-only\" alt=\"Banner Accent Mobile\" />
                <img src=\"$main_image\" class=\"rs-wmhw-device-img\" alt=\"$alt\">
            </div>
        </div>
    </div>
</div>";

					break;

				case 'combined':
					$style = $this->rs_assets('combined');
					$market_title = $defaultAtts['market_title'] ?: 'Discover new listings right when they hit the market.';
					$market_alt = strip_tags($market_title);
					$market_description = $defaultAtts['market_description'] ?: 'RealScout is the ultimate tool when searching for your new home!';
					$market_href = $defaultAtts['market_href'];
					$market_href_text = $defaultAtts['market_href_text'];
					$market_background_image = $defaultAtts['market_background_image'] ?: 'https://resources.agentimage.com/realscout/banner-split-one/banner.jpg';
					$market_device_image = $defaultAtts['market_device_image'] ?: 'https://resources.agentimage.com/realscout/banner-split-one/device-mobile-crop.png';
					$market_logo_image = $defaultAtts['market_logo_image'] ?: 'https://resources.agentimage.com/realscout/banner-one/logo.png';
					
					$wmhw_title = $defaultAtts['wmhw_title'] ?: 'What\'s My <br />Home Worth?';
					$wmhw_description = $defaultAtts['wmhw_description'] ?: 'Stay ahead with automatic home value alerts and market updates, designed to keep you informed and ready for every opportunity.';
					$wmhw_href = $defaultAtts['wmhw_href'];
					$wmhw_href_text = $defaultAtts['wmhw_href_text'];
					$wmhw_background_image = $defaultAtts['wmhw_background_image'] ?: 'https://resources.agentimage.com/realscout/banner-split-one/logo-overlay.png';
					$wmhw_device_image = $defaultAtts['wmhw_device_image'] ?: 'https://resources.agentimage.com/realscout/banner-split-one/device-tablet-v2.png';
					$wmhw_logo_image = $defaultAtts['wmhw_logo_image'] ?: 'https://resources.agentimage.com/realscout/banner-three/logo.png';

					$html = "<div class=\"rs-combined-vone\">
	<img src=\"$market_background_image\" alt=\"Marketing Desktop\" class=\"rs-combined-marketing-background rs-combined-desktop-only\" />

	<div class=\"rs-combined-container\">
		<div class=\"rs-combined-content rs-combined-marketing\">
			<img src=\"$market_background_image\" alt=\"Marketing Mobile\" class=\"rs-combined-marketing-background rs-combined-mobile-only\" />
			<div class=\"rs-combined-data\">
				<h2>$market_title</h2>
				<p>$market_description</p>
				<a target=\"_blank\" href=\"$market_href\" class=\"rs-combined-btn\">$market_href_text</a>
				<div class=\"rs-combined-pby\">
					<span>Powered By</span>
					<img src=\"$market_logo_image\" alt=\"Real Scout Logo\">
				</div>
			</div>
			<div class=\"rs-combined-marketing-device\">
				<img src=\"$market_device_image\" alt=\"$market_alt\" />
			</div>
		</div>
		<div class=\"rs-combined-content rs-combined-hworth\">
			<img src=\"$wmhw_background_image\" alt=\"Real Scout Overlay\" class=\"rs-combined-hworth-background\" />
			<div class=\"rs-combined-data\">
				<h2>$wmhw_title</h2>
				<p>$wmhw_description</p>
				<a target=\"_blank\" href=\"$wmhw_href\" class=\"rs-combined-btn\">$wmhw_href_text</a>
				<div class=\"rs-combined-pby\">
					<span>Powered By</span>
					<img src=\"$wmhw_logo_image\" alt=\"Real Scout Logo\">
				</div>
			</div>
			<div class=\"rs-combined-hworth-device\">
				<img src=\"$wmhw_device_image\" alt=\"What’s My Home Worth\" />
			</div>
		</div>
	</div>
</div>";

					break;
				
				default:
					$html = "Please select a banner type";

					break;
			}
		}

		return $style . $html;
	}

}

new Controller();