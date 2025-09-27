<?php
$products = new WP_Query(
    array(
        'post_type' => 'product',
        'posts_per_page' => 8 , 
    )
);
if($products->have_posts()){
?>

<div id='new-courses' class='flex justify-between mb-2 md:mb-6'>
    <div class='text-lg flex items-center font-semibold py-2 text-textPrimary-100'>
        <div class='w-[20px] h-[20px] rounded-md bg-primary-100 ml-2'></div>
        <span class="text-xl md:text-3xl font-bold">جدیدترین دوره‌های</span>
    </div>
    <div class='py-2 flex items-center'>
        <a href="<?php echo home_url(); ?>/courses"
            class='text-sm md:text-base transition-all duration-150 hover:text-primary-100 text-textPrimary-100 dark:hover:text-primary-100'>
            مشاهده همه 
        </a>
    </div>
</div>


<div class="w-full flex flex-wrap mb-[50px] md:mb-[80px]" >
    <div class="w-full swiper-container swiper slider-prducts" dir="rtl">
            <div class="swiper-wrapper">

            <?php 
                while($products->have_posts()):
                $products->the_post();
            ?>
            <div class="swiper-slide">
                <?php
                    wc_get_template_part( 'template/card', 'productSlider' );
                ?>  
            </div>

            <?php endwhile; ?>
            <?php wp_reset_query() ?>
                    
       
        </div>

        <div class="swiper-pagination"></div>

    </div>  
</div>

<?php } ?>