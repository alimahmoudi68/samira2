<?php 
    $episodes = get_post_meta(get_the_ID() , 'episode_group' , true);
    $type =  get_post_meta( get_the_ID() , 'product_type' , true); 
    $regular_price = get_post_meta( get_the_ID(), '_regular_price', true);
    $formatted_regular_price = WC_price( $regular_price , array(
            'ex_tax_label'       => false,
            'currency'           => false,
    ));
    $sale_price  =  get_post_meta( get_the_ID(), '_sale_price', true);
    if($sale_price !== ''){
        $formatted_sale_price = WC_price( $sale_price , array(
            'ex_tax_label'       => false,
            'currency'           => false,
        ));
    }


?>
    <div
        class='card-product flex flex-col items-center h-full transition-all duration-300 rounded-lg bg-white-100 shadow-card relative'>
        <div class='w-full overflow-hidden card-image-container rounded-lg'>
            <a href="<?php the_permalink() ?>">
                <?php the_post_thumbnail('post'); ?>
            </a>
        </div>
        <!-- <div class='w-full h-[230px]'>
        </div> -->
        <div class='flex flex-col w-full mt-2 p-3'>
            <div class='flex items-center text-sm font-semibold text-primary-100'>
                <svg class='w-2 h-2 fill-primary-100 ml-1' viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="50" />
                </svg>
                <span>
                    <?php 
                        $status =  get_post_meta( get_the_ID() , 'product_status' , true);
                        if($status == 'soon'){
                            echo 'به زودی'; 
                        }else if($status == 'continue'){
                            echo 'در حال برگزاری'; 
                        }else if($status == 'finish'){
                            echo 'تکمیل ضبط'; 
                        }
                    ?>
                </span>
            </div>
            <div
                class='w-full h-[50px] flex items-start flex-grow text-[1.2rem] font-semibold text-textPrimary-100'>
                <a href="<?php the_permalink() ?>">
                <?php the_title(); ?>
                </a>
            </div>
            <?php
            $teacher_id =  get_post_meta( get_the_ID() , 'product_teacher' , true); 
            $teacher = new WP_Query(
                array(
                    'post_type' => 'tutor',
                    'posts_per_page' => 1 , 
                    'p' => $teacher_id , 
                )
            );
            if($teacher->have_posts()){
                while($teacher->have_posts()):
                $teacher->the_post();
            ?>
            <div class="flex items-center teacher-sec">
                <?php the_post_thumbnail('profile'); ?>
                <span class="text-sm font-light text-textPrimary-100">
                    <?php the_title(); ?>
                </span>
            </div>
            <?php
                endwhile; 
            }
            wp_reset_query();
        ?>
        </div>
        <div class='w-full flex justify-between items-end text-sm font-light h-[40px] p-3'>
            <div class='flex items-center gap-x-2'>
                <div class='flex justify-center items-center rounded-md bg-primary-50 text-textPrimary-100 p-1'>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} class="stroke-textPrimary-100 w-4 h-4 ml-1">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0 1 18 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0 1 18 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 0 1 6 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 10.875c0 .621-.504 1.125-1.125 1.125M18 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m-12 5.25v-5.25m0 5.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125m-12 0v-1.5c0-.621-.504-1.125-1.125-1.125M18 18.375v-5.25m0 5.25v-1.5c0-.621.504-1.125 1.125-1.125M18 13.125v1.5c0 .621.504 1.125 1.125 1.125M18 13.125c0-.621.504-1.125 1.125-1.125M6 13.125v1.5c0 .621-.504 1.125-1.125 1.125M6 13.125C6 12.504 5.496 12 4.875 12m-1.5 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M19.125 12h1.5m0 0c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h1.5m14.25 0h1.5" />
                    </svg>
                    <span class='text-[0.8rem]'>
                        <?php echo count($episodes) . " " . "جلسه"; ?>
                    </span>
                </div>    
                <div class='flex justify-center items-center rounded-md bg-primary-50 text-textPrimary-100 p-1'>
                    <svg class="w-4 h-4 ml-1" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M1.29921 7.10036C1.29921 8.47492 1.37342 9.55017 1.56095 10.394C1.74739 11.2329 2.04007 11.8164 2.45902 12.2353C2.87796 12.6543 3.4615 12.947 4.30041 13.1334C5.14419 13.3209 6.21945 13.3952 7.594 13.3952C8.96856 13.3952 10.0438 13.3209 10.8876 13.1334C11.7265 12.947 12.31 12.6543 12.729 12.2353C13.1479 11.8164 13.4406 11.2329 13.6271 10.394C13.8146 9.55017 13.8888 8.47492 13.8888 7.10036C13.8888 5.72581 13.8146 4.65055 13.6271 3.80677C13.4406 2.96786 13.1479 2.38432 12.729 1.96538C12.31 1.54643 11.7265 1.25375 10.8876 1.06731C10.0438 0.879784 8.96856 0.805572 7.594 0.805572C6.21945 0.805572 5.14419 0.879784 4.30041 1.06731C3.4615 1.25375 2.87796 1.54643 2.45902 1.96538C2.04007 2.38432 1.74739 2.96786 1.56095 3.80677C1.37342 4.65055 1.29921 5.72581 1.29921 7.10036Z"
                            stroke="currentColor" strokeWidth="0.858919" strokeLinecap="round" strokeLinejoin="round">
                        </path>
                        <path
                            d="M7.59399 3.73825C7.59399 3.73825 7.59399 5.97967 7.59399 6.54002C7.59399 7.10038 7.59399 7.10038 8.15435 7.10038C8.71471 7.10038 10.9561 7.10038 10.9561 7.10038"
                            stroke="currentColor" strokeWidth="0.858919" strokeLinecap="round" strokeLinejoin="round">
                        </path>
                    </svg>
                    <span class='text-[0.8rem]'>
                        <?php echo get_total_time_course($episodes); ?>
                    </span>
                </div>
            </div>
            <div class='flex flex-col justify-center font-medium text-textPrimary-100'>
                <?php 
                if($type !== 'free'){
                ?>
                <?php if($sale_price !== '') {?> 
                <span class='line-through text-red-500'>
                    <?php echo $formatted_sale_price; ?>
                </span>
                <?php } ?>
                <span class='text-textPrimary-100'>
                    <?php echo $formatted_regular_price; ?>
                </span>
                <?php  }else{ ?>
                <span>رایگان</span>
                <?php } ?>
            </div>
        </div>
    </div>

