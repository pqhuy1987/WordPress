<?php
/*
 * @package murray, Copyright Rohit Tripathi, rohitink.com
 * This file contains Custom Theme Related Functions.
 */
 
/*
** Walkers for Navigation menus
*/ 
//Supports Icon only. No Description.
class Murray_Menu_With_Icon extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$fontIcon = ! empty( $item->attr_title ) ? ' <i class="fa ' . esc_attr( $item->attr_title ) .'">' : '';
		$attributes = ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>'.$fontIcon.'</i>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );
	}
}

/*
 * Pagination Function. Implements core paginate_links function.
 */
function murray_pagination() {
	the_posts_pagination(
	array(
		'mid_size' => 2,
		'prev_text' => "<i class='fa fa-caret-left'></i>",
		'next_text' => "<i class='fa fa-caret-right'></i>",
		)
	);
}

/*
** Customizer Controls 
*/
if (class_exists('WP_Customize_Control')) {
	class WP_Customize_Category_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         */
        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'              => '_customize-dropdown-categories-' . $this->id,
                    'echo'              => 0,
                    'show_option_none'  => __( '&mdash; Select &mdash;', 'murray' ),
                    'option_none_value' => '0',
                    'selected'          => $this->value(),
                )
            );
 
            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
 
            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );
        }
    }
}  
if (class_exists('WP_Customize_Control')) {
	class WP_Customize_Upgrade_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         */
        public function render_content() {
             printf(
                '<label class="customize-control-upgrade"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $this->description
            );
        }
    }
}
  
/*
** Function to check if Sidebar is enabled on Current Page 
*/
function murray_load_sidebar() {
	$load_sidebar = true;
	if ( get_theme_mod('murray_disable_sidebar') ) :
		$load_sidebar = false;
	elseif( get_theme_mod('murray_disable_sidebar_home') && is_home() )	:
		$load_sidebar = false;
	elseif( get_theme_mod('murray_disable_sidebar_front') && is_front_page() ) :
		$load_sidebar = false;
	endif;
	
	return  $load_sidebar;
}

/*
**	Determining Sidebar and Primary Width
*/
function murray_primary_class() {
	$sw = esc_html(get_theme_mod('murray_sidebar_width',4));
	$class = "col-md-".(12-$sw);
	
	if ( !murray_load_sidebar() ) 
		$class = "col-md-12";
	
	echo $class;
}
add_action('murray_primary-width', 'murray_primary_class');

function murray_secondary_class() {
	$sw = esc_html(get_theme_mod('murray_sidebar_width',4));
	$class = "col-md-".$sw;
	
	echo $class;
}
add_action('murray_secondary-width', 'murray_secondary_class');


/*
** Function to Get Theme Layout 
*/
function murray_get_blog_layout(){
	$ldir = 'framework/layouts/content';
	if (get_theme_mod('murray_blog_layout') ) :
		get_template_part( $ldir , get_theme_mod('murray_blog_layout') );
	else :
		get_template_part( $ldir ,'murray');	
	endif;	
}
add_action('murray_blog_layout', 'murray_get_blog_layout');

/*
** Function to Render Featured Category Area for Front Page
*/
function murray_featured_posts( $title, $category_id = 0, $icon = "fa-star"  ) { ?>
	
	<div class="featured-section">
		
		<div class="section-title">
			<i class="fa <?php echo esc_attr($icon); ?>"></i><span><?php echo esc_html($title); ?></span>
		</div>
		
		<?php /* Start the Loop */  
		$args = array( 
			'posts_per_page' => 3,
			'cat' => $category_id,
			'ignore_sticky_posts' => true,
		);
		
		$lastposts = new WP_Query($args);
		
		while ( $lastposts->have_posts() ) :
		  $lastposts->the_post(); 
		  
		  global $murray_fpost_ids;
		  $murray_fpost_ids[] = get_the_id(); 
		  
		 	
		
		  ?> 	
				
		<article id="post-<?php the_ID(); ?>" <?php post_class('item col-md-4 col-xs-10 col-xs-offset-1 col-sm-offset-0 col-sm-4'); ?>>
			<div class="item-container">
					<?php if (has_post_thumbnail()) : ?>	
						<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('murray-featpost-thumb'); ?></a>
					<?php else : ?>
						<a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>"><img src="<?php echo get_template_directory_uri()."/assets/images/featpostthumb.jpg"; ?>"></a>

					<?php endif; ?>
					<div class="featured-caption">
						<a class="post-title" href="<?php the_permalink() ?>"><?php echo the_title(); ?></a>
						<span class="postdate title-font"><?php the_time(__('M j, Y','murray')); ?></span>
					</div>
					
			</div>		
				
		</article><!-- #post-## -->
			
		<?php endwhile; 
		wp_reset_postdata();?>
			
	</div>	
	
<?php }
//Create an Array to Store Post Ids of all posts that have been displayed already.
$murray_fpost_ids = [];
			
//Function to Exclude already displayed posts form the Homepage.
for ($i = 1; $i < 3; $i++ ) :
	if (get_theme_mod('murray_featposts_enable'.$i) && get_theme_mod('murray_featposts_cat'.$i) ) :
		
		$args = array( 
			'posts_per_page' => 3,
			'cat' => get_theme_mod('murray_featposts_cat'.$i),
			'ignore_sticky_posts' => true,
		);
		
		$lastposts = new WP_Query($args);
		
		while ( $lastposts->have_posts() ) :
		  $lastposts->the_post(); 
		  
		  global $murray_fpost_ids;
		  $murray_fpost_ids[] = get_the_id(); 
		  
		 endwhile; 
	endif;	
	
	wp_reset_postdata();
		
endfor;
		
function murray_exclude_single_posts_home($query) {		
global $murray_fpost_ids;
if ($query->is_home() && $query->is_main_query()) {
    $query->set('post__not_in', $murray_fpost_ids);
  }
}	
add_action('pre_get_posts', 'murray_exclude_single_posts_home');	


/*
** Sticky Menu Function
*/
function murray_stick_menu() {
	if (is_admin_bar_showing() ) {
		$script = "jQuery(document).ready(function() {
				  	if (jQuery(window).width() > 768) {
				  		jQuery('#site-navigation').scrollToFixed({ marginTop: 32 });
				  		}
				});";
	
	} else {
		$script = "jQuery(document).ready(function() {
					if (jQuery(window).width() > 768)
						jQuery('#site-navigation').scrollToFixed();
				});";
	}
	
	wp_add_inline_script('murray-custom-js', $script);
}
add_action('wp_enqueue_scripts', 'murray_stick_menu');


/*
** Load Custom Widgets
*/

require get_template_directory() . '/framework/widgets/recent-posts.php';


