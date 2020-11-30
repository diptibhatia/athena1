jQuery(".selected-flag").after("<div class='country-code' />");
jQuery(document).ready(function() {
    if (jQuery(".country-code").length == 0) {
        jQuery(".selected-flag").after("<div class='country-code' />");
        jQuery(".country-code").text("+1");
    }
    jQuery("#phone").intlTelInput();
    jQuery(".country-list li").click(function(){
        jQuery(".country-code").text("+" + jQuery(this).attr('data-dial-code'));
    });
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
