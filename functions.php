<?php
/** Start the engine */
require_once( get_template_directory() . '/lib/init.php' );


/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'WP Realm' );
define( 'CHILD_THEME_URL', 'http://wprealm.com' );


/** Loading HTML5 features*/
include 'lib/markup/html5.php';


/** WP Thumb even better then 'resize on demand' */
if( !class_exists( 'WP_Thumb' ) ){
   include 'lib/plugins/WPThumb/wpthumb.php';
}


/** Metaboxes are here */
include 'lib/admin/metaboxes.php';


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


add_action( 'genesis_before_post_title', 'wpr_wpthumb_featured_image_magic' );
/**
 * Use WPThumb to display featured images on the fly.
 * 
 * @author Remkus de Vries
 * @uses wbthumb()
 * @uses wp_get_attachment_url()
 * @uses get_post_thumbnail_id()
 * @link https://github.com/humanmade/WPThumb
 *
 */
function wpr_wpthumb_featured_image_magic() {
	global $post;


	// Rafa, this is for your gmap as featured image

	// if gmap isset
	// if( $gmap = [somecodethatgetsgmap] ) {
	// 	echo $gmap;
	// 	return;
	// } 
	

	// if a featured video isset
	if( $video = get_post_meta( $post->ID, '_wpr_featured_video' ) ){
		echo wp_oembed_get( $video[0], array( 'width' => 882 ) );
		return;
	}
	
	// else, show featured image
	$image_url = wpthumb( 
		wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ), // get thumnail url by post thumbnail ID
		$args = array(
			'width'		=> 882, 
			'height'	=> 400, /* Golden Ratio FTW */ 
			'crop'		=> true,
			/*'default'    => CHILD_DIR . '/images/default.png',*/
			/*'watermark_options'=> array(
				'mask' => wpthumb( CHILD_URL . '/images/wprealm-watermark.png', 'height=20'),
				'padding' => 0, 
				'position' => 'rb', 
				'pre_resize' => false
			)*/
		) 
		
	);
	
	echo '<img class="feature-image" src=" '.$image_url . '">';
	
}


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
		<?php //example for retrieving twitter url
		//global $post; $twitter = get_the_author_meta( 'twitter', $post->post_author ); ?>
		
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


add_filter( 'user_contactmethods', 'wpr_changing_contactmethods', 10, 1 );
/**
 * wpr_changing_contactmethods function.
 * 
 * @access public
 * @param mixed $contactmethods
 * @return void
 */
function wpr_changing_contactmethods( $contactmethods ) {
  
	// Add Twitter
	if ( ! isset( $contactmethods['twitter'] ) )
	$contactmethods['twitter'] = 'Twitter';
	
	// Add Facebook
	if ( ! isset( $contactmethods['facebook'] ) )
	$contactmethods['facebook'] = 'Facebook';

	// Remove Yahoo IM
	if ( isset( $contactmethods['yim'] ) )
	unset( $contactmethods['yim'] );

	return $contactmethods;
}


add_filter( 'embed_oembed_html', 'wpr_oembed_transparency', 10, 4 );
/**
 * oEmbed Transparency
 *
 * Used so that menus can appear on top of videos
 *
 * @author Bill Erickson
 * @link http://www.billerickson.net/code/oembed-transparency
 *
 * @param string $html
 * @param string $url
 * @param array $attr, shortcode attributes
 * @param int $post_id
 * @return string The embed HTML on success, otherwise the original URL.
 */
function wpr_oembed_transparency( $html, $url, $attr, $post_id ) {

	if ( strpos( $html, "<embed src=" ) !== false ){
		return str_replace('</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $html);
	}
	elseif ( strpos ( $html, 'feature=oembed' ) !== false ){
		return str_replace( 'feature=oembed', 'feature=oembed&wmode=opaque', $html );
	}
	else{
		return $html;
	}
}


