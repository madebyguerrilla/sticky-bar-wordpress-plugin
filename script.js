(function($){
  $.fn.extend({
    stickyalert: function(options) {
        var defaults = {
            barColor: '#000',
            barFontColor: '#FFF',
            barFontSize: '1.1rem',
            barText: 'Welcome to my website',
            barTextLink: '',
        };
        var options = $.extend(defaults, options);
        return this.each(function() {
          $('<div class="alert-box" style="background-color:' + options.barColor + '"><a href="' + options.barTextLink + '" style="color:' + options.barFontColor + '; font-size:' + options.barFontSize + '" target="_blank">' + options.barText + '</a><a href="" class="close">&#10006;</a></div>').appendTo(this);
          $(".alert-box").delegate("a.close", "click", function(event) {
            event.preventDefault();
            $(this).closest(".alert-box").fadeOut(function(event){
              $(this).remove();
            });
          });
        });
      }
  });
})(jQuery);