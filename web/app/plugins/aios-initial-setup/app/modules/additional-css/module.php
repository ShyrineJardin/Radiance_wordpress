<?php
/**
 * Name: Additional CSS
 * Remove additional CSS
 * Version: 6.1.4
 */

namespace AiosInitialSetup\App\Modules\AdditionalCss;

class AdditionalCss {
  /**
   * Module constructor.
   */
  public function __construct()
  {

	add_action( 'customize_register', [$this, 'customizer_remove_css_section'], 15 );

  }

  	/*
  		Disable Additional CSS on Customizer
	*/
	
	function customizer_remove_css_section( $wp_customize ) {

		$wp_customize->remove_section( 'custom_css' );

	}
}

new AdditionalCss();