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
	wp_enqueue_script('neshan_js', "https://static.neshan.org/sdk/mapboxgl/v1.13.2/neshan-sdk/v1.1.1/index.js" , array() , false , true );
	wp_enqueue_style('neshan_css' , "https://static.neshan.org/sdk/mapboxgl/v1.13.2/neshan-sdk/v1.1.1/index.css" , array() , false , 'all');
	wp_enqueue_script('master' , get_template_directory_uri().'/js/master.js' , array('neshan_js') , false , true);



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
	if ( $current_url  == get_site_url() ) {
		wp_enqueue_script('typewriter', get_template_directory_uri() . '/js/typewriter.js' , array() , false , true );
		wp_enqueue_script('swiper.min', "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" , array() , false , true );
		wp_enqueue_style('swiper.min' , 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css' , array() , false , 'all');
		wp_enqueue_script('index', get_template_directory_uri() . '/js/index.js' , array('swiper.min') , false , true );
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



// ------- for card product -------
function get_total_time_course($all_episodes){

	$totalSeconds =  0;

	foreach($all_episodes as $episode) {

		list($minutes, $seconds) = explode(":", $episode['episode_product_time']);
		$totalSeconds += $minutes *  60 + $seconds;
	}

	$totalHours = floor($totalSeconds /  3600);
	$totalMinutes =  floor(($totalSeconds % 3600) / 60);
	$remainingSeconds = $totalSeconds %  60;

	$result = sprintf("%02d:%02d:%02d", $totalHours , $totalMinutes, $remainingSeconds);
	
	return $result;
}

// ------- get sale count of product -------
function get_product_sales_count( $product_id ) {
    $product = wc_get_product( $product_id );
    return $product->get_total_sales();
}



// set title
function set_courses_title() {
	if (get_query_var('all_course')) {
	$title =  get_bloginfo('title').'-'.'دوره ها';
	}else{
		$title =  get_bloginfo('title');
	}
	return $title;
}
add_filter( 'document_title', 'set_courses_title', 11 );



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


// fehrestha
function register_my_menus() {
	register_nav_menus(
		array(
		'header_left' => __( 'سمت چپ هدر' ),
		)
	);    
}
add_action( 'init', 'register_my_menus' );


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


// lenth preview blog post
function custom_excerpt_length($excerpt) {
    if (has_excerpt()) {
        $excerpt = wp_trim_words(get_the_excerpt(), apply_filters("excerpt_length", 100));
    }
    return $excerpt;
}
add_filter("the_excerpt", "custom_excerpt_length", 999);


// حذف محصولات مرتبط
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


// حذف کلمه تومان
function avia_remove_wc_currency_symbol( $currency_symbol, $currency ) {
	if (is_single()) {
		 $currency_symbol = '';
		 return $currency_symbol;
	} else {
		$currency_symbol = '';
		return $currency_symbol;
	}
	}
//add_filter('woocommerce_currency_symbol', 'avia_remove_wc_currency_symbol', 10, 2);


// تغییرات تب
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['reviews'] ); // Remove the reviews tab
    return $tabs;
}


// حذف محصولات مشابه در سبد خرید
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );


// حذف فیلد های اضافی چک اوت
function wc_remove_checkout_fields( $fields ) {
	unset( $fields['billing']['billing_email'] );
	unset( $fields['billing']['billing_state'] );
	unset( $fields['billing']['billing_country'] );
	unset( $fields['billing']['billing_company'] );
	unset( $fields['billing']['billing_address_1'] );
	unset( $fields['billing']['billing_address_2'] );
	unset( $fields['billing']['billing_city'] );
	unset( $fields['billing']['billing_postcode'] );
	return $fields;
}
add_filter('woocommerce_checkout_fields', 'wc_remove_checkout_fields' );



// برای نشان دادن تاکسونومی های پست تایپ تیوی در ارشیو
add_action( 'pre_get_posts', function ( WP_Query $query ) {
    if ( $query->is_main_query() && $query->is_tax( 'tv-cat' ) ) {
        $query->set( 'post_type', [ 'tv' ] );
    }
} );


// برای داشتن پجینیشن در صفحه سینگل تیچر
function mytheme_template_redirect() {
    if(is_singular('teacher')) {
        global $wp_query;
        $page = (int)$wp_query->get('page');
        if($page > 1) {
            $query->set('page', 1);
            $query->set('paged', $page);
        }
        remove_action('template_redirect', 'redirect_canonical');
    }
}
add_action('template_redirect', 'mytheme_template_redirect', 0);


// اپدیت خودکار بعد از اضفه یا کم کردن سبد خرید
add_action( 'wp_footer', 'update_cart_on_item_qty_change');
function update_cart_on_item_qty_change() {
    if (is_cart()) :
    ?>
    <script type="text/javascript">
  jQuery( function( $ ) {
	let timeout;
	$('.woocommerce').on( 'change', 'input.qty', function(){
		if ( timeout !== undefined ) {
			clearTimeout( timeout );
		}
		timeout = setTimeout(function() {
			$("[name='update_cart']").trigger("click"); // trigger cart update
		}, 1000 ); // 1 second delay, half a second (500) seems comfortable too
	});
} );
    </script>
    <?php
    endif;
}



// آپدیت خودکار تعداد کارت در هدر
add_filter( 'woocommerce_add_to_cart_fragments', 'refresh_cart_count', 50, 1 );
function refresh_cart_count( $fragments ){
    ob_start();
    ?>
    <span id="cart-count" class="w-[17px] h-[17px] leading-[15px] text-[0.7rem] absolute top-[-4px] right-[4px] rounded-full bg-primary-100 px-[4px] py-[1px] tex-sm text-textPrimary-100"><?php
    $cart_count = WC()->cart->get_cart_contents_count();
    echo sprintf ( _n( '%d', '%d', $cart_count ), $cart_count );
    ?></span>

    <?php
     $fragments['#cart-count'] = ob_get_clean();

    return $fragments;
}


