(function ($, Drupal) {
  $(document).ready(function () {
    // alert("fggf");
    /*-----------------------------------------------------------------------------------*/
    /*	STICKY HEADER
	/*-----------------------------------------------------------------------------------*/
  var menu = $('.navbar'),
  pos = menu.offset();
$(window).scroll(function() {
  if ($(this).scrollTop() > pos.top + menu.height() && menu.hasClass('default') && $(this).scrollTop() > 300) {
      menu.fadeOut('fast', function() {
          $(this).removeClass('default').addClass('fixed').fadeIn('fast');
      });
  } else if ($(this).scrollTop() <= pos.top + 300 && menu.hasClass('fixed')) {
      menu.fadeOut(0, function() {
          $(this).removeClass('fixed').addClass('default').fadeIn(0);
      });
  }
});
$('.offset').css('padding-top', $('.navbar').height() + 'px');
$(window).resize(function() {
$('.offset').css('padding-top', $('.navbar').height() + 'px');
});
$('.onepage .navbar .nav li a').on('click', function() {
  $('.navbar .navbar-collapse.in').collapse('hide');
  $('.nav-bars').removeClass('is-active');
});
    $('.shop').owlCarousel({
      loop: false,
      margin: 30,
      nav: true,
      navContainer: '.nav-outside-shop',
      navClass: ['btn btn-square nav-outside-prev', 'btn btn-square nav-outside-next'],
      navText: ['<img src="/themes/custom/athena/images/affiliatepage/previous.svg" />', '<img src="/themes/custom/athena/images/affiliatepage/next.svg" />'],
       dots: true,
      responsive: {
          0: {
              items: 1
          },
          480: {
              items: 2
          },
          1024: {
              items: 3
          },
          1440: {
              items: 3
          }
      }
  });
  $('.testimonials.col3').owlCarousel({
      autoplay: true,
      autoplayTimeout: 10000,
     loop: true,
      margin: 15,
      nav: false,
      dots: true,
      responsive: {
          0: {
              items: 1
          },
          768: {
              items: 2
  
          },
          1024: {
              items: 3
          }
      }
  });
  });
})(jQuery, Drupal);