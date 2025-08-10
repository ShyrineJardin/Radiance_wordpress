<?php

/**
 * Default Config
 *
 * @return void
 */
namespace AIOS\Communities\Func;

use AIOS\Communities\Controllers\Options;
use AIOS\Communities\Controllers\Colors;

if ( !class_exists( 'aios_communities_details_page_template_ascend' ) ) {

	class aios_communities_details_page_template_ascend {
		
		private $active_template_url;
		private $active_template_dir;
		private $template_url;
		private $template_dir;
		private $communities_settings;

		public function __construct() 
        {
			$this->communities_settings = Options::options();
			$this->active_template_url = AIOS_COMMUNITIES_URL . 'templates/themes/ascend';
			$this->active_template_dir = AIOS_COMMUNITIES_DIR . '/templates/themes/ascend';
			$this->add_actions();
		}

		public function add_actions() 
        {
			add_action( 'wp_head', [ $this, 'append_head' ], 7 );
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 20 );
			add_filter( 'template_include', [ $this, 'custom_archive' ], 20 );
			add_filter( 'template_include', [ $this, 'custom_taxonomy' ], 20 );
			add_filter( 'template_include', [ $this, 'custom_single' ], 20 );
		}

		public function append_head() 
        {
			extract($this->communities_settings);
			$post_id = get_the_ID();
			
			if ( $main_page == $post_id && $post_id != 0 ||  is_tax( 'community-group') || ( is_single() && get_post_type( $post_id ) == 'aios-communities' ) ) {
				Colors::color();
			}
		}

		public function enqueue_scripts() 
        {
			extract($this->communities_settings);

			$post_id = get_the_ID();
			
			// run archive styles and scripts
			if ( $main_page == $post_id && $post_id != 0 ||  is_tax( 'community-group') ) {
				wp_enqueue_style( 'aios_communties_archive', $this->active_template_url . '/assets/css/archive.min.css' );
				wp_enqueue_script( 'aios-communities-frontend', AIOS_COMMUNITIES_RESOURCES . '/js/frontend.min.js' );
			}
			
			// run single styles and scripts
            if ( is_single() && get_post_type( $post_id ) == 'aios-communities' ) {
				$aios_layout = get_post_meta( $post_id, 'aios_communities_layout', true );

				if ($aios_layout == "yes") {
					wp_register_script('aios-sticky', 'https://cdnjs.cloudflare.com/ajax/libs/sticky-js/1.3.0/sticky.min.js');
					wp_enqueue_script('aios-sticky');
					wp_enqueue_style( 'aios_communties_archive_single', $this->active_template_url . '/assets/css/single.min.css' );
					wp_enqueue_script( 'aios_communties_archive_single', $this->active_template_url . '/assets/js/single.min.js' );
				} else {
					wp_enqueue_script( 'aios_communties_archive_single', $this->active_template_url . '/assets/js/single-basic.min.js' );
					wp_enqueue_style( 'aios_communties_archive_single', $this->active_template_url . '/assets/css/single-basic.min.css' );
					wp_enqueue_script('aios-communities-frontend', AIOS_COMMUNITIES_RESOURCES . '/js/frontend.min.js');
				}
            }
		}

		public function custom_archive( $template ) 
        {
			extract($this->communities_settings);
			if( !empty( $aios_communities_settings ) ) extract( $aios_communities_settings );
			
			if ( $main_page == get_the_ID() && get_the_ID() != 0 ) {
				if($display_by == 'communities'){
					$template = $this->active_template_dir . '/archive.php';
				}else{
					$template = $this->active_template_dir . '/community-group.php';
				}
			}
			return $template;
		}

		public function custom_taxonomy( $template ) 
        {
			extract($this->communities_settings);
			if( !empty( $aios_communities_settings ) ) extract( $aios_communities_settings );
			
			if ( is_tax( 'community-group')  ) {
				$template = $this->active_template_dir . '/taxonomy.php';
			}

			return $template;
		}

        public function custom_single( $template ) {
			$post_id = get_the_ID();

			if ( is_single() && get_post_type( $post_id ) == 'aios-communities' ) {
				$aios_layout = get_post_meta( $post_id, 'aios_communities_layout', true );
				
				if ($aios_layout == "yes") { 
					$template = $this->active_template_dir . '/single.php';
				} else {
					$template = $this->active_template_dir . '/single-basic.php';
				}
			}
			return $template;
		}


	}
    
    $aios_communities_details_page_template_ascend = new aios_communities_details_page_template_ascend();
}