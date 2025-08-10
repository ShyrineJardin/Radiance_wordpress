<?php get_header();

    use AIOS\Communities\Controllers\Options;

    $communities_settings  = Options::options();
    if (!empty($communities_settings)) extract($communities_settings);

    $post_id    = get_the_ID();

    $aios_cta_title             =  get_post_meta($post_id, 'cta_title', true);
    $aios_cta_link              =  get_post_meta($post_id, 'cta_link', true);
    $aios_cta_new_tab           =  get_post_meta($post_id, 'cta_new_tab', true);
    $aios_display_cta           =  get_post_meta($post_id, 'display_cta', true);
    $aios_display_cta           =  get_post_meta($post_id, 'display_cta', true);
    $aios_communities_shortcode = get_post_meta($post_id, 'aios_communities_shortcode', true);
?>

<div id="<?php echo ai_starter_theme_get_content_id('content-full') ?>">
    <article id="content" class="hfeed community-container">

        <?php do_action('aios_starter_theme_before_inner_page_content') ?>

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php do_action('aios_starter_theme_before_entry_content') ?>
                    
                    <div class="entry entry-content">
                        <?php if ($remove_featured_image != 'true') : ?>
                            <div class="community-featured-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <canvas width="1270" height="408"></canvas>
                                    <?= get_the_post_thumbnail(null, 'full'); ?>
                                <?php endif; ?>
                                <?php 
                                    $image_url = get_the_post_thumbnail_url( $post_id, 'full' ) ?? '';
                                    $video_url = get_post_meta($post_id, 'aios_communities_video_url', true) ?? '';

                                    if (! empty($video_url)) {
                                        echo "<video id=\"cfa-player\" preload=\"none\" poster=\"$image_url\" muted playsinline autoplay loop>
                                            <source src=\"$video_url\" type=\"video/mp4\" />
                                        </video>
                                        <div class=\"community-featured-actions\">
                                            <button type=\"button\" class=\"cfa-playbtn\">
                                                <span>Play</span>
                                                <em class=\"ai-font-play-button-a\"></em>
                                            </button>
                                            <button type=\"button\" class=\"cfa-pausebtn\">
                                                <span>Pause</span>
                                                <em class=\"ai-font-pause-button-a\"></em>
                                            </button>
                                            <button type=\"button\" class=\"cfa-mutedbtn\">
                                                <span>Muted</span>
                                                <em class=\"ai-font-mute\"></em>
                                            </button>
                                            <button type=\"button\" class=\"cfa-volumebtn\">
                                                <span>Volume</span>
                                                <em class=\"ai-font-volume-a\"></em>
                                            </button>
                                        </div>";
                                    }
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="community-title">
                            <?php
                                $aios_metaboxes_banner_title_layout = get_option('aios-metaboxes-banner-title-layout', '');
                                
                                if ( !is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {
                                    $aioscm_used_custom_title   = get_post_meta( get_the_ID(), 'aioscm_used_custom_title', true );
                                    $aioscm_main_title          = get_post_meta( get_the_ID(), 'aioscm_main_title', true );
                                    $aioscm_sub_title           = get_post_meta( get_the_ID(), 'aioscm_sub_title', true );
                                    $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                                    echo '<h1 class="entry-title">' . $aioscm_title . '</h1>';
                                } else {
                                    echo '<h2 class="heading-1">' . get_the_title() . '</h2>';
                                }
                            ?>
                        </div>
                        
                        <div class="community-content">
                            <?php the_content(); ?>
                        </div>

                        <?php if (!empty($aios_display_cta)) : ?>
                            <div class="community-cta">
                                <div class="siteButton siteButton--mobileFull">
                                    <a href="<?= $aios_cta_link ? $aios_cta_link : '#aios-communities-scroll-to' ?>" <?= !empty($aios_cta_new_tab) ? 'target="_blank"' : '' ?> <?= $aios_cta_link ? '' : 'class="aios-communities-scroll-to"' ?> > <?= $aios_cta_title ? $aios_cta_title : 'View Available Listings' ?></a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($aios_communities_shortcode)) : ?>
                            <div class="community-properties" id="aios-communities-scroll-to">
                                <?=do_shortcode( $aios_communities_shortcode )?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php do_action('aios_starter_theme_after_entry_content') ?>

                </div>

            <?php endwhile; ?>

        <?php endif; ?>

        <?php do_action('aios_starter_theme_after_inner_page_content') ?>

    </article><!-- end #content -->

</div><!-- end #content-full -->


<?php get_footer(); ?>