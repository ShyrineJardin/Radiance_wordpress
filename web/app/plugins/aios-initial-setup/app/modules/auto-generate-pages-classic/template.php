<?php

namespace AiosInitialSetup\App\Modules\AutoGeneratePagesClassicEditor;

class Template
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts'], 20);
        add_action('wp_footer', [$this, 'inline_scripts'], 100);
        add_filter('template_include', [$this, 'template'], 11);
    }

    public function enqueue_scripts()
    {
        $cdnUrl = cdnDomainSwitcher();
        $queried_object = get_queried_object();
        $option = get_option(AIOS_AUTO_GENERATE_PAGES, []);

        if (!is_null($queried_object) && isset($option[$queried_object->ID])) {
            $pluginUrl = plugin_dir_url(__FILE__) . "templates/{$option[$queried_object->ID]["type"]}/{$option[$queried_object->ID]["theme"]}";

            wp_enqueue_style('aios-generate-page-template', "{$pluginUrl}/styles.css");

            // Enqueue AOS not enabled
            if (wp_script_is('aios-aos-script') === false) {
                wp_enqueue_style('aios-aos-style', "$cdnUrl/libraries/css/aos.min.css");
                wp_enqueue_script('aios-aos-script', "$cdnUrl/libraries/js/aos.min.js");
            }

            // Enqueue Slick not enabled
            if ($option[$queried_object->ID]["has_slick"] && wp_script_is('aios-slick-script') === false && wp_script_is('aios-slick-1-8-1-script') === false) {
                wp_enqueue_style('aios-slick-1-8-1-style', "$cdnUrl/libraries/css/slick.min.1.8.1.css");
                wp_enqueue_script('aios-slick-1-8-1-script', "$cdnUrl/libraries/js/slick.min.1.8.1.js");
            }

            if ($option[$queried_object->ID]["has_script"]) {
                wp_enqueue_script('aios-generate-page-template', "{$pluginUrl}/scripts.js");
            }

            // Dequeue deprecated generate styling
            wp_dequeue_style('aios-generated-about-page');
            wp_dequeue_style('aios-generated-contact-page');
        }
    }
    
    /**
     * Animate-On-Scroll
     *
     * @return void
     */
    public function inline_scripts()
    {
        $libraries = get_option('aios-enqueue-cdn');

        if ($libraries['aos'] ?? '' === 1) {
            // Initialize Animate-On-Scroll
            if ($libraries['aos-mobile'] ?? '' === 1) {
                echo "<script type=\"text/javascript\">\"undefined\"!=typeof AOS&&AOS.init();</script>";
            } else {
                echo "<script type=\"text/javascript\">\"undefined\"!=typeof AOS&&AOS.init({disable:\"mobile\"});</script>";
            }
        }
    }

    public function template($template)
    {
        $queried_object = get_queried_object();
        $page_id = !is_null($queried_object) ? $queried_object->ID : null;
        $option = get_option(AIOS_AUTO_GENERATE_PAGES, []);

        if (!is_null($page_id) && isset($option[$page_id])) {
            if ($option[$page_id]['product_tye'] === 'agent-pro') {
                return __DIR__ . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "agent-pro.default.php";
            } else {
                return __DIR__ . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . $option[$page_id]["type"] . DIRECTORY_SEPARATOR . $option[$page_id]["theme"] . DIRECTORY_SEPARATOR . "index.php";
            }
        }

        return $template;
    }
}

new Template();
