<?php

if ( ! class_exists( 'AIOS_Bypass_Caching' ) ) { 
    
    class AIOS_Bypass_Caching {

        private $post_types;
    
        public function __construct() {

            $this->post_types = ['post', 'page', 'aios-communities', 'aios-neighborhood'];

            // For Bypass Caching Meta Box
            add_action('add_meta_boxes', array($this, 'add_bypass_caching_meta_box'));
            add_action('save_post', array($this, 'save_bypass_caching_meta_box'));

            // Auto Enabled Bypass Caching if Optima Shortcode is present
            add_action('save_post', array($this, 'save_bypass_caching'));

            foreach ($this->post_types as $post_type) {
                add_filter('bulk_actions-edit-' . $post_type, array($this, 'register_custom_bulk_actions'));
                add_filter('handle_bulk_actions-edit-'  . $post_type, array($this, 'handle_custom_bulk_actions'), 10, 3);
            }
    
            // Admin Notices
            add_action('admin_notices', array($this, 'custom_bulk_action_admin_notice'));

            // Set cookies for visitors based on the meta field
            add_action('wp', array($this, 'set_cookies_for_visitors'));

        }
         /** 
         * Add Bypass Caching Box Meta 
         */
        public function add_bypass_caching_meta_box() {
            foreach ($this->post_types as $post_type) {
                add_meta_box(
                    'bypass_caching_meta_box',
                    'Caching Issue?',
                    array($this, 'render_bypass_caching_meta_box'),
                    $post_type,
                    'side',
                    'high'
                );
            }
        }
    
        /**
         * Bypass Caching Box Option 
         */
        public function render_bypass_caching_meta_box($post) {
    
            $bypass_caching = get_post_meta($post->ID, '_bypass_caching', true);
            echo '
                <label for="_bypass_caching">
                    <input type="checkbox" name="_bypass_caching" id="_bypass_caching" value="yes" ' . ($bypass_caching == 'yes' ? 'checked="checked"' : '') . ' >
                    Force Varnish Bypass
                </label>
            ';
        }

        /**
         *  Save Action Bypass Caching Metabox
         */
        public function save_bypass_caching_meta_box($post_id) {
            // Check if auto save
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            // Check if this is a revision
            if (wp_is_post_revision($post_id)) {
                return;
            }
    
            // Check if user can edit post
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
    
            // Save meta box data
            $bypass_caching = isset($_POST['_bypass_caching']) && $_POST['_bypass_caching'] == 'yes' ? 'yes' : '';
            update_post_meta($post_id, '_bypass_caching', $bypass_caching);
        }
    
         /**
         *  Save Action Bypass Caching
         */
        public function save_bypass_caching($post_id) {
            
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return $post_id;
            }

            // Check if this is a revision
            if (wp_is_post_revision($post_id)) {
                return;
            }

            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }

            $post = get_post($post_id);

            $permalink = parse_url(get_permalink($post_id), PHP_URL_PATH);

            $expiration = 2147483647; // Maximum value - https://stackoverflow.com/questions/3290424/set-a-cookie-to-never-expire

            $conditions_met = false;

            $bypass_caching = get_post_meta($post_id, '_bypass_caching', true);
            
            // Check in Post Content
            $post_content = get_post_field('post_content', $post_id);
            if (preg_match('/\[optima_express(.*?)\]/', $post_content)) {

                setcookie('aios_bypass_caching', 1, $expiration, $permalink, COOKIE_DOMAIN, true, true);

                $conditions_met = true;

                $bypass_caching = 'yes';
            }

            // Check in All ACF Field
            if (is_plugin_active( 'advanced-custom-fields-pro/acf.php' )) {
                $fields = get_fields($post_id);
                if ($fields) {
                    foreach ($fields as $field_name => $value) {

                        // Check for a specific value in the ACF fields
                        if (preg_match('/\[optima_express(.*?)\]/', $value)) {

                            setcookie('aios_bypass_caching', 1, $expiration, $permalink, COOKIE_DOMAIN, true, true);
                        
                            $conditions_met = true;

                            $bypass_caching = 'yes';
                        }
                    }
                }
            }

            // Check if the bypass caching box is checked
            if($bypass_caching == 'yes') {
                if(!$conditions_met) {

                    setcookie('aios_bypass_caching', 1, $expiration, $permalink, COOKIE_DOMAIN, true, true);

                    $conditions_met = true;
                }
            }

            update_post_meta($post_id, '_bypass_caching', $bypass_caching);

            // Ensure to Unset the Cookie to those pages that doesnt have optima 
            if (!$conditions_met) {  
                if (isset($_COOKIE['aios_bypass_caching'])) {
                    // unset($_COOKIE['aios_bypass_caching']);
                    setcookie('aios_bypass_caching', '', time() - 3600, $permalink, COOKIE_DOMAIN, true, true);
                }
            }

            return $post_id;
        }
    
        /**
         *  Add Bulk Action
         */
        public function register_custom_bulk_actions($bulk_actions) {
            $bulk_actions['set_bypass_caching'] = 'Force Varnish/Cloudflare Bypass';

            return $bulk_actions;
        }
    
        /**
         *  Handle Bulk Action
         */
        public function handle_custom_bulk_actions($redirect_to, $doaction, $post_ids) {
            if ($doaction !== 'set_bypass_caching') {
                return $redirect_to;
            }
    
            foreach ($post_ids as $post_id) {
                
                // Force to Yes the Bypass Caching in Bulk action
                update_post_meta($post_id, '_bypass_caching', 'yes');

                $this->save_bypass_caching($post_id);
            }
    
            $redirect_to = add_query_arg('set_bypass_caching', count($post_ids), $redirect_to);
            return $redirect_to;
        }
    
        /**
         *  Bulk Action Notice
         */
        public function custom_bulk_action_admin_notice() {
            if (!empty($_REQUEST['set_bypass_caching'])) {
                $count = intval($_REQUEST['set_bypass_caching']);
                printf('<div id="message" class="updated notice notice-success is-dismissible"><p>Forced Varnish/Cloudflare Bypass for %d items.</p></div>', $count);
            }
        }

        /**
         * Set Cookies for Visitors
         */
        public function set_cookies_for_visitors() {
            if (is_singular($this->post_types)) {
                global $post;
                $post_id = $post->ID;
    
                $permalink = parse_url(get_permalink($post_id), PHP_URL_PATH);

                $expiration = 2147483647; // Maximum value - https://stackoverflow.com/questions/3290424/set-a-cookie-to-never-expire
    
                $bypass_caching = get_post_meta($post_id, '_bypass_caching', true);
    
                // Check if the bypass caching box is checked
                if ($bypass_caching === 'yes') {

                    setcookie('aios_bypass_caching', 1, $expiration, $permalink, COOKIE_DOMAIN, true, true);

                }
            }
        }

    }

    new AIOS_Bypass_Caching();

}