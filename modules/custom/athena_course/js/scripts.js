
        jQuery(document).ready(function() {
            jQuery("#phone").intlTelInput();
            jQuery("#get_in_touch_mobile").intlTelInput();
            jQuery("#contact_form_phone").intlTelInput();
            
            
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
                
  
  
                if(jQuery("#get_in_touch_mobile").val() == '') {
                    msg += '\n\u2022  Phone number cannot be empty';
                }
                
                if(msg =='') {
                    alert("Thank you!! we'll get in touch with you shortly")
                    
                }else {
                    
                    alert(msg)
                }
            });
             jQuery("#registration_form").click(function() {
                 
                 
                var msg = '';
                if(jQuery("#reg_first_name").val() == '') {
                    msg += '\n\u2022  First name cannot be empty';
                }
                if(jQuery("#reg_last_name").val() == '') {
                    msg += '\n\u2022  Last name cannot be empty';
                }
                if(jQuery("#reg_email").val() == '') {
                    msg += '\n\u2022  Email cannot be empty';
                }
                 var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(jQuery("#reg_email").val())) {
    msg += '\n\u2022  Invalid Email id';
  }
                if(jQuery("#reg_mobile_num").val() == '') {
                    msg += '\n\u2022  Phone number cannot be empty';
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
                 if(jQuery("#reg_pass").val() == '') {
                    msg += '\n\u2022  Please Enter password';
                }
                 if(jQuery("#reg_confirm_pass").val() == '') {
                    msg += '\n\u2022 please confirm pass';
                }
                
                if(jQuery("#reg_pass").val() !== jQuery("#reg_confirm_pass").val()){
                     msg += '\n\u2022 password and confirm password do not match'; 
                }

                if(!jQuery("#reg_terms").prop('checked') == true){
                     msg += '\n\u2022 please accept consent terms';
                }
                
                if(msg == ''){
                    var sendInfo = {
           UserName: String(jQuery("#reg_email").val()),
Password:String(jQuery("#reg_pass").val()),
FirstName:String(jQuery("#reg_first_name").val()),
LastName:String(jQuery("#reg_last_name").val()),
Email:String(jQuery("#reg_email").val()),
CountryId:99,
ContactNo:String(jQuery("#reg_mobile_num").val()),
CourseId:1,
Highestqualification:String(jQuery("#reg_qual").val()),
Yearsofexperience:parseInt(jQuery("#reg_exp").val()),
Monthofexperience:parseInt(jQuery("#reg_months").val()),
IsAccepted:true,
Employmentlevel:String(jQuery("#reg_level").val())
       };
       
jQuery.ajax('https://agestagingapi.azurewebsites.net/Register/SaveLead', {
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
                             window.location.replace("http://portal.athena.edu/login");
                            } else {
                              //txt = "You pressed Cancel!";
                            }  
                                    
                                }
                        }
                    });
       
       
       
       
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
                if(jQuery("#speak_first_name").val() == '') {
                    msg += '\n\u2022  Phone number cannot be empty';
                }
                 if(jQuery("#speak_country").val() == '') {
                    msg += '\n\u2022  Country cannot be empty';
                }
                 if(jQuery("#speak_mobile_number").val() == '') {
                    msg += '\n\u2022  Phone number cannot be empty';
                }
                if(!jQuery("#speak_consent").prop('checked') == true){
                     msg += '\n\u2022 please accept consent terms';
                }
                
                if(msg == ''){
                    alert("Data Submitted, will reach out to you shortly")
                }else {
                    
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
            })
        })
