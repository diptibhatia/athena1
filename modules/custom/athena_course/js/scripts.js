
        jQuery(document).ready(function() {
            
            console.log("hellooooooooo")
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
