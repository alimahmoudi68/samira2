
<?php 
if(!is_user_logged_in()){ 
wp_safe_redirect(home_url());
exit;

return;
}

?>


<?php 

    $current_user = wp_get_current_user()->ID;
    $bookmarks = $wpdb->get_results(" SELECT * FROM {$wpdb->prefix}posts 
    join {$wpdb->prefix}likes on post_id = {$wpdb->prefix}posts.ID WHERE user_id= $current_user ")  ;    

?>


<main class='w-full flex-grow mb-5 px-2'>
    <div class="container mx-auto ">
        <div id="error" class="hidden"><?php echo $error_too_much_licenec ?></div>

        <div class="bg-white-100 rounded-md p-5 mt-3">

            <div class='w-full flex justify-start items-center mb-5'>
                <svg class='w-2 h-2 fill-gray-700 dark:fill-white-100 ml-2' viewBox="0 0 100 100"
                    xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="50" />
                </svg>
                <span class='text-gray-600 dark:text-textPrimary-100 text-xl font-extrabold'>نشان شده‌ها</span>
            </div>

       

            <div class='parent-bookmark w-full text-[0.9rem] font-normal text-center border-collapse overflow-x-auto'>
                <?php if($bookmarks){ 
                    $i = 1 ;
                    foreach ($bookmarks as $value) { ?>
                        <div remove-set="<?php echo $i ?>" class="flex items-center justify-between border border-gray-200 border-r-4 border-r-primary-100 rounded-md p-5">
                            <div class='flex flex-col items-start justify-center'>
                                <span class="font-medium text-lg text-gray-700 dark:text-textPrimary-100 ">
                                    <?php echo  the_date($value->post_title); ?>
                                </span>
                                <div class='flex items-center mt-2'>
                                    <a href="<?php echo get_permalink( $value->ID ) ?>" class="text-[0.9rem] border cursor-pointer duration-200 border-primary-100 bg-primary-100 hover:bg-white-100 px-[12px] py-[5px] text-textPrimary-100 hover:text-primary-100 font-medium rounded-lg">
                                        مشاهده
                                    </a>
                                    <div  data-set="<?php echo $value->ID  ?>"  class="btn-remove-bookmark text-[0.9rem] border cursor-pointer duration-200 border-red-500 bg-red-500 hover:bg-white-100 px-[12px] py-[5px] text-textPrimary-100 hover:text-red-500 font-medium rounded-lg mr-2"  data-set="<?php echo $value->ID ?>">
                                        حذف از نشان شده‌ها
                                    </div>
                                </div>
                            </div>
                            <div class='w-[100px]'>
                                <?php if (has_post_thumbnail( $value->ID ) ) {
                                    $image = wp_get_attachment_image_src( get_post_thumbnail_id($value->ID), 'thumbnail' );
                                    $image = $image[0];
                                } ?>
                                <img src="<?php echo $image; ?>" class="w-full h-auto"/>
                            
                            </div>
                        </div>
                    <?php 
                    $i++; 
                    } 
                    ?>
                <?php } else { ?>
                <p class="caption-no-result">
                    هیچ موردی نشان گذاری نشده است
                </p>
                <?php 
                } 
                ?>
            </div>

        </div>

    </div>
</main>

<div id="back-modal-remove" class='hidden w-full h-full z-60 fixed top-0 left-0 right-0 bg-modalBackground-100'></div>
<div id="modal-remove"
    class='h-fit w-10/12 max-w-[600px] fixed z-70 bg-white-100 dark:bg-dark-100 rounded-md left-0 right-0 top-0 bottom-0 m-auto hidden'>
    <div class='w-full h-full flex flex-col justify-center items-start p-5 overflow-y-auto'>
        <h1 class='font-bold text-xl mb-1 text-zinc-500 dark:text-white-50'>
            حذف از نشان شده‌ها        </h1>
        <span>
            از حذف این دوره از لیست نشان شده‌ها اطمینان دارید؟
        </span>
        <div class='w-full flex justify-end items-center mt-3'>
            <button id="btn-submit" class="w-[60px] btn btn-remove-customer ml-1 text-[0.9rem] py-1 px-2 bg-primary-100 text-textPrimary-100 outline-none rounded-lg hover:opacity-80">
                    بله
            </button>
            <button id="btn-close" class="w-[60px] btn text-[0.9rem] py-1 px-2 bg-red-500 text-textPrimary-100 outline-none rounded-lg hover:opacity-80">
                خیر
            </button>
        </div>
    </div>
</div>





<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo get_template_directory_uri() ?>/js/bookmark.js"></script>