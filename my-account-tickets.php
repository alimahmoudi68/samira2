<?php 
if(!is_user_logged_in()){ 
wp_safe_redirect(home_url());
exit;

return;
}


$current_user = wp_get_current_user()->ID;
//$tickets = $wpdb->get_results(" SELECT * FROM {$wpdb->prefix}posts 
//join {$wpdb->prefix}tickets on courseId  = {$wpdb->prefix}posts.ID WHERE userId= $current_user ")  ;



$items_per_page = 3;
$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
$offset = ( $page * $items_per_page ) - $items_per_page;

$query = "SELECT * FROM {$wpdb->prefix}posts 
join {$wpdb->prefix}tickets on courseId  = {$wpdb->prefix}posts.ID WHERE userId= $current_user AND parentId = '0' " ;

$total = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}posts 
join {$wpdb->prefix}tickets on courseId  = {$wpdb->prefix}posts.ID WHERE userId= $current_user AND parentId = '0' " );

$tickets = $wpdb->get_results( $query . " ORDER BY {$wpdb->prefix}tickets.id DESC LIMIT ${offset}, ${items_per_page}" );


//var_dump($tickets);

?>




<?php 
function stateToText($status){
    $text="";
    switch ($status) {
        case 0:
            $text = "در انتظار پاسح";
          break;
        case 1:
            $text = "در دست بررسی";
          break;
        case 2:
            $text = "پاسخ داده شده";
          break;
        case 3:
            $text = "بسته شده";
          break;
        default:
            $text="";
    }
    return $text;

}

?>


<main class='w-full flex-grow mb-5 px-2'>
    <div class="container mx-auto">
      
            <div class='w-full text-[0.9rem] font-normal text-start border-collapse overflow-x-auto bg-white-100 p-5'>

            <span class="text-[1.2rem] text-gray-700 dark:text-text-primary-100 font-black">
                تیکت‌ها        
            </span>
            <div class='w-full flex justify-end mb-5'>
                <a class="bg-primary-100 border border-primary-100 py-1 px-3 rounded-md text-text-primary-100 hover:bg-white-100 dark:hover:bg-dark-100 hover:text-primary-100 transition-all"                     
                        href="<?php echo home_url('/my-account/new-ticket')?>">
                    تیکت جدید
                </a>
            </div>


            <?php if($tickets){ ?>
            <table class="w-full table text-gray-700 dark:text-text-primary-100 text-center">
                <thead>
                    <tr>
                        <th class='min-w-[120px] font-semibold border-none align-middle h-20'>شماره</th>
                        <th class='min-w-[120px] font-semibold border-none align-middle h-20'>دوره مربوطه</th>
                        <th class='min-w-[120px] font-semibold border-none align-middle h-20'>موضوع</th>
                        <th class='min-w-[120px] font-semibold border-none  align-middle h-20'>وضعیت</th>
                        <th class='min-w-[120px] font-semibold border-none  align-middle h-20'>آخرین به روز رسانی
                        </th>
                        <th class='min-w-[120px] font-semibold border-none  align-middle h-20'>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $value) { ?>
                    <tr class="hover:bg-slate-50 dark:hover:bg-dark-50">
                        <td class='font-normal border-none align-middle h-20'>
                            <?php echo $value->id  ?></td>
                        </td>
                        <td class='font-normal border-none align-middle h-20'>
                            <?php echo $value->post_title  ?></td>
                        </td>
                        <td class='font-normal border-none align-middle h-20'>
                            <?php echo $value->title  ?></td>
                        </td>
                        <td class='font-normal border-none align-middle h-20'>
                            <?php echo stateToText($value->status);  ?></td>
                        </td>
                        <td class='font-normal border-none align-middle h-20'>
                            <?php echo $value->lastUpdate  ?></td>
                        </td>
                        <td class='font-normal border-none align-middle h-20'>
                            <a class="bg-primary-100 border border-primary-100 py-1 px-3 rounded-md text-text-primary-100 hover:bg-white-100 dark:hover:bg-dark-100 hover:text-primary-100 transition-all"
                                href="<?php echo home_url('/my-account/ticket?id=' . $value->id )?>">
                                مشاهده
                            </a>
                        </td>
                    </tr>
                    <?php } ?>

                </tbody>
            </table>
            <?php } else { ?>
            <p class="caption-no-result">
                هنوز موردی ثبت نشده است
            </p>
            <?php } ?>


            <div class="pagination text-center my-8">
                <?php echo paginate_links( array(
                        'base' => add_query_arg( 'cpage', '%#%' ),
                        'format' => '',
                        'prev_text' => __('&laquo;'),
                        'next_text' => __('&raquo;'),
                        'total' => ceil($total / $items_per_page),
                        'current' => $page
                    ));
                    ?>
            </div>
        </div>

    </div>
</main>




<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>