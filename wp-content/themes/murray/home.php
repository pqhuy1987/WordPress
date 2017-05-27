<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package murray
 */

get_header(); ?>

	<?php
	$args = array(
		'posts_per_page' => 1,
		'post__in'  => get_option( 'sticky_posts' ),
		'ignore_sticky_posts' => 1
	);
	$sticky_query = new WP_Query( $args );
	
	if ($sticky_query->have_posts()) {
		$sticky_query->the_post();
	} ?>
	
	<div id="sticky-post">
		<div <?php post_class("sticky-image col-md-8"); ?>>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('murray-thumb'); ?></a>
		</div>
		
		<div class="sticky-details col-md-4">
			<div class="sticky-title title-font">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</div>	
			
			<div class="sticky-desc">
				<?php the_excerpt(); ?>
			</div>	
		</div>
	</div>	
	
	
	<?php wp_reset_postdata(); ?>
	
	<div id="primary" class="content-areas <?php do_action('murray_primary-width') ?>">
		
		
		<?php
			
		for ($i = 1; $i < 3; $i++ ) :
			if (get_theme_mod('murray_featposts_enable'.$i) ) :
				//Call the Function to Display the Featured Posts
				murray_featured_posts( 
					get_theme_mod('murray_featposts_title'.$i,
					__("Section Title","murray")),
					get_theme_mod('murray_featposts_cat'.$i,0),
					get_theme_mod('murray_featposts_icon'.$i,'fa-star')
				); 
				
			endif;	
		endfor;
		
			
		
?>
		
		<main id="main" class="site-main" role="main">
		<div class="section-title">
			<i class="fa fa-home"></i><span><?php _e('Latest Posts','murray'); ?></span>
		</div>	
		<?php if ( have_posts() ) : ?>
		
			<?php /* Start the Loop */ $loop_c = 0; ?>
			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php
					/* Include the Post-Format-specific template for the content.
					 */
					$loop_c++;
					if ( ($loop_c == 1) && is_sticky() )
					continue;
					do_action('murray_blog_layout'); 
					
				?>

			<?php endwhile; ?>

			<?php murray_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
