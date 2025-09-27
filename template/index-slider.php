<?php
    $sliders =  myprefix_get_option('slidersIndex');
?>
<div class="swiper-container pslider">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->

                <?php
                    foreach($sliders as  $item){
                ?>
                    <div class="swiper-slide">
                        <a href="<?php echo @$item['link'] ?>">
                            <img src="<?php echo $item['image'] ?>"  width="1024" height="455">
                        </a>    
                    </div>
                <?php   
                    }
                ?>
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>
        
            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        
        </div>