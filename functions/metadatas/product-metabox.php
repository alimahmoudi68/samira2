<?php 
// -------- video -------------
add_action( 'cmb2_admin_init', 'cmb2_video_product_metaboxes' );

function cmb2_video_product_metaboxes() {

	$video_box = new_cmb2_box( array(
		'id'            => 'video_product_box_metabox',
		'title'         => __( 'ویدیوی معرفی', 'cmb2' ),
		'object_types'  => array( 'product', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	$video_box->add_field( array(
		'name'       => __( 'فایل ویدوی معرفی', 'cmb2' ),
		'id'         => 'product_video',
		'type'       => 'file',
        'desc'    => 'فایل معرفی را آپلود کنید یا آدرس را بدهید',
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'آپلود فایل' // Change upload button text. Default: "Add or Upload File"
        ),
	) );

	$video_box->add_field( array(
		'name'       => __( 'تصویر کاور ویدیو', 'cmb2' ),
		'id'         => 'product_cover_video',
		'type'       => 'file',
        'desc'    => 'فایل معرفی را آپلود کنید یا آدرس را بدهید',
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'آپلود فایل' // Change upload button text. Default: "Add or Upload File"
        ),
	) );

}
// -------- select tutor -------------
add_action( 'cmb2_admin_init', 'cmb2_teacher_product_metaboxes' );

function cmb2_teacher_product_metaboxes() {
$teacher_box = new_cmb2_box( array(
	'id'            => 'teacher_product_box_metabox',
	'title'         => __( 'انتخاب مدرس', 'cmb2' ),
	'object_types'  => array( 'product', ), // Post type
	'context'       => 'normal',
	'priority'      => 'high',
	'show_names'    => true, // Show field names on the left
	// 'cmb_styles' => false, // false to disable the CMB stylesheet
	// 'closed'     => true, // Keep the metabox closed by default
) );

// Regular text field
$args = array(
    'post_type' => 'tutor',
);

$list = array();
$query = new WP_Query( $args ); 
if ( $query->have_posts() ) {
while ( $query->have_posts() ) {
$query->the_post(); 

$ii=get_the_ID();
$list[$ii] = __( get_the_title(), 'cmb2' );

} // end while
} // end if
wp_reset_query();


$teacher_box->add_field( array(
	'name'             => 'مدرس',
	'desc'             => 'یک مدرس را انتخاب کنید',
	'id'               => 'product_teacher',
	'type'             => 'select',
	'show_option_none' => true,
	'default'          => 'custom',
	'options'          => $list,
) );

}


// -------- additional meta -------------
add_action( 'cmb2_admin_init', 'cmb2_additional_product_metaboxes' );

function cmb2_additional_product_metaboxes() {
$additional_box = new_cmb2_box( array(
	'id'            => 'additional_product_box_metabox',
	'title'         => __( 'اطلاعات تکمیلی', 'cmb2' ),
	'object_types'  => array( 'product', ), // Post type
	'context'       => 'normal',
	'priority'      => 'high',
	'show_names'    => true, // Show field names on the left
	// 'cmb_styles' => false, // false to disable the CMB stylesheet
	// 'closed'     => true, // Keep the metabox closed by default
) );


$additional_box->add_field( array(
	'name'             => 'نوع دوره',
	'desc'             => 'نوع دوره را انتخاب کنید',
	'id'               => 'product_type',
	'type'             => 'select',
	'show_option_none' => true,
	'default'          => 'custom',
	'options'          => array(
        'free' => __( 'رایگان', 'cmb2' ),
        'cash'   => __( 'نقدی', 'cmb2' ),
    ),
) );

$additional_box->add_field( array(
	'name'             => 'وضعیت دوره',
	'desc'             => 'وضعیت دوره را انتخاب کنید',
	'id'               => 'product_status',
	'type'             => 'select',
	'show_option_none' => true,
	'default'          => 'custom',
	'options'          => array(
        'soon' => __( 'به زودی', 'cmb2' ),
        'continue'   => __( 'در حال برگزاری', 'cmb2' ),
        'finish'     => __( 'تکمیل ضبط', 'cmb2' ),
    ),
) );

$additional_box->add_field( array(
    'name'    => 'روش پشتیبانی',
    'desc'    => 'روش پشتیانی دوره را بنویسید',
    'default' => '',
    'id'      => 'product_support',
    'type'    => 'text_small'
) );


$additional_box->add_field( array(
    'name'    => 'روش مشاهده',
    'desc'    => 'روش مشاهده دوره را بنویسید',
    'default' => '',
    'id'      => 'product_view',
    'type'    => 'text_small'
) );

$additional_box->add_field( array(
    'name'    => 'درصد تکمیل',
    'desc'    => 'درصد تکمیل دوره را با یک عدد انگلیسی بنویسید',
    'default' => '',
    'id'      => 'product_complete',
    'type'    => 'text_small'
) );


}



// -------- seasons and episodes -------------
add_action( 'cmb2_admin_init', 'cmb2_season_product_metaboxes' );

function cmb2_season_product_metaboxes() {

	// metabox
	$episode_box = new_cmb2_box( array(
		'id'            => 'episodes_product_box_metabox',
		'title'         => __( 'جلسات دوره', 'cmb2' ),
		'object_types'  => array( 'product', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

   // episode group
   $episode_group = $episode_box->add_field( array(
	'id'          => 'episode_group',
	'type'        => 'group',
	'options'     => array(
		'group_title'       => __( 'جلسه {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
		'add_button'        => __( 'افزودن جلسه جدید', 'cmb2' ),
        'remove_button'     => __( 'حذف کردن جلسه', 'cmb2' ),
        'sortable'          => true,
         'closed'         => true, // true to have the groups closed by default
         'remove_confirm' => esc_html__( 'آیا از حذف کردن جلسه اطمینان دارید؟?', 'cmb2' ), // Performs confirmation before removing group.
		),
	) );

	// episode number
	$episode_box->add_group_field($episode_group , array(
		'id'            => 'episode_product_number',
		'name'         => __( 'شماره جلسه', 'cmb2' ),
		'desc'       => __( 'شماره جلسه را وارد کنید', 'cmb2' ),
		'type'    => 'text',
		'priority'      => 'high',
		'attributes' =>  array(
			'placeholder' => ''
		),
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	// episode title
	$episode_box->add_group_field($episode_group , array(
		'id'            => 'episode_product_title',
		'name'         => __( 'عنوان جلسه', 'cmb2' ),
		'desc'       => __( 'عنوان جلسه را وارد کنید', 'cmb2' ),
		'type'    => 'text',
		'priority'      => 'high',
		'attributes' =>  array(
			'placeholder' => ''
		),
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	$episode_box->add_group_field($episode_group , array(
		'name'       => __( 'فایل ویدوی معرفی', 'cmb2' ),
		'id'         => 'episode_product_video',
		'type'       => 'file',
        'desc'    => 'فایل معرفی را آپلود کنید یا آدرس را بدهید',
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'آپلود فایل' // Change upload button text. Default: "Add or Upload File"
        ),
	) );



	// episode time
	$episode_box->add_group_field($episode_group , array(
		'id'            => 'episode_product_time',
		'name'         => __( 'زمان جلسه', 'cmb2' ),
		'desc'       => __( 'زمان جلسه را وارد کنید (به انگلیسی)', 'cmb2' ),
		'type'    => 'text',
		'priority'      => 'high',
		'attributes' =>  array(
			'placeholder' => '02:33'
		),
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );


	$episode_box->add_group_field($episode_group ,   array(
		'name'             => 'نوع قسمت',
		'desc'             => 'نوع قسمت را انتخاب کنید',
		'id'               => 'episode_product_purchase_status',
		'type'             => 'select',
		'show_option_none' => false,
		'default'          => 'free',
		'options'          => array(
			'free' => __( 'رایگان', 'cmb2' ),
			'cash'   => __( 'نقدی', 'cmb2' ),
		),
	) );

	
	$episode_box->add_group_field( $episode_group ,  array(
		'name'             => 'اجباری بودن ثبت نام برای قسمت رایگان',
		'desc'             => 'برای قسمت رایگان اجبار به ثبت نام باشد یا خیر',
		'id'               => 'episode_product_show_status',
		'type'             => 'select',
		'show_option_none' => false,
		'default'          => '1',
		'options'          => array(
			'yes' => __( 'اجباری نیست', 'cmb2' ),
			'no'   => __( 'اجباری است', 'cmb2' ),
		),
	) );
}


// -------- faq -------------
add_action( 'cmb2_admin_init', 'cmb2_faq_product_metaboxes' );

function cmb2_faq_product_metaboxes() {

	// metabox
	$faq_box = new_cmb2_box( array(
		'id'            => 'faq_product_box_metabox',
		'title'         => __( 'سوالات متداول', 'cmb2' ),
		'object_types'  => array( 'product', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

   // faq group
   $faq_group = $faq_box->add_field( array(
	'id'          => 'faq_group',
	'type'        => 'group',
	'options'     => array(
		'group_title'       => __( 'سوال {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
		'add_button'        => __( 'افزودن سوال جدید', 'cmb2' ),
        'remove_button'     => __( 'حذف کردن سوال', 'cmb2' ),
        'sortable'          => true,
         'closed'         => true, // true to have the groups closed by default
         'remove_confirm' => esc_html__( 'آیا از حذف کردن سوال اطمینان دارید؟?', 'cmb2' ), // Performs confirmation before removing group.


		),
	) );

	$faq_box->add_group_field( $faq_group, array(
		'name' => 'عنوان سوال',
		'desc' => 'عنوان سوال را بنویسید',
		'default' => '',
		'id' => 'question_product',
		'type' => 'textarea_small'
	) );

	$faq_box->add_group_field( $faq_group, array(
		'name' => 'جواب',
		'desc' => 'جواب را بنویسید',
		'default' => '',
		'id' => 'answer_product',
		'type' => 'textarea_small'
	) );
}

?>