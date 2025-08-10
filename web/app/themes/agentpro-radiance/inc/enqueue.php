<?php 
    class AIOSSTARTETHEMEENQUEUE
    {

        /**
         * Admin constructor.
         */
        public function __construct()
        {
            add_action( 'wp_enqueue_scripts', [$this, 'ai_starter_theme_enqueue_assets'] );

        }

        /*
        * Enqueue theme styles and scripts
        */
        function ai_starter_theme_enqueue_assets() {
            
            /* AIOS CDN */
            $cdn = 'https://resources.agentimage.com';

            /* Fonts */
            wp_enqueue_style( 'playfair-font', 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

            wp_enqueue_style( 'lato-font', 'https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');

            /* Styles */
            wp_enqueue_style( 'aios-starter-theme-defaults', get_template_directory_uri().'/assets/css/defaults.min.css' );
            wp_enqueue_style( 'aios-starter-theme-style', get_template_directory_uri().'/assets/css/global.min.css' );

            
            /* Enqueue globals */
            wp_register_script('aios-starter-theme-global', $cdn . '/libraries/js/global.min.js');
            wp_enqueue_script('aios-starter-theme-global');
            
            wp_enqueue_script('aios-starter-theme-script', get_template_directory_uri() . '/assets/js/scripts.min.js');
            /* Scripts */

            /* Custom Contact template Enqueue */
            if ( is_page_template( 'templates/contact.php' ) ) {
                wp_enqueue_style('custom-style-contact', get_template_directory_uri() . '/assets/css/contact.min.css', array(), '1.0.0');
            }

            /* Custom About template Enqueue */
            if ( is_page_template( 'templates/about.php' ) ) {
                wp_enqueue_style('custom-style-about', get_template_directory_uri() . '/assets/css/about.min.css', array(), '1.0.0');
            }

            /* Homepage Specific Enqueue */
            if( is_home() ) {
                wp_enqueue_style( 'aios-starter-theme-home', get_template_directory_uri().'/assets/css/homepage.min.css' );
                wp_enqueue_script('aios-starter-theme-home', get_template_directory_uri() . '/assets/js/home.min.js');

            } else {
                wp_enqueue_style( 'aios-starter-theme-ip', get_template_directory_uri().'/assets/css/innerpage.min.css' );
            }

            /* Archive Specific Enqueue */
            if ( is_archive() || is_search() ) {
                
                wp_enqueue_style( 'aios-starter-theme-archive', get_template_directory_uri().'/assets/css/archive.min.css' );
            }

            /* Single Specific Enqueue */
            if ( is_single() ) {
                wp_enqueue_style( 'aios-starter-theme-archive', get_template_directory_uri().'/assets/css/single.min.css' );
            
                wp_register_script( 'aios-agentpro-single-script', get_template_directory_uri().'/assets/js/single.min.js' );
                if (!wp_script_is('agentpro-child-single-script', 'enqueued')) {
                    wp_enqueue_script('aios-agentpro-single-script');
                }
            }
        }
    }

    new AIOSSTARTETHEMEENQUEUE();