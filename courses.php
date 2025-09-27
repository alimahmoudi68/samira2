<?php
defined( 'ABSPATH' ) || exit;


// دریافت تمام دسته‌بندی‌های محصولات
$cats = get_terms( array(
    'taxonomy'   => 'product_cat', // نوع دسته‌بندی (taxonomy)
    'hide_empty' => false,         // برای نمایش تمام دسته‌بندی‌ها، حتی آن‌هایی که محصول ندارند
) );

// ---------  خواندن متای سفارشی دسته بندی  --------
//$attributes = get_term_meta( $term_id , 'category_attributes', true); // دریافت ویژگی‌های ذخیره‌شده
$attributes = array('course_type');


// ---------  /خواندن متای سفارشی دسته بندی  --------
$max_price_product = 10000000;

$limit = 20;
$page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '1';
$sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : '';
$priceMin = isset($_GET['priceMin']) ? sanitize_text_field($_GET['priceMin']) : 0;
$priceMax = isset($_GET['priceMax']) ? sanitize_text_field($_GET['priceMax']) : $max_price_product;


$args = array(
    'post_type'      => 'product',
    'post_status' => 'publish' ,
    'no_found_rows' => true ,
    'posts_per_page' => $limit,
    'paged' => $page  ,              
);


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


// اعمال فیلتر بر اساس دسته بندی
if(  $cat  !== ''  ){

    $catArr = explode( ",", $cat ) ; 

    $args ['tax_query'] = array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    =>  $catArr,
        ),
    );
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


// فیلتر کردن بر اساس ویژگی‌های داینامیک (تاکسونومی‌های محصول)
foreach ($attributes as $attribute) {
    $attribute_name = $attribute ; // ? مثل color
    if ( isset($_GET[$attribute_name]) ) { // اگر ویژگی‌ای از درخواست ارسال شده باشد
        $terms = explode(',', sanitize_text_field($_GET[$attribute_name]));
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


$query = new WP_Query($args);

$products = array(); // آرایه‌ای برای ذخیره اطلاعات محصولات

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post(); // تنظیم داده‌های پست

        $product_id = get_the_ID(); // دریافت ID محصول
        $product_title = get_the_title(); // دریافت عنوان محصول
        $product_permalink = get_permalink(); // دریافت لینک دائمی محصول
        $product_img_thumbnail = get_the_post_thumbnail_url($product_id, 'thumbnail'); 
        $product_img_medium = get_the_post_thumbnail_url($product_id, 'medium'); 
        $product_img_450 = get_the_post_thumbnail_url($product_id, 'product-450'); 
        $product_status = get_post_meta($product_id , 'product_status' , true);
        $product_total_time = get_total_time_course(get_post_meta(get_the_ID() , 'episode_group' , true));
        $product_episode_count = count(get_post_meta(get_the_ID() , 'episode_group' , true));


        global $product;
    
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
    

        // ذخیره عنوان و قیمت محصول در آرایه
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
            'episode_count' => $product_episode_count
        );
    }

    wp_reset_postdata(); // بازنشانی داده‌های پست



    //------- pagination -------
    $total_args = $args;
    unset($total_args['posts_per_page']);
    unset($total_args['paged']);
    unset($total_args['no_found_rows']); // برای محاسبه تعداد کل محصولات، باید این را حذف کنیم

    $total_query = new WP_Query($total_args);
    $total_products = $total_query->found_posts; // تعداد کل محصولات با توجه به شرط‌ها
    //------- /pagination -------

}else{
    $products = array();
    $total_products = 0;
}



$filterObj = new stdClass();
$filterElKeyObj = new stdClass();
$product_attributes = array(); 


?>

<?php get_header() ?>

