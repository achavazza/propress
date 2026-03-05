function init_map(map_div){
    // Check if lat and lon are defined
    if (typeof lat === 'undefined' || typeof lon === 'undefined' || !lat || !lon) {
        console.log('Map coordinates not defined');
        return;
    }
    // Options
    //console.log(lat);
    //console.log(lon);
    var myOptions = {
        zoom:16,
        center:new google.maps.LatLng(lat,lon)
    };
    // Setting map using options
    map = new google.maps.Map(document.getElementById(map_div), myOptions);
    // Setting marker to our GPS coordinates
    marker = new google.maps.Marker({map: map,clickable: false,position: new google.maps.LatLng(lat,lon)});
}
// Initializes google map
//google.maps.event.addDomListener(window, 'load', init_map);
function init_street_view(map_div) {
    // Check if lat and lon are defined
    if (typeof lat === 'undefined' || typeof lon === 'undefined' || !lat || !lon) {
        console.log('Street View coordinates not defined');
        return;
    }
    var fenway = {lat: lat, lng: lon};
    var map = new google.maps.Map(document.getElementById(map_div), {
        center: fenway,
        zoom: 16
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
        // Only init map if coordinates are defined
        if (typeof lat !== 'undefined' && typeof lon !== 'undefined' && lat && lon) {
            init_map('gmap_canvas');
        }
        /*
        $(window).on('load',function(){
        init_map('gmap_canvas');
    })
    */
});
