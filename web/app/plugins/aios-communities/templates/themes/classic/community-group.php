<?php

    use AIOS\Communities\Controllers\Options;

    get_header();

    $params = $_GET;
    extract($params);

    $communities_settings 		= Options::options();
    if( !empty( $communities_settings ) ) extract( $communities_settings );
    $show_overlay = ($show_overlay == true ? 'aios-communities-show-overlay' : '' );
    $text_shadow = ($text_shadow == true ? 'aios-communities-has-text-shadow' : '' );

    $taxonomy = 'community-group';
    $number   = $post_per_page;


    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    $offset       = ( $paged > 0 ) ?  $number * ( $paged - 1 ) : 1;
    $totalterms   = wp_count_terms( $taxonomy, array( 'hide_empty' => false, 'search' => $address  ) ); 
    $totalpages   = ceil( $totalterms / $number );

    $order_set = is_null($sort) ? $order_by : 'name';


    $args = array(
        'hide_empty'    => false,
        'number'        => $number, 
        'offset'        => $offset, 
        'search'        => $address,
        'orderby'       => $order_set,
        'order'         => is_null($sort) ? 'ASC' : $sort,
    );

    $community_query = get_terms( $taxonomy, $args );
    $community_total_posts = $community_query->post_count;
?>

<!-- BEGIN: Classic Communities -->
<div class="ai-classic-communities">
  <!-- BEGIN: Heading -->
  <div class="container">
    <div class="ai-classic-communities-heading" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
      <!-- BEGIN: Row -->
      <div class="ai-classic-communities-heading-row">
        <!-- BEGIN: Entry Title -->
        <div class="ai-classic-communities-title ai-classic-communities-heading-col">

        <div id="content">
            <?php do_action('aios_starter_theme_before_inner_page_content') ?>
            <?php

                $aios_metaboxes_banner_title_layout = get_option('aios-metaboxes-banner-title-layout', '');
                if ( !is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {
                    $aioscm_used_custom_title   = get_post_meta(get_the_ID(), 'aioscm_used_custom_title', true);
                    $aioscm_main_title          = get_post_meta(get_the_ID(), 'aioscm_main_title', true);
                    $aioscm_sub_title           = get_post_meta(get_the_ID(), 'aioscm_sub_title', true);
                    $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                    echo '<h1 class="archive-title">' . $aioscm_title . '</h1>';
                }

                the_content();
            ?>
            <?php do_action('aios_starter_theme_after_inner_page_content') ?>

            </div>

        </div>
        <!-- BEGIN: Entry Title -->
      </div>
      <!-- END: Row -->
      <!-- BEGIN: Row -->
      <div class="ai-classic-communities-heading-row ai-classic-communities-search">
        <!-- BEGIN: Search -->
        <form class="ai-classic-communities-search-input ai-classic-communities-heading-col" method="get">
          <label for="address">Search:</label>
          <input type="text" id="address" name="address" placeholder="Type here ...">
          <button type="submit" class="ai-font-magnifying-glass-f ai-classic-seach">Submit</button>  
          <input type="hidden" name="sort">
        </form>
        <!-- BEGIN: Search -->
        <!-- BEGIN: Sort -->
        <div class="ai-classic-communities-sortby ai-classic-communities-heading-col">
          <span>Sort by</span>
          <div class="ai-classic-communities-sortby-button-wrap">
            <select name="sort" id="sort">
                <option value="ASC" <?= $sort == 'ASC' ? 'selected' : '' ?>>A-Z</option>
                <option value="DESC"  <?= $sort == 'DESC' ? 'selected' : '' ?>>Z-A</option>
            </select>
          </div>
        </div>
        <!-- BEGIN: Sort -->
      </div>
      <!-- END: Row -->
    </div>
  </div>
  <!-- END: Heading -->
  <!-- BEGIN: Listings -->
  <div class="ai-classic-communities-listings">
    <div class="ai-classic-communities-listings-row">


        <?php

            if(!empty($community_query)){
                foreach($community_query as $term){
                    $term_id                    = $term->term_id;
                    $term_name                  = $term->name;
                    $term_permalink             = get_term_link(  $term_id );
                    $taxonomy_meta              = get_option( "term_meta_" . $term_id );

                    $banner                     =   wp_get_attachment_url($taxonomy_meta['banner']);

                    $banner_image = '';

                    if(!empty( $taxonomy_meta['banner'])){
                        $banner_image .= '<img src="'.$banner.'" alt="'.$term_name.'">';
                    }else{
                        $banner_image .= !empty($default_photo) ? '<img src="'.$default_photo.'" alt="'.$term_name.'">': '';
                    }


                    echo ' <!-- BEGIN: Listing -->
                    <div class="ai-classic-communities-listing" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
                    <!-- BEGIN: Content -->
                    <div class="ai-classic-communities-content '.$show_overlay.' '.$text_shadow.'">
                        <!-- BEGIN: Image -->
                        <div class="ai-classic-communities-content-img">
                            <a href="'.$term_permalink.'">
                                <canvas width="785" height="394"></canvas>
                                '.$banner_image.'           
                            </a>
                        </div>
                        <!-- END: Image -->
                        <!-- BEGIN: Content Grid -->
                        <div class="ai-classic-communities-content-grid">
                        <div class="ai-classic-communities-content-grid-price">
                        '.$term_name.'
                        </div>
                        </div>
                        <a href="'.$term_permalink.'" class="ai-classic-communities-content-grid-link">'.$term_name.'</a>
                        <!-- END: Content Grid -->
                    </div>
                    <!-- END: Content -->
                    </div>
                    <!-- END: Listing -->';
                }

            }else{
                echo '<div class="aios-no-communities-found"> <p>No Community Group Was Found.</p></div>';
            }

        ?>

    </div>
  </div>
  <!-- END: Listings -->
  <!-- BEGIN: Pagination -->
  <div class="ai-classic-communities-pagination" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
        <div class="page-links">

           <?php
                $big = 999999999; // need an unlikely integer
                echo paginate_links( array(
                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format' => '?paged=%#%',
                    'current' => max( 1, $paged ),
                    'total'         => $totalpages,
                ) );
            ?>

        </div>
  </div>
  <!-- END: Pagination -->
</div>
<!-- END: Classic Properties -->
<?php
    get_footer();
?>
