<?php
namespace AIOS\Communities\PostType\Create;
use AIOS\Communities\Controllers\Options;

if ( !class_exists( 'aios_communities_post_type_create' ) ) {

	class aios_communities_post_type_create {
		private $post_type = 'aios-communities';

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() 
		{
			$this->add_actions();
		}

		/**
		 * Add Actions.
		 *
		 * @since 1.0.0
		 *
		 * @access protected
		 * @return void
		 */
		protected function add_actions() 
		{
			/** Global Action with Filter **/
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_uiux' ) );

			/* Taxonomy */
			add_action( 'init', array( $this, 'custom_taxonomy' ) , 0 );
			add_action('community-group_edit_form_fields', array( $this, 'edit_custom_term_field'), 10, 2);
			add_action('edited_community-group', array( $this, 'save_custom_term_position'), 10, 2);

			add_action( 'init', array( $this, 'custom_post_type' ) );
			add_action( 'enter_title_here', array( $this, 'title_placeholder' ) );
			add_filter( 'wpseo_metabox_prio', array( $this, 'move_yoast_meta_box' ) );

			/** Only run on aios-communities post type **/
			add_filter( 'aios-default-metaboxes', array( $this, 'default_metaboxes' ) );
			add_filter( $this->post_type . '-default-tab', array( $this, 'default_tab' ) );
			add_filter( 'aios_add_custom_metabox_after_content_' . $this->post_type, array( $this, 'default_content' ) );
			add_filter( $this->post_type . '-additional-tabs', array( $this, 'additional_tabs' ) );
			add_filter( $this->post_type . '-additional-content', array( $this, 'additional_content' ) );

			// Metaboxes for Content Writing
			add_action( 'add_meta_boxes', [ $this, 'add_custom_box' ] );
		}

		protected function html_stats_parent( $data, $isOpen, $content = "", $index = "index", $subindex = "subindex", $statindex = "statindex" ) 
		{
			$stat_html = "";
			$img = "";

			if ( ! empty($data) && empty( $content ) ) {
				if ( isset( $data[ 'image' ] ) ) {
					$img = "<img src=\"" . wp_get_attachment_image_url( $data[ 'image' ], 'large' ) . "\" width=\"200\" height=\"200\">";
				}

				if ( isset( $data[ 'child' ] ) ) {
					foreach ( $data[ 'child' ] as $fieldindex => $stat_data ) {
						$stat_html .= $this->html_stats_child( $stat_data, false, $index, $subindex, $statindex, $fieldindex );
					}
				} else {
					$stat_html .= $this->html_stats_child( [], false );
				}
			} else {
				$stat_html = $content;
			}

			$toggleActiveClass = $isOpen ? "active" : "";
			$toggleActiveStyle = $isOpen ? "" : "style=\"display:none\"";

			return "<div class=\"wc-stats-item\" data-section-stat data-toggle-parent>
				<div class=\"wc-stats-item-header\" data-toggle-header data-sort-handle>
					<div class=\"wc-repeater-section-header-title\" data-head-title-heading>
						" . ( isset( $data['title'] ) ? $data['title'] : "No Title" ) . "
					</div>
					<div class=\"wc-repeater-field-toggle $toggleActiveClass\" data-toggle-field>
						<span class=\"ai-font-arrow-g-u\"></span>
					</div>
					<div class=\"wc-repeater-field-close\" data-close-field>
						<span class=\"ai-font-close-c\"></span>
					</div>
				</div>
				<div class=\"wc-stats-item-body\" data-toggle-body $toggleActiveStyle>
					<div class=\"wc-stats-field wc-stats-img\">
						<label>Background Image</label>
						<div class=\"wc-stats-img-content\">
							<input type=\"hidden\" name=\"community_field[$index][fields][$subindex][stats][$statindex][image]\" value=\"" . ( isset( $data[ 'image' ] ) ? $data[ 'image' ] : "" ) . "\">
							<button type=\"button\" class=\"wc-button wc-field\" data-add-stat-image>Add/Replace Image</button>
							<div>$img</div>
						</div>
					</div>
					<div class=\"wc-stats-field\">
						<label>Title</label>
						<input type=\"text\" name=\"community_field[$index][fields][$subindex][stats][$statindex][title]\" value=\"" . ( isset( $data[ 'title' ] ) ? $data[ 'title' ] : "" ) . "\" data-head-title-input>
					</div>
					<label>Stats</label>
					<div class=\"wc-stats-child\" data-section-stats-child data-sort-wrapper data-sort=\"stats\">
						$stat_html
					</div>
					<div class=\"wc-add-stat\">
						<button type=\"button\" class=\"wc-button wc-field\" data-add-stat>Add Stat</button>
					</div>
				</div>
			</div>";
		}

		protected function html_stats_child( $data, $isOpen, $index = "index", $subindex = "subindex", $statindex = "statindex", $fieldindex = 0 ) 
		{
			$toggleActiveClass = $isOpen ? "active" : "";
			$toggleActiveStyle = $isOpen ? "" : "style=\"display:none\"";

			return "<div class=\"wc-stats-child-item\" data-section-stats-child-item data-toggle-parent>
				<div class=\"wc-stats-child-item-header\" data-toggle-header data-sort-handle>
					<div class=\"wc-stats-child-item-header-title\" data-head-title-heading>
						" . ( isset( $data['description'] ) ? $data['description'] : "No Title" ) . "
					</div>
					<div class=\"wc-repeater-field-toggle $toggleActiveClass\" data-toggle-field>
						<span class=\"ai-font-arrow-g-u\"></span>
					</div>
					<div class=\"wc-repeater-field-close\" data-close-field>
						<span class=\"ai-font-close-c\"></span>
					</div>
				</div>
				<div class=\"wc-stats-child-item-body\" data-toggle-body $toggleActiveStyle>
					<div class=\"wc-stats-field\">
						<label>Number</label>
						<input type=\"text\" name=\"community_field[$index][fields][$subindex][stats][$statindex][child][$fieldindex][number]\" value=\"" . ( isset( $data['number'] ) ? $data['number'] : "" ) . "\">
					</div>
					<div class=\"wc-stats-field\">
						<label>Description</label>
						<input type=\"text\" name=\"community_field[$index][fields][$subindex][stats][$statindex][child][$fieldindex][description]\"  value=\"" . ( isset( $data['description'] ) ? $data['description'] : "" ) . "\" data-head-title-input>
					</div>
				</div>
			</div>";
		}

		protected function html_section_field( $data, $isOpen, $content = "", $index = "index", $subindex = "subindex" ) 
		{
			$stats_html = "";

			// Types
			$defaultType = "textarea";
			$types = [
				'textarea' => 'Textarea',
				'gallery' => 'Gallery',
				'iframe' => 'Iframe',
				'tinymce' => 'WYSIWYG',
				'stats' => 'Stats',
			];
			$typesHtml = "";

			foreach ( $types as $k => $v ) {
				$typesHtml .= "<span data-field-type=\"$k\">$v</span>";
			}

			if ( ! empty($data) && empty( $content ) ) {
				$defaultType = $data[ 'type' ];

				if ( isset( $data['stats'] ) ) {
					foreach ( $data['stats'] as $statindex => $data ) {
						$stats_html .= $this->html_stats_parent( $data, false, "", $index, $subindex, $statindex );
					}
				} else {
					$stats_html .= $this->html_stats_parent( [], false ); 
				}
			} else {
				$stats_html = $content;
			}

			$toggleActiveClass = $isOpen ? "active" : "";
			$toggleActiveStyle = $isOpen ? "" : "style=\"display:none\"";

			$noImagePlaceholder = "";
			$imageGalleries = "";

			if (isset( $data[ 'gallery' ] ) && ! empty( $data[ 'gallery' ] )) {
				$imageIds = explode( ',', $data[ 'gallery' ] );
				
				foreach ($imageIds as $id) {
					$imageGalleries .= "<div>
						<div class=\"img-move-drag\" data-sort-handle></div>
						<div class=\"img-remove\" data-remove-image-gallery></div>
						<img src=\"" . wp_get_attachment_image_url( $id, 'large' ) . "\" width=\"150\" height=\"150\" data-id=\"$id\">
						<canvas width=\"150\" height=\"150\"></canvas>
					</div>";
				}
			} else {
				$noImagePlaceholder = "<div class=\"wc-repeater-field-content-no-images\">No images</div>";
			}

			return "<div class=\"wc-repeater-field\" data-section-field data-toggle-parent>
				<div class=\"wc-repeater-field-header\" data-toggle-header data-sort-handle>
					<div class=\"wc-repeater-field-type\">
						<input type=\"hidden\" name=\"community_field[$index][fields][$subindex][type]\" value=\"$defaultType\">
						<div class=\"wc-repeater-field-type-button\">
							<span>" . $types[ $defaultType ] . "</span>
							<span class=\"ai-font-arrow-g-d\"></span>
						</div>
						<div class=\"wc-repeater-field-type-dropdown\">
							$typesHtml
						</div>
					</div>
					<div class=\"wc-repeater-field-visibility\">
						<input 
							type=\"checkbox\" 
							name=\"community_field[$index][fields][$subindex][visibility]\" 
							value=\"1\" 
							" . ( isset( $data['visibility'] ) ? "checked" : "" ) . "
						>
					</div>
					<div class=\"wc-repeater-field-toggle $toggleActiveClass\" data-toggle-field>
						<span class=\"ai-font-arrow-g-u\"></span>
					</div>
					<div class=\"wc-repeater-field-close\" data-close-field>
						<span class=\"ai-font-close-c\"></span>
					</div>
				</div>
				<div class=\"wc-repeater-field-content\" data-toggle-body $toggleActiveStyle>
					<div data-id=\"textarea\" class=\"wc-repeater-field-content-type\" " . ( $defaultType === "textarea" ? "" : "style=\"display: none\"" ) . ">
						<label>Content</label>
						<textarea name=\"community_field[$index][fields][$subindex][textarea]\">" . ( isset( $data['textarea'] ) ? $data['textarea'] : "" ) . "</textarea>
					</div>
					<div data-id=\"gallery\" class=\"wc-repeater-field-content-type\"  " . ( $defaultType === "gallery" ? "" : "style=\"display: none\"" ) . ">
						<input type=\"hidden\" name=\"community_field[$index][fields][$subindex][gallery]\" value=\"" . ( isset( $data['gallery'] ) ? $data['gallery'] : "" ) . "\">
						$noImagePlaceholder
						<div class=\"wc-repeater-field-content-gallery\" data-sort-wrapper data-sort=\"gallery\">
							$imageGalleries
						</div>
						<button type=\"button\" class=\"wc-button wc-add-images\" dat-add-images>Add Images</button>
						<label>Column</label>
						<input type=\"number\" name=\"community_field[$index][fields][$subindex][column]\" min=\"1\" max=\"8\" value=\"" . ( isset( $data['column'] ) ? $data['column'] : "3" ) . "\">
					</div>
					<div data-id=\"tinymce\" class=\"wc-repeater-field-content-type\"  " . ( $defaultType === "tinymce" ? "" : "style=\"display: none\"" ) . ">
						<label>Content</label>
						<textarea name=\"community_field[$index][fields][$subindex][tinymce]\" class=\"wc-repeater-tinymce\">" . ( isset( $data['tinymce'] ) ? $data['tinymce'] : "" ) . "</textarea>
					</div>
					<div data-id=\"iframe\" class=\"wc-repeater-field-content-type\"  " . ( $defaultType === "iframe" ? "" : "style=\"display: none\"" ) . ">
						<label>Embedded Link</label>
						<input type=\"text\" name=\"community_field[$index][fields][$subindex][iframe]\" value=\"" . ( isset( $data['iframe'] ) ? $data['iframe'] : "" ) . "\">
						<label style=\"margin-top: 15px\">Width</label>
						<input type=\"text\" name=\"community_field[$index][fields][$subindex][iframewidth]\" value=\"" . ( isset( $data['iframewidth'] ) ? $data['iframewidth'] : "" ) . "\">
						<label style=\"margin-top: 15px\">Height</label>
						<input type=\"text\" name=\"community_field[$index][fields][$subindex][iframeheight]\" value=\"" . ( isset( $data['iframeheight'] ) ? $data['iframewidth'] : "" ) . "\">
					</div>
					<div data-id=\"stats\" class=\"wc-repeater-field-content-type\"  " . ( $defaultType === "stats" ? "" : "style=\"display: none\"" ) . ">
						<div class=\"wc-stats-items\" data-sort-wrapper data-sort=\"stats\">
							$stats_html
						</div>

						<div class=\"wc-add-stat\">
							<button type=\"button\" class=\"wc-button wc-field\" data-add-stat-section>Add Stat Section</button>
						</div>
					</div>
				</div>
			</div>";
		}

		protected function html_section( $data, $isOpen, $content = "", $index = "index" ) 
		{
			$toggleActiveClass = $isOpen ? "active" : "";
			$toggleActiveStyle = $isOpen ? "" : "style=\"display:none\"";

			return "<div class=\"wc-repeater-section\" data-section-wrapper data-toggle-parent>
				<div class=\"wc-repeater-section-header\" data-toggle-header data-sort-handle>
					<div class=\"wc-repeater-section-header-title\" data-head-title-heading>
						" . ( isset( $data['title'] ) ? $data['title'] : "No Title" ) . "
					</div>
					<div class=\"wc-repeater-field-toggle $toggleActiveClass\" data-toggle-field>
						<span class=\"ai-font-arrow-g-u\"></span>
					</div>
					<div class=\"wc-repeater-field-close\" data-close-field>
						<span class=\"ai-font-close-c\"></span>
					</div>
				</div>
				
				<div class=\"wc-repeater-section-body\" data-toggle-body $toggleActiveStyle>
					<div class=\"wc-repeater-field-title\">
						<label>Title</label>
						<input type=\"text\" name=\"community_field[$index][title]\" value=\"" . ( isset( $data['title'] ) ? $data['title'] : "" ) . "\" data-head-title-input>
						<label class=\"wc-repeater-field-checkbox\">
							<input type=\"checkbox\" name=\"community_field[$index][title_hide]\" value=\"1\" " . ( isset( $data['title_hide'] ) ? "checked" : "" ) . ">
							<span>Hide title</span>
						</label>
						<label class=\"wc-repeater-field-checkbox\">
							<input type=\"checkbox\" name=\"community_field[$index][title_hide_table]\" value=\"1\" " . ( isset( $data['title_hide_table'] ) ? "checked" : "" ) . ">
							<span>Hide title from table of contents</span>
						</label>
					</div>

					<div class=\"wc-repeater-fields\" data-section-fields data-sort-wrapper data-sort=\"fields\">
						$content
					</div>
					<div class=\"wc-add-field\">
						<button type=\"button\" class=\"wc-button wc-field\" data-add-field>Add Field</button>
					</div>
				</div>
			</div>";
		}

		/**
		 * Enqueue Assets
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return void
		 */
		public function admin_uiux() 
		{
			$admin_page_id = get_current_screen()->id;
			$admin_page_contains = 'aios-communities';

			if ( strpos($admin_page_id, $admin_page_contains) !== false ) {
				// Media and editor
				wp_enqueue_media();
				wp_enqueue_editor();
				
				wp_enqueue_style( 'aios-communities-post-type-style', AIOS_COMMUNITIES_RESOURCES . '/css/post-type.min.css' );
				wp_enqueue_script( 'aios-communities-post-type-script', AIOS_COMMUNITIES_RESOURCES . '/js/post-type.min.js' );

				// Data
				$stat_child_html = $this->html_stats_child( [], true );
				$stat_html = $this->html_stats_parent( [], true, $stat_child_html );
				$field_html = $this->html_section_field( [], true, $stat_html );
				$section_html = $this->html_section( [], true, $field_html );

				wp_localize_script( 'aios-communities-post-type-script', 'communities_pt_data', [
					"section" => $section_html,
					"field" => $field_html,
					"stat" => $stat_html,
					"stat_child" => $stat_child_html,
				] );
			}
		}

		/**
		 * Create two taxonomies, Area and Area for the post type "book".
		 *
		 * @see register_post_type() for registering custom post types.
		 */
		function custom_taxonomy() {
		
			// Add new taxonomy, NOT hierarchical (like tags)
			$labels = array(
				'name'              => _x( 'Community Group', 'taxonomy general name', 'textdomain' ),
				'singular_name'     => _x( 'Community Group', 'taxonomy singular name', 'textdomain' ),
				'search_items'      => __( 'Search Community Group', 'textdomain' ),
				'all_items'         => __( 'All Community Group', 'textdomain' ),
				'parent_item'       => __( 'Parent Community Group', 'textdomain' ),
				'parent_item_colon' => __( 'Parent Community Group:', 'textdomain' ),
				'edit_item'         => __( 'Edit Community Group', 'textdomain' ),
				'update_item'       => __( 'Update Community Group', 'textdomain' ),
				'add_new_item'      => __( 'Add New Community Group', 'textdomain' ),
				'new_item_name'     => __( 'New Community Group Name', 'textdomain' ),
				'menu_name'         => __( 'Community Group', 'textdomain' ),
			);
		 
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,				
				'rewrite'           => array( 'slug' => 'community-group' ),
			);
		 
			register_taxonomy( 'community-group', 'aios-communities', $args );
		}


		// Display the custom input field for the position in the term edit screen
		function edit_custom_term_field($term) {
			$position = get_term_meta($term->term_id, 'term_position', true);

			?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="term_position"><?php _e('Position', 'text-domain'); ?></label>
				</th>
				<td>
					<input type="number" name="term_position" id="term_position" step="1" class="small-text" value="<?php echo esc_attr($position); ?>" />
					<p class="description"><?php _e('Enter the desired position for this term.', 'text-domain'); ?></p>
				</td>
			</tr>
			<?php
		}

		// Save the term position when a term is edited or updated
		function save_custom_term_position($term_id) {
			if (isset($_POST['term_position'])) {
				$position = intval($_POST['term_position']);
				update_term_meta($term_id, 'term_position', $position);
			}
		}

		/**
		 * Register Post Type.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return void
		 */
		public function custom_post_type() {
			/** Get array of Settings **/
			$communities_settings 		= Options::options();
			if( !empty( $communities_settings ) ) extract( $communities_settings );

			$labels = array(
				'name'                  => 'AIOS Communities',
				'singular_name'         => 'Communities',
				'add_new'               => 'Add New Community',
				'add_new_item'          => 'Add New Community',
				'edit_item'             => 'Edit Community',
				'new_item'              => 'New Community',
				'view_item'             => 'View Community',
				'search_items'          => 'Search Community',
				'not_found'             =>  'Nothing Found',
				'not_found_in_trash'    => 'Nothing found in the Trash',
				'parent_item_colon'     => ''
			);

			$supports = array(
				'title', 'thumbnail', 'revisions'
			);

			$args = array(
				'labels'                => $labels,
				'supports'              => $supports,
				'public'                => true,
				'publicly_queryable'    => true,
				'show_ui'               => true,
				'query_var'             => true,
				'menu_icon'             => 'dashicons-admin-multisite',
				'rewrite'               => array(
					'slug' => $permastructure
				),
				'capability_type'       => 'post',
				'hierarchical'          => false,
				'menu_position'         => 23,
				'has_archive'           => false,// editable content - archive-{cpt-name}.php
			);

			register_post_type( 'aios-communities', $args );

			/** Flush Permalinks **/
			if ( get_option( 'communities_slug' ) !== $permastructure ) {
				update_option( 'communities_slug', $permastructure );
				flush_rewrite_rules();
			}
		}

		/**
		 * Replace Title Placeholder.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return string
		 */
		public function title_placeholder( $title ) {
			$admin_page_post_type 	= get_current_screen()->post_type;
			$admin_page_contains 	= 'aios-communities';
			
			if ( $admin_page_post_type == $admin_page_contains ) {
				$title = 'Community Name';
            }
            
			return $title;
		}

		/**
		 * Move Yoas Meta Box below.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return void
		 */
		public function move_yoast_meta_box() {
			return 'low';
		}

		/**
		 * aios-communities tabs
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */
		public function meta_box_tabs( $add_meta_box_tabs = array() ) {

			/** Run plugin functions for is_plugin_active incase theirs priority issues **/
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			$tabs = [];
			
			$add_meta_box_tabs = apply_filters( 'communities_add_meta_box_tabs', $add_meta_box_tabs );
			$tabs = array_merge_recursive( array_filter( $tabs ), array_filter( $add_meta_box_tabs ) );

			return $tabs;
		}

		/**
		 * Add communities to custom metabox if not added
		 * This will display the metaboxes tab
		 *
		 * @param $post_types
		 * @return mixed
		 */
		public function default_metaboxes($post_types) {
			if (! isset($post_types['aios-communities'])) {
			$post_types['aios-communities'] = [];
			}
	
			return $post_types;
		}
	
		/**
		 * Change the default title of "Details"
		 *
		 * @return string
		 */
		public function default_tab(){
			return 'Community Information';
		}
  
		/**
		 * Add custom fields to the "Details" tab
		 */
		public function default_content(){
			$post_id = get_the_ID();

			include_once AIOS_COMMUNITIES_FORMS_DIR . 'forms/communities-form.php';
		}
  
		/**
		 * Add new tabs
		 *
		 * @return string
		 */
		public function additional_tabs(){
			$tabs = $this->meta_box_tabs();

			if (! is_null($tabs)) {
				foreach ($this->meta_box_tabs() as $key => $tab) {
					return '<li><a data-id="' . $this->post_type . '-' . $tab['url'] . '">' . $tab['title'] . '</a></li>';
				}
			}

			return '';
		}
  
		/**
		 * Add new content to the tabs
		 */
		public function additional_content(){
			$post_id = get_the_ID();
			$tabs = $this->meta_box_tabs();
	
			if (! is_null($tabs)) {
				foreach ($this->meta_box_tabs() as $key => $tab) {
					echo '<div data-id="' . $this->post_type . '-' . $tab['url'] . '" class="wpui-tabs-content"><div class="wpui-tabs-container">';
					include_once $tab['function'];
					echo '</div></div>';
				}
			}
	  	}

		/**
		 * Add custom box
		 */
		public function add_custom_box() {
			add_meta_box( 'writing-content', 'Writing Content', [ $this, 'writing_content_custom_box' ], $this->post_type );
		}

		public function writing_content_custom_box( $post ) {
			$options = get_post_meta( $post->ID, 'community_field' );
			$html = "";

			if ( ! empty( $options ) ) {
				foreach ( $options[0] as $index => $option ) {
					$field_html = "";

					foreach ( $option[ 'fields' ] as $subindex => $field) {
						$field_html .= $this->html_section_field( $field, false, "", $index, $subindex );
					}

					$html .= $this->html_section( $option, false, $field_html, $index );
				}
			}
			
			echo "<div id=\"wc-repeater\">
				<div class=\"wc-repeater-inside\" data-sort-wrapper data-sort=\"fields\">
					$html
				</div>
			</div>";
			echo "<div id=\"wc-add-section\">
				<button type=\"button\" class=\"wc-button\">Add Section</button>
			</div>";
		}

	}

}
$aios_communities_post_type_create = new aios_communities_post_type_create();