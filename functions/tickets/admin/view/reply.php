<?php
defined( 'ABSPATH' ) || exit;
//wp_die('شما دسرسی ندارید');

$id2 =  sanitize_text_field($_GET['id']);
$id = absint($id2);


global $wpdb;
$parent = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM {$wpdb->prefix}users join {$wpdb->prefix}tickets on userId= {$wpdb->prefix}users.ID join {$wpdb->prefix}posts on courseId = {$wpdb->prefix}posts.ID WHERE {$wpdb->prefix}tickets.id = %d  " ,  $id )
);

$childs = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM {$wpdb->prefix}users join {$wpdb->prefix}tickets on userId= {$wpdb->prefix}users.ID join {$wpdb->prefix}posts on courseId = {$wpdb->prefix}posts.ID WHERE {$wpdb->prefix}tickets.parentId = %d " ,  $id)
);


//var_dump($parent);


//$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}users join {$wpdb->prefix}tickets on userId= {$wpdb->prefix}users.ID join {$wpdb->prefix}posts on courseId = {$wpdb->prefix}posts.ID $where $orderbyTxt LIMIT $per_page OFFSET $offset" , ARRAY_A);

function ticket_status_to_text($status){
    if($status == '0'){
       return 'در انتظار پاسخ' ;
    }else if($status == '1'){
        return 'در حال بررسی' ;
    }else if($status == '2'){
        return 'پاسخ داده شده' ;
    }else if($status == '3'){
        return 'بسته شده' ;
    }else{
        return 'نا مشخص' ;
    }

}

?>


<?php if($parent){ ?>
<div class="wrap">

    <div id="icon-options-general" class="icon32"></div>
    <h1>
        موضوع: <?php echo $parent[0]->title ?>
    </h1>

    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-2">

            <!-- main content -->
            <div id="post-body-content">

                <div class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <h2><span>
                                <?php echo $parent[0]->title ?>
                            </span>
                        </h2>
                        <div class="inside">
                            <p>
                                <?php echo $parent[0]->body ?>
                            </p>
                            <div class="flex justify-end">
                                <?php echo wp_date('j F Y H:i' , $parent[0]->createdAt /1000) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php foreach($childs as $child) { ?>

                <div class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <div class="inside">
                            <p>
                                <?php echo $child->body ?>
                            </p>
                            <?php if($child->file !== '0'){ ?>
                            <a href="<?php echo $child->file ?>" class="flex items-center" download>
                                <span class="ml-2">
                                    فایل ضمیمه
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                                </svg>
                            </a>
                            <?php } ?>
                            <div class="flex justify-end">
                                <?php echo wp_date('j F Y H:i' , $child->createdAt /1000) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } ?>

				<div class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <h2><span>ارسال پاسخ</span></h2>
                        <div class="inside">

                            <form action="" method="POST">
                                <input name="parentId" type="hidden"  value="<?php echo $id ?>" >
                                <input name="courseId" type="hidden"  value="<?php echo $parent[0]->courseId ?>" >


                                <textarea id="" name="body" cols="80" rows="10" class="large-text mb-6" placeholder="متن پاسخ"></textarea>

                                <div class='flex mb-6'>
                                <input id="ticket_attachment" type="text" name="attachment" class="regular-text ml-2">
                                <div class="button-secondary" id="btn_ticket_uploader" name="Example" >انتخاب فایل ضمیمه</div>

                                </div>


                                <fieldset class="mb-6">
                                    <legend class="screen-reader-text"><span>Fieldset Example</span></legend>
                                    <label for="users_can_register">
                                        <input name="" type="checkbox" checked id="users_can_register" value="1" />
                                        <span>به کاربر پیامک داده شود</span>
                                    </label>
                                </fieldset>
                                <div class="w-full flex justify-end">
                                    <input class="button-primary" type="submit"  value="ثبت پاسخ" />
                                </div>
                            </form>

                        </div>
                    </div>

                </div>



            </div>
            <!-- post-body-content -->

            <!-- sidebar -->
            <div id="postbox-container-1" class="postbox-container">

                <div class="meta-box-sortables">

                    <div class="postbox">

                        <h2>
							<span>
								درباره این تیکت
							</span>
						</h2>

                        <div class="inside">
                        <p>
                                مربوط به دور: <?php echo $parent[0]->post_title ?>
                            </p>
                            <p>
                                ارسال کننده: <?php echo $parent[0]->user_login ?>
                            </p>
                            <p>
                                زمان ایجاد تیکت: <?php echo wp_date('j F Y H:i' , $parent[0]->lastUpdate /1000) ?>
                            </p>
                            <p>
                                وضعیت تیکت: <?php echo ticket_status_to_text($parent[0]->status) ?>
                            </p>
                        </div>
                        <!-- .inside -->

                    </div>
                    <!-- .postbox -->

                </div>
                <!-- .meta-box-sortables -->

            </div>
            <!-- #postbox-container-1 .postbox-container -->

        </div>
        <!-- #post-body .metabox-holder .columns-2 -->

        <br class="clear">
    </div>
    <!-- #poststuff -->

</div> <!-- .wrap -->



<?php }else{ ?>

<div class="wrap">
    <span>
        تیکتی یافت نشد
    </span>
</di>


<?php } ?>