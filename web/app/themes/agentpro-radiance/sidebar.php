<?php if ( is_active_sidebar('primary-sidebar') ) : ?>

	<aside class="sidebar">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Primary Sidebar') ) : ?><?php endif; ?>
		<div class="clear"></div>
	</aside><!-- end .sidebar -->

<?php endif ?>