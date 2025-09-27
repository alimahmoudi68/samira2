<?php 
if(!is_user_logged_in()){ 
wp_safe_redirect(home_url());
exit;

return;
}

?>


<?php 
  
  if('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['_themename-advert-create-check']) && wp_verify_nonce( $_POST['__themename_submit_advert_nonce'], '_themename_submit_advert_action')) {
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;

    $new_post_title = sanitize_text_field($_POST['_themename-advert-create-title']);
    $new_post_content = sanitize_textarea_field($_POST['_themename-advert-create-content']);


    $postTitleError = '';
    if ( trim( $_POST['_themename-advert-create-title'] ) === '' ) {
        $postTitleError = 'Please enter a title.';
        $hasError = true;

    }else{
        $meta_time = $_POST['_themename-advert-create-title'];

        $new_post = array();
        $new_post['post_author'] = $user_id;
        $new_post['post_title'] = $new_post_title;
        $new_post['post_content'] = $new_post_content;
        $new_post['post_status'] = 'pending';
        $new_post['post_name'] = 'pending';
        $new_post['post_type'] = 'ad';
    
        $pid =   $post_success = wp_insert_post($new_post);
        add_post_meta($pid, 'ad_time',$new_post_title, true);



    }

 
    
    if ( $_FILES ) { 
        $files = $_FILES["_themename-advert-create-image"];  
        foreach ($files['name'] as $key => $value) {
            if ($files['name'][$key]) {
                $file = array( 
                    'name' => $files['name'][$key],
                    'type' => $files['type'][$key], 
                    'tmp_name' => $files['tmp_name'][$key], 
                    'error' => $files['error'][$key],
                    'size' => $files['size'][$key]
                );
                $_FILES = array ("_themename-advert-create-image" => $file);
                foreach ($_FILES as $file => $array) {              
                    // $newupload = frontend_handle_attachment( $file, $post_success );
                    if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) __return_false();

                    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
                    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

                    $attach_id = media_handle_upload( $file, $post_success );

                    // Set featured image 
                    set_post_thumbnail($post_success, $attach_id);
                }
            }
        }
    }

}

?>


<main class='w-full flex-grow mb-5 px-2'>
    <div class="container mx-auto ">
        <div id="error" class="hidden"><?php echo $error_too_much_licenec ?></div>



        <form id="_themename-advert-create-form" method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('_themename_submit_advert_action','__themename_submit_advert_nonce'); ?>
            <input type="hidden" name="_themename-advert-create-check" value="1" />




            <div class="flex flex-col justify-between">
                <div class="flex flex-col items-start w-full">
                    <span class="ml-2">
                        انتخاب دسته آگهی
                    </span>
                    <select name="cat" class="w-full outline-none p-2 border border-gray-200 bg-white-100 grow rounded-md">
                        <option value="0">انتخاب کنید</option>
                        <?php foreach ($listUsersCourses as $course) { ?>
                        <option value="<?php echo $course->id ?>"><?php echo $course->title ?></option>
                        <?php } ?>
                    </select>
                    <small class="w-full text-start font-semibold text-red-400 mt-1 invisible">خطا</small>
                </div>
                <div class="flex flex-col items-start w-full">
                    <span class="ml-2">
                        عنوان آگهی
                    </span>
                    <input class="w-full p-2 border border-gray-200 bg-white-100 outline-none grow rounded-md"
                        name="_themename-advert-create-title"
                        value="<?php if ( isset( $_POST['_themename-advert-create-title'] ) ) echo $_POST['_themename-advert-create-title']; ?>" />
                    <small class="w-full text-start font-semibold text-red-400 mt-1 invisible">خطا</small>
                </div>
                <div class="flex flex-col items-start w-full">
                    <span class="ml-2">
                        متن آگهی
                    </span>
                    <textarea rows="5" name="_themename-advert-create-content"
                        class="w-full p-2 border border-gray-200 bg-white-100 outline-none grow rounded-md"><?php if ( isset( $_POST['_themename-advert-create-content'] ) ) { if ( function_exists( 'stripslashes' ) ) { echo stripslashes( $_POST['_themename-advert-create-content'] ); } else { echo $_POST['_themename-advert-create-content']; } } ?></textarea>
                        <small class="w-full text-start font-semibold text-red-400 mt-1 invisible">خطا</small>
                </div>
            </div>
            <div class="flex flex-col items-start w-full">
                <span class="ml-2">
                    انتخاب عکس
                </span>
                <input type="file" id="_themename-advert-create-image" name="_themename-advert-create-image[]" />
            </div>
            <div class='w-full flex justify-end items-center mt-5'>
                <button id="btn-submit" type="submit" value="SUBMIT" name="_themename-advert-create-submit"
                    class="w-[60px] btn btn-remove-customer ml-1 text-[0.9rem] py-1 px-2 bg-primary-100 text-textPrimary-100 outline-none rounded-lg hover:opacity-80">
                    ثبت
                </button>
            </div> 

        </form>



    </div>
</main>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo get_template_directory_uri() ?>/js/new-ad.js"></script>