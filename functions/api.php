<?php 

//----------- convert phone to digits_no in user meta  ------------
function convertToInternationalFormat($phoneNumber) {
    if (preg_match('/^09/', $phoneNumber)) {
        // Replace '0' with '+98'
        $internationalFormat = preg_replace('/^0/', '+98', $phoneNumber);
        return $internationalFormat;
    }
        return null; 
}

function convertToLocalFormat($phoneNumber) {
    if (preg_match('/^09/', $phoneNumber)) {
        // Remove the leading '0'
        $localFormat = preg_replace('/^0/', '', $phoneNumber);
        return $localFormat;
    }
    
    return null; 
}

function convertPersianToEnglish($string) {
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
     
    $output= str_replace($persian, $english, $string);
    return $output;
}



add_action('rest_api_init', 'getProducts');
function getProducts(){
	register_rest_route('myapi/v1', '/products' , array(
		'methods' => 'GET',
	    'callback' => 'get_products_function'
    ));


    function get_products_function($data){

        $page = sanitize_text_field($data['page']);
        $q = sanitize_text_field($data['q']);
        $sort = sanitize_text_field($data['sort']);
        $cat = sanitize_text_field($data['cat']);
        $priceMin = isset($_GET['priceMin']) ? sanitize_text_field($_GET['priceMin']) : '';
        $priceMax = isset($_GET['priceMax']) ? sanitize_text_field($_GET['priceMax']) : '';


        if (!$page) {
            $page = 1;
        }


        if (!empty($q)) {
            $args['s'] = $q;
        }


        add_filter( 'posts_where', 'title_filter', 10, 2 );


    
        $args = array(
            'post_type' =>  'product',
            'post_status' => 'publish',
            'no_found_rows' => true ,
            'posts_per_page' => 20 ,
            'paged' => $page  ,
            'search_prod_title' => $q ,
        );


        if( $cat !== '' ){

            $catArr = explode( ",", $cat ) ; 
        
            $args ['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    =>  $catArr,
                ),
            );
        }



        if(  $sort  == 'expensive'  ){
            $args ['orderby'] = 'meta_value_num';
            $args ['meta_key'] ='_price';
            $args ['order'] = 'desc';
        }

        if(  $sort  == 'cheapest'  ){
            $args ['orderby'] = 'meta_value_num';
            $args ['meta_key'] ='_price';
            $args ['order'] = 'asc';
        }


        // اضافه کردن فیلتر قیمت در محدوده قیمت وارد شده توسط کاربر
        if (!empty($priceMin) || !empty($priceMax)) {
            $price_filter = array('key' => '_price', 'type' => 'NUMERIC');
            
            if (!empty($priceMin)) {
                $price_filter['value'][] = $priceMin;
                $price_filter['compare'] = '>=';
            }
            
            if (!empty($priceMax)) {
                $price_filter['value'][] = $priceMax;
                $price_filter['compare'] = '<=';
            }
            
            if (!empty($priceMin) && !empty($priceMax)) {
                $price_filter['compare'] = 'BETWEEN';
            }

            $args['meta_query'][] = $price_filter;
        }


        // دریافت تمام تاکسونومی‌های محصول به صورت پویا
        $taxonomies = wc_get_attribute_taxonomies(); // همه ویژگیهای محصول را می‌گیرد

        //var_dump( $taxonomies );
        // فیلتر کردن بر اساس ویژگی‌های داینامیک (تاکسونومی‌های محصول)
        foreach ($taxonomies as $taxonomy) {
            $attribute_name = $taxonomy->attribute_name; // ? مثل color
            if (!empty($data[$attribute_name])) { // اگر ویژگی‌ای از درخواست ارسال شده باشد
                $terms = explode(',', sanitize_text_field($data[$attribute_name]));
                // $txonomy = 
                $args['tax_query'][] = array(
                    'taxonomy' => 'pa_'.$attribute_name,
                    'field' => 'slug',
                    'terms' =>  $terms,
                );
            }
        }

        // تنظیم نوع رابطه در tax_query در صورت وجود چندین فیلتر
        if (!empty($args['tax_query'])) {
            $args['tax_query']['relation'] = 'AND';
        }

        //var_dump( $args );

        
        // اجرای کوئری
	    $query = new WP_Query($args);
        
        // آماده‌سازی نتیجه
        $products = array();
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                global $product;

                $product_id = get_the_ID(); // دریافت ID محصول
                $product_title = get_the_title(); // دریافت عنوان محصول
                $product_permalink = get_permalink(); // دریافت لینک دائمی محصول
                $product_img_thumbnail = get_the_post_thumbnail_url($product_id, 'thumbnail'); 
                $product_img_medium = get_the_post_thumbnail_url($product_id, 'medium'); 
                $product_img_450 = get_the_post_thumbnail_url($product_id, 'product-450'); 
                $product_status = get_post_meta($product_id , 'product_status' , true);
                $product_total_time = get_total_time_course(get_post_meta(get_the_ID() , 'episode_group' , true));

                 // بررسی می‌کنیم که آیا محصول متغیر است
                if ( $product->is_type( 'variable' ) ) {
                    // دریافت کمترین و بیشترین قیمت
                    $regular_price_min = $product->get_variation_regular_price( 'min', true );
                    //$regular_price_max = $product->get_variation_regular_price( 'max', true );
                    
                    $sale_price_min = $product->get_variation_sale_price( 'min', true );
                    //$sale_price_max = $product->get_variation_sale_price( 'max', true );
            
                    // قالب‌بندی قیمت‌ها
                    $formatted_regular_price = number_format( $regular_price_min, 0, '', ',' ); 
            
                    // قالب‌بندی قیمت‌ها
                    if ($sale_price_min && $sale_price_min < $regular_price_min) {
                        $formatted_sale_price = number_format( $sale_price_min, 0, '', ',' );      
                    }else{
                        $formatted_sale_price = 0;
                    }
                }else{
            
                    $regular_price = get_post_meta( get_the_ID(), '_regular_price', true);
                    $formatted_regular_price = number_format( $regular_price, 0, '', ',' );

                    $sale_price  =  get_post_meta( get_the_ID(), '_sale_price', true);
                    if($sale_price !== ''){
                        $formatted_sale_price = number_format( $sale_price , 0, '', ',' );
                    }else{
                        $formatted_sale_price=0;
                    }
                }

                $products[] = array(
                    'title' => $product_title,
                    'link'=> $product_permalink ,
                    'image_thumbnail' => $product_img_thumbnail,
                    'image_medium' => $product_img_medium,
                    'image_450' => $product_img_450,
                    'formatted_regular_price' => $formatted_regular_price,
                    'formatted_sale_price' => $formatted_sale_price ,
                    'status' => $product_status,
                    'total_time' => $product_total_time ,
                );
            }
            wp_reset_postdata();
        }


        //------- pagination -------
        $total_args = $args;
        unset($total_args['posts_per_page']);
        unset($total_args['paged']);
        unset($total_args['no_found_rows']); // برای محاسبه تعداد کل محصولات، باید این را حذف کنیم

        $total_query = new WP_Query($total_args);
        $total_products = $total_query->found_posts; // تعداد کل محصولات با توجه به شرط‌ها
        //------- /pagination -------


        // بازگرداندن نتیجه
        return new WP_REST_Response(array(
            'current_page' => (int)$page,
            'total_products' =>  $total_products,
            'products' => $products,
        ), 200);
    }

}


