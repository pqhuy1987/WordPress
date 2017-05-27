<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package murray
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'murray' ); ?></a>
	<div id="jumbosearch">
		<span class="fa fa-remove closeicon"></span>
		<div class="form">
			<?php get_search_form(); ?>
		</div>
	</div>	
	
	<div id="social-icons-fixed" title="<?php _e('Follow us on Social Media',''); ?>">
		<?php get_template_part('social', 'soshion'); ?>
	</div>	
	
	<header id="masthead" class="site-header" role="banner">			
		<div class="container">
			<div class="site-branding">
				<?php if ( murray_has_logo() ) : ?>					
				<div id="site-logo">
					<?php murray_logo() ?>
				</div>
				<?php endif; ?>
				<div id="text-title-desc">
				<h1 class="site-title title-font"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</div>
			</div>
			
			<div class="searchform">
				<?php get_template_part('searchform', 'top'); ?>
			</div>
			
		</div>	
	</header><!-- #masthead -->
		
	<nav id="site-navigation" class="main-navigation" role="navigation">
		<div class="nav-container container">
			<?php
				// Get the Appropriate Walker First.
				if (has_nav_menu(  'primary' ) && !get_theme_mod('murray_disable_nav_desc',true) ) :
						$walker = new Murray_Menu_With_Icon;
				else :
						$walker = '';
				endif;
				//Display the Menu.							
				wp_nav_menu( array( 'theme_location' => 'primary', 'walker' => $walker ) ); ?>
		</div>
	</nav><!-- #site-navigation -->
	
	<?php if( class_exists('rt_slider') ) {
			 rt_slider::render('slider', 'nivo' ); 
		} ?>
	
	<div class="mega-container">
	
		<div id="content" class="site-content container">