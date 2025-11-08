<?php
global $my_opt;
?>


<div class='footer-mobile md:hidden container mx-auto z-[150] fixed bottom-[0px] border border-[#9B9C9F] right-[0px] left-[0px] bg-white-100 px-4 py-2 text-center flex justify-between items-center' data-color='<?php echo $my_opt['opt-color-rgba']['color']; ?>' data-url='<?php echo home_url() ?>'>
        
  <a href='<?php echo home_url() ?>' data-url='' class='text-primary-100 w-[60px] text-[0.7rem] font-light rounded-full flex flex-col items-center justify-center lg:cursor-pointer group lg:hover:bg-gray-200 duration-300'>
    <div class='p-2 rounded-md bg-primary-20'>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class='h-6 w-6 mb-1 stroke-primary-100'>
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
      </svg>
    </div>
    صفحه اصلی
  </a>

  <a href='<?php echo home_url('courses') ?>' data-url='courses' class='text-primary-100 w-[60px] text-[0.7rem] font-light rounded-full flex flex-col items-center justify-center lg:cursor-pointer group lg:hover:bg-gray-200 duration-300'>
    <div class='p-2 rounded-md bg-primary-20'>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 mb-1 stroke-primary-100">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
      </svg>
    </div>
    دوره‌ها
  </a>

  <a href='<?php echo home_url('my-account') ?>' data-url='my-account' class='text-primary-100 w-[60px] text-[0.7rem] font-light rounded-full flex flex-col items-center justify-center lg:cursor-pointer group lg:hover:bg-gray-200 duration-300'>
    <div class='p-2 rounded-md bg-primary-20'>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 mb-1 stroke-primary-100">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
      </svg>
    </div>
    پروفایل من
  </a>

</div>


<?php wp_footer(); ?>  

</body>

</html>