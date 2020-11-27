/*jQuery(document).scroll(function() {
    var y = jQuery(document).scrollTop(),
        header = jQuery(".share-icon ul");
    if(y <= 1600)  {
        header.css({position: "fixed"});
    } else {
        header.css("position", "relative");
    }
});
*/

function scrollEvent(){
        jQuery(function(){
            var stopFloating = jQuery('.stopScroll');
            if (stopFloating) {
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
