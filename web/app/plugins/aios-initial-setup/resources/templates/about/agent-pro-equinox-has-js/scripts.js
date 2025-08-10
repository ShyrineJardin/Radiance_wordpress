;( function($, w, d, h, b) {
    var about = {

        sticky: function(){


            let sticky = new Sticky('.ip-equinox-about__photo--wrap');

        },


        init: function() {
            this.sticky();
        },
    };

    $(document).ready( function() {
        about.init();
    });
})(jQuery, window, document, 'html', 'body');
