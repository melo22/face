(function($){


$(function() {
        var $header = $('#top-head');
        // Nav Fixed
        $(window).scroll(function() {
            if ($(window).scrollTop() > 250) {
                //$header.addClass('fixed');
            } else {
              //  $header.removeClass('fixed');
            }
        });
        // Nav Toggle Button
        $('#nav-toggle').click(function(){
            $header.toggleClass('open');
        });
    });

$('.animated').on('inview', function(event, isInView) {
  $(this).addClass('slideInUp');
  $(this).css('opacity',1);
});
  $('section div').on('inview', function(event, isInView) {
    $(this).addClass('slideInUp');
    $(this).css('opacity',1);
  });

  $('.blog_section .animated').on('inview', function(event, isInView) {
    $(this).addClass('slideInUp');
    $(this).css('opacity',1);
  });
})(jQuery);
