<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta id="viewport-tag" name="viewport" content="width=device-width, initial-scale=1"/>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php if ( has_action( 'aios_seotools_gtm_body' ) ) { do_action('aios_seotools_gtm_body'); } ?>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Mobile Header") ) : ?><?php endif ?>


	<div id="main-wrapper">
		
		<header class="header">
			<header class="header__container site-container flex justify-between items-center">
				<div class="header__logo">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Header: Logo") ) : ?><?php endif ?>
				</div><!-- end of logo -->
				<div class="header__menu flex items-center">
					<nav class="header__nav">
						<?php wp_nav_menu( 
							array( 
									'sort_column' => 'menu_order', 
									'menu_id' => 'nav', 
									'menu_class' => 'flex justify-between',
									'theme_location' => 'primary-menu',
									'link_after'	=> '<svg xmlns="http://www.w3.org/2000/svg" width="6" height="4" viewBox="0 0 6 4" fill="none"><path d="M2.90002 3.5L5.40002 0.5H0.400024L2.90002 3.5Z" fill="white"/></svg>',
								) 
							); 
						?>
					</nav>
					<div class="header__contactInfo">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Header: Contact Info") ) : ?><?php endif ?>
					</div><!-- ebnd of contact info -->
					<div class="header__burgerMenu">
						<svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 22 12" fill="none">
							<rect width="22" height="2" fill="#D9D9D9"/>
							<rect y="5" width="22" height="2" fill="#D9D9D9"/>
							<rect y="10" width="22" height="2" fill="#D9D9D9"/>
						</svg>
					</div><!-- end of burger menu -->
				</div><!-- end of menu -->
			</header>
		</header>
		

		<header class="mobileMenu">
			<div class="mobileMenu__container">

				<div class="mobileMenu__logo">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Expanded Menu: Logo") ) : ?><?php endif ?>
					<div class="mobileMenu__close">
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
							<path d="M18 1.49206L16.8487 0L9 7.68254L1.15133 0L0 1.49206L7.66615 9L0 16.5079L1.15133 18L9 10.3175L16.8487 18L18 16.5079L10.3339 9L18 1.49206Z" fill="black"/>
						</svg>
					</div>
				</div>

				<div class="mobileMenu__nav">
					<?php wp_nav_menu( 
						array( 
								'sort_column' => 'menu_order', 
								'menu_id' => 'nav', 
								'theme_location' => 'primary-menu',
								'link_after'	=> '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="27" viewBox="0 0 26 27" fill="none">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M12.8822 15.2644L18.6466 9.5L19.7645 10.6178L12.8822 17.5L6 10.6178L7.11781 9.5L12.8822 15.2644Z" fill="#080341"/>
								</svg>',

							) 
						); 
					?>
				</div>

				<div class="mobileMenu__contactInfo">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Expanded Menu: Contact Info") ) : ?><?php endif ?>
				</div><!-- end of contact info -->
		</header>
	<main>
		<h2 class="aios-starter-theme-hide-title">Main Content</h2>

		<!-- ip banner goes here -->
    <?php
    if ( ! is_home() && !is_page_template( 'template-homepage.php' ) && is_custom_field_banner( get_queried_object() ) && is_active_sidebar('aios-inner-pages-banner')) {
      dynamic_sidebar('aios-inner-pages-banner');
    }
    ?>
		<!-- ip banner goes here -->


		<?php if ( !is_home() && !is_page_template( 'template-fullwidth.php' ) && !is_page_template( 'template-homepage.php' ) ) : ?>

		<div id="inner-page-wrapper">
			<div class="inner-page-container site-container">

		<?php endif ?>
