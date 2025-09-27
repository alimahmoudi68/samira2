<?php get_header() ?>
<div class='loading w-full h-full  justify-center items-center fixed top-0 left-0 z-70 hidden'>
    <div class="lds-ripple">
        <div></div>
        <div></div>
    </div>
</div>
<main class='w-full flex-grow mb-5 px-2'>

<div class="container mx-auto">
    <div class='my-5 py-2 dark:text-textPrimary-100'>
        <span class="text-xl md:text-3xl font-bold text-slate-700 dark:text-textPrimary-100">همه سالن‌ها</span>
        <span class="block text-base md:text-xl font-medium text-slate-400 dark:text-white-50">سالن‌های زیبایی رو پیدا کن</span>
    </div>

    <div class="flex flex-wrap" id="main">

        <div class="w-full md:w-9/12 md:order-2">

            <div class="flex flex-wrap">
            <?php while(have_posts()) : the_post(); ?>
                    <div class="w-full sm:w-1/2 md:w-1/3 my-1">
                        <?php wc_get_template_part( 'template/card', 'salon' ); ?>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class='pagination'>
                <?php 
                global $wp_query;
                $current_page = max(1, get_query_var('paged'));
                if (isset($_GET['_sfm_tv_teacher']) || isset($_GET['_sft_tv-cat'])) {
                    $format = '&sf_paged=%#%';
                } else  {
                    $format = '?sf_paged=%#%';
                  }


                echo paginate_links(array(
                    'base' => get_pagenum_link(1) . '%_%',
                    //'format' => '?page/%#%',
                    'format' => $format,
                    'current' => $current_page,
                    'total' => $wp_query->max_num_pages,
                    'perv_next' => __(false) ,
                    'prev_text' => __('<'),
                    'next_text' => __('>') ,
                )); 
                ?>
            </div>
        </div>
        <div class="w-full md:w-3/12 md:order-1">
            <div class='border border-gray-300 rounded-xl mt-3 p-3 md:mt-0 md:ml-4 dark:bg-dark-100 dark:border-cyan-500'>
            <?php
            if( is_active_sidebar('sidebar-archive-salon')){ ?>
            <?php dynamic_sidebar('sidebar-archive-salon') ?>
            <?php } ?>
            </div>
        </div>
    </div>
</div>
</main>
<?php get_footer() ?>

<script src="<?php echo get_template_directory_uri() ?>/js/jquery-3.3.1.slim.min"></script>
<script src="<?php echo get_template_directory_uri() ?>/js/tv-archive.js"></script>
