<?php
/**
 * @package Murray
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('grid murray col-md-4 grid_3_column'); ?>>


		<div class="featured-thumb col-md-12">
			<?php if (has_post_thumbnail()) : ?>	
				<a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_post_thumbnail('murray-featpost-thumb'); ?></a>
			<?php else: ?>
				<a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><img src="<?php echo get_template_directory_uri()."/assets/images/featpostthumb.jpg"; ?>"></a>
			<?php endif; ?>
		</div><!--.featured-thumb-->
		
		<div class="icon">
			<i class="fa fa-newspaper-o"></i>
		</div>
			
		<div class="out-thumb col-md-12">
			<header class="entry-header">
					<h1 class="entry-title body-font"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
					<div class="postedon"><?php murray_posted_on_date(); ?></div>
				</header><!-- .entry-header -->
		</div>
		
</article><!-- #post-## -->