const notyf = new Notyf({
  duration: 3000,
  position: {
    x: "left",
    y: "top",
  },
});
//---ajax add to cart---
jQuery(document).ready(function ($) {
  $(".addToCard").on("click", function (e) {
    e.preventDefault();
    $thisbutton = $(this);
    let width = $thisbutton[0].offsetWidth;
    let height = $thisbutton[0].offsetHeight;
    $thisbutton[0].style.width = `${width}px`;
    $thisbutton[0].style.height = `${height}px`;

    $thisbutton[0].childNodes[1].classList.add("hidden");
    $thisbutton[0].classList.add("is-loading");

    product_qty = 1;

    product_id = $thisbutton[0].getAttribute("data-set");
    //variation_id = $form.find('input[name=variation_id]').val() || 0;
    var data = {
      action: "ql_woocommerce_ajax_add_to_cart",
      product_id,
      product_sku: "",
      quantity: 1,
    };
    $.ajax({
      type: "post",
      url: wc_add_to_cart_params.ajax_url,
      data: data,
      beforeSend: function (response) {
        $thisbutton.removeClass("added").addClass("loading");
      },
      complete: function (response) {
        $thisbutton.addClass("added").removeClass("loading");
      },
      success: function (response) {
        $thisbutton[0].childNodes[1].classList.remove("hidden");
        $thisbutton[0].classList.remove("is-loading");
        //$thisbutton[0].style.width  = 'unset';
        $thisbutton[0].style.height = "unset";

        if (response.error & response.product_url) {
          window.location = response.product_url;
          notyf.error("متاسفانه مشکلی رخ داد مجددا بعدا تلاش کنید");
          return;
        } else {
          $(document.body).trigger("added_to_cart", [
            response.fragments,
            response.cart_hash,
            $thisbutton,
          ]);

          notyf.success("این دوره با موفقیت به سبد خرید اضافه شد");
        }
      },
    });
  });
});
//------ FAQ -------
(function () {
  let coll = document.getElementsByClassName("btn-collapse");
  let i;

  for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function () {
      let content = this.nextElementSibling;
      this.querySelector("svg").remove();
      if (content.style.maxHeight) {
        content.style.maxHeight = null;
        this.innerHTML +=
          "<svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 sm:h-6 sm:w-6 stroke-gray-600 md:group-hover:stroke-primary-100 dark:stroke-white-100' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'><path stroke-linecap='round' stroke-linejoin='round' d='M12 4v16m8-8H4' /></svg>";
      } else {
        content.style.maxHeight = content.scrollHeight + "px";
        this.innerHTML +=
          "<svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 sm:h-6 sm:w-6 stroke-gray-600 md:group-hover:stroke-primary-100 dark:stroke-white-100' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'><path stroke-linecap='round' stroke-linejoin='round' d='M20 12H4' /></svg>";
      }
    });
  }
})();

//------ read more/less for article content ------
document.addEventListener("DOMContentLoaded", function () {
  const contentWrapper = document.querySelector(".content-wrapper");
  if (contentWrapper) {
    const shortContent = contentWrapper.querySelector(".short-content");
    const fullContent = contentWrapper.querySelector(".full-content");

    if (shortContent && fullContent) {
      const shortBtn = shortContent.querySelector(".btn-read-more");
      const fullBtn = fullContent.querySelector(".btn-read-more");

      // Toggle function
      function toggleContent(e) {
        e.preventDefault();

        if (
          shortContent.style.display === "none" ||
          shortContent.style.display === ""
        ) {
          // Currently showing full content, switch to short
          shortContent.style.display = "inline";
          fullContent.style.display = "none";
        } else {
          // Currently showing short content, switch to full
          shortContent.style.display = "none";
          fullContent.style.display = "inline";
        }
      }

      // Add click handlers
      if (shortBtn) {
        shortBtn.addEventListener("click", toggleContent);
      }
      if (fullBtn) {
        fullBtn.addEventListener("click", toggleContent);
      }
    }
  }
});

