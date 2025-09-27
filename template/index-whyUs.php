<?php
global $my_opt;
//wp_die( $my_opt['opt-cover-about-video']['url'] );
?>

<div class='flex justify-between mb-4 md:mb-6'>
    <div class='text-lg flex items-center font-semibold py-2 text-text-primary-100'>
        <div class='w-[20px] h-[20px] rounded-md bg-primary-100 ml-2'></div>
        <span class="text-xl md:text-3xl font-bold">چرا ما؟</span>
    </div>
</div>


<div class="flex flex-col gap-y-8 lg:flex-row justify-between lg:items-center flex-wrap mb-[50px] md:mb-[80px]">
    <div class='w-full h-fit flex flex-wrap gap-x-[16px] gap-y-3 justify-start items-center lg:w-[48%] order-2 lg:order-1'>
        <span
            class='text-base font-semibold text-center md:text-xl text-text-primary-100 mb-2'>
            <span class='mx-1'><?php echo get_bloginfo('name'); ?></span> جایی که هنر و مهارت به هم می‌رسند.    
        </span>
        <span
            class='font-normal text-start md:font-normal text-text-primary-100 mb-6'>
            در آکادمی ما، فقط آموزش نمی‌بینید؛ بلکه به یک حرفه‌ای واقعی تبدیل می‌شوید! تدریس توسط برترین اساتید، سرفصل‌های به‌روز، پشتیبانی دائمی و ارائه مدرک معتبر، تنها بخشی از مزایای یادگیری با ماست. آماده‌اید تا به یک هنرمند حرفه‌ای در دنیای زیبایی تبدیل شوید؟
        </span>
    </div>

    <div class='w-full lg:w-[calc(50%-30px)] relative pt-[56%] lg:pt-[24%] rounded-lg order-1 lg:order-2'>
        <video width="100%" height="100%" class='video w-full h-full rounded-lg absolute top-0 left-0 right-0 bottom-0 object-cover' controls>
            <source src="<?php echo $my_opt['opt-about-video'] ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class='video-cover absolute top-0 left-0 right-0 bottom-0 flex items-center rounded-lg justify-center bg-red-500' style="background-image: url('<?php echo $my_opt['opt-cover-about-video']['url'] ?>'); background-size: cover; background-position: center; cursor: pointer; z-index: 2;">
            <span class="animate-my-ping w-[50px] h-[50px] inline-flex rounded-full bg-primary-100 opacity-50"></span>
            <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            strokeWidth={1}
            class="w-[50] h-[50px] stroke-white-100 absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%]"
            >
            <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"
            />
            </svg>
        </div> 
    </div>    
</div>

<script>
    document.querySelector('.video-cover').addEventListener('click', function() {
        this.style.display = 'none'; // حذف کاور
        document.querySelector('.video').play();
    });
</script>