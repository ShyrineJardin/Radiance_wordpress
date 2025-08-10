import { aiosAddStylesheetRules } from './aios-default-libraries/classes/_addStylesheetRules'
import { aiosMobileDoubleTap } from './aios-default-libraries/classes/_mobileDoubleTap'
import { aiosResponsiveImages } from './aios-default-libraries/classes/_responsiveImages'

import './aios-default-libraries/functions/_isDocumentLoaded'
import './aios-default-libraries/functions/_isDocumentReady'

document.aiosReady(() => {
  let elements = document.querySelectorAll( '.responsive-background-image' );
  for (let i=0; i<elements.length; i++) {
    let hasClass = elements[i].className;
    hasClass = hasClass.split( ' ' );
    if ( hasClass.indexOf( 'lazyloaded' ) > 0 ) {
      document.aiosLoad( () => {
        setTimeout(() => {
          new aiosResponsiveImages(elements[i]);
        }, i * 100);
      } );
    } else {
      new aiosResponsiveImages(elements[i]);
    }
  }
});

document.aiosReady(() => {
  let elements = document.querySelectorAll('.mobile-hover');
  for (let i=0; i<elements.length; i++) {
    new aiosMobileDoubleTap(elements[i]);
  }
});

/** Add style rules */
new aiosAddStylesheetRules([
  ['.mobile-hover',
    ['-webkit-user-select', 'none'],
    ['-webkit-touch-callout', 'none']
  ]
]);
