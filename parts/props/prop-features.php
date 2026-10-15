<?php
// Fixed: Check if meta keys exist before accessing
$data              = get_post_meta($post->ID);
$prop_rooms        = isset($data['_prop_rooms'][0]) ? $data['_prop_rooms'][0] : '';
$prop_sup          = isset($data['_prop_sup'][0]) ? $data['_prop_sup'][0] : '';
$prop_dormrooms    = isset($data['_prop_dormrooms'][0]) ? $data['_prop_dormrooms'][0] : '';
$prop_bathrooms    = isset($data['_prop_bathrooms'][0]) ? $data['_prop_bathrooms'][0] : '';
//$prop_garage     = isset($data['_prop_garage'][0]) ? $data['_prop_garage'][0] : '';
//$prop_time       = isset($data['_prop_time'][0]) ? $data['_prop_time'][0] : '';

// Fixed: Define $type variable if not set
if (!isset($type)) {
    $type = null;
}

// Per-term Lucide icon (fallback to a generic property icon).
$type_icon = isset($type) && !is_wp_error($type) ? tnb_get_term_icon($type->term_id) : '';
if (!$type_icon) {
    $type_icon = 'building-2';
}
?>
<div class="card block">
<div class="card-content">
    <ul class="prop-list is-unstyled">
        <li>
            <?php if(!$type):?>
            <a class="icon-text" href="<?php echo home_url().'/?s=' ?>" title="<?php echo __('Tipo de propiedad') ?>">
                <span class="block align-center">
                    <?php echo tnb_icon($type_icon); ?>
                </span>
                &nbsp;
                <?php echo 'Propiedad' ?>
            </a>
            <?php else: ?>
            <a class="icon-text" href="<?php echo get_term_link($type); ?>" title="<?php echo __('Tipo de propiedad') ?>">
                <span class="icon">
                    <?php echo tnb_icon($type_icon); ?>
                </span>
                <span>
                    <?php echo $type->name; ?>
                </span>
            </a>
            <?php endif; ?>
        </li>
        <?php if($prop_dormrooms): ?>
        <li>
            <span class="icon-text" title="<?php echo __('Dormitorios') ?>">
                <span class="icon">
                    <?php echo tnb_icon('bed'); ?>
                </span>
                <span>
                <?php
                    if(!$prop_dormrooms):
                        $prop_dormrooms = 0;
                    endif;
                    $dorms = intval($prop_dormrooms);
                    echo ($dorms == 1) ? "$dorms Dormitorio" : "$dorms Dormitorios";
                ?>
                </span>
            </span>
        </li>
        <?php endif; ?>
        <?php if($prop_bathrooms): ?>
        <li>
            <span class="icon-text" title="<?php echo __('Baños') ?>">
                <span class="icon">
                    <?php echo tnb_icon('toilet'); ?>
                    <!-- <i class="icon cofasa-linear icon-l icon-bath"></i> -->
                </span>
                <span>
                    <?php
                        //if(!$prop_bathrooms):
                        //    $prop_bathrooms = 0;
                        //endif;
                        $baths = intval($prop_bathrooms);
                        echo ($baths == 1) ? "$baths Baño" : "$baths Baños";
                    ?>
                </span>
            </span>
        </li>
        <?php endif; ?>
    </ul>
</div>
</div>
