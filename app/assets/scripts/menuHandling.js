$(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
  });

  if ($(window).width() < 992) {

      $('.has-submenu a').click(function(e){
         e.preventDefault();
         $(this).next('.megasubmenu').toggle();

         $('.dropdown').on('hide.bs.dropdown', function () {
          $(this).find('.megasubmenu').hide();
       })
      });

 }

 
// }); // jquery end

function copyDiv(secondary_data) {
 var firstDivContent = document.getElementById(secondary_data);
 var secondDivContent = document.getElementById('three-level');
 secondDivContent.innerHTML = firstDivContent.innerHTML;
 event.stopPropagation();
}
function showThirdLevel(secondary_data){
copyDiv(secondary_data);
}