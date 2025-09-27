11
<?php get_header() ?>
<main class='w-full flex-grow mb-5 px-2'>
<div class="container mx-auto">
    <div class='my-5 py-2 dark:text-textPrimary-100'>
        <span class="text-xl md:text-3xl font-bold text-slate-700 dark:text-textPrimary-100">رخ‌تاپ تی‌وی</span>
        <span class="block text-base md:text-xl font-medium text-slate-400 dark:text-white-50">ویدیو‌های آموزشی ببین</span>
    </div>

    <div class="flex flex-wrap">

        <div class="w-full md:w-9/12 md:order-2">

            <div class="flex flex-wrap" id="main">
            <?php while(have_posts()) : the_post(); ?>
                    <div class="w-full sm:w-1/2 md:w-1/3 my-1">
                        <?php wc_get_template_part( 'template/card', 'top-teachers' ); ?>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class='pagination'>
                <?php echo paginate_links(array(
                    'perv_next' => __(false) ,
                    'prev_text' => __('<'),
                    'next_text' => __('>') ,
                )); ?>
            </div>
        </div>
        <div class="w-full md:w-3/12 md:order-1">
            <div class='border border-gray-300 rounded-xl mt-3 p-3 md:mt-0 md:ml-4 dark:bg-dark-100 dark:border-cyan-500'>
            <?php
            if( is_active_sidebar('sidebar-archive-tv')){ ?>
            <?php dynamic_sidebar('sidebar-archive-tv') ?>
            <?php } ?>
            </div>
        </div>
    </div>
</div>
</main>
<?php get_footer() ?>