<?php 
$faqs = array(
    (object) [
        'q' => 'آیا آموزشگاه زیبایی سمیرا دارای مجوز رسمی از سازمان فنی و حرفه‌ای است؟',
        'a' => 'بله، آموزشگاه زیبایی سمیرا با مجوز رسمی از سازمان فنی و حرفه‌ای فعالیت می‌کند.',
    ],
    (object) [
        'q' => 'آیا پس از پایان دوره‌ها مدرک فنی و حرفه‌ای دریافت می‌کنم؟',
        'a' => 'بله، بیشتر دوره‌های آموزشگاه سمیرا همراه با مدرک معتبر فنی و حرفه‌ای ارائه می‌شود.',
    ],
    (object) [
        'q' => 'آیا با مدرک فنی حرفه‌ای می‌توانم برای تاسیس سالن زیبایی اقدام کنم؟',
        'a' => 'برای تاسیس سالن زیبایی گذراندن دوره آرایش و پیرایش و دوره‌های مهارتی لازم ضروری است.',
    ],
    (object) [
        'q' => 'آیا امکان کارآموزی بعد از پایان دوره در آموزشگاه وجود دارد؟',
        'a' => 'بله، در صورت تایید مربی و پرداخت هزینه جداگانه، امکان کارآموزی در آموزشگاه فراهم است.',
    ],
    (object) [
        'q' => 'چه مدت بعد از پایان دوره می‌توانم وارد بازار کار شوم؟',
        'a' => 'دوره‌های آموزشگاه سمیرا به‌صورت مهارتی و عملی طراحی شده‌اند و هنرجویان معمولاً بلافاصله پس از دوره آماده ورود به بازار کار هستند.',
    ],
    (object) [
        'q' => 'آیا دوره‌ها از سطح مبتدی هم برگزار می‌شود؟',
        'a' => 'بله، دوره‌ها از سطح مبتدی تا تخصصی برگزار می‌شوند و نیاز به پیش‌نیاز ندارند.',
    ],
    (object) [
        'q' => 'آیا امکان پرداخت اقساطی شهریه وجود دارد؟',
        'a' => 'بله، آموزشگاه زیبایی سمیرا در برخی دوره‌ها امکان پرداخت اقساطی را برای هنرجویان فراهم کرده است.',
    ],
);

?>
<div class='flex flex-wrap items-start gap-y-6'>
    <div class='w-full md:w-[50%] flex flex-col'>
        <span class="text-xl md:text-3xl font-bold mb-3">سوالات پر تکرار</span>
        <span class="text-justify">
        به پرتکرار‌ترین سوالاتی که کاربران لیمو‌هاست داشته‌اند پاسخ داده‌ایم؛ شاید پاسخ شما هم در این میان باشد.
        </span>
    </div>

    <div class="w-full md:w-[50%] flex flex-col justify-between gap-2 flex-wrap">

        <?php 
            foreach($faqs as $faq) {
                
        ?>
        <div class='w-full bg-white-100 border border-gray-200 rounded-md p-3'>
            <div
                class='btn-collapse w-full text-base group font-semibold flex flex-wrap justify-between items-center text-gray-600 hover:cursor-pointer'>
                <div class='w-full flex justify-between items-center'>
                    <div class='flex justify-start items-center'>
                        <div
                            class='rounded-lg py-1 px-3 ml-2 bg-primary-100'>
                            <span
                                class='text-lg sm:text-2xl font-bold text-text-primary-100'>?</span>
                        </div>
                        <span
                            class='text-sm sm:text-base text-text-primary-100'><?php echo $faq->q; ?></span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 sm:h-6 sm:w-6 stroke-gray-600 stroke-text-primary-100"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
            </div>
            <div class='answer-container w-full transition-all duration-200 rounded-md max-h-0 overflow-hidden'>
                <div class='mt-3 p-3 rounded-md'>
                    <span
                        class='text-sm sm:text-base font-normal text-text-primary-100'><?php echo $faq->a; ?></span>
                </div>
            </div>
            </div>    
          

        <?php } ?>
    
    
    </div>
</div>

