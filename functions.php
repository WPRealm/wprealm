<?php
/** Start the engine */
require_once( get_template_directory() . '/lib/init.php' );


/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'WP Realm' );
define( 'CHILD_THEME_URL', 'http://wprealm.com' );

/** Add support for post formats */
add_theme_support( 'post-formats', array( 'aside', 'chat', 'image', 'link', 'quote', 'status', 'video' ) );

/** Loading HTML5 features*/
include 'lib/markup/html5.php';

/** Loading Crowd Favorite's Post Formats */
require_once( 'lib/plugins/wp-post-formats/cf-post-formats.php' );

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


add_action( 'genesis_before_post_title', 'wpr_post_featured_content' );
/**
 * Use WPThumb to display featured images on the fly.
 * 
 * @author Remkus de Vries, Daan Kortenbach
 * @uses wbthumb()
 * @uses wp_get_attachment_url()
 * @uses get_post_thumbnail_id()
 * @link https://github.com/humanmade/WPThumb
 *
 */
function wpr_post_featured_content() {
	global $post;
	
	if( ! is_page() ) {
	

	// Rafa, this is for your gmap as featured image

	// if gmap isset
	// if( $gmap = [somecodethatgetsgmap] ) {
	// 	echo $gmap;
	// 	return;
	// } 
	

	// if a featured video isset
	if( $video = get_post_meta( $post->ID, '_wpr_featured_video' ) ){
		echo '<div class="videocontainer"> ' . wp_oembed_get( $video[0], array( 'width' => 882 ) ) . '</div>';
		return;
	}
	
	// else, show featured image
	$image_url = wpthumb( 
	
		// get thumnail url by post thumbnail ID
		wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ), 
		$args = array(
			'width'		=> 882, 
			'height'	=> 400,  
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
	
	if( has_post_format( 'aside' ) ) {
		return;
	} else
	if( has_post_format( 'chat' ) ) {
		return;
	} else 
	if( has_post_format( 'link' ) ) {
		return;
	} else
	if( has_post_format( 'video' ) ) {
		return;
	} else
	if( has_post_format( 'image' ) ) {
		return;
	} else
	if( has_post_format( 'quote' ) ) {
		return;
	} else 
	if( has_post_format( 'status' ) ) {
		return;
	} else
	echo '<a href="' . get_permalink() . '"><img class="feature-content" src="'.$image_url . '" alt="' . esc_attr( $post->post_title ) . '" /></a>';

	}

}

//add_action('wp_enqueue_scripts', 'wpr_js_plugins');
/**
 * Add Sticky Meta-Box Functionality
 *
 * @author Noel Tock
 * @todo make it behave properly.
 */
function wpr_js_plugins() {
    wp_enqueue_script('js_plugins', CHILD_URL . '/html/js/stickyfloor.js', array( 'jquery' ) );
}

add_action('wp_enqueue_scripts', 'wpr_js_dropdownmenu');
/**
 * Add functionality to make the <select>-box menu work.
 *
 * @access public
 * @author Luc De Brouwer
 */
function wpr_js_dropdownmenu() {
    wp_enqueue_script('js_select', CHILD_URL . '/lib/js/dropdownmenu.js', array( 'jquery' ) );
}


add_action('wp_enqueue_scripts', 'wpr_responsive_video');
/**
 * Adds responsive video jQuery
 * 
 * @access public
 * @author Daan Kortenbach
 */
function wpr_responsive_video() {
	wp_enqueue_script(
		'jquery-responsive-video',
		CHILD_URL . '/lib/js/jquery.responsive.video.js',
		array( 'jquery' ),
		'0.1',
		//put in footer
		true 
	);
}

add_action( 'genesis_post_content', 'wpr_adding_lead_text_above_content', 1 );
/**
 * wpr_adding_lead_text_above_content function.
 * 
 * @access public
 * @return void
 */
function wpr_adding_lead_text_above_content() {
	if ( ! is_page() ) {
	?>
	<section class="lead">
		<?php genesis_custom_field( '_wpr_lead_text' ); ?>
	</section>
	<?php
	}
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
		return str_replace( '</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $html );
	}
	elseif ( strpos ( $html, 'feature=oembed' ) !== false ){
		return str_replace( 'feature=oembed', 'feature=oembed&wmode=opaque', $html );
	}
	else{
		return $html;
	}
}

remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'wpr_header' );
/**
 * Echo the WP Realm header, including the #title-area div,
 * along with #title and #description, as well as the .widget-area.
 *
 * Calls the genesis_site_title, genesis_site_description and
 * wpr_header_nav actions.
 *
 * @access public
 * @author Luc De Brouwer
 */
function wpr_header() {

	echo '<div id="title-area">';
	do_action( 'genesis_site_title' );
	do_action( 'genesis_site_description' );
	echo '</div><!-- end #title-area -->';
	do_action( 'wpr_header_nav' );

}

