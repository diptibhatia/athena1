
        jQuery(document).ready(function() {
            jQuery("#phone").intlTelInput();
            jQuery("#get_in_touch_mobile").intlTelInput();
            jQuery("#contact_form_phone").intlTelInput();

            var search_url = 'http://website.athena.edu/search-results/abc?univ=';
            jQuery("#partner_search" ).change(function() {
              var partner =  jQuery("#partner_search").val();
              var search_key =  jQuery("#search_key").val();
              var lang =  jQuery("#language_search").val();
              var level =  jQuery("#level_search").val();
              var duration =  jQuery("#duration_search").val();
              window.location= search_url + partner + '&lang=' +lang+ +'&level=' +level+ '&duration='+duration;
            });
            jQuery("#language_search" ).change(function() {
              var partner =  jQuery("#partner_search").val();
              var search_key =  jQuery("#search_key").val();
              var lang =  jQuery("#language_search").val();
              var level =  jQuery("#level_search").val();
              var duration =  jQuery("#duration_search").val();
              window.location= search_url + partner + '&lang=' +lang+ +'&level=' +level+ '&duration='+duration;
            });
            jQuery("#level_search" ).change(function() {
              var partner =  jQuery("#partner_search").val();
              var search_key =  jQuery("#search_key").val();
              var lang =  jQuery("#language_search").val();
              var level =  jQuery("#level_search").val();
              var duration =  jQuery("#duration_search").val();
              window.location= search_url + partner + '&lang=' +lang+ +'&level=' +level+ '&duration='+duration;
            });
            jQuery("#duration_search" ).change(function() {
              var partner =  jQuery("#partner_search").val();
              var search_key =  jQuery("#search_key").val();
              var lang =  jQuery("#language_search").val();
              var level =  jQuery("#level_search").val();
              var duration =  jQuery("#duration_search").val();
              window.location= search_url + partner + '&lang=' +lang+ +'&level=' +level+ '&duration='+duration;
            });

            jQuery("#get_in_touch").click(function() {
                 var msg = '';
                if(jQuery("#get_in_touch_fname").val() == '') {
                    msg += '\n\u2022  First name cannot be empty';
                }
                if(jQuery("#get_in_touch_lname").val() == '') {
                    msg += '\n\u2022  Last name cannot be empty';
                }
                if(jQuery("#get_in_touch_email").val() == '') {
                    msg += '\n\u2022  Email cannot be empty';
                }
                                 var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(jQuery("#get_in_touch_email").val())) {
    msg += '\n\u2022  Invalid Email id';
  }
  if(!jQuery("#get_in_touch_consent").prop('checked') == true){
                     msg += '\n\u2022 please accept consent terms';
                }

                if(jQuery("#phone").val() == '') {
                    msg += '\n\u2022  Phone number cannot be empty';
                }

                if(!jQuery('#phone').val().match(/^[0-9]+$/)) {
                  msg += '\n\u2022  Phone number is invalid';
                }

                if(jQuery("#get_in_touch_mobile").val() == '') {
                    msg += '\n\u2022  Phone number cannot be empty';
                }

                if(msg =='') {
                    jQuery('#get_in_touch_course').val("");
                    jQuery('#get_in_touch_fname').val("");
                    jQuery('#get_in_touch_lname').val("");
                    jQuery('#get_in_touch_email').val("");
                    jQuery('#get_in_touch_mobile').val("");
                    //jQuery('#get_in_touch_consent').val("");
                    jQuery('#get_in_touch_consent').prop('checked', false);
                    alert("Thank you!! we'll get in touch with you shortly");

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
Yearsofexperience:parseInt(jQuery("#reg_exp").val()),
Monthofexperience:parseInt(jQuery("#reg_months").val()),
IsAccepted:true,
Employmentlevel:String(jQuery("#reg_level").val())
       };
       
       var email_id = jQuery("#reg_email").val();
       var cid = jQuery("#reg_course").val();

jQuery.ajax('https://athenawpapi.azurewebsites.net/Register/SaveLead', {
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
                             window.location.replace('http://ulearn.athena.edu/login?mail='+email_id+'&CId='+cid);
                            } else {
                              //txt = "You pressed Cancel!";
                            }

                                }
                        }
                    });



             });

             jQuery("#registration_form").click(function() {
                var msg = '';
                var c_email = jQuery("#reg_email").val();
                if(jQuery("#reg_first_name").val() == '') {
                    msg += '\n\u2022  First name cannot be empty';
                }
                if(jQuery("#reg_last_name").val() == '') {
                    msg += '\n\u2022  Last name cannot be empty';
                }
                if(jQuery("#reg_email").val() == '') {
                    msg += '\n\u2022  Email cannot be empty';
                }
                if(jQuery("#reg_country").val() == '') {
                    msg += '\n\u2022  please select country';
                }
                 var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(jQuery("#reg_email").val())) {
    msg += '\n\u2022  Invalid Email id';
  }
                if(jQuery("#phone").val() == '') {
                    msg += '\n\u2022  Phone number cannot be empty';
                }

                if(!jQuery('#phone').val().match(/^[0-9]+$/)) {
                  msg += '\n\u2022  Phone number is invalid';
                }

                 if(jQuery("#reg_qual").val() == '') {
                    msg += '\n\u2022  please select Qualification';
                }
                 if(jQuery("#reg_exp").val() == '') {
                    msg += '\n\u2022  Enter experience field';
                }
                if(jQuery("#reg_months").val() == '') {
                    msg += '\n\u2022  Enter Months field';
                }
                 if(jQuery("#reg_level").val() == '') {
                    msg += '\n\u2022  Please select Level of employment';
                }

                if(!jQuery("#reg_terms").prop('checked') == true){
                     msg += '\n\u2022 please accept consent terms';
                }
 
                    

                if(msg == ''){
                    
                   jQuery.get( "https://athenawpapi.azurewebsites.net/Register/GetCheckuser/Email/"+c_email, function( data ) {
                            if (data == 'Email Exist') {
                                var redirect = confirm("Email ID already registered, redirect to login page ?");
                                if (redirect == true) {
                                 window.location.replace('http://ulearn.athena.edu/login?mail='+email_id+'&CId='+cid);
                                } else {
                                  return FALSE;
                                }
                               
                            } else {
                              //txt = "You pressed Cancel!";
                            }
                       return FALSE;
                    });
                    
                    
                    var countryData = jQuery("#phone").intlTelInput("getSelectedCountryData");
 var iso2 = countryData.iso2;
 iso2 = iso2.toUpperCase();
 jQuery.get( "https://learn.athena.edu/athenaprod/api/country/"+iso2, function( data ) {
  jQuery( "#country_code" ).val(data);
  
});
                      jQuery("#registration_form22").click();;
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
