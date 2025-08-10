<?php 
    /*
    * Template Name: Contact
    */

get_header();?>

<div id="ip-radiance-contact" class="ip-radiance-contact">
    <div id="content-full">
        <article id="content" class="hfeed contact-hfeed">

            <?php do_action('aios_starter_theme_before_inner_page_content') ?>

            <?php if(have_posts()) : ?>

                <?php while(have_posts()) : the_post(); ?>

                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

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

                        <?php do_action('aios_starter_theme_before_entry_content') ?>

                        <div class="entry entry-content contact-entry-content">
                                                  
                            <!-- contact template -->
                            <section class="contact-radiance">
                                <div class="contact-radiance__container site__container">
                                    <div class="contact-radiance__wrapper">
                                        <div class="contact-radiance__content">
                                            <div class="contact-radiance__header">
                                                <h2 class="title-contact">Contact us</h2>
                                                <h3 class="sub-contact">GOT ANY QUESTIONS? <span class="text-break"> GET IN TOUCH</span></h3>
                                            </div>

                                            
                                            <span class="form-title">Fill out the form below and I will get to you.</span>
                                            

                                            <div class="contact-radiance__form">
                                                <?= do_shortcode('[contact-form-7 id="" title="Custom Page Form with Newsletter (Auto-generated)"]'); ?>
                                            </div>
                                        </div>

                                        <div class="contact-radiance__image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/wc-photo.jpg" alt="Liam Anderson">
                                        </div>
                                        
                                    </div>
                                </div>
                            </section>
                            <!-- end of contact template -->
                            
                        </div>

                        <?php do_action('aios_starter_theme_after_entry_content') ?>

                    </div>

                <?php endwhile; ?>

            <?php endif; ?>

            <?php do_action('aios_starter_theme_after_inner_page_content') ?>

        </article><!-- end #content -->

    </div><!-- end #content-full -->
</div><!-- end #ip-about -->

<?php get_footer();?>