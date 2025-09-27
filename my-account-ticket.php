<?php 
if(!is_user_logged_in()){ 
wp_safe_redirect(home_url());
exit;

return;
}

?>

<?php


    $id = $_GET['id'];

    $current_user = wp_get_current_user();
    $ticketParent = $wpdb->get_results(" SELECT * FROM {$wpdb->prefix}posts 
        join {$wpdb->prefix}tickets on courseId  = {$wpdb->prefix}posts.ID WHERE userId = $current_user->ID  AND {$wpdb->prefix}tickets.ID = $id ");


    $ticketChilds = $wpdb->get_results(" SELECT * FROM {$wpdb->prefix}posts 
        join {$wpdb->prefix}tickets on courseId  = {$wpdb->prefix}posts.ID WHERE userId = $current_user->ID  AND {$wpdb->prefix}tickets.parentId = $id ");


    //var_dump($ticketParent[0]->courseId);
    
    //var_dump($ticketChilds[0]->display_name);
    //var_dump($ticketChilds[0]->body);
    //var_dump($ticketChilds[0]->lastUpdate);
    //var_dump($ticketChilds[0]->file);


    // courses that user buyed
    //$current_user = wp_get_current_user();
    $listUsersCourses = array();
    $products = new WP_Query(
        array(
            'post_type' => 'product',
        )
    );
    if($products->have_posts()){
        while($products->have_posts()):
        $products->the_post();

        if(wc_customer_bought_product( $current_user->user_email, $current_user->ID , get_the_ID())){   
            array_push($listUsersCourses , (object)[
                'id' => get_the_ID() ,
                'title' => get_the_title() ,
        ]);

        }

        endwhile; 
    }
    wp_reset_query();


?>


<main class='w-full flex-grow mb-5'>
    <div class="container mx-auto ">
        <div
            class='bg-white-100 dark:bg-dark-100 p-4 mb-2 rounded-md text-[0.9rem] font-normal flex flex-col justify-center items-start dark:shadow-none '>
            <div class='w-full flex flex-col justify-start items-center mb-5 p-5n'>
                <div class='w-full flex flex-col md:flex-row items-center md:justify-between'>
                    <div class='text-[1.5rem] text-gray-700 font-black'>
                        <?php echo $ticketParent[0]->title ?>
                    </div>
                    <div class='text-[1rem] text-gray-500 font-bold flex items-center'>
                        #<?php echo $ticketParent[0]->id ?>
                    </div>
                </div>
                <div class='w-full flex items-center justify-center md:justify-start'>
                    <span class='text-[1rem] text-gray-700 font-light'>دوره: </span>
                    <div class='text-[1rem] text-gray-700 ml-1'>
                        <?php echo $ticketParent[0]->post_title ?>
                    </div>
                </div>
                <div class='w-full flex flex-col items-center md:flex-row justify-between my-5'>
                    <div
                        class='text-[1rem] text-gray-500 font-normal p-2 hover:bg-gray-100 cursor-pointer rounded-md duration-300'>
                        بستن تیکت
                    </div>


                    <div class='text-[1rem] text-gray-500 ml-2'>
                        در حال
                    </div>
                </div>
                <div class='w-full flex flex-col md:flex-row'>
                    <div
                        class='flex flex-col items-center text-[1rem] text-gray-400 font-normal md:border-l md:border-gray-200 md:pl-3 md:ml-3'>
                        <img class="rounded-full" width="64" height="64"
                            src="<?php echo get_avatar_url($current_user->ID , array("size"=>260 )); ?>" alt="user" />
                        <span class='block'><?php echo $current_user->display_name ?></span>
                        <span><?php echo wp_date('j F Y H:i' , $ticketParent[0]->lastUpdate /1000)  ?></span>
                    </div>
                    <span class='mt-3'>
                        <?php echo $ticketParent[0]->body ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="w-full bg-white-100 dark:bg-dark-100 p-4 mb-2 rounded-md">
            <span class="text-[1.2rem] text-gray-700 dark:text-text-primary-100 font-black mb-5 block">
                ارسال جواب      
            </span>
            <form class="w-full" id="form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_themename-advert-create-check" value="1" />

                <div class="flex flex-col justify-between">


                    <input value="<?php echo $ticketParent[0]->id ?>" name="parent" class="hidden" />
                    <input value="<?php echo $ticketParent[0]->courseId ?>" name="courseId" class="hidden" />

                    <div class="flex flex-col items-start w-full">
                        <span class="ml-2">
                            متن جواب
                        </span>
                        <textarea rows="5" name="body"
                            class="w-full p-2 border border-gray-200 bg-white-100 outline-hidden grow rounded-md"><?php if ( isset( $_POST['body'] ) ) { if ( function_exists( 'stripslashes' ) ) { echo stripslashes( $_POST['_themename-advert-create-content'] ); } else { echo $_POST['_themename-advert-create-content']; } } ?></textarea>
                        <small class="w-full text-start font-semibold text-red-400 mt-1 invisible">خطا</small>
                    </div>
                </div>
                <div class="flex flex-col items-start w-full">
                    <span class="ml-2">
                        فایل ضمیمه
                    </span>
                    <input type="file" name="upload" />
                    <small class="w-full text-start font-semibold text-red-400 mt-1 invisible">خطا</small>
                </div>
                <div class='w-full flex justify-end items-center mt-5'>
                    <button id="btn-submit" type="submit" value="SUBMIT" name="_themename-advert-create-submit"
                        class="btn btn-remove-customer text-[1rem] py-2 px-3 bg-primary-100 text-text-primary-100 outline-hidden rounded-lg hover:opacity-80 border border-primary-100 hover:text-primary-100 hover:bg-white-100">
                        ثبت جواب
                    </button>
                </div>

            </form>
        </div>

        <?php foreach ($ticketChilds as $value) { ?>
        <div
            class='bg-white-100 dark:bg-dark-100 p-4 mb-2 rounded-md text-[0.9rem] font-normal flex flex-col justify-center items-start dark:shadow-none '>
            <div class='w-full flex flex-col md:flex-row'>
                <div
                    class='flex flex-col items-center text-[1rem] text-gray-400 font-normal md:border-l md:border-gray-200 md:pl-3 md:ml-3'>
                    <img class="rounded-full" width="64" height="64"
                        src="<?php echo get_avatar_url($current_user->ID , array("size"=>260 )); ?>" alt="user" />
                    <span class='block'><?php echo $current_user->display_name ?></span>
                    <span><?php echo wp_date('j F Y H:i' , $ticketParent[0]->lastUpdate /1000)  ?></span>
                </div>
                <span class='mt-3'>
                    <?php echo $ticketParent[0]->body ?>
                </span>
            </div>
        </div>
        <?php } ?>
    </div>



    </div>
</main>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="<?php echo get_template_directory_uri() ?>/js/reply-support.js"></script>