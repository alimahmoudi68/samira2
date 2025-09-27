<?php 
add_action( 'cmb2_admin_init', 'cmb2_sample_metaboxes' );


function cmb2_sample_metaboxes() {

	$radio = new_cmb2_box( array(
		'id'            => 'radio_box_metabox',
		'title'         => __( 'آپلود رادیو', 'cmb2' ),
		'object_types'  => array( 'radio', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	// Regular text field
	$radio->add_field( array(
		'name'       => __( 'فایل رادیو', 'cmb2' ),
		'id'         => 'radio',
		'type'       => 'file',
        'desc'    => 'فایل را آپلود کنید یا آدرس را بدهید',
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'آپلود فایل' // Change upload button text. Default: "Add or Upload File"
        ),
	) );


    $time = new_cmb2_box( array(
		'id'            => 'time_metabox',
		'title'         => __( 'زمان', 'cmb2' ),
		'object_types'  => array( 'radio', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

    	// Regular text field
	$time->add_field( array(
		'name'       => __( 'زمان رادیو', 'cmb2' ),
		'desc'       => __( 'زمان رادیو را وارد کنیپد', 'cmb2' ),
		'id'         => 'time',
		'type'       => 'text',
		'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );


        


}

?>