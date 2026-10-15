<div class="card block">
    <div class="card-header">
        <h3 class="card-header-title"><?php echo __('Detalles', 'tnb'); ?></h3>
    </div>
    <div class="card-content">
        <?php
            // Fixed: Get post meta safely
            $data = get_post_meta($post->ID);
            
            // Fixed: Define variables safely if not already set
            if (!isset($prop_sup)) {
                $prop_sup = isset($data['_prop_sup'][0]) ? $data['_prop_sup'][0] : '';
            }
            if (!isset($prop_dormrooms)) {
                $prop_dormrooms = isset($data['_prop_dormrooms'][0]) ? $data['_prop_dormrooms'][0] : '';
            }
            if (!isset($prop_bathrooms)) {
                $prop_bathrooms = isset($data['_prop_bathrooms'][0]) ? $data['_prop_bathrooms'][0] : '';
            }
            
            $stat             = status();
            $prop_statuses    = get_post_meta($post->ID, '_prop_status', true);

            $services         = services();
            $prop_services    = get_post_meta($post->ID, '_prop_services', true);

            $front            = front();
            $prop_front       = get_post_meta($post->ID, '_prop_front', true);

            $orientation      = orientation();
            $prop_orientation = get_post_meta($post->ID, '_prop_orientation', true);

            //$prop_features    = get_service_list();
            $features = get_the_terms($post, 'features');
            if (is_wp_error($features)) {
                $features = null;
            }
        ?>
        <ul class="prop-details-list">
            <?php /*
            AMBIENTES
            <?php if($prop_rooms): ?>
                <li>
                    <?php echo sprintf(__('Ambientes: %s'), $prop_rooms) ?>
                </li>
            <?php endif; ?>
            */ ?>
            <?php if($prop_sup): ?>
                <li class="prop-detail">
                    <span class="prop-detail__icon"><?php echo tnb_icon('ruler', 'prop-detail__glyph'); ?></span>
                    <span class="prop-detail__body">
                        <span class="prop-detail__value"><?php echo $prop_sup; ?> m<sup>2</sup></span>
                        <span class="prop-detail__label"><?php _e('Superficie', 'tnb'); ?></span>
                    </span>
                </li>
            <?php endif; ?>
            <?php if($prop_dormrooms): ?>
                <li class="prop-detail">
                    <span class="prop-detail__icon"><?php echo tnb_icon('bed', 'prop-detail__glyph'); ?></span>
                    <span class="prop-detail__body">
                        <span class="prop-detail__value"><?php echo esc_html($prop_dormrooms); ?></span>
                        <span class="prop-detail__label"><?php _e('Dormitorios', 'tnb'); ?></span>
                    </span>
                </li>
            <?php endif; ?>
            <?php if($prop_bathrooms): ?>
                <li class="prop-detail">
                    <span class="prop-detail__icon"><?php echo tnb_icon('toilet', 'prop-detail__glyph'); ?></span>
                    <span class="prop-detail__body">
                        <span class="prop-detail__value"><?php echo esc_html($prop_bathrooms); ?></span>
                        <span class="prop-detail__label"><?php _e('Baños', 'tnb'); ?></span>
                    </span>
                </li>
            <?php endif; ?>
            <?php
                if($features){
                    foreach($features as $feature){
                        if($feature){
                            $feature_icon = tnb_get_term_icon($feature->term_id);
                            ?>
                            <li class="prop-detail">
                                <span class="prop-detail__icon"><?php echo tnb_icon($feature_icon ? $feature_icon : 'star', 'prop-detail__glyph'); ?></span>
                                <span class="prop-detail__body">
                                    <span class="prop-detail__value"><?php _e('Si', 'tnb'); ?></span>
                                    <span class="prop-detail__label"><?php echo esc_html($feature->name); ?></span>
                                </span>
                            </li>
                            <?php
                        }
                    }
                }
            ?>
            <?php if($prop_front): ?>
                <li class="prop-detail">
                    <span class="prop-detail__icon"><?php echo tnb_icon('map-pin', 'prop-detail__glyph'); ?></span>
                    <span class="prop-detail__body">
                        <span class="prop-detail__value"><?php echo esc_html(isset($front[$prop_front]) ? $front[$prop_front] : ' '); ?></span>
                        <span class="prop-detail__label"><?php _e('Ubicación', 'tnb'); ?></span>
                    </span>
                </li>
            <?php endif; ?>
            <?php if($prop_orientation): ?>
                <li class="prop-detail">
                    <span class="prop-detail__icon"><?php echo tnb_icon('compass', 'prop-detail__glyph'); ?></span>
                    <span class="prop-detail__body">
                        <span class="prop-detail__value"><?php echo esc_html(isset($orientation[$prop_orientation]) ? $orientation[$prop_orientation] : ' '); ?></span>
                        <span class="prop-detail__label"><?php _e('Orientación', 'tnb'); ?></span>
                    </span>
                </li>
            <?php endif; ?>
            <?php
                if($prop_services){
                    foreach($services as $k => $service){
                        if($service){
                            $has_service = in_array($k, $prop_services);
                            ?>
                            <li class="prop-detail">
                                <span class="prop-detail__icon"><?php echo tnb_icon($has_service ? 'check' : 'x', 'prop-detail__glyph'); ?></span>
                                <span class="prop-detail__body">
                                    <span class="prop-detail__value"><?php echo $has_service ? __('Si') : __('No'); ?></span>
                                    <span class="prop-detail__label"><?php echo esc_html($service); ?></span>
                                </span>
                            </li>
                            <?php
                        }
                    }
                }
            ?>
        </ul>
    </div>
</div>
