<?php
function renderMap($lat, $lon){
    // Check if GMaps key is available
    if (!function_exists('tnb_has_gmaps_key') || !tnb_has_gmaps_key()) {
        if (function_exists('tnb_gmaps_required_notice')) {
            tnb_gmaps_required_notice();
        }
        return;
    }

    if(isset($lat) && isset($lon)):
    ?>

    <?php /*
    <script type="text/javascript" src="<?php echo 'http://maps.google.com/maps/api/js?'.GMAPS_KEY ?>"></script>
    */
    wp_enqueue_script('map');
    ?>
    <script type="text/javascript">
        function init_map(){
            // Options
            var myOptions = {
                zoom:16,
                center:new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lon; ?>)
            };
            // Setting map using options
            map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);
            // Setting marker to our GPS coordinates
            marker = new google.maps.Marker({map: map,clickable: false,position: new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lon; ?>)});
        }
        // Initializes google map
        //google.maps.event.addDomListener(window, 'load', init_map);
    </script>
    <script type="text/javascript">
        $(function(){
           $(window).load(function(){
               init_map();
           });
        });
    </script>
    <div id="gmap_canvas" style="width:100%;height:300px;"></div>
    <?php
    endif;
}
?>
