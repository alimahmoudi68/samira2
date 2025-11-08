<?php

// redux
require_once get_template_directory() . '/functions/redux.php';

// cmb2
require_once dirname( __FILE__ ) . '/cmb2/init.php';



// rewrites
require_once dirname( __FILE__ ) . '/functions/rewrites.php';

	
// restfull api
require_once dirname( __FILE__ ) . '/functions/api.php';

// portfolio post type
require_once dirname( __FILE__ ) . '/functions/portfolio.php';


function my_custom_scripts() {
    // Create a nonce for your API
    wp_localize_script('your-script-handle', 'myApi', [
        'nonce' => wp_create_nonce('wp_rest')
    ]);
}
add_action('wp_enqueue_scripts', 'my_custom_scripts');


// incluse css and js
function add_theme_scripts(){
	wp_enqueue_style('fontiran' , get_template_directory_uri().'/css/fontiran.css' , array() , false , 'all');
	wp_enqueue_style('style2' ,  get_template_directory_uri().'/css/style2.css' , array() , false , 'all');
	wp_enqueue_style('style' , get_stylesheet_uri() , array() , false , 'all');
	wp_enqueue_style( 'dynamic-styles', get_template_directory_uri() . '/dynamic-styles.php', array(), null );
	wp_enqueue_script('master' , get_template_directory_uri().'/js/master.js' , array() , false , true);



	if ( get_query_var('auth') ) {
		wp_enqueue_style('sweetalertStyles' ,  get_template_directory_uri().'/css/sweetalert.css' , array() , false , 'all');
		wp_enqueue_script('axios' , get_template_directory_uri().'/js/axios.js' , array() , false , true);
		wp_enqueue_script( 'auth', get_template_directory_uri() . '/js/auth-page.js' , array() , false , true );

		wp_localize_script('auth', 'nonces', [
			'nonce_send_phone' => wp_create_nonce('send_phone') ,
			'nonce_send_code' => wp_create_nonce('send_code'),
			'nonce_send_name' => wp_create_nonce('send_name')
		]);

	}
	if ( get_query_var('all_course')  ) {
		wp_enqueue_script( 'price-slider', get_stylesheet_directory_uri() . '/js/price-slider.js' , array() , false , true );
		wp_enqueue_script('alpinejs_collaps', "https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js" , array() , false , true );
		wp_enqueue_script('alpinejs', "https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" , array() , false , true );
		wp_enqueue_script('axios' , get_template_directory_uri().'/js/axios.js' , array() , false , true);
	}

	global $wp;
	$current_url = home_url(add_query_arg(array(), $wp->request));
	// if ( $current_url  == get_site_url() ) {
	if (is_home()) {
		wp_enqueue_script('swiper.min', "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" , array() , false , true );
		wp_enqueue_style('swiper.min' , 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css' , array() , false , 'all');
		wp_enqueue_script('index', get_template_directory_uri() . '/js/index.js' , array('swiper.min') , false , true );
	}


	if ( is_product() ) {
        wp_enqueue_script('axios' , get_template_directory_uri().'/js/axios.js' , array() , false , true);
        wp_enqueue_script('notyf-js', get_template_directory_uri() . '/js/notyf.min.js' , array() , false , true );
        wp_enqueue_style('notyf-css' , get_template_directory_uri().'/css/notyf.min.css' , array() , false , 'all');
        wp_enqueue_script( 'single-course', get_stylesheet_directory_uri() . '/js/single-course.js' , array('notyf-js') , false , true );
    }

	$url = [
		'base_url' => home_url()
	];
	wp_add_inline_script(
		'auth' ,
		'const url=' . json_encode($url)  ,
		'before'
	);

	wp_add_inline_script(
		'courses' ,
		'const home_url=' . json_encode($url)  ,
		'before'
	);

	global $my_opt;

	$location = [
		'title' =>  get_bloginfo('name') ,
		'long' => $my_opt['opt-long'] ,
		'lat' => $my_opt['opt-lat'] ,
	];
	wp_add_inline_script(
		'master' ,
		'const loc=' . json_encode($location)  ,
		'before'
	);


	//wp_enqueue_script('single-course' , get_template_directory_uri().'/js/single-course.js' , array() , false , true);

}
add_action('wp_enqueue_scripts' , 'add_theme_scripts');






//- ----- admin ticket styles and scripts ------------
if(is_admin()){
    // admin styles
    function add_admin_styles(){
        wp_enqueue_style('admin-panel' , get_template_directory_uri().'/css/admin/admin-panel.css' , array() , false , 'all');
    }
    add_action('admin_enqueue_scripts' , 'add_admin_styles');


    // admin scripts
    function add_admin_scripts(){
        wp_enqueue_media();
        wp_enqueue_script('admin-tickets-script' , get_template_directory_uri().'/js/admin/admin-tickets-script.js' , ['jquery'] , false , true);
    }
    add_action('admin_enqueue_scripts' , 'add_admin_scripts');

}


// fehrestha - moved to functions/menu.php


function my_setup(){
	add_theme_support('title-tag');  
	add_theme_support('post-thumbnails'); 
	add_theme_support('woocommerce');
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	add_image_size('post' ,'800' , '600' , true ); 
	add_image_size('profile' ,'32' , '32' , true ); 
	add_image_size('teacher' ,'64' , '64' , true ); 
	add_image_size('top-teacher' ,'300' , '300' , true ); 
	add_image_size('single-course' ,'500' , '500' , true ); 
	add_image_size('portfolio-thumb', 600, 600, true);

}
add_action('after_setup_theme' , 'my_setup');


// tutor post type
function my_tutor_post_type(){
	$labels1 =  array(
		'name' => 'مدرسان دوره',
		'singular_name' => 'مدرس دوره',
		'menu_name' => 'مدرسان دوره',
		'name_admin_bar' => 'مدرسان دوره',
		'add_new' => 'افزودن',
		'add_new_item' => 'افزودن مدرس دوره',
		'new_item' => 'مدرس دوره جدید',
		'edit_item' => 'ویرایش مدرس دوره',
		'view_item' => 'مشاهده مدرس دوره',
		'all_items' => 'تمام مدرسان دوره',
		'search_items' => 'جستجوی مدرس دوره', 
		'parent_item_colon' => 'مادر',
		'not_found' => 'مدرس دوره ای پیدا نشد',
		'not_found_in_trash' => 'مدرس دوره ای در سطل زباله یافت نشد ',
	);
	register_post_type('tutor' , array(
		'public' => true ,
		'labels' => $labels1 , 
		'exclude_from_search' => true , 
		'menu_icon' => 'dashicons-admin-users',
		'has_archive' => true,
		'rewrite'     => array( 'slug' => 'tutors' ),
		'supports' => array('title' , 'editor' , 'author' , 'thumbnail' , 'excerpt' , 'comments'),
	)
	);
}
add_action('init' , 'my_tutor_post_type');



//  review post type
function my_review_post_type(){
	$labels1 =  array(
		'name' => 'نظرات مشتریان',
		'singular_name' => 'نظر مشتری',
		'menu_name' => 'نظرات مشتریان',
		'name_admin_bar' => 'نظرات مشتریان',
		'add_new' => 'افزودن',
		'add_new_item' => 'افزودن نظر مشتری',
		'new_item' => 'نظر مشتری جدید',
		'edit_item' => 'ویرایش نظر مشتری',
		'view_item' => 'مشاهده نظر مشتری',
		'all_items' => 'تمام نظرات مشتریان',
		'search_items' => 'جستجوی نظر مشتری', 
		'parent_item_colon' => 'مادر',
		'not_found' => 'نظر مشتری ای پیدا نشد',
		'not_found_in_trash' => 'نظر مشتری ای در سطل زباله یافت نشد',
	);
	register_post_type('review' , array(
		'public' => true ,
		'labels' => $labels1 , 
		'exclude_from_search' => true , 
		'menu_icon' => 'dashicons-email',
		'has_archive' => true,
		'rewrite'     => array( 'slug' => 'review' ),
		'supports' => array('title' , 'editor' ,'thumbnail' , ),
	)
	);
}
add_action('init' , 'my_review_post_type');




// برای نشان دادن تاکسونومی های پست تایپ تیوی در ارشیو
add_action( 'pre_get_posts', function ( WP_Query $query ) {
    if ( $query->is_main_query() && $query->is_tax( 'tv-cat' ) ) {
        $query->set( 'post_type', [ 'tv' ] );
    }
} );





function my_account_menu_order() {
    $menuOrder = array(
       'dashboard' => __( 'Dashboard', 'woocommerce' ),
       'orders' => __( 'Orders', 'woocommerce'),
	   'edit-account' => __( 'ویرایش حساب کاربری', 'woocommerce' ),
       'customer-logout' => __( 'Logout', 'woocommerce' ),
  );
 return $menuOrder;
}
add_filter ( 'woocommerce_account_menu_items', 'my_account_menu_order');



function title_filter( $where, $wp_query ){
    global $wpdb;
    if ( $search_term = $wp_query->get( 'search_prod_title' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $search_term ) ) . '%\'';
    }
    return $where;
}


