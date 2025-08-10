<?php
    get_header();
    
    $about_options = get_option('about_options', []);
    $contact_options = get_option('contact_options', []);
    $theme_type = "";
    $theme_name = "";

    if (isset($about_options['page_id']) || isset($contact_options['page_id'])) {
        $theme_type = isset($about_options['page_id']) && get_the_ID() === (int) $about_options['page_id'] ? "about" : (
            isset($contact_options['page_id']) && get_the_ID() === (int) $contact_options['page_id'] ? "contact" : ""
        );
        $theme_name = str_replace(['agent-pro-', '-has-js'], ['', ''], get_option("{$theme_type}-theme", ''));
        
        $templateData = [
            'type' => $theme_type,
            'theme' => $theme_name
        ];
    }

    $hideTitle = $theme_name == 'amante-ii' ? 'hide' : '';

?>

<div id="ip-<?=$theme_name?>-<?=$theme_type?>" class="aios-auto-generate-page">
    <div id="<?php echo ai_starter_theme_get_content_id('content-full') ?>">
        <article id="content" class="hfeed about-hfeed">

            <?php do_action('aios_starter_theme_before_inner_page_content') ?>

            <?php if(have_posts()) : ?>
                <?php while(have_posts()) : the_post(); ?>
                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <?php
                            $aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );
                            if ( ! is_custom_field_banner( get_queried_object() ) || (is_array($aios_metaboxes_banner_title_layout) && $aios_metaboxes_banner_title_layout[1] != 1) ) {
                                $aioscm_used_custom_title   = get_post_meta( get_the_ID(), 'aioscm_used_custom_title', true );
                                $aioscm_main_title          = get_post_meta( get_the_ID(), 'aioscm_main_title', true );
                                $aioscm_sub_title           = get_post_meta( get_the_ID(), 'aioscm_sub_title', true );
                                $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                                echo '<h1 class="entry-title '.$hideTitle.'">' . $aioscm_title . '</h1>';
                            } else {
                                echo '<h1 class="entry-title hide">' . get_the_title() . '</h1>';
                            }
                        ?>

                        <?php do_action('aios_starter_theme_before_entry_content') ?>

                        <div class="entry entry-content">
                            <?php the_content(); ?>
                        </div>

                        <?php do_action('aios_starter_theme_after_entry_content') ?>

                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
            <?php do_action('aios_starter_theme_after_inner_page_content') ?>

        </article><!-- end #content -->

        <?php if (wp_get_theme()->template === "agentpro-radiance" && $theme_type === "about"): ?>
            <section class="hp-cta-wrap container-padding">
                <div class="hp-cta-cont max-container">
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("CTA") ) : ?><?php endif ?>	
                </div>
            </section><!-- end of cta -->
        <?php endif; ?>

    </div><!-- end #content-full -->
</div><!-- end #ip-about -->
<?php get_footer(); ?>
