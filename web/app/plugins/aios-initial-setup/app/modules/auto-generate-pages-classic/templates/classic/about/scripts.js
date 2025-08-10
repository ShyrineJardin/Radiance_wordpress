;( function($, w, d, h, b) {
    var app = {
        ai_classic_testimonials: function () {
            var slides = $('.ai-classic-about-slides');

            if (slides.length) {
                slides.not('.slick-initialized').slick({
                    autoplay: true,
                    autoplaySpeed: 4000,
                    dots: false,
                    infinite: false,
                    speed: 300,
                    arrows: true,
                    fade: true,
                    cssEase: 'linear'
                });
            }
        },
        init: function() {
            this.ai_classic_testimonials();
        },
    };

    $(document).ready( function() {
        /* Initialize all app functions */
        app.init();
    });
})(jQuery, window, document, 'html', 'body');
