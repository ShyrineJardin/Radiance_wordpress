<?php

namespace AiosInitialSetup\App\Controllers;

use WP_Post;

class ShortcodeController
{
  /**
   * Shortcode constructor.
   */
  public function __construct()
  {
    // This hook is called during each page load, after the theme is initialized.
    add_action('after_setup_theme', [$this, 'shortcodeLists'], 20);
  }

  /**
   * Init Shortcodes after theme initialzie.
   *
   * @since 3.1.8
   * @access public
   * @return void
   */
  public function shortcodeLists()
  {
    // Force to remove old shortcodes and replace
    add_shortcode('agentimage_credits', [$this, 'credits_shortcode']);
    add_shortcode('bloginfo', [$this, 'get_bloginfo']);
    add_shortcode('blogurl', [$this, 'get_blogurl']);
    add_shortcode('current_url', [$this, 'get_current_url']);
    add_shortcode('agentimage_video', [$this, 'get_agentimage_video']);
    add_shortcode('aios_element', [$this, 'get_aios_element']);
    add_shortcode('iframe_async', [$this, 'get_iframe_async']);
    add_shortcode('mail_to', [$this, 'get_mail_to']);
    add_shortcode('ai_phone', [$this, 'get_ai_phone']);
    add_shortcode('currentYear', [$this, 'get_currentYear']);
    add_shortcode('sitemap', [$this, 'get_sitemap']);
    add_shortcode('aios_sitemap', [$this, 'get_sitemap']);
    add_shortcode('stylesheet_directory', [$this, 'get_stylesheet_directory']);
    add_shortcode('template_directory', [$this, 'get_template_directory']);
    add_shortcode('aios-mortgage-calculator', [$this, 'mortgage_calculator_shortcode']);

    // filter the menu item output on frontend.
    add_filter('walker_nav_menu_start_el', [$this, 'start_el'], 20, 2);

    // images
    add_shortcode('aios_responsive_image',  [$this, 'aios_responsive_image_render']);
    add_shortcode('aios_image',  [$this, 'aios_image_render']);

    // Custom Banner
    add_shortcode('aios_custom_banner',  [$this, 'aios_custom_banner_render']);

    // Current dates
	  add_shortcode('date_day', [$this, 'date_day']);
	  add_shortcode('date_year', [$this, 'date_year']);
	  add_shortcode('date_month', [$this, 'date_month']);
	  add_shortcode('date_yyyymmdd', [$this, 'date_yyyymmdd']);
	  add_shortcode('date_monthyear', [$this, 'date_monthyear']);
  }

  /**
   * Return Agentimage Copyright.
   *
   * @param $atts
   * @return string
   * @since 3.1.8
   * @access public
   */
  public function credits_shortcode($atts)
  {
    $atts = shortcode_atts([
      "credits" => "",
      "renew" => "false",
      "seo" => "false",
    ], $atts, 'agentimage_credits');

    // If SEO is true
    if ($atts['seo'] === 'true') {
      $v_credits = "Real Estate Website Design & Internet Marketing by <a target='_blank' href='https://www.agentimage.com' style='text-decoration:underline;font-weight:bold'>Agent Image</a>";
    } else {
      if ($atts['credits'] === '') {
        $v_credits = "Real Estate Website Design by <a target='_blank' href='https://www.agentimage.com' style='text-decoration:underline;font-weight:bold'>Agent Image</a>";
      } else {
        $v_credits = $atts['credits'];
      }
    }

    // Get credits
    $credits = get_option('ai_starter_theme_agentimage_credits');

    // Renew credits
    if ($atts['renew'] == "true" && $credits != $v_credits) {
      delete_option('ai_starter_theme_agentimage_credits');
    }

    // Add credits if not yet existing
    add_option('ai_starter_theme_agentimage_credits', $v_credits);

    // Use persistent credits if existing
    $persistent_credits = get_option('ai_starter_theme_agentimage_credits_persistent');
    if ($persistent_credits) {
      $credits = $persistent_credits;
    }

    return $credits;
  }

	/**
	 * Displays information about the current site.
	 * @param $atts
	 *
	 * @since 5.8.0
	 * @access public
	 * @return string
	 */
  public function get_bloginfo($atts) {
	  $atts = shortcode_atts([
		  'show' => '',
	  ], $atts, 'bloginfo');

	  return get_bloginfo($atts['shows']);
  }

  /**
   * Return Domain.
   *
   * @since 3.1.8
   * @access public
   * @return string
   */
  public function get_blogurl()
  {
    return home_url();
  }

