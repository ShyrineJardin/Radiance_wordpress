( function ( $, w, d, h, b ) {
	var metabox = {
		main: function() {
			$( '#aios-communities-details-meta-box' ).insertAfter( '#titlediv' )
		},

		init: function() {
			this.main()
		}
	}

	var gallery = {
		main: function() {
			let frame

			$( b ).on( 'click', '[dat-add-images]', function() {
				const el = $( this ),
					parent = el.parent(),
					input = parent.find( 'input[type="hidden"]' ),
					ids = input.val() ? input.val().split(',') : []

				frame = wp.media({ 
					title: 'Select or Upload Media',
					button: {
						text: 'Insert Media'
					},
					multiple: true
				} )

				frame.on( 'select', function() {
					const attachments = frame.state().get( 'selection' ),
                    	placeholder = parent.find( '.wc-repeater-field-content-no-images' ),
						container = parent.find( '.wc-repeater-field-content-gallery' )
					
					if ( attachments.length ) {
						attachments.forEach( function( attachment ) {
							if ( ! ids.includes( String( attachment.id ) ) ) {
							  	ids.push(attachment.id);
								container.append( `<div>
									<div class=\"img-move-drag\" data-sort-handle></div>
									<div class=\"img-remove\" data-remove-image-gallery></div>
									<img src="${attachment.attributes.url}" width="150" height="150" data-id="${attachment.attributes.id}">
									<canvas width="150" height="150"></canvas>
								</div>` )
							}
						} )
						
						input.val(ids.join(','))
						placeholder.hide()
					}
				} )

				frame.on( 'close', function() {
                    const placeholder = parent.find( '.wc-repeater-field-content-no-images' )

					if ( input.val() === "" ) {
						placeholder.show()
					} else {
						placeholder.hide()
					}
				} )

				frame.open()
			} )
		},

		getSortable: function() {
			let sortable = []
			const sort = $( d ).find( '[data-sort-wrapper]' )

			sort.each( function( i ) {
				const el = $( this )
				const addId = `wc-repeater-sortable-${i}`

				el.attr( 'id', addId )
				sortable.push( addId )
			} )

			return sortable
		},

		initSortable: function() {
			const updateFields = stats.updateIndexFields

            this.getSortable().forEach( function( id ) {
				$( `#${id}` )
					.sortable({
						placeholder: 'ui-state-highlight',
						forcePlaceholderSize: true,
						tolerance: 'pointer',
						// cursorAt: { top: 75, left: 75 },
						handle: `[data-sort-handle]`,
      					// items: "not:[data-sort=\"fields\"]",
						cancel: '.wc-repeater-section-header-title, .wc-repeater-field-type, .wc-repeater-field-toggle, .wc-repeater-field-close, .wc-repeater-field-visibility, .img-remove',
						update: function () {
							const el = $( this )

							if ( el.attr( 'data-sort' ) === "gallery" ) {
								let ids = []

								$( this ).find( 'img' ).each( function () {
									const attr = $( this ).attr( 'data-id' )
									ids.push( attr );
								} );

								$( this ).parent().find( 'input[type="hidden"]' ).val( ids.join( ',' ) )
							} else if ( el.attr( 'data-sort' ) === "stats" ) {
								updateFields( $( this ) )
								
								editor.reInit()
								gallery.reInitSortable()							
							} else if ( el.attr( 'data-sort' ) === "fields" ) {
								updateAllIndexes.main()

								editor.reInit()
								gallery.reInitSortable()
							}
						},

						start: function ( e, ui ) {
							$( ui.item ).find( 'textarea' ).each( function () {
							   tinymce.execCommand( 'mceRemoveEditor', false, $( this ).attr( 'id' ) );
							} );
						  },
						  stop: function ( e, ui ) {
							$( ui.item ).find( 'textarea' ).each( function () {
							   tinymce.execCommand( 'mceAddEditor', true, $( this ).attr( 'id' ) );
							} );
						  }
					} );
			} )
		},

		removeSortable: function() {
			this.getSortable().forEach( function( id ) {
				$( id ).sortable( "disable" )
			} )
		},

		reInitSortable: function() {
			this.removeSortable()
			this.initSortable()
		},

		removeImage: function() {
			$( b ).on( 'click', '[data-remove-image-gallery]', function() {
				const el = $( this ),
					parent = el.parent(),
					imgId = parent.find( 'img' ).attr( 'data-id' ),
					parents = el.parents( '.wc-repeater-field-content-type' ),
					input = parents.find( 'input[type="hidden"]' ),
					ids = input.val() ? input.val().split(',') : [],
					newIds = ids.filter( v => v !== imgId )

				input.val(newIds.join(','))
				parent.remove()
			} )
		},

		init: function() {
			this.main()
			this.initSortable()
			this.removeImage()
		}
	}

	var editor = {
		get: function() {
			let editors = [],
				len = 1
			const tinymces = $( b ).find( '.wc-repeater-tinymce' )

			tinymces.each( function( i ) {
				const el = $( this )

				if ( el.attr( 'id' ) === undefined ) {
					for (let index = 1; index < 999; index++) {
						// console.log(`#wc-repeater-tinymce-${len}`, jQuery( `#wc-repeater-tinymce-${len}` ).length)

						if ( jQuery( `#wc-repeater-tinymce-${len}` ).length === 0 ) {
							// console.log(len)
							break;
						}

						len++
					}

					el.attr( 'id', `wc-repeater-tinymce-${len}` )
					editors.push( `wc-repeater-tinymce-${len}` )
				}
			} )

			return editors
		},

		init: function() {
			const editors = this.get()

			editors.forEach( function(id) {
				wp.editor.initialize( id, {
					tinymce: {
					  wpautop: true,
					  plugins : 'charmap colorpicker hr lists paste tabfocus textcolor fullscreen wordpress wpautoresize wpeditimage wpemoji wpgallery wplink wptextpattern',
					  toolbar1: 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,wp_more,spellchecker,fullscreen,wp_adv,listbuttons',
					  toolbar2: 'styleselect,strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help',
					  textarea_rows : 20
					},
					quicktags: {
						buttons: 'strong,em,link,block,del,ins,img,ul,ol,li,code,more,close'
					},
					mediaButtons: true
				} )
			} )
		},

		remove: function() {
			this.get().forEach( function(id) {
				wp.editor.remove( id )
			} )
		},

		reInit: function() {
			// this.remove()
			this.init()
		},
	}

	var updateAllIndexes = {
		main: function() {
			const container = $( '#wc-repeater' ).find( '[data-section-wrapper]' )
			const fieldUpdate = this.field
	
			$.each( container, function (index, element) {
				const el = $( element )
				const wrapperFields = el.find('[name*="community_field"]')

				fieldUpdate( wrapperFields, 0, index )

				// update fields index
				// $.each( wrapperFields, function ( indexalt, v ) {
				// 	var field = $(v)
				// 	var name = field.attr('name')
	
				// 	// format name to update string index
				// 	name = name.slice(16, -1).split('][')
				// 	name[0] = index
	
				// 	field.attr('name', 'community_field[' + (name.join('][')) + ']')
				// })
	
				// update fields
				const fields = el.find('[data-section-field]')

				$.each( fields, function ( sectionIndex, element ) {
					const el = $( element ),
						fields = el.find('[name*="community_field"]')

					fieldUpdate( fields, 2, sectionIndex )
	
					// $.each( fields, function ( indexalt, v ) {
					// 	var field = $(v)
					// 	var name = field.attr('name')
	
					// 	// format name to update string index
					// 	name = name.slice(16, -1).split('][')
					// 	name[2] = sectionIndex
	
					// 	field.attr('name', 'community_field[' + (name.join('][')) + ']')
					// })
				
					// Update main stats
					const statsFields = el.find('[data-section-stat]')
					
					$.each( statsFields, function ( statsIndex, element ) {
						const el = $( element ),
							fields = el.find('[name*="community_field"]')

						fieldUpdate( fields, 4, statsIndex )
		
						// $.each( fields, function ( indexalt, v ) {
						// 	var field = $(v)
						// 	var name = field.attr('name')
		
						// 	// format name to update string index
						// 	name = name.slice(16, -1).split('][')
						// 	name[4] = statsIndex
		
						// 	field.attr('name', 'community_field[' + (name.join('][')) + ']')
						// })
	
						// Update sub stats
						const statFields = el.find('[data-section-stats-child-item]')
						
						$.each( statFields, function ( statIndex, element ) {
							const el = $( element ),
								fields = el.find('[name*="community_field"]')
			
							fieldUpdate( fields, 6, statIndex )
							
							// $.each( fields, function ( indexalt, v ) {
							// 	var field = $(v)
							// 	var name = field.attr('name')
			
							// 	// format name to update string index
							// 	name = name.slice(16, -1).split('][')
							// 	name[6] = statIndex
			
							// 	field.attr('name', 'community_field[' + (name.join('][')) + ']')
							// })
						} )
					} )
				} )
			} )
		},

		field: function ( fields, keyIndex, index ) {
			$.each( fields, function ( indexalt, v ) {
				var field = $( v )
				var name = field.attr( 'name' )

				// format name to update string index
				name = name.slice( 16, -1 ).split( '][' )
				name[keyIndex] = index

				field.attr( 'name', 'community_field[' + (name.join('][')) + ']' )
			} )
		}
	}

	var repeater = {
		addFields: function() {
			$( '#wc-add-section button' ).on( 'click', function() {
				$( '.wc-repeater-inside' ).append( communities_pt_data.section )

				updateAllIndexes.main()
				editor.reInit()
				gallery.reInitSortable()
			} )
		},

		addSubFields: function() {
			$( b ).on( 'click', '[data-add-field]', function() {
				const el = $( this ),
					parent = el.parents( '.wc-repeater-section' )

				parent.find( '.wc-repeater-fields' ).append( communities_pt_data.field )
				
				updateAllIndexes.main()
				editor.reInit()
				gallery.reInitSortable()
			} )
		},

		updateTitle: function() {
			$( d ).on( 'keyup', '[data-head-title-input]', function() {
				const val = $( this ).val(),
					title = $( this ).closest( '[data-toggle-parent]' ).find( '> div > [data-head-title-heading]' )

				title.text( val === "" ? "No Title" : val )
			} )
		},

		init: function() {
			this.addFields()
			this.addSubFields()
			this.updateTitle()
		}
	}

	var toggle = {
		fieldType: function() {
			$( b ).on( 'click', '.wc-repeater-field-type-button', function() {
				const el = $( this )

				el.addClass( 'active' )
				el.closest( '.wc-repeater-field-type' ).find( '.wc-repeater-field-type-dropdown' ).slideDown( 'fast' )
				el.closest( '.wc-repeater-field' ).addClass( 'field-open' )
			} )

			$( b ).on( 'click', '[data-field-type]', function() {
				const el = $( this ),
					type = el.attr( 'data-field-type' ),
					parent = el.closest( '.wc-repeater-field-type' ),
					grandParent = el.parents( '.wc-repeater-field' )

				parent.find( 'input[type=hidden]' ).val( type )
				parent.find( '.wc-repeater-field-type-button' ).text( el.text() )

				grandParent.find( '.wc-repeater-field-content-type' ).hide()
				grandParent.find( `.wc-repeater-field-content-type[data-id=${type}]` ).slideDown()

				// Close
				$( '.wc-repeater-field.field-open' ).removeClass( 'field-open' )
				$( '.wc-repeater-field-type-button' ).removeClass( 'active' )
				$( '.wc-repeater-field-type-dropdown' ).slideUp( 'fast' )
			} )


            $( d ).on( 'click', function (e) {
                const trigger = $('.wc-repeater-field-type')

                if (
                    trigger !== e.target &&
                    !trigger.has(e.target).length
                ) {
                    $('.wc-repeater-field-type-button').removeClass( 'active' )
                    $('.wc-repeater-field-type-dropdown').slideUp( 'fast' )
                }
            } )
		},

		subField: function() {
			$( b ).on( 'click', '[data-toggle-field]', function() {
				const el = $( this ),
					parent = el.closest( '[data-toggle-parent]' )

				el.toggleClass( 'active' )
				parent.find( '> [data-toggle-body]' ).slideToggle( 'fast' )
			} )
		},

		deleteField: function() {
			$( b ).on( 'click', '[data-close-field]', function() {
				const el = $( this ),
					parent = el.closest( '[data-toggle-parent]' )

				parent.remove()
				updateAllIndexes.main()
			} )
		},

		init: function() {
			this.fieldType()
			this.subField()
			this.deleteField()
		}
	}

	var stats = {
		imageHandler: function () {
			let frame

			$( b ).on( 'click', '[data-add-stat-image]', function() {
				const el = $( this ),
					parent = el.parent(),
					input = parent.find( 'input[type="hidden"]' )

				// if ( frame ) {
				// 	frame.open();
				// 	return;
				// }

				frame = wp.media({ 
					title: 'Select or Upload Media',
					button: {
						text: 'Insert Media'
					},
					multiple: true
				} )

				frame.on( 'select', function() {
					const attachment = frame.state().get( 'selection' ).first().toJSON(),
						container = parent.find( ' > div' )

						container.append( `
							<img src="${attachment.url}" width="200" height="200">
						` )

						input.val(attachment.id)
				} )

				frame.on( 'close', function() {
                    const placeholder = parent.find( '.wc-repeater-field-content-no-images' )

					if ( input.val() === "" ) {
						placeholder.show()
					} else {
						placeholder.hide()
					}
				} )

				frame.open()
			} )
		},

		addStatFields: function() {
			$( b ).on( 'click', '[data-add-stat]', function() {
				const el = $( this )
					parent = el.parents( '.wc-stats-item' ).find( '.wc-stats-child' )

				parent.append( communities_pt_data.stat_child )
				updateAllIndexes.main()
			} )
		},

		addStatSection: function() {
			$( b ).on( 'click', '[data-add-stat-section]', function() {
				const el = $( this )
					parent = el.parents( '.wc-repeater-field-content-type' ).find( '.wc-stats-items' )

				parent.append( communities_pt_data.stat )
				updateAllIndexes.main()
			} )
		},

		// deleteStat: function() {
		// 	$( b ).on( 'click', '[data-close-stat]', function() {
		// 		const el = $( this ),
		// 			parent = el.closest( '[data-toggle-parent]' ),
		// 			grandParent = el.closest( '.wc-stats-child-items' )

		// 		parent.remove()
		// 		updateAllIndexes.main()
		// 	} )
		// },

		updateIndexFields: function( el ) {
			const fieldUpdate = updateAllIndexes.field

			$.each( el.parents( '.wc-repeater-field-content-type' ).find( '[data-section-stat]' ), function ( statsIndex, element ) {
				const el = $( element ),
					fields = el.find('[name*="community_field"]')

				fieldUpdate( fields, 4, statsIndex )

				$.each( el.find( '[data-section-stats-child-item]' ), function ( statIndex, element ) {
					const el = $( element ),
						fields = el.find('[name*="community_field"]')
	
					fieldUpdate( fields, 6, statIndex )
				} )
			} )
		},

		init: function() {
			this.imageHandler()
			this.addStatFields()
			this.addStatSection()
			// this.deleteStat()
		}
	}

	var app = {
		init: function() {
			metabox.init()
			repeater.init()
			toggle.init()
			gallery.init()
			stats.init()
			editor.init()
		}
	}


    $(document).ready(function () {
        app.init()
    } )

} )( jQuery, window, document, 'html', 'body' )
