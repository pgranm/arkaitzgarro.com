// Avoid `console` errors in browsers that lack a console.
(function() {
    'use strict';

    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
})();

$(document).ready(function() {

    // ==================== HEADER SIZE ==================== //
    var $navbar = $('.navbar'),
        opts = {
            height: '35px'
        },
        speed = 600;

    $(function(){
        $navbar.data('size','big');
    });

    $(window).scroll(function() {
        if($(document).scrollTop() > 0) {
            if($navbar.data('size') === 'big') {
                $navbar.data('size', 'small');
                $navbar.find('.logo img').stop().animate(opts, speed);
            }
        } else {
            if($navbar.data('size') === 'small') {
                $navbar.data('size', 'big');
                $navbar.find('.logo img').stop().animate({
                    height: '75px'
                }, speed);
            }
        }
    });

    // ==================== WOW ANIMATION DELAY ==================== //
    wow = new WOW({
        animateClass: 'animated',
        mobile: false,
        offset: 70
    });
    wow.init();

    // ==================== MASONRY ==================== //
    var $gallery = $('.gallery');
    $gallery.masonry({
        itemSelector: '.project'
    });

    // ==================== SCROLL ==================== //
    $('a[href*=#]:not([href=#])').click(function() {
        var $this = $(this),
            offset = $('body').data('offset');

        if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'')
            && location.hostname == this.hostname)
        {
            var target = $(this.hash);

            offset = (parseInt(target.offset().top) === offset)? offset : 105;
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: parseInt(target.offset().top) - parseInt(offset)
                }, 700);

                return false;
            }
        }
    });
});
