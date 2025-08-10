<?php 
    class AIOSSTARTETHEMERHOOKS
    {

        /**
         * Config Constructor
         */
        public function __construct()
        {

            /*
            * Add custom data attributes to menu items
            * @since 1.0.0
            */
            add_filter('nav_menu_link_attributes', [$this, 'ai_starter_theme_add_menu_link_attributes'], 10, 3);

            /*
            * Register menus
            * @action
            */
            add_action( 'init',  [$this, 'ai_starter_theme_register_menus'] );


            /*
            * Enable post thumbnails
            * @since 1.0.0
            */
            add_theme_support('post-thumbnails');
            set_post_thumbnail_size(150, 150);
            

            /*
            * Add custom classes to HP and IP
            * @fitler
            */
            add_filter('body_class', [$this, 'ai_starter_theme_extra_classes'] );


            /*
            * Hide admin bar on mobile devices
            */
            if ( $this->ai_starter_theme_is_mobile() ) {
                show_admin_bar( false );
            }

            /*
            * Allow shortodes on text widgets
            * @since 1.0.0
            */
            add_filter('widget_text', 'do_shortcode');

            /*
            * Format wp_title
            * @since 1.0.0
            */
            add_filter( 'wp_title', [$this, 'ai_starter_theme_title_filter'], 10, 2 );

            /*
            * Get content area class. Automatically uses 'content-full' if sidebar is empty.
            * @since 1.0.0
            */
            add_option( "ai_starter_theme_force_sidebar_visibility", false );

            /*
            * Remove Really Simple Discovery link
            * @since 1.0.0
            */

            remove_action( 'wp_head', 'rsd_link' );


            add_action( 'aios_starter_theme_before_inner_page_content', [$this, 'aios_starter_theme_before_inner_page_content_action'], 11 );


            $aios_metaboxes_breadcrumb = get_option('aios-metaboxes-breadcrumb', 0);
            if (is_array($aios_metaboxes_breadcrumb) && $aios_metaboxes_breadcrumb[1] !== '1') {
                add_filter( 'aios_starter_theme_before_inner_page_content_filter', [$this, 'aios_starter_theme_add_breadcrumbs'], 10 );
            }

			add_action( 'aios_starter_theme_before_entry', [$this, 'aios_starter_theme_before_entry_action'], 11 );
			add_filter( 'aios_starter_theme_before_entry_filter', [$this, 'ai_starter_theme_add_post_meta'], 10 );

			add_action( 'aios_starter_theme_after_entry_content', [$this, 'aios_starter_theme_after_entry_content_action'], 11 );
			add_filter( 'aios_starter_theme_after_entry_content_filter', [$this, 'ai_starter_theme_add_comments_section'], 10 );

            add_shortcode( 'aios_wp_search_form', [ $this, 'search_form' ] );

        }

        /*
        * Add custom data attributes to menu items
        * @since 1.0.0
        */
        public function ai_starter_theme_add_menu_link_attributes($atts, $item, $args)
        {
            $atts['data-title'] = $item->title;
            return $atts;
        }

        /*
        * Register menus
        * @since 1.0.0
        *
        * @access public
        * @return array
        */
        public function ai_starter_theme_register_menus() {
            register_nav_menu( 'primary-menu', 'Primary Menu' );
            register_nav_menu( 'secondary-menu', 'Secondary Menu (optional)' );
        }
                
        /*
        * Add custom classes to HP and IP
        * @since 1.0.0
        *
        * @access public
        * @return array
        */
        public function ai_starter_theme_extra_classes($c) {
            if ( is_home() ) {
                $c[] = "home-container";
            }
            else {
                $c[] = "ip-container";
            }
            return $c;
        }


        /*
        * Detect Mobile
        * @since 1.0.0
        *
        * @return bool
        */
        public function ai_starter_theme_is_mobile() {
            if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|playbook|sagem|sharp|sie-|silk|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT'])){
                return true;
            }
            else {
                return false;
            }
        }

        /*
        * Format wp_title
        * @since 1.0.0
        */
        public function ai_starter_theme_title_filter( $title, $sep ) {
            global $paged, $page;

            if ( is_feed() )
                return $title;

            // Add the site name.
            $title .= get_bloginfo( 'name' );

            // Add the site description for the home/front page.
            $site_description = get_bloginfo( 'description', 'display' );
            if ( $site_description && ( is_home() || is_front_page() ) )
                $title = "$title $sep $site_description";

            // Add a page number if necessary.
            if ( $paged >= 2 || $page >= 2 )
                $title = "$title $sep " . sprintf( __( 'Page %s', 'agentimage-theme' ), max( $paged, $page ) );

            return $title;
        }
        
        /**
		 * Display before content on innner page.
		 *
		 * @since 1.0.0
		 */
		function aios_starter_theme_before_inner_page_content_action( $content ) {

			echo apply_filters( 'aios_starter_theme_before_inner_page_content_filter', $content );

		}
		
		/**
		 * Add Yoast breadcrumbs on aios_starter_theme_before_inner_page_content_action
		 */
		function aios_starter_theme_add_breadcrumbs() {

		    // if both yoast and rank match is activagted
		    if ( is_plugin_active( 'wordpress-seo/wp-seo.php' )  && is_plugin_active( 'seo-by-rank-math/rank-math.php' )) {
               echo rank_math_the_breadcrumbs();
            }else{
                /// check if rank math is activated
                if (function_exists('rank_math_the_breadcrumbs')) {
                    echo rank_math_the_breadcrumbs();
                }
                // check if yoast fucntion is activated
                if ( function_exists('yoast_breadcrumb') ) {
                    echo yoast_breadcrumb( '<p id="breadcrumbs">','</p>', false );
                }

            }
		}

		/**
		 * Display post meta.
		 *
		 * @since 1.0.0
		 */
		function aios_starter_theme_before_entry_action( $content ) {

			echo apply_filters( 'aios_starter_theme_before_entry_filter', $content );

		}


		/*
		 * Add post meta
		 */

		function ai_starter_theme_add_post_meta() {
			
			$output = '<p class="aios-starter-theme-entry-meta">';
				$output .= '<span class="updated">Updated on ' . date('Y-m-d') . '</span>';
				$output .= '<span class="entry-meta-separator"> | </span>';
				$output .= 'Written by <span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>';
			$output .= '</p>';

			return $output;
			
		}

		/**
		 * Display comment section on innner page.
		 *
		 * @since 1.0.0
		 */
		function aios_starter_theme_after_entry_content_action( $content ) {

			echo apply_filters( 'aios_starter_theme_after_entry_content_filter', $content );

		}

		/**
		 * Add comments section
		 */
		function ai_starter_theme_add_comments_section( $content ) {
			
			return '<div class="comments-template">' . comments_template() . '</div>';
			
		}
        
        function search_form() {
            $queried_object = get_queried_object();
            $taxonomy = get_taxonomy( $queried_object->taxonomy );
            $postTypes = $taxonomy->object_type ?: [];
    
            return "<form role=\"search\" method=\"get\" id=\"searchform\" class=\"searchform\" action=\"" . esc_url( home_url( '/' ) ) . "\">
                <input type=\"hidden\" name=\"post_type\" value=\"" . implode( ',', $postTypes ) . "\" />
                <input type=\"hidden\" name=\"category_name\" value=\"" . $queried_object->slug . "\" />
                <label class=\"sr-only\" for=\"s\">Search</label>
                <input type=\"search\" name=\"s\" class=\"search-field paragraph\" placeholder=\"" . esc_attr_x( single_cat_title('Search ', false), 'placeholder' ) . "\" value=\"" . get_search_query() . "\" />
                <button type=\"submit\" class=\"search-submit site-button-submit\" />
                    <svg width=\"16\" height=\"16\" viewBox=\"0 0 16 16\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"currentColor\">
                        <path d=\"M5.9175 11.835C4.26363 11.835 2.86392 11.2622 1.71835 10.1166C0.572783 8.97108 0 7.57136 0 5.9175C0 4.26363 0.572783 2.86392 1.71835 1.71835C2.86392 0.572783 4.26363 0 5.9175 0C7.57136 0 8.97108 0.572783 10.1166 1.71835C11.2622 2.86392 11.835 4.26363 11.835 5.9175C11.835 6.58511 11.7288 7.21479 11.5164 7.80654C11.3039 8.39829 11.0156 8.92176 10.6515 9.37696L15.7496 14.4751C15.9165 14.642 16 14.8544 16 15.1124C16 15.3703 15.9165 15.5827 15.7496 15.7496C15.5827 15.9165 15.3703 16 15.1124 16C14.8544 16 14.642 15.9165 14.4751 15.7496L9.37696 10.6515C8.92176 11.0156 8.39829 11.3039 7.80654 11.5164C7.21479 11.7288 6.58511 11.835 5.9175 11.835ZM5.9175 10.0142C7.05548 10.0142 8.02276 9.61593 8.81934 8.81934C9.61593 8.02276 10.0142 7.05548 10.0142 5.9175C10.0142 4.77952 9.61593 3.81223 8.81934 3.01565C8.02276 2.21906 7.05548 1.82077 5.9175 1.82077C4.77952 1.82077 3.81223 2.21906 3.01565 3.01565C2.21906 3.81223 1.82077 4.77952 1.82077 5.9175C1.82077 7.05548 2.21906 8.02276 3.01565 8.81934C3.81223 9.61593 4.77952 10.0142 5.9175 10.0142Z\"/>
                    </svg>
                    " . esc_attr_x( ' Search', 'submit button' ) . "
                </button>
            </form>";
        }
    }

    new AIOSSTARTETHEMERHOOKS();