(function ($, Drupal) {
  $(document).ready(function () {

    $("#reg_mobile_num").intlTelInput();

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

    //----------------form validation
    jQuery.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-zA-Z_ \.]*$/i.test(value);
    }, "Please enter only letters");

    jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
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
              var r = confirm("User already register, please wait while we redirect you to payment page");

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

        cData.email = String(jQuery("#regEmail").val());
        cData.cId = parseInt(jQuery("#course").val());
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
          CourseId:parseInt(jQuery("#course").val()),
          Highestqualification:String(jQuery("#highestQualification").val()),
          source:String(utmSource),
          CampainName:String(campaign),
          IsAccepted:true,
        };
        //console.log(JSON.stringify(sendInfo));
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
