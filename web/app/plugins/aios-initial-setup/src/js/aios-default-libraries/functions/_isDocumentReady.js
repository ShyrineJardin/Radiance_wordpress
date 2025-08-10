/**
 * Alterative for jquery document ready
 * @param {fn} isReady = callback
 * @example
		document.aiosReady( () => {
			// code goes here
		} );
*/

Document.prototype.aiosReady = isReady => {
	if( isReady && typeof isReady === 'function' ) {
		document.addEventListener("DOMContentLoaded", () =>  {
			if(document.readyState === "interactive" || document.readyState === "complete") {
				return isReady();
			}
		});
	}
};