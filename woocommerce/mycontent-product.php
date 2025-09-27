<?php 
    $time = get_post_meta( get_the_ID() , 'product_time' , true);
    $type =  get_post_meta( get_the_ID() , 'product_type' , true); 
    $regular_price = get_post_meta( get_the_ID(), '_regular_price', true);
    $formatted_regular_price = WC_price( $regular_price , array(
            'ex_tax_label'       => false,
            'currency'           => false,
    ));
?>
<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 my-6">
    <div
        class='card-product flex flex-col items-center h-full bg-white-100 transition-all duration-300 rounded-md border-none p-2 mx-1 dark:bg-dark-50 relative'>
        <div class='w-11/12 overflow-hidden card-image-container mt-[-30px]'>
            <a href="<?php the_permalink() ?>">
                <?php the_post_thumbnail('post'); ?>
            </a>
        </div>
        <!-- <div class='w-full h-[230px]'>
        </div> -->
        <div class='flex flex-col w-full mt-2'>
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
                class='w-full h-[50px] flex items-start flex-grow text-[1.2rem] font-semibold text-slate-500 dark:text-textPrimary-100'>
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
                <span class="text-sm font-extralight text-gray-5=400">
                    <?php the_title(); ?>
                </span>
            </div>
            <?php
                endwhile; 
            }
            wp_reset_query();
        ?>
        </div>
        <div class='w-full flex justify-between items-end text-sm font-light h-[40px]'>
            <div class='flex justify-center items rounded-md bg-slate-200 dark:bg-sky-900 dark:text-textPrimary-100 p-1'>
                <svg class="m w-4 h-4 ml-1" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M1.29921 7.10036C1.29921 8.47492 1.37342 9.55017 1.56095 10.394C1.74739 11.2329 2.04007 11.8164 2.45902 12.2353C2.87796 12.6543 3.4615 12.947 4.30041 13.1334C5.14419 13.3209 6.21945 13.3952 7.594 13.3952C8.96856 13.3952 10.0438 13.3209 10.8876 13.1334C11.7265 12.947 12.31 12.6543 12.729 12.2353C13.1479 11.8164 13.4406 11.2329 13.6271 10.394C13.8146 9.55017 13.8888 8.47492 13.8888 7.10036C13.8888 5.72581 13.8146 4.65055 13.6271 3.80677C13.4406 2.96786 13.1479 2.38432 12.729 1.96538C12.31 1.54643 11.7265 1.25375 10.8876 1.06731C10.0438 0.879784 8.96856 0.805572 7.594 0.805572C6.21945 0.805572 5.14419 0.879784 4.30041 1.06731C3.4615 1.25375 2.87796 1.54643 2.45902 1.96538C2.04007 2.38432 1.74739 2.96786 1.56095 3.80677C1.37342 4.65055 1.29921 5.72581 1.29921 7.10036Z"
                        stroke="currentColor" strokeWidth="0.858919" strokeLinecap="round" strokeLinejoin="round">
                    </path>
                    <path
                        d="M7.59399 3.73825C7.59399 3.73825 7.59399 5.97967 7.59399 6.54002C7.59399 7.10038 7.59399 7.10038 8.15435 7.10038C8.71471 7.10038 10.9561 7.10038 10.9561 7.10038"
                        stroke="currentColor" strokeWidth="0.858919" strokeLinecap="round" strokeLinejoin="round">
                    </path>
                </svg>
                <span>
                    <?php echo $time; ?>
                </span>
            </div>
            <div class='font-medium dark:text-textPrimary-100'>
                <?php 
                if($type !== 'free'){
                ?>
                <span>
                    <?php echo $formatted_regular_price; ?>
                </span>
                <?php  }else{ ?>
                <span>رایگان</span>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
