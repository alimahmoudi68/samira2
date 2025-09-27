<?php
// portfolio post type
function my_portfolio_post_type(){
	$labels1 =  array(
		'name' => 'نمونه کارها',
		'singular_name' => 'نمونه‌کار',
		'menu_name' => 'نمونه کارها',
		'name_admin_bar' => 'نمونه کارها',
		'add_new' => 'افزودن',
		'add_new_item' => 'افزودن نمونه‌کار',
		'new_item' => 'نمونه‌کار جدید',
		'edit_item' => 'ویرایش نمونه‌کار',
		'view_item' => 'مشاهده نمونه‌کار',
		'all_items' => 'تمام نمونه کارها',
		'search_items' => 'جستجوی نمونه‌کار', 
		'parent_item_colon' => 'مادر',
		'not_found' => 'نمونه‌کاری پیدا نشد',
		'not_found_in_trash' => 'نمونه‌کاری در سطل زباله یافت نشد',
	);
	register_post_type('portfolio' , array(
		'public' => true ,
		'labels' => $labels1 , 
		'exclude_from_search' => true , 
		'menu_icon' => 'dashicons-format-gallery',
		'has_archive' => true,
		'rewrite'     => array( 'slug' => 'portfolio' ),
		'supports' => array('title' , 'editor' , 'author' , 'thumbnail' , 'excerpt' , 'comments'),
	)
	);
}
add_action('init' , 'my_portfolio_post_type');

// Add new taxonomy for portfolio post type
function register_portfolio_taxonomy(){
	$labels = array(
		'name' => _x( 'دسته‌بندی', 'دسته‌بندی' ),
		'singular_name' => _x( 'دسته بندی تی‌وی', 'دسته‌بندی' ),
		'search_items' =>  __( 'جستجوری دسته‌بندی‌ها' ),
		'all_items' => __( 'همه دسته‌بندی‌ها' ),
		'parent_item' => __( 'زیر دسته' ),
		'parent_item_colon' => __( 'دسته پدر:' ),
		'edit_item' => __( 'پیرایش دسته' ), 
		'update_item' => __( 'به روز رسانی دسته' ),
		'add_new_item' => __( 'افزودن دسته‌بندی جدید' ),
		'new_item_name' => __( 'عنوان دسته‌بندی جدید' ),
		'menu_name' => __( 'دسته‌بندی‌ها' ),
	);
	$args = array(
		'hierarchical' => true,
		'show_in_rest' => true,
		'show_admin_column' => true,
		'labels'                  => $labels,
		'public'         		  => true,
		'query_var '              => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'has_archive' => true,
	);
	register_taxonomy( 'portfolio-cat', 'portfolio' , $args );
}
add_action('init' , 'register_portfolio_taxonomy');



// افزودن فیلد تصویر در صفحه افزودن دسته‌بندی جدید
function add_portfolio_category_image_field() {
    ?>
    <div class="form-field">
        <label for="portfolio_cat_image"><?php _e('آپلود تصویر دسته‌بندی', 'textdomain'); ?></label>
        <input type="text" name="portfolio_cat_image" id="portfolio_cat_image" value="" class="widefat" />
        <button class="upload_image_button button"><?php _e('انتخاب تصویر', 'textdomain'); ?></button>
        <p class="description"><?php _e('یک تصویر برای این دسته‌بندی انتخاب کنید.', 'textdomain'); ?></p>
    </div>
    <script>
        jQuery(document).ready(function($){
            $('.upload_image_button').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var custom_uploader = wp.media({
                    title: 'انتخاب تصویر دسته‌بندی',
                    button: { text: 'انتخاب' },
                    multiple: false
                }).on('select', function() {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    button.prev().val(attachment.url);
                }).open();
            });
        });
    </script>
    <?php
}
add_action('portfolio-cat_add_form_fields', 'add_portfolio_category_image_field', 10, 2);
