<?php get_header() ?>

<main>

    <div class="container" id="main-container">

        <div class="row">

            <div class="col-12 col-md-3 m-0 p-0 sb">
                <div class="archive-sidebar">
                    <div class='d-flex justify-content-between'>
                        <div class="card-detail d-flex flex-col justify-content-center align-items-center p-5 ml-2">
                            <i class="fa fa-clock mb-2"></i>
                            <span class="key">
                                زمان ویدیو:
                            </span>
                            <span class="value">
                                <?php echo  get_post_meta( get_the_ID() , 'tv_time' , true); ?>
                            </span>
                        </div>
                        <div class="card-detail d-flex flex-col justify-content-center align-items-center p-5">
                            <i class="fa fa-folder-open mb-2"></i>
                            <span class="key">
                                دسته‌بندی:
                            </span>
                            <span class="value">
                                <?php 
                                    $getslugid = wp_get_post_terms( $post->ID, 'tv-cat' );
                                    foreach( $getslugid as $thisslug ) {
                                        echo $thisslug->name . '';
                                    }
                                ?>
                            </span>    
                        </div>
                    </div>
                    <div class="card-detail card-teacher d-flex flex-col justify-content-center align-items-center p-5 mt-2">
                    <?php
                        $teacher_id =  get_post_meta( get_the_ID() , 'tv_teacher' , true); 
                        $teacher = new WP_Query(
                            array(
                                'post_type' => 'teacher',
                                'posts_per_page' => 1 , 
                                'p' => $teacher_id , 
                            )
                        );
                        if($teacher->have_posts()){
                            while($teacher->have_posts()):
                            $teacher->the_post();
                        ?>
                        <?php the_post_thumbnail('teacher'); ?>
                        <span class="teacher-name">
                            <?php the_title(); ?>
                        </span>
                        <span class="teacher-txt">
                            مدرس دوره
                        </span>
                        <span class="teacher-about">
                        <?php  the_excerpt() ?>
                        </span>
                        <?php
                            endwhile; 
                        }
                        wp_reset_query();
                    ?>

                    </div>
                </div>
            </div>

            <div class="col-12 col-md-9 m-0 p-0">
                <div class="card-body p-5">
                    <h1 class="title-tv">
                        <?php the_title(); ?>
                    </h1>
                    <?php the_content(); ?>

                    <?php the_time('d F Y'); ?>

                </div>


                <div class="card-body p-5 mt-2 woocommerce">
                    <?php
                            if(comments_open() || get_comments_number()) :
                            comments_template();
                            endif;
                    ?>
                </div>


            </div>




        </div>

    </div>

</main>

<?php get_footer() ?>