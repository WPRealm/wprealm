<?php 

/**
 * HTML5 markup being applied instead of default Genesis
 *
 * @category   Genesis
 * @package    Markup
 * @subpackage HTML5
 * @author     WP Realm
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://wprealm.com
 */

remove_action( 'genesis_doctype', 'genesis_do_doctype' );
add_action( 'genesis_doctype', 'wpr_html5_doctype' );
/**
 * Changes the HTML doc type to HTML5.
 * 
 * @uses language_attributes() Detects languages attributes
 * @uses bloginfo() Display site constants
 * @author Remkus de Vries
 */
function wpr_html5_doctype() {
	?>
<!DOCTYPE html>
<html <?php language_attributes('xhtml'); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<?php
}

add_action( 'wp_head','wpr_html5_forIE' );
/**
 * Help bloody IE perform somewhat decent with HTML5.
 * 
 * @uses get_stylesheet_directory_uri() Returns the stylesheet directory
 */
function wpr_html5_forIE() {
	?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/lib/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<?php
}

remove_action( 'genesis_loop', 'genesis_do_loop' ); 
add_action( 'genesis_loop', 'wpr_html5_genesis_standard_loop' ); 
/**
 * Modified Genesis loop to accomodate HMTL5 markup.
 * 
 * It outputs basic wrapping HTML, but uses hooks to do most of its
 * content output like title, content, post information and comments.
 *
 * The action hooks called are:
 *   genesis_before_post,
 *   genesis_before_post_title,
 *   genesis_post_title,
 *   genesis_after_post_title,
 *   genesis_before_post_content,
 *   genesis_post_content
 *   genesis_after_post_content
 *   genesis_after_post,
 *   genesis_after_endwhile,
 *   genesis_loop_else (only if no posts were found).
 *
 * @since 1.0
 * @author Remkus de Vries
 *
 * @global integer $loop_counter Increments on each loop pass
 */
function wpr_html5_genesis_standard_loop() {

	global $loop_counter;

	$loop_counter = 0;

	if ( have_posts() ) : while ( have_posts() ) : the_post();

	do_action( 'genesis_before_post' );
	?>
	<article <?php post_class(); ?>> 
		
		<header>
			<?php do_action( 'genesis_before_post_title' ); ?>
			<?php do_action( 'genesis_post_title' ); ?>
			<?php do_action( 'genesis_after_post_title' ); ?>

			<?php do_action( 'genesis_before_post_content' ); ?>
		</header>
		
		<div class="entry-content">
			<?php do_action( 'genesis_post_content' ); ?>
		</div><!-- end .entry-content -->
		
		<footer>
			<?php do_action( 'genesis_after_post_content' ); ?>
		</footer>
		
	</article><!-- end .postclass -->
	<?php

	do_action( 'genesis_after_post' );
	$loop_counter++;

	endwhile; /** end of one post **/
	do_action( 'genesis_after_endwhile' );

	else : /** if no posts exist **/
	do_action( 'genesis_loop_else' );
	endif; /** end loop **/

}

remove_action( 'genesis_before_post_content', 'genesis_post_info' );
//add_action( 'genesis_before_post_content', 'wpr_post_info' );
/**
 * Custom Post-Info with Google Rich Snippet support
 *
 * @author Greg Rickaby
 * @link https://gist.github.com/2876822
 * @since 1.0.0
 */
function wpr_post_info() {
	
	if ( is_page() )
	
	// don't do post-info on pages. Evah.	
	return;  
	
	?>
	<div class="speech-tailmeta"></div>
	<div class="post-info">
		<span class="date published time">
			<i class="icon-calendar"></i><time class="entry-date" itemprop="startDate" datetime="<?php echo get_the_date( 'c' ); ?>" pubdate><?php echo get_the_date(); ?></time>
		</span> 
		<span class="author vcard">
			<i class="icon-user"></i>By <a class="fn n" href="<?php echo get_the_author_url( get_the_author_meta( 'ID' ) ); ?>" title="View <?php echo get_the_author(); ?>'s Profile" rel="author me"><?php the_author_meta( 'display_name' ); ?></a>
		</span>
		<span class="post-comments">
			<i class="icon-comment"></i><a href="<?php the_permalink() ?>#comments"><?php comments_number( 'Leave a Comment', '1 Comment', '% Comments' ); ?></a></span>
		<?php // if the post has been modified, display the modified date
		$published = get_the_date( 'F j, Y' );
		$modified = the_modified_date( 'F j, Y', '', '', FALSE );
		$published_compare = get_the_date( 'Y-m-d' );
		$modified_compare = the_modified_date( 'Y-m-d', '', '', FALSE ); 
			if ( $published_compare < $modified_compare ) {
				echo '<span class="updated"><em>(Updated: ' . $modified . ')</em></span>';
			} ?>
	</div>
<?php }

remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
add_action( 'genesis_footer', 'wpr_genesis_footer_markup_open', 5 );
/**
 * Echo the opening div tag for the footer.
 *
 * @since 1.2.0
 *
 * @uses genesis_structural_wrap() Maybe add opening .wrap div tag
 */
function wpr_genesis_footer_markup_open() {

	echo '<footer id="footer" class="footer">';
	genesis_structural_wrap( 'footer', 'open' );

}

remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
add_action( 'genesis_footer', 'wpr_genesis_footer_markup_close', 15 );
/**
 * Echo the closing div tag for the footer.
 *
 * @since 1.2.0
 *
 * @uses genesis_structural_wrap() Maybe add closing .wrap div tag
 */
function wpr_genesis_footer_markup_close() {

	genesis_structural_wrap( 'footer', 'close' );
	echo '</footer><!-- end #footer -->' . "\n";

}