<main class='w-full flex-grow mb-5 px-2 py-3 md:mt-[80px]'>
    <div class="container mx-auto my-3 flex flex-col items-end">

        <div x-data="products()" @scroll.window="checkScroll()" class='w-full flex flex-col'>

            <div class='my-scroll w-full flex flex-row gap-x-3 mb-4 pb-2 overflow-x-auto md:overflow-x-visible scroll-smooth'>
                

                <?php 
                $attributeName = 'cat';
                $filterElKeyObj->$attributeName="";
                $filterObj->$attributeName=array();
                ?>
                <div x-data="dropdown" class="flex flex-col bg-darkCard-100 rounded-lg relative">
                    <div :class="{'md:border-gray-800' : open}" class='flex items-center gap-x-2 cursor-pointer px-4 py-2 text-textPrimary-100 border border-darkCard-100 md:hover:border-gray-800 rounded-md' @click="toggle()">
                        <h4>دسته بندی‌</h4>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="{'rotate-[180deg]': open}" class="w-[20px] h-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                    <div x-show="open" x-cloak class='bg-darkTransparent-100 fixed right-0 left-0 bottom-0 top-0 z-[999999999999999999999999] md:hidden'></div>
                    <div x-show="open" x-cloak x-collapse.duration.100ms  @click.outside="close" class='flex flex-col bg-darkCard-100 md:border md:border-gray-800 fixed left-0 bottom-0 z-[9999999999999999999999999] md:absolute gap-y-3 p-3 rounded-md md:top-[50px] md:bottom-auto md:left-auto right-0 md:z-[100000000000000]'>
                        <div class='flex items-center gap-x-1'>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-[16px] h-[16px] stroke-white-100">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <input x-model="filterElementKey['cat']" class='outline-none text-textPrimary-100 text-[0.9rem] placeholder:text-[0.9rem] bg-darkBack-100 placeholder:font-light placeholder:text-textPrimary-100 p-2' placeholder='جستجو'>
                        </div>
                        <?php
                        foreach ( $cats as $term ) {
                        ?>
                            <div x-show="isShowFilterElement('cat' , '<?php echo $term->name ?>')" class="w-full flex items-center gap-x-2 cursor-pointer" data-id="<?php echo $term->slug ?>" @click="updateFilters('<?php echo $term->slug ?>' , 'cat')">
                                <div class='w-[16px] h-[16px] border border-gray-600' :class="{'bg-primary-100 border-primary-100': filtersTemp['cat'].includes('<?php echo $term->slug ?>')}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" :class="{'hidden': !filtersTemp['cat'].includes('<?php echo $term->slug ?>')}" class="w-[16px] h-[18px] stroke-white-100">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                </div>
                                <span class='text-textPrimary-100'><?php echo $term->name ?>(<?php echo $term->count ?>)</span>
                            </div>
                        <?php 

                        $term_data[] = array(
                            'key' => $term->slug,    // Term slug (e.g., 'blue')
                            'value' => $term->name   // Term name (e.g., 'آبی')
                        );

                        }
                        ?>
                        <div class='flex items-center justify-center gap-x-2'>
                            <div class='border border-darkBack-100 px-3 py-1 cursor-pointer rounded-md' @click="clearFilter('cat')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-[24px] h-[24px] stroke-white-100">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </div>
                            <div class='px-3 py-1 bg-primary-100 text-textPrimary-100 cursor-pointer rounded-md' @click="makeFilterUrl(1)">
                                اعمال
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $product_attributes['cat'] = $term_data;
                ?>
                
                
                <?php 
                if ( true ) {

                        foreach ( $attributes as $attribute ) {

                            $attributeName = $attribute;
                            $filterElKeyObj->$attributeName="";
                            $filterObj->$attributeName=array();

                            $taxonomy = 'pa_' . $attributeName;

                            // Get terms for the attribute used by products in this category
                            $terms = get_terms( array(
                                'taxonomy' => $taxonomy,
                                'hide_empty' => true,
                            ));


                            if ( $terms ) { ?>
                                <div x-data="dropdown" class="flex flex-col bg-darkCard-100 rounded-lg relative">
                                    <div :class="{'md:border-gray-800' : open}" class='flex items-center gap-x-2 cursor-pointer px-4 py-2 text-textPrimary-100 border border-darkCard-100 md:hover:border-gray-800 rounded-md' @click="toggle()">
                                        <h4><?php echo wc_attribute_label($taxonomy) ?></h4>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="{'rotate-[180deg]': open}" class="w-[20px] h-[20px]">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </div>
                                    <div x-show="open" x-cloak class='bg-darkTransparent-100 fixed right-0 left-0 bottom-0 top-0 z-[999999999999999999999999] md:hidden'></div>
                                    <div x-show="open" x-cloak x-collapse.duration.100ms  @click.outside="close" class='flex flex-col bg-darkCard-100 md:border md:border-gray-800 fixed left-0 bottom-0 z-[9999999999999999999999999] md:absolute gap-y-3 p-3 rounded-md md:top-[50px] md:bottom-auto md:left-auto right-0 md:z-[100000000000000]'>
                                        <div class='flex items-center gap-x-1'>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-[16px] h-[16px] stroke-white-100">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                            </svg>
                                            <input x-model="filterElementKey['<?php echo $attributeName; ?>']" class='outline-none text-textPrimary-100 text-[0.9rem] placeholder:text-[0.9rem] bg-darkBack-100 placeholder:font-light placeholder:text-textPrimary-100 p-2' placeholder='جستجو'>
                                        </div>
                                        <?php
                                        $term_data = array(); 
                                        foreach ( $terms as $term ) {
                                            // Count the number of products for each term
                                            $product_count = count( get_posts( array(
                                                'post_type' => 'product',
                                                'posts_per_page' => -1,
                                                'fields' => 'ids', // Only get IDs to improve performance
                                                'tax_query' => array(
                                                    array(
                                                        'taxonomy' => $taxonomy,
                                                        'field'    => 'slug',
                                                        'terms'    => $term->slug,
                                                    ),
                                                ),
                                            )));
                                        ?>
                                            <div x-show="isShowFilterElement('<?php echo $attributeName; ?>' , '<?php echo $term->name ?>')" class="w-full flex items-center gap-x-2 cursor-pointer" data-id="<?php echo $term->slug ?>" @click="updateFilters('<?php echo $term->slug ?>' , '<?php echo $attributeName ?>')">
                                                <div class='w-[16px] h-[16px] border border-gray-600' :class="{'bg-primary-100 border-primary-100': filtersTemp['<?php echo $attributeName ?>'].includes('<?php echo $term->slug ?>')}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" :class="{'hidden': !filtersTemp['<?php echo $attributeName ?>'].includes('<?php echo $term->slug ?>')}" class="w-[16px] h-[18px] stroke-white-100">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                                    </svg>
                                                </div>
                                                <span class='text-textPrimary-100'><?php echo $term->name ?>(<?php echo $product_count ?>)</span>
                                            </div>
                                        <?php 

                                        $term_data[] = array(
                                            'key' => $term->slug,    // Term slug (e.g., 'blue')
                                            'value' => $term->name   // Term name (e.g., 'آبی')
                                        );

                                        }
                                        ?>
                                        <div class='flex items-center justify-center gap-x-2'>
                                            <div class='border border-darkBack-100 px-3 py-1 cursor-pointer rounded-md' @click="clearFilter('<?php echo $attributeName ?>')">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-[24px] h-[24px] stroke-white-100">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </div>
                                            <div class='px-3 py-1 bg-primary-100 text-textPrimary-100 cursor-pointer rounded-md' @click="makeFilterUrl(1)">
                                                اعمال
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                            
                            $product_attributes[$attributeName] = $term_data; // Add this attribute's terms to the result

                            }
                        }
                        ?>
                    <?php    
                    
                }
                ?>


                <!-- price dropdown -->
                <?php 

                    $filterObj->priceMin=array(); 
                    $filterObj->priceMax=array(); 
                ?>
                <div x-data="dropdown" class="flex flex-col bg-darkCard-100 rounded-lg relative">
                    <div :class="{'md:border-gray-800' : open}" class='flex items-center gap-x-2 cursor-pointer text-textPrimary-100 px-4 py-2 border border-darkCard-100 md:hover:border-gray-800 rounded-md' @click="toggle()">
                        <h4>قیمت</h4>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="{'rotate-[180deg]': open}" class="w-[20px] h-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                    <div x-show="open" x-cloak class='bg-darkTransparent-100 fixed right-0 left-0 bottom-0 top-0 z-[999999999999999999999999] md:hidden'></div>
                    <div x-show="open" x-cloak x-collapse.duration.100ms  @click.outside="close" class='flex flex-col bg-darkCard-100 text-textPrimary-100 md:border md:border-gray-800 fixed left-0 bottom-0 z-[9999999999999999999999999] md:absolute gap-y-3 p-3 rounded-md md:top-[50px] md:bottom-auto md:left-auto right-0 md:z-[100000000000000]'>
                        <!-- slider price -->
                        <div class='w-[100%] max-w-[300px] mx-auto flex flex-col justify-center items-center px-[16px] pt-[20px]'>
                            <tc-range-slider 
                            value1="0" 
                            value2="<?php echo $priceMax ?>" 
                            id="price-slider"
                            min= "0" 
                            max= "<?php echo $max_price_product ?>" 
                            round="0"
                            step="1000"
                            >
                            </tc-range-slider>
                            <div class='flex flex-col mt-[10px]'>
                                <div>
                                    <span>
                                        از
                                    </span>
                                    <span x-text='showPriceMin()' class='outline-none text-[0.9rem] placeholder:text-[0.9rem] placeholder:font-light placeholder:text-gray-600'></span>
                                </div>
                                <div>
                                    <span>
                                        تا
                                    </span>
                                    <span x-text='showPriceMax()' class='outline-none text-[0.9rem] placeholder:text-[0.9rem] placeholder:font-light placeholder:text-gray-600'></span>
                                </div>
                            </div>
                        </div>

                        <div class='flex items-center justify-center gap-x-2'>
                            <div class='border border-darkBack-100 px-3 py-1 cursor-pointer rounded-md' @click="clearPricesFilter()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-[24px] h-[24px] stroke-white-100">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </div>
                            <div class='px-3 py-1 bg-primary-100 text-textPrimary-100 cursor-pointer rounded-md' @click="makeFilterUrl(1)">
                                اعمال
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='flex items-center mb-4 md:mb-8 gap-x-3'>
                <template x-for="item in filterToList(filters)">
                    <div class='flex items-center gap-x-3 px-3 py-1 rounded-md bg-gray-500'>
                        <span x-text="getAttribiteName(item.key , item.value)" class='text-textPrimary-100'></span>
                        <svg @click="updateFilters(item.value , item.key , true)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-[16px] h-[16px] stroke-white-100 cursor-pointer hover:opacity-80">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </div>
                </template>
            </div> 

            <div class='w-full flex min-[350px]:gap-[10px] flex-wrap relative'>

                <span x-show="!loading && products.length==0" x-cloak class='mx-auto my-[60px] text-textPrimary-100'>
                دوره‌ای پیدا نشد :(
                </span>
 

                <template x-for="product in products">
                    <div class='w-[calc(50%-10px)] md:w-[calc(33%-20px)] lg:w-[calc(25%-30px)] card-product flex flex-col items-center transition-all duration-300 rounded-lg bg-darkCard-100 relative'>
                        <a :href="product.link" class='w-full h-auto relative'>
                            <div class='absolute left-[10px] top-[10px] flex flex-col gap-y-3 backdrop-blur-lg'>
                                <template x-for="color in product.colors">
                                    <span x-text="color" class='text-[0.8] font-light bg-white-50 text-gray-600 px-2 py-1'></span>
                                </template>
                            </div>
                            <img :src='product.image_medium'
                            :srcset="product.image_thumbnail + ' 150w, ' + product.image_medium + ' 300w,' + product.image_450 + ' 450w'"
                            sizes="50vw , (min-width: 768px) 33vw  , (min-width: 1024px) 25vw" 
                            loading="lazy" 
                            decoding="async"
                            class='w-full' 
                            width="300" 
                            height="300"/>
                        </a>
                        <div class='w-full flex flex-col p-3'>
                            <div class='flex items-center text-sm font-semibold text-primary-100'>
                                <svg class='w-2 h-2 fill-primary-100 ml-1' viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="50" cy="50" r="50" />
                                </svg>
                                <span x-text="statusToText(product.status)"></span>
                            </div>
                            <a x-text='product.title' :href="product.link" class='w-full h-[50px] flex items-start flex-grow text-[1.2rem] font-semibold text-textPrimary-100'>
                            </a>
                            <div class='flex items-center'>
                                <div class='flex items-center gap-x-2'>
                                    <div class='flex justify-center items-center rounded-md bg-darkBack-100 text-textPrimary-100 p-1'>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} class="m w-4 h-4 ml-1 stroke-white-100">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0 1 18 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0 1 18 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 0 1 6 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 10.875c0 .621-.504 1.125-1.125 1.125M18 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m-12 5.25v-5.25m0 5.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125m-12 0v-1.5c0-.621-.504-1.125-1.125-1.125M18 18.375v-5.25m0 5.25v-1.5c0-.621.504-1.125 1.125-1.125M18 13.125v1.5c0 .621.504 1.125 1.125 1.125M18 13.125c0-.621.504-1.125 1.125-1.125M6 13.125v1.5c0 .621-.504 1.125-1.125 1.125M6 13.125C6 12.504 5.496 12 4.875 12m-1.5 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M19.125 12h1.5m0 0c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h1.5m14.25 0h1.5" />
                                        </svg>
                                        <span class='inline whitespace-nowrap text-[0.8rem]' x-text="`${product.episode_count} جلسه`"></span>
                                    </div>
                                    <div class='flex justify-center items-center rounded-md bg-darkBack-100 text-textPrimary-100 p-1'>
                                        <svg class="m w-4 h-4 ml-1" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M1.29921 7.10036C1.29921 8.47492 1.37342 9.55017 1.56095 10.394C1.74739 11.2329 2.04007 11.8164 2.45902 12.2353C2.87796 12.6543 3.4615 12.947 4.30041 13.1334C5.14419 13.3209 6.21945 13.3952 7.594 13.3952C8.96856 13.3952 10.0438 13.3209 10.8876 13.1334C11.7265 12.947 12.31 12.6543 12.729 12.2353C13.1479 11.8164 13.4406 11.2329 13.6271 10.394C13.8146 9.55017 13.8888 8.47492 13.8888 7.10036C13.8888 5.72581 13.8146 4.65055 13.6271 3.80677C13.4406 2.96786 13.1479 2.38432 12.729 1.96538C12.31 1.54643 11.7265 1.25375 10.8876 1.06731C10.0438 0.879784 8.96856 0.805572 7.594 0.805572C6.21945 0.805572 5.14419 0.879784 4.30041 1.06731C3.4615 1.25375 2.87796 1.54643 2.45902 1.96538C2.04007 2.38432 1.74739 2.96786 1.56095 3.80677C1.37342 4.65055 1.29921 5.72581 1.29921 7.10036Z"
                                                stroke="currentColor" strokeWidth="0.858919" strokeLinecap="round" strokeLinejoin="round">
                                            </path>
                                            <path
                                                d="M7.59399 3.73825C7.59399 3.73825 7.59399 5.97967 7.59399 6.54002C7.59399 7.10038 7.59399 7.10038 8.15435 7.10038C8.71471 7.10038 10.9561 7.10038 10.9561 7.10038"
                                                stroke="currentColor" strokeWidth="0.858919" strokeLinecap="round" strokeLinejoin="round">
                                            </path>
                                        </svg>
                                        <span class='text-[0.8rem]' x-text='product.total_time'></span>
                                    </div>
                                </div>
                                <div class='w-full flex flex-col justify-center items-end text-sm font-light h-[40px]'>
                                    <span x-show='product.formatted_sale_price !== 0' x-cloak x-text="product.formatted_regular_price + ' ' + 'تومان'" class='text-red-600 line-through'></span>
                                    <span x-text="showPrice(product.formatted_sale_price , product.formatted_regular_price)" class='text-textPrimary-100 font-medium'></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div x-show="loading" x-cloak class='mt-[10px] w-full flex flex-wrap gap-[10px]'>
                <div class='w-[calc(50%-10px)] md:w-[calc(33%-20px)] lg:w-[calc(25%-30px)] h-[250px] bg-skeleton'></div>
                <div class='w-[calc(50%-10px)] md:w-[calc(33%-20px)] lg:w-[calc(25%-30px)] h-[250px] bg-skeleton'></div>
                <div class='w-[calc(50%-10px)] md:w-[calc(33%-20px)] lg:w-[calc(25%-30px)] h-[250px] bg-skeleton'></div>
                <div class='w-[calc(50%-10px)] md:w-[calc(33%-20px)] lg:w-[calc(25%-30px)] h-[250px] bg-skeleton'></div>
                <div class='w-[calc(50%-10px)] md:w-[calc(33%-20px)] lg:w-[calc(25%-30px)] h-[250px] bg-skeleton'></div>
                <div class='w-[calc(50%-10px)] md:w-[calc(33%-20px)] lg:w-[calc(25%-30px)] h-[250px] bg-skeleton'></div>
                <div class='w-[calc(50%-10px)] md:w-[calc(33%-20px)] lg:w-[calc(25%-30px)] h-[250px] bg-skeleton'></div>
                <div class='w-[calc(50%-10px)] md:w-[calc(33%-20px)] lg:w-[calc(25%-30px)] h-[250px] bg-skeleton'></div>
                <div class='w-[calc(50%-10px)] md:w-[calc(33%-20px)] lg:w-[calc(25%-30px)] h-[250px] bg-skeleton'></div>
                <div class='w-[calc(50%-10px)] md:w-[calc(33%-20px)] lg:w-[calc(25%-30px)] h-[250px] bg-skeleton'></div>
                <div class='w-[calc(50%-10px)] md:w-[calc(33%-20px)] lg:w-[calc(25%-30px)] h-[250px] bg-skeleton'></div>
                <div class='w-[calc(50%-10px)] md:w-[calc(33%-20px)] lg:w-[calc(25%-30px)] h-[250px] bg-skeleton'></div>
            </div> 

        </div>

    </div>
