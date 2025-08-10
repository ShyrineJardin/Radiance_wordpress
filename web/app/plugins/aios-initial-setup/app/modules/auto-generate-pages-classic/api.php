<?php

namespace AiosInitialSetup\App\Modules\AutoGeneratePagesClassicEditor;

use WP_REST_Request;
use WP_REST_Response;

class Api {
    use Generate;

	public function __construct()
	{
		add_action('rest_api_init', [$this, 'register']);
	}

	// Register API
	public function register()
	{
		// POST: Save changes
		register_rest_route(
			'aios-auto-generate-page/v1',
			'generate',
			[
				'methods' => \WP_REST_Server::CREATABLE,
				'callback' => [$this, 'generate_callback'],
				'permission_callback' => [$this, 'permission_check']
			]
		);

        // Delete: revoke option
        register_rest_route(
            'aios-auto-generate-page/v1',
            'revoke',
            [
                'methods' => \WP_REST_Server::CREATABLE,
                'callback' => [$this, 'revoke_callback'],
                'permission_callback' => [$this, 'permission_check']
            ]
        );
	}

	/**
	 * Check if a given request has access to publish a page
	 *
	 * @param $request
	 * @return bool
	 */
	public function permission_check(WP_REST_Request $request)
	{
		// https://wordpress.org/support/article/roles-and-capabilities/
		// default: manage_options
		return current_user_can('publish_pages');
	}

	/**
	 * Set Options
	 *
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 */
	public function generate_callback(WP_REST_Request $request)
	{
        $generate = $this->generate($request->get_param('id'), $request->get_param('name'), $request->get_param('type'));

        return new WP_REST_Response([
            'status' => $generate['success'] ? 'success' : 'unsuccessful',
            'message' => $generate['message'],
            'edit' => isset($generate['edit']) ? $generate['edit'] : '',
			'edit_id' => isset($generate['edit_id']) ? $generate['edit_id'] : '',
        ], $generate['success'] ? 200 : 400);
	}

    /**
     * Revoke Option
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
	public function revoke_callback(WP_REST_Request $request)
    {
        // Save post ID to options
        $postId = (int) $request->get_param('id');
        $option = get_option(AIOS_AUTO_GENERATE_PAGES, []);

        if (isset($option[$postId])) {
            unset($option[$postId]);
        }

        // Delete option first
        delete_option(AIOS_AUTO_GENERATE_PAGES);

        // Update option
        update_option(AIOS_AUTO_GENERATE_PAGES, $option);

        return new WP_REST_Response([
            'status' => 'success',
            'message' => 'Revoked',
        ], 200);
    }

}

new Api();
