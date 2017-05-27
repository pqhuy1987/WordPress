<?php
/**
 * murray Theme Customizer
 *
 * @package murray
 */
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function murray_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

		
	
	//Replace Header Text Color with, separate colors for Title and Description
	//Override murray_site_titlecolor
	$wp_customize->remove_control('display_header_text');
	$wp_customize->remove_setting('header_textcolor');
	$wp_customize->add_setting('murray_site_titlecolor', array(
	    'default'     => '#FFF',
	    'sanitize_callback' => 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize, 
		'murray_site_titlecolor', array(
			'label' => __('Site Title Color','murray'),
			'section' => 'colors',
			'settings' => 'murray_site_titlecolor',
			'type' => 'color'
		) ) 
	);
	
	$wp_customize->add_setting('murray_header_desccolor', array(
	    'default'     => '#FFF',
	    'sanitize_callback' => 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize, 
		'murray_header_desccolor', array(
			'label' => __('Site Tagline Color','murray'),
			'section' => 'colors',
			'settings' => 'murray_header_desccolor',
			'type' => 'color'
		) ) 
	);
	
	
	//Settings for Header Image
	$wp_customize->add_setting( 'murray_himg_style' , array(
	    'default'     => 'cover',
	    'sanitize_callback' => 'murray_sanitize_himg_style'
	) );
	
	/* Sanitization Function */
	function murray_sanitize_himg_style( $input ) {
		if (in_array( $input, array('contain','cover') ) )
			return $input;
		else
			return '';	
	}
	
	$wp_customize->add_control(
	'murray_himg_style', array(
		'label' => __('Header Image Arrangement','murray'),
		'section' => 'header_image',
		'settings' => 'murray_himg_style',
		'type' => 'select',
		'choices' => array(
				'contain' => __('Contain','murray'),
				'cover' => __('Cover Completely (Recommended)','murray'),
				)
	) );
	
	$wp_customize->add_setting( 'murray_himg_align' , array(
	    'default'     => 'center',
	    'sanitize_callback' => 'murray_sanitize_himg_align'
	) );
	
	/* Sanitization Function */
	function murray_sanitize_himg_align( $input ) {
		if (in_array( $input, array('center','left','right') ) )
			return $input;
		else
			return '';	
	}
	
	$wp_customize->add_control(
	'murray_himg_align', array(
		'label' => __('Header Image Alignment','murray'),
		'section' => 'header_image',
		'settings' => 'murray_himg_align',
		'type' => 'select',
		'choices' => array(
				'center' => __('Center','murray'),
				'left' => __('Left','murray'),
				'right' => __('Right','murray'),
			)
	) );
	
	$wp_customize->add_setting( 'murray_himg_repeat' , array(
	    'default'     => true,
	    'sanitize_callback' => 'murray_sanitize_checkbox'
	) );
	
	$wp_customize->add_control(
	'murray_himg_repeat', array(
		'label' => __('Repeat Header Image','murray'),
		'section' => 'header_image',
		'settings' => 'murray_himg_repeat',
		'type' => 'checkbox',
	) );
	
	
	//Settings For Logo Area
	
	$wp_customize->add_setting(
		'murray_hide_title_tagline',
		array( 'sanitize_callback' => 'murray_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'murray_hide_title_tagline', array(
		    'settings' => 'murray_hide_title_tagline',
		    'label'    => __( 'Hide Title and Tagline.', 'murray' ),
		    'section'  => 'title_tagline',
		    'type'     => 'checkbox',
		)
	);
	
	$wp_customize->add_setting(
		'murray_branding_below_logo',
		array( 'sanitize_callback' => 'murray_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'murray_branding_below_logo', array(
		    'settings' => 'murray_branding_below_logo',
		    'label'    => __( 'Display Site Title and Tagline Below the Logo.', 'murray' ),
		    'section'  => 'title_tagline',
		    'type'     => 'checkbox',
		    'active_callback' => 'murray_title_visible'
		)
	);
	
	function murray_title_visible( $control ) {
		$option = $control->manager->get_setting('murray_hide_title_tagline');
	    return $option->value() == false ;
	}	
			
			
	//FEATURED POSTS for Homepage
	$wp_customize->add_panel( 'murray_featposts', array(
	    'priority'       => 30,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => __('Featured Posts (Homepage)','murray'),
	) );
	
	for ($i = 1; $i < 3; $i++) :
	
	$wp_customize->add_section(
	    'murray_featposts'.$i,
	    array(
	        'title'     => __('Featured Category ','murray').$i,
	        'priority'  => 35,
	        'panel' => 'murray_featposts',
	    )
	);
	
	$wp_customize->add_setting(
		'murray_featposts_enable'.$i,
		array( 'sanitize_callback' => 'murray_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'murray_featposts_enable'.$i, array(
		    'settings' => 'murray_featposts_enable'.$i,
		    'label'    => __( 'Enable', 'murray' ),
		    'section'  => 'murray_featposts'.$i,
		    'type'     => 'checkbox',
		)
	);
	
	
	$wp_customize->add_setting(
		'murray_featposts_title'.$i,
		array( 'sanitize_callback' => 'sanitize_text_field' )
	);
	
	$wp_customize->add_control(
			'murray_featposts_title'.$i, array(
		    'settings' => 'murray_featposts_title'.$i,
		    'label'    => __( 'Title', 'murray' ),
		    'section'  => 'murray_featposts'.$i,
		    'type'     => 'text',
		)
	);
	
	$wp_customize->add_setting(
		'murray_featposts_icon'.$i,
		array( 'sanitize_callback' => 'sanitize_text_field', 'default' => 'fa-star' )
	);
	
	$wp_customize->add_control(
			'murray_featposts_icon'.$i, array(
		    'settings' => 'murray_featposts_icon'.$i,
		    'label'    => __( 'Title Icon', 'murray' ),
		    'section'  => 'murray_featposts'.$i,
		    'type'     => 'text',
		    'description' => __('Icon Class should be entered in this format: <strong>fa-video, fa-star, fa-envelope-o</strong>. List of Support Icons and Classes <a href="http://fontawesome.io/cheatsheet/" target="_blank">Available Here.</a>','murray'),
		)
	);
	
	$wp_customize->add_setting(
		    'murray_featposts_cat'.$i,
		    array( 'sanitize_callback' => 'murray_sanitize_category' )
		);
	
		
	$wp_customize->add_control(
	    new WP_Customize_Category_Control(
	        $wp_customize,
	        'murray_featposts_cat'.$i,
	        array(
	            'label'    => __('Category For Featured Posts','murray'),
	            'settings' => 'murray_featposts_cat'.$i,
	            'section'  => 'murray_featposts'.$i,
	        )
	    )
	);
	
	
	
	endfor;
		
	// Layout and Design
	$wp_customize->add_panel( 'murray_design_panel', array(
	    'priority'       => 40,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => __('Design & Layout','murray'),
	) );
	
	$wp_customize->add_section(
	    'murray_design_options',
	    array(
	        'title'     => __('Blog Layout','murray'),
	        'priority'  => 0,
	        'panel'     => 'murray_design_panel'
	    )
	);
	
	
	$wp_customize->add_setting(
		'murray_blog_layout',
		array( 'sanitize_callback' => 'murray_sanitize_blog_layout', 'default' => 'murray' )
	);
	
	function murray_sanitize_blog_layout( $input ) {
		if ( in_array($input, array('grid','grid_2_column','grid_3_column','murray') ) )
			return $input;
		else 
			return '';	
	}
	
	$wp_customize->add_control(
		'murray_blog_layout',array(
				'label' => __('Select Layout','murray'),
				'settings' => 'murray_blog_layout',
				'section'  => 'murray_design_options',
				'type' => 'select',
				'choices' => array(
						'murray' => __('Murray Theme Layout','murray'),
						'grid' => __('Basic Blog Layout','murray'),
						'grid_2_column' => __('Grid - 2 Column','murray'),
						'grid_3_column' => __('Grid - 3 Column','murray'),
						
					)
			)
	);
	
	$wp_customize->add_section(
	    'murray_sidebar_options',
	    array(
	        'title'     => __('Sidebar Layout','murray'),
	        'priority'  => 0,
	        'panel'     => 'murray_design_panel'
	    )
	);
	
	$wp_customize->add_setting(
		'murray_disable_sidebar',
		array( 'sanitize_callback' => 'murray_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'murray_disable_sidebar', array(
		    'settings' => 'murray_disable_sidebar',
		    'label'    => __( 'Disable Sidebar Everywhere.','murray' ),
		    'section'  => 'murray_sidebar_options',
		    'type'     => 'checkbox',
		    'default'  => false
		)
	);
	
	$wp_customize->add_setting(
		'murray_disable_sidebar_home',
		array( 'sanitize_callback' => 'murray_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'murray_disable_sidebar_home', array(
		    'settings' => 'murray_disable_sidebar_home',
		    'label'    => __( 'Disable Sidebar on Home/Blog.','murray' ),
		    'section'  => 'murray_sidebar_options',
		    'type'     => 'checkbox',
		    'active_callback' => 'murray_show_sidebar_options',
		    'default'  => false
		)
	);
	
	$wp_customize->add_setting(
		'murray_disable_sidebar_front',
		array( 'sanitize_callback' => 'murray_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'murray_disable_sidebar_front', array(
		    'settings' => 'murray_disable_sidebar_front',
		    'label'    => __( 'Disable Sidebar on Front Page.','murray' ),
		    'section'  => 'murray_sidebar_options',
		    'type'     => 'checkbox',
		    'active_callback' => 'murray_show_sidebar_options',
		    'default'  => false
		)
	);
	
	
	$wp_customize->add_setting(
		'murray_sidebar_width',
		array(
			'default' => 4,
		    'sanitize_callback' => 'murray_sanitize_positive_number' )
	);
	
	$wp_customize->add_control(
			'murray_sidebar_width', array(
		    'settings' => 'murray_sidebar_width',
		    'label'    => __( 'Sidebar Width','murray' ),
		    'description' => __('Min: 25%, Default: 33%, Max: 40%','murray'),
		    'section'  => 'murray_sidebar_options',
		    'type'     => 'range',
		    'active_callback' => 'murray_show_sidebar_options',
		    'input_attrs' => array(
		        'min'   => 3,
		        'max'   => 5,
		        'step'  => 1,
		        'class' => 'sidebar-width-range',
		        'style' => 'color: #0a0',
		    ),
		)
	);
	
	/* Active Callback Function */
	function murray_show_sidebar_options($control) {
	   
	    $option = $control->manager->get_setting('murray_disable_sidebar');
	    return $option->value() == false ;
	    
	}
	
	$wp_customize-> add_section(
    'murray_custom_footer',
    array(
    	'title'			=> __('Custom Footer Text','murray'),
    	'description'	=> __('Enter your Own Copyright Text.','murray'),
    	'priority'		=> 11,
    	'panel'			=> 'murray_design_panel'
    	)
    );
    
	$wp_customize->add_setting(
	'murray_footer_text',
	array(
		'default'		=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
		)
	);
	
	$wp_customize->add_control(	 
	       'murray_footer_text',
	        array(
	            'section' => 'murray_custom_footer',
	            'settings' => 'murray_footer_text',
	            'type' => 'text'
	        )
	);	
	
	$wp_customize->add_section(
	    'murray_sec_upgrade',
	    array(
	        'title'     => __('Upgrade to Murray Pro Version','murray'),
	        'priority'  => 1,
	    )
	);
	
	$wp_customize->add_setting(
			'murray_upgrade',
			array( 'sanitize_callback' => 'esc_textarea' )
		);
			
	$wp_customize->add_control(
	    new WP_Customize_Upgrade_Control(
	        $wp_customize,
	        'murray_upgrade',
	        array(
	            'label' => __('Thank You','murray'),
	            'description' => __('Thank You for Choosing Murray. Murray Plus is a Powerful Wordpress theme which also supports WooCommerce in the best possible way. It is "as we say" the last theme you would ever need. It has all the basic and advanced features needed to run a gorgeous looking site. If you are looking for more features and to support us, please  <a href="https://inkhive.com/product/murray-plus/">purchase Murray Plus</a>.','murray'),
	            'section' => 'murray_sec_upgrade',
	            'settings' => 'murray_upgrade',			       
	        )
		)
	);
	
	$wp_customize->add_section(
	    'murray_typo_options',
	    array(
	        'title'     => __('Google Web Fonts','murray'),
	        'priority'  => 41,
	    )
	);
	
	$font_array = array('Fjalla One','Khula','Open Sans','Droid Sans','Droid Serif','Roboto','Roboto Condensed','Lato','Bree Serif','Oswald','Slabo','Lora','Source Sans Pro','PT Sans','Ubuntu','Lobster','Arimo','Bitter','Noto Sans');
	$fonts = array_combine($font_array, $font_array);
	
	$wp_customize->add_setting(
		'murray_title_font',
		array(
			'default'=> 'Fjalla One',
			'sanitize_callback' => 'murray_sanitize_gfont' 
			)
	);
	
	function murray_sanitize_gfont( $input ) {
		if ( in_array($input, array('Source Sans Pro','Khula','Open Sans','Droid Sans','Droid Serif','Roboto','Roboto Condensed','Lato','Bree Serif','Oswald','Slabo','Lora','PT Sans','Ubuntu','Lobster','Arimo','Bitter','Noto Sans') ) )
			return $input;
		else
			return '';	
	}
	
	$wp_customize->add_control(
		'murray_title_font',array(
				'label' => __('Title','murray'),
				'settings' => 'murray_title_font',
				'section'  => 'murray_typo_options',
				'type' => 'select',
				'choices' => $fonts,
			)
	);
	
	$wp_customize->add_setting(
		'murray_body_font',
			array(	'default'=> 'Source Sans Pro',
					'sanitize_callback' => 'murray_sanitize_gfont' )
	);
	
	$wp_customize->add_control(
		'murray_body_font',array(
				'label' => __('Body','murray'),
				'settings' => 'murray_body_font',
				'section'  => 'murray_typo_options',
				'type' => 'select',
				'choices' => $fonts
			)
	);
	
	// Social Icons
	$wp_customize->add_section('murray_social_section', array(
			'title' => __('Social Icons','murray'),
			'priority' => 44 ,
	));
	
	$social_networks = array( //Redefinied in Sanitization Function.
					'none' => __('-','murray'),
					'facebook' => __('Facebook','murray'),
					'twitter' => __('Twitter','murray'),
					'google-plus' => __('Google Plus','murray'),
					'instagram' => __('Instagram','murray'),
					'rss' => __('RSS Feeds','murray'),
					'vine' => __('Vine','murray'),
					'vimeo-square' => __('Vimeo','murray'),
					'youtube' => __('Youtube','murray'),
					'flickr' => __('Flickr','murray'),
				);
				
	$social_count = count($social_networks);
				
	for ($x = 1 ; $x <= ($social_count - 3) ; $x++) :
			
		$wp_customize->add_setting(
			'murray_social_'.$x, array(
				'sanitize_callback' => 'murray_sanitize_social',
				'default' => 'none'
			));

		$wp_customize->add_control( 'murray_social_'.$x, array(
					'settings' => 'murray_social_'.$x,
					'label' => __('Icon ','murray').$x,
					'section' => 'murray_social_section',
					'type' => 'select',
					'choices' => $social_networks,			
		));
		
		$wp_customize->add_setting(
			'murray_social_url'.$x, array(
				'sanitize_callback' => 'esc_url_raw'
			));

		$wp_customize->add_control( 'murray_social_url'.$x, array(
					'settings' => 'murray_social_url'.$x,
					'description' => __('Icon ','murray').$x.__(' Url','murray'),
					'section' => 'murray_social_section',
					'type' => 'url',
					'choices' => $social_networks,			
		));
		
	endfor;
	
	function murray_sanitize_social( $input ) {
		$social_networks = array(
					'none' ,
					'facebook',
					'twitter',
					'google-plus',
					'instagram',
					'rss',
					'vine',
					'vimeo-square',
					'youtube',
					'flickr'
				);
		if ( in_array($input, $social_networks) )
			return $input;
		else
			return '';	
	}	
	
	
	/* Sanitization Functions Common to Multiple Settings go Here, Specific Sanitization Functions are defined along with add_setting() */
	function murray_sanitize_checkbox( $input ) {
	    if ( $input == 1 ) {
	        return 1;
	    } else {
	        return '';
	    }
	}
	
	function murray_sanitize_positive_number( $input ) {
		if ( ($input >= 0) && is_numeric($input) )
			return $input;
		else
			return '';	
	}
	
	function murray_sanitize_category( $input ) {
		if ( term_exists(get_cat_name( $input ), 'category') )
			return $input;
		else 
			return '';	
	}
	
	
}
add_action( 'customize_register', 'murray_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function murray_customize_preview_js() {
	wp_enqueue_script( 'murray_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'murray_customize_preview_js' );
