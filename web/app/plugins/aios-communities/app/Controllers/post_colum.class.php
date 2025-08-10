<?php

if ( !class_exists( 'aios_communities_posts_columns' ) ) {

	class aios_communities_posts_columns {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function __construct() {
			$this->add_actions();
		}

		/**
		 * Add Actions.
		 *
		 * @since 1.0.0
		 *
		 * @access protected
		 */
		protected function add_actions() {

			add_filter( 'manage_edit-aios-communities_columns', array( $this, 'communities_view_columns' ),10, 1 );
	 		add_action( 'manage_aios-communities_posts_custom_column' , array( $this, 'communities_view_custom_columns' ), 10, 2 );
		}

        /**
		 * Add the custom columns to the aios-communities.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */

		function communities_view_columns( $gallery_columns ) {
			$new_columns['cb'] = $gallery_columns['cb'];
			$new_columns['title'] = 'Name';
			$new_columns['is_featured'] = 'Set as Featured';
			$new_columns['featured_image'] = 'Featured Image';
			$new_columns['author'] = 'Created By';
			$new_columns['date'] = 'Date';

			return $new_columns;
		}

		/**
		 * Add the custom columns to the aios-communities.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */
		function communities_view_custom_columns( $gallery_columns, $post_id ) {

			switch( $gallery_columns ) {
				case 'is_featured':
					$featured = get_post_meta( $post_id,'aios_communities_featured', true );
					echo  $featured == 'yes' ? 'Yes' : 'No' ;
					break;
				case 'featured_image':
					$featured = get_post_meta( $post_id,'_thumbnail_id', true );
					echo '<div class="featured-image"><canvas width="100" height="100" style="background-image:url('.wp_get_attachment_url($featured, 'thumbnail').'); background-size: cover; background-position:center;"></div>';
					break;
                default:
                    echo '';
			}
		}

	}

	$aios_communities_posts_columns = new aios_communities_posts_columns();

}