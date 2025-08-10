<?php
/**
 * Default Config
 *
 * @return void
 */
namespace AIOS\Communities\Func;
use AIOS\Communities\Controllers\Options;
use AIOS\Communities\Controllers\Colors;

if ( !class_exists( 'aios_communities_custom_theme_func' ) ) {

	class aios_communities_custom_theme_func{
		
		private $active_template_url;
		private $active_template_dir;
		private $template_url;
		private $template_dir;
		private $communities_settings;

		/*
		* Construct
		*
		* @access public
		* @return void
		*/
		public function __construct() {
			$this->communities_settings = Options::options();


			// Replace your_custom_theme_name with your desire name
			$this->active_template_url = get_stylesheet_directory_uri() . '/aios-communities/your_custom_theme_name';
			$this->active_template_dir = get_stylesheet_directory() . '/aios-communities/your_custom_theme_name';
			
			
			$this->add_actions();			
		}

		/*
		* Actions
		*
		* @access public
		* @return void
		*/
		public function add_actions() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );
			add_filter( 'template_include', array( $this, 'custom_archive' ), 20, 2 );
			add_filter('template_include', array( $this, 'custom_taxonomy' ), 20);
			add_filter('pre_get_posts', array( $this,  'taxonomy_post_per_page') , 20 ) ;
			add_filter('template_include', array( $this, 'custom_single' ), 20);
			add_filter( 'the_content',  array( $this, 'communities_single_hook'),  20);
		}

		/*
		* Enqueue Scripts
		*
		* @access public
		* @return void
		*/
		public function enqueue_scripts() {
			extract($this->communities_settings);
			
			/// run archive styles and scripts
			if ( $main_page == get_the_ID() && get_the_ID() != 0 ||  is_tax( 'community-group') ) {
				wp_enqueue_style( 'aios_communties_archive', $this->active_template_url . '/css/archive.css' );
				wp_enqueue_script( 'aios-communities-frontend', AIOS_COMMUNITIES_RESOURCES . '/js/frontend.min.js' );
				Colors::color();
			}
			// run single styles and scripts
            if ( is_single() && get_post_type( get_the_ID() ) == 'aios-communities' ) {
				wp_enqueue_style( 'aios_communties_archive_single', $this->active_template_url . '/css/single.css' );
				Colors::color();
            }

		
		}

		/*
		* Run Template for Archive and Community Group
		*
		* @access public
		* @return void
		*/
		public function custom_archive( $template ) {

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

		/*
		* Run Taxonomy Template
		*
		* @access public
		* @return void
		*/
		public function custom_taxonomy( $template ) {

			extract($this->communities_settings);
			if( !empty( $aios_communities_settings ) ) extract( $aios_communities_settings );
			
			if ( is_tax( 'community-group')  ) {

				$template = $this->active_template_dir . '/taxonomy.php';
			}
			return $template;
		}

		/*
		* Flush Taxonomy Pages
		*
		* @access public
		* @return void
		*/

		public function taxonomy_post_per_page($query) {

			extract($this->communities_settings);

			if ( is_admin() || ! $query->is_main_query() ) {
				return;
			 }
		 
			 if (  is_tax( 'community-group' )  ) {
				$query->set( 'posts_per_page', $post_per_page );
			 }
		}

       /*
		* Run Single Template
		* @access public
		* @return void
		*/
        public function custom_single( $template ) {
			if ( is_single() && get_post_type( get_the_ID() ) == 'aios-communities' ) {
				remove_filter( 'the_content', 'wpautop' );
				$template = $this->active_template_dir . '/single.php';
			}
			return $template;
		}


	  	/*
		* The Content Post Communities
		*
		* @access public
		* @return void
		*/
		function communities_single_hook( $content ) {

			$post_id = get_the_ID();
			
			$aios_communities_shortcode        =  get_post_meta( $post_id, 'aios_communities_shortcode', true );
			
			// Check if we're inside the main loop in a single Post.
			if ( is_single() && get_post_type( get_the_ID() ) == 'aios-communities' ) {
				return $content . do_shortcode($aios_communities_shortcode);
			}
			return $content;
		}

	}

}

$aios_communities_custom_theme_func = new aios_communities_custom_theme_func();