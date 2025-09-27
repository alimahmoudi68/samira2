<?php
    $sliders =  myprefix_get_option('customersSection');
?>
<div class="card-section">
    <div class="card-section-top mb-2 md:mb-6">
        <span class="card-section-title">نظرات مشتریان</span>
    </div>

    <div class="swiper-container slider-customer mb-3" dir="rtl">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <?php
                foreach($sliders as  $item){
            ?>

            <div class="swiper-slide p-1">
                <div class='card-customer'>
                    <div class='card-customer-content'>
                        <div class='customer-content-img'>
                            <Image class='customer-img' src='<?php echo $item['image'] ?>' width="64" height="64" />
                            <span class='customer-user-name'>
                                <?php echo $item['name'] ?>
                            </span>
                            <span class='customer-job'>
                                <?php echo $item['job'] ?>
                            </span>
                        </div>
                        <div class='customer-body'>
                            <span>
                                <?php echo $item['comment'] ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php   
                }
            ?>

        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination swiper-pagination-customer"></div>

        <!-- If we need navigation buttons -->
        <!-- <div class="swiper-button-prev swiper-button-prev-new"></div>
        <div class="swiper-button-next swiper-button-next-new"></div> -->

    </div>
</div>
<!--------------------------------- /Slider new -------------------------------------------------------->