  /**
   * Return Current Page URL.
   *
   * @since 3.1.8
   * @access public
   * @return string
   */
  public function get_current_url()
  {
    return home_url(add_query_arg('_', false));
  }

  /**
   * Return Iframe Video with Placeholder.
   *
   * @param $atts
   * @return string
   * @since 3.1.8
   * @access public
   */
  public function get_agentimage_video($atts)
  {
    $args = shortcode_atts([
      'width' => 560,
      'height' => 315,
      'url'	=> 'https://player.vimeo.com/video/215609798'
    ], $atts);

    $markup = "<iframe width='{$args['width']}' height='{$args['height']}' src='{$args['url']}'></iframe>";
    return $markup;
  }

  /**
   * Return this return shortcode that doesn't accept by WordPress > 4.6.0.
   *
   * @param array $atts
   * @param null $content
   * @return string
   * @since 3.1.8
   * @access public
   */
  public function get_aios_element($atts = [], $content = null)
  {
    $atts = shortcode_atts([
      'element'         => '',
      'class'           => '',
      'width'           => '',
      'height'          => '',
      'style'           => '',
      'data-src'        => '',
      'data-class'      => '',
      'data-animation'  => '',
      'data-offset'     => ''
    ], $atts);

    $class = ! empty($atts['class']) ? ' class="' . $atts['class'] . '"' : '';
    $width = ! empty($atts['width']) ? ' width="' . $atts['width'] . '"' : '';
    $height = ! empty($atts['height']) ? ' height="' . $atts['height'] . '"' : '';
    $style = ! empty($atts['style']) ? ' style="' . $atts['style'] . '"' : '';
    $dataSrc	= ! empty($atts['dataSrc']) ? ' data-src="' . $atts['dataSrc'] . '"' : '';
    $dataClass	= ! empty($atts['dataClass']) ? ' data-class="' . $atts['dataClass'] . '"' : '';
    $dataAnimation = ! empty($atts['dataAnimation']) ? ' data-animation="' . $atts['dataAnimation'] . '"' : '';
    $dataOffset	= ! empty($atts['dataOffset']) ? ' data-offset="' . $atts['dataOffset'] . '"' : '';

    if (! empty($element)) {
      $content = '<' . $element
        . $class
        . $width
        . $height
        . $style
        . $dataSrc
        . $dataClass
        . $dataAnimation
        . $dataOffset .'>' . $content . '</' . $element . '>';
    }
    $content = str_replace('{{blogurl}}', get_home_url(), $content);
    $content = str_replace('{{theme_dir}}', get_stylesheet_directory_uri(), $content);
    $content = str_replace('{{template_dir}}', get_template_directory_uri(), $content);
    $content = do_shortcode($content);

    return $content;
  }

  /**
   * Return load iframe after the page is fully loaded.
   *
   * @param $atts
   * @return string
   * @since 3.1.8
   * @access public
   */
  public function get_iframe_async($atts)
  {
    $atts = shortcode_atts([
      'src' => 'http://localhost/vip-clients/sallyforsterjones.com/',
      'width' => 700,
      'height' => 350,
      'id' => '',
      'class' => '',
      'additional' => '' //for additional attributes
    ], $atts);

    if ($atts['id'] !== '') {
      $atts['id'] = 'id="' . $atts['id'] . '"';
    }

    $iframe_output = '
				<iframe 
					websource="' . $atts['src'] . '"
					width="' . $atts['width'] . '"
					height="' . $atts['height'] . '"
					' . $atts['id'] . '
					class="aios-iframe ' . $atts['class'] . '"
					' . $atts['additional'] . '
				></iframe>
			';

    return $iframe_output;
  }

  /**
   * Return Email Address Obfuscated.
   *
   * @param $atts
   * @param string $content
   * @return string
   * @since 3.1.8
   * @access public
   */
  public function get_mail_to($atts, $content = "")
  {
    $atts = shortcode_atts([
      'email' => '',
      'class' => '',
    ], $atts);

    // Do character replacements in the email address
    $obfuscated_email = str_replace('@','(at)',$atts['email']);
    $obfuscated_email = str_replace('.','(dotted)',$obfuscated_email);

    // Replace instances of email address with the obfuscated version in the content
    $obfuscated_content = do_shortcode(str_replace($atts['email'], $obfuscated_email, $content));

    // Return output
    return '<a class="asis-mailto-obfuscated-email-hidden asis-mailto-obfuscated-email ' . $atts['class'] . '" aria-label="' . $obfuscated_email . '" data-value="' . $obfuscated_email . '">' . $obfuscated_content . '</a>';
  }

