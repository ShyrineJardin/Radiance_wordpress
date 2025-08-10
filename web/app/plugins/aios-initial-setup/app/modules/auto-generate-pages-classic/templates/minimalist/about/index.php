<?php get_header(); ?>
    <div id="content">
        <div class="container">
            <?php do_action('aios_starter_theme_before_inner_page_content') ?>
        </div>

        <div class="ai-minimalist-wrapper">

            <?=do_shortcode(get_the_content());?>

            
        </div>
        <div class="container">
            <?php do_action('aios_starter_theme_after_inner_page_content') ?>
        </div>
    </div>
<?php get_footer(); ?>

