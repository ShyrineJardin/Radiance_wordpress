( function ( $, w, d, h, b ) {

	var app = {
        videop: function() {
            var container = $( '.community-banner-image' ),
                player = $( '#cfa-player' ),
                playbtn = $( '.cfa-playbtn' ),
                pausebtn = $( '.cfa-pausebtn' ),
                mutedbtn = $( '.cfa-mutedbtn' ),
                volumebtn = $( '.cfa-volumebtn' ),
                videoVolume = function () {
                    if ( player.prop('muted') ) {
                        player.prop('muted', false);
                    } else {
                        player.prop('muted', true);
                    }
                }

            playbtn.on( 'click', function() {
                container.toggleClass('is-pause')
                player[0].play()
            } )
            
            pausebtn.on( 'click', function() {
                container.toggleClass('is-pause')
                player[0].pause()
            } )
            
            mutedbtn.on( 'click', function() {
                container.toggleClass('is-muted')
                videoVolume()
            } )
            
            volumebtn.on( 'click', function() {
                container.toggleClass('is-muted')
                videoVolume()
            } )
        },
		init: function() {
            this.videop()
        }
    }

    $( document ).ready( function () {
        app.init()
    } )

} )( jQuery, window, document, 'html', 'body' )