  /**
   * Return Phone Number.
   *
   * @param $atts
   * @param null $content
   * @return string
   * @since 3.1.8
   * @access public
   */
  public function get_ai_phone($atts, $content = null)
  {
    $atts = shortcode_atts([
      'filter' => true,
      'href' => '',
      'extension' => '',
      'convert_js' => false,
      'unwrap_em' => false,
      'class' => ''
    ], $atts);

    if ($atts['convert_js'] || $atts['convert_js'] === 'true') {
      if ($atts['extension'] != "") {
        $atts['extension'] = 'data-ext="' . $atts['extension'] .'"';
      }

      $disabled_filter = $atts['filter'] === 'false' ? 'data-filter="off"' : '';

      return '<em class="ai-mobile-phone" '.$disabled_filter.' data-href="'.$atts['href'].'" '.$atts['extension'].'>'.$content.'</em>';
    } else {
      $dialer = $atts['href'] . (! empty($atts['extension']) ? ',' . $atts['extension'] : '');
      $dialer = str_replace(" ","",$dialer);
      $class = ! empty( $class ) ? $atts['class'] : '';
      $html = '<a href="tel:' . $dialer . '" class="aios-ai-phone ' . $class . '" aria-label="'.$dialer.'">' . $content . '</a>';

      return $atts['unwrap_em'] || $atts['unwrap_em'] == 'true' ? $html : '<em class="ai-mobile-phone">' . $html . '</em>';
    }
  }

  /**
   * Return Current Year.
   *
   * @since 3.1.8
   * @access public
   * @return string
   */
  public function get_currentYear()
  {
    return date('Y');
  }

  /**
   * Return list of pages using wp_list_pages().
   *
   * @param $atts
   * @return string
   * @since 3.1.8
   * @access public
   */
  public function get_sitemap($atts)
  {
    if (! is_array($atts)) {
      $atts = [];
    }

    $defaults = [
      'depth' => 0,
      'show_date' => '',
      'date_format' => 'F j, Y',
      'child_of' => 0,
      'exclude' => '',
      'title_li' => '',
      'echo' => 1,
      'authors' => '',
      'sort_column' => 'post_title',
      'link_before' => '',
      'link_after' => '',
      'item_spacing' => 'preserve',
      'walker' => '',
      'expiration' => 3,
      'refresh' => false,
      'show_categories' => false,
    ];

    // Check if sitemap does have transient
    $cache = get_transient('aios-is-sitemap');

    // Bypass if refresh is true even there's a cache
    if ($cache && $defaults['refresh'] === false) {
      return $cache;
    }

    // Parse and updated defaults
    $parsed_args = wp_parse_args($atts, $defaults);
    $parsed_args['date_format'] = get_option('date_format');
    $parsed_args['exclude'] = preg_replace('/[^0-9,]/', '', $parsed_args['exclude']);
    
    // Allow plugins to filter an array of excluded pages (but don't put a nullstring into the array).
	  $exclude_array = $parsed_args['exclude'] ? explode(',', $parsed_args['exclude']) : [];

    // Filters the array of pages to exclude from the pages list.
    $parsed_args['exclude'] = implode(',', apply_filters('wp_list_pages_excludes', $exclude_array));
    $parsed_args['hierarchical'] = 0;

    // Output
    $html = '<ul class="sitemap-list">' . $this->sitemap_html($parsed_args) . '</ul>';

    // Save to transient
    $expiration_in_day = absint($parsed_args['expiration']);
    set_transient('aios-is-sitemap', $html, DAY_IN_SECONDS * $expiration_in_day);

    return $html;
  }
  
