<?php
/**
 * Name: Intercept IHF leads
 * Description: This will prevent location field from exceeding container
 */

namespace AiosInitialSetup\App\Modules\IhfLeads;

use AiosInitialSetup\Helpers\Classes\IntegrationsTrait;

class Module
{
	use IntegrationsTrait;

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		add_action('init', [$this, 'intercept_ihf_ajax_requests'], 10, 0);
	}

	/**
	 * Intercept IHF AJAX requests and push leads to Mailchimp
	 *
	 * @return void
	 */
	public function intercept_ihf_ajax_requests()
	{
		// Check if it's an AJAX request
		if (defined('DOING_AJAX') && DOING_AJAX) {
			// List of actions we want to intercept
			$valid_actions = [
				'ihf_save_property',
				'ihf_schedule_showing',
				'ihf_more_info_request',
				'ihf_email_alert_popup'
			];
			
			// Check if the action is in our list of valid actions
			if (isset($_GET['action']) && in_array($_GET['action'], $valid_actions) && isset($_GET['actionType'])) {
				try {
					// Capture the form data from the request
					$first_name = isset($_GET['firstName']) ? sanitize_text_field($_GET['firstName']) : '';
					$last_name = isset($_GET['lastName']) ? sanitize_text_field($_GET['lastName']) : '';
					$email = isset($_GET['newEmail']) ? sanitize_email($_GET['newEmail']) : '';
					$phone = isset($_GET['phone']) ? sanitize_text_field($_GET['phone']) : '';
					$dataset = [
						'firstName' => $first_name,
						'lastName'  => $last_name,
						'email'     => $email,
						'phone'     => $phone,
						'tags'      => 'ihf-leads',
						'assignedTo'=> 'ihf-leads'
					];

					// Validation checks
					$validated = true;

					if (empty($first_name) || empty($last_name)) {
						$validated = false;
					}

					if (empty($email) || !is_email($email)) {
						$validated = false;
					}

					if ($validated) {
						// Push leads to Mailchimp
						$mailchimp = get_option('aios_mailchimp', []);

						if (
							$mailchimp['enabled'] ?? '' === "1" 
							&& ! empty($mailchimp['api-key'] ?? '') 
							&& ! empty($mailchimp['audience-id'] ?? '')
						) {
							$bodyArr['mailchimp'] = $this->mailchimp_add_leads(
								$mailchimp['api-key'],
								$mailchimp['audience-id'],
								$dataset
							);
						}
					}
				} catch(\Throwable $e) {
					// Do nothing
				}
			}
		} else {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				try {
					// Capture the form data from the IHF 'contact' page
					if ((isset($_POST['JKGH00920']) && $_POST['JKGH00920'] === '') && isset($_POST['submitted']) && $_POST['submitted'] === 'true' ) {
						$full_name = isset($_POST['contactName']) ? sanitize_text_field($_POST['contactName']) : "";
						$first_name = $full_name;
						$last_name = "";
						$email = isset($_POST['email']) ? sanitize_email($_POST['email']) : "";
						$phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : "";
						
						if ( ! empty( $full_name ) ) {
							$full_name = explode( " ", $full_name );

							if ( count( $full_name ) > 1 ) {
								$last_name = end($full_name);

								if ( count( $full_name ) > 1 ) {
									array_pop( $full_name );
								}

								$first_name = implode( " ", $full_name );
							}
						}
						
						$dataset = [
							'firstName' => $first_name,
							'lastName'  => $last_name,
							'email'     => $email,
							'phone'     => $phone,
							'tags'      => 'ihf-leads',
							'assignedTo'=> 'ihf-leads'
						];

						// Validation checks
						$validated = true;

						if (empty($email) || !is_email($email)) {
							$validated = false;
						}

						if ($validated) {
							// Push leads to Mailchimp
							$mailchimp = get_option('aios_mailchimp', []);

							if (
								$mailchimp['enabled'] ?? '' === "1" 
								&& ! empty($mailchimp['api-key'] ?? '') 
								&& ! empty($mailchimp['audience-id'] ?? '')
							) {
								$this->mailchimp_add_leads(
									$mailchimp['api-key'],
									$mailchimp['audience-id'],
									$dataset
								);
							}
						}
					}
				} catch(\Throwable $e) {
					// Do nothing
				}
			}
		}
	}
}

new Module();

