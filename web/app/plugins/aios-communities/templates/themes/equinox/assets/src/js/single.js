( function ( $, w, d, h, b ) {

	var app = {
        tab: function() {
            var sticky = new Sticky( '.community-tabs-sticky' ),
                communityAtag = $( '.community-tabs ul li button' ),
                headfix = $( 'header.header' )

            communityAtag.on( 'click', function() {
                var id = $( this ).attr( 'data-id' )

                $( 'html, body' ).animate( {
                    scrollTop: $( '.community-entry-content[data-id=' + id + ']' ).offset().top - 120
                }, 400 );
            } )
        },
        contentObserver: function() {
            var observer = new IntersectionObserver( function ( entries, observer ) {
                entries.forEach( function ( entry ) {
                    if ( entry.isIntersecting ) {
                        var id = $( entry.target ).attr( 'data-id' )

                        $( '.community-tabs ul li button' ).removeClass( 'tab-active' )
                        $( '.community-tabs ul li button[data-id=' + id + ']' ).addClass( 'tab-active' )
                    }
                })
            }, {
                threshold: .5
            })
            
            $( ".community-entry-content.entry-not-hidden" ).each( function () {
                observer.observe( this )
            } )
        },
		init: function() {
            this.tab()
            this.contentObserver()
        }
    }

    $( document ).ready( function () {
        app.init()
    } )

} )( jQuery, window, document, 'html', 'body' )