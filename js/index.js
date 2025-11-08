//var indexTypewriter = document.getElementById('index-typewriter');

// var typewriter = new Typewriter(indexTypewriter, {
//   loop: true,
//   delay: 75,
// });

// typewriter
//   .pauseFor(2500)
//   .typeString('مستقل')
//   .pauseFor(3000)
//   .deleteChars(10)
//   .typeString('هنرمند')
//   .pauseFor(3000)
//   .deleteChars(10)
//   .typeString('کارآفرین')
//   .pauseFor(3000)
//   .deleteChars(10)
//   .start();

//--------- scoll to new courses -------
// var scrollDiv = document.getElementById("new-courses").offsetTop;
// let btnToNewCourses = document.querySelector('#btn-to-new-courses');
// btnToNewCourses.addEventListener('click' , function(){
//   window.scrollTo({ top: scrollDiv-100, behavior: 'smooth'});
// });


// ------- swiper index portfolio --------------
let sliderPortfolio = new Swiper ('.slider-portfolio', {
  // Optional parameters
  //loop: true,                        
  slidesPerView: 1,
  spaceBetween: 5,
  rtl : true ,
  direction: 'horizontal',
  loop: true,

  pagination: {
    el: '.swiper-pagination',
  },

  autoplay: {
    delay: 3000,
    disableOnInteraction: true,
    pauseOnMouseEnter : true
  },

  //cssMode: true,
  breakpoints: {
    720: {
      slidesPerView: 3,
      spaceBetween: 20,
    },
    960: {
      slidesPerView: 4,
      spaceBetween: 20,
    }
  },

});
const portfolioDetailContainer = document.querySelector('.portfolio-detail-container');
const portfolioDetailVideoContainer = document.querySelector('.portfolio-detail-video-container');
const portfolioDetailImgContainer = document.querySelector('.portfolio-detail-img-container');
const portfolioDetailVideo = document.querySelector('.portfolio-detail-video');
let btnShowPortfolioDetail = document.querySelectorAll('.btn-show-portfolio-detail');
let loadingPortfolioDetail = document.querySelector('.loading-portfolio-detail'); // انتخاب المان لودینگ


for (let i = 0; i < btnShowPortfolioDetail.length; i++) {

  btnShowPortfolioDetail[i].addEventListener("click", function(event) {
    let videoUrl = this.getAttribute('data-video'); // گرفتن لینک ویدیو
    let imgUrl = this.getAttribute('data-img');  // گرفتن لینک تصویر
    document.body.style.overflow = 'hidden';

    if (portfolioDetailContainer) {

      // نمایش جزئیات پورتفولیو
      portfolioDetailContainer.classList.remove('hidden');

      if (videoUrl) {
        portfolioDetailVideoContainer.style.display = 'block';

        // نمایش ویدیو و پنهان کردن تصویر
        portfolioDetailImgContainer.style.display = 'none'; // مخفی کردن عکس

        // نمایش لودینگ
        loadingPortfolioDetail.style.display = 'block';

        // تغییر لینک ویدیو
        portfolioDetailVideo.setAttribute('src', videoUrl);

        // پخش ویدیو زمانی که آماده شد
        portfolioDetailVideo.addEventListener('canplay', function() {
          loadingPortfolioDetail.style.display = 'none'; // پنهان کردن لودینگ
        });

        // اگر ویدیو در حال بارگذاری باشد
        portfolioDetailVideo.addEventListener('waiting', function() {
          loadingPortfolioDetail.style.display = 'block'; // نمایش لودینگ
        });

      } else {
        // نمایش تصویر و پنهان کردن ویدیو
        document.querySelector('.portfolio-detail-container img').setAttribute('src', imgUrl);
        portfolioDetailImgContainer.style.display = 'block'; // نمایش تصویر
        portfolioDetailVideoContainer.style.display = 'none'; // مخفی کردن ویدیو
        loadingPortfolioDetail.style.display = 'none';
      }
    }
  });
}

portfolioDetailVideo.addEventListener('click', function(e) {
  e.stopPropagation();
});

