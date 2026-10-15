(function( $ ) {
	'use strict';

	var maps = [];
	var mapId = ( window.tnbMaps && tnbMaps.mapId ) ? tnbMaps.mapId : 'DEMO_MAP_ID';

	// The Maps API is loaded with loading=async, so wait until it (and the
	// marker/places libraries) is ready before touching google.maps.
	function whenMapsReady( callback ) {
		var tries = 0;
		var timer = window.setInterval( function() {
			if ( window.google && google.maps && google.maps.marker && google.maps.places ) {
				window.clearInterval( timer );
				callback();
			} else if ( ++tries > 200 ) {
				window.clearInterval( timer );
			}
		}, 50 );
	}

	$( function() {
		if ( typeof postboxes !== 'undefined' ) {
			postboxes.pbshow = function () {
				var arrayLength = maps.length;
				for ( var i = 0; i < arrayLength; i++ ) {
					var mapCenter = maps[i].getCenter();
					google.maps.event.trigger( maps[i], 'resize' );
					maps[i].setCenter( mapCenter );
				}
			};
		}

		whenMapsReady( function() {
			$( '.cmb-type-pw-map' ).each( function() {
				initializeMap( $( this ) );
			} );
		} );
	} );

	function initializeMap( mapInstance ) {
		var searchInput = mapInstance.find( '.pw-map-search' );
		var mapCanvas = mapInstance.find( '.pw-map' );
		var latitude = mapInstance.find( '.pw-map-latitude' );
		var longitude = mapInstance.find( '.pw-map-longitude' );
		var hasCoords = latitude.val().length > 0 && longitude.val().length > 0;
		var latLng = hasCoords ? new google.maps.LatLng( latitude.val(), longitude.val() ) : new google.maps.LatLng( -31.6295, -60.701 );
		var zoom = hasCoords ? 17 : 12;

		// Map
		var map = new google.maps.Map( mapCanvas[0], {
			center: latLng,
			zoom: zoom,
			mapId: mapId
		} );

		// Advanced Marker (replaces the deprecated google.maps.Marker)
		var marker = new google.maps.marker.AdvancedMarkerElement( {
			map: map,
			position: hasCoords ? latLng : null,
			gmpDraggable: true
		} );

		// Address search using the new Places API (PlaceAutocompleteElement)
		if ( searchInput.length ) {
			var autocomplete = new google.maps.places.PlaceAutocompleteElement();
			autocomplete.setAttribute( 'placeholder', searchInput.attr( 'placeholder' ) || 'Buscar dirección' );
			searchInput.after( autocomplete );
			searchInput.hide();

			autocomplete.addEventListener( 'gmp-select', function( event ) {
				var prediction = event.placePrediction;
				if ( ! prediction ) {
					return;
				}
				var place = prediction.toPlace();
				place.fetchFields( { fields: [ 'location', 'viewport', 'formattedAddress' ] } ).then( function() {
					if ( place.viewport ) {
						map.fitBounds( place.viewport );
					} else if ( place.location ) {
						map.setCenter( place.location );
						map.setZoom( 17 );
					}
					if ( place.location ) {
						marker.position = place.location;
						latitude.val( place.location.lat() );
						longitude.val( place.location.lng() );
					}
					if ( place.formattedAddress ) {
						searchInput.val( place.formattedAddress );
					}
				} );
			} );

			searchInput.on( 'keypress', function( event ) {
				if ( 13 === event.keyCode ) {
					event.preventDefault();
				}
			} );
		}

		// Allow marker to be repositioned
		marker.addListener( 'dragend', function() {
			if ( marker.position ) {
				latitude.val( marker.position.lat() );
				longitude.val( marker.position.lng() );
			}
		} );

		maps.push( map );
	}

	// When a new row is added, reinitialize Google Maps
	$( document ).on( 'cmb2_add_row', '.cmb-repeatable-group', function( event, newRow ) {
		var groupWrap = $( newRow ).closest( '.cmb-repeatable-group' );
		groupWrap.find( '.cmb-type-pw-map' ).each( function() {
			initializeMap( $( this ) );
		} );
	} );

})( jQuery );
