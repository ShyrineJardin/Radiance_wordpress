<?php

if (! function_exists('aios_all_widget_results')) {
  /**
   * Display Results
   *
   * @param $posts
   * @param $pbcw_html
   * @param $matches
   * @param $shortcode
   * @return string
   */
  function aios_all_widget_results($posts, $pbcw_html, $matches, $shortcode)
  {
    $html = '';
    $newPosts = '';

    if (! empty($posts) && isset($matches[1])) {
      foreach ($posts as $post) {
        $arrayToReplace = [
          '[post_date_day]' => $post['post_date_day'],
          '[post_date_day_nozero]' => $post['post_date_day_nozero'],
          '[post_date_day_text]' => $post['post_date_day_text'],
          '[post_date_day_text_abbr]' => $post['post_date_day_text_abbr'],
          '[post_date_month]' => $post['post_date_month'],
          '[post_date_month_abbr]' => $post['post_date_month_abbr'],
          '[post_date_month_num]' => $post['post_date_month_num'],
          '[post_date_month_num_nozero]' => $post['post_date_month_num_nozero'],
          '[post_date_year_full]' => $post['post_date_year_full'],
          '[post_date_year_short]' => $post['post_date_year_short'],
          '[featured_img_small]' => $post['featured_img_small'],
          '[featured_img_medium]' => $post['featured_img_medium'],
          '[featured_img_large]' => $post['featured_img_large'],
          '[featured_img_full]' => $post['featured_img_full'],
          '[featured_img_small_url]' => $post['featured_img_small_url'],
          '[featured_img_medium_url]' => $post['featured_img_medium_url'],
          '[featured_img_large_url]' => $post['featured_img_large_url'],
          '[featured_img_full_url]' => $post['featured_img_full_url'],
          '[post_title]' => $post['post_title'],
          '[post_content]' => $post['post_content'],
          '[post_excerpt]' => $post['post_excerpt'],
          '[post_name]' => $post['post_name'],
          '[post_readmore]' => $post['post_readmore'],
          '[permalink]' => $post['permalink'],
          '[post_author]' => $post['post_author'],
          '[image_width]' => $post['image_width'],
          '[image_height]' => $post['image_height']
        ];

        $newPosts .= strtr($matches[1], $arrayToReplace);
      }

      $html = preg_replace('/\[loop_start]([^#]+)\[loop_end]/U', $newPosts, $pbcw_html, 1);
      $html = str_replace('[stylesheet_directory]', get_stylesheet_directory_uri(), $html);
    }

    return $shortcode === 'on' ? strip_shortcodes($html) : do_shortcode($html);
  }
}

