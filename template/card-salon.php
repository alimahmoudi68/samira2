<div
    class="card-product flex flex-col items-center h-fit transition-all bg-white-100 duration-300 rounded-md border-none dark:bg-dark-50 relative mx-1">
    <div class="w-full overflow-hidden card-image-container rounded-md">
        <a href="<?php the_permalink() ?>">
            <?php the_post_thumbnail('post'); ?>
        </a>
    </div>
    <div class="flex flex-col w-full mt-2 p-3">
        <div
            class="w-full h-[50px] flex items-start flex-grow text-[1.2rem] font-semibold text-slate-500 dark:text-text-primary-100">
            <h5>
                <a href="<?php the_permalink() ?>">
                    <?php the_title(); ?>
                </a>
            </h5>
        </div>

        <div class="flex items-center teacher-sec">
            <img src="<?php echo get_post_meta( get_the_ID() , 'pic_manager_salon' , true); ?>" />
            <span class="text-sm font-light text-gray-500 dark:text-text-primary-100">
                <?php echo get_post_meta( get_the_ID() , 'name_manager_salon' , true); ?>
            </span>
        </div>

        <div class="flex justify-end mt-2">
            <div class="bg-pink-100 dark:bg-sky-900 dark:text-text-primary-100 px-2 py-1 rounded-md flex items-center text-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <?php echo get_post_meta( get_the_ID() , 'city_salon' , true); ?>
            </div>
        </div>

    </div>
</div>