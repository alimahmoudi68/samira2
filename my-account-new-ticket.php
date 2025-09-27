<?php 
if(!is_user_logged_in()){ 
wp_safe_redirect(home_url());
exit;

return;
}

?>


<?php
    // courses that user buyed
    $current_user = wp_get_current_user();
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

<?php
function upload_user_file( $file = array() ) {

	require_once( ABSPATH . 'wp-admin/includes/admin.php' );

      $file_return = wp_handle_upload( $file, array('test_form' => false ) );

      if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
          return false;
      } else {

          $filename = $file_return['file'];

          $attachment = array(
              'post_mime_type' => $file_return['type'],
              'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
              'post_content' => '',
              'post_status' => 'inherit',
              'guid' => $file_return['url']
          );

          $attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );

          require_once(ABSPATH . 'wp-admin/includes/image.php');
          $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
          wp_update_attachment_metadata( $attachment_id, $attachment_data );

          if( 0 < intval( $attachment_id ) ) {
          	return $attachment_id;
          }
      }

      return false;
}
?>


<?php 

// روش معمولی ثبت تیکت
  
//   if(isset($_POST['courseId'])){ 
//     if(wc_customer_bought_product( $current_user->user_email, $current_user->ID , $_POST['courseId'])){ 
       
//         $attachment_id = 0 ;
//         if( ! empty( $_FILES ) ) {
//             foreach( $_FILES as $file ) {
//               if( is_array( $file ) ) {
//                 $attachment_id = upload_user_file( $file );
//               }
//             }
//         }

        
//         // save to db
//         $course_id = $_POST['courseId'];
//         require_once 'jdf.php';

//         $wpdb->insert($wpdb->prefix.'tickets', array('courseId'=>$course_id  , 'title'=>$_POST['title'] , 'body'=>$_POST['body'] , 'userId'=>$current_user->ID , 'file'=> $attachment_id  , 'status'=> '0' , 'lastUpdate' => jdate('Y/m/d')."-".date('h:i')  ));
            

//         $course = $wpdb->get_results("SELECT post_title FROM {$wpdb->prefix}posts WHERE ID= $course_id ") ;

//         // send sms to user
//         // $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//         // $user = "ali206";
//         // $pass = "ali930mmm";
//         // $fromNum = "3000505";
//         // $toNum = array('0'.$current_user->digits_phone_no);
//         // $pattern_code = "n44l6co5x2y4qzj";
//         // $input_data = array(
//         // "course" => $course[0] -> post_title ,
//         // );
//         // echo $client->sendPatternSms($fromNum,$toNum,$user,$pass,$pattern_code,$input_data);


//         // send sms to admin
//         // $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//         // $user = "ali206";
//         // $pass = "ali930mmm";
//         // $fromNum = "3000505";
//         // $toNum = array('09158302458');
//         // $pattern_code = "004x9lk5genat6x";
//         // $input_data = array(
//         // "course" => $course[0] -> post_title ,
//         // 'phone' => '0'.$current_user->digits_phone_no
//         // );
//         // echo $client->sendPatternSms($fromNum,$toNum,$user,$pass,$pattern_code,$input_data);
    
//         $finish_send = 'true';

//     } 
  

// }


?>


<main class='w-full flex-grow mb-5 px-2'>
    <div class="container mx-auto ">
        <div class='w-full text-[0.9rem] font-normal text-start border-collapse overflow-x-auto bg-white-100 p-5'>

            <span class="text-[1.2rem] text-gray-700 dark:text-textPrimary-100 font-black mb-5 block">
                ثبت تیکت جدید        
            </span>

            <form id="form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_themename-advert-create-check" value="1" />

                <div class="flex flex-col justify-between">
                    <div class="flex flex-col items-start w-full">
                        <span class="ml-2">
                            انتخاب دوره
                        </span>
                        <select name="courseId" class="w-full outline-none p-2 border border-gray-200 bg-white-100 grow rounded-md">
                            <option value="0">انتخاب کنید</option>
                            <?php foreach ($listUsersCourses as $course) { ?>
                            <option value="<?php echo $course->id ?>"><?php echo $course->title ?></option>
                            <?php } ?>
                        </select>
                        <small class="w-full text-start font-semibold text-red-400 mt-1 invisible">خطا</small>
                    </div>
                    <div class="flex flex-col items-start w-full">
                        <span class="ml-2">
                            عنوان سوال
                        </span>
                        <input class="w-full p-2 border border-gray-200 bg-white-100 outline-none grow rounded-md"
                            name="title"
                            value="" />
                        <small class="w-full text-start font-semibold text-red-400 mt-1 invisible">خطا</small>
                    </div>
                    <div class="flex flex-col items-start w-full">
                        <span class="ml-2">
                            متن سوال
                        </span>
                        <textarea rows="5" name="body"
                            class="w-full p-2 border border-gray-200 bg-white-100 outline-none grow rounded-md"><?php if ( isset( $_POST['body'] ) ) { if ( function_exists( 'stripslashes' ) ) { echo stripslashes( $_POST['_themename-advert-create-content'] ); } else { echo $_POST['_themename-advert-create-content']; } } ?></textarea>
                            <small class="w-full text-start font-semibold text-red-400 mt-1 invisible">خطا</small>
                    </div>
                </div>
                <div class="flex flex-col items-start w-full">
                    <span class="ml-2">
                        فایل ضمیمه                
                    </span>
                    <input type="file" name="upload"/>
                    <small class="w-full text-start font-semibold text-red-400 mt-1 invisible">خطا</small>
                </div>
                <div class='w-full flex justify-end items-center mt-5'>
                    <button id="btn-submit" type="submit" value="SUBMIT" name="_themename-advert-create-submit"
                        class="btn btn-remove-customer text-[1rem] py-2 px-3 bg-primary-100 text-textPrimary-100 outline-none rounded-lg hover:opacity-80 border border-primary-100 hover:text-primary-100 hover:bg-white-100">
                        ثبت تیکت
                    </button>
                </div> 

            </form>

        </div>

    </div>
</main>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="<?php echo get_template_directory_uri() ?>/js/new-support.js"></script>