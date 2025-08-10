<div id="aios-mobile-header-wrapper-<?php echo $instance_id ?>" class="<?= $args['widget_id'] ?> aios-mobile-header-wrapper <?php echo "aios-mobile-header-wrapper-breakpoint-" . $breakpoint ?>">

	<div class="amh-fixed-header-nav amh-area-wrap">
		<div class="amh-header-buttons amh-2b amh-clearfix">

			<div class="amh-navigation-trigger"><span>Menu</span></div>

			<div class="amh-header-right-btn <?= !empty($phone2) ? 'amh-dual-phone' : ''?> ">
				<?php if (!$phone_hide) : ?>
					<a href="tel:<?php echo do_shortcode($phone_href) ?>" class="amh-phone"><?php echo do_shortcode($phone) ?></a>
				<?php endif ?>

				<?php if (!empty($phone2)) : ?>
					<a href="tel:<?php echo do_shortcode($phone2) ?>" class="amh-phone amh-phone-secondary">
						<?php echo do_shortcode($phone2) ?>
					</a>
				<?php endif ?>

			</div>


		</div><!-- end of buttons -->

		<div class="amh-navigation amh-nav-1">
			<?php

			wp_nav_menu(array(
				'menu' => $menu_id,
				'menu_id' => ('amh-menu' . $instance_id),
				'menu_class' => 'amh-menu',
				'walker' => new \AiosInitialSetup\App\Widgets\MobileHeader\Models\Menu()
			));

			?>
		</div><!-- end of navigation -->

	</div><!-- end of fixed header and anv -->

	<!-- SCRIPTS -->

	<script>
		jQuery(document).ready(function() {

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