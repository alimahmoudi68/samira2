<?php
header("Content-type: text/css; charset: UTF-8");

global $my_opt; // تنظیمات Redux
$main_color = isset( $theme_options['opt-color-rgba'] ) ? $theme_options['opt-color-rgba'] : array( 'color' => '#000000', 'alpha' => 1 );

?>
:root {
    --colorPrimaryLight: <?php echo esc_attr( $main_color['color'] ); ?>;
}
