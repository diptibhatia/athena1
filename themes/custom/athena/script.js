jQuery(document).scroll(function() {
    var y = jQuery(document).scrollTop(),
        header = jQuery(".share-icon ul");
    if(y <= 1600)  {
        header.css({position: "fixed"});
    } else {
        header.css("position", "relative");
    }
});