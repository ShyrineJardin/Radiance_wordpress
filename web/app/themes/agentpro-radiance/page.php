<?php get_header(); ?>
<div id="<?php echo ai_starter_theme_get_content_id('content-sidebar') ?>">
	<article id="content" class="hfeed">
		
		<?php do_action('aios_starter_theme_before_inner_page_content') ?>
		
		<?php get_template_part("templates/partials/content","page") ?>
		
		<?php do_action('aios_starter_theme_after_inner_page_content') ?>
		
    </article><!-- end #content -->
    
    <?php get_sidebar(); ?>	
</div><!-- end #content-sidebar -->

<?php get_footer(); ?>
