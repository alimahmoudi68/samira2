<?php
defined( 'ABSPATH' ) || exit;

// get portfolio posts
$args = array(
    'post_type'      => 'portfolio',
    'posts_per_page' => -1,          // دریافت همه پست‌ها
    'post_status'    => 'publish'   
);
$portfolios = new WP_Query($args);


if ($portfolios->have_posts()) {
?>

<div class='text-lg flex items-center font-semibold py-2 text-textPrimary-100'>
    <span class="text-xl md:text-3xl font-bold">آخرین نمونه کارها</span>
</div>


<div class="w-full flex flex-wrap" >
        <div class="w-full swiper-container swiper slider-portfolio pb-65" dir="rtl">
            <div class="swiper-wrapper">

                <?php 
                    while($portfolios->have_posts()):
                        $portfolios->the_post();
                ?>
                <div class="swiper-slide">
                    <?php
                        get_template_part( 'template/card', 'portfolio' );
                    ?>  
                </div>

                <?php endwhile; ?>
                <?php wp_reset_query() ?>
                        
            </div>

            <div class="swiper-pagination"></div>

        </div>  
    </div>
<?php 
}
?>

