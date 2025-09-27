<?php get_header() ?>
<main>
    <div class="container" id="main-container">
        <?php while(have_posts()) : the_post(); ?>
        <?php woocommerce_breadcrumb() ?>

        <h1>
            <?php the_title(); ?>
        </h1>
        
        <?php the_content(); ?>

        <?php comments_template(); ?>

        <?php endwhile; ?> 

    </div>
</main>


<?php get_footer() ?>