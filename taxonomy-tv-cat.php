<?php get_header() ?>

<main>

<div class="container" id="main-container">
    <div class='title-sec'>
        <svg class="text-dark-550 dark:text-white ml-4" width="37" height="34" viewBox="0 0 37 34" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="10" cy="24" r="10" fill="currentColor"></circle>
            <circle cx="30" cy="13" r="7" fill="currentColor" fill-opacity="0.4"></circle>
            <circle cx="15" cy="4" r="4" fill="currentColor" fill-opacity="0.7"></circle>
        </svg>
        <div class='sec-clip-title text-xl	font-semibold text-gray-700 dark:text-textPrimary-100	py-[10px] border-b-[3px] border-primary-100'>
        
            <span>رخ‌تاپ تی‌وی</span>
            <?php
            $queried_object = get_queried_object();
            $name_term = $queried_object ->name;
            ?>
            <span class="cat-title">دسته: <?php echo $name_term; ?></span>
        </div>
    </div>
    <div class="row m-0 p-0">

        <div class="col-12 col-md-3 m-0 p-0 sb">
            <div class="archive-sidebar border-sidebar p-2">
                <div class="archive-sidebar-head">
                    <div>
                        <span>دسته بندی</span>
                    </div>
                </div>
                <ul class="m-0 p-0">
                    <?php 
                        $cats = get_terms( array( 'post_types' => 'tv', 'taxonomy' => 'tv-cat' ) );
                        foreach( $cats as $cat ) {
                    ?>
                        <li>
                            <a href='<?php  echo home_url(); ?>/tv-cat/<?php echo $cat->slug ?>'>
                                <?php echo $cat->name; ?>
                            </a>
                        </li>  
                    <?php     
                    }
                    ?>

                   
                </ul>
            </div>
        </div>

        <div class="col-12 col-md-9 m-0 p-0" >

            <div class="row m-0 p-0">

                <?php while(have_posts()) : the_post(); ?>
                    <div class="col-6 col-sm-4 p-0 m-0">
                        <div class='m-1'>
                            <?php wc_get_template_part( 'template/card', 'tv' ); ?>
                        </div>
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

      


    </div> 

</div>

</main>

<?php get_footer() ?>