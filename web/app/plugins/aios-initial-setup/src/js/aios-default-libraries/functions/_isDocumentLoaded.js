/**
 * Alterative for jquery window onload
 * @param {fn} isLoaded = callback
 * @example
		document.load( () => {
			// code goes here
		} );
*/

Document.prototype.aiosLoad = isLoaded => {
	if( isLoaded && typeof isLoaded === 'function' ) {
		window.addEventListener("load", () =>  {
			if(document.readyState === "interactive" || document.readyState === "complete") {
				return isLoaded();
			}
		});
	}
};