$(document).ready(function() {

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

    $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'')
            && location.hostname == this.hostname)
        {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: parseInt(target.offset().top) - $('.navbar').height()
                }, 700);

                return false;
            }
        }
    });
});
