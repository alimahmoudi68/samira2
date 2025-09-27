<?php

?>

<?php get_header() ?>

<main class='w-full flex-grow mb-5 px-2'>
    <div class="container mx-auto my-3 flex flex-col items-end">
        <div class="w-full flex flex-wrap">
            <div class="w-full md:w-9/12 md:order-2">
                <div
                    class='flex flex-col justify-center items-start bg-white-100 p-5 rounded-md shadow-my mb-2 dark:bg-dark-50 dark:shadow-none'>
                    <h1
                        class='w-full text-2xl text-slate-700 md:text-4xl font-extrabold text-right mt-1 mb-3 dark:text-text-primary-100'>
                        <?php the_title(); ?>
                    </h1>
                    <?php 
                        $video = get_post_meta( get_the_ID() , 'tv_video' , true);
                    ?>
                    <video width="100%" class="max-h-[600px]" controls>
                        <source src="<?php echo $video ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="my-2 p-2 bg-pink-100 text-gray-500 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline h-5 w-5 ml-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-xs">
                            <?php echo get_post_meta( get_the_ID() , 'city_salon' , true); ?>
                        </span>
                    </div>

                    <div class="container-body">
                        <?php  the_content(); ?>
                    </div>
                </div>
                <div
                    class='flex flex-col justify-center items-start bg-white-100 p-5 rounded-md shadow-my mb-2 dark:bg-dark-50 dark:shadow-none'>
                    <div class='w-full flex justify-start items-center mb-5'>
                        <svg class='w-2 h-2 fill-primary-100 ml-1' viewBox="0 0 100 100"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="50" />
                        </svg>
                        <span class='text-primary-100 text-2xl font-extrabold'>موقعیت مکانی</span>
                    </div>

                    <?php 
                    $lat =get_post_meta( get_the_ID() , 'lat_salon' , true); 
                    $long =get_post_meta( get_the_ID() , 'long_salon' , true); 
                    echo do_shortcode("[neshan-map-dynamic api_key='web.QEIXnYfoIgLHfwUQr3MkmThSik36p0islDiVpASv' lat='$lat' lng='$long' width='100%' height='400px' maptype='neshan']")
                    ?>

                </div>

                <div
                    class='flex flex-col justify-center items-start bg-white-100 p-5 rounded-md shadow-my mb-2 dark:bg-dark-50 dark:shadow-none'>
                    <div class='w-full flex justify-start items-center mb-5'>
                        <svg class='w-2 h-2 fill-primary-100 ml-1' viewBox="0 0 100 100"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="50" />
                        </svg>
                        <span class='text-primary-100 text-2xl font-extrabold'>گالری</span>
                    </div>

                    <div class="w-full" dir="rtl">
                    <div class="swiper-container slider" dir="rtl">

                        <div class="swiper-wrapper">
                            <?php 
                                $galleries = get_post_meta( get_the_ID() , 'gallery_group_salon' , true); 
                                foreach($galleries as $gallery) {
                            ?>
      
                            <div class="swiper-slide">
                            <div
                                class="card-product flex flex-col items-center h-fit transition-all bg-white-100 duration-300 rounded-md border-none dark:bg-dark-50 relative mx-1">
                                <div class="w-full overflow-hidden card-image-container rounded-md">
                                <img src="<?php echo $gallery['gallery_salon']  ?>" />  
                                </div>
                                </div>            
                            </div>

                            <?php } ?>
      

                        </div>
                        <!-- If we need pagination -->
                        <div class="swiper-pagination swiper-pagination-customer"></div>

                        <!-- If we need navigation buttons -->
                        <!-- <div class="swiper-button-prev swiper-button-prev-new"></div>
                        <div class="swiper-button-next swiper-button-next-new"></div> -->
                    </div>
                                </div>

                </div>

            </div>

            <div class="w-full md:w-3/12 md:order-1">
                <div class='md:ml-3 md:mt-0 mt-3'>
                    <div
                        class='w-full p-3 bg-white-100 flex flex-col justify-center rounded-xl items-center shadow-my mb-2 dark:bg-dark-50 dark:shadow-none'>
                        <div class="w-full flex justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-gray-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class='text-lg font-semibold	 text-gray-700 dark:text-white-50 mr-2'>
                                مدیریت
                            </span>
                        </div>
                        <div class="w-full flex justify-center items-center mt-2">
                            <img class="rounded-full" width="64" heigh="64"
                                src="<?php echo get_post_meta( get_the_ID() , 'pic_manager_salon' , true); ?>" />
                            <span class='text-base font-medium text-gray-600 dark:text-text-primary-100 mr-2'>
                                <?php echo  get_post_meta( get_the_ID() , 'name_manager_salon' , true); ?>
                            </span>
                        </div>
                    </div>
                    <div
                        class='w-full p-3 bg-white-100 flex flex-col justify-center rounded-xl items-center shadow-my mb-2 dark:bg-dark-50 dark:shadow-none'>
                        <div class="w-full flex justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-gray-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            <span class='text-lg font-semibold	 text-gray-700 dark:text-white-50 mr-2'>
                                آدرس
                            </span>
                        </div>
                        <div class="w-full flex justify-center items-center nt-2">
                            <span class='text-base font-medium text-gray-600 dark:text-text-primary-100 mr-2'>
                                <?php echo  get_post_meta( get_the_ID() , 'address_salon' , true); ?>
                            </span>
                        </div>
                    </div>
                    <div
                        class='w-full p-3 bg-white-100 flex flex-col justify-center rounded-xl items-center shadow-my mb-2 dark:bg-dark-50 dark:shadow-none'>
                        <div class="w-full flex justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-gray-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class='text-lg font-semibold	 text-gray-700 dark:text-white-50 mr-2'>
                                شماره تماس
                            </span>
                        </div>
                        <div class="w-full flex justify-center items-center mt-2">
                            <span class='text-base font-medium text-gray-600 dark:text-text-primary-100 mr-2'>
                                <?php echo  get_post_meta( get_the_ID() , 'phone_salon' , true); ?>
                            </span>
                        </div>
                    </div>
                    <div
                        class='w-full p-3 bg-white-100 flex flex-col justify-center rounded-xl items-center shadow-my mb-2 dark:bg-dark-50 dark:shadow-none'>
                        <div class="w-full flex justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-gray-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <span class='text-lg font-semibold text-gray-700 dark:text-white-50 mr-2'>
                                خدمات
                            </span>
                        </div>
                        <div class="w-full flex justify-center items-center mt-2">
                            <?php $services = get_post_meta( get_the_ID() , 'services_group' , true); 
                            foreach($services as $service) {
                            ?>
                            <div class="bg-sky-100 px-2 py-1 rounded-md m-1">
                                <span class='text-base font-medium text-gray-700 dark:text-white-50 '>
                                    <?php echo $service['servuces_salon_title']; ?>
                                </span>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="w-full md:w-9/12 woocommerce">
            <div id="comment-section"
                class='w-full bg-white-100 dark:bg-dark-50 flex flex-col justify-center items-center shadow-my dark:shadow-none p-5 rounded-md text-[0.9rem] font-normal my-3'>
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

</main>

<?php get_footer() ?>
<script src="<?php echo get_template_directory_uri() ?>/js/swiper.min.js"></script>
<script src="<?php echo get_template_directory_uri() ?>/js/single-salon.js"></script>