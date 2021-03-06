<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category WP Realm
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'wpr_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function wpr_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_wpr_';

	/**
	 * Post Lead Box
	 */
	$meta_boxes[] = array(
		'id'         => 'post_lead',
		'title'      => 'Lead text',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'core',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Lead text',
				'desc' => 'Add your lead text here',
				'id'   => $prefix . 'lead_text',
				'type'    => 'wysiwyg',
				'options' => array(	'textarea_rows' => 5, ),
			),
		)
	);
	
	/**
	 * Event / Map metabox
	 */
	$meta_boxes[] = array(
		'id'         => 'event_map',
		'title'      => 'Event data',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'core',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Event Title',
				'desc' => 'Title of the event',
				'id'   => $prefix . 'event_title',
				'type' => 'text',
			),
			array(
				'name' => 'Event Location',
				'desc' => 'Event location',
				'id'   => $prefix . 'event_location',
				'type' => 'text',
			),
			array(
				'name' => 'Event date(s)',
				'desc' => 'Date of the Event',
				'id'   => $prefix . 'event_date',
				'type' => 'text',
			),
			array(
				'name' => 'Event Link',
				'desc' => 'Link to the website of the Event',
				'id'   => $prefix . 'event_link',
				'type' => 'text',
			),
			array(
				'name' => 'Event description',
				'desc' => 'Description of the Event',
				'id'   => $prefix . 'event_description',
				'type' => 'text',
			),
		)
	);
	
	/**
	 * Featured Video Metabox
	 */
	$meta_boxes[] = array(
		'id'         => 'featured_video_metabox',
		'title'      => 'Featured Video',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'side',
		'priority'   => 'low',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Link',
				'desc' => 'Add full YouTube or Vimeo url',
				'id'   => $prefix . 'featured_video',
				'type' => 'text',
			),
		)
	);

	// Add other metaboxes as needed

	return $meta_boxes;
}



add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once CHILD_DIR . '/lib/metabox/init.php';

}