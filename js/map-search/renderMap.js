function init_map(map_div){
    // Check if lat and lon are defined
    if (typeof lat === 'undefined' || typeof lon === 'undefined' || !lat || !lon) {
        console.log('Map coordinates not defined');
        return;
    }
    // Options
    //console.log(lat);
    //console.log(lon);
    var mapId = (window.tnbMaps && tnbMaps.mapId) ? tnbMaps.mapId : 'DEMO_MAP_ID';
    var myOptions = {
        zoom:16,
        center:new google.maps.LatLng(lat,lon),
        mapId: mapId
    };
    // Setting map using options
    map = new google.maps.Map(document.getElementById(map_div), myOptions);
    // Setting marker to our GPS coordinates
    marker = new google.maps.marker.AdvancedMarkerElement({map: map, position: new google.maps.LatLng(lat,lon)});
}
// Initializes google map
//google.maps.event.addDomListener(window, 'load', init_map);
function init_street_view(map_div) {
    // Check if lat and lon are defined
    if (typeof lat === 'undefined' || typeof lon === 'undefined' || !lat || !lon) {
        console.log('Street View coordinates not defined');
        return;
    }
    var mapId = (window.tnbMaps && tnbMaps.mapId) ? tnbMaps.mapId : 'DEMO_MAP_ID';
    var fenway = {lat: lat, lng: lon};
    var map = new google.maps.Map(document.getElementById(map_div), {
        center: fenway,
        zoom: 16,
        mapId: mapId
    });
    var panorama = new google.maps.StreetViewPanorama(
        document.getElementById(map_div), {
            position: fenway,
            pov: {
                heading: 0,
                pitch: 0
            }
        });
        map.setStreetView(panorama);
    }

    $(function(){
        // Only init map if coordinates and the canvas element are available
        if (typeof lat === 'undefined' || typeof lon === 'undefined' || !lat || !lon) {
            return;
        }
        if (!document.getElementById('gmap_canvas')) {
            return;
        }
        // Wait for the Google Maps API to be ready (supports loading=async)
        var tries = 0;
        var timer = setInterval(function(){
            if (window.google && window.google.maps) {
                clearInterval(timer);
                init_map('gmap_canvas');
            } else if (++tries > 100) {
                clearInterval(timer);
            }
        }, 100);
});