add_action( 'wpr_header_nav', 'wpr_header_nav' );
/**
 * Echoes the "Primary Navigation" menu.
 *
 * @access public
 * @author Luc De Brouwer
 */
function wpr_header_nav( ) {
	$nav = '';
	if ( has_nav_menu( 'primary' ) ) {
		$args = array(
			'theme_location' => 'primary',
			'container' => '',
			'echo' => 0,
		);
	
		$nav = wp_nav_menu( $args );
	}
	echo '<nav id="header-nav">' . $nav . '</nav>';
}

add_action( 'genesis_after_header', 'wpr_select_nav' );
/**
 * Echoes the "Primary Navigation" menu as a select dropdown.
 *
 * @access public
 * @author Luc De Brouwer
 */
function wpr_select_nav( ) {
	$nav = '';
	if ( has_nav_menu( 'primary' ) ) {
		$args = array(
			'theme_location' => 'primary',
			'container' => '',
			'echo' => 0,
			'walker' => new wpr_Walker_Nav_Menu_Dropdown( ),
			'items_wrap' => '<select><option value="">- Choose -</option>%3$s</select>',
		);
	
		$nav = wp_nav_menu( $args );
	}
	echo '<nav id="select-nav">' . $nav . '</nav>';
}

/**
 * Custom walker to generate a <select>-based menu.
 *
 * @access public
 * @author Luc De Brouwer
 */
class wpr_Walker_Nav_Menu_Dropdown extends Walker_Nav_Menu {
	function start_lvl(&$output, $depth){
		$indent = str_repeat( "\t", $depth );
	}

	function end_lvl(&$output, $depth){
		$indent = str_repeat( "\t", $depth );
	}

	function start_el( &$output, $item, $depth, $args ){
		$item->title = str_repeat( "&nbsp;", $depth * 4 ).$item->title;
		$output .= '<option value="' . $item->url . '">' . $item->title;
	}

	function end_el( &$output, $item, $depth ){
	  $output .= "</option>\n";
	}
}

add_filter( 'genesis_post_meta', 'wpr_post_meta_filter' );
/**
 * Customize the post meta function.
 * 
 * @access public
 * @param mixed $post_meta
 * @return void
 */
function wpr_post_meta_filter( $post_meta ) {
	if ( is_singular() ) {
    
    $post_meta = '[post_categories] [post_tags]';
    
    return $post_meta;
	
	}
	if ( ! is_singular() ) {
	
	$post_meta = '[post_categories] [post_comments]';
    
    return $post_meta;	
		
	}
}

remove_action( 'genesis_meta', 'genesis_load_favicon' );
add_action( 'genesis_meta', 'wpr_custom_favicon' );
/**
 * Remove Genesis Favicon and Replace with own
 * 
 * @access public
 * @return void
 */
function wpr_custom_favicon() {
    $favicon = 'http://wprealm.com/favicon.ico';
    
    echo "\n".'<!--The Favicon-->'."\n";
    echo '<link rel="Shortcut Icon" href="'. esc_url( $favicon ). '" type="image/x-icon" />'."\n";
}

add_filter( 'the_content_more_link', 'custom_read_more_link' );
/**
 * Modify the WordPress read more link 
 * 
 * @access public
 * @return void
 * @link http://www.studiopress.com/tutorials/post-excerpts
 */
function custom_read_more_link() {
    return ' <a class="more-link" href="' . get_permalink() . '">Keep reading &raquo;</a>';
}

add_filter( 'genesis_ping_list_args', 'wpr_ping_list_args' );
/**
 * Take the existing arguments, and amend one that specifies a custom callback.
 * 
 * Tap into the list of arguments applied at genesis/lib/functions/comments.php.
 * 
 * @see child_list_pings() Callback for displaying trackbacks.
 *
 * @author Gary Jones
 * @link   http://code.garyjones.co.uk/change-trackback-format/
 * 
 * @param array $args Existing ping list arguments.
 *
 * @return array Amended ping list arguments.
 */
function wpr_ping_list_args( $args ) {
	
	$custom_args = array( 'callback' => 'wpr_list_pings' );

	return array_merge( $args, $custom_args );
	
}

/**
 * Echo the appearance of a single trackback.
 * 
 * Code below strips away most details about the ping, and just leaves a link to
 * the source of the ping, with the source title as the displayed text. 
 * 
 * @author Gary Jones
 * @link   http://code.garyjones.co.uk/change-trackback-format/
 * 
 * @param object  $comment Comment object.
 * @param array   $args    Comment arguments.
 * @param integer $depth   Current comment nested depth.
 */
function wpr_list_pings( $comment, $args, $depth ) {

	$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, $size = '48', $default = '<path_to_url>' ); ?>
				<?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ) ?>
			</div>
		</div>
	</li>
	<?php

}