<?php
/* 
**   Custom Modifcations in CSS depending on user settings.
*/

function murray_custom_css_mods() {

	echo "<style id='custom-css-mods'>";
	
	
	//If Title and Desc is set to Show Below the Logo
	if (  get_theme_mod('murray_branding_below_logo') ) :		
		echo "#masthead #text-title-desc { display: block; clear: both; } ";		
	endif;	
	
	
	if ( get_theme_mod('murray_title_font','Fjalla One') ) :
		echo ".title-font, h1, h2, .section-title { font-family: ".esc_html(get_theme_mod('murray_title_font'))."; }";
	endif;
	
	if ( get_theme_mod('murray_body_font','Source Sans Pro') ) :
		echo "body { font-family: ".esc_html(get_theme_mod('murray_body_font'))."; }";
	endif;
	
	if ( get_theme_mod('murray_site_titlecolor') ) :
		echo "#masthead h1.site-title a { color: ".esc_html(get_theme_mod('murray_site_titlecolor', '#FFF'))."; }";
	endif;
	
	
	if ( get_theme_mod('murray_header_desccolor','#777') ) :
		echo "#masthead h2.site-description { color: ".esc_html(get_theme_mod('murray_header_desccolor','#FFF'))."; }";
	endif;
	
	
	if ( get_theme_mod('murray_hide_title_tagline') ) :
		echo "#masthead .site-branding #text-title-desc { display: none; }";
	endif;

	echo "</style>";
}

add_action('wp_head', 'murray_custom_css_mods');