<?php

namespace AiosInitialSetup\App\Controllers;

class AboutContactController
{
    /**
     * Template Setup constructor.
     */
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'load_template_assets'], 11);
        add_action('wp_head', [$this, 'inline_style'], 10);
        add_action('wp_footer', [$this, 'inline_scripts'], 100);
        add_filter('the_content', [$this, 'filter_the_content'], 20);
        add_filter('template_include', [$this, 'template'], 11);
    }

    /**
     * Enqueue Scripts
     *
     * @access public
     * @return void
     */
    public function load_template_assets()
    {
        if (is_page()) {
            $about_options = get_option('about_options', []);
            $contact_options = get_option('contact_options', []);
            
            if (isset($about_options['page_id']) || isset($contact_options['page_id'])) {
                $template_type = isset($about_options['page_id']) && get_the_ID() === (int) $about_options['page_id'] 
                    ? "about" : (
                        isset($contact_options['page_id']) && get_the_ID() === (int) $contact_options['page_id'] 
                            ? "contact" : ""
                    );
                $template_has_js = "";
                $template_url = "";

                if (! empty($template_type)) {
                    $theme = get_option("$template_type-theme", '');

                    if (! empty($theme)) {
                        $template_has_js = strpos($theme, 'has-js') !== false;
                        $template_url = AIOS_INITIAL_SETUP_URL . 'resources/templates/' . $template_type . '/' . $theme;
                    }
                }

                if (! empty($template_url)) {
                    $cdnUrl = cdnDomainSwitcher();
    
                    if (wp_script_is('aios-aos-script') === false) {
                        wp_enqueue_style('aios-aos-style', "$cdnUrl/libraries/css/aos.min.css");
                        wp_enqueue_script('aios-aos-script', "$cdnUrl/libraries/js/aos.min.js");
                    }
        
                    if (wp_script_is('aios-sticky') === false){
                        wp_enqueue_script('aios-sticky', 'https://cdnjs.cloudflare.com/ajax/libs/sticky-js/1.3.0/sticky.min.js');
                    }

                    if (wp_script_is('aios-slick-script') === false && wp_script_is('aios-slick-1-8-1-script') === false) {
                        wp_enqueue_style('aios-slick-1-8-1-style', "$cdnUrl/libraries/css/slick.min.1.8.1.css");
                        wp_enqueue_script('aios-slick-1-8-1-script', "$cdnUrl/libraries/js/slick.min.1.8.1.js");
                    }

                    wp_enqueue_style("aios-$template_type-style", $template_url . '/styles.css');
                    
                    if ($template_has_js) {
                        wp_enqueue_script("aios-$template_type-script", $template_url . '/scripts.js');
                    }

                    wp_dequeue_style('aios-generated-about-page');
                    wp_dequeue_style('aios-generated-contact-page');
                }
            }
        }
    }

    /**
     * Inline Scripts
     *
     * @access public
     * @return void
     */
    public function inline_style()
    {
        if (is_page()) {
            $about_options = get_option('about_options', []);
            $contact_options = get_option('contact_options', []);
            
            if (isset($about_options['page_id']) || isset($contact_options['page_id'])) {
                echo "<style>.custom-page-row{display:flex;margin-right:-15px;margin-left:-15px}.custom-page-col{position:relative;padding:0 15px;margin-top:15px;flex-grow:1;flex-basis:0}.custom-page-row:first-child .custom-page-col{margin-top:0}.custom-page-submit{justify-content:center}.custom-page-submit .custom-page-col{flex-grow:0}.custom-page-col label{font-size:inherit;margin-bottom:10px}.custom-page-hidden-label .custom-page-col label{display:none}.custom-page-col span{display:block;position:relative}.custom-page-col input[type=email],.custom-page-col input[type=phone],.custom-page-col input[type=text],.custom-page-col textarea{outline: 0;display:block;appearance:none;width:100%;padding:6px;border:solid 1px rgba(0,0,0,.3)}.custom-page-col textarea{resize:none;height:80px}.custom-page-col button[type=submit],.custom-page-col input[type=submit]{appearance:none;border:0;background-color:transparent}.custom-page-col button[type=submit]{display:none;position:absolute;right:25px;bottom:10px;padding:0!important;margin:0!important}.custom-page-col input[type=submit]{border:solid 1px rgba(0,0,0,.3);padding:5px 15px;transition: all 150ms linear}.custom-page-col .wpcf7-spinner{position:absolute;bottom:50%;right:-15px;margin:0!important;transform:translateY(50%)}.wpcf7 form.custom-page-cf span.wpcf7-not-valid-tip{position:absolute;top:auto;left:auto;bottom:50%;right:3px;width:auto;transform:translateY(50%)}.wpcf7 form.custom-page-cf .wpcf7-response-output{margin:20px 0 0;text-align:center}@media only screen and (max-width:480px){.custom-page-row{flex-direction:column}.custom-page-row:first-child .custom-page-col{margin-top:15px}}</style>";
            }
        }
    }

    /**
     * Inline Scripts
     *
     * @access public
     * @return void
     */
    public function inline_scripts()
    {
        if (is_page()) {
            $about_options = get_option('about_options', []);
            $contact_options = get_option('contact_options', []);
            
            if (isset($about_options['page_id']) || isset($contact_options['page_id'])) {
                $libraries = get_option('aios-enqueue-cdn');

                if ($libraries['aos'] ?? '' === 1) {
                    if ($libraries['aos-mobile'] ?? '' === 1) {
                        echo "<script type=\"text/javascript\">\"undefined\"!=typeof AOS&&AOS.init();</script>";
                    } else {
                        echo "<script type=\"text/javascript\">\"undefined\"!=typeof AOS&&AOS.init({disable:\"mobile\"});</script>";
                    }
                }
            }
        }
    }

    /**
     * Filter Content
     *
     * @param $content
     * @return string
     */
    public function filter_the_content($content)
    {
        if (is_page()) {
            $about_options = get_option('about_options', []);
            $contact_options = get_option('contact_options', []);
            
            $template_type = isset($about_options['page_id']) && get_the_ID() === (int) $about_options['page_id'] 
                ? "about" : (
                    isset($contact_options['page_id']) && get_the_ID() === (int) $contact_options['page_id'] 
                        ? "contact" : ""
                );

            if (! empty($template_type)) {
                $theme = get_option("$template_type-theme", '');

                if (! empty($theme)) {
                    $file = AIOS_INITIAL_SETUP_DIR . 'resources' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $template_type . DIRECTORY_SEPARATOR . $theme . DIRECTORY_SEPARATOR . 'template.php';

                    if (file_exists($file)) {
                        require_once $file;
                        $templateContent = \AiosInitialSetup\Resources\Template\ContentTemplate::render();
                        return $templateContent . $content;
                    }
                }
            }
        }

        return $content;
    }

    public function template($template)
    {
        if (is_page()) {
            $about_options = get_option('about_options', []);
            $contact_options = get_option('contact_options', []);

            if (isset($about_options['page_id']) || isset($contact_options['page_id'])) {
                $file_path = "";
                $resource_path = AIOS_INITIAL_SETUP_DIR . 'resources' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
                $template_type = isset($about_options['page_id']) && get_the_ID() === (int) $about_options['page_id'] 
                    ? "about" : (
                        isset($contact_options['page_id']) && get_the_ID() === (int) $contact_options['page_id'] 
                            ? "contact" : ""
                    );

                if (! empty($template_type)) {
                    $theme = get_option("$template_type-theme", '');

                    if (! empty($theme)) {
                        if (strpos($theme, 'agent-pro') !== false) {
                            $file_path = $resource_path . 'agent-pro.default.php';
                        } else {
                            $file_path = $resource_path . $template_type . DIRECTORY_SEPARATOR . $theme . DIRECTORY_SEPARATOR . 'index.php';
                        }
                    }
                }

                if (! empty($file_path)) {
                    return $file_path;
                }
            }
        }

        return $template;
    }

}

new AboutContactController();
