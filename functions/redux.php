<?php
if ( ! class_exists( 'Redux' ) ) {
    return;
}

$opt_name = "my_opt"; // اسم گزینه‌های تنظیمات (در دیتابیس ذخیره می‌شود)

$args = array(
    'opt_name'             => $opt_name,
    'display_name'         => 'تنظیمات قالب',
    'display_version'      => '1.0.0',
    'menu_type'            => 'menu',
    'allow_sub_menu'       => true,
    'menu_title'           => 'تنظیمات قالب',
    'page_title'           => 'تنظیمات قالب',
    'dev_mode'             => false,
    'customizer'           => true,
);

Redux::setArgs( $opt_name, $args );

// تعریف گزینه‌های تنظیمات
Redux::setSection( $opt_name, array(
    'title'  => 'تنظیمات عمومی',
    'id'     => 'general',
    'desc'   => 'تنظیمات عمومی قالب.',
    'icon'   => 'el el-home',
    'fields' => array(
        array(
            'id'       => 'opt-logo',
            'type'     => 'media',
            'title'    => 'لوگو',
            'desc'     => 'آپلود لوگوی سایت',
        ),
        array(
            'id'        => 'opt-color-rgba',
            'type'      => 'color_rgba',
            'title'     => 'رنگ اصلی',
            //'subtitle'  => 'Set color and alpha channel',
            //'desc'      => 'The caption of this button may be changed to whatever you like!',

            // See Notes below about these lines.
            //'output'    => array('background-color' => '.site-header'),
            //'compiler'  => array('color' => '.site-header, .site-footer', 'background-color' => '.nav-bar'),
            'default'   => array(
                'color'     => '#fdfdfd',
                'alpha'     => 1
            ),
        ),
        array(
            'id'       => 'opt-about-video',
            'title'    => 'ویدیوی درباره ما',
            'desc'     => 'آپلود ویدیوی درباره ما',
            'type' => 'text',
        ),
        array(
            'id'       => 'opt-cover-about-video',
            'type'     => 'media',
            'title'    => 'کاور ویدیوی درباره ما',
            'desc'     => 'آپلود کاور ویدیوی درباره ما',
        ),
        array(
            'id'       => 'opt-create-table',
            'type'     => 'checkbox',
            'title'    => 'ساخت جداول در دیتابیس',
            'desc'     => 'با فعال کردن این گزینه، جداول در صورت نبود ساخته می شوند.',
            'default'  => '1', // مقدار پیش‌فرض: غیرفعال
        ),
    ),
));


Redux::setSection( $opt_name, array(
    'title'            => 'مشخصات سالن',
    'id'               => 'salon',
    'customizer_width' => '400px',
    'icon'             => 'el el-map-marker' ,
    'fields'           => array(
        array(
            'id'       => 'opt-about',
            'type'     => 'textarea',
            'title'    => 'درباره سالن',
            'default'  => '',
        ),
        array(
            'title'    => 'شماره ثابت',
            'id' => 'opt-office-phone',
            'type' => 'text',
        ),
        array(
            'title'    => 'شماره همراه',
            'id' => 'opt-phone',
            'type' => 'text',
        ),
        array(
            'title'    => 'آیدی تلگرام',
            'id' => 'opt-telegram',
            'type' => 'text',
        ),
        array(
            'title'    => 'آیدی اینستاگرام',
            'id' => 'opt-insta',
            'type' => 'text',
        ),
        array(
            'id'       => 'opt-address',
            'type'     => 'textarea',
            'title'    => 'آدرس',
            //'subtitle' => __( 'Subtitle', 'redux-framework-demo' ),
            //'desc'     => __( 'This is the description field, again good for additional info.', 'redux-framework-demo' ),
            'default'  => '',
        ),
        array(
            'title'    => 'طول جفرافیایی',
            'id' => 'opt-long',
            'type' => 'text',
        ),
        array(
            'title'    => 'عرض جغرافیانی',
            'id' => 'opt-lat',
            'type' => 'text',
        ),

    )
) );


Redux::setSection( $opt_name, array(
    'title'            => 'پنل پیامک',
    'id'               => 'sms',
    'customizer_width' => '400px',
    'icon'             => 'el el-comment' ,
    'fields'           => array(
        array(
            'title'    => 'نام کاربری پنل پیامک',
            'id' => 'opt-sms-username',
            'type' => 'text',
        ),
        array(
            'title'    => 'رمز عبور پنل پیامک',
            'id' => 'opt-sms-password',
            'type' => 'text',
        ),
        array(
            'title'    => 'شماره ارسالی پنل پیامک',
            'id' => 'opt-sms-number-output',
            'type' => 'text',
        ),
        array(
            'title'    => 'شماره پترن ارسال کد',
            'id' => 'opt-sms-pattern-otp',
            'type' => 'text',
        ),
        array(
            'title'    => 'شماره پترن خوش آمد گویی ثبت نام',
            'id' => 'opt-sms-pattern-register',
            'type' => 'text',
        ),
        array(
            'title'    => 'شماره پترن پیامک بعد از خرید ',
            'id' => 'opt-sms-pattern-buy',
            'type' => 'text',
        ),
    
    )
) );
