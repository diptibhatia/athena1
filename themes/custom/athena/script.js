jQuery(".selected-flag").after("<div class='country-code' />");
jQuery('.iti__flag-container').remove();
jQuery(document).ready(function() {
    jQuery("#phone").intlTelInput();

    if (jQuery(".country-code").length == 0) {
        jQuery(".selected-flag").after("<div class='country-code' />");
        jQuery(".country-code").text("+1");
    }

    jQuery(".country-list li").on('click', function(){
        jQuery(".country-code").text("+" + jQuery(this).attr('data-dial-code'));
    });

    if (jQuery(".country-code").length > 0) {
        jQuery.get('https://api.ipgeolocation.io/ipgeo?apiKey=90a52fe906a94d778219bd6d0c76b4e8', function(data) {
            var countrycode = data.country_code2;
            countrycode = countrycode.toLowerCase();

            var element = document.getElementsByClassName("selected-flag")[0];
            element.dispatchEvent(new Event("click"));
            jQuery("li.country[data-country-code='" + countrycode +
            "']").trigger('click');

            window.scrollTo(0, 0);
        });
    }


});

jQuery(document).on("click", ".country-list li", function(event) {
    event.preventDefault();
    jQuery(".country-code").text("+" + jQuery(this).attr('data-dial-code'));
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
