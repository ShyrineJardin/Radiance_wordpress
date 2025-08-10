<?php if(have_posts()) : ?>

<div class="template__archive--list latestnews__items">
	<?php while(have_posts()) : the_post(); ?>
			
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'latestnews__item archive-content' . (has_post_thumbnail() ? " archive-has-thumbnail" : "") ); ?>>
			<?php if ( has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>" class="latestnews__item--image inset-on-canvas">
					<canvas width="312" height="192"></canvas>
					<img class="img-responsive inset-full" src="<?= wp_get_attachment_image_url(get_post_thumbnail_id(), 'large') ?>" alt="View Blog">
				</a>
			<?php endif ?>

			<h5><a href="<?php the_permalink(); ?>" class="text-inherit shoter-line-clamp"><?php the_title(); ?></a></h5>
			<p class="default-line-clamp">
				<?php if ( has_excerpt( get_the_ID() ) ) : ?>
					<?php the_excerpt(); ?>
				<?php else: ?>
					<?php echo ai_starter_theme_truncate_string( strip_tags( strip_shortcodes( get_the_content() ) ), 244, "..." ) ?>
				<?php endif ?>
			</p>
			<div class="latestnews__item--cta">
				<a href="<?php the_permalink() ?>" class="button-text archive-more text-inherit">Read More</a>
			</div>
		</article>
		
	<?php endwhile; ?>
</div>

<div class="template__archive--pagination archive__pagination">
	<?php
		echo paginate_links( [
			'prev_text'     => __( '<svg width="8" height="13" viewBox="0 0 8 13" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M7.91 10.7892L3.33 6.19922L7.91 1.60922L6.5 0.199219L0.5 6.19922L6.5 12.1992L7.91 10.7892Z" /></svg>' ),
			'next_text'     => __( '<svg width="8" height="13" viewBox="0 0 8 13" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M0.0900002 10.7892L4.67 6.19922L0.0900002 1.60922L1.5 0.199219L7.5 6.19922L1.5 12.1992L0.0900002 10.7892Z" /></svg>' ),
		] );
	?>
</div>

<?php else: ?>
<p style="text-align: center;">No results found. Please refine your search.</p>
<?php endif ?>