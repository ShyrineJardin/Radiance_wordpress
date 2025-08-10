( function($) {
	$( document ).ready( function() {
		function __construct() {
			$(window).on('load', function() {
				$('select.qs-select').each( function (i,v) {
					const fieldName = $(v).attr('id')
					ajaxQuickSearch($(v), fieldName);
				} );
				
				$('select.qs-select-single').each( function() {
					const $this = $(this)
					$this.selectpicker();
				});
			});
		}
		
		function ajaxQuickSearch(input, areaSrc) {
			var select_title = input.attr('title'),
				acceptedValues = new Array(),
				acceptedValuesText = select_title == '' ? 'value' : select_title;
			
			if ( typeof areaSrc == "string" ) {
				if ( areaSrc.search("city") > -1 ) {
					acceptedValues.push("city");
				}
				
				if ( areaSrc.search("zip") > -1 ) {
					acceptedValues.push("ZIP");
				}
				
				if ( areaSrc.search("neighborhood") > -1 ) {
					acceptedValues.push("Neighborhood");
				}
				
				if ( areaSrc.search("mlsarea") > -1 ) {
					acceptedValues.push("MLS Area");
				}
				
				if ( acceptedValues.length == 2 ) {
					acceptedValuesText = acceptedValues.join(" or ");
				}
				
				if ( acceptedValues.length > 2 ) {
					acceptedValuesText = acceptedValues.join(", ");
					lastCommaIndex = acceptedValuesText.lastIndexOf(",");
					
					acceptedValuesText1 = acceptedValuesText.slice(0,lastCommaIndex);
					
					acceptedValuesText2 = acceptedValuesText.slice(lastCommaIndex,acceptedValuesText.length);
					acceptedValuesText2 = acceptedValuesText2.replace(",",", or");
					
					acceptedValuesText = acceptedValuesText1 + acceptedValuesText2;
				}
				acceptedValuesText = acceptedValuesText.replace( 'Select a', '' );
			}
			
			if( input.attr('data-status-placeholder') != undefined ) {
				acceptedValuesText = input.attr('data-status-placeholder');
			}
			
			/* Set up quick search */
			var $formName = input.parents( 'form' ),
				$eventSelect = input,
				options = {
					ajax: {
						url: aios_qs_ajax,
						type: 'POST',
						dataType: 'json',
						data: {
							fieldname: areaSrc,
							q: '{{{q}}}'
						}
					},
					locale: {
						errorText: 'Error retrieving results.',
						statusInitialized: 'Start typing a ' + acceptedValuesText + '.',
						statusNoResults: 'The ' + acceptedValuesText + ' not found.',
						searchPlaceholder: '',
						statusSearching: 'Looking for ' + acceptedValuesText + '...'
					},
					preserveSelectedPosition: 'before',
					preprocessData: function( data ) {
						var i, l = data.length, array = [];
						
						if (l) {
							for(var i = 0; i <= data.length - 1; i++){
								array.push($.extend(true, data[i], {
									text : data[i].text,
									value: data[i].value,
									data : { type: data[i].type, subtext: data[i].remarks }
								}));
							}
						}
						
						return array;
					}
				};
			
			if( $formName.length && $eventSelect.length ) {
				$eventSelect.selectpicker({liveSearch: true}).ajaxSelectPicker(options);
				
				// Regenerate fields content
				$eventSelect.on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
					$d = $( this );
					
					// Remove old data
					$( '.city-zip-fields' ).remove();
					
					setTimeout(function() {
						$d.find( 'option[selected="selected"]' ).each( function(){
							$dd = $(this);
							$field_type = $dd.data('type');
							$field_value = $dd.val();
							
							if($field_type == 'listingIdList'){
								mlsIdField = $formName.find('input[name=listingIdList]');
								
								if(mlsIdField.length > 0){
									mlsIdField.val(mlsIdField.val() + ',' + $field_value)
								}else{
									$formName.prepend('<input type="hidden" class="city-zip-fields" name="' + $field_type + '" value="' + $field_value + '">');
								}
							}else if($field_type == 'street'){
								var split_add = $field_value.split(" ");
								var sliced = split_add.slice(1, split_add.length);
								var street_address = '';
								
								jQuery.each(sliced,function(i,e){
									street_address += sliced[i]+' ';
								});
								
								$formName.prepend('<input type="hidden" class="city-zip-fields" name="' + $field_type + '" value="' + street_address + '">');
								$formName.prepend('<input type="hidden" class="city-zip-fields" name="streetNumber" value=" '+split_add[0]+' ">');
							}else{
								$formName.prepend('<input type="hidden" class="city-zip-fields" name="' + $field_type + '" value="' + $field_value + '">');
							}
						});
					}, 1000)
				});
				
			}
		}
		
		// Instantiate
		__construct();
	});
})(jQuery);
