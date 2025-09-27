<?php 

add_action('init' , 'customer_rewrite');

function customer_rewrite(){

    add_rewrite_rule(
        'auth' ,
        'index.php?auth=yes',
        'top'
    );

}

add_filter('query_vars' , 'customer_vars_handler');
function customer_vars_handler($vars){
    $vars[]= 'auth';
    return $vars;
}


add_filter('template_include' , 'template_path_handler_customer');
function template_path_handler_customer($template_path){

    $auth_page = get_query_var('auth');
    if($auth_page){
        return  get_template_directory().'/page-auth.php';
    }
    return $template_path;
}



?>