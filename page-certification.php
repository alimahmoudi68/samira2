<?php get_header() ?>


<main class='w-full flex-grow my-5 px-2'>
    <div class="container mx-auto w-full max-w-[600px] bg-white-100 p-5 mt-[10x]">
        <div id="error" class="hidden"><?php echo $error_too_much_licenec ?></div>

        <div class='w-full flex justify-start items-center mb-5'>
            <svg class='w-2 h-2 fill-gray-700 dark:fill-white-100 ml-2' viewBox="0 0 100 100"
                xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="50" />
            </svg>
            <span class='text-gray-600 dark:text-text-primary-100 text-xl font-extrabold'>استعلام گواهینامه پایان دوره</span>
        </div>

        <div class="w-full flex justify-center">
            <form class="max-w-[350px]" id="_themename-advert-create-form" method="post" enctype="multipart/form-data">
                <span>
                    لطفا کد رجیستری گواهینامه مربووطه را وارد کنید.
                </span>
                <?php wp_nonce_field('_themename_submit_advert_action','__themename_submit_advert_nonce'); ?>
                <input type="hidden" name="_themename-advert-create-check" value="1" />

                <div class="w-full flex flex-col justify-between items-center cropper-container">
                    <div class="w-full flex flex-col items-start">

                        <input class="w-full  p-2 border border-gray-200 bg-white-100 outline-hidden grow rounded-md"
                            name="code"
                            value="<?php if ( isset( $_POST['_themename-advert-create-title'] ) ) echo $_POST['_themename-advert-create-title']; ?>" />
                        <small class="w-full text-start font-semibold text-red-400 mt-1 invisible">خطا</small>
                    </div>
                </div>
                <div class='w-full flex justify-end items-center'>
                    <button id="btn-submit" type="submit" value="SUBMIT" name="_themename-advert-create-submit"
                        class="w-[60px] btn btn-remove-customer ml-1 text-[0.9rem] py-1 px-2 bg-primary-100 text-text-primary-100 outline-hidden rounded-lg hover:opacity-80">
                        استعلام
                    </button>
                </div>
            </form>
        </div>



    </div>
</main>

<div id="back-modal-remove" class='hidden w-full h-full z-60 fixed top-0 left-0 right-0 bg-modal-background-100'></div>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="<?php echo get_template_directory_uri() ?>/js/certification.js"></script>

<?php get_footer() ?>