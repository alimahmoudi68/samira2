<?php 

add_action('init' , 'courses_rewrite');

function courses_rewrite(){
    add_rewrite_rule(
        '^courses/?$' ,
        'index.php?all_course=1',
        'top'
    );
}

add_filter('query_vars' , 'courses_vars_handler');
function courses_vars_handler($vars){
    $vars[]= 'all_course';
    $vars[]= 'q';
    $vars[]= 'p';
    $vars[]= 'sort';
    $vars[]= 'cat';
    $vars[]= 'redirect';
    return $vars;
}


add_filter('template_include' , 'template_path_handler_courses');
function template_path_handler_courses($template_path){

    $episodes_page = get_query_var('all_course');

    
    if($episodes_page){

        return  get_template_directory().'/courses.php';
    }

    return $template_path;
}



?>