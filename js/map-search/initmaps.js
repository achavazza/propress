function initMap() {
    var mapId = (window.tnbMaps && tnbMaps.mapId) ? tnbMaps.mapId : 'DEMO_MAP_ID';
    var map = new google.maps.Map(document.getElementById('gmap_canvas'), {
        //mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoom: 14,
        mapId: mapId,
        //center: {lat: -25.363, lng: 131.044},
        // NOTE: the legacy `styles` array cannot be combined with a mapId.
        // Map styling is now configured via cloud-based styling on the Map ID.
    });

    var bounds     = new google.maps.LatLngBounds();
    /*var infowindow = new google.maps.InfoWindow({
        //content: body,
        //maxWidth: 200
    });*/

    var infowindow = new InfoBubble({
      map: map,
      minWidth: 450,
      maxWidth: 450,
      minHeight: 175,
      maxHeight: 250,
      //content: '<div class="phoneytext">Some label</div>',
      position: new google.maps.LatLng(-35, 151),
      padding: 10,
      backgroundColor: 'rgb(255,255,255)',
      borderColor: '#dddddd',
      borderWidth: 2,
      borderRadius: 2,
      arrowSize: 10,
      arrowStyle: 0,
      shadowStyle: 3,
      disableAutoPan: true,
      hideCloseButton: false,
      disableAnimation: true,
      //arrowPosition: 30,
      //backgroundClassName: 'phoney',
    });
    var marker, i;
    for (i = 0; i < locations.length; i++) {
        //console.log(locations[i]);
        marker = new google.maps.marker.AdvancedMarkerElement({
            position: new google.maps.LatLng(locations[i][0], locations[i][1]),
            map: map,
            gmpClickable: true
        });
        marker.content = body[i];
        markers.push(marker);
        bounds.extend(marker.position);
        marker.addListener('gmp-click', (function(marker, i) {
            return function() {
                //map.setCenter(marker.position);
                map.panTo(marker.position);
                infowindow.setPosition(marker.position);
                infowindow.setContent(this.content);
                infowindow.open(map);
            }
        })(marker, i));
    }
    google.maps.event.addListener(map, 'zoom_changed', function() {
        zoomChangeBoundsListener =
            google.maps.event.addListener(map, 'bounds_changed', function(event) {
                if (this.getZoom() > 16 && this.initialZoom == true) {
                    // Change max/min zoom here
                    this.setZoom(16);
                    this.initialZoom = false;
                }
            google.maps.event.removeListener(zoomChangeBoundsListener);
        });
    });

    /*
    // Add a marker clusterer to manage the markers.
    var mcOptions = {
        //gridSize: 10,
        minimumClusterSize: 20
    };
    var markerCluster = new MarkerClusterer(map, markers, mcOptions);
    */

    map.initialZoom = true;
    map.fitBounds(bounds);
    //google.maps.event.addDomListener(window, 'load', init_map);
}
$(function(){
    if($(window).width() >= 1240){
        winH    = $(window).height();
        headH   = $('#gmap_canvas').offset().top;
        //headH   = $('#header').height();
        calc    = (winH - headH);

        $('#map-container').height(calc);
    }
    //$('#gmap_canvas').height(calc);
});
//google.maps.event.addDomListener(window, 'load', initMap);
//initMap();
