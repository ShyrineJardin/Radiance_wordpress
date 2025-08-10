(function ($, w, d, h, b) {

    const init = {

        mobileNav: function(){

            const burgerMenu =  $('.header__burgerMenu');
            const mobileNav = $('.mobileMenu');
            const mobileClose = $('.mobileMenu__close');

            burgerMenu.on('click',function(){
                mobileNav.toggleClass('open');
            });

            mobileClose.on('click',function(){
                mobileNav.removeClass('open');
            });
         
        },
        header: function(){

            const $header = $('.header');

            // for fixed header
            $(w).on('load scroll orientationchange', function () {
                const currentScroll = w.pageYOffset || d.documentElement.scrollTop;
                const offset = 0;
                
                if (currentScroll > offset) {
                    $header.addClass('header--fixed');
                } else {
                    $header.removeClass('header--fixed');
                }
            });


            // for double Tap
            $('.site-menu').navTabDoubleTap();

        }

    }

    $(document).ready(function () {
        init.mobileNav();
        init.header();
    });

    $(window).on('load', function () {


    })


})(jQuery, window, document, 'html', 'body');