let screenWidt = window.innerWidth;
window.addEventListener('resize' , ()=>{
  screenWidt =  window.innerWidth;
  if(screenWidt > 768){
    let mstSidebarBg = document.querySelector(".mst-sidebar-bg");
    mstSidebarBg.style.display = "none";
  }
});
//-----------------------init loading -------------
let preLoader = document.querySelector('.preloader');
document.addEventListener('DOMContentLoaded', ()=>{
  preLoader.style.display='none';
});
// ------------------------- farsi digit -----------
function toPersian(number){
  return number.toLocaleString('fa');
}


// --------- show/hide master sidebar -----------------
let btnHamberger = document.querySelector('.btn-hamberger');
let mstSidebar = document.querySelector(".mst-sidebar");
let mstSidebarBg = document.querySelector(".mst-sidebar-bg");

btnHamberger.addEventListener('click' , function(){
  mstSidebarBg.style.display = "block";
  setTimeout(()=>{
    mstSidebar.classList.remove('translate-x-full');
    mstSidebar.classList.add('translate-x-0');
  } , 10);
})

// --------- show/hide cart sidebar -----------------
let btnCart = document.querySelector('.btn-cart');
let mstCart = document.querySelector(".mst-cart");
let mstCartBg = document.querySelector(".mst-cart-bg");

btnCart.addEventListener('click' , function(){
  mstCartBg.style.display = "block";
  setTimeout(()=>{
    mstCart.classList.add('translate-x-0');
    mstCart.classList.remove('translate-x-[-100%]');
  } , 100);
})


// ---  When the user clicks anywhere outside of the master sidebar it close ------
window.onclick = function(e) {

  if (e.target == mstSidebarBg) {
    mstSidebar.classList.add('translate-x-full');
    mstCart.classList.remove('translate-x-0');

    setTimeout(()=>{
      mstSidebarBg.style.display = "none";
    } , 200);

  }

  if (e.target == mstCartBg) {
    mstCart.classList.remove('translate-x-0');
    mstCart.classList.add('translate-x-[-100%]');

    setTimeout(()=>{
      mstCartBg.style.display = "none";
    } , 200);

  }

  // if (e.target == mstSidebarBgSort) {
  //     mstSidebarSort.classList.add('translate-y-full');
  
  //     setTimeout(()=>{
  //       mstSidebarBgSort.style.display = "none";
  //     } , 200);
      
  // }

  
}
let mstSidebatCatTxt =  document.querySelector('.mst-sidebat-cat-txt');
let mstSidebatCat =  document.querySelector('.mst-sidebat-cat');
let mstSidebarSvg = mstSidebatCatTxt.querySelector('svg');
 
mstSidebatCatTxt.addEventListener('click' , function(){
  if (mstSidebatCat.style.maxHeight){
    mstSidebatCat.style.maxHeight = null;
    mstSidebarSvg.innerHTML= '<path strokeLinecap="round" strokeLinejoin="round" d="M12 4v16m8-8H4" />';
  } else {
    mstSidebatCat.style.maxHeight = mstSidebatCat.scrollHeight + "px";
    mstSidebarSvg.innerHTML= '<path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />';
  } 
});
// ------- profile menu and shopping cart -------
let header= document.querySelector('.header');
let btnProfileMenu = header.querySelector('.profile-header-container');
let ProfileMenu = header.querySelector('.profile-menu');
let bgProfileMenu = document.querySelector('.bg-profile-menu');

// if user login karde

if(ProfileMenu){
  document.addEventListener('click', function( event ) {
    if(isClick (btnProfileMenu , event)){
      ProfileMenu.classList.toggle('hidden');
      bgProfileMenu.classList.toggle("hidden");
    }else{
      ProfileMenu.classList.add('hidden');
      bgProfileMenu.classList.add("hidden");
    }
  });
}
function isClick (el , evt){
  const flyoutElement = el;
      let targetElement = evt.target; // clicked element
      do {
          if (targetElement == flyoutElement) {
              // This is a click inside. Do nothing, just return.
              return true;
          }
          // Go up the DOM
          targetElement = targetElement.parentNode;
      } while (targetElement);
    
      // This is a click outside.
      return false;
}



// ---------- map ---------
const neshanMap = new nmp_mapboxgl.Map({
  mapType: nmp_mapboxgl.Map.mapTypes.neshanVectorNight,
  container: "map",
  zoom: 13,
  pitch: 0,
  center: [loc.long , loc.lat],
  minZoom: 2,
  maxZoom: 21,
  trackResize: true,
  mapKey: "web.1b5c3fac78984a74a8c106db0265147e",
  poi: false,
  traffic: false,
  mapTypeControllerOptions: {
      show: false,
      position: 'bottom-left'
  }
});

// ساخت یک Popup با متن دلخواه
var popup = new nmp_mapboxgl.Popup({ offset: [0, -40] , closeButton: false}) // حذف دکمه بستن }) // تنظیم فاصله برای ظاهر بهتر
.setHTML(`<span style='color:black'>${loc.title}</span>`);

// اضافه کردن Popup به مارکر
var marker = new nmp_mapboxgl.Marker({ color: "purple" })
    .setLngLat([loc.long , loc.lat])
    .setPopup(popup) // اتصال Popup به مارکر
    .addTo(neshanMap);

// نمایش Popup به صورت پیش‌فرض (اختیاری)
popup.addTo(neshanMap);