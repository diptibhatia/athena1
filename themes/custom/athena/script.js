(function($) {
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
  }(jQuery));

// jQuery(".selected-flag").after("<div class='country-code' />");
// jQuery('.iti__flag-container').remove();

function initiateSendingMail(form_id, mailinfo) {
  var dataObj = {
    'form_id': form_id,
    'info': mailinfo
  };
  jQuery.ajax(baseUrl + '/send/mail', {
      type: 'POST',
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      data: JSON.stringify(dataObj) ,
      dataType: 'json',
      success: function (data, status, xhr) {
        console.log(data);
      },
      error: function (jqXhr, textStatus, errorMessage) {
        console.log(jqXhr);
      }
  });
}

jQuery(document).ready(function() {

    jQuery(".mat-expansion-panel .mat-expansion-panel-header").click(function(){
        jQuery(this).toggleClass("mat-expanded");
        jQuery(this).siblings(".mat-panel-content").slideToggle();
      });
      //Switch tab in reg page based on course
      let type = getURLParameterByName("type");
      if(type == "cert") {
        jQuery('ul.nav a[href="' + '#uc' + '"]').tab('show');
      } else if(type == "acad") {
        jQuery('ul.nav a[href="' + '#ac' + '"]').tab('show');
      }
    // Typing effect in home page - starts here.
    // https://css-tricks.com/snippets/css/typewriter-effect/
    var TxtType = function(el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 2000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };

    TxtType.prototype.tick = function() {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];

        if (this.isDeleting) {
        this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
        this.txt = fullTxt.substring(0, this.txt.length + 1);
        }

        this.el.innerHTML = '<span class="typewrite-wrap">'+this.txt+'</span>';

        var that = this;
        var delta = 200 - Math.random() * 100;

        if (this.isDeleting) { delta /= 2; }

        if (!this.isDeleting && this.txt === fullTxt) {
        delta = this.period;
        this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
        this.isDeleting = false;
        this.loopNum++;
        delta = 500;
        }

        setTimeout(function() {
        that.tick();
        }, delta);
    };

    var elements = document.getElementsByClassName('typewrite');
    for (var i=0; i<elements.length; i++) {
        var toRotate = elements[i].getAttribute('data-type');
        var period = elements[i].getAttribute('data-period');
        if (toRotate) {
          new TxtType(elements[i], JSON.parse(toRotate), period);
        }
    }
    // INJECT CSS
    var css = document.createElement("style");
    css.type = "text/css";
    css.innerHTML = ".typewrite > .typewrite-wrap { border-right: 0.08em solid #ff026f}";
    document.body.appendChild(css);
    // Typing effect in home page - ends here.
    // Search by enter key in shaort course page
    jQuery("#search").keyup(function(event) {
      if (event.keyCode === 13) {
          $(".search-btn").click();
      }
    });
    var telConfig = {
      initialCountry: "auto",
      geoIpLookup: function(success, failure) {
        jQuery.ajax({
            url: 'https://api.ipdata.co/?api-key=87a4372ec9b7336f78f3b3551e7410d213ef86d45f7c266c0fefa137',
            type: 'GET',
            success: function (resp) {
                // console.log(resp);
                var countryCode = (resp && resp.country_code) ? resp.country_code : "in";
                // console.log(countryCode);
                success(countryCode.toLowerCase());
            },
            async: false
        });
      },
      separateDialCode: true
    }
    let ciso = getURLParameterByName("ciso");
    if(ciso !== null) {
      console.log("ciso");
      telConfig = {
        initialCountry: atob(ciso),
        separateDialCode: true
      };
    }
    jQuery("#phone").intlTelInput(telConfig);
    jQuery(".ac-form #phone").intlTelInput(telConfig);
    jQuery(".pc-form #phone").intlTelInput(telConfig);

    jQuery(".ac-form #phone").inputFilter(function(value) {
      return /^\d*$/.test(value);
     });
    jQuery('.pc-form #phone').attr('maxlength', 15);

    jQuery(".pc-form #phone").inputFilter(function(value) {
      return /^\d*$/.test(value);
     });
    jQuery('.pc-form #phone').attr('maxlength', 15);


    jQuery("#phone").inputFilter(function(value) {
        return /^\d*$/.test(value);
    });
    jQuery('#phone').attr('maxlength', 15);

    // if (jQuery(".country-code").length == 0) {
    //     jQuery(".selected-flag").after("<div class='country-code' />");
    //     jQuery(".country-code").text("+1");
    // }

    // jQuery(".country-list li").on('click', function(){
    //     jQuery(".country-code").text("+" + jQuery(this).attr('data-dial-code'));
    // });

    // if (jQuery(".country-code").length > 0) {
    //     jQuery.get('https://api.ipdata.co/?api-key=87a4372ec9b7336f78f3b3551e7410d213ef86d45f7c266c0fefa137', function(data) {
    //         var countrycode = data.country_code2;
    //         countrycode = countrycode.toLowerCase();

    //         var element = document.getElementsByClassName("selected-flag")[0];
    //         element.dispatchEvent(new Event("click"));
    //         jQuery("li.country[data-country-code='" + countrycode +
    //         "']").trigger('click');

    //         var element = document.getElementsByClassName("selected-flag")[1];
    //         element.dispatchEvent(new Event("click"));
    //         jQuery("li.country[data-country-code='" + countrycode +
    //         "']").trigger('click');


    //         window.scrollTo(0, 0);
    //     });
    // }
});

jQuery(document).on("click", ".country-list li", function(event) {
    event.preventDefault();
    jQuery(".country-code").text("+" + jQuery(this).attr('data-dial-code'));
});

function scrollEvent(){
    jQuery(function(){
        var stopFloating = jQuery('.stopScroll');
        if (stopFloating.length > 0) {
            var stop = stopFloating.offset().top;
            jQuery(document).scroll(function() {
                var y = jQuery(window).scrollTop(),
                header = jQuery(".share-icon div");
                if(y <= stop-500)  {
                    header.css({display: "block"});
                header.css({position: "fixed"});
                } else {
                    header.css({display: "none"});
                }
            });
        }
    });
}

window.onload = scrollEvent();

function getURLParameterByName(name, url = window.location.href) {
  name = name.replace(/[\[\]]/g, '\\$&');
  var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, ' '));
}