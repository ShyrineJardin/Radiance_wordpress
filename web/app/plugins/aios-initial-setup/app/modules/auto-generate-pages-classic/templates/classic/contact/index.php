<?php get_header(); ?>

    <article id="content" class="hfeed ai-classic-contact">
        <div class="container">
            <?php do_action('aios_starter_theme_before_inner_page_content') ?>
        </div>
        <div id="ai-classic-contact-wrap">
	        <?php
                $aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );
                if ( ! is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {
                    $aioscm_used_custom_title   = get_post_meta( get_the_ID(), 'aioscm_used_custom_title', true );
                    $aioscm_main_title          = get_post_meta( get_the_ID(), 'aioscm_main_title', true );
                    $aioscm_sub_title           = get_post_meta( get_the_ID(), 'aioscm_sub_title', true );
                    $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                    echo '<h1 class="entry-title">' . $aioscm_title . '</h1>';
                }
	        ?>
		    <?=do_shortcode(get_the_content());?>
        </div>
        <div class="container">
            <?php do_action('aios_starter_theme_after_inner_page_content') ?>
        </div>
    </article>

<?php get_footer(); ?>
