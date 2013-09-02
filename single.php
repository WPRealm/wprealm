<?php

//Remove post info above content
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

add_filter( 'genesis_post_title_output', 'wpr_link_filter' );
/**
 * Replaces permalink with custom field value
 *
 * @access public
 * @param mixed $link
 * @param mixed $post
 * @return void
 */
function wpr_link_filter() {
	global $post;

	$link = get_post_meta( $post->ID, '_format_link_url', true );

     // check to see if the post format is a link and if it has the proper custom field
     if ( has_post_format( 'link', $post ) && get_post_meta( $post->ID, '_format_link_url', true ) ) {

     	echo '<h1 class="entry-title"><a href="'. $link . '">' . the_title_attribute( 'echo=0' ) . '</a></h1>';
     }
     else {
     	echo '<h1 class="entry-title">' . the_title_attribute( 'echo=0' ) . '</h1>';
     }

}

genesis();