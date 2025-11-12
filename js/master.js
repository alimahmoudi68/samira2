let screenWidt = window.innerWidth;
window.addEventListener('resize' , ()=>{
  screenWidt =  window.innerWidth;
  if(screenWidt > 768){
    // let mstSidebarBg = document.querySelector(".mst-sidebar-bg");
    // mstSidebarBg.style.display = "none";
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
let mstSidebar = document.querySelector(".mst-sidebar");
let mstSidebarBg = document.querySelector(".mst-sidebar-bg");


// --------- show/hide cart sidebar -----------------
let btnCart = document.querySelector('.btn-cart');
let mstCart = document.querySelector(".mst-cart");
let mstCartBg = document.querySelector(".mst-cart-bg");

btnCart.addEventListener('click' , function(){
  mstCartBg.style.display = "block";
  setTimeout(()=>{
    mstCart.classList.add('translate-x-0');
    mstCart.classList.remove('-translate-x-full');
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
    mstCart.classList.add('-translate-x-full');

    setTimeout(()=>{
      mstCartBg.style.display = "none";
    } , 200);

  }

  
}

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



// --------- WordPress 3-Level Mega Menu Functionality ---------
document.addEventListener('DOMContentLoaded', function() {
    let megaMenu = document.querySelector('.mega-menu');
    let megaMenuBg = document.querySelector('.mega-menu-bg');
    let megaCategoryItems = document.querySelectorAll('.mega-category-item');
    let megaSubcategoryContents = document.querySelectorAll('.mega-subcategory-content');
    let megaMenuGroup = document.querySelector('.group');

    // Show mega menu on hover
    if (megaMenuGroup && megaMenu) {
        megaMenuGroup.addEventListener('mouseenter', function() {
            megaMenu.classList.remove('hidden');
            megaMenu.classList.add('show');
            if (megaMenuBg) {
                megaMenuBg.classList.remove('hidden');
            }
        });

        megaMenuGroup.addEventListener('mouseleave', function() {
            megaMenu.classList.add('hidden');
            megaMenu.classList.remove('show');
            if (megaMenuBg) {
                megaMenuBg.classList.add('hidden');
            }
            
            // Reset active states
            megaCategoryItems.forEach(item => item.classList.remove('active'));
            megaSubcategoryContents.forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('show');
            });
        });

        // Also handle hover on the mega menu itself
        if (megaMenu) {
            megaMenu.addEventListener('mouseenter', function() {
                megaMenu.classList.remove('hidden');
                megaMenu.classList.add('show');
                if (megaMenuBg) {
                    megaMenuBg.classList.remove('hidden');
                }
            });

            megaMenu.addEventListener('mouseleave', function() {
                megaMenu.classList.add('hidden');
                megaMenu.classList.remove('show');
                if (megaMenuBg) {
                    megaMenuBg.classList.add('hidden');
                }
                
                // Reset active states
                megaCategoryItems.forEach(item => item.classList.remove('active'));
                megaSubcategoryContents.forEach(content => {
                    content.classList.add('hidden');
                    content.classList.remove('show');
                });
            });
        }
    }

    // Close mega menu when clicking on background
    if (megaMenuBg) {
        megaMenuBg.addEventListener('click', function() {
            megaMenu.classList.add('hidden');
            megaMenu.classList.remove('show');
            megaMenuBg.classList.add('hidden');
            
            // Reset active states
            megaCategoryItems.forEach(item => item.classList.remove('active'));
            megaSubcategoryContents.forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('show');
            });
        });
    }

    // Handle category item hover (level 2)
    megaCategoryItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            const category = this.getAttribute('data-category');
            
            // Remove active class from all items
            megaCategoryItems.forEach(catItem => catItem.classList.remove('active'));
            
            // Add active class to current item
            this.classList.add('active');
            
            // Hide all subcategory contents
            megaSubcategoryContents.forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('show');
            });
            
            // Show the selected subcategory content
            const targetContent = document.querySelector(`.mega-subcategory-content[data-category="${category}"]`);
            if (targetContent) {
                targetContent.classList.remove('hidden');
                targetContent.classList.add('show');
            }
        });
    });

    // Handle subcategory item hover (level 3)
    let subcategoryItems = document.querySelectorAll('[data-subcategory]');
    subcategoryItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            const subcategory = this.getAttribute('data-subcategory');
            
            // Remove active class from all subcategory items
            subcategoryItems.forEach(subItem => subItem.classList.remove('active'));
            
            // Add active class to current item
            this.classList.add('active');
        });
    });



  // ------------------------- Footer Accordion -----------
  const accordionItems = document.querySelectorAll('.footer-accordion-item');
  
  if (accordionItems.length > 0) {
    accordionItems.forEach(item => {
      const header = item.querySelector('.footer-accordion-header');
      const icon = item.querySelector('.accordion-icon');
      
      // Add click listener
      header.addEventListener('click', function(e) {
        // Only toggle on mobile
        if (window.innerWidth < 768) {
          e.preventDefault();
          
          const isOpen = item.classList.contains('footer-accordion-open');
          
          // Close all other items
          accordionItems.forEach(otherItem => {
            if (otherItem !== item) {
              const otherIcon = otherItem.querySelector('.accordion-icon');
              otherItem.classList.remove('footer-accordion-open');
              if (otherIcon) {
                otherIcon.style.transform = 'rotate(0deg)';
              }
            }
          });
          
          // Toggle current item
          if (isOpen) {
            item.classList.remove('footer-accordion-open');
            if (icon) {
              icon.style.transform = 'rotate(0deg)';
            }
          } else {
            item.classList.add('footer-accordion-open');
            if (icon) {
              icon.style.transform = 'rotate(180deg)';
            }
          }
        }
      });
    });
    
    // Close all on window resize when switching to desktop
    let resizeTimer;
    window.addEventListener('resize', function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function() {
        const isMobile = window.innerWidth < 768;
        accordionItems.forEach(item => {
          const icon = item.querySelector('.accordion-icon');
          
          if (isMobile) {
            // Mobile: keep state
            if (!item.classList.contains('footer-accordion-open') && icon) {
              icon.style.transform = 'rotate(0deg)';
            }
          } else {
            // Desktop: close all
            item.classList.remove('footer-accordion-open');
            if (icon) {
              icon.style.transform = 'rotate(0deg)';
            }
          }
        });
      }, 100);
    });
  }
  // ------------------------- /Footer Accordion -----------
});