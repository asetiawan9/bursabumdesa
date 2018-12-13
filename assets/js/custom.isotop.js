			jQuery(window).load(function(){
			// init Isotope
					var $gellary_img = $('.all-gallery-items').isotope({
					  itemSelector: '.single-item',
					  percentPosition: true,
					  transitionDuration: '0.8s',
					  masonry: {
						// use outer width of grid-sizer for columnWidth
						columnWidth: '.single-item',
						gutter: 15
					  },
					  getSortData: {
						name: '.name',
						symbol: '.symbol',
						number: '.number parseInt',
						category: '[data-category]',
						weight: function( itemElem ) {
						  var weight = $( itemElem ).find('.weight').text();
						  return parseFloat( weight.replace( /[\(\)]/g, '') );
						}
					  }
					});       
						
					// filter functions
					var filterFns = {
					  // show if number is greater than 50
					  numberGreaterThan50: function() {
						var number = $(this).find('.number').text();
						return parseInt( number, 10 ) > 50;
					  },
					  // show if name ends with -ium
					  ium: function() {
						var name = $(this).find('.name').text();
						return name.match( /ium$/ );
					  }
					};
						
					// bind filter button click
					$('.gallery-menu ul').on( 'click', 'li', function() {
					  var filterValue = $( this ).attr('data-filter');
					  // use filterFn if matches value
					  filterValue = filterFns[ filterValue ] || filterValue;
					  $gellary_img.isotope({ filter: filterValue });
					});            

					// Isotop for four grid     
					var $gellary_img_4 = $('.gallery-grid-4').isotope({
					  itemSelector: '.single-item-4',
					  transitionDuration: '0.8s',
					  getSortData: {
						name: '.name',
						symbol: '.symbol',
						number: '.number parseInt',
						category: '[data-category]',
						weight: function( itemElem ) {
						  var weight = $( itemElem ).find('.weight').text();
						  return parseFloat( weight.replace( /[\(\)]/g, '') );
						}
					  }
					}); 
					// bind filter button click
					$('.gallery-menu ul').on( 'click', 'li', function() {
					  var filterValue = $( this ).attr('data-filter');
					  // use filterFn if matches value
					  filterValue = filterFns[ filterValue ] || filterValue;
					  $gellary_img_4.isotope({ filter: filterValue });
					});
					
					// change is-checked class on buttons
					$('.gallery-menu ul').each( function( i, liList ) {
					  var $liList = $( liList );
					  $liList.on( 'click', 'li', function() {
						$liList.find('.is_selected').removeClass('is_selected');
						$( this ).addClass('is_selected');
					  });
					});
            

			}); 
 