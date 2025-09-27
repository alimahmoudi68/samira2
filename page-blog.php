<?php get_header() ?>
<div class='loading w-full h-full flex justify-center items-center fixed top-0 left-0 z-70 hidden'>
    <div class="lds-ripple">
        <div></div>
        <div></div>
    </div>
</div>
<main class='w-full flex-grow mb-5 px-2'>
    <div class="container mx-auto">
        <div class='my-5 py-2 dark:text-text-primary-100'>
            <span class="text-xl md:text-3xl font-bold text-slate-700 dark:text-text-primary-100">مقاله‌ها</span>
            <span class="block text-base md:text-xl font-medium text-slate-400 dark:text-white-50">مقاله‌های رخ‌تاپ</span>
        </div>

        <div class="w-full flex flex-wrap" id="main">

            <div class="w-full md:w-9/12 md:order-2">

                <div class="flex flex-wrap">
                    <?php

                    $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' =>10, 
                        'paged' => $paged ,
                        'order' => 'DESC'  
                    );
                    $query = new WP_Query( $args );
                    var_dump($query->max_num_pages);
                    while ( $query->have_posts() ) :
                        $query->the_post();
                    ?>
                    <div class="w-full sm:w-1/2 md:w-1/3 my-1">
                        <?php wc_get_template_part( 'template/card', 'tv' ); ?>
                    </div>
                    <?php endwhile ?>
                    <?php wp_reset_postdata(); ?>
                </div>

                <?php
                    $big = 999999999; // need an unlikely integer



                    echo paginate_links( array(
                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format' => '?paged=%#%',
                        'current' => $paged ,
                        'total' =>  $query->max_num_pages
                    ) );
                    ?>

            </div>
            <div class="w-full md:w-3/12 md:order-1">
                <div class='border border-gray-300 rounded-xl mt-3 p-3 md:mt-0 md:ml-4 dark:bg-dark-100 dark:border-cyan-500'>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer() ?>

<script src="<?php echo get_template_directory_uri() ?>/js/jquery-3.3.1.slim.min"></script>
<script src="<?php echo get_template_directory_uri() ?>/js/tv-archive.js"></script>
