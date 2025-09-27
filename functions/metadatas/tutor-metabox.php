<?php 
// -------- video -------------
add_action( 'cmb2_admin_init', 'cmb2_tutor_metaboxes');

function cmb2_tutor_metaboxes() {

	$aboutTutorBox = new_cmb2_box( array(
		'id'            => 'expert_box_metabox',
		'title'         => __( 'درباره مدرس', 'cmb2' ),
		'object_types'  => array( 'tutor', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );


	$aboutTutorBox ->add_field( array(
		'name'       => __( 'تخصص', 'cmb2' ),
		'desc'       => __( 'تخصص مدرس را وارد کنید', 'cmb2' ),
		'id'         => 'tutor_expert',
		'type'       => 'text',
		'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );

	$aboutTutorBox->add_field( array(
		'name'       => __( 'ویدیوی معرفی', 'cmb2' ),
		'id'         => 'tutor_video',
		'type'       => 'file',
        'desc'    => 'فایل را آپلود کنید یا آدرس را بدهید',
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'آپلود فایل' // Change upload button text. Default: "Add or Upload File"
        ),
	) );


}
