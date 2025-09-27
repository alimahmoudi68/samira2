<?php
global $my_opt;
?>
<div class="w-full p-[16px] max-w-[1536px] mx-auto bg-section-pattern flex items-center flex-col md:flex-row justify-between gap-y-4 text-center md:text-right md:h-40 lg:h-40 rounded-2xl mb-[50px] md:mb-[70px]">
    <div class="text-textPrimary-100 space-y-4">
        <h5 class="font-black text-[1.5rem] leading-[58px]">پیج اینستاگرام <?php echo get_bloginfo( 'name' );  ?></h5>
        <p class="text-[0.9rem]">اطلاع رسانی تخفیف ها، آموزش های رایگان و نکات کاربردی و لایو های آموزشی</p>
    </div>
    <a href="instagram://user?<?php echo $my_opt['opt-insta'] ?>" class="bg-white-50 inline-flex items-center shrink-0 text-base h-12 px-2 gap-x-0.5 rounded-xl text-[#502ED6] sm:bg-white-100  border border-transparent hover:border-white-100 hover:text-textPrimary-100 hover:bg-transparent transition-colors">
        <span class="text-[0.9rem] font-normal">دیدن پست ها</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="w-5 h-5">
        <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
    </a>
</div>
