<?php
if(is_singular('product')){

    $id_post = get_the_ID();
    $is_buy = false;
    
    $video = get_post_meta( get_the_ID() , 'product_video' , true);
    $videoCover = get_post_meta( get_the_ID() , 'product_cover_video' , true);


    $sale_price  =  get_post_meta( get_the_ID(), '_sale_price', true);
    if($sale_price !== ''){
        $formatted_sale_price = WC_price( $sale_price , array(
            'ex_tax_label'       => false,
            'currency'           => false,
        ));
    }

    $regular_price = get_post_meta( get_the_ID(), '_regular_price', true);
    $formatted_regular_price = WC_price( $regular_price , array(
        'ex_tax_label'       => false,
        'currency'           => false,
    ));

    if(is_user_logged_in()){ 
        $current_user = wp_get_current_user();
        $is_buy = wc_customer_bought_product( '', $current_user->ID, $id_post );
    }


    function beauty_product_spotplayer( $post_id ) {
        $_spotplayer_course = get_post_meta( $post_id, '_spotplayer_course', true );
        if( ! empty( $_spotplayer_course ) ) return $_spotplayer_course;
        return false;
    }

    $product_spotplayer = beauty_product_spotplayer($id_post);


    function amzshyar_user_products_buys_spotplayer_key() {
        $customer = wp_get_current_user();
        $buys_products = [];
        $spotplayer_keys = [];
        if( ! empty( $customer ) ) {
            $buys_products = wp_cache_get( 'amzshyar_user_products_buys_spotplayer_key' . get_current_user_id() );
            if( false === $buys_products ) {
                $buys_products = [];
                $customer_orders = get_posts(array(
                    'numberposts' => -1,
                    'meta_key' => '_customer_user',
                    'orderby' => 'date', 'order' => 'ASC',
                    'meta_value' => get_current_user_id(),
                    'post_type' => wc_get_order_types(),
                    'post_status' => array_keys(wc_get_order_statuses()), 'post_status' => array('wc-completed'),
                ));
                $Order_Array = [];
                foreach ($customer_orders as $customer_order) {
                    $orderq = wc_get_order($customer_order);
                    $_spotplayer_data = get_post_meta( $customer_order->ID, '_spotplayer_data', true );

                    $items = $orderq->get_items();
                    foreach( $items as $item ) {
                        $productId =  ( int ) $item[ 'product_id' ];
                        if( ! empty( $_spotplayer_data ) && is_array( $_spotplayer_data ) && ! empty( $_spotplayer_data[ 'key' ] ) ) {
                            if( ! empty( beauty_product_spotplayer( $productId ) ) ) {
                                $spotplayer_keys[$productId] = [
                                    'key' => $_spotplayer_data[ 'key' ],
                                    'url' => ( ! empty( $_spotplayer_data[ 'url' ] ) ? $_spotplayer_data[ 'url' ] : '' )
                                ];
                            }
                        }
                    }
                }
                wp_cache_set( 'amzshyar_user_products_buys_spotplayer_key' . get_current_user_id(), $buys_products );
            }
        }
        return $spotplayer_keys;
    }




    

    function can_see_icon($status , $showable ,  $product_id){

        $result = can_see($status , $showable ,  $product_id);

        if($result == 'play'){
            return wc_get_template_part( 'template/episode', 'play' );

        }else if($result == 'spotplayer'){
            return wc_get_template_part( 'template/episode', 'spotplayer' );

        }else if($result == 'lock'){
            return wc_get_template_part( 'template/episode', 'lock' );
        }
      
    }



    function can_see($status , $showable ,  $product_id){
        if($status == 'cash'){
            if(is_user_logged_in()){ 
                $current_user = wp_get_current_user();
                if(wc_customer_bought_product( $current_user->user_email, $current_user->ID , $product_id)){ 
                    return 'spotplayer';
                }
            }
            return 'lock';
        }
        if($status == 'free'){

            if($showable == 'no'){

                if(is_user_logged_in()){ 
                    $current_user = wp_get_current_user();
                    if(wc_customer_bought_product( $current_user->user_email, $current_user->ID , $product_id)){ 
                        return 'play';
                    }else{
                        return 'lock';
                    }
                }else{
                    return 'lock';
                }

            }

        }
        return 'play';
    }

    $episodes = get_post_meta(get_the_ID() , 'episode_group' , true);
    $type = get_post_meta( get_the_ID() , 'product_type' , true);

    $faqs = get_post_meta( get_the_ID() , 'faq_group' , true);

?>

<?php get_header() ?>

<main class='w-full flex-grow px-6 md:pt-[100px] md:pb-[100px]'>
    <div class="container mx-auto px-2">
        <div class="flex gap-[40px]">
            <div class="hidden w-0 lg:w-[300px] h-fit sticky top-[0px] lg:block border border-gray-200 p-5 relative flex flex-col">
                <div class="flex-1 overflow-y-auto">
                <div class='btn-show-video video-cover w-full h-[150px] flex items-center rounded-lg justify-center relative mb-8' style="background-image: url('<?php echo $videoCover ?>'); background-size: cover; background-position: center; cursor: pointer; z-index: 2;" data-video=<?php echo get_post_meta( get_the_ID() , 'product_video' , true) ?>>
                    <span class="animate-my-ping w-[50px] h-[50px] inline-flex rounded-full bg-primary-100 opacity-50"></span>
                    <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    strokeWidth={1}
                    class="w-[50] h-[50px] stroke-white-100 absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%]"
                    >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"
                    />
                    </svg>
                </div> 
                <div class="w-full flex flex-col items-start bg-gray-100 gap-y-2 rounded-lg p-3 mb-4">
                    <span class="w-full text-textPrimary-100 text-[0.9rem]">
                        مدرس:
                    </span>
                    <div class="flex items-center gap-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" class="w-[20px] h-[20px] stroke-textPrimary-100">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    <?php
                        $teacher_id =  get_post_meta( get_the_ID() , 'product_teacher' , true); 
                        $teacher = new WP_Query(
                            array(
                                'post_type' => 'tutor',
                                'posts_per_page' => 1 , 
                                'p' => $teacher_id , 
                            )
                        );
                        if($teacher->have_posts()){
                            while($teacher->have_posts()):
                            $teacher->the_post();
                        ?>
                        
                          
                            <span class='text-[1rem] text-justify font-medium text-textPrimary-100'>
                                <?php the_title(); ?>
                            </span>
                          
                        <?php
                            endwhile; 
                            }
                        wp_reset_query();
                        ?>
                    </div>   
                </div>
                <div class="w-full flex flex-col items-start bg-gray-100 gap-y-2 rounded-lg p-3 mb-4">
                    <span class="w-full text-textPrimary-100 text-[0.9rem]">
                        تعداد جلسات:    
                    </span>
                    <div class="flex items-center gap-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" class="w-[20px] h-[20px] stroke-textPrimary-100">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    <?php
                        $teacher_id =  get_post_meta( get_the_ID() , 'product_teacher' , true); 
                        $teacher = new WP_Query(
                            array(
                                'post_type' => 'tutor',
                                'posts_per_page' => 1 , 
                                'p' => $teacher_id , 
                            )
                        );
                        if($teacher->have_posts()){
                            while($teacher->have_posts()):
                            $teacher->the_post();
                        ?>
                        
                          
                            <span class='text-[1rem] text-justify font-medium text-textPrimary-100'>
                                <?php 
                                    echo count($episodes);
                                ?>
                            </span>
                          
                        <?php
                            endwhile; 
                            }
                        wp_reset_query();
                        ?>
                    </div>   
                </div>
                <div class="w-full flex flex-col items-start bg-gray-100 gap-y-2 rounded-lg p-3 mb-4">
                    <span class="w-full text-textPrimary-100 text-[0.9rem]">
                        زمان دوره:
                    </span>
                    <div class="flex items-center gap-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" class="w-[20px] h-[20px] stroke-textPrimary-100">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    <?php
                        $teacher_id =  get_post_meta( get_the_ID() , 'product_teacher' , true); 
                        $teacher = new WP_Query(
                            array(
                                'post_type' => 'tutor',
                                'posts_per_page' => 1 , 
                                'p' => $teacher_id , 
                            )
                        );
                        if($teacher->have_posts()){
                            while($teacher->have_posts()):
                            $teacher->the_post();
                        ?>
                        
                          
                            <span class='text-[1rem] text-justify font-medium text-textPrimary-100'>
                                <?php 
                                echo get_total_time_course($episodes);
                                ?>
                            </span>
                          
                        <?php
                            endwhile; 
                            }
                        wp_reset_query();
                        ?>
                    </div>   
                </div>
                </div>
                <div class="w-full border border-dashed p-3 rounded-lg">
                    <?php if($regular_price == 0){ ?>
                        <div class="w-full text-center text-textPrimary-100 mb-1">
                            رایگان 
                        </div>
                    <?php }else{ ?>
                        <div class="w-full text-center text-textPrimary-100 mb-1">
                            <?php echo $formatted_regular_price; ?> 
                            <?php if($sale_price !== '') {?> 
                            <span class='line-through text-red-400 mr-1'>
                                <?php echo $formatted_sale_price; ?>
                            </span>
                        <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if($is_buy){ ?>
                        <p class="text-center">
                            شما به این دوره دسترسی دارید    
                        <p>
                    <?php }else{ ?>
                        <button data-set="<?php echo get_the_ID(); ?>"
                            class='addToCard btn w-full cursor-pointer bg-primary-100 hover:text-primary-100 border border-primary-100 inline-flex rounded-md hover:bg-transparent transition-all duration-300'>
                            <a class='w-full flex justify-center px-3 py-2'>
                                <span class="btn text-lg font-medium text-white-100">
                                    ثبت نام دوره
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 mr-2 stroke-white-100 " fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path
                                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                            </a>
                        </button>
                    <?php } ?>
                </div>

            </div>
            <!-- main -->
            <div class="w-full lg:w-[calc(100%-440px)] md:text-2xl font-semibold text-textPrimary-100">
                <h1 class="text-xl md:text-3xl font-bold text-textPrimary-100 mb-4"><?php the_title(); ?></h1>
                <!-- content -->
                <div class='content-wrapper mb-10'>
                    <?php 
                    $content = get_the_content();
                    $content = wp_strip_all_tags($content);
                    $content_length = mb_strlen($content);
                    $short_content = mb_substr($content, 0, 200);
                    $is_long = $content_length > 200;
                    ?>
                    
                    <div class='w-full leading-8 text-justify text-base font-light mt-3 relative text-textPrimary-100 content-text'>
                        <?php if($is_long): ?>
                            <span class='short-content' style='display:inline;'><?php echo $short_content; ?>... <button class='btn-read-more text-primary-100 hover:text-primary-200 font-medium transition-colors duration-300 cursor-pointer' style='display:inline; font-size:1em; padding:0; margin:0; border:none; background:none; cursor:pointer;'>بیشتر</button></span>
                            <span class='full-content' style='display:none;'><?php echo $content; ?> <button class='btn-read-more btn-full-content text-primary-100 hover:text-primary-200 font-medium transition-colors duration-300 cursor-pointer' style='display:inline; font-size:1em; padding:0; margin:0; border:none; background:none; cursor:pointer;'>مخفی کردن</button></span>
                        <?php else: ?>
                            <?php echo $content; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- just mobile -->
                <div class="w-full md:hidden flex flex-wrap gap-x-[16px] items-center justify-between mb-4">
                    <div class="w-full border border-dashed p-3 rounded-lg mb-10">
                        <?php if($regular_price == 0){ ?>
                            <div class="w-full text-center text-textPrimary-100 mb-1">
                                رایگان 
                            </div>
                        <?php }else{ ?>
                            <div class="w-full text-center text-textPrimary-100 mb-1">
                                <?php echo $formatted_regular_price; ?> 
                                <?php if($sale_price !== '') {?> 
                                <span class='line-through text-red-400 mr-1'>
                                    <?php echo $formatted_sale_price; ?>
                                </span>
                            <?php } ?>
                            </div>
                        <?php } ?>
                        <?php if($is_buy){ ?>
                            <p class="text-center">
                            شما به این دوره دسترسی دارید    
                            <p>
                        <?php }else{ ?>
                            <button data-set="<?php echo get_the_ID(); ?>"
                                class='addToCard btn w-full cursor-pointer bg-primary-100 hover:text-primary-100 border border-primary-100 inline-flex rounded-md hover:bg-transparent transition-all duration-300'>
                                <a class='w-full flex justify-center px-3 py-2'>
                                    <span class="btn text-lg font-medium text-white-100">
                                        ثبت نام دوره
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 mr-2 stroke-white-100 " fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                        <path
                                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                    </svg>
                                </a>
                            </button>
                        <?php } ?>
                    </div>                   
                    <div class="w-full flex flex-col items-start bg-card-100 gap-y-2 rounded-lg p-3 mb-4">
                        <span class="w-full text-textPrimary-100 text-[0.9rem]">
                            مدرس:
                        </span>
                        <div class="flex items-center gap-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" class="w-[20px] h-[20px] stroke-textPrimary-100">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        <?php
                            $teacher_id =  get_post_meta( get_the_ID() , 'product_teacher' , true); 
                            $teacher = new WP_Query(
                                array(
                                    'post_type' => 'tutor',
                                    'posts_per_page' => 1 , 
                                    'p' => $teacher_id , 
                                )
                            );
                            if($teacher->have_posts()){
                                while($teacher->have_posts()):
                                $teacher->the_post();
                            ?>
                            
                            
                                <span class='text-[1rem] text-justify font-medium text-textPrimary-100'>
                                    <?php the_title(); ?>
                                </span>
                            
                            <?php
                                endwhile; 
                                }
                            wp_reset_query();
                            ?>
                        </div>   
                    </div>
                    <div class="w-[calc(50%-8px)] flex flex-col items-start bg-card-100 gap-y-2 rounded-lg p-3 mb-4">
                        <span class="w-full text-textPrimary-100 text-[0.9rem]">
                            تعداد جلسات:    
                        </span>
                        <div class="flex items-center gap-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" class="w-[20px] h-[20px] stroke-textPrimary-100">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        <?php
                            $teacher_id =  get_post_meta( get_the_ID() , 'product_teacher' , true); 
                            $teacher = new WP_Query(
                                array(
                                    'post_type' => 'tutor',
                                    'posts_per_page' => 1 , 
                                    'p' => $teacher_id , 
                                )
                            );
                            if($teacher->have_posts()){
                                while($teacher->have_posts()):
                                $teacher->the_post();
                            ?>
                            
                            
                                <span class='text-[1rem] text-justify font-medium text-textPrimary-100'>
                                    <?php 
                                        echo count($episodes);
                                    ?>
                                </span>
                            
                            <?php
                                endwhile; 
                                }
                            wp_reset_query();
                            ?>
                        </div>   
                    </div>
                    <div class="w-[calc(50%-8px)] flex flex-col items-start bg-card-100 gap-y-2 rounded-lg p-3 mb-4">
                        <span class="w-full text-textPrimary-100 text-[0.9rem]">
                            زمان دوره:
                        </span>
                        <div class="flex items-center gap-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" class="w-[20px] h-[20px] stroke-textPrimary-100">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        <?php
                            $teacher_id =  get_post_meta( get_the_ID() , 'product_teacher' , true); 
                            $teacher = new WP_Query(
                                array(
                                    'post_type' => 'tutor',
                                    'posts_per_page' => 1 , 
                                    'p' => $teacher_id , 
                                )
                            );
                            if($teacher->have_posts()){
                                while($teacher->have_posts()):
                                $teacher->the_post();
                            ?>
                            
                            
                                <span class='text-[1rem] text-justify font-medium text-textPrimary-100'>
                                    <?php 
                                    echo get_total_time_course($episodes);
                                    ?>
                                </span>
                            
                            <?php
                                endwhile; 
                                }
                            wp_reset_query();
                            ?>
                        </div>   
                    </div>        
                </div>
                       
                
                <!-- episodes -->
                <div
                    class='flex flex-col justify-center items-center my-10'>
                    <div class='w-full flex justify-start items-center mb-5'>
                        <span class='text-textPrimary-100 text-xl font-bold'>قسمت‌های دوره</span>
                    </div>
                    <?php if(!empty($episodes)){ ?>
                    <div class='w-full relative hidden pt-[56%] lg:pt-[50%] rounded-lg mb-3'>
                        <video width="100%" height="100%" class='video-episode w-full h-full rounded-lg absolute top-0 left-0 right-0 bottom-0 object-cover' controls>
                            <source src="<?php echo $episodes[0]['episode_product_video'] ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                         <!-- لودینگ -->
                        <div class="loading-indicator" style="
                            display: none;
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%);
                            font-size: 18px;
                            color: white;
                            background: rgba(0, 0, 0, 0.7);
                            padding: 10px 20px;
                            border-radius: 5px;
                            ">
                            در حال بارگیری...
                        </div>
                    </div> 
                    <?php } ?>
                    <?php 
                        if(!empty($episodes)){
                            foreach($episodes as $episode) {
                    ?>
                    <div class='<?php echo ( can_see( $episode['episode_product_purchase_status'] , $episode['episode_product_show_status']  , get_the_ID() ) == 'play'  ) ? 'btn-episodes hover:cursor-pointer' : '' ?> <?php echo ( $episode['episode_product_number'] == 1 &&  can_see( $episode['episode_product_purchase_status'] , $episode['episode_product_show_status']  , get_the_ID() ) == 'play' ) ? 'border border-card-100 ' : '' ?> group w-full h-fit flex mb-2 justify-between items-center border border-gray-200 text-sm sm:text-base font-normal p-4 text-textPrimary-100 rounded-lg' data-video="<?php echo $episode['episode_product_video']; ?>">
                        <div
                            class='h-fit flex flex-col items-center py-[5px] px-[10px] rounded-lg bg-bg-100 ml-2 font-bold text-textPrimary-100 <?php echo ( can_see( $episode['episode_product_purchase_status'] , $episode['episode_product_show_status']  , get_the_ID() ) == 'play'  ) ? 'group-hover:text-primary-100' : '' ?>'>
                            <?php echo $episode['episode_product_number']; ?>
                        </div>
                        <div class='flex flex-wrap flex-grow justify-start items-center' >
                            <span
                                class='h-fit font-normal text-textPrimary-100 <?php echo ( can_see( $episode['episode_product_purchase_status'] , $episode['episode_product_show_status']  , get_the_ID() ) == 'play'  ) ? 'group-hover:text-primary-100' : '' ?>'>
                                <?php echo $episode['episode_product_title']; ?>
                            </span>
                            <div
                                class='h-fit flex justify-end flex-grow items-center text-xs sm:text-[0.9rem]'>
                                <div class='h-full flex items-center text-textPrimary-100'>
                                    <span class='font-normal ml-[5px] <?php echo ( can_see( $episode['episode_product_purchase_status'] , $episode['episode_product_show_status']  , get_the_ID() ) == 'play'  ) ? 'group-hover:text-primary-100' : '' ?>'>
                                        <?php echo $episode['episode_product_time']; ?>
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-5 <?php echo ( can_see( $episode['episode_product_purchase_status'] , $episode['episode_product_show_status']  , get_the_ID() ) == 'play'  ) ? 'group-hover:stroke-primary-100' : '' ?>" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div
                                    class='mr-2 h-fit flex items-center bg-background-100 text-textPrimary-100 px-2 py-1 font-normal rounded-md <?php echo ( can_see( $episode['episode_product_purchase_status'] , $episode['episode_product_show_status']  , get_the_ID() ) == 'play'  ) ? '' : '' ?>'>
                                    <?php can_see_icon( $episode['episode_product_purchase_status'] , $episode['episode_product_show_status']  , get_the_ID() ); ?>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php }else{ ?>
                    <% if(course.episodes.length == 0) { %>
                    <?php } ?>
                </div>
                <!-- faqs   -->
                <?php if($faqs){ ?>
                <div
                    class='flex flex-col justify-center items-center  mb-2 '>
                    <div class='w-full flex justify-start items-center mb-5'>
                        <span class='text-textPrimary-100 text-xl font-bold'>سوالات متداول</span>
                    </div>
                    <?php 
                        foreach($faqs as $faq) {
                    ?>
                    <div
                        class='btn-collapse w-full h-16 text-base group border bordr-gray-200 font-semibold rounded-md p-3 flex justify-between items-center text-gray-600 hover:cursor-pointer'>
                        <div class='flex justify-start items-center'>
                            <div
                                class='rounded-lg py-1 px-2 ml-2 bg-bg-100'>
                                <span
                                    class='text-lg sm:text-2xl font-bold lg:group-hover:text-primary-100 text-textPrimary-100'>?</span>
                            </div>
                            <span
                                class='lg:group-hover:text-primary-100 text-textPrimary-100'><?php echo $faq['question_product']; ?></span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 sm:h-6 sm:w-6 lg:group-hover:stroke-primary-100 stroke-textPrimary-100"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div class='w-full mb-3 transition-all duration-200 rounded-md max-h-0 overflow-hidden'>
                        <div class='mt-3 mr-14 p-3 bg-card-100 rounded-md'>
                            <span
                                class='font-normal text-base text-textPrimary-100'><?php echo $faq['answer_product']; ?></span>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
   
    </div>
</main>

<div class='video-container hidden bg-black-80 fixed top-0 bottom-0 left-0 right-0 flex flex-col items-center justify-center z-[999999999]'>

        <!-- استفاده از نسبت تصویر 9 به 16 -->
        <div class="portfolio-detail-video-container max-w-[700px] relative aspect-[16/9] w-full rounded-lg flex items-center justify-center overflow-hidden">
            
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} class="portfolio-close-btn">
                <path strokeLinecap="round" strokeLinejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>

            <video controls class="video-introduce absolute top-0 left-0 w-full h-full object-contain rounded-lg bg-black-100">
                <source type="video/mp4">
                مرورگر شما از ویدیو پشتیبانی نمی‌کند.
            </video>
            <!-- لودینگ -->
            <div class="loading-indicator-introduce" style="
                display: nonedddd;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                font-size: 18px;
                color: white;
                background: rgba(0, 0, 0, 0.7);
                padding: 10px 20px;
                border-radius: 5px;
                ">
                در حال بارگیری...
            </div>
        </div>
</div>

<?php get_footer() ?>
<?php
}else{
    wc_get_template('archive-product.php');
}
?>
