<div id="aios-mobile-header-wrapper-<?php echo $instance_id ?>" class="<?=$args['widget_id']?> aios-mobile-header-wrapper <?php echo "aios-mobile-header-wrapper-breakpoint-" . $breakpoint ?>">

	<div class="amh-fixed-header-nav amh-area-wrap">
		<div class="amh-header-buttons amh-1a amh-clearfix">

			<div class="amh-navigation-trigger"><div class="ai-font-menu"></div></div>
			<div class="amh-center">
                <?php if ( !$phone_hide ) : ?>
					<a href="tel:<?php echo do_shortcode( $phone_href ) ?>" class="amh-phone"><div class="amh-phone-text"><?php echo do_shortcode( $phone ) ?></div></a>
				<?php endif ?>
			</div>

			<div class="amh-header-right-btn">
				<?php if ( !$email_hide ) : ?>
					<?php if ( !shortcode_exists('mail_to') ) : ?>
						<a class="amh-email" href="mailto:<?php echo do_shortcode( $email )?>"><span class="ai-font-envelope-f"><span class="amh-email-text-hide"><?php echo do_shortcode( $email )?></span></span></a>
					<?php elseif ( shortcode_exists('mail_to') ) : ?>
						<?php echo do_shortcode( '[mail_to email="' . do_shortcode($email) . '"]
						<span class="amh-email"><span class="ai-font-envelope-f"><span class="amh-email-text-hide">' . do_shortcode($email) . '</span></span></span>
						[/mail_to]' ) ?>
					<?php endif ?>
				<?php endif ?>
			</div>


		</div><!-- end of buttons -->

		<div class="amh-navigation amh-nav-1">
			<?php
				/** Optima Slug **/
				$optima_slug = 'optima-express';

				/** Set Primary Menu if Optima is selected **/
				$d_menu_name 	= 'primary-menu';
				$d_locations 	= get_nav_menu_locations();
				$d_menu_id 		= $d_locations[ $d_menu_name ];

				/** Get selected menu **/
				$selected_menu 	= wp_get_nav_menu_object( $menu_id );
				if ( $selected_menu->slug == $optima_slug ) {
					$menu_id = $d_menu_id;
				}

				wp_nav_menu( array(
					'menu'=>$menu_id,
					'menu_id'=>('amh-menu' . $instance_id),
					'menu_class'=>'amh-menu',
					'walker'=>new \AiosInitialSetup\App\Widgets\MobileHeader\Models\Menu()
				));

			?>
		</div><!-- end of navigation -->

	</div><!-- end of fixed header and anv -->

	<!-- SCRIPTS -->

	<script>

		jQuery(document).ready( function() {

			var instanceId = 'aios-mobile-header-wrapper-<?php echo $instance_id ?>';
			var header = jQuery("#" + instanceId);
			var trigger = header.find(".amh-navigation-trigger");
			var nav = header.find(".amh-navigation");
			var position = '<?php echo $behavior == '' ? 'bottom' : $behavior ?>';

			nav.aiosMobileHeaderNavigation({
				trigger: trigger,
				attachment: header,
				position: position
			});

			header.find(".amh-fixed-header-nav").aiosMobileHeader();

		});

	</script>

	<!-- END SCRIPTS -->


</div><!-- end of ampl wrapper -->
