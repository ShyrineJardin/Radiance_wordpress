(function ($, w, d, h, b) {

    const init = {

        sharer: function(){
            $('[data-sharer]').on('click', (e) => {
                let $this = $(e.currentTarget),
                    href = $this.attr('href'),
                    title = $this.data('title');

                if (!$this.hasClass('as-mailto')) {
                    e.preventDefault();

                    let newWindow = window.open(href, title, 'width=700,height=500');
                    newWindow.focus();
                }
            });
        }
    }


    $(document).ready(function () {
        
        init.sharer();
      
    });

    $(window).on('load', function () {

    })


})(jQuery, window, document, 'html', 'body');