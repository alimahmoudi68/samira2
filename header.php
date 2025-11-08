<?php
global $my_opt;
?>
<!DOCTYPE html>
<html dir="rtl" lang="fa-IR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0" />
    <meta name="theme-color" content="#fc427b" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="description" content="<?php bloginfo('description') ?>">
    <meta name="keywords" content="<?php bloginfo('description') ?>">
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri().'/images/favicon.png' ?>" title="Favicon" />

    <?php wp_head(); ?>

</head>
<body dir="rtl" class='h-screen font-modam bg-white-100 flex flex-col ss02 ss03'>

    <div class="preloader fixed w-screen h-screen bg-dark-30 backdrop-blur-lg flex items-center justify-center z-100">
        <div class="w-[100px] h-[100px] flex items-center justify-center relative rounded-full">
            <span class="w-full h-full absolute inline-block rounded-[50%] border-t-2 shadow-loading animate-loading"></span>
            <span class="w-full h-full absolute inline-block rounded-[50%] shadow-loadingBg bg-linear-to-r from-primary-100 to-[##191a1a]"></span>
            <img class="z-2 rounded-full" class="logo" src="<?php echo $my_opt['opt-logo']['url'] ?>" width="80" height="60"/>
        </div>
    </div>

    <div class='bg-profile-menu hidden fixed w-screen h-screen bg-red-500 z-2000 bg-slate-900 bg-opacity-50'>
    </div>

    <div class='mega-menu-bg hidden fixed w-screen h-screen bg-black-50 z-40'>
    </div>

    <div class='mst-cart-bg hidden fixed z-3000 w-full h-screen bg-slate-900 bg-opacity-50'>
        <div class='mst-cart absolute top-0 left-0 bg-white-100 w-3/5 max-w-[500px] h-screen z-40 pt-5 p-2 -translate-x-full transition-transform duration-300 overflow-hidden'>
            <div id="mini-cart" class="w-full h-full cart-list flex flex-col justify-between">
                <?php woocommerce_mini_cart(); ?>
            </div>
        </div>
    </div>

    <header class='hidden header header-top w-full transition-all duration-300 z-2000 md:block md:fixed top-[24px]'>
        <div class='container mx-auto border border-gray-200 flex justify-between px-2 py-3 md:py-5 backdrop-blur-lg rounded-lg relative'>
            <div class='flex justify-between items-center'>
                <a href='<?php  echo home_url() ?>' class='items-center ml-5 flex'>
                    <img width="300" height="300" src="<?php echo $my_opt['opt-logo']['url'] ?>" class='w-[50px] h-auto'/>
                    <p class='text-text-primary-100 mr-2 flex text-text-primary-100 font-bold hidden md:block'>
                        <?php echo get_bloginfo('name'); ?>
                    </p>
                </a>    
                <nav class='hidden md:block'>
                    <!-- WordPress mega menu -->
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header_left',
                        'menu_class' => 'flex p-0 m-0 list-none h-[35px]',
                        'container' => false,
                        'walker' => new Mega_Menu_Walker(),
                        'fallback_cb' => 'default_menu_fallback'
                    ));
                    ?>
                </nav>
            </div>
            <div class='flex justify-end items-center'>
                <div class="btn-cart text-center cursor-pointer relative">             
                    <div class="w-[40px] h-[40px] flex items-center justify-center rounded-full ml-2 bg-primary-30 relative group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-7 md:w-7 stroke-primary-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth=2>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span id="cart-count" class="h-[17px] leading-[15px] text-[0.7rem] absolute top-[-4px] right-[4px] rounded-full bg-primary-100 px-[4px] py-px tex-sm text-text-primary-100">
                            <?php echo WC()->cart->get_cart_contents_count(); ?>
                        </span>
                        <div class='scale-0 duration-300 px-[2px] opacity-0 left-[-3px] top-[44px] absolute md:group-hover:opacity-100 md:group-hover:scale-105 rounded-lg bg-white-100 text-xs border border-slate-700 w-14 text-center'>
                            <span class='text-gray-500 dark:text-text-primary-100'>سبد خرید</span>
                        </div>
                    </div>
                </div>
                <?php if(is_user_logged_in()){
                $current_user = wp_get_current_user();
                ?>
                <div
                    class="profile-header-container h-[53px] flex items-center justify-center text-color-state-600 relative hover:cursor-pointer">
                    <div>
                        <img class="rounded-full" width="40" height="40" src="<?php echo get_template_directory_uri(); ?>/images/default-avatar.jpg"
                            alt="user" />
                    </div>
                    <div
                        class="profile-menu hidden absolute p-3 rounded-lg top-14 left-1 w-[200px] bg-white-100 border z-2002">
                        <ul>
                            <li><a href="<?php echo home_url()  ?>/my-account"
                                    class='flex items-center list-none text-sm font-normal px-3 py-2 w-full rounded-lg hover:cursor-pointer hover:bg-gray-100'>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 stroke-white-100" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" strokeWidth="2">
                                        <path strokeLinecap="round" strokeLinejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class='mr-1 text-text-primary-100'>
                                        حساب کاربری
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo wp_logout_url( home_url() ); ?>"
                                    class='flex items-center list-none text-sm font-normal px-3 py-2 w-full rounded-lg  hover:bg-gray-100'>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 stroke-white-100" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" strokeWidth="2">
                                        <path strokeLinecap="round" strokeLinejoin="round"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span class='mr-1 text-text-primary-100'>
                                        خروج
                                    </span> </a>
                            </li>
                        </ul>
                    </div>

                </div>
                <?php 
                }else{ ?>
                    <a href="<?php echo home_url()  ?>/my-account">
                        <div class="w-[40px] h-[40px] flex items-center justify-center rounded-full ml-2 bg-primary-30 relative group">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-5 w-5 md:h-7 md:w-7 stroke-primary-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth=2>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <div class='scale-0 duration-300 px-[2px] opacity-0 left-[-3px] top-[44px] absolute md:group-hover:opacity-100 md:group-hover:scale-105 rounded-lg bg-white-100 text-xs border border-slate-700 w-14 text-center'>
                                <span class='text-gray-500 dark:text-text-primary-100'>ورود</span>
                            </div>
                        </div>
                    </a>
                
                <?php } ?>
            </div>
        </div>
    </header> 


