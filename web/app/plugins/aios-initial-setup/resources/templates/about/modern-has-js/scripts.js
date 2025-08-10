;(function ($, w, d, h, b) {

    var app = {
        aos: function () {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    disable: 'mobile',
                    once: true
                });
            }
        },
        testimonials: function () {
            var slides = $('.ai-modern-about-testi-slider');

            // initialized slick slider
            if (slides.length) {
                slides.not('.slick-initialized').slick({
                    dots: false,
                    fade: true,
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    prevArrow: '.ai-modern-about-testi-prev',
                    nextArrow: '.ai-modern-about-testi-next',
                });
            }
        },
        init: function () {
            this.aos();
            this.testimonials();
        }
    };

    $(document).ready(function () {
        /* Initialize all app functions */
        app.init();
    });

    /**
     *
     * Please do add your custom script functions similar to the current file structure.
     * You may also add your uncategorized script functions inside the `app.others` function.
     *
     */
})(jQuery, window, document, 'html', 'body');
