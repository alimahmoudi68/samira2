<?php

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