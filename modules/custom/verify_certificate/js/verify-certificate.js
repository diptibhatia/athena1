(function ($) {
    Drupal.behaviors.verifyCertBehavior = {
      attach: function (context, settings) {
        document.getElementById("copy-btn").addEventListener("click", function(){
          CopyToClipboard("copy-text");
        });
      }
    };
    function CopyToClipboard(id) {
      var r = document.createRange();
      r.selectNode(document.getElementById(id));
      window.getSelection().removeAllRanges();
      window.getSelection().addRange(r);
      document.execCommand('copy');
      window.getSelection().removeAllRanges();
      alert("Link copied to clipboard!");
    }
  }
) (jQuery);