if (! function_exists('aios_all_widget_posts_per_cat_type')) {
  /**
   * Filter posts by category and post type
   *
   * @param $category_id
   * @param $post_type
   * @param $orderby
   * @param $order
   * @param $limit
   * @param $pbcw_readmore_length
   * @param $pbcw_readmore_text
   * @param $pbcw_readmore_added
   * @param $pbcw_photoholder
   * @param $pbcw_photoholder_flag
   * @return array
   */
  function aios_all_widget_posts_per_cat_type($category_id, $post_type, $orderby, $order, $limit, $pbcw_readmore_length, $pbcw_readmore_text, $pbcw_readmore_added,$pbcw_photoholder,$pbcw_photoholder_flag) {

    if($post_type === 'All') {
      $all_post_types = get_post_types( '', 'names' );
      $remove_post_type = ['page', 'attachment', 'revision', 'nav_menu_item'];
      $post_type = aios_unset_post_type( $remove_post_type, $all_post_types );
    }

    $pbcw_readmore_length = ! empty($pbcw_readmore_length) ? $pbcw_readmore_length : 55;

    $args = [
      'posts_per_page' => $limit,
      'category' => $category_id,
      'post_type' => $post_type,
      'orderby' => $orderby,
      'order' => $order
    ];

    $all_posts = [];
    $myposts = get_posts($args);

    foreach ($myposts as $post) :
      setup_postdata($post);
      $readmore_text = $pbcw_readmore_text;
      $excerpt_count = str_word_count(strip_tags($post->post_content));

      if ($pbcw_readmore_length >= $excerpt_count) {
        if(empty($pbcw_readmore_added)) {
          $readmore_text = "";
        } else {
          $readmore_text = $pbcw_readmore_text;
        }
      }

      $image = get_the_post_thumbnail($post->ID);

      // If post has featured image
      // Else post has NO featured image
      if (! empty($image)) {
        $image_thumb = get_the_post_thumbnail($post->ID, 'thumbnail');
        $image_med = get_the_post_thumbnail($post->ID, 'medium');
        $image_large = get_the_post_thumbnail($post->ID, 'large');
        $image_full = get_the_post_thumbnail($post->ID, 'full');
        $thumbSrc	= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'thumbnail');
        $medSrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'medium');
        $largeSrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'large');
        $fullSrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full');
        $image_meta = isset($fullSrc) ? wp_get_attachment_metadata(get_post_thumbnail_id( $post->ID ),'full') : '';
        $image_width = isset($image_meta['width']) ? $image_meta['width'] : '';
        $image_height = isset($image_meta['height']) ? $image_meta['height'] : '';
      } else {
        $data = htmlspecialchars($post->post_content);
        $txt = str_replace('&quot;', '#', $data);
        $content_image = "";

        //Get first image in content if available
        if (preg_match_all('/img src=#(.*?)#/', $txt, $match)) {
          foreach($match[1] as $image) {
            $content_image = $image;
            break;
          }
        }

        // If image in content is NOT available
        // Else image in content is available, find its attachment ID
        if (empty($content_image)) {
          // If placeholder image is set to display
          // Else placeholder image is set to hide
          if (empty($pbcw_photoholder_flag)) {
            $image_thumb = "<img src='" . $pbcw_photoholder . "' alt='".$post->post_title."'/>";
            $image_med = "<img src='" . $pbcw_photoholder . "' alt='".$post->post_title."'/>";
            $image_large = "<img src='" . $pbcw_photoholder . "' alt='".$post->post_title."'/>";
            $image_full = "<img src='" . $pbcw_photoholder . "' alt='".$post->post_title."'/>";

            $thumbSrc = $pbcw_photoholder;
            $medSrc = $pbcw_photoholder;
            $largeSrc = $pbcw_photoholder;
            $fullSrc = $pbcw_photoholder;
          } else {
            $image_thumb = '';
            $image_med = '';
            $image_large = '';
            $image_full = '';

            $thumbSrc = '';
            $medSrc = '';
            $largeSrc = '';
            $fullSrc = '';
          }
        } else {
          global $wpdb;
          $content_image = preg_replace('/-\d+[Xx]\d+\./', '.', $content_image);
          $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $content_image ));

          // If it is an attachment
          // Else it is a third-party image
          if (!empty($attachment)) {
            $thumbSrc	= wp_get_attachment_image_src($attachment[0],'thumbnail');
            $medSrc = wp_get_attachment_image_src($attachment[0],'medium');
            $largeSrc = wp_get_attachment_image_src($attachment[0],'large');
            $fullSrc = wp_get_attachment_image_src($attachment[0],'full');

            $image_thumb = "<img src='" . $thumbSrc[0] . "' alt='".$post->post_title."' />";
            $image_med = "<img src='" . $medSrc[0] . "' alt='".$post->post_title."' />";
            $image_large = "<img src='" . $largeSrc[0] . "' alt='".$post->post_title."' />";
            $image_full = "<img src='" . $fullSrc[0] . "' alt='".$post->post_title."' />";
          } else {
            $image_thumb = "<img src='" . $content_image . "' alt='".$post->post_title."'/>";
            $image_med = "<img src='" . $content_image . "' alt='".$post->post_title."'/>";
            $image_large = "<img src='" . $content_image . "' alt='".$post->post_title."'/>";
            $image_full = "<img src='" . $content_image . "' alt='".$post->post_title."'/>";

            $thumbSrc = $content_image;
            $medSrc = $content_image;
            $largeSrc = $content_image;
            $fullSrc = $content_image;
          }
        }
      }

      $excerpt = wp_trim_words( strip_tags($post->post_content), $pbcw_readmore_length, '');
      array_push($all_posts, [
        'post_title' => $post->post_title,
        'post_date' => $post->post_date,
        'post_date_year_full' => date('Y', strtotime($post->post_date)),
        'post_date_year_short' => date('y', strtotime($post->post_date)),
        'post_date_month' => date('F', strtotime($post->post_date)),
        'post_date_month_abbr' => date('M', strtotime($post->post_date)),
        'post_date_month_num' => date('m', strtotime($post->post_date)),
        'post_date_month_num_nozero' => date('n', strtotime($post->post_date)),
        'post_date_day' => date('d', strtotime($post->post_date)),
        'post_date_day_nozero' => date('j', strtotime($post->post_date)),
        'post_date_day_text' => date('l', strtotime($post->post_date)),
        'post_date_day_text_abbr' => date('D', strtotime($post->post_date)),
        'post_content' => $post->post_content,
        'post_excerpt' => $excerpt,
        'post_readmore' => $readmore_text,
        'post_name' => $post->post_name,
        'post_author' => get_the_author_meta( 'nickname', $post->post_author ),
        'permalink' => get_permalink($post->ID),
        'featured_img_small' => $image_thumb,
        'featured_img_medium' => $image_med,
        'featured_img_large' => $image_large,
        'featured_img_full' => $image_full,
        'featured_img_small_url' => $thumbSrc[0] ?? '',
        'featured_img_medium_url' => $medSrc[0] ?? '',
        'featured_img_large_url' => $largeSrc[0] ?? '',
        'featured_img_full_url' => $fullSrc[0] ?? '',
        'image_width' => $image_width,
        'image_height' => $image_height
      ]);
    endforeach;
    wp_reset_postdata();

    return $all_posts;
  }
}

if (! function_exists('aios_unset_post_type')) {
  /**
   * Filter post types to generate on dropdown
   *
   * @param $to_remove
   * @param $post_types
   * @return mixed
   */
  function aios_unset_post_type($to_remove, $post_types) {
    foreach( $to_remove as $post_name ) {
      unset($post_types[$post_name]);
    }

    return $post_types;
  }
}

if (! function_exists('aios_select_country_code')) {
  function aios_select_country_code($name, $id, $value) {
//    $options = [];
//    foreach (constant_country_code() as $k => $v ) {
//      $options[] = '<option value="' . $k . '" ' . selected($k, $value, false) . ' data-subtext="+' . (empty($k) ? '1' : $k) . '">' . ucwords(strtolower($v)) . '</option>';
//    }
//
//    return '<select class="widefat aios-all-widgets-country-code" name="' . $name . '" id="' . $id . '" data-size="10">' . implode('', $options). '</select>';
    return constant_select_element($name, $id, $value);
  }
}
