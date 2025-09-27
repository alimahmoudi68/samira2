<?php
/**
 * Menu Functions
 * All menu related functions and walker classes
 */

// mega menu walker
require_once dirname( __FILE__ ) . '/mega-menu-walker.php';

// Default menu fallback
function default_menu_fallback() {
    echo '<ul class="flex p-0 m-0 list-none h-[35px]">';
    echo '<li><a href="' . home_url() . '" class="flex text-text-primary-100 font-medium items-center ml-[30px] relative h-[35px] transition-all hover:opacity-80 header-nav">صفحه اصلی</a></li>';
    echo '<li class="z-10 relative inline-block group"><a href="' . home_url('in-person-courses') . '" class="flex text-text-primary-100 font-medium items-center ml-[30px] relative h-[35px] transition-all hover:opacity-80 header-nav">دوره‌ها</a></li>';
    echo '<li><a href="' . home_url('blog') . '" class="flex text-text-primary-100 font-medium items-center ml-[30px] relative h-[35px] transition-all hover:opacity-80 header-nav">مقاله‌ها</a></li>';
    echo '</ul>';
}

// Register menu locations
function register_my_menus() {
    register_nav_menus(
        array(
        'header_left' => __( 'منوی هدر' ),
        )
    );    
}
add_action( 'init', 'register_my_menus' );
