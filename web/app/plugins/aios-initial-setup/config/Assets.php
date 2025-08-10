<?php

namespace AiosInitialSetup\Config;

trait Assets
{
    /**
     * Get enqueue option value
     *
     * @return mixed|void
     */
    protected function enqueue_options()
    {
        $options = get_option('aios-enqueue-cdn', []);

        foreach ($options as $k => $v) {
            $options[$k] = (int) $v;
        }

        return $options;
    }

    /**
     * Get quick search option
     *
     * @return mixed|void
     */
    protected function quick_search_options()
    {
        return get_option('aios-quick-search', []);
    }

    /**
     * Pre-register scripts on 'wp_default_scripts' action, they won't be overwritten by $wp_scripts->add().
     *
     * @param $scripts
     * @param $handle
     * @param $src
     * @param array $deps
     * @param bool $ver
     * @param bool $in_footer
     */
    protected function set_script($scripts, $handle, $src, $deps = [], $ver = false, $in_footer = false) {
        $script = $scripts->query($handle, 'registered');

        if ($script) {
            // If already added
            $script->src  = $src;
            $script->deps = $deps;
            $script->ver  = $ver;
            $script->args = $in_footer;

            unset($script->extra['group']);

            if ($in_footer) {
                $script->add_data('group', 1);
            }
        } else {
            // Add the script
            if ($in_footer) {
                $scripts->add($handle, $src, $deps, $ver, 1);
            } else {
                $scripts->add($handle, $src, $deps, $ver);
            }
        }
    }