// otp api
add_action('rest_api_init', 'create_route_otp');
function create_route_otp(){
	register_rest_route('myapi', '/send-otp' , array(
		'methods' => 'POST',
	    'callback' => 'res_function_otp' ,
        'permission_callback' => function () {
            return true;
        }
    ));



    function res_function_otp($data){


        if( !isset($data['wp_nonce']) || !wp_verify_nonce( $data['wp_nonce'] , 'send_phone') ){
            $array = [
                'status' => 'error n',
            ];
        
            return new WP_REST_Response( $array , 200);
        }

       $phone = convertPersianToEnglish(sanitize_text_field($data['phone']));
       if(!preg_match('/^09[0-9]{9}$/' , $phone)){
        return;
       }


       $hashCode = createRandomCode();
       $token = createToken(10);


        global $wpdb;

        //------------

        $ip =  get_user_ip();


        $lastReq = $wpdb->get_results(" SELECT * FROM {$wpdb->prefix}phone_otp_allow WHERE ip = '$ip' ");


        if($lastReq){

            
            $diff = time()*1000 - ( (int)$lastReq[0]->date );

            if(  $diff > 3600000 ){

                $wpdb->update($wpdb->prefix.'phone_otp_allow', array('count'=>1  , 'date'=>time()*1000 ) , array('ip'=>$ip) );

            }else{

                $count = $lastReq[0]->count;
                $newCount = $count+1 ;
                if( $newCount > 5 ){

                    $array = [
            
                        'status' => 'error',
                        'msg' => 'شما بیش از حد تلاش کردید لطفا یک ساعت بعد امتحان کنید',
                    ];
            
                    return new WP_REST_Response( $array , 200);
            

                }else{

                    $wpdb->update($wpdb->prefix.'phone_otp_allow', array('count'=>$newCount , 'date'=>time()*1000 ) , array('ip'=>$ip) );

                }

            }


        }else{
            $result = $wpdb->insert($wpdb->prefix.'phone_otp_allow' , array('ip'=>$ip , 'count'=>1 ,  'date'=>time()*1000 ));
        }


        //snd sms
        global $my_opt;
        $username = $my_opt['opt-sms-username'];
        $password = $my_opt['opt-sms-password'];
        $from = $my_opt['opt-sms-number-output'];
        $pattern_code = $my_opt['opt-sms-pattern-otp'];

        // $username = '09124234337';
        // $password = 'faraz0057370958';
        // $from = $my_opt['opt-sms-number-output'];
        // $pattern_code = $my_opt['opt-sms-pattern-otp'];

        $input_data = [
        'code' => $hashCode
        ];
        $to = array( $phone );
        $url = 'https://ippanel.com/patterns/pattern?username=' . $username . '&password=' . urlencode($password) . "&from=$from&to=" . json_encode($to) . '&input_data=' . urlencode(json_encode($input_data)) . '&pattern_code=' . $pattern_code;
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handler);


        //---------------
        $CurrentPhone = $wpdb->get_results(" SELECT time FROM {$wpdb->prefix}phone_otp WHERE phone=$phone ");


        if($CurrentPhone){
            // user ast
            $wpdb->update($wpdb->prefix.'phone_otp', array('otp'=>wp_hash_password($hashCode) , 'token'=>$token  , 'time'=>time()*1000 ) , array('phone'=>$phone));
        }else{

            // user nist
            global $wpdb;
            $result = $wpdb->insert($wpdb->prefix.'phone_otp' , array('phone'=>$phone , 'otp'=>wp_hash_password($hashCode) , 'token'=>$token , 'time'=>time()*1000 ));
        }
        
        $array = [
            'status' => 'success',
            'token' => $token ,
        ];

        return new WP_REST_Response( $array , 200);
        //wp_send_json_success(true); // alternative response

    }

    function createRandomCode() { 
        return $six_digit_random_number = random_int(100000, 999999);
    }

    function createToken($length) { 
        $string = "";
        $chars = "0123456789";
        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $string .= $chars[rand(0, $size - 1)];
        }
        return  $string; 
    } 
}

