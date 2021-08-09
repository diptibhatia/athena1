var baseUrl = window.location.origin;
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
    //navContainer: '.nav-outside-shop',
    navClass: ['owl-prev', 'owl-next'],
    //navText: ['<img src="/themes/custom/athena/images/affiliatepage/previous.svg" />',
    //'<img src="/themes/custom/athena/images/affiliatepage/next.svg" />'],
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
  jQuery("#reg_mobile_num").intlTelInput({
    initialCountry: "auto",
    geoIpLookup: function(success, failure) {
       jQuery.get("https://ipinfo.io/?token=8ac111a31f0784", function() {}, "jsonp").always(function(resp) {
        //  console.log(resp);
         var countryCode = (resp && resp.country) ? resp.country : "us";
         success(countryCode);
       });
    },
    separateDialCode: true
  });

  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };
  jQuery("#reg_mobile_num").inputFilter(function(value) {
      return /^\d*$/.test(value);
  });
  jQuery('#reg_mobile_num').attr('maxlength', 15);


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
    // console.log(modId);
    //populate the hidden field
    $(e.currentTarget).find('input[name="cId"]').val(cId);
    $(e.currentTarget).find('select[name="course"]').val(cId);
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
        jQuery("#registration-afpage").validate().resetForm();
        $('#registration-afpage .reg-form-control').removeClass('help-inline-error');

    $(".ref-form-2").hide("fast");
    $(".reg-form").show("slow");
  });

  //----------------form validation
  jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-zA-Z_ \.]*$/i.test(value);
}, "Please enter only letters");

  jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
      if (phone_number.length == 0) {
        return false;
      }
      if (phone_number.length < 6 || phone_number.length > 15) {
        return false;
      }
      return true;
  }, "Please specify a valid phone number");

jQuery.validator.addMethod("emailExt", function(value, element, param) {
    return value.match(/^[a-zA-Z0-9_\.%\+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,}$/);
},'Please enter a valid Email id');

  var v = jQuery("#registration-afpage").validate({
    rules: {
      firstName: {
        required: true,
        minlength: 2,
        maxlength: 16,
        lettersonly: true
      },
      lastName: {
        required: true,
        minlength: 2,
        maxlength: 16,
        lettersonly: true
      },
      regEmail: {
        required: true,
        emailExt: true
      },
      reg_mobile_num: {
        required: true,
        phoneUS: true
      },
      'terms[]': {
        required: true,
      },
      pswd: {
        required: true,
        minlength: 4,
        maxlength: 15,
      },
      confirmpswd: {
        required: true,
        minlength: 4,
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
    cData.cId = parseInt(jQuery("#course").val());
    cData.modId = jQuery("#modId").val();
    cData.pay = jQuery("#pay").val();
    var utmSource = getParameterByName("utm_source");
    // var userId = 0;
    if (v.form()) {
      jQuery.ajax('https://athenawpapi.azurewebsites.net/Register/GetCheckuser/Email/' + cData.email, {
        type: 'GET', // http method
        success: function(response) {
          // console.log(response);
          if(response == "Email Exist") {
            var r = null;
            if(cData.pay == 1) {
              var r = confirm("User already registered, please wait while we redirect you to payment page");
            }
            else {
              var r = confirm("User already registered, you will be redirected to login page now.");
            }

            if (r == true) {
              redirCandidate(cData, utmSource);
              //window.location.replace('https://ulearn.athena.edu/login?from=affiliate&mail='+cData.email+'&CId='+cData.cId+'&source='+utmSource);
            } else {
                 window.close();
                 parent.location.reload();
            }

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
      var prov_list = ['Western Cape', 'Limpopo', 'Eastern Cape', 'Free State', 'North West','Kerala'];
      let BU = "AGE"
      utmSource = (utmSource == null || utmSource == '') ? "Direct":utmSource;
      //API URL

     if (baseUrl == "http://websitestg.athena.edu" || baseUrl == "https://websitestg.athena.edu") {
        var URL = "https://agestagingapi.azurewebsites.net/Register/SaveLead";
      } else {
        var URL = "https://athenawpapi.azurewebsites.net/Register/SaveLead";
      }

      cData.email = String(jQuery("#regEmail").val());
      cData.cId = parseInt(jQuery("#course").val());
      cData.modId = jQuery("#modId").val();
      cData.pay = jQuery("#pay").val();
      let ip,province;
      jQuery.ajax({
        url : "https://ipinfo.io/?token=8ac111a31f0784",
        type : "get",
        async: false,
        success : function(data) {
          ip = data.ip;
          province = data.region;
          // province = "Free State";
          // console.log(ip + ' ' + province);
          if(prov_list.includes(province)) {
            BU = "DicioMarketing"
          }
          // console.log(BU);
        },
        error: function() {
          alert("Something went wrong please try again");
        }
      });
      // var userId = 0;
      var sendInfo = {
        UserName: String(jQuery("#regEmail").val()),
        Password:String(jQuery("#pswd").val()),
        FirstName:String(jQuery("#firstName").val()),
        LastName:String(jQuery("#lastName").val()),
        Email:String(jQuery("#regEmail").val()),
        Code:parseInt(jQuery("#countryId").val()),
        ContactNo:String(phoneNum),
        CourseId:parseInt(jQuery("#course").val()),
        Highestqualification:String(jQuery("#highestQualification").val()),
        source:String(utmSource),
        CampainName:String(campaign),
        IsAccepted:true,
        IPAddress:ip,
        BU:BU
      };
      //console.log(JSON.stringify(sendInfo));
      jQuery.ajax({
        url: URL,
        type: 'POST', // http method
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify(sendInfo), // data to submit
        success: function (data, status, xhr) {
          // console.log(data);
          if (data == "Sucess" || data == "Success") {
            // console.log(modId);
            if(cData.pay == 1) {
              var r = confirm("Registration Successful, please wait while we redirect you to payment page");
            }
            else {
              var r = confirm("Registration Successful, you will be redirected to login page now.");
            }

            if (r == true) {
              redirCandidate(cData, utmSource);
            } else {
                 window.close();
                 parent.location.reload();
            }

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

  function redirCandidate(cData, utmSource) {
    // console.log(cData);

    if(cData.hasOwnProperty('pay') && cData.pay == 1) {
      jQuery.when( jQuery.get("https://athenawpapi.azurewebsites.net/Register/GetUserId/"+cData.email))
        .then(function( data, textStatus, jqXHR ) {
        //   alert(data);
        // alert( jqXHR.status );
        var userId = parseInt(jQuery.trim(data));
        if( userId > 0) {
          window.location.replace('https://ulearn.athena.edu/StudentEnroltoCourse?from=affiliate&UId='+userId+'&CId='+cData.cId+'&ModId='+cData.modId+'&source='+utmSource);

          //window.location.replace('https://athena.edu/StudentEnroltoCourse?from=affiliate&UId='+userId+'&CId='+cData.cId+'&ModId='+cData.modId+'&source='+utmSource);

        } else {
          alert("Something went wrong please try again");
        }
      });
    } else {
      //window.location.replace('https://ulearn.athena.edu/login?mail='+cData.email+'&CId='+cData.cId);
      window.location.replace('https://athena.edu/StudentEnroltoCourse?from=affiliate&mail='+cData.email+'&CId='+cData.cId+'&source='+utmSource);
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
