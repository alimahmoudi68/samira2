<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<main class='w-full flex-grow px-6 md:pt-[100px] md:pb-[100px]'>
    <div class="container mx-auto">
        <?php get_template_part('template/index' , 'topBanner') ?>
        <?php get_template_part('template/index' , 'portfolio') ?>
        <?php get_template_part('template/index' , 'whyUs') ?>
        <?php get_template_part('template/index' , 'newProduct') ?>
        <?php get_template_part('template/index' , 'comments') ?>
        <?php get_template_part('template/index' , 'faq') ?>
    </div>
</main>
<div class='portfolio-detail-container hidden bg-black-80 fixed top-0 bottom-0 left-0 right-0 flex flex-col items-center justify-center z-[999999999]'>
    <!-- Container for image with close button -->
    <div class="portfolio-detail-img-container relative w-full max-w-[80%] md:max-w-[50%] max-h-[80%] rounded-lg overflow-visible bg-black">
        <div class="relative w-full h-full flex items-center justify-center">
            <div class="portfolio-image-container">
                <img src="" class="portfolio-image">
                
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} class="portfolio-close-btn">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
        </div>
    </div>

    <!-- استفاده از نسبت تصویر 9 به 16 -->
    <div class="portfolio-detail-video-container md:max-w-[700px] relative aspect-[16/9] w-full rounded-lg flex items-center justify-center overflow-hidden">

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} class="portfolio-close-btn">
            <path strokeLinecap="round" strokeLinejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
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
<?php get_footer() ?>



