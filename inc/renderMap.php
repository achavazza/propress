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
        $has_coords = ('' !== trim((string) $lat) && is_numeric($lat)
            && '' !== trim((string) $lon) && is_numeric($lon));
        $js_lat = $has_coords ? (float) $lat : 'null';
        $js_lon = $has_coords ? (float) $lon : 'null';
        ?>
        <script type="text/javascript">
            const lat = <?php echo $js_lat; ?>;
            const lon = <?php echo $js_lon; ?>;
            //console.log(lat);
            //console.log(lon);
        </script>
        <?php wp_enqueue_script('renderMap'); ?>

        <?php /*
        <div id="gmap_canvas" style="width:100%;height:300px;"></div>
        */ ?>

        <div id="modal-lightbox" class="modal main-modal">
          <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title"><?php echo __('Localizacion en el mapa', 'tnb') ?></p>
                <button class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <div id="gmap_lightbox" style="width:100%;height:80vh;"></div>
            </section>
          </div>
        </div>

        <div id="modal-streetview" class="modal main-modal">
          <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title"><?php echo __('Google Street View', 'tnb') ?></p>
                <button class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <div id="gstreet_lightbox" style="width:100%;height:80vh;"></div>
            </section>
          </div>
        </div>

    <?php endif; ?>
<?php } ?>
