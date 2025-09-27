<?php
if(is_user_logged_in()) {
    wp_redirect( home_url() , 302 );
    exit;
}
$redirect =  get_query_var('redirect');
?>
<?php get_header() ?>


<main class='w-full grow h-full flex flex-col items-center justify-center pt-[80px] md:pt-[100px] md:pb-[100px] px-2 relative'>
    <div class="w-full overflow-y-hidden flex flex-col max-w-[400px] bg-white-100 rounded-md p-5 my-[100px]">
        <span class="mx-auto mb-6 font-black text-textPrimary-100">
            ورود به حساب کاربری
        </span>
        <div id="card-send-otp" class="w-full flex flex-col duration-300">
            <?php if($redirect == 'checkout'){ ?>
            <span class="mb-5 text-sm text-textPrimary-100 text-start">
                لطفا قبل از ادامه خرید وارد حساب کاربری خود شود و یا ثبت نام کنید.
            </span>
            <?php }else{ ?>
            <span class="mb-5 text-sm text-textPrimary-100 text-start">
                برای ورود یا ثبت نام لطفا شماره موبایل خود را وارد کنید.
            </span>
            <?php } ?>
            <div>
                <input name='phone' type="text" autocomplete="off" inputmode='tel' class="w-full h-10 bg-background-100 text-textPrimary-100 font-dana outline-none rounded-md px-[10px] py-p[5px]" placeholder="شماره موبایل"/>
                <small class="w-full text-start font-semibold text-red-400 mt-1 invisible">خطا</small>
            </div>
            <button id="btn-send-otp" class="btn w-full mt-2 tex-normal rounded-lg bg-primary-100 py-[10px] border border-primary-100 text-white-100 hover:opacity-80 duration-300">
                ورود  
            </button>
        </div>
        <div id="card-verify" class="w-full flex-col translate-y-[300px] duration-300 hidden">
            <span class="mx-auto mb-5 text-textPrimary-100">
                کدی که به شماره موبایل شما ارسال شد را وارد کنید
            </span>
            <input name='token' class="hidden" id='token-input' value=""/>
            <input name='otp' autocomplete="off" type="text" class="w-full h-10 text-center text-textPrimary-100 bg-background-100 font-dana outline-none rounded-md px-[10px] py-p[5px]" placeholder="- - - - -"/>
            <div class='flex justify-start h-5 mt-2'>
                <div class="verify-timer text-textPrimary-100 text-[0.7rem]">
                    <span id="seconds">59</span>
                    <span>:</span>
                    <span id="minutes">1</span>
                    <span> تا درخواست مجدد کد فعالسازی</span>
                </div>
                <div
                    class="verify-resend hidden text-sm hover:cursor-pointer hover:bg-primary-50 text-primary-100">
                    ارسال مجدد پیامک
                </div>
            </div>
            <button id="btn-verify" class="btn w-full mt-5 tex-normal bg-primary-100 py-[8px] border rounded-lg border-primary-100 text-white-100 hover:opacity-80 duration-300">
                تایید  
            </button>
        </div>
        <div id="card-register" class="w-full flex-col translate-y-[300px] duration-300 hidden">
            <span class="mx-auto mb-5 text-sm text-textPrimary-100">
                برای تکمیل ثبت نام لطفا نام و نام خانوادگی خود را وارد نمایید
            </span>
            <div>
                <input name='name' type="text" autocomplete="off" class="w-full h-10 font-dana outline-none rounded-lg text-textPrimary-100 bg-background-100 px-[10px] py-p[5px]" placeholder="نام و نام خانوادگی"/>
                <small class="w-full text-start font-semibold text-red-400 mt-1 invisible">خطا</small>
            </div>
            <button id="btn-register" class="btn w-full mt-5 tex-normal rounded-lg bg-primary-100 py-[8px] border border-primary-100 text-white-100 hover:opacity-80 duration-300">
                ثبت نام  
            </button>
        </div>
    </div>

  

</main>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php get_footer() ?>

