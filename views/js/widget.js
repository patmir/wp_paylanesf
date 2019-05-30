(function($) {
  "use strict";
  jQuery(".paylane-sf-widget .paylane-sf-amount-button").click(function(e) {
    var $that = this;
    jQuery(".paylane-sf-widget .paylane-sf-amount-button.selected").each(
      function(e) {
        jQuery(this).removeClass("selected");
        if (
          jQuery(this).attr("type") == "number" &&
          jQuery($that).attr("type") != "number"
        ) {
          jQuery(this).val("");
        }
      }
    );
    jQuery(this).addClass("selected");
  });

  jQuery(".paylane-sf-widget-form").submit(function(e) {
    jQuery(".paylane-sf-widget-form button[type=submit]").addClass("loading");
    jQuery(".paylane-sf-widget-form button[type=submit]").attr(
      "disabled",
      "disabled"
    );
    e.preventDefault();
    var input = jQuery(".paylane-sf-widget .paylane-sf-amount-button.selected");
    var amountVar = 0.0;
    if (jQuery(input).attr("type") == "number") {
      amountVar = jQuery(input).val();
    } else {
      amountVar = jQuery(input).data("amount");
    }

    var data = {
      action: "paylane_sf_get_hash",
      amount: amountVar,
      source: window.location.href
    };
    jQuery.post(ajax_options.admin_ajax_url, data, function(response) {
      jQuery(".paylane-sf-widget-form button[type=submit]").removeClass(
        "loading"
      );
      jQuery(".paylane-sf-widget-form button[type=submit]").prop(
        "disabled",
        false
      );
      var formHtml = response;
      console.log(response);
      var parsedHtml = jQuery.parseHTML(formHtml);
      jQuery(parsedHtml)
        .appendTo("body")
        .submit();
    });
  });
})(jQuery);
