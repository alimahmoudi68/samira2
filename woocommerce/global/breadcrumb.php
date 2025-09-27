<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ) { ?>

	<div class='w-full overflow-x-auto overflow-y-hidden text-textPrimary-100 bg-white-100 px-5 py-2 md:py-4 rounded-lg flex gap-x-2 items-center mt-2 mb-3'>

	<?php
	foreach ( $breadcrumb as $key => $crumb ) {


		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<div class="relative px-[20px]">
				<div class="w-[50px] h-[3px] rounded-lg bg-gray-300 absolute bottom-[-7px] left-[-18px] rotate-[45deg]"></div>
					<a class="min-w-fit text-[0.8rem]" href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>
				<div class="w-[50px] h-[3px] rounded-lg bg-gray-300 absolute top-[-7px] left-[-18px] rotate-[-45deg]"></div>
			</div>';
		} else {
			echo '<div class="relative px-[20px]">
				<span class="min-w-fit text-[0.8rem] font-medium">' . esc_html( $crumb[0] ) . '</span>
			</div>';
		}


		// جدا کننده است
		// if ( sizeof( $breadcrumb ) !== $key + 1 ) {
		// 	echo $delimiter;
		// }
	}

	?>

	</div>

	<?php
}
