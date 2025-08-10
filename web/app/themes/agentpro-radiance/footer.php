			<?php if ( !is_home() && !is_page_template( 'template-fullwidth.php' ) && !is_page_template( 'template-homepage.php' ) ) : ?>
			<div class="clearfix"></div>
			</div><!-- end of #inner-page-wrapper .inner -->
			</div><!-- end of #inner-page-wrapper -->
		<?php endif ?>
	</main>
	
	<section class="globFooterForm">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer: Form") ) : ?><?php endif ?>
	</section>


	<footer class="footer">
		<div class="footer__container site-container">

			<div class="footer__logo">
				<div class="footer__logo--clientLogo">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer: Logo") ) : ?><?php endif ?>
				</div>
				<div class="footer__logo--brokerageLogo">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer: Brokerage Logo") ) : ?><?php endif ?>
				</div>
			</div><!-- end of logo -->
			<div class="footer__details">
				<div class="footer__details--navigate">
					<h2>NAVIGATE</h2>
					<?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'menu_class' => 'footernav', 'theme_location' => 'primary-menu','depth'=>1 ) ); ?>
				</div><!-- end of nav -->
				<div class="footer__details--contactInfo">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer: Contact Info") ) : ?><?php endif ?>
				</div><!-- end of contact info -->
				<div class="footer__details--company">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer: Company") ) : ?><?php endif ?>		
				</div><!-- end of company -->
				<div class="footer__details--newsletter">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer: Newsletter") ) : ?><?php endif ?>		

					<div class="footer__details--socialMedia">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer: Social Media") ) : ?><?php endif ?>
					</div>

				</div><!-- end of newsletter -->
			</div><!-- end of footer details -->

			<div class="footer__disclaimer">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer: Disclaimer") ) : ?><?php endif ?>

				<div class="footer__disclaimer--copyright">
					<p>Copyright © <?php echo date('Y') ?> | <a href="/privacy-policy/">Privacy Policy</a> | <a href="/sitemap">Sitemap</a> | Real Estate Website Design by Agent Image</p>
				</div>

				<div class="footer__disclaimer--footerLogos">
					<i class="ai-font-eho"></i>
					<i class="ai-font-realtor-mls"></i>
				</div>
			</div>

		</div><!-- end of footer container -->		
	</footer>
		
	</div><!-- end of #main-wrapper -->


	<?php wp_footer(); ?>
</body>
</html> 