function get_user_ip() {
    // Check if the user is behind a proxy
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // If the user is behind a proxy, use the HTTP_CLIENT_IP header
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // If the user is behind a proxy, use the HTTP_X_FORWARDED_FOR header
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // If the user is not behind a proxy, use the REMOTE_ADDR header
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    // Return the IP address
    return $ip;
}


// tickets
//require_once dirname( __FILE__ ) . '/functions/tickets/tickets.php';

// metadatas
require_once dirname( __FILE__ ) . '/functions/metadatas/product-metabox.php';
require_once dirname( __FILE__ ) . '/functions/metadatas/tutor-metabox.php';
require_once dirname( __FILE__ ) . '/functions/metadatas/review-metabox.php';
require_once dirname( __FILE__ ) . '/functions/metadatas/portfolio.php';


// menu functions
require_once dirname( __FILE__ ) . '/functions/menu.php';

// rewrites
require_once dirname( __FILE__ ) . '/functions/courses_rewrite.php';


/**
 * Change the breadcrumb separator
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_delimiter' );
function wcc_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'
	$defaults['delimiter'] = '';
	return $defaults;
}



// create tables
require_once dirname( __FILE__ ) . '/functions/createTables.php';

// for woocommerce
require_once dirname( __FILE__ ) . '/functions/forWoocommerce.php';