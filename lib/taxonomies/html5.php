<?php 

remove_action('genesis_doctype', 'genesis_do_doctype');
add_action('genesis_doctype', 'rt_html5_doctype');
/**
 * rt_html5_doctype function.
 * 
 * @access public
 * @return void
 */
function rt_html5_doctype() {
	?>
	<!DOCTYPE html>
	<html <?php language_attributes('xhtml'); ?>>
	<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<?php
}

add_action('wp_head','rt_html5_forIE');
/**
 * rt_html5_forIE function.
 * 
 * @access public
 * @return void
 */
function rt_html5_forIE() {
	?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/lib/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<?php
}

remove_action( 'genesis_loop', 'genesis_do_loop' ); 
add_action( 'genesis_loop', 'rt_html5_genesis_standard_loop' ); 
/**
 * rt_html5_genesis_standard_loop function.
 * 
 * @access public
 * @return void
 */
function rt_html5_genesis_standard_loop() { 
    global $loop_counter; 
    $loop_counter = 0; 

    if ( have_posts() ) : while ( have_posts() ) : the_post(); // the loop 

    do_action( 'genesis_before_post' ); ?> 

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