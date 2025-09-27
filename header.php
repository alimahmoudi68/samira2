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
<body dir="rtl" class='h-screen font-dana bg-white-100 flex flex-col ss02 ss03'>

    <div class="preloader fixed w-screen h-screen bg-dark-30  backdrop-blur-lg flex items-center justify-center z-[100]">
        <div class="w-[100px] h-[100px] flex items-center justify-center relative rounded-full">
            <span class="w-full h-full absolute inline-block rounded-[50%] border-t-[2px] shadow-loading animate-loading"></span>
            <span class="w-full h-full absolute inline-block rounded-[50%] shadow-loadingBg bg-gradient-to-r from-primary-100 to-[##191a1a]"></span>
            <img class="z-[2] rounded-full" class="logo" src="<?php echo $my_opt['opt-logo']['url'] ?>" width="80" height="60"/>
        </div>
    </div>

    <div class='bg-profile-menu hidden fixed w-screen h-screen bg-red-500 z-[2000] bg-slate-900 bg-opacity-50'>
    </div>

    <header class='h-full mst-sidebar-bg hidden fixed z-[3000] h-full w-full overflow-auto bg-slate-900 bg-opacity-50' >
        <nav
            class='h-full mst-sidebar absolute top-0 right-0 bg-darkBack-100 w-3/5 h-screen z-[3001] pt-5 pr-1 pb-5 translate-x-full transition-transform duration-300 overflow-auto md:hidden'>
            <div class=' flex justify-center items-center pb-8'>
                <Image width="80" height="60" src="<?php echo $my_opt['opt-logo']['url'] ?>" alt='logo' />
            </div>
            <ul class='flex flex-col list-none p-3'>
                <li class='pb-5'>
                    <a href="<?php echo home_url(); ?>"
                        class='no-underline text-base font-normal text-textPrimary-100 visited:text-textPrimary-100 active:text-textPrimary-100 hover:text-white-50'>
                        صفحه اصلی
                    </a>
                </li>
                <li class='pb-5'>
                    <div
                        class="mst-sidebat-cat-txt flex items-center justify-between text-textPrimary-100 hover:cursor-pointer hover:text-white-50 transition-all duration-150">
                        <span
                            class='no-underline text-base font-normal visited:text-textPrimary-100 active:text-textPrimary-100'>
                            دوره‌های آموزشی
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" strokeWidth={2}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div
                        class='mst-sidebat-cat bg-darkCard-100 max-h-0 overflow-hidden transition-all duration-500 pr-8 mt-3'>
                        <ul class='pr-0 first:mt-5 last:mb-5'>
                            <li class="p-0 mb-5">
                                <div class='flex'>
                                    <a href="/courses/color-specialist"
                                        class='no-underline text-base font-normal text-textPrimary-100 visited:text-textPrimary-100 active:text-gray-800 active:text-textPrimary-100 hover:text-white-50'>
                                        متخصص رنگ
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class='pb-5'>
                    <a href="<?php echo home_url('/blog') ?>"
                        class='no-underline text-base font-normal text-textPrimary-100 visited:text-textPrimary-100 active:text-textPrimary-100 hover:text-white-50'>مقالات</a>
                </li>
                <li class='pb-5'>
                    <a href="<?php  echo home_url('about') ?>"
                        class='no-underline text-base font-normal text-textPrimary-100 visited:text-textPrimary-100 active:text-textPrimary-100 hover:text-white-50'>درباره
                        ما</a>
                </li>
            </ul>
        </nav>
    </header>

    <div class='mst-cart-bg hidden fixed z-[3000] w-full h-screen bg-slate-900 bg-opacity-50'>
        <div class='mst-cart absolute top-0 left-0 bg-white-100 w-3/5 max-w-[500px] h-screen z-40 pt-5 p-2 translate-x-[-100%] transition-transform duration-300 overflow-hidden'>
            <div id="mini-cart" class="w-full h-full cart-list flex flex-col justify-between">
                <?php woocommerce_mini_cart(); ?>
            </div>
        </div>
    </div>

    <header class='header header-top w-full transition-all duration-300 z-[2000] fixed top-[24px]'>
        <div class='container mx-auto border border-gray-200 flex justify-between px-2 py-3 md:py-5 backdrop-blur-lg rounded-lg relative'>
            <div class='flex justify-between items-center'>
                <div class='btn-hamberger flex items-center ml-3 md:ml-5 md:hidden'>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-8 stroke-textPrimary-100 hover:cursor-pointer hover:opacity-60" fill="none"
                        viewBox="0 0 24 24" strokeWidth="4">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </div>
                <a href='<?php  echo home_url() ?>' class='items-center ml-5 flex'>
                    <img width="300" height="300" src="<?php echo $my_opt['opt-logo']['url'] ?>" class='w-[50px] h-auto'/>
                    <p class='text-textPrimary-100 mr-2 flex text-textPrimary-100 font-bold hidden md:block'>
                        <?php echo get_bloginfo('name'); ?>
                    </p>
                </a>    
                <nav class='hidden md:block'>
                    <ul class='flex p-0 m-0 list-none h-[35px]'>
                        <li>
                            <a href="<?php  echo home_url() ?>"
                                class="flex text-textPrimary-100 font-medium items-center ml-[30px] relative h-[35px] transition-all hover:opacity-80 header-nav">صفحه
                                اصلی</a>
                        </li>
                        <li class='z-10 relative inline-block group'>
                            <a href="<?php  echo home_url('in-person-courses') ?>"
                                class="flex text-textPrimary-100 font-medium items-center ml-[30px] relative h-[35px] transition-all hover:opacity-80 header-nav">دوره‌ها
                                </a>
                            <div
                                class='sub-menu-container invisible absolute flex flex-col w-[200px] border bg-white-100 top-[25px] rounded-lg -translate-y-2  group-hover:visible  group-hover:translate-y-2 transition-transform duration-150'>
                                <ul class='list-none p-0'>
                                    <li
                                        class='text-xs font-medium text-textPrimary-100 hover:bg-gray-100'>
                                        <a href="<?php  echo home_url('in-person-course/دوره-صفر-تا-صد-گریم-و-میکاپ/') ?>" class='px-[10px] py-[15px] block'>
                                        دوره رنگ‌های بدون دکلره 
                                        </a>
                                    </li>
                                    <li
                                        class='text-xs font-medium text-textPrimary-100 hover:bg-gray-100'>
                                        <a href="<?php  echo home_url('in-person-course/دوره-صفر-تا-صد-ماساژ-صورت-و-گردن/') ?>" class='px-[10px] py-[15px] block'>
                                        دوره تکنیک رنگ
                                        </a>
                                    </li>
                                    <li
                                        class='text-xs font-medium text-textPrimary-100 hover:bg-gray-100'>
                                        <a href="<?php  echo home_url('in-person-course/دوره-صفر-تا-صد-آرایش-موی-زنانه/') ?>" class='px-[10px] py-[15px] block'>
                                        دوره ترکیب رنگ
                                        </a>
                                    </li>
                                    <li
                                        class='text-xs font-medium text-textPrimary-100 hover:bg-gray-100'>
                                        <a href="<?php  echo home_url('in-person-course/دوره-صفر-تا-صد-کاربر-مواد-شیمیایی/') ?>" class='px-[10px] py-[15px] block'>
                                        دوره کراتین
                                        </a>
                                    </li>
                                    <li
                                        class='text-xs font-medium text-textPrimary-100 hover:bg-gray-100'>
                                        <a href="<?php  echo home_url('in-person-course/دوره-صفر-تا-صد-پاکسازی-پوست/') ?>" class='px-[10px] py-[15px] block'>
                                        دوره کوتاهی
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="<?php  echo home_url('blog') ?>"
                                class="flex text-textPrimary-100 font-medium items-center ml-[30px] relative h-[35px] transition-all hover:opacity-80 header-nav">مقاله‌ها</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class='flex justify-end items-center'>
                <div class="btn-cart text-center cursor-pointer relative">             
                    <div class="w-[40px] h-[40px] flex items-center justify-center rounded-full ml-2 bg-primary-30 relative group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-7 md:w-7 stroke-primary-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth=2>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span id="cart-count" class="h-[17px] leading-[15px] text-[0.7rem] absolute top-[-4px] right-[4px] rounded-full bg-primary-100 px-[4px] py-[1px] tex-sm text-textPrimary-100">
                            <?php echo WC()->cart->get_cart_contents_count(); ?>
                        </span>
                        <div class='scale-0 duration-300 px-[2px] opacity-0 left-[-3px] top-[44px] absolute md:group-hover:opacity-100 md:group-hover:scale-105 rounded-lg bg-white-100 text-xs border border-slate-700 w-14 text-center'>
                            <span class='text-gray-500 dark:text-textPrimary-100'>سبد خرید</span>
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
                        class="profile-menu hidden absolute p-3 rounded-lg top-14 left-1 w-[200px] bg-white-100 border z-[2002]">
                        <ul>
                            <li><a href="<?php echo home_url()  ?>/my-account"
                                    class='flex items-center list-none text-sm font-normal px-3 py-2 w-full rounded-lg hover:cursor-pointer hover:bg-gray-100'>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 stroke-white-100" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" strokeWidth="2">
                                        <path strokeLinecap="round" strokeLinejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class='mr-1 text-textPrimary-100'>
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
                                    <span class='mr-1 text-textPrimary-100'>
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
                                <span class='text-gray-500 dark:text-textPrimary-100'>ورود</span>
                            </div>
                        </div>
                    </a>
                
                <?php } ?>
            </div>
        </div>
    </header> 


