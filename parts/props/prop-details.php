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
        ?>
        <ul class="is-unstyled">
            <?php /*
            AMBIENTES
            <?php if($prop_rooms): ?>
                <li>
                    <?php echo sprintf(__('Ambientes: %s'), $prop_rooms) ?>
                </li>
            <?php endif; ?>
            */ ?>
            <?php if($prop_sup): ?>
                <li>
                    <?php
                    $prop_sup_val = $prop_sup. ' m<sup>2</sup>';
                    echo '<i class="cofasa-img-icons icon-star"></i>';
                    echo sprintf(__('Superficie: %s'), $prop_sup_val) ?>
                </li>
            <?php endif; ?>
            <?php if($prop_dormrooms): ?>
                <li>
                    <?php
                    echo '<i class="cofasa-img-icons icon-star"></i>';
                    echo sprintf(__('Dormitorios: %s'), $prop_dormrooms) ?>
                </li>
            <?php endif; ?>
            <?php if($prop_bathrooms): ?>
                <li>
                    <?php
                    echo '<i class="cofasa-img-icons icon-star"></i>';
                    echo sprintf(__('Baños: %s'), $prop_bathrooms)
                    ?>
                </li>
            <?php endif; ?>
            <?php

                if($features){
                    $i = 0;
                    foreach($features as $feature){
                        if($feature){
                            echo '<li>';
                            echo '<i class="cofasa-img-icons icon-star"></i>';
                            echo $feature->name.': ' . __('Si');
                            echo '</li>';
                            $i++;
                        }
                    }
                }
            ?>
            <?php if($prop_front): ?>
                <li>
                    <?php
                        $val_front = isset( $front[ $prop_front ] ) ? $front[ $prop_front ] : ' ';
                        echo '<i class="cofasa-img-icons icon-star"></i>';
                        echo sprintf(__('Ubicación: %s'), $val_front);
                    ?>
                </li>
            <?php endif; ?>
            <?php if($prop_orientation): ?>
                <li>
                    <?php
                        $val_orientation = isset( $orientation[ $prop_orientation ] ) ? $orientation[ $prop_orientation ] : ' ';
                        echo '<i class="cofasa-img-icons icon-star"></i>';
                        echo sprintf(__('Orientación: %s'), $val_orientation);
                    ?>
                </li>
            <?php endif; ?>
            <?php
                if($prop_services){
                    $i = 0;
                    foreach($services as $k => $service){
                        if($service){
                            echo '<li>';
                            echo '<i class="cofasa-img-icons icon-star"></i>';
                            echo $service;
                            echo ': ';
                            echo in_array($k, $prop_services) ? __('Si') : __('No');
                            echo '</li>';
                            $i++;
                        }
                    }
                }
            ?>
        </ul>
    </div>
</div>
