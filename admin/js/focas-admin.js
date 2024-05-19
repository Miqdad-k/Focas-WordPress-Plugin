jQuery(document).ready(function ($) {
    $('.slider').slick({
        dots: false,
        infinite: true,
        speed: 500,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 2000,
        arrows: true,
        responsive: [{
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 400,
            settings: {
                arrows: false,
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }]
    });
  });
  
  function billSection() {
    var bill = document.getElementById('billing-section');
    bill.style.display = "block"
    bill.style.right = "0"
  
    var product = document.getElementById('product-section');
    product.style.zIndex = "-1"
  
  }
  
  function closeBill() {
    var bill = document.getElementById('billing-section');
    bill.style.right = "-100%"
    bill.style.display = "none"
  
    var product = document.getElementById('product-section');
    product.style.zIndex = "1"
  
  }
  
  function notification() {
    var notify = document.getElementById('notify');
    notify.style.display = "flex"
  }
  
  
  // .........................................................................
  // .........................................................................
  // .........................................................................
  // .........................................................................
  
  