  /**
   * sitemap_html
   *
   * @param  mixed $parsed_args
   * @return void
   */
  private function sitemap_html($parsed_args) 
  {
    $output = '';
    $current_page = 0;

    // Query pages.
    $pages = get_pages($parsed_args);

    // Query communities.
    $aios_communities_settings = get_option('aios_communities_settings', []);
    if (isset($aios_communities_settings['main_page'])) {
      $extended_args = $parsed_args;
      $extended_args['numberposts'] = '-1';
      $extended_args['order'] = 'ASC';
      $extended_args['orderby'] = 'title';
      $extended_args['post_type'] = 'aios-communities';
      $communities = get_posts($extended_args);

      foreach ($communities as $community) {
        $community->post_parent = absint($aios_communities_settings['main_page']);
        $pages[] = $community;
      }
    }

    // Query roadmaps.
    $aios_roadmaps_status = get_option('aios-roadmaps', '');
    if ($aios_roadmaps_status === 'freshly-installed') {
		  $aios_roadmaps_settings = get_option('aios_roadmaps_settings', []);

      // Buyers
      if (isset($aios_roadmaps_settings['buyers_page'])) {
        $extended_args['post_type'] = 'aios-rm-buyers';
        $buyers = get_posts($extended_args);

        foreach ($buyers as $buyer) {
          $buyer->post_parent = absint($aios_roadmaps_settings['buyers_page']);
          $pages[] = $buyer;
        }
      }

      // Sellers
      if (isset($aios_roadmaps_settings['sellers_page'])) {
        $extended_args['post_type'] = 'aios-rm-sellers';
        $sellers = get_posts($extended_args);

        foreach ($sellers as $seller) {
          $seller->post_parent = absint($aios_roadmaps_settings['sellers_page']);
          $pages[] = $seller;
        }
      }

      // Financing
      if (isset($aios_roadmaps_settings['financing_page'])) {
        $extended_args['post_type'] = 'aios-rm-financing';
        $finances = get_posts($extended_args);

        foreach ($finances as $finance) {
          $finance->post_parent = absint($aios_roadmaps_settings['financing_page']);
          $pages[] = $finance;
        }
      }
    }

    if ($parsed_args['show_categories'] === "true") {
      $categories = get_categories(['hide_empty' => false]);
      if (! empty($categories)) {
        foreach ($categories as $category) {
          $post_id = -$category->term_id;
          $post = new WP_Post((object) [
              "ID" => $post_id,
              "post_author" => 1,
              "post_date" => current_time( 'mysql' ),
              "post_date_gmt" => current_time( 'mysql', 1 ),
              "post_title" => $category->name,
              "post_content" => '',
              "post_status" => 'publish',
              "comment_status" => 'closed',
              "ping_status" => 'closed',
              "post_name" => str_replace(get_home_url(), '', get_category_link($category->term_id)),
              "post_type" => 'page',
              "filter" => 'raw',
          ]); 
          
          wp_cache_add( $post_id, $post, 'posts' );
          
          $pages[] = $post;
        }
      }
    }

    if (!empty($pages)) {
      if ($parsed_args['title_li']) {
        $output .= '<li class="pagenav">' . $parsed_args['title_li'] . '<ul>';
      }

      global $wp_query;

      if (is_page() || is_attachment() || $wp_query->is_posts_page) {
        $current_page = get_queried_object_id();
      } elseif (is_singular()) {
        $queried_object = get_queried_object();
        if (is_post_type_hierarchical($queried_object->post_type)) {
          $current_page = $queried_object->ID;
        }
      }

      $output .= walk_page_tree($pages, $parsed_args['depth'], $current_page, $parsed_args);

      if ( $parsed_args['title_li'] ) {
        $output .= '</ul></li>';
      }
    }

    return apply_filters('wp_list_pages', $output, $parsed_args, $pages);
  }

  /**
   * Return Stylesheet Directory.
   * If child this will get the child directory
   *
   * @since 3.1.8
   * @access public
   * @return string
   */
  public function get_stylesheet_directory()
  {
    return get_stylesheet_directory_uri();
  }

  /**
   * Return Template Directory / Parent Direct.
   *
   * @since 3.1.8
   * @access public
   * @return string
   */
  public function get_template_directory()
  {
    return get_template_directory_uri();
  }

