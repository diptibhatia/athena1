
        $(document).ready(function() {
            
            console.log("hellooooooooo")
            $('.owl-carousel').owlCarousel({
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
            $(window).scroll(function() {
                if($(window).width() > 1249) {
                    if(($(window).scrollTop() > $(".course-login-wrapper").offset().top) && 
                    ($(window).scrollTop() < ($(".course-login-wrapper").offset().top + $(".course-login-wrapper").height() - 
                    $(".testimonials").height() + 10))) {
                        $(".testimonials").css("position", "fixed");
                        console.log("Yo");
                    } else {
                        $(".testimonials").css("position", "static");
                    }
                }
            })
        })
