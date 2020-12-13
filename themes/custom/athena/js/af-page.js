(function ($, Drupal) {
  $(document).ready(function () {
    /*-----------------------------------------------------------------------------------*/
    /*	STICKY HEADER
	/*-----------------------------------------------------------------------------------*/
  var menu = $('.navbar'),
  pos = menu.offset();
  $(window).scroll(function() {
    if ($(this).scrollTop() > pos.top + menu.height() && menu.hasClass('default') && $(this).scrollTop() > 300) {
        menu.fadeOut('fast', function() {
            $(this).removeClass('default').addClass('fixed').fadeIn('fast');
        });
    } else if ($(this).scrollTop() <= pos.top + 300 && menu.hasClass('fixed')) {
        menu.fadeOut(0, function() {
            $(this).removeClass('fixed').addClass('default').fadeIn(0);
        });
    }
  });
  $('.offset').css('padding-top', $('.navbar').height() + 'px');
  $(window).resize(function() {
  $('.offset').css('padding-top', $('.navbar').height() + 'px');
  });
  $('.onepage .navbar .nav li a').on('click', function() {
    $('.navbar .navbar-collapse.in').collapse('hide');
    $('.nav-bars').removeClass('is-active');
  });
  $('.shop').owlCarousel({
    loop: false,
    margin: 30,
    nav: true,
    navContainer: '.nav-outside-shop',
    navClass: ['btn btn-square nav-outside-prev', 'btn btn-square nav-outside-next'],
    navText: ['<img src="/themes/custom/athena/images/affiliatepage/previous.svg" />', '<img src="/themes/custom/athena/images/affiliatepage/next.svg" />'],
      dots: true,
    responsive: {
        0: {
            items: 1
        },
        480: {
            items: 2
        },
        1024: {
            items: 3
        },
        1440: {
            items: 3
        }
    }
  });
  $('.testimonials.col3').owlCarousel({
      autoplay: true,
      autoplayTimeout: 10000,
     loop: true,
      margin: 15,
      nav: false,
      dots: true,
      responsive: {
          0: {
              items: 1
          },
          768: {
              items: 2
  
          },
          1024: {
              items: 3
          }
      }
  });
  $("#reg_mobile_num").intlTelInput();
  var cData = {};
  $(".btn-try a").on('click', function(e) {
    e.preventDefault();
    $("#registrationModal").modal('toggle', $(this));
  });
  $(document).on('show.bs.modal', '#registrationModal', function(e) {
    //get data-id attribute of the clicked element
    var cId = $(e.relatedTarget).data('cid');
    var modId = $(e.relatedTarget).data('mid');
    var pay = $(e.relatedTarget).data('pay');
    console.log(modId);
    //populate the hidden field
    $(e.currentTarget).find('input[name="cId"]').val(cId);
    $(e.currentTarget).find('input[name="modId"]').val(modId);
    $(e.currentTarget).find('input[name="pay"]').val(pay);
  });
  //Reset form fields on close
  $('#registrationModal').on('hidden.bs.modal', function (e) {
    $(this)
      .find("input,textarea,select,input[type=hidden]")
        .val('')
        .end()
      .find("input[type=checkbox], input[type=radio]")
        .prop("checked", "")
        .end();
    $(".ref-form-2").hide("fast");
    $(".reg-form").show("slow");
  });

  var v = jQuery("#registration-afpage").validate({
    rules: {
      firstName: {
        required: true,
        minlength: 2,
        maxlength: 16
      },
      lastName: {
        required: true,
        minlength: 2,
        maxlength: 16
      },
      regEmail: {
        required: true,
        email: true
      },
      reg_mobile_num: {
        required: true
      },
      'terms[]': {
        required: true,
      },
      pswd: {
        required: true,
        minlength: 6,
        maxlength: 15,
      },
      confirmpswd: {
        required: true,
        minlength: 6,
        equalTo: "#pswd",
      }
    },
    messages: {
        firstName: {
          required: "Enter your firstname",
          minlength: jQuery.validator.format("Enter at least {0} characters"),
        },
        lastName: {
          required: "Enter your lastname",
          minlength: jQuery.validator.format("Enter at least {0} characters"),
        },
        'terms[]': {
          required: "Please agree to our terms & conditions",
        },
    },
    errorElement: "span",
    errorClass: "help-inline-error",
  });
  $(".sign-up-button").click(function(e) {
    e.preventDefault();
    cData.email = String(jQuery("#regEmail").val());
    cData.cId = parseInt(jQuery("#cId").val());
    cData.modId = jQuery("#modId").val();
    cData.pay = jQuery("#pay").val();
    // var userId = 0;
    if (v.form()) {
      jQuery.ajax('https://athenawpapi.azurewebsites.net/Register/GetCheckuser/Email/' + cData.email, {
        type: 'GET', // http method
        success: function(response) {
          // console.log(response);
          if(response == "Email Exist") {
            confirm("User already registered, please wait while we redirect you");
            redirCandidate(cData);
          }
          else {
            $(".reg-form").hide("fast");
            $(".ref-form-2").show("slow");
            var countryData = jQuery("#reg_mobile_num").intlTelInput("getSelectedCountryData");
            var iso2 = countryData.iso2;
            iso2 = iso2.toUpperCase();
            jQuery.get( "https://learn.athena.edu/athenaprod/api/country/"+iso2, function( data ) {
            jQuery( "#countryId" ).val(data);
            });
          }
        },
        error: function(xhr) {
          console.log(xhr);
          //Do Something to handle error
          alert("Something went wrong please try again");
        }
      });
      
    }
  });

  $('#registration-afpage').submit(function(e) {
    if (v.form()) {
      var utmSource = getParameterByName("utm_source"), campaign = getParameterByName("utm_campaign");
      var phnNumber = $("#reg_mobile_num").val(); // get full number eg +17024181234
      var countryCode = $("#reg_mobile_num").intlTelInput("getSelectedCountryData").dialCode; // get country data as obj 
      var phoneNum = "+" + countryCode + phnNumber;

      cData.email = String(jQuery("#regEmail").val());
      cData.cId = parseInt(jQuery("#cId").val());
      cData.modId = jQuery("#modId").val();
      cData.pay = jQuery("#pay").val();
      // var userId = 0;
      var sendInfo = {
        UserName: String(jQuery("#regEmail").val()),
        Password:String(jQuery("#pswd").val()),
        FirstName:String(jQuery("#firstName").val()),
        LastName:String(jQuery("#lastName").val()),
        Email:String(jQuery("#regEmail").val()),
        Code:parseInt(jQuery("#countryId").val()),
        ContactNo:String(phoneNum),
        CourseId:parseInt(jQuery("#cId").val()),
        Highestqualification:String(jQuery("#highestQualification").val()),
        source:String(utmSource),
        CampainName:String(campaign),
        IsAccepted:true,
      };
      // console.log(JSON.stringify(sendInfo));
      jQuery.ajax({
        url: "https://athenawpapi.azurewebsites.net/Register/SaveLead",
        type: 'POST', // http method
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify(sendInfo), // data to submit
        success: function (data, status, xhr) {
          // console.log(data);
          if (data == "Sucess" || data == "Success") {
            // console.log(modId);
            if(cData.pay == 1) {
              confirm("Registration Successful, please wait while we redirect you to payment page");
            }
            else {
              confirm("Registration Successful, you will be redirected to login page now.");
            }
            redirCandidate(cData);
          }
        },
        error: function (jqXhr, textStatus, errorMessage) {
          console.log(jqXhr);
          if (jqXhr.status != 200) {
            alert("Something went wrong please try again");
          }
        }
      });
      return false;
    }
    
  });
});
})(jQuery, Drupal);

  function redirCandidate(cData) {
    // console.log(cData);
    if(cData.hasOwnProperty('pay') && cData.pay == 1) {
      jQuery.when( jQuery.get("https://athenawpapi.azurewebsites.net/Register/GetUserId/"+cData.email))
        .then(function( data, textStatus, jqXHR ) {
        //   alert(data);  
        // alert( jqXHR.status ); 
        var userId = parseInt(jQuery.trim(data));
        if( userId > 0) {
          window.location.replace('https://ulearn.athena.edu/StudentEnroltoCourse?UId='+userId+'&CId='+cData.cId+'&ModId='+cData.modId);
        } else {
          alert("Something went wrong please try again");
        }
      });
    } else {
      window.location.replace('http://ulearn.athena.edu/login?mail='+cData.email+'&CId='+cData.cId);
    }
  }
  function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}