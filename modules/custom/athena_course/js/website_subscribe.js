(function ($, Drupal, drupalSettings) {
  'use strict';

  jQuery('document').ready(function() {
      jQuery('#register-pop-up').show();
      jQuery('#thanks-up').hide();
      var event = new Event("click");
      popBtn.dispatchEvent(event);
  });

  jQuery('.close, .lclose, .okay').on('click', function() {
      jQuery.ajax(baseUrl + '/website-newsletter-subscribe/close/close', {
        type: 'GET',
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data, status, xhr) {
          console.log(data.message);
        },
        error: function (jqXhr, textStatus, errorMessage) {
          if(jqXhr.status == 200) {
            console.log('error');
          }
        }
      });

      jQuery('#register-pop-up').remove();
      jQuery('#thanks-up').remove();
  });

  jQuery('#popthnksBtn').on('click', function() {
      var emailval = jQuery('#register-pop-up #email').val();
      emailval = emailval.trim();
      var nameval = jQuery('#register-pop-up #name').val();
      nameval = nameval.trim();

      var flag = false;

      if (emailval == '') {
          flag = true;
          jQuery('#register-pop-up #email').css("border", "1px solid red");
      }
      else {
          if (!isEmail(emailval)) {
              flag = true;
              jQuery('#register-pop-up #email').css("border", "1px solid red");
          }
      }
      if (nameval == '') {
          flag = true;
          jQuery('#register-pop-up #name').css("border", "1px solid red");
      }

      if (!flag) {

          nameval = nameval.substring(0, 200);
          nameval = nameval.replace(/(<([^>]+)>)/ig,"");

          emailval = emailval.substring(0, 200);
          emailval = emailval.replace(/(<([^>]+)>)/ig,"");

          jQuery.ajax(baseUrl + '/website-newsletter-subscribe/' + nameval + '/' + emailval, {
            type: 'GET',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data, status, xhr) {
              console.log(data.message);
            },
            error: function (jqXhr, textStatus, errorMessage) {
              if(jqXhr.status == 200) {
                console.log('error');
              }
            }
          });

          jQuery('#register-pop-up').hide();
          jQuery('#thanks-up').show();
      }
  });

  function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }

  var modal = document.getElementById("register-pop-up");
  window.onload = function () {
      setTimeout(function () {
          modal.style.display = "block";
      }, 10000);
  };

})(jQuery, Drupal, drupalSettings);