</main>


<?php 
foreach ($attributes as $attribute) {
    $attribute_name = $attribute; // ? مثل color
    if ( isset($_GET[$attribute_name]) ) { // اگر ویژگی‌ای از درخواست ارسال شده باشد
        $terms = explode(',', sanitize_text_field($_GET[$attribute_name]));
        $filterObj->$attribute_name = $terms;

    }
}

if ( isset($_GET['priceMin']) ) {
    $terms = explode(',', sanitize_text_field($_GET['priceMin']));
    $filterObj->priceMin = $terms;

}

if ( isset($_GET['priceMax']) ) {
    $terms = explode(',', sanitize_text_field($_GET['priceMax']));
    $filterObj->priceMax = $terms;

}

?>

<script>
    document.addEventListener("alpine:init" , ()=>{
        Alpine.data('dropdown' , ()=>({
        open:false ,
        close(){
            if(open){
                let filtersOld = this.filters;
                this.filtersTemp = filtersOld;
                this.filtersTemp = JSON.parse(JSON.stringify(this.filters)); 
                this.open = false;

                $slider.value1 = this.filtersTemp.priceMin[0] ?? 0;
                $slider.value2 = this.filtersTemp.priceMax[0] ?? 10000000;
            }
        },
        toggle(){
            let filtersOld = {...this.filters};
            this.filtersTemp = JSON.parse(JSON.stringify(this.filters)); 
            this.open = !this.open;
        },
        }));
    })


    function products() {
        return {
            url : ' <?php echo home_url(); ?>/product-category/<?php echo $category_slug ?>?' ,
            filterElementKey : <?php echo json_encode( $filterElKeyObj ); ?>,
            filtersTemp : <?php echo json_encode( $filterObj ); ?>,
            filters : <?php echo json_encode( $filterObj ); ?>,
            allAttributes : <?php echo json_encode( $product_attributes); ?> ,
            products: <?php echo json_encode( $products); ?> ,
            loading: false,
            maxPriceProduct : <?php echo $max_price_product ?> ,
            page: 1,
            totalPage :  Math.ceil(<?php echo intval($total_products) ?> / <?php echo intval($limit) ?>),
            init() {
                this.$el.addEventListener('my-custom-event', (event) => {
                   this.changePriceMin(event.detail.priceMin);
                   this.changePriceMax(event.detail.priceMax);
                });
            },
            fetchProducts(query , p) {
                if (this.loading) return;
                this.loading = true;

                console.log('qq' , query)

                if(p == 1){
                    this.products = [];
                }else{
                    query = `page=${p}${query.length > 0 ?  '&' : ''}${query}`;
                }

                // Fetch data from the API
                fetch(`<?php echo home_url(); ?>/wp-json/myapi/v1/products?page=${p}${query !== "" ? '&'+query : ''}`)
                    .then(response => response.json())
                    .then(data => {
                        //console.log(data)
                        if(data.products.length > 0){
                            if(p==1){
                                this.products = data.products;
                            }else{
                                this.products.push(...data.products);
                            }
                            this.page = p; 
                            
                            this.totalPage =  Math.ceil(data.total_products / <?php echo intval($limit) ?>) ;
                            
                        }else{

                            this.totalPage = 0;
                        }

            
                        this.loading = false;

                        window.history.pushState({}, '', this.url+query);
                    })
                    .catch(error => {
                        console.error('Error fetching products:', error);
                        this.loading = false;
                    });
            },
            makeFilterUrl(nextPage){

                let filtersTempOld = {...this.filtersTemp};
                // اگر فیلتر قیمت صفر و ماکریمم قیمت محصولات باشد دیگر اعمال نشود
                if(filtersTempOld.priceMin == 0 && filtersTempOld.priceMax == this.maxPriceProduct){
                    filtersTempOld['priceMax'] = [];
                    filtersTempOld['priceMin'] = [];
                }
                this.filters = filtersTempOld; 
                //this.filters = JSON.parse(JSON.stringify(this.filtersTempOld)); // اینجوری هم میشه برای نمونه


                let filterArr = Object.keys(this.filters).map((key) => [key, this.filters[key]]);
                const result = [];

                filterArr.forEach(item => {
                    const key = item[0];
                    const values = item[1];

                    if (values.length > 0) { 
                        result.push(`${key}=${values.join(',')}`);
                    }
                });

                let query =  result.join('&');
                console.log(query)
                console.log('nextPage' , nextPage)

                this.fetchProducts(query , nextPage);
                this.open = false;

            },
            filterToList(obj){

                const result = [];

                for (const key in obj) {
                    if (obj.hasOwnProperty(key)) {
                        const values = obj[key];

                        values.forEach(value => {
                            if(value == 0 || value ==  this.maxPriceProduct){
                                // برای قیمت صفر و قیمت ماکزیمم  کادر فیلتر های انتخاب شده نذار
                            }else{
                                result.push({ key: key, value: value });
                            }
                        });
                    }
                }

                console.log('re' , result)

                return result;

            },
            isShowFilterElement(filterName , attributeName){

                if(attributeName.includes( this.filterElementKey[filterName] )){
                    return true;
                }else{
                    return false;
                }

            },
            updateFilters(id , type , isMakeFilterUrl = false) {

                console.log('>>>>>' ,type, id);

                if(this.filtersTemp[type].includes(id)){
                    let oldFilters = this.filtersTemp ;
                    oldFilters[type] = oldFilters[type].filter(item => item !== id);
                    this.filtersTemp = oldFilters;

                }else{

                    let oldFilters = this.filtersTemp ;
                    oldFilters[type].push(id);
                    this.filtersTemp = oldFilters;
                }

                if(isMakeFilterUrl){
                    if(type=='priceMin' || type=='priceMax'){
                        $slider.value1 = this.filtersTemp.priceMin[0] ?? 0;
                        $slider.value2 = this.filtersTemp.priceMax[0] ?? 10000000;
                    }
                    this.makeFilterUrl(1);
                }
                
                console.log( 'filterElementKey', this.filterElementKey);
                //console.log('filtersTemp' , this.filtersTemp);
                //console.log('allAttributes' , this.allAttributes);
                //console.log('products' , this.products);
                //console.log('totalPage' , this.totalPage);

            },
            clearFilter(type) {
                let oldFiltersTemp = this.filtersTemp ;
                oldFiltersTemp[type] = [];
                this.filtersTemp = oldFiltersTemp;
            },
            clearPricesFilter(){
                let oldFiltersTemp = this.filtersTemp ;
                oldFiltersTemp['priceMax'] = [];
                oldFiltersTemp['priceMin'] = [];
                this.filtersTemp = oldFiltersTemp;
                $slider.value1 = 0;
                $slider.value2 = this.maxPriceProduct;
            },
            getAttribiteName(attribute , term){

                console.log('attribute>>' , attribute)
                console.log('term>>' , term)

                if(attribute == 'priceMin'){
                    return ('از قیمت' + ' ' + term);
                }else if(attribute == 'priceMax'){
                    return ('تا قیمت' + ' ' + term);
                }else{
                    let termObj = this.allAttributes[attribute].filter(item=>item.key == term);
                    return termObj[0].value;
                }
               
            },
            changePriceMin(price){
                this.filtersTemp.priceMin[0] = price;
            },
            changePriceMax(price){
                this.filtersTemp.priceMax[0] = price;
            },
            showPriceMin(){
                return this.filtersTemp.priceMin[0] ? Number(this.filtersTemp.priceMin[0]).toLocaleString() : 0 ;
            },
            showPriceMax(){
                return this.filtersTemp.priceMax[0] ? Number(this.filtersTemp.priceMax[0]).toLocaleString() : Number(this.maxPriceProduct).toLocaleString() ;
            },
            statusToText(status){

                if(status == 'soon'){
                    return 'به زودی';
                }else if(status == 'continue'){
                    return 'در حال برگزاری'; 
                }else if(status == 'finish'){
                    return 'تکمیل ضبط';
                }else{
                    return '-';
                }

            },
            showPrice(salePrice , reqular_price){
                if( Number(salePrice) !== 0){
                    return `${salePrice} تومان`;
                }else if(Number(reqular_price) !== 0){
                    return `${reqular_price} ت`;
                }else{
                    return 'رایگان';
                }
            },
            checkScroll() {
                if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 100) {
                    if( !this.loading && (this.page < this.totalPage) ){
                        this.makeFilterUrl((this.page)+1);
                    }
                }
            }
        };
    }

</script>



<script>
    const $slider = document.getElementById('price-slider');

    $slider.addEventListener('change', (evt) => {
        //console.log(evt.detail.value1, evt.detail.value2);
        const alpineElement = document.querySelector('[x-data="products()"]');
        const dataToSend = { priceMin: evt.detail.value1  , priceMax : evt.detail.value2};
        const event = new CustomEvent('my-custom-event', {
            detail: dataToSend,
        });
        alpineElement.dispatchEvent(event);

    });

</script>

<?php get_footer() ?>


