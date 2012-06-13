<?php

/**
 * Handles primary sidebar structure in HTML5 markup.
 *
 * This file is a core Genesis file and should not be edited.
 *
 * @category Genesis
 * @package  Templates
 * @author   WP Realm
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://wprealm.com
 */

?><section id="sidebar" class="sidebar widget-area" role="complementary">
<?php
	genesis_structural_wrap( 'sidebar' );
	do_action( 'genesis_before_sidebar_widget_area' );
	do_action( 'genesis_sidebar' );
	do_action( 'genesis_after_sidebar_widget_area' );
	genesis_structural_wrap( 'sidebar', 'close' );
?>
</section>