  /**
   * Return Mortgage Calculator
   *
   * @param $atts
   * @return string
   * @since 3.6.4
   * @access public
   */
  public function mortgage_calculator_shortcode($atts)
  {
    $atts = shortcode_atts([
      'years'		=> '',
      'interest'	=> '',
      'la'		=> '',
      'tax'		=> '',
      'insurance'	=> ''
    ], $atts, 'aios-mortgage-calculator');

    return '<div class="aios-mortgage-calculator-standalone">
	<p>Owning a home is a great investment and it is key to plan your mortgage payments ahead of time. Calculate your monthly mortgage using our free calculator below.</p>
	<form action="#" method="post" enctype="application/x-www-form-urlencoded" name="temps">
		<span class="aios-mortgage-calculator-standalone-form-reminder">Required fields are marked*</span>
		
		<div class="aios-mortgage-calculator-standalone-mort-row">
			<div class="aios-mortgage-calculator-standalone-full-input">
				<label for="aios-mortgage-calculator-standalone-loan-years">Length of Loan Years *</label>
				<input type="text" id="aios-mortgage-calculator-standalone-loan-years" class="aios-mortgage-calculator-standalone-loan-years aios-mortgage-calculator-standalone-number" name="YR" value="' . $atts['years'] . '">
			</div> 
			<div class="aios-mortgage-calculator-standalone-full-input">
				<label for="aios-mortgage-calculator-standalone-interest-rate">Interest Rate (%) *</label>
				<input type="text" id="aios-mortgage-calculator-standalone-interest-rate" class="aios-mortgage-calculator-standalone-interest-rate aios-mortgage-calculator-standalone-number" name="IR" value="' . $atts['interest'] . '">
			</div>
			<div class="aios-mortgage-calculator-standalone-half-input">
				<label for="aios-mortgage-calculator-standalone-loan-amount">Loan Amount *</label>
				<input type="text" id="aios-mortgage-calculator-standalone-loan-amount" class="aios-mortgage-calculator-standalone-loan-amount aios-mortgage-calculator-standalone-number" name="LA" value="' . $atts['la'] . '">
			</div>
			<div class="aios-mortgage-calculator-standalone-half-input">
				<label for="aios-mortgage-calculator-standalone-property-tax">Annual Property Tax *</label>
				<input type="text" id="aios-mortgage-calculator-standalone-property-tax" class="aios-mortgage-calculator-standalone-property-tax aios-mortgage-calculator-standalone-number" value="' . $atts['tax'] . '" name="AT" >
			</div>
			<div class="aios-mortgage-calculator-standalone-full-input">
				<label for="aios-mortgage-calculator-standalone-annual-insurance">Annual Insurance *</label>
				<input type="text" id="aios-mortgage-calculator-standalone-annual-insurance" class="aios-mortgage-calculator-standalone-annual-insurance aios-mortgage-calculator-standalone-number" name="AI" value="' . $atts['insurance'] . '">
			</div>
			<div class="aios-mortgage-calculator-standalone-mortgage-buttons">
				<div class="aios-mortgage-calculator-standalone-half-input">
					<button type="reset" class="aios-mortgage-calculator-standalone-reset" value="Reset">Reset</button>
				</div>
				<div class="aios-mortgage-calculator-standalone-half-input">
					<button type="submit" class="aios-mortgage-calculator-standalone-calculate" value="Calculate">Calculate</button>
				</div>
			</div>   
		</div> 
		<div class="aios-mortgage-calculator-standalone-calculation-result">
			<div class="aios-mortgage-calculator-standalone-mort-row">
				<div class="aios-mortgage-calculator-standalone-half-input">
					<label for="aios-mortgage-calculator-standalone-PI"><span>Monthly Principal + Interest:</span></label>
				</div>
				<div class="aios-mortgage-calculator-standalone-half-input">
					<input readonly type="text" name="PI" id="aios-mortgage-calculator-standalone-PI">
				</div>
				<div class="aios-mortgage-calculator-standalone-half-input">
					<label for="aios-mortgage-calculator-standalone-MT"><span>Monthly Tax:</span></label>
				</div>
				<div class="aios-mortgage-calculator-standalone-half-input">
						<input readonly type="text" name="MT" id="aios-mortgage-calculator-standalone-MT">
				</div>
				<div class="aios-mortgage-calculator-standalone-half-input">
					<label for="aios-mortgage-calculator-standalone-MI"><span>Monthly Insurance:</span></label>
				</div>
				<div class="aios-mortgage-calculator-standalone-half-input">
						<input readonly type="text" name="MI" id="aios-mortgage-calculator-standalone-MI">
				</div>
				<div class="aios-mortgage-calculator-standalone-half-input">
					<label for="aios-mortgage-calculator-standalone-MP"><span>Total Payment:</span></label>
				</div>
				<div class="aios-mortgage-calculator-standalone-half-input">
					<input readonly type="text" name="MP" id="aios-mortgage-calculator-standalone-MP">
				</div>
			</div>
		</div>
	</form>
	<div class="aios-mortgage-calculator-standalone-disclaimer">
		<p>DISCLAIMER: The information found in these calculators are to be used as a guide and is deemed reliable but not guaranteed. Please schedule an appointment today to find out more information about your loan.</p>
	</div>
</div>';
  }

  /**
   * Modifies the menu item display on frontend.
   *
   * @since 4.5.4
   *
   * @param string $item_output The original html.
   * @param object $item  The menu item being displayed.
   *
   * @return string Modified menu item to display.
   */
  public function start_el($item_output, $item)
  {
    // Rare case when $item is not an object, usually with custom themes.
    if (! is_object($item) || ! isset($item->object)) {
      return $item_output;
    }

    // if it isn't our custom object.
    if ('gs_sim' !== $item->object) {
      // check the legacy hack.
      if (isset($item->post_title) && 'FULL HTML OUTPUT' === $item->post_title) {
        // then just process as we used to.
        $item_output = do_shortcode(preg_replace("/https?:\/\/\[/", "[", $item->url));
      } else {
        $item_output = do_shortcode(preg_replace("/https?:\/\/\[/", "[", $item_output));
      }
      // if it is our object.
    } elseif (isset($item->description)) {
      // just process it.
      $item_output = do_shortcode($item->description);
    }

    return $item_output;
  }

