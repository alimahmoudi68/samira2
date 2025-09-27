<?php get_header() ?>

<main class='w-full flex-grow'>
    <div class="container mx-auto px-2 pt-[70px] md:pt-[100px]">
        <?php while(have_posts()) : the_post(); ?>

        <h1>
            <?php the_title(); ?>
        </h1>

        <?php the_content(); ?>

        <?php endwhile; ?>

    </div>
</main>


<?php get_footer() ?>