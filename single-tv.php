<?php

?>

<?php get_header() ?>

<main class='w-full flex-grow mb-5 px-2'>
    <div class="container mx-auto my-3 flex flex-col items-end">
        <div class="w-full flex flex-wrap">
            <div class="w-full md:w-9/12 md:order-2">
                <div
                    class='flex flex-col justify-center items-start bg-white-100 p-5 rounded-md shadow-my mb-2 dark:bg-darkCard-100 dark:shadow-none'>
                    <?php 
                        $video = get_post_meta( get_the_ID() , 'tv_video' , true);
                    ?>
                    <video width="100%" class="max-h-[600px] object-cover rounded-lg" controls>
                        <source src="<?php echo $video ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="my-2 p-2 bg-pink-100 text-gray-500 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-xs">
                            <?php  the_date('d F Y'); ?>
                        </span>
                    </div>
                    <h1
                        class='w-full text-2xl text-slate-700 md:text-4xl font-extrabold text-right my-2 md:mt-[30px] dark:text-textPrimary-100'>
                        <?php the_title(); ?>
                    </h1>
                    <div class="container-body">
                        <?php  the_content(); ?>
                    </div>
                </div>
    
            </div>

            <div class="w-full md:w-3/12 md:order-1">
                <div class='md:ml-3 md:mt-0 mt-3'>
                    <div class='flex flex-wrap'>
                        <div class='w-1/2'>
                            <div
                                class='p-1 bg-white-100 h-[100px] flex flex-col justify-center items-center shadow-my md:mb-1 dark:bg-darkCard-100 dark:shadow-none'>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-primary-100" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class='text-[0.6rem] font-normal mt-2 text-gray-500 dark:text-white-50'>
                                    زمان ویدیو
                                </span>
                                <span class='text-xs sm:text-base font-semibold text-gray-700 dark:text-textPrimary-100'
                                    dir='ltr'>
                                    <?php echo  get_post_meta( get_the_ID() , 'tv_time' , true); ?>
                                </span>
                            </div>
                        </div>
                        <div class='w-1/2'>
                            <div
                                class='p-1 bg-white-100 h-[100px] flex flex-col justify-center items-center shadow-my mr-2 md:mb-2 dark:bg-darkCard-100 dark:shadow-none'>
                                <svg class="h-5 w-5 text-primary-100" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path class="fill-current transition duration-200" fill-rule="evenodd" clip-rule="evenodd" d="M5.00525 4.99988C4.77513 4.99988 4.58858 5.18643 4.58858 5.41654C4.58858 5.64666 4.77513 5.83321 5.00525 5.83321L6.67725 5.83321C6.90737 5.83321 7.09392 5.64666 7.09392 5.41654C7.09392 5.18643 6.90737 4.99988 6.67725 4.99988H5.00525ZM3.3335 6.67224C3.10338 6.67224 2.91683 6.85879 2.91683 7.08891C2.91683 7.31903 3.10338 7.50557 3.3335 7.50557L6.6775 7.50557C6.90762 7.50557 7.09416 7.31903 7.09416 7.08891C7.09416 6.85879 6.90762 6.67224 6.6775 6.67224L3.3335 6.67224Z"></path>
                                    <path class="stroke-current transition duration-200" d="M7.08323 2.17834C6.6357 2.13634 6.1178 2.11907 5.52165 2.11907C1.83979 2.11907 0.958571 2.77779 0.528906 5.85116C0.46337 6.31993 0.424047 6.73253 0.41753 7.09518M7.08323 2.17834C9.3997 2.39569 9.83099 3.27541 9.47089 5.85116C9.04123 8.92452 8.16001 9.58323 4.47814 9.58323C1.35787 9.58323 0.381319 9.11014 0.41753 7.09518M7.08323 2.17834C7.08323 2.17834 7.14666 1.79476 7.08323 1.28972C6.92699 0.0456842 1.79278 0.208173 1.24992 1.28972C0.417377 2.9484 0.41753 7.09518 0.41753 7.09518" stroke-width="0.833333" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <span class='text-[0.6rem] font-normal mt-2 text-gray-500 dark:text-white-50'>
                                    دسته بندی
                                </span>
                                <span class='text-xs sm:text-base font-semibold text-gray-700 dark:text-textPrimary-100'>
                                    <?php 
                                        $getslugid = wp_get_post_terms( $post->ID, 'tv-cat' );
                                        foreach( $getslugid as $thisslug ) {
                                            echo $thisslug->name . '';
                                        }
                                    ?>
                                </span>
                            </div>
                        </div> 
                    </div>
                </div>
                <?php
                        $teacher_id =  get_post_meta( get_the_ID() , 'tv_teacher' , true); 
                        $teacher = new WP_Query(
                            array(
                                'post_type' => 'teacher',
                                'posts_per_page' => 1 , 
                                'p' => $teacher_id , 
                            )
                        );
                        if($teacher->have_posts()){
                            while($teacher->have_posts()):
                            $teacher->the_post();
                        ?>
                        <div
                            class='teacher-prof flex flex-col justify-center items-center bg-white-100 rounded-xl p-3 mt-3 shadow-my md:mt-2 md:ml-3 dark:bg-darkCard-100 dark:shadow-none'>
                                <?php the_post_thumbnail('teacher'); ?>
                            <span class='text-lg font-bold mt-[5px] text-gray-700 text-justify dark:text-textPrimary-100'>
                                
                            </span>
                            <span class='text-[0.9rem] text-justify font-normal	text-gray-400 dark:text-textPrimary-100'>
                                <?php the_title(); ?>
                            </span>
                            <span class='text-[0.9rem] text-justify font-normal	my-2 text-gray-500 dark:text-textPrimary-100'>
                            <?php the_content(); ?>
                            </span>
                        </div>
                        <?php
                            endwhile; 
                        }
                        wp_reset_query();
                ?>
            </div>
        </div>
        <div class="w-full md:w-9/12 woocommerce">
            <div id="comment-section" class='w-full bg-white-100 dark:bg-darkCard-100 flex flex-col justify-center items-center shadow-my dark:shadow-none p-5 rounded-md text-[0.9rem] font-normal my-3'>
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