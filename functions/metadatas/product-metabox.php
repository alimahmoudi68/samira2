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


// -------- certificate settings -------------
add_action( 'cmb2_admin_init', 'cmb2_certificate_product_metaboxes' );

function cmb2_certificate_product_metaboxes() {

	// metabox
	$certificate_box = new_cmb2_box( array(
		'id'            => 'certificate_product_box_metabox',
		'title'         => __( 'تنظیمات مدرک', 'cmb2' ),
		'object_types'  => array( 'product', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	// Template image
	$certificate_box->add_field( array(
		'name'       => __( 'عکس Template مدرک', 'cmb2' ),
		'id'         => 'certificate_template_image_id',
		'type'       => 'file',
		'desc'       => 'عکس template مدرک را آپلود کنید. این عکس به عنوان پس‌زمینه مدرک استفاده می‌شود.',
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
		'text'    => array(
			'add_upload_file_text' => 'آپلود عکس Template'
		),
		'query_args' => array(
			'type' => 'image',
		),
		'preview_size' => 'medium',
	) );

	// Section: تنظیمات نام کاربر
	$certificate_box->add_field( array(
		'name' => 'تنظیمات نام کاربر',
		'desc' => 'تنظیمات مربوط به نمایش نام کاربر روی مدرک',
		'type' => 'title',
		'id'   => 'certificate_name_settings_title'
	) );

	$certificate_box->add_field( array(
		'name'    => 'موقعیت X نام',
		'desc'    => 'موقعیت افقی نام (از چپ). برای پیدا کردن موقعیت دقیق، از ابزار انتخاب مختصات استفاده کنید.',
		'default' => '',
		'id'      => 'certificate_name_x',
		'type'    => 'text_small',
		'attributes' => array(
			'type' => 'number',
			'step' => '1',
			'min' => '0',
		),
	) );

	$certificate_box->add_field( array(
		'name'    => 'موقعیت Y نام',
		'desc'    => 'موقعیت عمودی نام (از بالا). برای پیدا کردن موقعیت دقیق، از ابزار انتخاب مختصات استفاده کنید.',
		'default' => '',
		'id'      => 'certificate_name_y',
		'type'    => 'text_small',
		'attributes' => array(
			'type' => 'number',
			'step' => '1',
			'min' => '0',
		),
	) );

	$certificate_box->add_field( array(
		'name'    => 'اندازه فونت نام',
		'desc'    => 'اندازه فونت نام (پیکسل)',
		'default' => '60',
		'id'      => 'certificate_name_font_size',
		'type'    => 'text_small',
		'attributes' => array(
			'type' => 'number',
			'step' => '1',
			'min' => '10',
			'max' => '200',
		),
	) );

	$certificate_box->add_field( array(
		'name'    => 'حداکثر عرض نام',
		'desc'    => 'حداکثر عرض نام (پیکسل). 0 به معنای نامحدود است.',
		'default' => '0',
		'id'      => 'certificate_name_max_width',
		'type'    => 'text_small',
		'attributes' => array(
			'type' => 'number',
			'step' => '1',
			'min' => '0',
		),
	) );

	$certificate_box->add_field( array(
		'name'    => 'رنگ نام',
		'desc'    => 'رنگ متن نام (hex)',
		'default' => '#000000',
		'id'      => 'certificate_name_color',
		'type'    => 'colorpicker',
	) );

	// Section: تنظیمات عکس کاربر
	$certificate_box->add_field( array(
		'name' => 'تنظیمات عکس کاربر',
		'desc' => 'تنظیمات مربوط به نمایش عکس کاربر روی مدرک',
		'type' => 'title',
		'id'   => 'certificate_user_image_settings_title'
	) );

	$certificate_box->add_field( array(
		'name'    => 'موقعیت X عکس کاربر',
		'desc'    => 'موقعیت افقی عکس کاربر (از چپ). برای پیدا کردن موقعیت دقیق، از ابزار انتخاب مختصات استفاده کنید.',
		'default' => '100',
		'id'      => 'certificate_user_image_x',
		'type'    => 'text_small',
		'attributes' => array(
			'type' => 'number',
			'step' => '1',
			'min' => '0',
		),
	) );

	$certificate_box->add_field( array(
		'name'    => 'موقعیت Y عکس کاربر',
		'desc'    => 'موقعیت عمودی عکس کاربر (از بالا). برای پیدا کردن موقعیت دقیق، از ابزار انتخاب مختصات استفاده کنید.',
		'default' => '100',
		'id'      => 'certificate_user_image_y',
		'type'    => 'text_small',
		'attributes' => array(
			'type' => 'number',
			'step' => '1',
			'min' => '0',
		),
	) );

	$certificate_box->add_field( array(
		'name'    => 'عرض عکس کاربر',
		'desc'    => 'عرض عکس کاربر (پیکسل)',
		'default' => '200',
		'id'      => 'certificate_user_image_width',
		'type'    => 'text_small',
		'attributes' => array(
			'type' => 'number',
			'step' => '1',
			'min' => '1',
		),
	) );

	$certificate_box->add_field( array(
		'name'    => 'ارتفاع عکس کاربر',
		'desc'    => 'ارتفاع عکس کاربر (پیکسل)',
		'default' => '200',
		'id'      => 'certificate_user_image_height',
		'type'    => 'text_small',
		'attributes' => array(
			'type' => 'number',
			'step' => '1',
			'min' => '1',
		),
	) );

	$certificate_box->add_field( array(
		'name'    => 'شعاع گوشه‌های گرد',
		'desc'    => 'شعاع گرد کردن گوشه‌های عکس کاربر (پیکسل)',
		'default' => '20',
		'id'      => 'certificate_user_image_border_radius',
		'type'    => 'text_small',
		'attributes' => array(
			'type' => 'number',
			'step' => '1',
			'min' => '0',
		),
	) );

	// ابزار انتخاب مختصات
	$certificate_box->add_field( array(
		'name' => 'ابزار انتخاب مختصات',
		'desc' => 'برای پیدا کردن موقعیت دقیق، ابتدا عکس template را آپلود کنید، سپس روی دکمه زیر کلیک کنید. یک باکس قابل جابجایی روی تصویر نمایش داده می‌شود که می‌توانید آن را با موس جابجا کنید و در موقعیت مناسب قرار دهید. مختصات به صورت خودکار در فیلدهای مربوطه قرار می‌گیرد.',
		'type' => 'title',
		'id'   => 'certificate_coordinate_picker_title'
	) );

	// این فیلد فقط برای نمایش ابزار استفاده می‌شود
	$certificate_box->add_field( array(
		'name' => '',
		'desc' => '<div id="certificate-coordinate-picker-container" style="margin: 15px 0;">
			<button type="button" id="certificate-picker-btn-name" class="button" style="margin-right: 10px;">انتخاب موقعیت نام</button>
			<button type="button" id="certificate-picker-btn-image" class="button">انتخاب موقعیت عکس کاربر</button>
			<button type="button" id="certificate-picker-reset" class="button" style="margin-right: 10px; display: none;">بازنشانی</button>
			<div id="certificate-picker-preview" style="margin-top: 15px; display: none; position: relative;">
				<div style="position: relative; display: inline-block;">
					<img id="certificate-picker-image" style="max-width: 100%; border: 2px solid #0073aa; display: block;" />
					<!-- باکس قابل جابجایی برای نام -->
					<div id="certificate-picker-name-box" style="display: none; position: absolute; cursor: move; border: 2px dashed #0073aa; background: rgba(0, 115, 170, 0.1); padding: 10px; min-width: 150px; text-align: center; pointer-events: auto;">
						<div id="certificate-picker-name-text" style="font-weight: bold; color: #0073aa;">نام نمونه</div>
					</div>
					<!-- باکس قابل جابجایی برای عکس کاربر -->
					<div id="certificate-picker-image-box" style="display: none; position: absolute; cursor: move; border: 2px dashed #ff6b6b; background: rgba(255, 107, 107, 0.1); pointer-events: auto;">
						<div style="width: 100px; height: 100px; background: #ff6b6b; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 11px; text-align: center; padding: 5px;">عکس کاربر</div>
					</div>
				</div>
				<p id="certificate-picker-instruction" style="margin-top: 10px; color: #666;"></p>
			</div>
		</div>',
		'type' => 'title',
		'id'   => 'certificate_coordinate_picker_tool'
	) );
}

// Enqueue JavaScript for coordinate picker
add_action( 'admin_enqueue_scripts', 'enqueue_certificate_coordinate_picker_script' );
function enqueue_certificate_coordinate_picker_script( $hook ) {
	// فقط در صفحه ویرایش محصول
	if ( $hook !== 'post.php' && $hook !== 'post-new.php' ) {
		return;
	}
	
	global $post_type;
	if ( $post_type !== 'product' ) {
		return;
	}

	wp_enqueue_script(
		'certificate-coordinate-picker',
		get_template_directory_uri() . '/js/admin/certificate-coordinate-picker.js',
		array( 'jquery' ),
		'1.0.0',
		true
	);

	// Localize script برای ajaxurl
	wp_localize_script( 'certificate-coordinate-picker', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}

// AJAX handler برای دریافت URL attachment
add_action( 'wp_ajax_get_attachment_url', 'get_attachment_url_ajax_handler' );
function get_attachment_url_ajax_handler() {
	$attachment_id = isset( $_POST['attachment_id'] ) ? intval( $_POST['attachment_id'] ) : 0;
	
	if ( ! $attachment_id ) {
		wp_send_json_error( array( 'message' => 'Attachment ID is required' ) );
	}

	$url = wp_get_attachment_url( $attachment_id );
	
	if ( $url ) {
		wp_send_json_success( array( 'url' => $url ) );
	} else {
		wp_send_json_error( array( 'message' => 'Attachment not found' ) );
	}
}

?>