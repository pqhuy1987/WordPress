<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package murray
 */
?>

	</div><!-- #content -->

	<?php get_sidebar('footer'); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info container">
			<?php printf( __( 'Theme Designed by %1$s.', 'murray' ), '<a href="'.esc_url("http://inkhive.com/").'" rel="designer">InkHive</a>' ); ?>
			<span class="sep"></span>
			<?php echo ( get_theme_mod('murray_footer_text') == '' ) ? sprintf( __( '&copy; %1$s %2$s. All Rights Reserved.', 'murray' ), date_i18n( 'Y' ), get_bloginfo( 'name' ) ) : esc_html(get_theme_mod('murray_footer_text')); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
	
</div><!-- #page -->


<?php wp_footer(); ?>

</body>
</html>
