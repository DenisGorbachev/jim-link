(function ($) {

  if (typeof String.prototype.supplant === "undefined") {
    String.prototype.supplant = function(obj) {
      return this.replace(
        /{{?([^{}]*)}?}/g,
        function(a, b) {
          var r = obj[ $.trim(b) ];
          return typeof r === 'string' || typeof r === 'number' ? r : a;
        }
      );
    };
  }

  var hrefTpl = "<a href='{url}'>{url}</a>",
      successTpl = "<h3>{shrt}<br/><small>"+LANG._for+" {origin}</small></h3>",
      errorTpl = "<h4 class='error'>{error}</h4>",

      $shortenResult = $("#shortenResult");

  function a(href) {
    return hrefTpl.supplant({url: href})
  }

  function updateResult(tpl, data) {
    $shortenResult.html(tpl.supplant(data));
  }

  $("#shortenForm").submit(function (event) {
    event.preventDefault();
    var form = this,
        url = form.elements.url.value;
    $.post(this.action, {
      url: url
    }, function (result) {
      if (result.shrt) {
        updateResult(successTpl, {
          shrt: a(result.shrt),
          origin: a(url)
        });
        form.reset();
      }
      else if (result.error) {
        updateResult(errorTpl, result);
      }
      else {
        updateResult(errorTpl, {
          error: LANG.serviceIsUnavailable
        });
      }
    });
  });
})(jQuery);