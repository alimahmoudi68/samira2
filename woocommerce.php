<?php
if(is_singular('product')){

    $id_post = get_the_ID();

    $sale_price  =  get_post_meta( get_the_ID(), '_sale_price', true);
    if($sale_price !== ''){
        $formatted_sale_price = WC_price( $sale_price , array(
            'ex_tax_label'       => false,
            'currency'           => false,
        ));
    }

    if(is_user_logged_in()){ 
        $current_user = wp_get_current_user();
        $is_buy = wc_customer_bought_product( '', $current_user->ID, $id_post );
    }else{
        $is_buy = false;
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



    $sale_price  =  get_post_meta( get_the_ID(), '_sale_price', true);
    if($sale_price !== ''){
        $formatted_sale_price = WC_price( $sale_price , array(
            'ex_tax_label'       => false,
            'currency'           => false,
        ));
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

<main class='w-full flex-grow'>
    <div class="container mx-auto px-2 pt-[75px] md:pt-[100px]">
        <?php woocommerce_breadcrumb(); ?>
        <div
            class='w-full flex flex-col justify-center items-stretch mb-[20px] p-5 rounded-xl lg:flex-row lg:justify-between bg-white-100'>
            <div class="w-full items-center rounded-lg relative pt-[50%] lg:pt-[28%] xl:pt-[25%]">
                <?php 
                    $video = get_post_meta( get_the_ID() , 'product_video' , true);
                    $videoCover = get_post_meta( get_the_ID() , 'product_cover_video' , true);
                ?>
                <video width="100%" height="100%" class='video w-full h-full rounded-lg absolute top-0 left-0 right-0 bottom-0 object-cover' controls>
                    <source src="<?php echo $video ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class='video-cover absolute top-0 left-0 right-0 bottom-0 flex items-center rounded-lg justify-center' style="background-image: url('<?php echo $videoCover ?>'); background-size: cover; background-position: center; cursor: pointer; z-index: 2;">
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
            </div>
            <div class='w-full grow flex flex-col justify-between items-between grow lg:order-first mt-2 lg:mt-0 lg:ml-5 relative'>
                <div>    
                    <h1
                        class='w-full text-2xl mb-2 lg:text-4xl font-extrabold text-center lg:text-right text-textPrimary-100'>
                        <?php the_title(); ?>
                    </h1>
                    <span
                        class='text-justify font-light leading-6 lg:mt-5 text-textPrimary-100'>
                        <?php the_excerpt(); ?>
                    </span>
                </div>
                <div class='absolote bottom-0'>
                    <?php
                        $status = get_post_meta( get_the_ID() , 'product_status' , true);
                        if($status == 'soon'){                 
                    ?>
                    <button class='w-fit px-3 py-2 mt-3 bg-slate-200 hover:cursor-default rounded-md'>
                        این دوره به زودی آماده می‌شود
                    </button>

                    <?php }else{ ?>
                    <div class='flex flex-col lg:flex-row justify-center lg:justify-between items-center mt-3'>
                        <?php 
                        $id = get_the_ID();
                        if(is_user_logged_in()){ 
                            $current_user = wp_get_current_user();
                            if(wc_customer_bought_product( $current_user->user_email, $current_user->ID , $id)){            
                        ?>
                            <div
                                class='bg-primary-100 border border-primary-100 px-3 py-2 inline-flex rounded-md group transition-all duration-300'>
                                <span class="text-lg font-medium text-white-100 ">
                                    شما دانشجوی این دوره هستید
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 mr-2 stroke-white-100" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path
                                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                            </div>
                            <?php 
                                }else{
                                    // login vali not buy
                            ?>
                            <button data-set="<?php echo get_the_ID(); ?>"
                                class='addToCard btn bg-primary-100 border border-primary-100 inline-flex rounded-md group hover:bg-dark-50 transition-all duration-300'>
                                <a class='flex px-3 py-2 hover:opacity-80'>
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
                            <?php
                            }
                        }else{
                            // not login
                            ?>
                            <button data-set="<?php echo get_the_ID(); ?>"
                                class='addToCard btn bg-primary-100 border border-primary-100 inline-flex rounded-md group hover:bg-dark-50 transition-all duration-300'>
                                <a class='flex px-3 py-2'>
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
                                
                            <?php 
                        }
                        ?>
                        <div class='inline-flex'>
                            <?php 
                                if($type == 'free'){    
                            ?>
                            <span class='mt-2 text-2xl font-medium lg:font-semibold	text-white-100'>
                                رایگان :)
                            </span>
                            <?php }else{ ?>
                            <div class='mt-2 flex flex-col items-center'>
                                <?php if($sale_price !== '') {?> 
                                <span class='block text-xl font-semibold ml-1 line-through text-red-400'>
                                    <?php echo $formatted_sale_price; ?>
                                </span>
                                <?php } ?>
                                       <span class='text-xl font-semibold ml-1 text-textPrimary-100'>
                                    <?php
                                        $regular_price = get_post_meta( get_the_ID(), '_regular_price', true);
                                        $formatted_regular_price = WC_price( $regular_price , array(
                                            'ex_tax_label'       => false,
                                            'currency'           => false,
                                        ));
                                        echo $formatted_regular_price;
                                    ?>
                                </span>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="w-full flex justify-between flex-wrap gap-3 mb-3">
            <div class="w-full items-stretch lg:w-[calc(25%-8px)]">
                <div class='w-full h-full flex flex-col gap-y-3 bg-white-100 rounded-lg p-5'>
                    <div class='w-full h-full flex gap-x-2 justify-between'>
                        <div class='w-[49%] flex flex-col gap-y-2 lg:flex-row justify-between items-center bg-background-100 rounded-lg p-2'>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-[40px] stroke-primary-100">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                            <div class='w-[50%]'>
                                <span class='text-textPrimary-100 text-center text-[0.9rem] block'>
                                    <?php echo get_product_sales_count($id_post); ?>
                                </span>
                                <span class='text-white-70 text-center text-[0.9rem] block'>
                                    دانشجو
                                </span>
                            </div>
                        </div>
                        <div class='w-[49%] flex flex-col gap-y-2 lg:flex-row justify-between items-center bg-background-100 rounded-lg p-2'>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-[40px] stroke-yellow-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                            </svg>
                            <div class='w-[50%]'>
                                <span class='text-textPrimary-100 text-center text-[1rem] block'>
                                    5.0
                                </span>
                                <span class='text-white-70 text-center text-[0.9rem] block'>
                                    رضایت
                                </span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class='flex justify-between items-center mb-1'>
                            <span class='text-textPrimary-100 text-[1rem] block'>
                                درصد تکمیل دوره
                            </span>
                            <span class='text-textPrimary-100 text-[1rem] block'>
                                <?php echo get_post_meta( get_the_ID() , 'product_complete' , true) ?>٪
                            </span>
                        </div>
                        <div class="w-full bg-background-100 rounded-full">
                            <div
                                class="bg-primary-100 p-[5px] text-center text-xs font-medium leading-none rounded-full text-gray-700"
                                style="width: <?php echo get_post_meta( get_the_ID() , 'product_complete' , true) ?>%">
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
            <div class="w-full flex justify-between flex-wrap gap-[12px] lg:w-[calc(75%-8px)]">
                <div class='w-[calc(50%-6px)] sm:w-[calc(33%-6px)] flex flex-col items-center lg:flex-row lg:justify-center gap-x-3 p-5 rounded-lg bg-white-100'>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[40px] stroke-primary-100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>
                    <div>
                        <span class='text-[1rem] text-center font-normal mt-2  text-textPrimary-100 block'>
                            وضعیت دوره
                        </span>
                        <span class='text-xs sm:text-base text-center font-semibold text-textPrimary-100 block'>
                            <?php 
                            $status=  get_post_meta( get_the_ID() , 'product_status' , true);
                            if($status == 'soon'){
                                echo 'به زودی';
                            }else if($status == 'continue'){
                                echo 'در حال برگزاری';
                            }else if($status == 'finish'){
                                echo 'تکمیل ضبط';
                            }
                            ?>
                        </span>
                    </div>
                </div>
                <div class='w-[calc(50%-6px)] sm:w-[calc(33%-6px)] flex flex-col items-center lg:flex-row lg:justify-center gap-x-3 p-5 rounded-lg bg-white-100'>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-[40px] stroke-primary-100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <div>
                        <span class='text-[1rem] text-center text-center font-normal mt-2 text-textPrimary-100 block'>
                            زمان دوره
                        </span>
                        <span class='text-xs sm:text-base font-semibold text-textPrimary-100 block'>
                            <?php 
                            echo get_total_time_course($episodes);
                            ?>
                        </span>
                    </div>
                </div>
                <div class='w-[calc(50%-6px)] sm:w-[calc(33%-6px)] flex flex-col items-center lg:flex-row lg:justify-center gap-x-3 p-5 rounded-lg bg-white-100'>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-[40px] stroke-primary-100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                    </svg>
                    <div>
                        <span class='text-[1rem] text-center font-normal mt-2 text-textPrimary-100 block'>
                            تعداد جلسات
                        </span>
                        <span class='text-xs sm:text-base text-center font-semibold text-textPrimary-100 block'>
                            <?php 
                                echo count($episodes);
                            ?>
                        </span>
                    </div>
                </div>
                <div class='w-[calc(50%-6px)] sm:w-[calc(33%-6px)] flex flex-col items-center lg:flex-row lg:justify-center gap-x-3 p-5 rounded-lg bg-white-100'>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-[40px] stroke-primary-100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                    <div>
                        <span class='text-[1rem] text-center font-normal mt-2 text-textPrimary-100 block'>
                            نوع دسترسی
                        </span>
                        <span class='text-xs sm:text-base text-center font-semibold text-textPrimary-100 block'>
                            <?php 
                                $type=  get_post_meta( get_the_ID() , 'product_type' , true);
                                if($type == 'free'){
                                    echo 'رایگان';
                                }else if($type == 'cash'){
                                    echo 'نقدی';
                                }
                            ?>
                        </span>
                    </div>
                </div>
                <div class='w-[calc(50%-6px)] sm:w-[calc(33%-6px)] flex flex-col items-center lg:flex-row lg:justify-center gap-x-3 p-5 rounded-lg bg-white-100'>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-[40px] stroke-primary-100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                    </svg>
                    <div>
                        <span class='text-[1rem] text-center font-normal mt-2 text-textPrimary-100 block'>
                            روش پشتیبانی
                        </span>
                        <span class='text-xs sm:text-base text-center font-semibold text-textPrimary-100 block'>
                            <?php 
                            echo  get_post_meta( get_the_ID() , 'product_support' , true);
                            ?>
                        </span>
                    </div>
                </div>
                <div class='w-[calc(50%-6px)] sm:w-[calc(33%-6px)] flex flex-col items-center lg:flex-row lg:justify-center gap-x-3 p-5 rounded-lg bg-white-100'>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-[40px] stroke-primary-100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                    <div>
                        <span class='text-[1rem] text-center font-normal mt-2 text-textPrimary-100 block'>
                            نوع مشاهده
                        </span>
                        <span class='text-xs sm:text-base text-center font-semibold text-textPrimary-100 block'>
                            <?php 
                            echo  get_post_meta( get_the_ID() , 'product_view' , true);
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full flex justify-between flex-wrap gap-3 mb-3">
            <div class="w-full lg:w-[calc(75%-8px)] lg:order-2">
                <?php if( ! empty( $product_spotplayer ) ) { ?> 
                <div class='flex flex-col justify-center items-start p-5 rounded-md  mb-2 bg-white-100'>
                    <div class='w-full flex justify-start items-center mb-5'>
                        <svg class='w-2 h-2 fill-primary-100 ml-1' viewBox="0 0 100 100"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="50" />
                        </svg>
                        <span class='text-primary-100 text-2xl font-extrabold'>لایسنس دوره</span>
                    </div>
                        <?php if ( $is_buy ) {
                            $spotplayer_key = amzshyar_user_products_buys_spotplayer_key(); ?>
                                <span class='mb-3 block text-justify text-base text-textPrimary-100'>باتوجه به سیستم عامل خود یکی از نسخه های موجود اسپات پلیر را دانلود و نصب کنید. بعد از نصب از طریق لایسنس زیر وارد نرم افزار شوید. بعد از وارد کردن لایسنس بصورت خودکار به محتوای دوره هدایت خواهید شد.</span>
                                <div class="text-textPrimary-100">
                                    <span class='mb-3 block font-bold'>لایسنس شما:</span>
                                    <?php if( ! empty( $spotplayer_key[$id_post] ) && ! empty( $spotplayer_key[$id_post]['key'] ) ) { ?>
                                    <code dir='ltr' class="product-spotplayer-lic-str block bg-primary-100 p-4 rounded-md text-textPrimary-100 mb-3 relative">
                                        <?php echo $spotplayer_key[$id_post]['key']; ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-[20px] h-[20px] stroke-white-100 cursor-pointer hover:opacity-70 absolute bottom-1 right-1" id='lic-copy' data-lic="<?php echo $spotplayer_key[$id_post]['key']; ?>">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
                                        </svg>
                                    </code>
                                   
                                    <?php } else { ?>
                                    <div class="block bg-primary-100 p-3 rounded-md text-textPrimary-100 mb-3">
                                        <span>لایسنس اسپات پلیر برای شما ساخته نشده است لطفا با پشتیبان سایت در ارتباط باشید.</span>
                                    </div>
                                    <?php } ?>
                                    <span class='mb-3 block font-bold mt-5'>دانلود اسپات پلیر:</span>
                                    <div class="flex gap-x-5 items-center mb-3">
                                        <div class='flex flex-col items-center'>
                                            <a href="http://dl.spotplayer.ir/assets/bin/spotplayer/setup.exe" target="_blank" download class="w-[40px] h-[40px] mb-2 rounded-lg hover:opacity-80">
                                                <img class='rounded-lg' src="<?php echo get_template_directory_uri() . '/images/win.png' ?>">
                                            </a>
                                            <span>نسخه ویندوز</span>
                                        </div>
                                        <div class='flex flex-col items-center'>
                                            <a href="http://dl.spotplayer.ir/assets/bin/spotplayer/setup.dmg" target="_blank" download class="w-[40px] h-[40px] mb-2 rounded-lg hover:opacity-80">
                                                <img class='rounded-lg' src="<?php echo get_template_directory_uri() . '/images/mac.png' ?>">
                                            </a>
                                            <span>نسخه مک</span>
                                        </div>
                                        <div class='flex flex-col items-center'>
                                            <a href="http://dl.spotplayer.ir/assets/bin/spotplayer/setup.apk" target="_blank" download class="w-[40px] h-[40px] mb-2 rounded-lg hover:opacity-80">
                                                <img class='rounded-lg' src="<?php echo get_template_directory_uri() . '/images/android.png' ?>">
                                            </a>
                                            <span>نسخه اندروید</span>
                                        </div>
                                    </div>
                                    <p class='text-textPrimary-100 flex items-center'>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="stroke-white-100 w-[25px] h-[25px] ml-1"">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                        </svg>
                                        اگر برای مشاهده فیلم ها  نیاز به راهنمایی دارید، می‌توانید فیلم های آموزشی را در 
                                        <a class='underline text-primary-100 mx-1' href='<?php echo home_url("/help"); ?>'>
                                            اینجا
                                        </a>
                                        ببینید. 
                                    </p>
                                </div>
                        <?php } else {  ?>
                                <span class='block text-justify text-base text-textPrimary-100 mb-2'>بعد از ثبت نام در این دوره، کلید لایسنس دوره در اختیار شما قرار خواهد گرفت. شما با قرار دادن کلید لایسنس در نرم افزار اسپات‌پلیر میتوانید به راحتی ویدیوهای دوره را مشاهده کنید.</span>
                                <p class='text-textPrimary-100 flex items-center'>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="stroke-white-100 w-[25px] h-[25px] ml-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                    </svg>
                                    اگر قبلا دوره را خریداری کرده‌اید ولی الان لایسنس را در اینجا مشاهده نمی‌کنید،
                                    <a class='underline text-primary-100 mx-1' href='<?php echo home_url("/help"); ?>'>
                                        اینجا
                                    </a>
                                    را کلیک کنید. 
                                </p>
                        <?php } ?>
                </div>
                <?php } ?> 

                <div
                    class='flex flex-col justify-center items-center p-5 rounded-md  mb-2 bg-white-100'>
                    <div class='w-full flex justify-start items-center mb-5'>
                        <svg class='w-2 h-2 fill-primary-100 ml-1' viewBox="0 0 100 100"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="50" />
                        </svg>
                        <span class='text-primary-100 text-2xl font-extrabold'>توضیحات</span>
                    </div>
                    <div class='more-content w-full leading-8 text-base font-light mt-3 relative transition-all duration-900 overflow-hidden text-textPrimary-100'
                        style="max-height : 200px">
                        <?php  the_content() ?>
                        <div class='gradientMore'>
                        </div>
                    </div>
                    <button
                        class="btn-more bg-white-100 mt-2 px-2 py-2 mb-5 text-gray-600 transition-all duration-500 hover:bg-background-100 bg-['transparent'] rounded-md group">
                        <span class="group-hover:text-textPrimary-100 text-textPrimary-100">
                            ادامه مطلب
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 mr-1 stroke-white-100 inline group-hover:stroke-white-100"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" strokeL-lnejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                
                <?php if($faqs){ ?>
                <div
                    class='flex flex-col justify-center items-center p-5 rounded-md  mb-2 bg-white-100'>
                    <div class='w-full flex justify-start items-center mb-5'>
                        <svg class='w-2 h-2 fill-primary-100 ml-1' viewBox="0 0 100 100"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="50" />
                        </svg>
                        <span class='text-primary-100 text-2xl font-extrabold'>سوالات متداول</span>
                    </div>
                    <?php 
                        foreach($faqs as $faq) {
                    ?>
                    <div
                        class='btn-collapse w-full h-16 text-base group bg-white-100 border font-semibold rounded-md p-3 flex justify-between items-center text-gray-600 hover:cursor-pointer'>
                        <div class='flex justify-start items-center'>
                            <div
                                class='rounded-lg py-1 px-3 ml-2 bg-background-100 lg:group-hover:bg-primary-100'>
                                <span
                                    class='text-lg sm:text-2xl font-bold lg:group-hover:text-textPrimary-100 text-textPrimary-100'>?</span>
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
                    <div class='h-15 w-full mb-3 transition-all duration-200  rounded-md max-h-0 overflow-hidden'>
                        <div class='mt-3 mr-14 p-3 bg-white-100 border rounded-md'>
                            <span
                                class='font-normal text-textPrimary-100'><?php echo $faq['answer_product']; ?></span>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
                
                <div
                    class='flex flex-col justify-center items-center  p-5 rounded-md mt-3 bg-white-100'>
                    <div class='w-full flex justify-start items-center mb-5'>
                        <svg class='w-2 h-2 fill-primary-100 ml-1' viewBox="0 0 100 100"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="50" />
                        </svg>
                        <span class='text-primary-100 text-2xl font-extrabold'>جلسات دوره</span>
                    </div>
                    <?php if(!empty($episodes) && $type == 'free' ){ ?>
                    <div class='w-full relative pt-[56%] lg:pt-[50%] rounded-lg mb-3'>
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
                    <div class='<?php echo ( can_see( $episode['episode_product_purchase_status'] , $episode['episode_product_show_status']  , get_the_ID() ) == 'play'  ) ? 'btn-episodes hover:cursor-pointer' : '' ?> <?php echo ( $episode['episode_product_number'] == 1 &&  can_see( $episode['episode_product_purchase_status'] , $episode['episode_product_show_status']  , get_the_ID() ) == 'play' ) ? 'border border-primary-100 ' : '' ?> group w-full h-fit flex mb-2 justify-between items-center bg-white-100 text-sm sm:text-base font-normal p-4 text-textPrimary-100 rounded-lg' data-video="<?php echo $episode['episode_product_video']; ?>">
                        <div
                            class='h-fit flex flex-col items-center py-[5px] px-[10px] rounded-lg bg-background-100 ml-2 font-bold text-textPrimary-100 <?php echo ( can_see( $episode['episode_product_purchase_status'] , $episode['episode_product_show_status']  , get_the_ID() ) == 'play'  ) ? 'group-hover:text-primary-100' : '' ?>'>
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
            </div>

            <div class="w-full lg:w-[calc(25%-8px)] lg:order-1">
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
                <div
                    class='teacher-prof flex flex-col justify-center items-center rounded-xl p-3 bg-white-100 hadow-none'>
                    <?php the_post_thumbnail('teacher'); ?>
                    <span class='text-lg font-bold mt-[5px] text-justify text-textPrimary-100'>

                    </span>
                    <span class='text-[0.9rem] text-justify font-normal text-textPrimary-100'>
                        <?php the_title(); ?>
                    </span>
                    <span class='text-[0.9rem] text-justify font-normal	my-2 text-textPrimary-100'>
                        <?php the_excerpt(); ?>
                    </span>
                </div>
                <?php
                            endwhile; 
                        }
                        wp_reset_query();
                ?>
            </div>
        </div>
        <div class='flex justify-end mb-[50px] md:mb-[70px]'>
            <div class="woocommerce w-full lg:w-9/12">
                <div id="comment-section"
                    class='w-full bg-white-100 flex flex-col justify-center items-center p-5 rounded-md text-[0.9rem] font-normal my-3'>
                    <div class='w-full flex justify-start items-center mb-5'>
                        <svg class='w-2 h-2 fill-primary-100 ml-1' viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="50" />
                        </svg>
                        <span class='text-primary-100 text-2xl font-extrabold'>نظرات</span>
                    </div>
                    <?php
                        if(comments_open() || get_comments_number()) :
                        comments_template();
                        endif;
                    ?>
                </div>
            </div>
        </div>
    </div>


</main>

<?php get_footer() ?>
<?php
}else{
    wc_get_template('archive-product.php');
}
?>

<script>
    document.querySelector('.video-cover').addEventListener('click', function() {
        this.style.display = 'none'; // حذف کاور
        document.querySelector('.video').play();
    });
</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo get_template_directory_uri() ?>/js/single-course.js"></script>