// verify api
add_action('rest_api_init', 'create_route_verify');
function create_route_verify(){
	register_rest_route('myapi', '/verify' , array(
		'methods' => 'POST',
	    'callback' => 'res_function_verify' ,
        'permission_callback' => function () {
            return true;
        }
    ));



    function res_function_verify($data){

        if( !isset($data['wp_nonce']) || !wp_verify_nonce( $data['wp_nonce'] , 'send_code')){
            $array = [
                'status' => 'error n',
            ];
        
            return new WP_REST_Response( $array , 200);
        }

       $token = sanitize_text_field($data['token']);
       $otp = convertPersianToEnglish(sanitize_text_field($data['otp']));



       global $wpdb;
       $wpdb->show_errors( true );
       $tokenRes = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}phone_otp where token= $token ");


        if($tokenRes){

            //var_dump('token is ok');

            require_once ( ABSPATH . 'wp-includes/class-phpass.php');
            $wp_hasher = new PasswordHash(8, TRUE);
            $password_hashed = $tokenRes[0]->otp;
            $plain_password = $otp;
            $check= $wp_hasher ->CheckPassword($plain_password , $password_hashed);


            if($check) {
            

                //var_dump('otp is ok');

                // otp is matched
                
                //var_dump(time()*1000);
                //var_dump((int) $tokenRes[0]->time);

               if( (time()*1000 - (int) $tokenRes[0]->time) < 60*5*1000 ){
               
                        //var_dump('time is ok');

                        $user = get_users(array(
                            'meta_key' => 'digits_phone',
                            'meta_value' => convertToInternationalFormat($tokenRes[0]->phone)
                        ));

                        if($user){

                            //login with id
                            wp_clear_auth_cookie();
                            wp_set_current_user ($user[0]->id);
                            wp_set_auth_cookie  ($user[0]->id , true);

                            $array = [
                                'status' => 'successLogin',
                            ];
                        
                            return new WP_REST_Response( $array , 200);

                        }else{

                            //var_dump('time is ok but not registered');

                            $array = [
                                'status' => 'success',
                            ];
                        
                            return new WP_REST_Response( $array , 200);



                        }
                            
                }else{

                    //var_dump('time is not ok');


                    // otp expired
                    $array = [
                        'status' => 'error',
                    ];
                
                    return new WP_REST_Response( $array , 200);
                }

           

            }else{

                //var_dump('otp is not ok');


                // otp didn't match
                $array = [
                    'status' => 'error2',
                ];
            
                return new WP_REST_Response( $array , 200);

            }   
        }else {

            //var_dump('token is not ok');

          // token didn't match
            $array = [
                'status' => 'error1',
            ];
        
            return new WP_REST_Response( $array , 200);
        }

        
    }
    
}