  /**
   * This will output responsive images with srcset and sizes
   *
   * Sizes:
   *  - Medium resolution (default 400px x 400px max)
   *  - Medium Large resolution (default 768 x 768 max)
   *  - Large resolution (default 1024px x 1024px max)
   *  - Full resolution (original size uploaded) this will be fallback if width is greater input viewport size
   *
   * @param $atts
   * @return string
   * @since 4.5.6
   *
   */
  public function aios_responsive_image_render($atts)
  {
    $atts = shortcode_atts([
      'id' => '', // Image ID . Default: empty(required)
      'reset' => false, // Reset sizes and viewport
      'default_size' => 'full',
      'sizes' => '', // Sizes separated by commas(viewport is required). Default: medium,medium_large,large,full. Default: 400,768,1024
      'viewport' => '', // Width of monitor where to change the image sizez separated by commas(viewport is required). Default: 400,768,1024
      'id_name' => '', // ID attribute for img element
      'width' => '', // Width for img element
      'height' => '', // height for img element
      'class' => 'img-responsive', // Class attribute for img element. Default: img-responsive
      'alt' => '', // Use for custom alt, if empty this will get alt from upload images
      'lazyload' => false
    ], $atts, 'aios_responsive_image');

    // Check if ID is not empty and int
    if (empty($atts['id'])) {
      return 'ID must not be a non-empty string.';
    }

    if (! is_numeric($atts['id'])) {
      return 'ID must be numeric.';
    }

    // Width and Height
    $width = ! empty($atts['width']) ? 'width="' . $atts['width'] .'"' : '';
    $height = ! empty($atts['height']) ? 'height="' . $atts['height'] .'"' : '';

    // Let's match the sizes and viewport
    if ($atts['reset']) {
      $sizes = ! empty($atts['sizes']) ? explode(',', $atts['sizes']) : '';
      $viewport = ! empty($atts['viewport']) ? explode(',', $atts['viewport']) : '';
    } else {
      $sizes = explode(',', 'medium,medium_large,large' . (! empty($atts['sizes']) ? ',' . $atts['sizes'] : ''));
      $viewport = explode(',', '400,768,1024' . (! empty($atts['viewport']) ? ',' . $atts['viewport'] : ''));
    }

    if (count($sizes) != count($viewport)) {
      return 'Sizes and viewport must be equal separated by comma.';
    }

    // Check given id if exists
    $image = wp_get_attachment_image_src($atts['id'], ($atts['reset'] ? (! empty($atts['default_size']) ? $atts['default_size'] : end($sizes)) : 'full' ));

    /** Enable lazyload */
    if ($atts['lazyload']) {
      $class = 'lazyload ' . $atts['class'];
    } else {
      $class = $atts['class'];
    }

    if ( $image ) {
      $image_set = $this->aios_responsive_image_srcs($atts['id'], $sizes, $viewport);
      $id_name = ! empty($atts['id_name']) ? 'id="' . $atts['id_name'] . '"' : '';
      $alt_tag = ! empty($atts['alt']) ? $atts['alt'] : $this->aios_responsive_image_alt($atts['id']);
      $alt_tag = ! empty($alt_tag) ? 'alt="' . $alt_tag . '"' : '';
      $output = '<picture>
			' . $image_set . '
			<img ' . $width . ' ' . $height . ' src="' . $image[0] . '" ' . $alt_tag . ' ' . $id_name . ' class="' . $class . '">
			<noscript><img src="' . $image[0] . '" ' . $alt_tag . ' ' . $id_name . ' class="' . $class . 	'"></noscript>
		</picture>';

      return $output;
    }

    return 'ID is not an image attachment.';
  }

  /**
   * Callback for [aios_responsive_image] shortcode to get each image link
   *
   * @param int $id - image ID
   * @param array $sizes - list of custom sizes
   *
   * @param $viewport
   * @return string
   * @since 4.5.6
   */
  private function aios_responsive_image_srcs($id, array $sizes, $viewport)
  {
    $arr = [];
    $count = 0;

    foreach ($sizes as $size) {
      $image_src = wp_get_attachment_image_src($id, $size);
      $arr[] = '<source srcset="'. $image_src[0] . '" media="(max-width: '. $viewport[$count] .'px)">';
      $count++;
    }

    return implode($arr);
  }

