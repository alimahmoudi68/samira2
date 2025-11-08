<?php 


add_action( 'cmb2_admin_init', 'cmb2_additional_portfolio_metaboxes' );

function cmb2_additional_portfolio_metaboxes() {
$video_box = new_cmb2_box( array(
	'id'            => 'additional_portfolio_box_metabox',
	'title'         => __( 'ویدیو', 'cmb2' ),
	'object_types'  => array( 'portfolio', ), // Post type
	'context'       => 'normal',
	'priority'      => 'high',
	'show_names'    => true, // Show field names on the left
	// 'cmb_styles' => false, // false to disable the CMB stylesheet
	// 'closed'     => true, // Keep the metabox closed by default
) );


$video_box->add_field( array(
    'name'       => __( 'فیلم نمونه کار', 'cmb2' ),
    'id'         => 'portfolio_video',
    'type'       => 'file',
    'desc'    => 'فیلم نمونه را آپلود کنید یا آدرس را بدهید',
    'options' => array(
        'url' => true, // Hide the text input for the url
    ),
    'text'    => array(
        'add_upload_file_text' => 'آپلود فایل' // Change upload button text. Default: "Add or Upload File"
    ),
) );


}
