<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<main class='w-full flex-grow'>
    <div class="container mx-auto px-6 pt-[80px] md:pt-[100px] md:pb-[100px]">
        <?php get_template_part('template/index' , 'topBanner') ?>
        <?php get_template_part('template/index' , 'portfolio') ?>
        <?php get_template_part('template/index' , 'whyUs') ?>
        <?php get_template_part('template/index' , 'newProduct') ?>
        <?php get_template_part('template/index' , 'comments') ?>
        <?php get_template_part('template/index' , 'faq') ?>
    </div>
</main>
<div class='portfolio-detail-container hidden bg-black-70 fixed top-0 bottom-0 left-0 right-0 flex flex-col items-center justify-center z-[999999999]'>
    <div class="relative w-full max-w-[80%] md:max-w-[50%] rounded-lg overflow-hidden bg-black">

        <img src="" class="mx-auto my-auto object-contain">

        <!-- استفاده از نسبت تصویر 9 به 16 -->
        <div class="portfolio-detail-video-container relative aspect-[16/9] w-full rounded-lg flex items-center justify-center overflow-hidden">

            <video controls class="portfolio-detail-video absolute top-0 left-0 w-full h-full object-contain rounded-lg bg-black-100">
                <source type="video/mp4">
                مرورگر شما از ویدیو پشتیبانی نمی‌کند.
            </video>
            <!-- لودینگ -->
            <div class="loading-portfolio-detail" style="
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
<?php get_footer() ?>