    /**
     * Enqueue resources from ai resources
     *
     * @param $scripts
     */
    protected function jquery_assets($scripts)
    {
        $cdnUrl = cdnDomainSwitcher();
        $assets_url = "$cdnUrl/libraries/";

        $this->set_script($scripts, 'jquery-migrate', $assets_url.'jquery-migrate/jquery-migrate-1.4.1-wp.js', [], '1.4.1-wp');
        $this->set_script($scripts, 'jquery-core', $assets_url.'jquery/jquery-1.12.4-wp.js', [], '1.12.4-wp');
        $this->set_script($scripts, 'jquery', false, ['jquery-core', 'jquery-migrate'], '1.12.4-wp');

        // All the jQuery UI stuff comes here.
        $this->set_script($scripts, 'jquery-ui-core', $assets_url.'jquery-ui/core.min.js', ['jquery'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-effects-core', $assets_url.'jquery-ui/effect.min.js', ['jquery'], '1.11.4-wp', 1);

        $this->set_script($scripts, 'jquery-effects-blind', $assets_url.'jquery-ui/effect-blind.min.js', ['jquery-effects-core'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-effects-bounce', $assets_url.'jquery-ui/effect-bounce.min.js', ['jquery-effects-core'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-effects-clip', $assets_url.'jquery-ui/effect-clip.min.js', ['jquery-effects-core'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-effects-drop', $assets_url.'jquery-ui/effect-drop.min.js', ['jquery-effects-core'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-effects-explode', $assets_url.'jquery-ui/effect-explode.min.js', ['jquery-effects-core'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-effects-fade', $assets_url.'jquery-ui/effect-fade.min.js', ['jquery-effects-core'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-effects-fold', $assets_url.'jquery-ui/effect-fold.min.js', ['jquery-effects-core'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-effects-highlight', $assets_url.'jquery-ui/effect-highlight.min.js', ['jquery-effects-core'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-effects-puff', $assets_url.'jquery-ui/effect-puff.min.js', ['jquery-effects-core', 'jquery-effects-scale'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-effects-pulsate', $assets_url.'jquery-ui/effect-pulsate.min.js', ['jquery-effects-core'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-effects-scale', $assets_url.'jquery-ui/effect-scale.min.js', ['jquery-effects-core', 'jquery-effects-size'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-effects-shake', $assets_url.'jquery-ui/effect-shake.min.js', ['jquery-effects-core'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-effects-size', $assets_url.'jquery-ui/effect-size.min.js', ['jquery-effects-core'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-effects-slide', $assets_url.'jquery-ui/effect-slide.min.js', ['jquery-effects-core'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-effects-transfer', $assets_url.'jquery-ui/effect-transfer.min.js', ['jquery-effects-core'], '1.11.4-wp', 1);

        $this->set_script($scripts, 'jquery-ui-accordion', $assets_url.'jquery-ui/accordion.min.js', ['jquery-ui-core', 'jquery-ui-widget'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-autocomplete', $assets_url.'jquery-ui/autocomplete.min.js', ['jquery-ui-menu', 'wp-a11y'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-button', $assets_url.'jquery-ui/button.min.js', ['jquery-ui-core', 'jquery-ui-widget'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-datepicker', $assets_url.'jquery-ui/datepicker.min.js', ['jquery-ui-core'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-dialog', $assets_url.'jquery-ui/dialog.min.js', ['jquery-ui-resizable', 'jquery-ui-draggable', 'jquery-ui-button', 'jquery-ui-position'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-draggable', $assets_url.'jquery-ui/draggable.min.js', ['jquery-ui-mouse'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-droppable', $assets_url.'jquery-ui/droppable.min.js', ['jquery-ui-draggable'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-menu', $assets_url.'jquery-ui/menu.min.js', ['jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-position'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-mouse', $assets_url.'jquery-ui/mouse.min.js', ['jquery-ui-core', 'jquery-ui-widget'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-position', $assets_url.'jquery-ui/position.min.js', ['jquery'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-progressbar', $assets_url.'jquery-ui/progressbar.min.js', ['jquery-ui-core', 'jquery-ui-widget'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-resizable', $assets_url.'jquery-ui/resizable.min.js', ['jquery-ui-mouse'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-selectable', $assets_url.'jquery-ui/selectable.min.js', ['jquery-ui-mouse'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-selectmenu', $assets_url.'jquery-ui/selectmenu.min.js', ['jquery-ui-menu'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-slider', $assets_url.'jquery-ui/slider.min.js', ['jquery-ui-mouse'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-sortable', $assets_url.'jquery-ui/sortable.min.js', ['jquery-ui-mouse'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-spinner', $assets_url.'jquery-ui/spinner.min.js', ['jquery-ui-button'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-tabs', $assets_url.'jquery-ui/tabs.min.js', ['jquery-ui-core', 'jquery-ui-widget'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-tooltip', $assets_url.'jquery-ui/tooltip.min.js', ['jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-position'], '1.11.4-wp', 1);
        $this->set_script($scripts, 'jquery-ui-widget', $assets_url.'jquery-ui/widget.min.js', ['jquery'], '1.11.4-wp', 1);

        // This just updates the dependency of `jquery-touch-punch`.
        $this->set_script($scripts, 'jquery-touch-punch', false, ['jquery-ui-widget', 'jquery-ui-mouse'], '0.2.2', 1);

        
    }

    /**
     * Enqueue Required Assets
     *
     * @param $options
     */
    protected function enqueue_required_assets($options)
    {
        $cdnUrl = cdnDomainSwitcher();

        // Enqueue AI Fonts
        wp_enqueue_style('agentimage-font', "$cdnUrl/font-icons/agentimage.font.icons.css", [], null, false);

        // Enqueue jQuery wp_enqueue array('jquery') - first make sure that jquery file is include in the header
        wp_enqueue_script('jquery');

        // Enqueue Bootstrap
        $bootstrap_url = $options['bootstrap_no_components_css'] ?? 0 === 1
                ? "$cdnUrl/bootstrap/bootstrap.noicons.min.css"
                : "$cdnUrl/bootstrap/bootstrap.min.css";

        wp_enqueue_style('aios-starter-theme-bootstrap', $bootstrap_url);

        if (isset($options['aios_lozad']) && $options['aios_lozad'] === 1){
            wp_enqueue_script('aios-vanilla-lozad', 'https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.4/dist/lazyload.min.js', '','',true);	
            wp_enqueue_script( 'aios-vanilla-lozad' );
            wp_enqueue_script('aios-lazy-load',  "$cdnUrl/libraries/js/aios-lazyload.min.js",'','',true);	
            wp_enqueue_script( 'aios-lazy-load' );
        }
    }

    /**
     * List of default styles
     * Note: Adding/Removing assets need to be change on the api as well
     *
     * @return array
     */
    protected function default_styles()
    {
        $cdnUrl = cdnDomainSwitcher();

        return [
            'aios-starter-theme-popup-style' => "$cdnUrl/libraries/css/aios-popup.min.css",
            'aios-initial-setup-frontend-style' => "$cdnUrl/libraries/css/frontend.min.css",
        ];
    }

    /**
     * List of default scripts
     * Note: Adding/Removing assets need to be change on the api as well
     *
     * @return array
     */
    protected function default_scripts()
    {
        $cdnUrl = cdnDomainSwitcher();

        return [
            'aios-starter-theme-bowser' => "$cdnUrl/libraries/js/bowser-scripts.js",
            'aios-starter-theme-crossbrowserselector' => "$cdnUrl/libraries/js/browser-selector.min.js",
            'aios-starter-theme-placeholder' => "$cdnUrl/libraries/js/placeholders.min.js",

            // SEO-friendly and self-initializing lazyloader for images (including responsive images picture/srcset)
            'aios-lazysizes' => "$cdnUrl/libraries/js/lazysizes.min.js",

            // 'aios-starter-theme-mobile-iframe-fix' => "$cdnUrl/libraries/js/mobile-iframe-fix.js",
            // 'aios-starter-theme-html5' => "$cdnUrl/libraries/js/html5.js",
            'aios-starter-theme-bootstrap-js' => "$cdnUrl/bootstrap/bootstrap.min.js",
            'aios-nav-double-tap' => "$cdnUrl/libraries/js/jquery.nav-tab-double-tap.min.js",
            'aios-starter-theme-popup' => "$cdnUrl/libraries/js/aios-popup.min.js",
            'aios-default-functions' => "$cdnUrl/libraries/js/aios-default-libraries.min.js",
            'aios-initial-setup-frontend-scripts' => "$cdnUrl/libraries/js/aios-initial-setup-frontend.min.js",
        ];
    }

    protected function separated_styles()
    {
        $cdnUrl = cdnDomainSwitcher();

        return [
            'aios-utilities-style' => "$cdnUrl/libraries/css/aios-utilities.min.css",
            'aios-animate-style' => "$cdnUrl/libraries/css/animate.min.css",
            'aios-slick-style' => "$cdnUrl/libraries/css/slick.min.css",
            'aios-slick-1-8-1-style' => "$cdnUrl/libraries/css/slick.min.1.8.1.css",
            'aios-swiper-style' => "$cdnUrl/libraries/css/swiper.min.css",
            'aios-simplebar-style' => "$cdnUrl/libraries/css/simplebar.min.css",
            'aios-aos-style' => "$cdnUrl/libraries/css/aos.min.css",
            'aios-video-plyr' => "$cdnUrl/libraries/css/plyr.min.css",
            'aios-bootstrap-select' => "$cdnUrl/libraries/css/aios-bootstrap-select.min.css",
            'aios-lazyframe' => "$cdnUrl/libraries/css/lazyframe.min.css",
            'aios-compass-serif' => "$cdnUrl/compass/serif.css",
            'aios-compass-sans-serif' => "$cdnUrl/compass/sans.css",
            'aios-compass-pressura-mono' => "$cdnUrl/compass/pressura-mono.css",
        ];
    }

    protected function separated_scripts()
    {
        $cdnUrl = cdnDomainSwitcher();
        
        return [
            'aios-starter-theme-bootstrap-js' => "$cdnUrl/bootstrap/bootstrap.min.js",
            'aios-picturefill' => "$cdnUrl/libraries/js/picturefill.min.js",
            'aios-autosize-script' => "$cdnUrl/libraries/js/autosize.min.js",
            'aios-chain-height-script' => "$cdnUrl/libraries/js/jquery.chain-height.min.js",
            'aios-elementpeek-script' => "$cdnUrl/libraries/js/jquery.elementpeek.min.js",
            'aios-splitNav-script' => "$cdnUrl/libraries/js/aios-split-nav.min.js",
            'aios-slick-script' => "$cdnUrl/libraries/js/slick.min.js",
            'aios-slick-1-8-1-script' => "$cdnUrl/libraries/js/slick.min.1.8.1.js",
            'aios-swiper-script' => "$cdnUrl/libraries/js/swiper.min.js",
            'aios-simplebar-script' => "$cdnUrl/libraries/js/simplebar.min.js",
            'aios-aos-script' => "$cdnUrl/libraries/js/aos.min.js",
            'aios-sidebar-navigation-script' => "$cdnUrl/libraries/js/jquery.sidenavigation.min.js",
            'aios-video-plyr' => "$cdnUrl/libraries/js/plyr.js",
            'aios-bootstrap-select' => "$cdnUrl/libraries/js/aios-bootstrap-select.min.js",
            'aios-quick-search-js' => "$cdnUrl/libraries/js/aios-quick-search.min.js",
            'aios-lazyframe' => "$cdnUrl/libraries/js/lazyframe.min.js",
        ];
    }

    /**
     * Enqueue Default Scripts
     * @param $isLegacyJquery
     */
    protected function enqueue_default_assets($isLegacyJquery)
    {
        foreach ($this->default_styles() as $style_name => $style_url) {
            wp_enqueue_style($style_name, $style_url);
        }

        foreach ($this->default_scripts() as $script_name => $script_url) {
            if ($script_name === 'aios-starter-theme-popup') {
                $script_url = $isLegacyJquery ? $script_url : str_replace('/libraries/js/', '/libraries/js/3.6.0/', $script_url);
                wp_enqueue_script($script_name, $script_url, ['jquery'], null, false);
            } else {
                wp_enqueue_script($script_name, $script_url, ['jquery'], null, false);
            }
        }
    }

    protected function enqueue_separated_names($options)
    {
        $enqueue_style_names = [];
        $enqueue_script_names = [];

        // Quick Search
        $quick_search = get_option('aios-quick-search');
        if ($quick_search['disabled_bootstrap'] ?? 0 !== 1) {
            $enqueue_script_names[] = 'aios-starter-theme-bootstrap-js';
        }

        if (isset($options['lazyframe']) && $options['lazyframe'] === 1) {
            $enqueue_style_names[] = 'aios-lazyframe';
            $enqueue_script_names[] = 'aios-lazyframe';
        }


        // Compass Fonts
        // Serif
        if (isset($options['compass_serif']) && $options['compass_serif'] === 1) {
            $enqueue_style_names[] = 'aios-compass-serif';
            $enqueue_script_names[] = 'aios-compass-serif';
        }

        // Sans Serif
        if (isset($options['compass_sans_serif']) && $options['compass_sans_serif'] === 1) {
            $enqueue_style_names[] = 'aios-compass-sans-serif';
            $enqueue_script_names[] = 'aios-compass-sans-serif';
        }

        // GT Pressura Mono 
        if (isset($options['compass_pressura_mono']) && $options['compass_pressura_mono'] === 1) {
            $enqueue_style_names[] = 'aios-compass-pressura-mono';
            $enqueue_script_names[] = 'aios-compass-pressura-mono';
        }

        if (isset($options['picturefill']) && $options['picturefill'] === 1) {
            $enqueue_script_names[] = 'aios-picturefill';
        }

        if (isset($options['utilities']) && $options['utilities'] === 1) {
            $enqueue_style_names[] = 'aios-utilities-style';
        }

        if (isset($options['animate']) && $options['animate'] === 1) {
            $enqueue_style_names[] = 'aios-animate-style';
        }

        if (isset($options['autosize']) && $options['autosize'] === 1) {
            $enqueue_script_names[] = 'aios-autosize-script';
        }

        // chainHight fallback
        if ((isset($options['chainHight']) && $options['chainHight'] === 1) || (isset($options['chainHeight']) && $options['chainHeight'] === 1)) {
            $enqueue_script_names[] = 'aios-chain-height-script';
        }

        if (isset($options['elementpeek']) && $options['elementpeek'] === 1) {
            $enqueue_script_names[] = 'aios-elementpeek-script';
        }

        if (isset($options['sidebar_navigation']) && $options['sidebar_navigation'] === 1) {
            $enqueue_script_names[] = 'aios-sidebar-navigation-script';
        }

        if (isset($options['slick']) && $options['slick'] === 1) {
            $enqueue_style_names[] = 'aios-slick-style';
            $enqueue_script_names[] = 'aios-slick-script';
        }

        if (isset($options['slick-1-8-1']) && $options['slick-1-8-1'] === 1) {
            $enqueue_style_names[] = 'aios-slick-1-8-1-style';
            $enqueue_script_names[] = 'aios-slick-1-8-1-script';
        }

        if (isset($options['swiper']) && $options['swiper'] === 1) {
            $enqueue_style_names[] = 'aios-swiper-style';
            $enqueue_script_names[] = 'aios-swiper-script';
        }

        if (isset($options['simplebar']) && $options['simplebar'] === 1) {
            $enqueue_style_names[] = 'aios-simplebar-style';
            $enqueue_script_names[] = 'aios-simplebar-script';
        }

        if (isset($options['aos']) && $options['aos'] === 1) {
            $enqueue_style_names[] = 'aios-aos-style';
            $enqueue_script_names[] = 'aios-aos-script';
        }

        if (isset($options['splitNav']) && $options['splitNav'] === 1)
            $enqueue_script_names[] = 'aios-splitNav-script';

        if (isset($options['videoPlyr']) && $options['videoPlyr'] === 1) {
            $enqueue_style_names[] = 'aios-video-plyr';
            $enqueue_script_names[] = 'aios-video-plyr';
        }

        if ($quick_search['enabled'] ?? '' !== '') {
            $enqueue_style_names[] = 'aios-bootstrap-select';
            $enqueue_script_names[] ='aios-bootstrap-select';
            $enqueue_script_names[] = 'aios-quick-search-js';
        }

        return [
            'styles' => $enqueue_style_names,
            'scripts' => $enqueue_script_names,
        ];
    }

    protected function enqueue_separated_assets($handlers, $qs_options)
    {
        if (isset($handlers['scripts'])) {
            $separated_styles = $this->separated_styles();

            foreach ($handlers['styles'] as $style_name) {
                wp_enqueue_style($style_name, $separated_styles[$style_name]);
            }
        }

        if (isset($handlers['scripts'])) {
            $separated_scripts = $this->separated_scripts();

            foreach ($handlers['scripts'] as $script_name) {
                wp_enqueue_script($script_name, $separated_scripts[$script_name], ['jquery'], null, $script_name === 'aios-lazyframe');
            }
        }
    }

    /**
     * Real Scout Banners Inline Styles
     * please update from src/scss/real-scout.scss
	 * copy the build from resources/vite/css/real-scout.css
     */
    protected function rs_assets($type, $removeSharedStyle = false)
    {
        $style = "";
        $simpleArray = [
            'default',
            'simple-one',
            'simple-two',
            'simple-three',
        ];

        // please update from src/scss/real-scout.scss
        // copy the buil from resources/vite/css/real-scout.css
        if ( in_array( $type, $simpleArray ) && $removeSharedStyle === false ) {
            $style = ".rs-single-bg{background-size:cover;background-position:center}.rs-single-mobile-only-flex{display:inline-flex!important}.rs-single-desktop-only,.rs-single-desktop-only-flex{display:none!important}.rs-single-pby{display:flex;align-items:flex-end;gap:6px;margin-top:48px}.rs-single-pby span{font-size:11px!important;line-height:1.6;color:#fff;text-transform:uppercase}.rs-single-pby img{max-width:111px;width:100%}.rs-single-heading{font-weight:600!important;font-size:24px!important;line-height:1.2;color:inherit;margin:0!important}.rs-single-paragraph{font-weight:400;font-size:16px!important;line-height:1.5;letter-spacing:-.02em;color:inherit;margin:8px 0 0!important}.rs-single-btn{display:flex;justify-content:center;align-items:center;padding:14px 20px;margin-top:24px;max-width:264px;min-height:49px;background:linear-gradient(90deg,#304BF4 0%,#21ADF4 100%);border-radius:2px;font-weight:600;font-size:14px!important;line-height:1.5;text-align:center;letter-spacing:.08em;text-transform:uppercase;color:var(--font-color-rs-btn, #FFFFFF)!important}.rs-single-btn:hover{color:var(--font-color-rs-btn, #FFFFFF)!important}@media screen and (min-width: 744px){.rs-single-mobile-only,.rs-single-mobile-only-flex{display:none!important}.rs-single-desktop-only{display:inline-block!important}.rs-single-desktop-only-flex{display:inline-flex!important}}@media screen and (min-width: 1024px){.rs-single-pby{margin-top:118px}.rs-single-heading{font-size:34px!important}}@media screen and (min-width: 1280px){.rs-single-pby{margin-top:59px}.rs-single-heading{font-size:48px!important}}";
        }

        switch ( $type ) {
            case 'default':
                $style .= ".rs-single-default{overflow:hidden;color:#1c1e26}.rs-single-default .rs-single-container{position:relative;display:flex;flex-direction:column;gap:16px;padding:32px 16px}.rs-single-default .rs-single-container .rs-single-content{position:relative;z-index:5}.rs-single-default .rs-single-container .rs-single-heading{font-weight:900!important;font-size:24px!important;line-height:1.2!important}.rs-single-default .rs-single-container .rs-single-paragraph{font-size:12px!important}.rs-single-default .rs-single-container .rs-single-btn{display:inline-flex;max-width:none;padding:16px 32px;font-size:12px!important;border-radius:10px;background:#1C1E26}.rs-single-default .rs-single-container .rs-single-pby{margin-top:0}.rs-single-default .rs-single-container .rs-single-pby span{color:#1c1e26}.rs-single-default .rs-single-container .rs-single-device{position:relative;overflow:hidden}.rs-single-default .rs-single-container .rs-single-device canvas{display:block;width:100%;height:auto}.rs-single-default .rs-single-container .rs-single-device img{position:absolute;top:50%;left:50%;width:125%;height:118%;transform:translate(-41%,-56%);-o-object-fit:cover;object-fit:cover;-o-object-position:center;object-position:center}@media screen and (min-width: 427px){.rs-single-default .rs-single-container .rs-single-content{max-width:400px;min-width:400px}}@media screen and (min-width: 744px){.rs-single-default .rs-single-container{flex-direction:row;padding:73px 40px}.rs-single-default .rs-single-container .rs-single-heading{font-size:32px!important}.rs-single-default .rs-single-container .rs-single-pby{margin-top:36px}.rs-single-default .rs-single-container .rs-single-device{position:static;overflow:visible}.rs-single-default .rs-single-container .rs-single-device canvas{display:none}.rs-single-default .rs-single-container .rs-single-device img{top:-37%;left:447px;width:721px;height:auto;-o-object-fit:initial;object-fit:initial;-o-object-position:initial;object-position:initial;transform:none}}@media screen and (min-width: 1024px){.rs-single-default .rs-single-container{padding:43px 40px}.rs-single-default .rs-single-container .rs-single-content{max-width:470px;min-width:470px}.rs-single-default .rs-single-container .rs-single-heading{font-size:44px!important}.rs-single-default .rs-single-container .rs-single-paragraph{font-size:14px!important}.rs-single-default .rs-single-container .rs-single-btn{font-size:16px!important}.rs-single-default .rs-single-container .rs-single-device img{top:-47%;left:544px;width:763px}}@media screen and (min-width: 1280px){.rs-single-default .rs-single-container{max-width:1440px;width:100%;margin:0 auto;padding:70px 88px}.rs-single-default .rs-single-container .rs-single-content{max-width:656px;min-width:656px}.rs-single-default .rs-single-container .rs-single-device img{top:-36%;left:732px;width:694px}}";

                break;

            case 'simple-one':
                $style .= ".rs-single-vone{overflow:hidden}.rs-single-vone .rs-single-container{display:flex;flex-direction:column;padding:38px 24px}.rs-single-vone .rs-single-container .rs-single-content{position:relative;padding:20px 16px;background:linear-gradient(217.72deg,rgba(255,255,255,.2) 2.86%,rgba(255,255,255,0) 92.13%);color:#fff}.rs-single-vone .rs-single-container .rs-single-content:before,.rs-single-vone .rs-single-container .rs-single-content:after{content:\"\";position:absolute;top:100%;left:0;width:100%;height:2px;background:linear-gradient(112.5deg,#CB952F 24.4%,#EFCF66 48.45%,#FFE6A8 65.81%)}.rs-single-vone .rs-single-container .rs-single-content:after{top:auto;bottom:100%}.rs-single-vone .rs-single-container .rs-single-device{margin-top:48px}.rs-single-vone .rs-single-container .rs-single-device img{max-width:none;width:120%;height:auto;margin:0}@media screen and (min-width: 744px){.rs-single-vone .rs-single-container{flex-direction:row;align-items:center;gap:14px;padding:38px 32px}.rs-single-vone .rs-single-container .rs-single-content{min-width:326px;max-width:326px}.rs-single-vone .rs-single-container .rs-single-device{margin-top:0}}@media screen and (min-width: 1024px){.rs-single-vone .rs-single-container{gap:67px;padding:48px 38px}.rs-single-vone .rs-single-container{gap:78px;padding:45px 59px;max-width:1420px;width:100%;margin:0 auto}.rs-single-vone .rs-single-container .rs-single-content{padding:20px 24px;min-width:418px;max-width:418px}}@media screen and (min-width: 1280px){.rs-single-vone .rs-single-container .rs-single-content{padding:20px 24px;min-width:638px;max-width:638px}}";

                break;

            case 'simple-two':
                $style .= ".rs-single-vtwo{overflow:hidden;position:relative}.rs-single-vtwo .rs-single-bg-default{position:absolute;top:0;left:0;width:100%;height:70.205%}.rs-single-vtwo .rs-single-bg-accent{position:absolute;top:70.205%;left:0;width:100%;height:29.795%}.rs-single-vtwo .rs-single-container{position:relative;z-index:3;display:flex;flex-direction:column;gap:31px;padding:48px 0 60px}.rs-single-vtwo .rs-single-device{display:inline-flex;justify-content:flex-end}.rs-single-vtwo .rs-single-device img{max-width:none;width:110%;height:auto;margin:0}.rs-single-vtwo .rs-single-inner{display:inline-flex;justify-content:center;padding-right:46px;padding-left:34px}.rs-single-vtwo .rs-single-content{position:relative;padding:24px;color:#626262}.rs-single-vtwo .rs-single-content *{position:relative;z-index:2}.rs-single-vtwo .rs-single-content:before,.rs-single-vtwo .rs-single-content:after{content:\"\";position:absolute;top:0;right:0;bottom:0;left:0;background:#FFFFFF;border-radius:4px;z-index:1}.rs-single-vtwo .rs-single-content:after{top:12px;right:-12px;bottom:-12px;left:12px;z-index:0;background:linear-gradient(90deg,#92C2FF 0%,#0071FF 43.5%,#151A26 100%)}.rs-single-vtwo .rs-single-content h2{font-size:20px!important;line-height:1.4;color:#000}.rs-single-vtwo .rs-single-content p{max-width:325px;margin-top:12px;font-size:14px!important;line-height:1.7}.rs-single-vtwo .rs-single-btn{font-size:16px!important}@media screen and (min-width: 744px){.rs-single-vtwo .rs-single-bg-default{width:65.322%;height:100%}.rs-single-vtwo .rs-single-bg-accent{top:0;right:0;left:auto;width:34.678%;height:100%}.rs-single-vtwo .rs-single-container{flex-direction:row;align-items:flex-end;justify-content:space-between;gap:0;padding-top:60px}.rs-single-vtwo .rs-single-device{width:43%}.rs-single-vtwo .rs-single-inner{padding-right:81px;padding-left:0;width:57%}.rs-single-vtwo .rs-single-content{max-width:326px;min-width:326px}.rs-single-vtwo .rs-single-content h2{font-size:24px!important;line-height:1.2}.rs-single-vtwo .rs-single-content p{font-size:15px!important;line-height:1.6}}@media screen and (min-width: 1024px){.rs-single-vtwo .rs-single-bg-default{width:69.238%}.rs-single-vtwo .rs-single-bg-accent{width:30.762%}.rs-single-vtwo .rs-single-container{padding-top:31px;padding-bottom:55px}.rs-single-vtwo .rs-single-device{width:auto}.rs-single-vtwo .rs-single-inner{padding-right:182px;padding-left:91px;width:auto}.rs-single-vtwo .rs-single-inner{padding-right:239px;padding-left:73px;width:auto}.rs-single-vtwo .rs-single-content{max-width:379px;min-width:379px;padding:26px 35px}.rs-single-vtwo .rs-single-content h2{font-size:28px!important;line-height:1.4}}@media screen and (min-width: 1280px){.rs-single-vtwo .rs-single-bg-default{width:65.234%}.rs-single-vtwo .rs-single-bg-accent{width:34.766%}.rs-single-vtwo .rs-single-container{align-items:center;padding-top:27px;padding-bottom:27px;max-width:1400px;width:100%;margin:0 auto}.rs-single-vtwo .rs-single-content{max-width:471px;min-width:471px}.rs-single-vtwo .rs-single-content h2{font-size:40px!important;line-height:1.2}.rs-single-vtwo .rs-single-content h2 br{display:none}.rs-single-vtwo .rs-single-content p{max-width:340px}}";

                break;

            case 'simple-three':
                $style .= ".rs-single-vthree{overflow:hidden;position:relative}.rs-single-vthree .rs-single-bg-default{background-position:left;position:absolute;top:0;left:0;width:100%;height:71.795%}.rs-single-vthree .rs-single-bg-accent{position:absolute;top:71.795%;left:0;width:100%;height:28.205%}.rs-single-vthree .rs-single-container{position:relative;z-index:3;display:flex;flex-direction:column;gap:42px;padding:80px 20px 72px}.rs-single-vthree .rs-single-content{display:flex;flex-direction:column;align-items:center;text-align:center}.rs-single-vthree .rs-single-content h2{max-width:408px;font-size:28px!important;line-height:1.2}.rs-single-vthree .rs-single-content p{max-width:408px;font-size:14px!important;line-height:1.7}.rs-single-vthree .rs-single-btn{max-width:100%;width:100%;margin-top:8px;font-size:16px!important}.rs-single-vthree .rs-single-pby{margin-top:20px;justify-content:center}.rs-single-vthree .rs-single-pby span{color:#1c1e26}.rs-single-vthree .rs-single-device img{display:block;margin:0 auto;max-width:664px;width:100%}@media screen and (min-width: 427px){.rs-single-vthree .rs-single-content h2 br{display:none}.rs-single-vthree .rs-single-btn{max-width:339px}}@media screen and (min-width: 744px){.rs-single-vthree .rs-single-bg-default{height:62.579%}.rs-single-vthree .rs-single-bg-accent{top:62.579%;height:37.421%}.rs-single-vthree .rs-single-container{gap:73px;padding:87px 40px 72px}.rs-single-vthree .rs-single-content h2{font-size:34px!important;line-height:1.3}.rs-single-vthree .rs-single-pby{margin-top:16px}}@media screen and (min-width: 1024px){.rs-single-vthree .rs-single-bg-default{width:61.23%;height:100%}.rs-single-vthree .rs-single-bg-accent{top:0;right:0;left:auto;width:38.77%;height:100%}.rs-single-vthree .rs-single-container{flex-direction:row;align-items:center;gap:24px;padding:85px 40px}.rs-single-vthree .rs-single-content{max-width:414px;min-width:414px;align-items:flex-start;text-align:left}.rs-single-vthree .rs-single-content h2{font-size:38px!important;line-height:1.2}.rs-single-vthree .rs-single-content h2 br{display:block}.rs-single-vthree .rs-single-btn{margin-top:24px}.rs-single-vthree .rs-single-pby{margin-top:36px;justify-content:flex-start}.rs-single-vthree .rs-single-device img{max-width:100%}}@media screen and (min-width: 1280px){.rs-single-vthree .rs-single-bg-default{width:55.833%}.rs-single-vthree .rs-single-bg-accent{width:44.167%}.rs-single-vthree .rs-single-container{gap:52px;padding:51px 48px;max-width:1440px;width:100%;margin:0 auto}.rs-single-vthree .rs-single-content{max-width:498px;min-width:498px}.rs-single-vthree .rs-single-content h2{max-width:100%;font-size:44px!important}.rs-single-vthree .rs-single-content p{max-width:100%}.rs-single-vthree .rs-single-content p br{display:none}}";

                break;

            case 'wmhw':
                $style = ".rs-wmhw-bg{background-size:cover;background-position:center}.rs-wmhw-desktop-only{display:none}.rs-wmhw-subtitle{display:flex;align-items:flex-end;gap:10px;padding:18px 0;font-weight:600;font-size:18px!important;line-height:1;color:#00194f;text-transform:uppercase;white-space:nowrap}.rs-wmhw-subtitle span:last-child{background:linear-gradient(45deg,#7ACAFF 10.82%,#4882FF 97.04%);max-width:189px;width:100%;height:4px;margin-bottom:3px}.rs-wmhw-container h2{font-weight:600!important;font-size:52px!important;line-height:1.1;color:#00194f;margin:0!important;text-transform:uppercase}.rs-wmhw-container p{font-weight:400;font-size:14px!important;line-height:1.7;letter-spacing:-.02em;color:#1c1e26;margin:18px 0 0!important}.rs-wmhw-btn{display:flex;justify-content:center;align-items:center;padding:14px 20px;margin-top:42px;width:100%;min-height:52px;background:linear-gradient(90deg,#304BF4 0%,#21ADF4 100%);border-radius:2px;font-weight:600;font-size:16px!important;line-height:1.5;text-align:center;letter-spacing:.08em;text-transform:uppercase;color:var(--font-color-rs-btn, #FFFFFF)!important}.rs-wmhw-btn:hover{color:var(--font-color-rs-btn, #FFFFFF)!important}.rs-wmhw-vone{overflow:hidden}.rs-wmhw-vone .rs-wmhw-section{position:relative}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-img-overlay{position:absolute;top:0;left:71px;max-width:none;width:auto;height:536px}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-img-accent{position:absolute;left:0;bottom:0;max-width:none;width:auto;height:100%}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-container{position:relative;z-index:3;display:flex;flex-direction:column;gap:26px;padding-top:38px;padding-bottom:0}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-content{padding-right:20px;padding-left:20px}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-device{position:relative;padding:43px 0 43px 20px}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-device-img{position:relative;max-width:none;width:123.385%;height:auto;margin:0}@media screen and (min-width: 600px){.rs-wmhw-btn{max-width:339px}}@media screen and (min-width: 744px){.rs-wmhw-mobile-only{display:none}.rs-wmhw-desktop-only{display:inline-block}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-img-overlay{left:105px;min-height:536px;height:103.5%}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-img-accent{height:100%;left:50%}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-container{flex-direction:row;align-items:flex-end;justify-content:space-between;gap:22px;padding:38px 0 127px 44px}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-content{padding-right:0;padding-left:0;max-width:338px;min-width:338px}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-device{padding:0;max-width:442px}}@media screen and (min-width: 1024px){.rs-wmhw-container h2 br{display:none}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-img-accent{left:47.754vw}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-container{align-items:flex-start;padding:76px 0 76px 74px}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-content{max-width:463px;min-width:463px}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-device{max-width:100%}}@media screen and (min-width: 1280px){.rs-wmhw-subtitle{padding:0;font-size:28px!important;line-height:1.2}.rs-wmhw-subtitle span:last-child{max-width:322px;margin-bottom:8px}.rs-wmhw-container h2{font-size:66px!important;line-height:1}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-img-overlay{left:16.528vw}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-img-accent{left:46.806vw}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-container{max-width:1440px;width:100%;margin:0 auto;align-items:center;padding:50px 0 50px 104px}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-content{max-width:492px;min-width:492px}.rs-wmhw-vone .rs-wmhw-section .rs-wmhw-device{max-width:521px}}";

                break;

            case 'combined':
                $style = ".rs-combined-bg{background-size:cover;background-position:center}.rs-combined-desktop-only{display:none}.rs-combined-subtitle{display:flex;align-items:flex-end;gap:10px;padding:18px 0;font-weight:600;font-size:18px!important;line-height:1;color:#00194f;text-transform:uppercase;white-space:nowrap}.rs-combined-subtitle span:last-child{background:linear-gradient(45deg,#7ACAFF 10.82%,#4882FF 97.04%);max-width:189px;width:100%;height:4px;margin-bottom:3px}.rs-combined-container h2{font-weight:600!important;font-size:24px!important;line-height:1.2;color:inherit;margin:0!important}.rs-combined-container p{font-weight:400;font-size:14px!important;line-height:1.7;letter-spacing:-.02em;color:inherit;margin:8px 0 0!important}.rs-combined-btn{display:inline-flex;justify-content:center;align-items:center;padding:14px 20px;margin-top:16px;min-width:160px;min-height:52px;background:#21ADF4;border-radius:10px;font-weight:600;font-size:16px!important;line-height:1.5;text-align:center;text-transform:uppercase;color:var(--font-color-rs-btn, #FFFFFF)!important}.rs-combined-btn:hover{color:var(--font-color-rs-btn, #FFFFFF)!important}.rs-combined-pby{display:flex;align-items:flex-end;gap:6px;margin-top:16px}.rs-combined-pby span{font-size:11px!important;line-height:1.6;color:inherit;text-transform:uppercase}.rs-combined-pby img{max-width:111px;width:100%}.rs-combined-marketing-background{position:absolute;top:0;left:0;z-index:0;width:100%;height:100%;-o-object-fit:cover;object-fit:cover;-o-object-position:center;object-position:center}.rs-combined-vone{position:relative;overflow:hidden}.rs-combined-vone .rs-combined-container .rs-combined-content{display:inline-flex;flex-direction:column;justify-content:space-between}.rs-combined-vone .rs-combined-container .rs-combined-data{position:relative;z-index:5;padding:24px 24px 0;max-width:287px;width:100%}.rs-combined-vone .rs-combined-container .rs-combined-marketing{position:relative;color:#fff}.rs-combined-vone .rs-combined-container .rs-combined-marketing-background{position:absolute;top:0;left:0;z-index:0;width:100%;height:100%;-o-object-fit:cover;object-fit:cover;-o-object-position:center;object-position:center}.rs-combined-vone .rs-combined-container .rs-combined-marketing-device{position:relative;z-index:2;padding:8px 24px 0}.rs-combined-vone .rs-combined-container .rs-combined-marketing-device img{display:block;width:100%;height:auto}.rs-combined-vone .rs-combined-container .rs-combined-hworth{position:relative;color:#1c1e26}.rs-combined-vone .rs-combined-container .rs-combined-hworth-background{position:absolute;right:0;bottom:0;z-index:0;width:282px;height:auto}.rs-combined-vone .rs-combined-container .rs-combined-hworth-device{position:relative;z-index:2;padding:36px 0 6px 24.8vw}.rs-combined-vone .rs-combined-container .rs-combined-hworth-device img{display:block;width:110%;height:auto}@media screen and (min-width: 744px){.rs-combined-mobile-only{display:none}.rs-combined-desktop-only{display:inline-block}.rs-combined-marketing-background{width:50%}.rs-combined-vone .rs-combined-container{display:flex}.rs-combined-vone .rs-combined-container .rs-combined-content{flex-grow:1;flex-basis:0}.rs-combined-vone .rs-combined-container .rs-combined-marketing-device{padding-top:0}.rs-combined-vone .rs-combined-container .rs-combined-hworth-device{padding-left:12.097vw;padding-bottom:0}}@media screen and (min-width: 1024px){.rs-combined-container h2{font-size:34px!important;line-height:1.1}.rs-combined-btn,.rs-combined-pby{margin-top:20px}.rs-combined-vone .rs-combined-container .rs-combined-data{padding:36px 36px 0;max-width:100%}.rs-combined-vone .rs-combined-container .rs-combined-marketing{padding-bottom:172px}.rs-combined-vone .rs-combined-container .rs-combined-marketing h2{max-width:424px;font-size:28px!important;line-height:1.2}.rs-combined-vone .rs-combined-container .rs-combined-marketing-device{padding:0;position:absolute;right:36px;bottom:0;max-width:362px}.rs-combined-vone .rs-combined-container .rs-combined-hworth{padding-bottom:112px}.rs-combined-vone .rs-combined-container .rs-combined-hworth p{max-width:289px}.rs-combined-vone .rs-combined-container .rs-combined-hworth-device{padding:0;position:absolute;left:49%;bottom:20px}.rs-combined-vone .rs-combined-container .rs-combined-hworth-device img{width:140%}}@media screen and (min-width: 1280px){.rs-combined-subtitle{padding:0;font-size:28px!important;line-height:1.2}.rs-combined-subtitle span:last-child{max-width:322px;margin-bottom:8px}.rs-combined-vone .rs-combined-container{max-width:1440px;width:100%;margin:0 auto}.rs-combined-vone .rs-combined-container .rs-combined-data{padding:46px}.rs-combined-vone .rs-combined-container .rs-combined-marketing h2{max-width:541px;font-size:34px!important;line-height:1.1}.rs-combined-vone .rs-combined-container .rs-combined-marketing-device{max-width:none;right:46px;left:46px}.rs-combined-vone .rs-combined-container .rs-combined-hworth-device{left:43%}}";

                break;
            
            default:
                break;
        }

        return "<style>$style</style>";
    }
}
