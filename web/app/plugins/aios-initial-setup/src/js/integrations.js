(function ($, w, d, h, b) {
    const app = {
        typeSelectors: function() {
            var selectorType = $( '#rs-listings-type' )

            // selectorType.on( 'change', function(evt) {
            //     app.shortcodeGenerator()
            // } )

            $( '#listing-shortcode-generator input, #listing-shortcode-generator select' ).on( 'change', function() {
                app.shortcodeGenerator()
            } )

            selectorType.trigger('change')
        },

        shortcodeGenerator: function() {
            const shortcodeType = $( '#rs-listings-type' ).val(),
                generatedShortcode = $( '#rs-generated-shortcode' ),
                sortBy = $( '#rs-sortby' ),
                statuses = $( '#lstatuses input:checked' ),
                types = $( '#ptypes input:checked' ),
                priceFrom = $( '#prange-from' ),
                priceTo = $( '#prange-to' ),
                dateFrom = $( '#lsrange-from' ),
                dateTo = $( '#lsrange-to' ),
                coListed = $( '#co-listed:checked' ),
                buyerRepresented = $( '#buyer-represented:checked' ),
                disableShadow = $( '#disable-shadow:checked' ),
                selectedType = shortcodeType === 'yl' ? 'listing' : 'office'

            let statusesArr = [],
                typesArr = [],
                priceFromValue = "",
                priceToValue = "",
                dateFromValue = "",
                dateToValue = ""
            
            statuses.each( function() {
                statusesArr.push( $(this).val() )
            } )
            
            types.each( function() {
                typesArr.push( $(this).val() )
            } )

            if (priceFrom.val() !== "") {
                priceFromValue = `price-min="${priceFrom.val()}"`
            }

            if (priceTo.val() !== "") {
                priceToValue = `price-max="${priceTo.val()}"`
            }

            if (dateFrom.val() !== "") {
                dateFromValue = `listing-date-start="${dateFrom.val()}"`
            }

            if (dateTo.val() !== "") {
                dateToValue = `listing-date-end="${dateTo.val()}"`
            }

            const atts = [
                    `type="${selectedType}"`,
                    `sort-order="${sortBy.val()}"`,
                    `listing-status="${statusesArr.join(',')}"`,
                    `property-types="${typesArr.join(',')}"`,
                    priceFromValue,
                    priceToValue,
                    dateFromValue,
                    dateToValue,
                    coListed.val(),
                    buyerRepresented.val(),
                    disableShadow.val()
                ],
                flattedAtts = atts.filter( e => e)
            
            generatedShortcode.val(`[aios_realscout_v2 ${flattedAtts.join( ' ' )}]`)
        },

        bannerShortcode: function() {
            const field_group = $('.rs-banner-generator-field')

            field_group.find('select').on('change', function() {
                const v = $(this).val(),
                    v_field = $(this).find('option:selected').data('field'),
                    name = $(this).attr('name'),
                    applicables = $('[data-applicable]')

                applicables.each(function(){
                    if ( $(this).data('applicable') === v_field || $(this).data('applicable') === v ) {
                        $(this).show()
                    } else {
                        $(this).hide()
                    }
                })
                
                app.bannerShortcodeGenerator()
            })

            field_group.each(function() {
                $(this).find('input').on('change', function() {
                    app.bannerShortcodeGenerator()
                })
            })

            field_group.find('select').trigger('change')

            const type = $('.rs-banner-generator-field select')
            
            type.on('change', function() {
                const v = $(this).val(),
                    parent = $(this).parent(),
                    imgs = parent.find('img')

                imgs.hide()
                parent.find(`img[data-name=${v}]`).show()
            })
        },

        bannerShortcodeGenerator: function() {
            const fields = $('.rs-banner-generator-field:visible').find('input, select'),
                atts = {}

            fields.each(function() {
                const v = $(this).val(),
                    name = $(this).attr('name')

                if ( $(this).attr('type') === 'checkbox' ) {
                    atts[name] = $(this).is(':checked') ? v : ""
                } else {
                    atts[name] = v
                }
            })

            const filtered = Object.keys(atts)
                .filter( key => atts[key] !== "" )
                .reduce( (res, key) => (res[key] = atts[key], res), {} ),
                attributes = Object.keys(filtered).map( key => `${key}="${filtered[key]}"` ).join(' '),
                shortcode = `[aios_realscout_banners ${attributes}]`
                
            $("#rs-banner-generator-code").val(shortcode)
        },

        init() {
            this.typeSelectors()
            this.bannerShortcode()
        }
    }


    $(document).ready(function () {
        app.init()
    })
})(jQuery, window, document, 'html', 'body')