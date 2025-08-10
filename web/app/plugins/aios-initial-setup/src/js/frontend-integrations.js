document.addEventListener( "DOMContentLoaded", ( event ) => {
    document.querySelectorAll( ".aios-rs-listings" ).forEach(( eL ) => {
        const totalListingsPerPage = 6,
            limit = parseInt( eL.getAttribute( 'data-limit' ) ),
            appendId = eL.getAttribute( 'data-append' )

        let listingItems = []

        const observer = new MutationObserver( ( mutationsList ) => {
            const numberOfListingsOfCurrentPage = eL.querySelectorAll( '.listing-item' ).length
            let currentListingCount = 0

            mutationsList.forEach( (mutation) => {
                mutation.addedNodes.forEach( ( addedNode ) => {

                    // Check if addedNode is an element
                    if ( addedNode instanceof HTMLElement ) {
                        if (
                            addedNode.classList.contains( 'listing-item')
                            && addedNode.querySelector('img')
                            && listingItems.length < limit
                        ) {
                            const next = eL.querySelector('.pagination-next'),
                                features = addedNode.querySelector('.listing-features').textContent,
                                address = addedNode.querySelector( '.listing-address' ).textContent,
                                splitAddress = address.split(',') ?? '',
                                fullAddress = address.trim() ?? '',
                                street = splitAddress[0].trim() ?? '',
                                city = splitAddress[1].trim() ?? '',
                                zipCode = splitAddress[2].trim() ?? ''

                            let beds = "",
                                baths = "",
                                area = ""

                                features.split('|').forEach((v, i) => {
                                if (v !== "") {
                                    const textContent = v.trim()

                                    if ( textContent.includes( 'Bed' )  )  {
                                        beds = textContent
                                    } else if ( textContent.includes( 'Bath' )  )  {
                                        baths = textContent
                                    } else if ( textContent.includes( 'Sqft' )  || textContent.includes( 'Sqm' ) ) {
                                        area = textContent
                                    }
                                }
                            })

                            // Query the details to array
                            listingItems.push({
                                fullAddress,
                                street,
                                city,
                                zipCode,
                                beds,
                                baths,
                                area,
                                price: addedNode.querySelector( '.listing-price' ).textContent,
                                permalink: addedNode.querySelector( 'a' ).getAttribute( 'href' ),
                                image: addedNode.querySelector( 'img' ).getAttribute( 'src' ),
                            })

                            // The actual number of listings currently
                            currentListingCount++

                            // Disconnect and append ID if it reach the limit
                            if ( listingItems.length === limit ) {
                                disconnectToAppendToId( appendId, listingItems )
                            } else {
                                // Ensures listing count matches the current count but differs from expected per page.
                                // Stop observing
                                if ( numberOfListingsOfCurrentPage !== totalListingsPerPage && numberOfListingsOfCurrentPage === currentListingCount ) {
                                    disconnectToAppendToId( appendId, listingItems )
                                }

                                // Trigger next button as the maximum listing per page is 6
                                if ( next !== null ) {
                                    next.click()
                                }
                            }
                        }
                    }
                } )
            } )
        } )

        const disconnectToAppendToId = ( id, items ) => {
            // data-rs-items
            const parent = document.getElementById( id ),
                elItems = parent.querySelectorAll( '[data-rs-item]' )

            if ( elItems.length ) {
                const cloneable = elItems[0].cloneNode( true )

                // remove static elements/loader
                elItems.forEach( evt => evt.remove() )

                // Append data to element
                items.forEach( ( item, index ) => {
                    const elItem = cloneable.cloneNode( true ),
                        selectors = [
                            'fullAddress',
                            'street',
                            'city',
                            'zipCode',
                            'beds',
                            'baths',
                            'area',
                            'price',
                            'permalink',
                            'image',
                        ]

                    selectors.forEach( ( selector, ii ) => {
                        elItem.innerHTML = elItem.innerHTML.replaceAll( `{{${selector}}}`, item[selector] !== undefined ? item[selector] : "" )
                    } )

                    // Remove loader classes
                    elItem.innerHTML = elItem.innerHTML.replaceAll( 'skeleton-loader', '' );

                    parent.insertAdjacentHTML( 'beforeend', elItem.outerHTML )
                } )
            }

            // Stop observing
            observer.disconnect()

            // Add event and dispatch event it append and the observer is disconnected
            const evt = new CustomEvent( "realscoutListings", { 
                bubbles: true,
                detail: {
                    id,
                    items,
                }
            } )

            document.getElementById( id ).dispatchEvent( evt )
        }

        const officeListings = eL.querySelector( "realscout-office-listings" )

        observer.observe(
            officeListings
                ? officeListings
                : eL.querySelector( "realscout-your-listings" ), 
            { 
                subtree: true, 
                childList: true 
            }
        )
    } )

} )