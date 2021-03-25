var baseUrl = window.location.origin;

        jQuery(document).ready(function() {
            var search_url = baseUrl + '/search-results/abc?univ=';
            jQuery("#partner_search" ).change(function() {
              var partner =  jQuery("#partner_search").val();
              var search_key =  jQuery("#search_key").val();
              var lang =  jQuery("#language_search").val();
              var level =  jQuery("#level_search").val();
              var duration =  jQuery("#duration_search").val();
              window.location= search_url + partner + '&lang=' +lang+ '&level=' +level+ '&duration='+duration;
            });
            jQuery("#language_search" ).change(function() {
              var partner =  jQuery("#partner_search").val();
              var search_key =  jQuery("#search_key").val();
              var lang =  jQuery("#language_search").val();
              var level =  jQuery("#level_search").val();
              var duration =  jQuery("#duration_search").val();
              window.location= search_url + partner + '&lang=' +lang+ '&level=' +level+ '&duration='+duration;
            });
            jQuery("#level_search" ).change(function() {
              var partner =  jQuery("#partner_search").val();
              var search_key =  jQuery("#search_key").val();
              var lang =  jQuery("#language_search").val();
              var level =  jQuery("#level_search").val();
              var duration =  jQuery("#duration_search").val();
              window.location= search_url + partner + '&lang=' +lang+ '&level=' +level+ '&duration='+duration;
            });
            jQuery("#duration_search" ).change(function() {
              var partner =  jQuery("#partner_search").val();
              var search_key =  jQuery("#search_key").val();
              var lang =  jQuery("#language_search").val();
              var level =  jQuery("#level_search").val();
              var duration =  jQuery("#duration_search").val();
              window.location= search_url + partner + '&lang=' +lang+ '&level=' +level+ '&duration='+duration;
            });

            if (jQuery("#partner_search").length > 0 && jQuery("#language_search" ).length > 0
              && jQuery("#duration_search" ).length > 0 && jQuery("#level_search" ).length > 0 ) {
              var univ = getUrlParameter('univ');
              var lang = getUrlParameter('lang');
              var duration = getUrlParameter('duration');
              var level = getUrlParameter('level');
              if (univ != undefined) {
                jQuery("#partner_search").val(univ);
              }
              if (lang != undefined) {
                jQuery("#language_search").val(lang);
              }
              if (duration != undefined) {
                jQuery("#duration_search").val(duration);
              }
              if (level != undefined) {
                jQuery("#level_search").val(level);
              }

            }


/*
  //---------------------------------------------



jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z]+$/i.test(value);
}, "Please enter only letters");

jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, "");
    return this.optional(element) || phone_number.length > 9 &&
        phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
}, "Please specify a valid phone number");

jQuery.validator.addMethod("emailExt", function(value, element, param) {
    return value.match(/^[a-zA-Z0-9_\.%\+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,}$/);
},'Please enter a valid Email id');


jQuery("#get_in_touch_form").validate({

        rules: {
            "get_in_touch_fname": {
                required: true,
                minlength: 2,
                maxlength: 16,
                lettersonly: true
            },

            "get_in_touch_lname": {
                required: true,
                minlength: 2,
                maxlength: 16,
                lettersonly: true
            },

            "get_in_touch_email": {
                required: true,
                email: true,
                emailExt: true
            },

            "phone": {
                required: true,
                phoneUS: true
            },
            'get_in_touch_consent[]' :{
                required: true,
            }

        },

        messages: {

            "get_in_touch_fname": {
                required: "Enter first name",
                minlength: jQuery.validator.format("Enter at least {0} characters"),
            },

            "get_in_touch_lname": {
                required: "Enter last name",
                minlength: jQuery.validator.format("Enter at least {0} characters"),
            },

            "phone": {
                required: "Please enter phone number"
            },
            "get_in_touch_consent[]": {
                required: "Please agree to our terms & conditions"
           },

        },

    });

//------------------------------------

*/





            jQuery("#get_in_touch").click(function(e) {
                 var msg = '';
                var regex = /^[a-zA-Z_ \.]*$/;

                fname  = jQuery("#get_in_touch_fname").val();
                lname  = jQuery("#get_in_touch_lname").val();

                if(fname == '' ) {
                    msg += '\n\u2022  Please enter first name';
                }else if ( fname.length < 2 || fname.length > 16  ){
                    msg += '\n\u2022  Please enter 2 to 16 characters for first name';
                }else if(!regex.test(jQuery("#get_in_touch_fname").val())) {
                  msg += '\n\u2022  Please enter only letters for first name';
                }

                if(lname == '' ) {
                    msg += '\n\u2022  Please enter last name';
                }else if ( lname.length < 2 || lname.length > 16  ){
                    msg += '\n\u2022  Please enter 2 to 16 characters for last name';
                }else if(!regex.test(jQuery("#get_in_touch_lname").val())) {
                  msg += '\n\u2022  Please enter only letters for last name';
                }

                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(jQuery("#get_in_touch_email").val() == '') {
                    msg += '\n\u2022  Please enter email id';
                }else if(!regex.test(jQuery("#get_in_touch_email").val())) {
                  msg += '\n\u2022  Please enter valid Email id';
                }


                if(!jQuery("#get_in_touch_consent").prop('checked') == true){
                     msg += '\n\u2022  Please accept consent terms';
                }

                var ph_num = jQuery("#phone").val();
                var num_len = ph_num.length;

                if( ph_num =='' || num_len <6 || num_len >15) {
                  msg += '\n\u2022  Please enter a valid phone number';
                }else if(!jQuery('#phone').val().match(/^[0-9]+$/)) {
                  msg += '\n\u2022  Please enter a valid phone number';
                }

                if(msg =='') {

                    var dataObj = {
                      'form_id': "Get in touch",
                      'course': jQuery('#get_in_touch_course').val(),
                      'fname': jQuery('#get_in_touch_fname').val(),
                      'lname': jQuery('#get_in_touch_lname').val(),
                      'email': jQuery('#get_in_touch_email').val(),
                      'phone': jQuery('#phone').val()
                    };

/*
                    jQuery.ajax({'https://athenawpapi.azurewebsites.net/save/contact',{}
                        //url: baseUrl + "/save/contact",

                        type: "post",
                        data: JSON.stringify(dataObj),
                        dataType: "json",
                        contentType: "application/json; charset=utf-8",
                        success: function (response) {
                          alert(url);
                          jQuery('#get_in_touch_course').val("");
                          jQuery('#get_in_touch_fname').val("");
                          jQuery('#get_in_touch_lname').val("");
                          jQuery('#get_in_touch_email').val("");
                          jQuery('#get_in_touch_consent').val("");
                          jQuery('#phone').val("");
                          jQuery('#get_in_touch_consent').prop('checked', false);

                           alert(response.message);
                           return false;
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                          alert(url);
                          alert(jqXHR.status);
                           if(jqXhr.status == 200) {
                                  alert("Thank you for submitting the registration form. Will reach out to you shortly");
                                }
                           console.log(textStatus, errorThrown);
                           console.log("here");
                        }
                    });
*/
jQuery.ajax(baseUrl + '/save/contact', {
                        type: 'POST',  // http method
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        data: JSON.stringify(dataObj) ,  // data to submit
                         dataType: 'json',
                        success: function (data, status, xhr) {
                            var txt;
                            alert("Thank you for showing your interest. We will reach out to you shortly")
                        },
                        error: function (jqXhr, textStatus, errorMessage) {
                                if(jqXhr.status == 200) {
                                  alert("Thank you for showing your interest. We will reach out to you shortly")

                                }
                        }
                    });


                          var mailinfo = {
                            'mail': jQuery('#get_in_touch_email').val(),
                            'fname': jQuery('#get_in_touch_fname').val(),
                            'lname': jQuery('#get_in_touch_lname').val(),
                            'phone': jQuery('#phone').val(),
                            'category': jQuery('#get_in_touch_course').val(),
                            'country_code': jQuery(".country-code").html(),
                            'action': 'save_newsletter',
                            'is_action': jQuery('input[name="register-latest"]:checked').val()
                          };
                          initiateSendingMail('get_in_touch', mailinfo);

                          jQuery('#get_in_touch_course').val("");
                          jQuery('#get_in_touch_fname').val("");
                          jQuery('#get_in_touch_lname').val("");
                          jQuery('#get_in_touch_email').val("");
                          jQuery('#get_in_touch_consent').val("");
                          jQuery('#phone').val("");
                          jQuery('#get_in_touch_consent').prop('checked', false);


                return false;

                }else {

                    alert(msg)
                }
            });


             jQuery("#registration_form_passchck").click(function() {
                var msg = '';
                if(jQuery("#reg_pass").val() == '') {
                  msg += '\n\u2022  Please Enter password';
                }
                if(jQuery("#reg_confirm_pass").val() == '') {
                  msg += '\n\u2022 please confirm pass';
                }

                if(jQuery("#reg_pass").val() !== jQuery("#reg_confirm_pass").val()){
                   msg += '\n\u2022 password and confirm password do not match';
                }


                var utm_source = jQuery("#utm_source").val();
                var utm_campaign = jQuery("#utm_campaign").val();
                console.log("UTM"+utm_source);
                console.log("utm_campaign"+utm_campaign);

                if(utm_source == '') {
                 utm_source = 'Direct';
                }

                if(msg != '') {
                  alert(msg);
                  return false;
                }

                var countryData = jQuery("#phone").intlTelInput("getSelectedCountryData");
                var iso2 = countryData.iso2;
                iso2 = iso2.toUpperCase();

                var sendInfo = {
                  UserName: String(jQuery("#reg_email").val()),
                  Password:String(jQuery("#reg_pass").val()),
                  FirstName:String(jQuery("#reg_first_name").val()),
                  LastName:String(jQuery("#reg_last_name").val()),
                  Email:String(jQuery("#reg_email").val()),
                  Code:parseInt(jQuery("#country_code").val()),
                  ContactNo:String(jQuery("#phone").val()),
                  CourseId:parseInt(jQuery("#reg_course").val()),
                  Highestqualification:String(jQuery("#reg_qual").val()),
                  source:String(utm_source),
                  CampainName:String(utm_campaign),
                  Yearsofexperience:parseInt(jQuery("#reg_exp").val()),
                  Monthofexperience:parseInt(jQuery("#reg_months").val()),
                  IsAccepted:true,
                  Employmentlevel:String(jQuery("#reg_level").val())
                };

                var email_id = jQuery("#reg_email").val();
                var cid = jQuery("#reg_course").val();

                var URL_path = baseUrl.split(".");

                if(URL_path.indexOf("websitestg") !== -1){
                    var URL = "https://agestagingapi.azurewebsites.net/Register/SaveLead";
                } else{
                    var URL = "https://athenawpapi.azurewebsites.net/Register/SaveLead";
                }

                alert(URL);

                jQuery.ajax(URL, {
                  type: 'POST',  // http method
                  contentType: "application/json; charset=utf-8",
                  dataType: "json",
                  data: JSON.stringify(sendInfo) ,  // data to submit
                   dataType: 'json',
                  success: function (data, status, xhr) {
                      var txt;
                      var r = confirm("Registration Successful, you will be redirected to login page now.");
                      if (r == true) {
                       // txt = "You pressed OK!";
                      } else {
                        //txt = "You pressed Cancel!";
                      }
                  },
                  error: function (jqXhr, textStatus, errorMessage) {
                    if(jqXhr.status == 200) {

                      var r = confirm("Registration Successful, you will be redirected to login page now.");
                      if (r == true) {

                        var URL_path = baseUrl.split(".");

                        if(URL_path.indexOf("websitestg") !== -1){
                            var URL = "https://agestagingapi.azurewebsites.net/Register/GetUserId/"+email_id;
                        } else{
                            var URL = "https://athenawpapi.azurewebsites.net/Register/GetUserId/"+email_id;
                        }

                        alert(URL);
                        
                        jQuery.when( jQuery.get(URL))
                          .then(function( data, textStatus, jqXHR ) {
                          var userId = parseInt(jQuery.trim(data));
                          if( userId > 0) {
                            //window.location.replace('https://ulearn.athena.edu/StudentEnroltoCourse?UId='+userId+'&CId='+cData.cId+'&ModId='+cData.modId);
                            window.location.replace(baseUrl + '/StudentEnroltoCourse?UId='+userId+'&CId='+cid+'&mail='+email_id);

                          }
                          else{
                            window.location.replace(baseUrl + '/StudentEnroltoCourse?mail='+email_id+'&CId='+cid);

                          }

                        });
                        // window.location.replace('https://ulearn.athena.edu/login?mail='+email_id+'&CId='+cid);
                        //window.location.replace(baseUrl + '/StudentEnroltoCourse?mail='+email_id+'&CId='+cid);

                      } else {

                          window.close();

                      }

                    }
                  }
                });

             });

             jQuery("#registration_form").click(function() {
                var msg = '';
                var c_email = jQuery("#reg_email").val();
                var regex = /^[a-zA-Z_ \.]*$/;

                fname  = jQuery("#reg_first_name").val();
                lname  = jQuery("#reg_last_name").val();

                if(fname == '' ) {
                    msg += '\n\u2022  Please enter first name';
                }else if ( fname.length < 2 || fname.length > 16  ){
                    msg += '\n\u2022  Please enter 2 to 16 characters for first name';
                }else if(!regex.test(jQuery("#reg_first_name").val())) {
                  msg += '\n\u2022  Please enter only letters for first name';
                }

                if(lname == '' ) {
                    msg += '\n\u2022  Please enter last name';
                }else if ( lname.length < 2 || lname.length > 16  ){
                    msg += '\n\u2022  Please enter 2 to 16 characters for last name';
                }else if(!regex.test(jQuery("#reg_last_name").val())) {
                  msg += '\n\u2022  Please enter only letters for last name';
                }

                if(jQuery("#reg_country").val() == '') {
                    msg += '\n\u2022  Please select country';
                }

                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(jQuery("#reg_email").val() == '') {
                    msg += '\n\u2022  Please enter email id';
                }else if(!regex.test(jQuery("#reg_email").val())) {
                  msg += '\n\u2022  Please enter valid Email id';
                }

                var ph_num = jQuery("#phone").val();
                var num_len = ph_num.length;

                if( ph_num =='' || num_len <6 || num_len >15) {
                  msg += '\n\u2022  Please enter a valid phone number';
                }else if(!jQuery('#phone').val().match(/^[0-9]+$/)) {
                  msg += '\n\u2022  Please enter a valid phone number';
                }

                 if(jQuery("#reg_qual").val() == '') {
                    msg += '\n\u2022  Please select Qualification';
                }
                 if(jQuery("#reg_exp").val() == '' || jQuery("#reg_months").val() == '' ) {
                    msg += '\n\u2022  Please enter years & months of experience';
                }
                 if(jQuery("#reg_level").val() == '') {
                    msg += '\n\u2022  Please select level of employment';
                }


                if(!jQuery("#reg_terms").prop('checked') == true){
                     msg += '\n\u2022  Please accept consent terms';
                }
   var countryData = jQuery("#phone").intlTelInput("getSelectedCountryData");
 var iso2 = countryData.iso2;
 iso2 = iso2.toUpperCase();
 jQuery.get( "https://learn.athena.edu/athenaprod/api/country/"+iso2, function( data ) {
  jQuery( "#country_code" ).val(data);

});


                if(msg == ''){

                        var URL_path = baseUrl.split(".");

                        if(URL_path.indexOf("websitestg") !== -1){
                            var URL = "https://agestagingapi.azurewebsites.net/Register/GetCheckuser/Email/"+c_email;
                        } else{
                            var URL = "https://athenawpapi.azurewebsites.net/Register/GetCheckuser/Email/"+c_email;
                        }

                        alert(URL);

                    jQuery.ajax({
   type: 'GET',
   url: URL, //Returns ID in body
   async: false, // <<== THAT makes us wait until the server is done.
   success: function(data){
       if (data == 'Email Exist') {
            var email_id = jQuery("#reg_email").val();
       var cid = jQuery("#reg_course").val();
                                var redirect = confirm("Email ID already registered, redirect to login page ?");
                                if (redirect == true) {
                                 // window.location.replace('https://ulearn.athena.edu/login?mail='+email_id+'&CId='+cid);
                                 window.location.replace(baseUrl + '/StudentEnroltoCourse?mail='+email_id+'&CId='+cid);
                                } else {
                                  return false;
                                }

                            } else {
                              jQuery("#registration_form22").click();;
                            }
                       return false;
   },
   error: function() {
       alert("Error Processing your request, please try again after some time")
       return FALSE;
   }
});

               return false;



                }else {

                    alert(msg)
                }

             });



           jQuery("#news-letter-subscribe").click(function() {
              var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
              if(!regex.test(jQuery('#newsletter-email-input').val())) {
                jQuery("#newsletter-info-box-error").html("Invalid Email id");
                jQuery("#newsletter-info-box-error").removeClass('hide');
                jQuery('#newsletter-info-box-error').css('display','inherit');
              }else{

                var mailinfo = {
                  'mail': jQuery('#newsletter-email-input').val(),
                  'type': 'newsletter'
                };

                jQuery.ajax(baseUrl + '/save/contact', {
                  type: 'POST',  // http method
                  contentType: "application/json; charset=utf-8",
                  dataType: "json",
                  data: JSON.stringify(mailinfo) ,  // data to submit
                   dataType: 'json',
                  success: function (data, status, xhr) {
                    console.log('success');
                  },
                  error: function (jqXhr, textStatus, errorMessage) {
                    if(jqXhr.status == 200) {
                      console.log('error');
                    }
                  }
                });

                initiateSendingMail('news-letter-subscribe', mailinfo);

                jQuery('#newsletter-info-box-error').css('display','none');
                jQuery("#newsletter-info-box").html("Subscribed Successfullly");
                jQuery('#newsletter-info-box').css('display','inherit');
                jQuery("#newsletter-info-box").removeClass('hide');
              }
           });




            jQuery("#speak_submit").click(function() {
                var msg = '';
                if(jQuery("#speak_first_name").val() == '') {
                    msg += '\n\u2022  First name cannot be empty';
                }
                if(jQuery("#speak_last_name").val() == '') {
                    msg += '\n\u2022  Last name cannot be empty';
                }
                if(jQuery("#speak_email").val() == '') {
                    msg += '\n\u2022  Email cannot be empty';
                }
                if(jQuery("#phone").val() == '') {
                    msg += '\n\u2022  Phone number cannot be empty';
                }

                if(!jQuery('#phone').val().match(/^[0-9]+$/)) {
                  msg += '\n\u2022  Phone number is invalid';
                }

                if(!jQuery("#speak_consent").prop('checked') == true){
                     msg += '\n\u2022 please accept consent terms';
                }

                if(msg == ''){
                   alert("Thank you for submitting the registration form. Will reach out to you shortly")
                }else {
                    jQuery('#speak_first_name').val("");
                    jQuery('#speak_last_name').val("");
                    jQuery('#speak_email').val("");
                    jQuery('#speak_country').val("");
                    jQuery('#speak_consent').prop('checked', false);
                    alert(msg)
                }
});
            jQuery('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                autoWidth: true,
                responsiveClass: true,
                responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                    margin: 20
                }
                }
            })


            jQuery(window).scroll(function() {
                if(jQuery(window).width() > 1249) {
                    if((jQuery(window).scrollTop() > jQuery(".course-login-wrapper").offset().top) &&
                    (jQuery(window).scrollTop() < (jQuery(".course-login-wrapper").offset().top + jQuery(".course-login-wrapper").height() -
                    jQuery(".testimonials").height() + 10))) {
                        jQuery(".testimonials").css("position", "fixed");
                        console.log("Yo");
                    } else {
                        jQuery(".testimonials").css("position", "static");
                    }
                }
            });


          jQuery(".academic-content .content--course")
            .slice(0, 3)
            .show();

          jQuery(".academic-content .content--course:hidden").css("opacity", 0);

          jQuery("#loadMore").on("click", function(e) {
            jQuery(".academic-content .content--course:hidden")
              .slice(0, 3)
              .slideDown("slow")
              .animate({
                opacity: 1
              }, {
                queue: false,
                duration: "slow"
              });
            if (jQuery(".academic-content .content--course:hidden").length == 0) {
              jQuery("#loadMore").hide();
              jQuery("#showLess").show();
            }
            e.preventDefault();
          });

          jQuery("#showLess").on("click", function(e) {
            jQuery(".academic-content .content--course:visible")
              .slice(3, 1000)
              .slideUp("slow")
              .animate({
                opacity: 1
              }, {
                queue: false,
                duration: "slow"
              });
              jQuery("#loadMore").show();
              jQuery("#showLess").hide();
              jQuery('html, body').animate({
                scrollTop: jQuery("#academic-content").offset().top
            });
            e.preventDefault();
          });

        });



function copy_to_clipboard() {
  /* Get the text field */
  var copyText = document.getElementById("shareurl--copy").innerHTML;
  var dummy = document.createElement('input');document.body.appendChild(dummy);dummy.value = copyText;
  /* Select the text field */
  dummy.select();
  dummy.setSelectionRange(0, 99999); /For mobile devices/

  /* Copy the text inside the text field */
  document.execCommand("copy");
  /* Alert the copied text */
  alert("Copied url to clipboard: ");
  document.body.removeChild(dummy);
}

function getUrlParameter(sParam) {
  var sPageURL = window.location.search.substring(1),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;

  for (i = 0; i < sURLVariables.length; i++) {
      sParameterName = sURLVariables[i].split('=');

      if (sParameterName[0] === sParam) {
          return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
      }
  }
}
