<?php
if(!is_user_logged_in() && $pagename == 'my-account') {
    //$login_url = home_url()+'/login';
    wp_redirect( home_url('/auth') , 302 );
    exit;
}
?>
<?php get_header() ?>

<main class='w-full flex-grow'>
    <div class="container mx-auto px-6 pt-[100px] md:pt-[140px] md:pb-[100px]">
        <?php while(have_posts()) : the_post(); ?>

        <h1 class="mb-5 font-bold text-xl md:text-2xl text-text-primary-100">
            <?php the_title(); ?>
        </h1> 

        <?php the_content(); ?>

        <?php endwhile; ?>

        </div>
</main>
<?php get_footer() ?>

