<?php get_header(); ?>
<div id="<?php echo ai_starter_theme_get_content_id('content-sidebar') ?>">
	<article id="content" class="hfeed">

		<div class="singlePost">
			<?php do_action('aios_starter_theme_before_inner_page_content') ?>
			
			<?php get_template_part("templates/partials/content","post") ?>
			
			<?php do_action('aios_starter_theme_after_inner_page_content') ?>
		</div>
		
    </article><!-- end #content -->
    
    <?php get_sidebar(); ?>	
</div><!-- end #content-sidebar -->

<?php get_footer(); ?>
