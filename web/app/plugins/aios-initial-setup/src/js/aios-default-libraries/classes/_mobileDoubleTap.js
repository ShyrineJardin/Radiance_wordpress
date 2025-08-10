/**
 * Allow hover to appear before going to redirecting to page
 * @param {Element} element accept element
 * @example
 let elements = document.querySelectorAll( '.sample' );
 for (let i=0; i<elements.length; i++) {
		new aiosResponsiveImages(elements[i]);
	}
 OR use class mobile-hover
 <a href="//www.agentimage.com" class="mobile-hover">AgentImage</a>
 */
export class aiosMobileDoubleTap {
	
	constructor( element ) {
		
		this.element = element;
		this.ctrlActive = false;
		
		/** Add default attributes */
		this.ready();
		
		/** Determine <a> state on touch gestures */
		this.element.addEventListener( 'touchstart', ( evt ) => {
			this.touchGesture( evt );
		});
		
		/** Determine <a> state on mouse gestures */
		this.element.addEventListener( 'mousedown', ( evt ) => {
			this.mouseGestures( evt );
		});
		
		/** listen to keydown */
		document.addEventListener( 'keydown', ( evt ) => {
			if ( evt.which == 17 ) this.ctrlActive = true;
		} );
		
		/** listen to keyup */
		document.addEventListener( 'keyup', ( evt ) => {
			if ( evt.which == 17 ) this.ctrlActive = false;
		} );
		
		/** Determine <a> behavior according to state */
		this.element.addEventListener( 'click', ( evt ) => {
			this.openUrl( evt, evt.target );
		});
		
		/** Reset classes and styles when <body> is clicked */
		document.body.addEventListener( 'click', ( evt ) => {
			this.reset();
		});
	}
	
	ready() {
		/** Add class to anchor <a> */
		this.element.className += ' mobile-anchor-pointer';
	}
	
	touchGesture( evt ) {
		
		evt.stopPropagation();
		
		/** Temporarily set <body>'s cursor style to pointer because iOS ignores click events on non-anchor elements */
		document.body.style.cursor = 'pointer';
		
		/** Temporarily set tap color to transparent to prevent flickering */
		document.body.style.webkitTapHighlightColor = 'transparent';
		
		/** Remove all classes from links that not trigger el */
		[].forEach.call( document.querySelectorAll( '.mobile-anchor-pointer' ), ( arrEvt, arrIndex ) => {
			arrEvt.addEventListener('click', () => {
				var elements = [...document.querySelectorAll('.mobile-anchor-pointer')];
				
				var otherElements = elements.filter( (element) => {
					return element !== arrEvt;
				});
				
				for (let i = 0; i < otherElements.length; i++)
					otherElements[i].classList.remove( 'mobile-anchor-redirect', 'mobile-anchor-active', 'mobile-anchor-touchstart' );
			});
		});
		
		
		/** Add touch gesture class */
		evt.target.classList.add( 'mobile-anchor-touchstart' );
		
		/** Mark for redirection on second tap if submenus are detected */
		if ( evt.target.classList.contains( 'mobile-anchor-active' ) ) {
			evt.target.classList.add( 'mobile-anchor-redirect' );
			return;
		}
		
		/** Mark as active on first tap */
		evt.target.classList.add( 'mobile-anchor-active' );
	}
	
	mouseGestures( evt ) {
		if ( !evt.target.classList.contains( 'mobile-anchor-touchstart' ) ) evt.target.classList.add( 'mobile-anchor-redirect' );
	}
	
	openUrl( evt, a ) {
		evt.preventDefault();
		evt.stopPropagation();
		
		if ( evt.target.classList.contains( 'mobile-anchor-redirect' ) && !evt.target.classList.contains( 'aios-initial-setup-dead-link' ) ) {
			let url = a.getAttribute( 'href' );
			let target = a.getAttribute( 'target' ) === null ? '_self' : a.getAttribute( 'target' ) ;
			
			if ( url != null || url != '#' ) {
				return false;
			} else {
				if ( this.ctrlActive ) {
					target = '_blank';
				}
				
				window.open( url, target );
			}
		}
	}
	
	reset() {
		document.body.style.cursor = 'auto';
		document.body.style.webkitTapHighlightColor = 'inherit';
		this.element.classList.remove( "mobile-anchor-redirect", "mobile-anchor-active", "mobile-anchor-touchstart" );
	}
	
}
