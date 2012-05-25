<?php
/** Start the engine */
require_once( get_template_directory() . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'WP Realm' );
define( 'CHILD_THEME_URL', 'http://wprealm.com' );

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

/** Add support for custom background */
add_custom_background();

/** Add support for custom header */
add_theme_support( 'genesis-custom-header', array( 'width' => 960, 'height' => 100 ) );

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );