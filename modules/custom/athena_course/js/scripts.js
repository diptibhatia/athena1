
        jQuery(document).ready(function() {
            
             jQuery("#news-letter-subscribe").click(function() {
               
                 
                 var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(jQuery('#newsletter-email-input').val())) {
    jQuery("#newsletter-info-box-error").html("Invalid Email id");
    jQuery("#newsletter-info-box-error").removeClass('hide');
    jQuery('#newsletter-info-box-error').css('display','inherit');
  }else{
       jQuery('#newsletter-info-box-error').css('display','none');
      jQuery("#newsletter-info-box").html("Subscribed Successfullly");
       jQuery('#newsletter-info-box').css('display','inherit');
                 jQuery("#newsletter-info-box").removeClass('hide');
  }
                 });
            jQuery("#speak_submit").click(function() {
                var msg = '';
                if(jQuery("#speak_first_name").val() == '') {
                    msg += '\n\u2022  First name cannot be empty';
                }
                if(jQuery("#speak_last_name").val() == '') {
                    msg += '\n\u2022  Last name cannot be empty';
                }
                if(jQuery("#speak_email").val() == '') {
                    msg += '\n\u2022  Email cannot be empty';
                }
                if(jQuery("#speak_first_name").val() == '') {
                    msg += '\n\u2022  Phone number cannot be empty';
                }
                 if(jQuery("#speak_country").val() == '') {
                    msg += '\n\u2022  Country cannot be empty';
                }
                 if(jQuery("#speak_mobile_number").val() == '') {
                    msg += '\n\u2022  Phone number cannot be empty';
                }
                if(!jQuery("#speak_consent").prop('checked') == true){
                     msg += '\n\u2022 please accept consent terms';
                }
                
                if(msg == ''){
                    alert("Data Submitted, will reach out to you shortly")
                }else {
                    
                    alert(msg)
                }
});
            jQuery('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                autoWidth: true,
                responsiveClass: true,
                responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                    margin: 20
                }
                }
            })
            jQuery(window).scroll(function() {
                if(jQuery(window).width() > 1249) {
                    if((jQuery(window).scrollTop() > jQuery(".course-login-wrapper").offset().top) && 
                    (jQuery(window).scrollTop() < (jQuery(".course-login-wrapper").offset().top + jQuery(".course-login-wrapper").height() - 
                    jQuery(".testimonials").height() + 10))) {
                        jQuery(".testimonials").css("position", "fixed");
                        console.log("Yo");
                    } else {
                        jQuery(".testimonials").css("position", "static");
                    }
                }
            })
        })
