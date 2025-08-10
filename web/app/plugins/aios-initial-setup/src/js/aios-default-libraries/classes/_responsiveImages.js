export class aiosResponsiveImages {
	
	constructor( element ) {
		this.element = element;
		this.src = '';
		this.defaultSrc = this.element.getAttribute( 'data-bg-src' );
		this.regexRemoveSpaces = /[\s\t]+/g;
		this.regexGetImageUrlFromString = /(http)?s?:?(\/\/[^"']*\.(?:png|jpg|jpeg|gif|png|svg))/g;
		this.viewportWidth = window.innerWidth;
		
		this.ready();
	}
	
	ready() {
		let src = this.element.getAttribute( 'data-bg-srcset' );
		this.update( src.split( ',' ) );
	}
	
	update( srcArr ) {
		if ( Array.isArray( srcArr ) ){
			/** Reverse Array */
			srcArr = srcArr.reverse();
			let renderImageUri;
			
			/** Loop to check less than */
			for (let i = 0; i < srcArr.length; i++) {
				let string 		= srcArr[i];
				string 		= string.replace( this.regexRemoveSpaces, '' );
				let viewport 	= string.replace( this.regexGetImageUrlFromString, '' );
				viewport 	= viewport.replace( 'w', '' );
				const imageUri 	= string.match( this.regexGetImageUrlFromString );
				
				if ( this.viewportWidth <= viewport ) {
					renderImageUri = imageUri;
					break;
				}
			}
			
			this.render( renderImageUri );
		}
	}
	
	render( imageUri ) {
		let image = this.defaultSrc;
		
		/** If undefined whos width is less than the image width */
		if ( imageUri !== undefined ) image = imageUri;
		
		/** Add style to element */
		this.element.style.backgroundImage = `url("${image}")`;
	}
	
}
