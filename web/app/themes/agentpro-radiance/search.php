<?php get_header(); ?>
<div id="<?php echo ai_starter_theme_get_content_id('content-sidebar') ?>">
	<section id="content" class="hfeed template__archive latestnews flex-column">
		
		<?php do_action('aios_starter_theme_before_inner_page_content') ?>

        <div class="template__archive--title-wrapper latestnews__intro flex-column text-center">
			<h1 class="archive-title">Search Results for &#8216;<?php printf( get_search_query() ); ?>&#8217;</h1>
        </div>
        
        <?php echo do_shortcode('[aios_wp_search_form]') ?>

		<?php get_template_part('templates/partials/loop','archive') ?>
		
		<?php do_action('aios_starter_theme_after_inner_page_content') ?>
		
    </section><!-- end #content -->

<?php get_sidebar(); ?>	
</div><!-- end #content-sidebar -->

<?php get_footer(); ?>