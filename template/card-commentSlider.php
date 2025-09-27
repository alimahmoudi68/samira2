<div
    class='btn-show-review w-full card-services flex flex-col items-center h-full rounded-lg cursor-pointer relative group' data-video='<?php echo get_post_meta( get_the_ID() , 'review_video', true ) ?>'>
    <div class=' w-full overflow-hidden card-image-container rounded-lg'>
        <?php the_post_thumbnail(); ?>
    </div>
    <div class='absolute md:top-0 md:left-0 md:right-0 md:bottom-0 left-[50%] translate-x-[-50%] md:translate-x-[0] bottom-[40px] px-4 py-2 rounded-lg md:opacity-0 bg-dark-80 md:group-hover:opacity-100 flex items-center duration-[1000ms] justify-center'>
      
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-[32px] h-[32px] fill-primary-100 group-hover:scale-[150%] duration-300 absolute left-[50%] top-[50%] translate-x-[-50%] translate-y-[-50%]">
        <path fill-rule="evenodd" d="M4.5 5.653c0-1.427 1.529-2.33 2.779-1.643l11.54 6.347c1.295.712 1.295 2.573 0 3.286L7.28 19.99c-1.25.687-2.779-.217-2.779-1.643V5.653Z" clip-rule="evenodd" />
    </svg>
</div>
