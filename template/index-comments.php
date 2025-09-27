<?php 
defined( 'ABSPATH' ) || exit;

$reviews= new WP_Query(
    array(
        'post_type' => 'review',
        'posts_per_page' => 8 , 
    )
);
if($reviews->have_posts()){
?>

<div class='flex justify-between mb-2 md:mb-6'>
    <div class='text-lg flex items-center font-semibold py-2 text-text-primary-100'>
        <div class='hidden md:block md:w-[20px] md:h-[20px] rounded-md bg-primary-100 ml-2'></div>
        <span class="text-xl md:text-3xl font-bold">نظرات هنرجویان</span>
    </div>
</div>


<div class="w-full flex flex-wrap mb-[50px] md:mb-[80px]" >
    <div class="w-full swiper-container swiper slider-comments" dir="rtl">
            <div class="swiper-wrapper">

                <?php 
                    while($reviews->have_posts()):
                        $reviews->the_post();
                ?>
                <div class="swiper-slide">
                    <?php
                        get_template_part( 'template/card', 'commentSlider' );
                    ?>  
                </div>

                <?php endwhile; ?>
                <?php wp_reset_query() ?>
                    
            </div>
            
            <div class="swiper-pagination"></div>

        </div>  
</div>

<?php } ?>


<div class='video-review-container hidden bg-black-70 fixed top-0 bottom-0 left-0 right-0 flex flex-col items-center justify-center z-999999999'>
    <div class="relative w-full max-w-[80%] md:max-w-[50%] rounded-lg overflow-hidden bg-black">
        <!-- استفاده از نسبت تصویر 9 به 16 -->
        <div class="relative aspect-video w-full rounded-lg overflow-hidden">
            <video controls class="video-review absolute top-0 left-0 w-full h-full object-contain rounded-lg bg-black-100">
                <source type="video/mp4">
                مرورگر شما از ویدیو پشتیبانی نمی‌کند.
            </video>
               <!-- لودینگ -->
               <div class="loading-indicator" style="
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
</div>

