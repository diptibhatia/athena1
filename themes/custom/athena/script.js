$(document).scroll(function() {
    var y = $(document).scrollTop(),
        header = $(".share-icon ul");
    if(y <= 1600)  {
        header.css({position: "fixed"});
    } else {
        header.css("position", "relative");
    }
});