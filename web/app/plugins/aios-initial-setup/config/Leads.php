<?php

namespace AiosInitialSetup\Config;

use AiosDashboard\App\Http\Request;
use AiosInitialSetup\Helpers\Classes\IntegrationsTrait;
use ReflectionClass;

trait Leads {
	use IntegrationsTrait;

	/**
	 * @param $title
	 * @param $wpcf7
	 * @param $submission
	 * @param bool $spam
	 */
	private function CreateLeads($title, $wpcf7, $submission, $spam = false)
	{
		$title = trim(preg_replace('/\s*\([^)]*\)/', '', $title));
		$category = preg_replace("![^a-z0-9]+!i", "-", $title);

		if ($submission) {
			$data = $submission->get_posted_data();
			$dataSkip = ['_wpcf7', '_wpcf7_version', '_wpcf7_locale', '_wpcf7_unit_tag', '_wpcf7_container_post', 'zerospam_key'];
			$inputSingle = ['text', 'email', 'textarea'];
			$firstName = $data['your-first-name']
				. $data['your-fname']
				. $data['fname']
				. $data['firstName']
				. $data['first-name']
				. $data['TxtFirstName']
				. $data['f-name']
				. $data['about-fname']
				. $data['your-FirstName']
				. $data['listings-fname'];
			$middleName = $data['your-middle-name']
				. $data['your-mname']
				. $data['mname']
				. $data['middleName']
				. $data['middle-name']
				. $data['TxtMiddleName']
				. $data['m-name'];
			$lastName = $data['your-last-name']
				. $data['your-lname']
				. $data['lname']
				. $data['lastName']
				. $data['last-name']
				. $data['TxtLastName']
				. $data['l-name']
				. $data['your-LastName']
				. $data['about-name']
				. $data['listings-lname'];
			$fullName = $data['your-name']
				. $data['your-fullname']
				. $data['fullname']
				. $data['full_name']
				. $data['TxtFullName']
				. $data['about-name']
				. $data['git-name']
				. $data['listings-name']
				. $data['contact-name'];
			$name = ! empty($fullName) ? $fullName : $firstName . ' ' . trim($middleName . ' ' . $lastName);
			$email = $data['your-email']
				. $data['email']
				. $data['email-address']
				. $data['TxtEmailAddress']
				. $data['git-email']
				. $data['about-email']
				. $data['contact-email']
				. $data['your-Email']
				. $data['listings-email']
				. $data['join-email'];
			$phone = $data['your-phone']
				. $data['phone']
				. $data['Phone']
				. $data['phone-number']
				. $data['TxtPhoneNumber']
				. $data['git-phone']
				. $data['about-phone']
				. $data['your-Phone']
				. $data['contact-phone']
				. $data['listings-phone'];
			$consent = $data['consent']
				. $data['consent-checkbox']
				. $data['consent-field'];
			$consentText = $data['consent-text']
				. $data['consent-description'];
			$message = $data['your-message']
				. $data['message']
				. $data['TxtMessage']
				. $data['git-message']
				. $data['about-message']
				. $data['your-Message']
				. $data['listings-message']
				. $data['contact-message'];
			$tags = $data['tags'] . $data['tag'];
			$assignedTo = $data['agent-name'];
			$formTag = $this->accessProtected($wpcf7, 'scanned_form_tags');

			/** List of input used */
			$meta = $this->accessProtected($submission, 'meta');

			/** List of page url, time, and ip of user */
			$page_source = str_replace(get_home_url(), '', $data['form-page-source']);
			$date_created = date("m/d/Y h:i:s A", $meta['timestamp']);
			$bodyArr = [];
			foreach ($data as $k => $v) {
				if (!in_array($k, $dataSkip) && !empty($v)) {
					foreach ($formTag as $kf) {
						if ($kf->name == $k) {
							if (in_array($kf->baseType, $inputSingle)) {
								$labels = (!empty($kf->labels) ? $kf->labels : ucwords(preg_replace("![^a-z0-9]+!i", " ", $kf->name)));
							} else {
								$labels = ucwords(preg_replace("![^a-z0-9]+!i", " ", $kf->name));
							}

							$bodyArr[][$labels] = sanitize_text_field(is_array($v) ? join(', ', $v) : $v);
						}
					}
				}
			}

			// Upload files if is not spam
			if (!$spam) {
				// Set your custom directory
				$upload_dir = wp_upload_dir();
				$dir = '/aios-cf7-uploads/';
				$target_dir = $upload_dir['basedir'] . $dir;
			
				// Make sure the directory exists
				if (!file_exists($target_dir)) {
					wp_mkdir_p($target_dir);
				}

				// Uploaded files and allowed extensions
				$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'heic', 'heif', 'txt'];
				$uploaded_files = $submission->uploaded_files();

				foreach ($uploaded_files as $field_name => $files) {
					foreach ($files as $file_path) {
						if (file_exists($file_path)) {
							// Get file extension
							$file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
				
							// Check if extension is allowed
							if (in_array($file_extension, $allowed_extensions)) {
								$file_name = basename($file_path);
								$new_path = $target_dir . $file_name;

								// If file already exists, append a number to the filename
								$i = 1;
								$file_base = pathinfo($file_name, PATHINFO_FILENAME);
								while (file_exists($new_path)) {
									$new_file_name = $file_base . '-' . $i . '.' . $file_extension;
									$new_path = $target_dir . $new_file_name;
									$i++;
								}
				
								// Move the file
								rename($file_path, $new_path);

								$bodyArr['file'][$field_name][] = str_replace($upload_dir['basedir'] . $dir, '', $new_path);
							}
						}
					}
				}
			}

			$bodyArr['consent'] = $consent;
			$bodyArr['consent_text'] = $consentText;

			$bodyArr['browser'] = $meta['user_agent'];
			$bodyArr['remote_ip'] = $meta['remote_ip'];

			// Separate first name and last name if full name is not empty 
			if ( ! empty( $fullName ) ) {
				$fullName = explode( ' ', $fullName );
				$lastName = end($fullName);

				if ( count( $fullName ) > 1 ) {
					array_pop( $fullName );
				}

				$firstName = implode( ' ', $fullName );
			}

			// Create dataset for integrations
			$dataset = [
				"pageUrl"		=> $data['form-page-source'],
				"source"        => $title,
				"firstName"     => $firstName ?? '',
				"lastName"      => $lastName ?? '',
				"email"        	=> $email ?? '',
				"phone"        	=> $phone ?? '',
				"tags"        	=> $tags ?? '',
				"assignedTo"    => $assignedTo ?? ''
			];
			
			// Push leads to FUB
			$fub = get_option('aios_fub');

			if ($fub['enabled'] ?? '' === "1" && ! empty($fub['api-key'] ?? '')) {
				$bodyArr['fub'] = $this->fub_add_leads(
					$fub['api-key'],
					$dataset,
					$bodyArr
				);
			}

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

			// Insert to Custom DB
			if(isset($_POST['consent']) || isset($_POST['consent-checkbox']) || isset($_POST['consent-field'])){
				$consent = 'Yes';
			}else{
				$consent = 'No';
			}

			global $wpdb;
			$wpdb->insert($wpdb->prefix . AIOS_LEADS_NAME, [
				'title' 			=> mb_strimwidth(sanitize_text_field($title), 0, 140, "..."),
				'category' 			=> mb_strimwidth(sanitize_text_field($category), 0, 140, "..."),
				'client_name' 		=> mb_strimwidth(sanitize_text_field($name), 0, 140, "..."),
				'client_email' 		=> mb_strimwidth(sanitize_text_field($email), 0, 140, "..."),
				'client_phone' 		=> mb_strimwidth(sanitize_text_field($phone), 0, 140, "..."),
				'client_message' 	=> mb_strimwidth(sanitize_text_field($message), 0, 140, "..."),
				'consent' 			=> mb_strimwidth(sanitize_text_field($consent), 0, 140, "..."),
				'consent_text' 		=> mb_strimwidth(sanitize_text_field($consentText), 0, 140, "..."),
				'client_body' 		=> serialize($bodyArr),
				'remote_ip' 		=> $meta['remote_ip'],
				'page_source' 		=> $page_source,
				'spam' 				=> $spam,
				'date' 				=> $date_created,
				'created_at' 		=> date("Y-m-d H:i:s")
			]);
		}
	}

	/**
	 * @param $ids
	 */
	private function deleteLeads($ids)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . AIOS_LEADS_NAME;
		$ids = implode(',', array_map('absint', $ids));
		$wpdb->query("DELETE from $table_name WHERE id IN($ids)");
	}

	/**
	 * @param $obj
	 * @param $prop
	 * @return mixed
	 */
	private function accessProtected($obj, $prop)
	{
		try {
			$reflection = new ReflectionClass($obj);
			$property = $reflection->getProperty($prop);
			$property->setAccessible(true);
			return $property->getValue($obj);
		} catch (\ReflectionException $e) {
			return $obj;
		}
	}

	/**
	 * Export Leads
	 */
	private function exportLeads($fullDetails)
	{
		// Get SQL data
		global $wpdb;
		$table_name = $wpdb->prefix . AIOS_LEADS_NAME;
		$prepare = $wpdb->prepare("SELECT * FROM $table_name ORDER BY id DESC LIMIT %d OFFSET %d", 10000, 0);
		$results = $wpdb->get_results($prepare, OBJECT);

		$data = ['No leads to be exported.'];

		if (! empty($results)) {
			// prepare the data set
			$data = [['Name', 'Email', 'Form', 'Phone', 'Message', 'Consent', 'Consent Text', 'Page Source', 'Date']];

			foreach ($results as $row) {
				$client_body = maybe_unserialize($row->client_body);
				$client_html = $client_body;

				if (is_array($client_body)) {
					// Get browser and remote_ip then unset
					$browser = $client_body['browser'];
					unset($client_body['browser']);
					$remote_ip = $client_body['remote_ip'];
					unset($client_body['remote_ip']);

					// Reset data
					$client_html = "Form Details\n";

					foreach ($client_body as $arr) {
						$client_html .= !empty($arr) ? key($arr) . ': ' . $arr[key($arr)] . "\n" : '';
					}

					// Other Data
					$client_html .= "\nOther Info\n
Browser: {$browser}\n
Remote IP: {$remote_ip}\n
Page Source: {$row->page_source}\n
Date: {$row->date}\n";
				} else {
					$client_html = preg_replace('/^ +/m', '', $client_html); // Remove space from start of each new line
					$client_html = str_replace('<br>', "\n", $client_html); // Change BR to newline
					$client_html = str_replace('<span class="full-logs-details-title mt-0">Form Details</span>', "Form Details\n", $client_html); // Change end of span from new line
					$client_html = strip_tags($client_html); // Strip tags
				}

				// Let's extract email if client_email doesn't exists
				$email = $row->client_email ?? '';
				if (empty($email)) {
					$emails = extractEmailFromString($client_html);

					if (count($emails) > 0) {
						$email = $emails[0];
					}
				}

				// Let's extract phone if client_phone doesn't exists
				$phoneNumber = $row->client_phone ?? '';
				if (empty($phoneNumber)) {
					$phoneNumbers = extractPhoneNumbersFromString($client_html);

					if (count($phoneNumbers) > 0) {
						$phoneNumber = implode(', ', $phoneNumbers);
					}
				}

				$data[] = [
					$row->client_name,
					$email,
					$row->category,
					$phoneNumber,
					$row->client_message,
					$row->consent,
					$row->consent_text,
					$row->page_source,
					$row->date,
					isset($fullDetails) ? $client_html : ''
				];
			}

		}

		header( 'Content-Type: application/csv' );
		header( 'Content-Disposition: attachment; filename="' . 'aios-leads-cf7-' . date("m-d-Y") . '.csv' . '";' );

		// clean output buffer
		ob_end_clean();

		$handle = fopen( 'php://output', 'w' );

		// use keys as column titles
		foreach ( $data as $value ) {
			fputcsv( $handle, $value , ',' );
		}

		fclose( $handle );

		// flush buffer
		ob_flush();
	}

	private function deleteSpamLeads($category)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . AIOS_LEADS_NAME;
		
		if ($category == 'all') {
			$wpdb->query("DELETE FROM $table_name WHERE spam LIKE 1");
		} else {
			$wpdb->query("DELETE FROM $table_name WHERE spam LIKE 1 AND category = '$category'");
		}

		return true;
	}
}