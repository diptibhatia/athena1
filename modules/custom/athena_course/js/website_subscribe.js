(function ($, Drupal, drupalSettings) {
  'use strict';

  var baseUrl = window.location.origin;

  jQuery('document').ready(function() {
      var gc = getCookie("website_subscribe");
      if (gc == null || gc === '') {
        jQuery('#register-pop-up').show();
        jQuery('#thanks-up').hide();
      }
      else {
        jQuery('#register-pop-up').hide();
        jQuery('#thanks-up').hide();
      }

      var event = new Event("click");
      popBtn.dispatchEvent(event);
  });


  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }


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

          // ****** save newsletter info in database *********      
      
      var mailinfo = {
          'mail': emailval
        };  

      var URL = "https://agestagingapi.azurewebsites.net/api/Newsletter/SaveNewsLetter";
        if (baseUrl == "https://www.athena.edu" || baseUrl == "https://athena.edu" 
          || baseUrl == "http://www.athena.edu" || baseUrl == "http://athena.edu") {
          URL = "https://athenawpapi.azurewebsites.net/api/Newsletter/SaveNewsLetter";
        }
  
      jQuery.ajax( URL, {
        type: 'POST',  // http method
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        data: JSON.stringify(mailinfo),  // data to submit
        dataType: 'json',
        success: function (data, status, xhr) {
          console.log('success');
        },
        error: function (jqXhr, textStatus, errorMessage) {
          if (jqXhr.status == 200) {
            console.log('error here');
          }
        }
      });
      // ********************************** 
  

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



