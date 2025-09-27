<?php 
  defined( 'ABSPATH' ) || exit;
?>
<div class="btn-show-portfolio-detail w-full flex flex-col items-center h-full transition-all duration-300 rounded-lg cursor-pointer relative group" data-img="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), 'full'); ?>" data-video='<?php echo get_post_meta( get_the_ID() , 'review_video', true ) ?>'>
    <div class=' w-full overflow-hidden card-image-container rounded-lg'>
        <?php the_post_thumbnail(); ?>
    </div>
    <div class="absolute md:top-0 md:left-0 md:right-0 md:bottom-0 left-1/2 -translate-x-1/2 md:translate-x-0 bottom-10 px-4 py-2 rounded-lg md:opacity-0 bg-primary-50 md:group-hover:opacity-100 flex items-center duration-1000 justify-center">
        <span class="font-semibold text-white">
            <?php the_title(); ?>
        </span>
    </div>
</div>
