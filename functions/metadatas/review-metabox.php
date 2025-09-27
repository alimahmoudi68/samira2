<?php 
defined( 'ABSPATH' ) || exit;

add_action( 'cmb2_admin_init', 'cmb2_review_metaboxes');

function cmb2_review_metaboxes() {

	$videoBox = new_cmb2_box( array(
		'id'            => 'video_review_box_metabox',
		'title'         => __( 'ویدیوی نظر مشتری', 'cmb2' ),
		'object_types'  => array( 'review', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	// Regular text field
	$videoBox->add_field( array(
		'name'       => __( 'فایل ویدیو', 'cmb2' ),
		'id'         => 'review_video',
		'type'       => 'file',
        'desc'    => 'ویدیو مشتری را آپلود کنید یا آدرس را بدهید',
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'آپلود فایل' // Change upload button text. Default: "Add or Upload File"
        ),

		
	) );

}

