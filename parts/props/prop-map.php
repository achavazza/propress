<?php
$mapGPS = get_post_meta($post->ID, '_prop_map', true);
?>
<?php if(isset($mapGPS['latitude']) && isset($mapGPS['longitude']) && !empty($mapGPS['latitude']) && !empty($mapGPS['longitude'])): ?>
<div class="card block">
    <div class="card-header">
        <h3 class="card-header-title"><?php echo __('Ubicación', 'tnb'); ?></h3>
    </div>
    <div class="card-content">
        <?php
        // Check if GMaps is available
        if (!function_exists('tnb_has_gmaps_key') || !tnb_has_gmaps_key()) {
            if (function_exists('tnb_gmaps_required_notice')) {
                tnb_gmaps_required_notice();
            } else {
                echo '<div class="alert alert-warning">' . __('Se necesita una clave API de Google Maps para mostrar el mapa de la propiedad.', 'tnb') . '</div>';
            }
        } else {
        ?>
        <div id="gmap_canvas" style="width:100%;height:300px;"></div>
        <?php } ?>
    </div>
</div>
<?php endif; ?>
