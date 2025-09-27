<div class="flex flex-col items-center rounded-[20px] bg-white-100 transition-all duration-300 dark:bg-dark-card-100 relative p-[12px]">
    <div class="w-full flex items-center">
        <div class="w-[100px] h-[100px] overflow-hidden image-container-top-teachers rounded-full">
            <?php the_post_thumbnail('top-teacher'); ?>
        </div>
        <div class='mr-2 flex flex-col items-start'>
            <span class="text-[0.8rem] font-normal text-slate-400 dark:text-text-primary-100">
                <?php the_title(); ?>
            </span>
            <span class="text-[0.8rem] font-normal text-primary-100">
                <?php echo get_post_meta( get_the_ID() , 'tutor_expert' , true); ?>
            </span>
        </div>
    </div>
    <span class="text-[0.8rem] h-[40px] mt-3 font-normal text-slate-400 dark:text-text-primary-100">
        <?php  the_excerpt(); ?>
    </span>
    <div class='w-full border-t pt-2'>
        <a href="<?php the_permalink() ?>" class='w-full flex justify-center items-center text-gray-600 dark:text-text-primary-100 font-bold text-[0.9rem] group'>
            مشاهده پروفایل
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 duration-200 group-hover:translate-x-[-3px]">
            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </a>
    </div>
</div>