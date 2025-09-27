<?php
defined( 'ABSPATH' ) || exit;


function add_menu_plugin_course_license(){
    $ticket_menu_suffix = add_menu_page(
        'تیکت‌ها' , // page title 
        'تیکت‌ها' ,
        'manage_options' , // دسترسی‌ها
        'tickets' , // slug
        'tickets_callback' , //callback  یعنی بخش نمایشی را اکو می کند
        'dashicons-email-alt' , 
        8
    );

    add_action( 'load-'. $ticket_menu_suffix , 'ticket_proccess_table_data');
} 
add_action('admin_menu' , 'add_menu_plugin_course_license');




function ticket_proccess_table_data(){
    require( realpath(dirname( __FILE__ ).'/tickets_list_table.php') );
    $GLOBALS['tickets_list_table'] = new Tickets_List_Table();
    $GLOBALS['tickets_list_table']->prepare_items();
}





function tickets_callback(){





    // show tickets list ---------پراسس ها رو میشه هم اینجوری نوشت و هم بعد از  ایجاد منو و اکشن لود دش  
    // add_action( ('admin_init'), function(){
    //     global $pagenow;
    //     if($pagenow == 'admin.php' && isset($_GET['page']) && $_GET['page'] =='tickets' ){

            
    //         if(isset($_GET['action']) && $_GET['action'] == 'reply' ){
    //             include dirname( __FILE__ ) . '/view/reply.php';
    //         }

    //     }

    // });

    if(isset($_GET['action']) && $_GET['action'] == 'reply' ){
        if(isset($_POST['body'])){


            $ticket_body =  sanitize_text_field($_POST['body']) ;
            $courseId =  sanitize_text_field($_POST['courseId']) ;
            $parentId =  sanitize_text_field($_POST['parentId']) ;
            $file =  sanitize_url($_POST['attachment']) ;


            if($ticket_body  == ''){
                return wp_redirect(admin_url('admin.php?page=tickets&action=reply&id=' . $_GET['id'] .  '&status=reply_error'));
            }



            global $wpdb;
            $update_parent = $wpdb->update(
                $wpdb->prefix.'tickets' , 
                ['lastUpdate' => time()*1000 , 'status' => '2' ] ,
                [ 'id'=> $_POST['parentId'] ] 
            );


            $reply_tiicket =$wpdb->insert($wpdb->prefix.'tickets' , array(
                'title'=> '' , 
                'body'=> $ticket_body ,
                'userId'=>  get_current_user_id()  , 
                'courseId'=>  $courseId, 
                'file'=> $file , 
                'status'=> '0'  ,  
                'parentId' => $parentId  , 
                'lastUpdate' => time()*1000  ,
                'createdAt' =>  time()*1000 ),
                ['%s' , '%s' , '%d' , '%d' , '%s' , '%s' , '%d' , '%d' , '%d' ]
                 );



                if( $update_parent && $reply_tiicket){
                    return wp_redirect(admin_url('admin.php?page=tickets&action=reply&id=' . $_GET['id'] .  '&status=reply_success'));
                }else{
                    return wp_redirect(admin_url('admin.php?page=tickets&action=reply&id=' . $_GET['id'] .  '&status=reply_error'));
                }




        }
        include dirname( __FILE__ ) . '/view/reply.php';
    }



    // get tickets
    if(! isset($_GET['action']) ){
        include dirname( __FILE__ ) . '/view/main.php';
        return;
    }

}



// manage notice
add_action('admin_notices', function(){
    $type = '' ;
    $message = '';

    if(isset($_GET['status'])){
        $status = sanitize_text_field( $_GET['status'] );
        if($status == 'reply_success'){
            $type = 'success';
            $message = "پاسخ تیکت با موفقیت ثبت شد" ;
        }else if($status == 'reply_error'){
            $type = 'error';
            $message = "خطایی رخ داده است و پاسخ ثبت نشد" ;
        }else if($status == 'delete_success'){
            $count = $_GET['delete_count'];
            $type = 'error';
            $message = $count . "تیکت با موفقیت حذف شد" ;
        }else if($status == 'delete_error'){
            $type = 'error';
            $message = "در حذف تیکت‌ها خطایی رخ داده است" ;
        }else if($status == 'reply_success'){
            $type = 'success';
            $message = "تیکت با موفقیت پاسخ داده شد" ;
        }
        else if($status == 'reply_error'){
            $type = 'success';
            $message = "خطایی در پاسخ دادن تیکت رخ داد" ;
        }
    }


    if($type && $message){
        ?>
            <div class="notice notice-<?php echo $type ?> is-dismissible">
                <p>
                    <?php echo $message ?>
                </p>
            </div>
        <?php 
    }
})



?>