jQuery(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
  });

  if (jQuery(document).width() < 992) {

    jQuery('.has-submenu a').click(function(e){
         e.preventDefault();
         jQuery(this).next('.megasubmenu').toggle();

         jQuery('.dropdown').on('hide.bs.dropdown', function () {
          jQuery(this).find('.megasubmenu').hide();
       })
      });

 }

 
// }); // jquery end
var lastMenuItem;
function copyDiv(secondary_data) {
 var firstDivContent = document.getElementById(secondary_data);
 lastMenuItem = secondary_data.split("_")[0]+'_three-level';
 var secondDivContent = document.getElementById(lastMenuItem);
 secondDivContent.innerHTML = firstDivContent.innerHTML;
 event.stopPropagation();
}
function showThirdLevel(secondary_data){
copyDiv(secondary_data);
}
function clearDiv()
{
  document.getElementById(lastMenuItem).innerHTML = "No Content";
}