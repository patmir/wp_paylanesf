(function($) {
  "use strict";
  jQuery("button.paylane_sf_amount_button").click(function(e) {
    jQuery("button.paylane_sf_amount_button.selected").each(function(e) {
      jQuery(this).removeClass("selected");
    });
    jQuery(this).addClass("selected");
  });

  jQuery(".paylane-sf-widget-form").submit(function(e) {
    jQuery(".paylane-sf-widget-form button[type=submit]").addClass("loading");
    jQuery(".paylane-sf-widget-form button[type=submit]").attr(
      "disabled",
      "disabled"
    );
    e.preventDefault();
    var data = {
      action: "paylane_sf_get_hash",
      amount: jQuery("button.paylane_sf_amount_button.selected").data("amount")
    };
    jQuery.post(ajax_options.admin_ajax_url, data, function(response) {
      jQuery(".paylane-sf-widget-form button[type=submit]").removeClass(
        "loading"
      );
      jQuery(".paylane-sf-widget-form button[type=submit]").attr(
        "disabled",
        ""
      );
      console.log(response);
      var formHtml = response;

      var parsedHtml = jQuery.parseHTML(formHtml);
      jQuery(parsedHtml)
        .appendTo("body")
        .submit();
    });
  });
})(jQuery);
