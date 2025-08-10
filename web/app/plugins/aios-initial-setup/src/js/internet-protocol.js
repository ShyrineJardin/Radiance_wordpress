( function($) {
	$( document ).ready( function() {

		/** NOTE: window.RTCPeerConnection is "not a constructor" in FF22/23 **/
		var RTCPeerConnection = /*window.RTCPeerConnection ||*/ window.webkitRTCPeerConnection || window.mozRTCPeerConnection;

		function __construct() {
			if ( RTCPeerConnection ) {
				success_to_connect();
			} else {
				failed_to_connect();
			}
		}

		function success_to_connect() {
			var rtc = new RTCPeerConnection({iceServers:[]});
			if (1 || window.mozRTCPeerConnection) {      /** FF [and now Chrome!] needs a channel/stream to proceed **/
				try {
					rtc.createDataChannel('', {reliable:false});
				} catch (e) {}
			};
			
			rtc.onicecandidate = function (evt) {
				/** convert the candidate to SDP so we can run it through our general parser **/
				/** see https:/**twitter.com/lancestout/status/525796175425720320 for details **/
				if (evt.candidate) grepSDP("a="+evt.candidate.candidate);
			};
			rtc.createOffer(function (offerDesc) {
				grepSDP(offerDesc.sdp);
				rtc.setLocalDescription(offerDesc);
			}, function (e) { console.warn("offer failed", e); });
			
			
			var addrs = Object.create(null);
			addrs["0.0.0.0"] = false;

			function updateDisplay(newAddr) {
				if (newAddr in addrs) return;
				else addrs[newAddr] = true;
				var displayAddrs = Object.keys(addrs).filter(function (k) { return addrs[k]; }),
					localipAddrs = displayAddrs.join(" or perhaps ") || "n/a";

				var date = new Date();
					date.setTime( date.getTime() + (31 * 24 * 60 * 60 * 1000) );
				var expires = "; expires=" + date.toUTCString();
					document.cookie = 'aioswp_6c6f63616c2d69702d61646472657373=TmVxdWUgcG9ycm8gcXVpc3F1YW0gZXN0IHF1aSBkb2xvcmVt' + localipAddrs + expires + "; path=/";

				$('.aios-server-data-local-ip span').text( localipAddrs.slice(0, 15) );

			}
			
			function grepSDP(sdp) {
				var hosts = [];
				sdp.split('\r\n').forEach(function (line) { /** c.f. http:/**tools.ietf.org/html/rfc4566#page-39 **/
					if (~line.indexOf("a=candidate")) {     /** http:/**tools.ietf.org/html/rfc4566#section-5.13 **/
						var parts = line.split(' '),        /** http:/**tools.ietf.org/html/rfc5245#section-15.1 **/
							addr = parts[4],
							type = parts[7];
						if (type === 'host') updateDisplay(addr);
					} else if (~line.indexOf("c=")) {       /** http:/**tools.ietf.org/html/rfc4566#section-5.7 **/
						var parts = line.split(' '),
							addr = parts[2];
						updateDisplay(addr);
					}
					else {
						$('.aios-server-data-local-ip span').text("Unavailable");
					}
				});
			}
		}

		function failed_to_connect() {
			$('.aios-server-data-local-ip span').text( "Unavailable" );
		}

		/** Instantiate **/
		__construct();

	} );
} )( jQuery );