// register api
add_action('rest_api_init', 'create_route_register');
function create_route_register(){
	register_rest_route('myapi', '/register' , array(
		'methods' => 'POST',
	    'callback' => 'res_function_register' ,
        'permission_callback' => function () {
            return true;
        }
    ));



    function res_function_register($data){

        if( !isset($data['wp_nonce']) || !wp_verify_nonce( $data['wp_nonce'] , 'send_name')){
            $array = [
                'status' => 'error n',
            ];
            return;
        }

       $token = sanitize_text_field($data['token']);
       $otp = convertPersianToEnglish(sanitize_text_field($data['otp']));
       $name = sanitize_text_field($data['name']);
       //$password = sanitize_text_field($data['password']);



       global $wpdb;
       $wpdb->show_errors( true );
       $tokenRes = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}phone_otp where token= $token ");

        if($tokenRes){

            require_once ( ABSPATH . 'wp-includes/class-phpass.php');
            $wp_hasher = new PasswordHash(8, TRUE);
            $password_hashed = $tokenRes[0]->otp;
            $plain_password = $otp;
            $check= $wp_hasher ->CheckPassword($plain_password , $password_hashed);


            if($check) {
            
                //var_dump('otp is ok');
                // otp is matched
                
               if( (time()*1000 - (int) $tokenRes[0]->time) < 60*5*1000 ){
               
                        //var_dump('time is ok');

                        $userdata = array(
                            'user_login' =>  apply_filters( 'pre_user_login' , $tokenRes[0]->phone),
                            'user_pass'  =>  apply_filters( 'pre_user_pass' , '@SS#de') ,
                            'first_name'  =>  apply_filters( 'pre_user_first_name' , $name) ,
                            'last_name'  =>  apply_filters( 'pre_user_last_name' , '') ,
                        );
                        
                        $user_id = wp_insert_user( $userdata ) ;
                        
                        // On success.
                        if ( ! is_wp_error( $user_id ) ) {

                            // set user meta key (phone)
                            update_user_meta( $user_id  , 'digits_phone' , convertToInternationalFormat($tokenRes[0]->phone));
                            update_user_meta( $user_id  , 'digits_phone_no' ,  convertToLocalFormat($tokenRes[0]->phone) );
                            update_user_meta( $user_id  , 'digt_countrycode' , '+98');
                            update_user_meta( $user_id  , 'nickname' , $name );
                            update_user_meta( $user_id  , 'first_name' , $name);


                            //login with id
                            wp_clear_auth_cookie();
                            wp_set_current_user ($user_id);
                            wp_set_auth_cookie  ($user_id , true , true);

                            $array = [
                                'status' => 'success',
                            ];
                        
                            return new WP_REST_Response( $array , 200);


                        }else{

                            $array = [
                                'status' => 'error',
                            ];
                        
                            return new WP_REST_Response( $array , 200);
    

                        }

                
                            
                }else{

                    //var_dump('time is not ok');


                    // otp expired
                    $array = [
                        'status' => 'error55550',
                    ];
                
                    return new WP_REST_Response( $array , 200);
                }

           

            }else{

                //var_dump('otp is not ok');


                // otp didn't match
                $array = [
                    'status' => 'error۶',
                ];
            
                return new WP_REST_Response( $array , 200);

            }   
        }else {

            //var_dump('token is not ok');

          // token didn't match
            $array = [
                'status' => 'error555',
            ];
        
            return new WP_REST_Response( $array , 200);
        }

        
    }
    
}

?>