<?php
if( !class_exists('WP_List_Table')){
    require_once( ABSPATH.'wp-admin/includes/class-wp-list-table.php');
}

class Tickets_List_Table extends WP_List_Table{

    public function get_columns(){
        return [
            'cb' => '<input type="checkbox"/>' ,
            'id' => 'آیدی تیکت'  ,
            'title' => 'عنوان' ,
            'course' => 'دوره' ,
            'user' => 'کاربر' ,
            'lastUpdate' =>'آخرین به روز رسانی' 
        ];
    }


    public function column_default( $item , $column_name ){
        if(isset( $item[$column_name])){
            return $item[$column_name];
        }else{
            return '-';
        }

    }

    // change default title
    public function column_title($item){
        $actions = [
            'edit' => '<a href="' . admin_url('admin.php?page=tickets&action=reply&id=' . $item['id']) . '">جواب دادن</a>' ,
            'delete' => '<a href="'. admin_url('admin.php?page=tickets&action=reply&id=' . $item['id']) .'" onclick="return confirm(\'آیا از حذف کردن اطمینان دارید؟\')">حذف</a>'

        ];

        return $item['title'] . $this->row_actions($actions) ;
    }

    // change default cb
    public function column_cb($item){
        return '<input type="checkbox" name="tickets[]" value="'. $item['id'] .'" ';
    }

    // change default course
    public function column_course($item){
        return $item['post_title'] ;
    }

    // change default user
    public function column_user($item){
        return $item['user_login'] ;
    }

     // change default lastUpdate
     public function column_lastUpdate($item){
        return wp_date('j F Y H:i' , $item['lastUpdate']/1000) ;
    }

    public function no_items(){
        echo 'تیکتی پیدا نشد';
    }

    public function get_bulk_actions(){
        $actions = [
            'delete' => 'حذف'
        ];

        return $actions;
    }

    private function create_view( $key , $label , $url , $count = 0){
        $current_status = isset( $_GET['tickets_status']) ? $_GET['tickets_status'] : 'all';
        $view_tag = sprintf(' <a href="%s" %s>%s</a>' , $url , $current_status == $key ? 'class="current" ' : '' , $label);
        if($count !== '0'){
            $view_tag.= sprintf('<span class="count">(%d)</span>' , $count);
        }else{
            $view_tag.= sprintf('<span class="count">(%d)</span>' ,'0');
        }
        return $view_tag ;
    }

    protected function get_views(){

        global $wpdb;


        $where = '' ;
        if(isset($_GET['s'])){
            $where.= $wpdb->prepare(" AND title LIKE %s ", '%' . $wpdb->esc_like( $_GET['s']) . '%' );

        }
        $count_all = $wpdb->get_var(" SELECT COUNT(*) FROM {$wpdb->prefix}tickets ");
        $count_check = $wpdb->get_var(" SELECT COUNT(*) FROM {$wpdb->prefix}tickets WHERE status = '1'  $where");
        $count_answer = $wpdb->get_var(" SELECT COUNT(*) FROM {$wpdb->prefix}tickets WHERE status = '2'  $where");
        $count_close = $wpdb->get_var(" SELECT COUNT(*) FROM {$wpdb->prefix}tickets WHERE status = '3'  $where");
       
       

        return[
            'all' => $this->create_view('all' , 'همه' , admin_url('admin.php?page=tickets&tickets_status=all') ,  $count_all), 
            'check' => $this->create_view('check' , 'در حال بررسی' , admin_url('admin.php?page=tickets&tickets_status=check') ,  $count_check), 
            'answer' => $this->create_view('answer' , 'پاسخ داده شده' , admin_url('admin.php?page=tickets&tickets_status=answer') ,  $count_answer), 
            'close' => $this->create_view('close' , 'بسته شده' , admin_url('admin.php?page=tickets&tickets_status=close') ,  $count_close), 
        ];
    }


    public function get_sortable_columns(){
        return[
            'id' => ['id' , false]
        ];
    }

    public function proccess_bulk_actions(){
        // check security

        if( $this->current_action() == 'delete' ){
            $tickets = $_GET['tickets'];
            $record_count = count($tickets);
            global $wpdb;
            foreach( $tickets as $ticket_id ){
                $wpdb->delete(
                    $wpdb->prefix.'tickets' ,
                    [
                        'id' => $ticket_id
                    ]
                );
                
            }


          wp_redirect(admin_url('admin.php?page=tickets&status=delete_success&delete_count=' . $record_count));

        }
        

    }


    public function get_hidden_columns(){
        return get_hidden_columns(get_current_screen());
    }

    public function prepare_items(){

        $this->proccess_bulk_actions();

        global $wpdb;

        $per_page = 2 ;
        $current_page = $this->get_pagenum();
        $offset = ($current_page -1) * $per_page;

        $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : false ;
        $order = isset($_GET['order']) ? $_GET['order'] : false ;
        $orderbyTxt =  "ORDER BY {$wpdb->prefix}tickets.id" ;
        if( $order && $orderby){
            if($orderby == 'id'){
                $orderbyTxt =  "ORDER BY {$wpdb->prefix}tickets.id $order " ;
            }
        }
        $where = "AND parentId = '0' ";
        if(isset($_GET['tickets_status']) && $_GET['tickets_status'] !== 'all' ){
            if( $_GET['tickets_status']=='check' ){
                $where.= "AND status = '1' AND parentId = '0' ";
            }else if($_GET['tickets_status']=='answer'){
                $where.= "AND status = '2'AND parent = '0'  ";
            }else if($_GET['tickets_status']=='close'){
                $where.= "AND status = '3'  AND parentId = '0' ";
            }
        }

        if(isset($_GET['s'])){
            $where.= $wpdb->prepare(" AND title LIKE %s ", '%' . $wpdb->esc_like( $_GET['s']) . '%' );

        }


        $results = $wpdb->get_results(" SELECT SQL_CALC_FOUND_ROWS * FROM {$wpdb->prefix}users join {$wpdb->prefix}tickets on userId= {$wpdb->prefix}users.ID join {$wpdb->prefix}posts on courseId = {$wpdb->prefix}posts.ID $where $orderbyTxt LIMIT $per_page OFFSET $offset" , ARRAY_A);

        

        $this->_column_headers = array($this->get_columns() ,  $this->get_hidden_columns() , $this->get_sortable_columns() , 'title'  );

        $this->set_pagination_args([
            'total_items' => $wpdb->get_var("SELECT FOUND_ROWS()"),
            'per_page' => $per_page

        ]);


        $this->items = $results;
    }

}



?>