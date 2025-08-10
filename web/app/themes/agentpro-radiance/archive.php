<?php get_header(); ?>
<div id="<?php echo ai_starter_theme_get_content_id('content-sidebar') ?>">
	<section id="content" class="hfeed template__archive latestnews flex-column">
		
		<?php do_action('aios_starter_theme_before_inner_page_content') ?>

        <div class="template__archive--title-wrapper latestnews__intro flex-column text-center">
            <?php 
                $post = $posts[0]; // Hack. Set $post so that the_date() works. 
                $aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );
                if ( ! is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {
                    $taxonomy_id        = get_queried_object()->term_id;
                    $taxonomy_name      = get_queried_object()->name;
                    $taxonomy_meta      = get_option( "term_meta_" . $taxonomy_id );

                    if( $taxonomy_meta['used_custom_title'] == 1 ) {
                        echo '<h1 class="heading-1 archive-title archive-custom-title">' . $taxonomy_meta['main_title'] . '<span>' .  $taxonomy_meta['sub_title'] . '</span></h1>';
                    } else {
                        echo '<h1 class="heading-1 archive-title">';
                        ?>
                            <?php /* If this is a category archive */ if (is_category()) { ?>
                            <?php single_cat_title(); ?>
                            <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
                                Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;
                            <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
                                Archive for <?php the_time( get_option( 'date_format' ) ); ?>
                            <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
                                Archive for <?php the_time( get_option( 'date_format' ) ); ?>
                            <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
                                Archive for <?php the_time( get_option( 'date_format' ) ); ?>
                            <?php /* If this is an author archive */ } elseif (is_author()) { ?>
                                Author Archive
                            <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
                                Blog Archives
                            <?php }
                        echo '</h1>';
                    }
                } 
                
                the_archive_description();
            ?>
        </div>
        
        <?php echo do_shortcode('[aios_wp_search_form]') ?>

		<?php get_template_part('templates/partials/loop','archive') ?>
		
		<?php do_action('aios_starter_theme_after_inner_page_content') ?>
		
    </section><!-- end #content -->

<?php get_sidebar(); ?>	
</div><!-- end #content-sidebar -->

<?php get_footer(); ?>