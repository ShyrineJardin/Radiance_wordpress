<?php if(have_posts()) : ?>

<?php while(have_posts()) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class( 'singlePost__main' ); ?>>
		<?php do_action('aios_starter_theme_before_entry_content') ?>

		<?php
			$aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );
			if ( ! is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {
				$aioscm_used_custom_title   = get_post_meta( get_the_ID(), 'aioscm_used_custom_title', true );
				$aioscm_main_title          = get_post_meta( get_the_ID(), 'aioscm_main_title', true );
				$aioscm_sub_title           = get_post_meta( get_the_ID(), 'aioscm_sub_title', true );
				$aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
				echo '<h1 class="no-margin entry-title ' . ($aioscm_used_custom_title == 1 ? 'entry-custom-title' : '') . '">' . $aioscm_title . '</h1>';
			} else {
				echo '<h3 class="no-margin">' . get_the_title() . '</h3>';
			}
		?>

		<?php if ( has_post_thumbnail() ): ?>
			<div class="singlePost__image">
				<canvas width="838" height="540" class="aios-lazyload" data-aios-lazy-bg="<?= wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), 'full' ) ?>"></canvas>
			</div>
		<?php endif; ?>

		<div class="entry entry-content singlePost__content">
			<?php the_content(); ?>

			

			<div class="singlePost__sharer">

				<?php 
					/** Sharer: Start */
					$sharerHtml = '';

					$actualLink = get_the_permalink(get_the_ID());
					$smiList = array(
						array(
							'link'  => '//www.facebook.com/sharer.php?u=' . $actualLink,
							'name'  => 'facebook',
							'icon'  => '
								<svg xmlns="http://www.w3.org/2000/svg" width="43" height="43" viewBox="0 0 43 43" fill="none">
									<path d="M23 22.2086H25.5L26.5 18.2086H23V16.2086C23 15.1792 23 14.2086 25 14.2086H26.5V10.8487C26.1743 10.8055 24.943 10.7086 23.6429 10.7086C20.9284 10.7086 19 12.3655 19 15.4083V18.2086H16V22.2086H19V30.7086H23V22.2086Z" fill="white"/>
								</svg>
							',
						),
						array(
							'link'  => '//www.linkedin.com/sharing/share-offsite/?url=' . $actualLink,
							'name'  => 'linkedin',
							'icon'  => '
								<svg xmlns="http://www.w3.org/2000/svg" width="43" height="43" viewBox="0 0 43 43" fill="none">
									<path d="M18.0479 15.2643C18.0479 16.09 17.5063 16.8014 16.5239 16.8014C15.5975 16.8014 15 16.13 15 15.3043C15 14.4572 15.5793 13.7086 16.5239 13.7086C17.4685 13.7086 18.0297 14.4157 18.0479 15.2643ZM15 27.7083V17.5971H18.0479V27.7083H15Z" fill="white"/>
									<path d="M19.5261 21.0518C19.5261 19.8504 19.4869 18.8461 19.4478 17.979H22.1863L22.3221 19.319H22.3795C22.7657 18.6876 23.7103 17.7633 25.2916 17.7633C27.2213 17.7633 28.6683 19.0818 28.6683 21.9175V27.7059H25.6204V22.3703C25.6204 21.1304 25.1586 20.1847 24.0965 20.1847C23.2877 20.1847 22.8818 20.8532 22.6691 21.4047C22.5908 21.6018 22.5726 21.8775 22.5726 22.1532V27.7059H19.5261V21.0518Z" fill="white"/>
								</svg>
							',
						),
						array(
							'link'  => '//twitter.com/intent/tweet?url=' . $actualLink,
							'name'  => 'twitter',
							'icon'  => '
								<svg xmlns="http://www.w3.org/2000/svg" width="43" height="43" viewBox="0 0 43 43" fill="none">
									<path d="M13.0429 11.7086L19.8409 21.6367L13 29.7086H14.5396L20.5288 22.6415L25.3679 29.7086H30.6072L23.4268 19.2221L29.7942 11.7086H28.2546L22.7389 18.2173L18.2823 11.7086H13.0429ZM15.307 12.9473H17.714L28.3428 28.4697H25.9358L15.307 12.9473Z" fill="white"/>
								</svg>
							',
						),
						array(
							'link'  => 'mailto:?subject=' . $fullAddress . '&body=Hey! Check out that URL: %0D%0A' . $actualLink,
							'name'  => 'mailto',
							'icon'  => '
								<svg xmlns="http://www.w3.org/2000/svg" width="43" height="43" viewBox="0 0 43 43" fill="none">
									<g opacity="0.999">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M13.5018 15.0201C18.8395 15.0175 24.1772 15.0201 29.5149 15.028C29.6842 15.0709 29.84 15.1389 29.9824 15.2319C30.0228 15.2633 30.0368 15.3025 30.0241 15.3495C29.9373 15.4363 29.8455 15.5174 29.7486 15.5926C27.0461 17.7482 24.3466 19.9075 21.6503 22.0705C21.57 22.1351 21.4865 22.1404 21.3998 22.0862C18.6336 19.8746 15.8673 17.6631 13.1011 15.4515C13.0527 15.4139 13.0137 15.3695 12.9842 15.3182C13.0397 15.2238 13.1231 15.1584 13.2347 15.1221C13.3273 15.0915 13.4163 15.0575 13.5018 15.0201Z" fill="white"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M12.5334 16.1808C12.5992 16.183 12.6548 16.2065 12.7004 16.2514C14.6484 17.8304 16.5965 19.4093 18.5445 20.9883C18.5827 21.0207 18.6105 21.0599 18.628 21.1059C18.5985 21.1572 18.5596 21.2016 18.5111 21.2392C16.5971 22.7495 14.6881 24.2658 12.7839 25.7879C12.7166 25.8403 12.6442 25.8848 12.5668 25.9212C12.5288 25.9168 12.5093 25.8958 12.5084 25.8584C12.4972 22.6535 12.4972 19.4485 12.5084 16.2436C12.5152 16.2216 12.5235 16.2007 12.5334 16.1808Z" fill="white"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M30.3999 16.1808C30.4277 16.1808 30.4555 16.1808 30.4833 16.1808C30.5056 19.4224 30.5056 22.6639 30.4833 25.9055C30.4494 25.908 30.4161 25.9054 30.3832 25.8976C28.4023 24.3351 26.4265 22.7666 24.4555 21.1922C24.4121 21.1558 24.3982 21.1114 24.4138 21.0589C26.4024 19.4233 28.3978 17.7973 30.3999 16.1808Z" fill="white"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M19.2124 21.6706C19.265 21.666 19.3151 21.6739 19.3627 21.6941C20.0535 22.2646 20.7493 22.8293 21.4499 23.3881C21.5159 23.4024 21.5771 23.3919 21.6336 23.3567C22.2928 22.8093 22.9551 22.2655 23.6206 21.7255C23.6799 21.6697 23.7466 21.6592 23.821 21.6941C25.888 23.3378 27.9501 24.9873 30.0075 26.6427C30.0292 26.6719 30.0347 26.7033 30.0241 26.7368C29.9425 26.8184 29.8451 26.8785 29.7319 26.9172C29.6144 26.946 29.4975 26.9774 29.3813 27.0113C24.1327 27.0218 18.884 27.0218 13.6354 27.0113C13.432 26.9766 13.2428 26.9087 13.0677 26.8074C12.957 26.7253 12.9625 26.6469 13.0844 26.5721C15.1254 24.9345 17.168 23.3007 19.2124 21.6706Z" fill="white"/>
									</g>
								</svg>
							',
						),
					);
					foreach ( $smiList as $item ) {
						$sharerHtml .= '
							<li>
								<a href="' . $item[ 'link' ] . '" class="as-' . $item[ 'name' ] . '" data-title="' . $fullAddress . '" aria-label="' . $item[ 'name' ] . '" data-sharer>
									' . $item[ 'icon' ] . '
								</a>
							</li>
						';
					}
					$sharerHtml = '
						<strong>Share</strong>
						<ul>
							' . $sharerHtml . '
						</ul>
					';
					/** Sharer: End */

					echo $sharerHtml;
				?>

			</div>

		</div>

		<?php do_action('aios_starter_theme_after_entry_content') ?>
	</div>


<?php endwhile; ?>

<?php endif; ?>

