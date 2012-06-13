<?php
/** Start the engine */
require_once( get_template_directory() . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'WP Realm' );
define( 'CHILD_THEME_URL', 'http://wprealm.com' );

/** Loading HTML5 features*/
require_once( CHILD_DIR. '/lib/markup/html5.php' );

add_action( 'genesis_meta', 'add_viewport_meta_tag' );
/**
 * Add Viewport meta tag for mobile browsers 
 * 
 * @access public
 * @return void
 */
function add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );

add_action( 'genesis_before_sidebar_widget_area', 'wpr_sidebar_author_meta' );
/**
 * Adds Author Meta (and then some) to top of sidebar.
 * 
 * @access public
 * @author Remkus de Vries
 */
function wpr_sidebar_author_meta() {
	
	// only on single post
	if ( is_single() ) {
	?>
	<aside id="article-meta">
		<i class="caret"></i>
		
		<?php wpr_post_info(); ?>
		
		<?php genesis_author_box( 'single' ); ?>
	
	</aside>
	<?php
	}
}

add_filter( 'genesis_footer_backtotop_text', 'wpr_footer_backtotop_filter' );
/**
 * Customizing Return to Top of Page section in Footer
 * 
 * @access public
 * @param mixed $backtotop
 * @return void
 */
function wpr_footer_backtotop_filter( $backtotop ) {
    
    $backtotop = '[footer_backtotop text="&uarr;"]';
    
    return $backtotop;
}  

add_filter( 'genesis_footer_creds_text', 'wpr_footer_creds_filter' ); 
/**
 * Modifying Footer Credit section.
 * 
 * @access public
 * @param mixed $creds
 * @return void
 */
function wpr_footer_creds_filter( $creds ) {
    
    $creds = '[footer_copyright] [footer_childtheme_link] [footer_loginout]';
    
    return $creds;
}