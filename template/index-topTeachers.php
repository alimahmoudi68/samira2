<?php
$teachers = new WP_Query(
    array(
        'post_type' => 'teacher',
        'posts_per_page' => 10, 
    )
);
if($teachers->have_posts()){
?>
<div class='flex justify-between mb-5 mt-3'>
    <div class='text-lg font-semibold text-gray-600 py-2 dark:text-text-primary-100'>
        <svg class="inline text-dark-600 dark:text-white ml-1" width="37" height="34" viewBox="0 0 37 34" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <circle cx="10" cy="24" r="10" fill="currentColor"></circle>
            <circle cx="30" cy="13" r="7" fill="currentColor" fill-opacity="0.4"></circle>
            <circle cx="15" cy="4" r="4" fill="currentColor" fill-opacity="0.7"></circle>
        </svg>
        <span class="text-xl md:text-3xl font-bold">مدرس‌های جدید</span>
    </div>
    <div class='py-2 flex items-center'>
        <a href="<?php echo home_url(); ?>/teachers"
            class='text-sm md:text-base transition-all duration-150 text-gray-500 hover:text-primary-100 dark:text-text-primary-100 dark:hover:text-primary-100'>
            مشاهده همه مدرس‌ها
            <svg class='w-4 h-4 inline mr-1 sm:h-6 sm:w-6 rotate-90' viewBox="0 0 14 21" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.4"
                    d="M8.29288 6.37436L8.65625 2.26557C8.65625 1.34349 7.90136 0.595886 6.9703 0.595886C6.03923 0.595886 5.28434 1.34349 5.28434 2.26557L5.64772 6.37436C5.64772 7.09773 6.23988 7.68418 6.9703 7.68418C7.70194 7.68418 8.29288 7.09773 8.29288 6.37436"
                    fill="currentColor"></path>
                <path
                    d="M8.22674 20.172C8.29159 20.1077 8.56565 19.8678 8.79322 19.6425C10.2186 18.3278 12.5493 14.8951 13.2626 13.0994C13.3764 12.8268 13.6186 12.1374 13.6357 11.7678C13.6357 11.4152 13.5538 11.0783 13.3923 10.7573C13.1659 10.3562 12.8087 10.0363 12.3878 9.85941C12.0966 9.74672 11.2218 9.56982 11.2059 9.56982C10.2504 9.39412 8.69656 9.2984 6.9788 9.2984C5.34423 9.2984 3.85403 9.39412 2.88259 9.53831C2.86546 9.55406 1.78024 9.73097 1.4083 9.92362C0.728047 10.2762 0.30717 10.9657 0.30717 11.7036V11.7678C0.323076 12.2488 0.745176 13.2594 0.759858 13.2594C1.47315 14.9593 3.69131 18.3108 5.1656 19.6582C5.1656 19.6582 5.54488 20.0387 5.78101 20.2035C6.12114 20.4603 6.54202 20.5888 6.96289 20.5888C7.43271 20.5888 7.86949 20.4446 8.22674 20.172"
                    fill="currentColor"></path>
            </svg>
        </a>
    </div>
</div>

<div class="swiper-container slider" dir="rtl">
    <div class="swiper-wrapper">
        <?php 
        while($teachers->have_posts()):
            $teachers->the_post();
        ?>
            <div class="swiper-slide">
                <?php
                wc_get_template_part( 'template/card', 'top-teachers' );
                ?>
            </div>
        <?php 
        endwhile; 
        wp_reset_query() 
        ?>    
      
    </div>
    <!-- If we need pagination -->
    <div class="swiper-pagination swiper-pagination-customer"></div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev swiper-button-prev-new"></div>
    <div class="swiper-button-next swiper-button-next-new"></div>

</div>
<!--------------------------------- /Slider new -------------------------------------------------------->
<?php } ?>