//------ episodes -------
let videoEpisode = document.querySelector(".video-episode"); // المان <video>
let btnEpisodes = document.querySelectorAll(".btn-episodes"); // انتخاب دکمه‌ها
let loadingIndicator = document.querySelector(".loading-indicator"); // انتخاب المان لودینگ

for (let i = 0; i < btnEpisodes.length; i++) {
  btnEpisodes[i].addEventListener("click", function (event) {
    videoEpisode.parentElement.classList.remove("hidden");

    let videoUrl = this.getAttribute("data-video"); // گرفتن لینک ویدیو

    // حذف کلاس از همه دکمه‌ها
    btnEpisodes.forEach((btn) =>
      btn.classList.remove("border", "border-primary-100")
    );

    // اضافه کردن کلاس به دکمه کلیک‌شده
    this.classList.add("border", "border-primary-100");

    if (videoEpisode) {
      // نمایش لودینگ
      loadingIndicator.style.display = "block";

      // تغییر لینک ویدیو
      videoEpisode.setAttribute("src", videoUrl);

      // پخش ویدیو زمانی که آماده شد
      videoEpisode.addEventListener("canplay", function () {
        loadingIndicator.style.display = "none"; // پنهان کردن لودینگ
        videoEpisode.play(); // پخش ویدیو
      });

      // اگر ویدیو در حال بارگذاری باشد
      videoEpisode.addEventListener("waiting", function () {
        loadingIndicator.style.display = "block"; // نمایش لودینگ
      });
    }
  });
}

// ---- itroducing video ------
const videoContainer = document.querySelector(".video-container");
const videoIntroduce = document.querySelector(".video-introduce");
let btnShowVideo = document.querySelectorAll(".btn-show-video");
let loadingIndicatorIntroduce = document.querySelector(
  ".loading-indicator-introduce"
);

// توابع برای مدیریت event listeners
let canplayHandler = null;
let waitingHandler = null;

function stopVideo() {
  if (videoIntroduce) {
    videoIntroduce.pause();
    videoIntroduce.currentTime = 0;
    // حذف src برای توقف کامل ویدیو
    videoIntroduce.src = "";
    videoIntroduce.load(); // بارگذاری مجدد برای توقف کامل

    // حذف event listeners قدیمی
    if (canplayHandler) {
      videoIntroduce.removeEventListener("canplay", canplayHandler);
      canplayHandler = null;
    }
    if (waitingHandler) {
      videoIntroduce.removeEventListener("waiting", waitingHandler);
      waitingHandler = null;
    }
  }
}

for (let i = 0; i < btnShowVideo.length; i++) {
  btnShowVideo[i].addEventListener("click", function (event) {
    document.body.style.overflow = "hidden";
    let videoUrl = this.getAttribute("data-video");

    if (videoIntroduce && videoContainer) {
      // توقف ویدیو قبلی در صورت وجود
      stopVideo();

      videoContainer.classList.remove("hidden");

      // نمایش لودینگ
      if (loadingIndicatorIntroduce) {
        loadingIndicatorIntroduce.style.display = "block";
      }

      // تغییر لینک ویدیو
      videoIntroduce.setAttribute("src", videoUrl);

      // تعریف handlers جدید
      canplayHandler = function () {
        if (loadingIndicatorIntroduce) {
          loadingIndicatorIntroduce.style.display = "none";
        }
        videoIntroduce.play();
      };

      waitingHandler = function () {
        if (loadingIndicatorIntroduce) {
          loadingIndicatorIntroduce.style.display = "block";
        }
      };

      // پخش ویدیو زمانی که آماده شد
      videoIntroduce.addEventListener("canplay", canplayHandler);

      // اگر ویدیو در حال بارگذاری باشد
      videoIntroduce.addEventListener("waiting", waitingHandler);
    }
  });
}

if (videoIntroduce) {
  videoIntroduce.addEventListener("click", function (e) {
    e.stopPropagation();
  });
}

if (videoContainer) {
  videoContainer.addEventListener("click", function () {
    videoContainer.classList.add("hidden");
    stopVideo();
    document.body.style.overflow = "auto";
  });
}
