<?php get_header() ?>
<main class='w-full flex-grow mb-5 px-2 py-5'>
<div class="container mx-auto">

    <div class="flex flex-wrap">

        <div class="w-full md:w-9/12 md:order-2" id="main">

            <div class=" bg-white-100 dark:bg-dark-100 p-2 mb-3 rounded-lg relative pt-[60%] md:pt-[50%]" >
                <?php 
                    $video = get_post_meta( get_the_ID() , 'tutor_video' , true);
                ?>
                <video class="w-full h-full absolute top-0 left-0 right-0 bottom-0 rounded-lg" controls>
                    <source src="<?php echo $video ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>


                <?php
                $original_query = $wp_query;

                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                $args =  array(
                    'post_type' => 'product',
                    'meta_key' => 'product_teacher',
                    'meta_value' => get_the_ID(),
                    'nopaging'   => false,
                    'posts_per_page' => 20 , 
                    'paged' => $paged,
            
                );

                $videos = new WP_Query($args);
                if($videos->have_posts()){ ?>

                    <div class="flex justify-between flex-wrap gap-3" >
                    <?php 
                    while($videos->have_posts()):
                    $videos->the_post();
                    wc_get_template_part( 'template/card', 'product' );
                    endwhile; 
                ?>

                </div>
                <div class='pagination'>
                    <?php
                    $orig_query = $wp_query; // fix for pagination to work
                    $wp_query = $videos;

                    $current_page = max(1, get_query_var('paged'));
                    echo paginate_links(array(
                        'base' => get_pagenum_link(1) . '%_%',
                        //'format' => '?page/%#%',
                        //'format' => '/paged/%#%',
                        //'format'       => '?paged%#%',

                        'current' => $current_page,
                        'total' => $videos->max_num_pages,
                        'perv_next' => __(false) ,
                        'prev_text' => __('<'),
                        'next_text' => __('>') ,
                    )); 
                    
                    ?>
                </div>
                <?php }
                wp_reset_query();
                $wp_query = $original_query;
                ?>
        </div>
        <div class="w-full md:w-3/12 md:order-1">
            <div class=' bg-white-100 rounded-xl mt-3 p-3 md:mt-0 md:ml-4 dark:bg-dark-100 dark:border-cyan-500 sticky top-[10px]'>
                <div class='teacher-prof flex flex-col justify-center items-center p-3 mt-3 md:mt-2 md:ml-3 dark:bg-dark-50 dark:shadow-none'>
                    <?php the_post_thumbnail('teacher'); ?>
                    <span class='text-[0.9rem] text-justify font-normal	text-gray-400 dark:text-text-primary-100'>
                        <?php the_title(); ?>
                    </span>
                    <span class='text-[0.9rem] text-justify font-normal	my-2 text-gray-500 dark:text-text-primary-100'>
                    <?php the_excerpt(); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<?php get_footer() ?>

