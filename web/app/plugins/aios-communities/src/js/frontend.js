(function ($) {
    var app = {
        mobile_width: 991,
        init: function () {
            this.pagination();
            this.viewMoreListings();
            this.scrollTo();
            if (typeof AOS !== 'undefined' && typeof AOS.init === 'function') {
                AOS.init();
            }
        },
        pagination: function(){
            let $prev = $('.aios-communities-prev');
            let $next = $('.aios-communities-next');


            if ($prev) {
                $prev.parent().addClass('aios-communitiesPrev');
            }

            if ($next) {
                $next.parent().addClass('aios-communitiesNext');
            }

        },

        scrollTo: function () {
            
            let anchor = $(".aios-communities-scroll-to");
            let listingsWrapper = anchor.attr('href');

            if ($(listingsWrapper)) {
                anchor.click(function (e) {
                    e.preventDefault();

                    target = $(this).attr('href');

                    $('html, body').animate({
                        scrollTop: $(target).offset().top - 150
                    }, 1000);
                });
            }
            
        },
        viewMoreListings: function () {
            
            // Select the div you want to move using querySelector
            let divToMove = document.querySelector('.aios-community-bttn');

            // Select the element with the specific class before which you want to move the div
            let targetElement = document.querySelector('.aios-custom-ihomefinder-shortcode-template');
            let targetElement2 = document.querySelector('#listings-results');

            if (divToMove && targetElement) {
                // Move the div before the target element
                targetElement.parentNode.insertBefore(divToMove, targetElement);
            } else { 
                if (divToMove && targetElement2) {
                    // Move the div before the target element
                    targetElement2.parentNode.insertBefore(divToMove, targetElement2);
                }
            }
        
            
        }
    };

    $(document).ready(function () {
        app.init();
    });

    $(window).on('resize', function () {

    });

})(jQuery);