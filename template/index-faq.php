<?php 
$faqs = array(
    (object) [
        'q' => 'آیا آموزشگاه زیبایی زهرا دلیل، زیر نظر سازمان فنی حرفه ای فعالیت میکنه؟',
        'a' => 'بله، آموزشگاه زیبایی زهرا دلیل دارای مجوز رسمی از سازمان فنی حرفه ای می باشد.',
        ],
    (object) [
        'q' => 'آیا در پایان دوره های آرایشگری مدرک فنی حرفه ای دریافت می کنم؟',
        'a' => 'بله. بسیاری از دوره‌ها مدرک فنی حرفه ای دارند. برای اطلاعات بیشتر در مورد هر دوره، روی دوره مورد نظر کلیک کنید.',
    ],
    (object) [
        'q' => 'آیا با مدرک فنی حرفه ای تمام دوره ها می توان اقدام به تاسیس سالن آرایشگری کرد؟',
        'a' => 'خیر، برای تاسیس سالن باید یک دوره آرایش و پیرایش را بگذرانید و با دوره‌های هفت مهارت جداگانه را بگذرانید.',
    ],
    (object) [
        'q' => 'بعد از گرفتن مدرک میتونم در آموزشگاه به عنوان کارآموز مشغول به کار بشم؟',
        'a' => 'بله، در صورت تایید مربی با پرداخت هزینه جداگانه می توانید در آموزشگاه مشغول به کارآموزی شوید.',
    ],
    (object) [
        'q' => 'بعد از تموم شدن دوره آموزشی، چه قدر طول میکشه تا بتونم وارد بازارکار بشم؟',
        'a' => 'تمام دوره های آموزشی آموزشگاه زهرا دلیل جهت ورود سریع به بازارکار طراحی شده است و بلافاصله بعد از تمام شدن دوره می توانید وارد بازارکار شوید.',
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

