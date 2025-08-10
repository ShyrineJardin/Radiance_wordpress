<?php get_header(); ?>
<div id="<?php echo ai_starter_theme_get_content_id('content-sidebar') ?>">
	<div id="content" class="hfeed">
		
		<?php do_action('aios_starter_theme_before_inner_page_content') ?>
		
		<?php if ( !is_front_page() ) : ?>
			<?php get_template_part('templates/partials/loop','archive') ?>
		<?php else : ?>
		
		<?php endif ?>
		
		<?php do_action('aios_starter_theme_after_inner_page_content') ?>
		
	</div><!-- end #content -->

	<?php get_sidebar(); ?>	
</div><!-- end #content-sidebar -->

<?php get_footer(); ?>
