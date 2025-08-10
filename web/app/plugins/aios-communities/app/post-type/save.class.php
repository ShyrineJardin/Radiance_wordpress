<?php

if ( !class_exists( 'aios_communities_post_type_save' ) ) {

	class aios_communities_post_type_save {

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
		 * @access public
		 */
		public function add_actions() {
			add_action( 'save_post_aios-communities', array( $this, 'save_communities' ) );
		}

		/**
		 * Save Metabox Value.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function save_communities( $post_id ) {
			/** Pointless if $_POST is empty (this happens on bulk edit) **/
			if ( empty( $_POST ) ) 
				return $post_id;
			
			/** Verify taxonomies meta box nonce **/
			if ( !isset( $_POST[ 'aios_aios-communities_meta_boxes_nonce' ] ) || !wp_verify_nonce( $_POST[ 'aios_aios-communities_meta_boxes_nonce' ], 'aios-aios-communities-save-details' ) )
			return;
			
			/** Verify quick edit nonce **/
			if ( isset( $_POST[ '_inline_edit' ] ) && ! wp_verify_nonce( $_POST[ '_inline_edit' ], 'inlineeditnonce' ) ) 
				return $post_id;
			
			/** Don't save on autosave **/
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
				return $post_id;
			
			/** Dont save on revisions **/
			if ( isset( $post->post_type ) && $post->post_type == 'revision' ) 
				return $post_id;
			
			/** Check the user's permissions. **/
			if ( !current_user_can( 'edit_page', $post_id ) ) 
				return;
			
			/** Check post status **/
			if ( get_post_status( $post_id ) == 'trash'  ) 
				return;
				
			/** Unhook this function to prevent infinite looping **/
			remove_action( 'save_post_aios-communities', 'save_communities' );

			update_post_meta($post_id, 'aios_communities_video_url', $_POST['aios_communities_video_url']);
			update_post_meta($post_id, 'aios_communities_shortcode', $_POST['aios_communities_shortcode']);
			update_post_meta($post_id, 'cta_title', $_POST['cta_title']);
			update_post_meta($post_id, 'cta_link', $_POST['cta_link']);
			update_post_meta($post_id, 'cta_new_tab', $_POST['cta_new_tab']);
			update_post_meta($post_id, 'display_cta', $_POST['display_cta']);
			update_post_meta($post_id, 'aios_communities_layout', $_POST['aios_communities_layout']);
			update_post_meta($post_id, 'aios_communities_idxBrokerLink', $_POST['aios_communities_idxBrokerLink']);
			update_post_meta($post_id, 'aios_communities_idxBrokerLinkNewTab', $_POST['aios_communities_idxBrokerLinkNewTab']);

            if ( isset ( $_POST['aios_communities_featured'] ) ) {
				update_post_meta( $post_id, 'aios_communities_featured', $_POST['aios_communities_featured'] );
			} else {
				update_post_meta( $post_id, 'aios_communities_featured', 'no' );
			}

			update_post_meta( $post_id, 'community_field', $this->array_remove_empty_keys( $_POST['community_field'] ) );

			/** rehook save_post **/
			add_action( 'save_post_aios-communities', 'save_communities' );
		}

		protected function array_remove_empty_keys( $arr, $make_empty = false ) {
			if ( ! is_array( $arr ) ) {
				return;
			}
		
			foreach ( $arr as $key => $value ) {
				if ( is_array( $value ) ) {
					$arr[$key] = $this->array_remove_empty_keys( $arr[$key] );
				}
				if ( empty( $arr[$key] ) ) {
					unset( $arr[$key] );
				}
			}
		
			if ( empty( $arr ) && $make_empty ) {
				$arr = '';
			}
		
			return $arr;
		}
	}

}
$aios_communities_post_type_save = new aios_communities_post_type_save();