add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {

    ob_start();
    ?>

	<div id="mini-cart" class="w-full h-full cart-list flex flex-col justify-between">
        <?php woocommerce_mini_cart(); ?>
    </div>
    <?php $fragments['#mini-cart'] = ob_get_clean();

    return $fragments;

} );


//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'crunchify_disable_woocommerce_loading_css_js' );
function crunchify_disable_woocommerce_loading_css_js() {
    // Check if WooCommerce plugin is active
    if( function_exists( 'is_woocommerce' ) ){
        // Check if it's any of WooCommerce page
        if(! is_woocommerce() && ! is_cart() && ! is_checkout() ) {         
            
            ## Dequeue WooCommerce styles
            wp_dequeue_style('woocommerce-layout'); 
            wp_dequeue_style('woocommerce-general'); 
            wp_dequeue_style('woocommerce-smallscreen');     
            ## Dequeue WooCommerce scripts
            wp_dequeue_script('wc-cart-fragments');
            wp_dequeue_script('woocommerce'); 
            wp_dequeue_script('wc-add-to-cart'); 
        
            wp_deregister_script( 'js-cookie' );
            wp_dequeue_script( 'js-cookie' );
        }
    }    
}





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


// add_filter( 'woocommerce_get_endpoint_url', function ( $url, $endpoint, $value, $permalink ) {
//     if ( $endpoint === 'my-courses' ) {
//         $url = home_url( 'my-account/licenses/' );
//     }
//     return $url;
// }, 10, 4 );


function title_filter( $where, $wp_query ){
    global $wpdb;
    if ( $search_term = $wp_query->get( 'search_prod_title' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $search_term ) ) . '%\'';
    }
    return $where;
}


//------------- ajax add to cart ---------------
add_action('wp_ajax_ql_woocommerce_ajax_add_to_cart', 'ql_woocommerce_ajax_add_to_cart'); 
add_action('wp_ajax_nopriv_ql_woocommerce_ajax_add_to_cart', 'ql_woocommerce_ajax_add_to_cart');          
function ql_woocommerce_ajax_add_to_cart() {  
    $product_id = apply_filters('ql_woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    //$variation_id = absint($_POST['variation_id']);
    $passed_validation = apply_filters('ql_woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id); 
    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) { 
        do_action('ql_woocommerce_ajax_added_to_cart', $product_id);
            if ('yes' === get_option('ql_woocommerce_cart_redirect_after_add')) { 
                wc_add_to_cart_message(array($product_id => $quantity), true);   


            } 
            WC_AJAX :: get_refreshed_fragments(); 
            } else { 
                $data = array( 
                    'error' => true,
                    'product_url' => apply_filters('ql_woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));
                echo wp_send_json($data);
            }
            wp_die();
        }
//------------- /ajax add to cart ---------------


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


// ---- in checkout pgae redirect to login page if user not login ----------
add_action( 'template_redirect', function() {
    if ( ! is_user_logged_in() && ( is_checkout() ) ) {
        wp_redirect( home_url( '/auth?redirect=checkout' ) );
        exit;
    }
} );

// ------- Disable Autocomplete For Billing Phone @ WooCommerce Checkout ---------
add_filter( 'woocommerce_checkout_fields', 'bbloomer_disable_autocomplete_checkout_fields' );
function bbloomer_disable_autocomplete_checkout_fields( $fields ) {
    $fields['billing']['billing_phone']['autocomplete'] = false;
    return $fields;
}


//------------Remove required field requirement for first/last name in My Account Edit form ------------
add_filter('woocommerce_save_account_details_required_fields', 'remove_required_fields');

function remove_required_fields( $required_fields ) {
	unset($required_fields['account_email']);

	return $required_fields;
}


// ----------- send sms when user payment successfully ------------------
function get_product_names_by_order_id($order_id) {
    $product_names = array();

    $order = wc_get_order($order_id);
    
    if ($order) {
        foreach ($order->get_items() as $item_id => $item) {
            $product = $item->get_product();
            if ($product) {
                $product_names[] = $product->get_name();
            }
        }
    }

    return $product_names;
}

function get_customer_id_by_order_id($order_id) {
    $order = wc_get_order($order_id);
    
    if ($order) {
        $customerId =  $order->get_customer_id();
    }

    return null;
}

add_action('woocommerce_thankyou', 'custom_function_after_payment', 10, 1);
function custom_function_after_payment($order_id) {
    $order = wc_get_order($order_id);

    // Check if the order is valid
    if ($order) {

		$customer_id =  get_customer_id_by_order_id($order_id);
		$customer_phone =  get_user_meta( $customer_id , 'digits_phone' , true);

		//snd sms
		global $my_opt;
		$username = $my_opt['opt-sms-username'];
		$password = $my_opt['opt-sms-password'];
		$from = $my_opt['opt-sms-number-output'];
		$pattern_code = $my_opt['opt-sms-pattern-buy'];

		$input_data = [
		'customer' => get_user_meta( $customer_id , 'first_name' , true),
		'course' => get_product_names_by_order_id($order_id)
		];
		$to = array( $customer_phone );
		$url = 'https://ippanel.com/patterns/pattern?username=' . $username . '&password=' . urlencode($password) . "&from=$from&to=" . json_encode($to) . '&input_data=' . urlencode(json_encode($input_data)) . '&pattern_code=' . $pattern_code;
		$handler = curl_init($url);
		curl_setopt($handler, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($handler);

    }
}


// create tables
require_once dirname( __FILE__ ) . '/functions/createTables.php';



?>