  /**
   * Callback for [aios_responsive_image] shortcode to get Alt value
   *
   * @since 4.5.6
   * @param int $id - image ID
   *
   * @return string
   */
  private function aios_responsive_image_alt($id)
  {
    return trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true)));
  }

  /**
   * Display Custom Banner
   *
   * @since 5.1.8
   * @param array $atts
   * @param string $content
   * @return string
   */
  public function aios_custom_banner_render($atts = [], $content = "")
  {
    $atts = shortcode_atts([
      'title-not-found' => false,
      'title-search' => false,
    ], $atts, 'aios_custom_banner');

    $banner_image_default_id = get_option( 'aios-metaboxes-default-banner-image', '' );
    $banner_image_size = get_option( 'aios-metaboxes-default-banner-size', 'full' );
    $banner_image_alt = get_post_meta( $banner_image_default_id, '_wp_attachment_image_alt', true);
    $banner_image_title = get_the_title($banner_image_default_id);

    $title = '';
    $sub_title = '';
    $banner_image= '';
    $post_type = '';
    $post_id = '';
    $banner_alternative_text = '';
    $banner_title = '';

    if (! is_null(get_queried_object()->post_type)) {

      $post_type = get_queried_object()->post_type;
      $post_id = get_queried_object()->ID;
      $banner_image = '';

      $aios_metaboxes_featured_banner_image = get_option('aios-metaboxes-featured-banner-image', []) ?: [];

      $isCustomTitle = (int) get_post_meta($post_id, 'aioscm_used_custom_title', true);
      $imgId = get_post_meta($post_id, 'aioscm_banner', true);

      $title = $isCustomTitle === 1 ? get_post_meta($post_id, 'aioscm_main_title', true) : get_the_title($post_id);
      $sub_title = $isCustomTitle === 1 ? get_post_meta($post_id, 'aioscm_sub_title', true) : '';
      $featured_image = get_the_post_thumbnail_url($post_id, 'full');

      if(in_array($post_type, $aios_metaboxes_featured_banner_image) && !empty($featured_image) ){
        $banner_image = get_the_post_thumbnail_url($post_id, 'full');
      }else{
        $banner_image = wp_get_attachment_image_url((! empty($imgId) ? $imgId : $banner_image_default_id), $banner_image_size);
      }
      
      $bannerAlt = get_post_meta($post_id, 'aioscm_banner_alternative_text', true);
      $bannerTitle = get_post_meta($post_id, 'aioscm_banner_title', true);

      $banner_alternative_text =  !empty($bannerAlt) ? $bannerAlt : $banner_image_alt;
      $banner_title =  !empty($bannerTitle ) ? $bannerTitle  : $banner_image_title;


    } elseif (! is_null(get_queried_object()->taxonomy)) {
      $taxonomy_meta = get_option('term_meta_' . get_queried_object()->term_id);

      $title = $taxonomy_meta['used_custom_title'] === 1 ? $taxonomy_meta['main_title'] : get_queried_object()->name;
      $sub_title = $taxonomy_meta['used_custom_title'] === 1 ? $taxonomy_meta['sub_title'] : '';
      $banner_image = wp_get_attachment_image_url((! empty($taxonomy_meta['banner']) ? $taxonomy_meta['banner'] : $banner_image_default_id), $banner_image_size);

      $post_type = get_queried_object()->name;
      $post_id = get_queried_object()->term_id;

      $bannerAlt = $taxonomy_meta['aioscm_banner_alternative_text'];
      $bannerTitle = $taxonomy_meta['aioscm_banner_title'];

      $banner_alternative_text =  !empty($bannerAlt) ? $bannerAlt : $banner_image_alt;
      $banner_title =  !empty($bannerTitle ) ? $bannerTitle  : $banner_image_title;

    } elseif (is_archive()) {
      $banner_image= wp_get_attachment_image_url($banner_image_default_id, $banner_image_size);
      $post_type = get_queried_object()->name;
      $post_id = get_queried_object()->name;
    } elseif (is_404()) {
      $banner_image= wp_get_attachment_image_url($banner_image_default_id, $banner_image_size);
      $post_type = '404-not-found';
      $post_id = '404-not-found';

      if ($atts['title-not-found']) {
        $title = "Not Found";
      }
    } elseif (is_search()) {
      $banner_image= wp_get_attachment_image_url($banner_image_default_id, $banner_image_size);
      $post_type = 'search';
      $post_id = 'search';

      if ($atts['title-search']) {
        $title = "Search";
      }
    }

    $content = strtr(html_entity_decode($content), [
      '[title]' => $title,
      '[sub_title]' => $sub_title,
      '[banner_image]' => $banner_image,
      '[post_type]' => $post_type,
      '[post_id]' => $post_id,
      '[banner_alternative_text]' => $banner_alternative_text,
      '[banner_title]' => $banner_title,
    ]);

    return strip_shortcodes(do_shortcode($content));
  }

	/**
	 * Display current Year
	 *
	 * @return string
	 */
	public function date_year () {
		return date_i18n ('Y');
	}

	/**
	 * Display current Month
	 *
	 * @return string
	 */
	public function date_month () {
		return date_i18n ('F');
	}

	/**
	 * Display current date as YYYY-MM-DD
	 *
	 * @since 5.8.0
	 * @return string
	 */
	public function date_yyyymmdd () {
		return date_i18n ('y-m-d');
	}

	/**
	 * Display current month and year
	 *
	 * @since 5.8.0
	 * @return string
	 */
	public function date_monthyear () {
		return date_i18n ('F Y');
	}

	/**
	 * Display current day
	 *
	 * @since 5.8.0
	 * @return string
	 */
	public function date_day () {
		return date_i18n ('l');
	}

  /**
   * This will output image src or html base on attachment id
   *
   * @param $atts
   * @return string
   * @since 6.7.8
   *
   */
  public function aios_image_render($atts)
  {
    // atts
    $atts = shortcode_atts([
      'id'          => '', // attachment ID
      'return'      => 'html', // return type: html | src
      'alt'         => '', // image custom alt, returns image alt
      'element'     => 'img', // shortcode element: img | div | canvas
      'width'       => '', // image width
      'height'      => '', // image height
      'class'       => '', // element class, separated by space
      'lazyload'    => 'true', // image lazyload
      'placeholder' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=', // placeholder image for lazyload
    ], $atts, 'aios_image');

    // extract shortcode attributes
    extract( $atts );

    // check id
    if ( empty( $id ) ) return '[aios_image]: `id` attribute is required.';

    // check return type
    if ( !in_array( $return, [ 'html', 'src' ] ) ) return '[aios_image]: `return` attribute is required and value must be valid. [html, src]';

    // check element type
    if ( $return == 'html' && !in_array( $element, [ 'img', 'div', 'canvas' ] ) ) return '[aios_image]: `element` attribute value must be valid. [img, div, canvas]';

    // checks if lazyload is enabled
    if ( $return == 'html' && $lazyload == 'true' ) {
      $element = "lazy_$element";
      $class = trim( $class ) . ' aios-lazyload';

      // checks if vanilla lazyload is enqueue/loaded
      if ( !wp_script_is( 'aios-lazy-load' ) ) return '[aios_image]: please enable vanilla lazyload library on <a href="' . admin_url( 'admin.php?page=aios-initial-setup&panel=enqueue-libraries' ) . '" target="_blank" style="text-decoration: underline;">AIOS Initial Setup</a>';
    }

    // image data
    $image_data = wp_get_attachment_image_src( $id, 'full' );

    // dimensions (width & height)
    $width = $width ?: $image_data[ 1 ];
    $height = $height ?: $image_data[ 2 ];
    $dimension = "width=\"{$width}\" height=\"{$height}\"";

    // alt (gets image alt as a default if set empty)
    if ( empty( $alt ) ) $alt = get_post_meta( $id, '_wp_attachment_image_alt', TRUE );

    // class
    if ( !empty( $class ) ) $class = "class=\"{$class}\"";

    // responses
    $responses = [
      // non lazyload
      'src'         => $image_data[ 0 ],
      'img'         => "<img src=\"{$image_data[ 0 ]}\" {$dimension} alt=\"{$alt}\" {$class}>",
      'div'         => "<div style=\"background-image: url('{$image_data[ 0 ]}')\" {$class}></div>", 
      'canvas'      => "<canvas style=\"background-image: url('{$image_data[ 0 ]}')\" {$class} {$dimension}></canvas>",

      // lazyload
      'lazy_img'    => "<img src=\"{$placeholder}\" data-aios-lazy-src=\"{$image_data[0]}\" {$dimension} alt=\"{$alt}\" {$class}>",
      'lazy_div'    => "<div data-aios-lazy-bg=\"{$image_data[0]}\" {$class}></div>",
      'lazy_canvas' => "<canvas data-aios-lazy-bg=\"{$image_data[0]}\" {$class} {$dimension}></canvas>", 
    ];

    // return response base on return type
    return do_shortcode( $responses[ $return == 'html' ? $element : $return ] );
  }
}

new ShortcodeController();
