<?php
defined( 'ABSPATH' ) || exit;
//wp_die('شما دسرسی ندارید');

echo '<div class="wrap">' ; 
?>
<h1 class="wp-heading-inline">تیکت‌ها</h1>
<!-- <a class="page-title-action" href="">تیکت جدید</a> -->

<?php
    echo '<form method="GET" >';
    echo '<input type="hidden" name="page" value="tickets"/>';
    $GLOBALS['tickets_list_table']->views();
    $GLOBALS['tickets_list_table']->search_box('جستجوی تیکت' , 'tickets_search');
    $GLOBALS['tickets_list_table']->display();
    echo '</form>' ;
echo '</div>' ;

?>
