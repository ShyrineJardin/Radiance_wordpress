<?php

namespace AiosInitialSetup\App\Modules\ContactFormSubmissions;

use AiosInitialSetup\Config\Config;
use AiosInitialSetup\Config\Leads;

class Module
{
	use Config,
		Leads;

	/**
	 * Run class
	 *
	 * @return void
	 */
	public function __construct()
	{
		add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
		add_action('admin_menu', [$this, 'render_sub_pages'], 11);
		add_action('wpcf7_mail_sent', [$this, 'wpcf7_insert_post']);
		add_action('wp_ajax_delete_leads', [$this, 'delete_leads']);
		add_action('init', [$this, 'export_leads']);
		add_action('wp_ajax_delete_spam_leads', [$this, 'delete_spam_leads']);
	}

	public function enqueue_scripts()
	{
		wp_enqueue_script('aios-leads', AIOS_INITIAL_SETUP_RESOURCES . 'vite/js/website-leads.js', ['jquery']);
		wp_localize_script('aios-leads', 'ajaxurl', admin_url('admin-ajax.php'));
	}

	/**
	 * Add sub menu page
	 *
	 * @since 3.8.0
	 *
	 * @access public
	 */
	public function render_sub_pages()
	{
		$loginScreen = $this->loginScreen();

		add_menu_page(
			'Contact Form 7 Leads - AgentImage Plugin',
			'Website Leads',
			'manage_options',
			'aios-cf7-store-messages',
			[$this, 'render'],
			$loginScreen['icon'],
			93
		);
	}

	/**
	 * Fallback: Render sub menu page
	 *
	 * @since 3.8.0
	 *
	 * @access public
	 */
	public function render()
	{
		include_once AIOS_INITIAL_SETUP_VIEWS . 'email-leads' . DIRECTORY_SEPARATOR . 'index.php';
	}

	/**
	 * Insert post to custom post type
	 *
	 * @param $WPCF7_ContactForm
	 * @return void
	 * @since 3.8.0
	 *
	 */
	public function wpcf7_insert_post($WPCF7_ContactForm)
	{
		$wpcf7 = \WPCF7_ContactForm:: get_current();
		$submission = \WPCF7_Submission::get_instance();
		$this->CreateLeads($WPCF7_ContactForm->title, $wpcf7, $submission, false);
	}

	/**
	 * Delete Leads
	 */
	public function delete_leads()
	{
		if (isset($_POST['data']) && ! empty($_POST['data'])) {
			$this->deleteLeads($_POST['data']);
		}

		echo json_encode(['Deleted']);
		die();
	}

	/**
	 * Export Leads
	 */
	public function export_leads()
	{
		error_reporting(0);
		if (strpos($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], str_replace(['http://', 'https://'], '', get_home_url() . '/aios/leads/export')) !== false) {

			// having issue? try adding this to wp-config after WP_DEBUG "define('SCRIPT_DEBUG', true);"
			$this->exportLeads($_GET['full-details']);

			// use exit to get rid of unexpected output afterward
			exit;
		}
	}

	/**
	 * Delete Spam Leads
	 */
	public function delete_spam_leads()
	{
		error_reporting(0);

		if (isset($_POST['data']) && ! empty($_POST['data'])) {
			$this->deleteSpamLeads($_POST['data']['category']);
		}

		echo json_encode(['Deleted']);
		exit;
	}
}

new Module();
