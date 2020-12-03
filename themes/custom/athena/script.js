jQuery(".selected-flag").after("<div class='country-code' />");
jQuery(document).ready(function() {
    jQuery("#phone").intlTelInput();
    jQuery("#reg_mobile_num").intlTelInput();

    if (jQuery(".country-code").length == 0) {
        jQuery(".selected-flag").after("<div class='country-code' />");
        jQuery(".country-code").text("+1");
    }

    jQuery(".country-list li").click(function(){
        jQuery(".country-code").text("+" + jQuery(this).attr('data-dial-code'));
    });


    // jQuery.getScript('http://www.geoplugin.net/javascript.gp', function() {
    //     var countrycode = geoplugin_countryCode();
    //     countrycode = countrycode.toLowerCase();
    //     var countryphone = '';
    //     jQuery(".country-list li.country").each(function( index ) {
    //       if (jQuery(this).attr('data-country-code') == countrycode) {
    //         jQuery(this).addClass('highlight active');
    //         countryphone = jQuery(this).attr('data-dial-code');
    //         jQuery(".country-code").text("+" + countryphone);
    //         jQuery('.selected-flag .iti-flag').removeClass('us');
    //         jQuery('.selected-flag .iti-flag').addClass(countrycode);
    //         return false;
    //       }
    //     });
    // });


});


function scrollEvent(){
        jQuery(function(){
            var stopFloating = jQuery('.stopScroll');
            if (stopFloating.length > 0) {
                var stop = stopFloating.offset().top;
                jQuery(document).scroll(function() {
                    var y = jQuery(window).scrollTop(),
                    header = jQuery(".share-icon div");
                    if(y <= stop-500)  {
                        header.css({display: "block"});
                    header.css({position: "fixed"});
                    } else {
                        header.css({display: "none"});
                    }
                });
            }
    });
}
window.onload = scrollEvent();
