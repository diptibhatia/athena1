/**
 * @file
 * Javascript functions.
 */

(function ($) {
 'use strict';
   
  $(document).ready(() => {
    //alert('hi.....');
    $('div.indented').css('display', 'none');
    $('article span.show-hide').click(function () {
      if ((this).innerHTML === 'Show') {
            
        (this).innerHTML = 'Hide';
        $(this).parents('article').next().slideToggle();
      }
      else {
        (this).innerHTML = 'Show';
        $(this).parents('article').next().slideToggle();
      }
    });
  });
}(jQuery));
