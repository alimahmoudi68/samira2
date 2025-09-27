<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>
<main class="w-full flex-grow mb-5 px-2">
	<div class='loading w-full h-full flex justify-center items-center fixed top-0 left-0 z-70 hidden'>
		<div class="lds-ripple">
			<div></div>
			<div></div>
		</div>
	</div>
	<div class="container mx-auto archve-product">
		<div class='my-5 py-2 dark:text-text-primary-100'>
			<span class="text-xl md:text-3xl font-bold text-slate-700 dark:text-text-primary-100">دوره‌ها</span>
		</div>
		<div class="w-full flex flex-wrap">
			<div class="w-full md:w-9/12 md:order-2 woocommerce">


<?php
/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<header class="woocommerce-products-header">
	<!-- <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?> -->

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>
<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'mycontent', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
?>


</div>

<!-- <?php
// in ghesmat side bar az file sidebar asli mikhanad
//do_action( 'woocommerce_sidebar' );
?> -->

<div class="w-full md:w-3/12 md:order-1">
    <div class='border border-gray-300 rounded-xl mt-3 p-3 md:mt-0 md:ml-4 dark:bg-dark-100 dark:border-cyan-500'>
		<?php
		if( is_active_sidebar('sidebar-archive-product')){ ?>
		
		<?php dynamic_sidebar('sidebar-archive-product') ?>

		<?php } ?>
	</div>
</div>		



		</div>
	</div>
</div>

<?php
get_footer( 'shop' );
?>
<script src="<?php echo get_template_directory_uri() ?>/js/jquery-3.3.1.slim.min"></script>
<script src="<?php echo get_template_directory_uri() ?>/js/tv-archive.js"></script>