portfolioDetailContainer.addEventListener('click', function() {
  portfolioDetailContainer.classList.add('hidden');
  portfolioDetailVideo.pause(); // متوقف کردن پخش ویدیو
  portfolioDetailVideo.currentTime = 0; // برگرداندن ویدیو به ابتدا (اختیاری)
  document.body.style.overflow = 'auto';
});

// Close button functionality
const closeButton = document.querySelector('.portfolio-detail-container svg');
if (closeButton) {
  closeButton.addEventListener('click', function(e) {
    e.stopPropagation(); // جلوگیری از اجرای event container
    portfolioDetailContainer.classList.add('hidden');
    portfolioDetailVideo.pause();
    portfolioDetailVideo.currentTime = 0;
  });
  document.body.style.overflow = 'auto';
}



// ------- swiper index products --------------
let sliderProducts = new Swiper ('.slider-prducts', {
  // Optional parameters
  //loop: true,                        
  slidesPerView: 1,
  spaceBetween: 5,
  rtl : true ,
  direction: 'horizontal',
  loop: true,

  pagination: {
    el: '.swiper-pagination',
  },

  autoplay: {
    delay: 3000,
    disableOnInteraction: true,
    pauseOnMouseEnter : true
  },

  //cssMode: true,
  breakpoints: {
    720: {
      slidesPerView: 3,
      spaceBetween: 20,
    },
    960: {
      slidesPerView: 4,
      spaceBetween: 20,
    }
  },

})




// ------- swiper index comments --------------
let mySwiper4 = new Swiper ('.slider-comments', {
  // Optional parameters
  //loop: true,                        
  slidesPerView: 1,
  spaceBetween: 5,
  rtl : true ,
  direction: 'horizontal',
  loop: true,

  pagination: {
    el: '.swiper-pagination',
  },

  autoplay: {
    delay: 3000,
    disableOnInteraction: true,
    pauseOnMouseEnter : true
  },

  //cssMode: true,
  breakpoints: {
    720: {
      slidesPerView: 3,
      spaceBetween: 20,
    },
    960: {
      slidesPerView: 4,
      spaceBetween: 20,
    }
  },

})

const videoReviewContainer = document.querySelector('.video-review-container');
const videoReview = document.querySelector('.video-review');
let btnShowReviews = document.querySelectorAll('.btn-show-review');
let loadingIndicator = document.querySelector('.loading-indicator'); // انتخاب المان لودینگ


for (let i = 0; i < btnShowReviews.length; i++) {

  btnShowReviews[i].addEventListener("click", function(event) {
    let videoUrl = this.getAttribute('data-video'); // گرفتن لینک ویدیو

    if (videoReview) {

      videoReviewContainer.classList.remove('hidden');

      // نمایش لودینگ
      loadingIndicator.style.display = 'block';

      // تغییر لینک ویدیو
      videoReview.setAttribute('src', videoUrl);

      // پخش ویدیو زمانی که آماده شد
      videoReview.addEventListener('canplay', function() {
        loadingIndicator.style.display = 'none'; // پنهان کردن لودینگ
        //videoReview.play(); // پخش ویدیو
      });

      // اگر ویدیو در حال بارگذاری باشد
      videoReview.addEventListener('waiting', function() {
        loadingIndicator.style.display = 'block'; // نمایش لودینگ
      });
    }
  });
}


videoReview.addEventListener('click' , function(e){
  e.stopPropagation();
})

videoReviewContainer.addEventListener('click' , function(){
  videoReviewContainer.classList.add('hidden');
  videoReview.pause(); // متوقف کردن پخش ویدیو
  videoReview.currentTime = 0; // برگرداندن ویدیو به ابتدا (اختیاری)
})

//------ FAQ -------
let coll = document.getElementsByClassName("btn-collapse");

for (let i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    let content = this.nextElementSibling;
    let icon = this.querySelector("svg"); // پیدا کردن svg مربوطه

    if (content.style.maxHeight) {
        content.style.maxHeight = null;
        icon.style.transform = "rotate(0deg)"; // بازگشت به حالت اولیه
    } else {
        content.style.maxHeight = content.scrollHeight + "px";
        icon.style.transform = "rotate(45deg)"; // چرخش svg
    }
  });
}
