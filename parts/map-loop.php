<?php
$prop_img        = get_the_post_thumbnail_url(null, 'thumbnail');
$default         = get_attachment_url_by_slug('default', 'thumbnail');
$thumb           = empty($prop_img) ? $default : $prop_img;

// Fixed: Check if array keys exist before accessing
$prop_address    = isset($args['_prop_address'][0]) ? $args['_prop_address'][0] : '';
$prop_extra      = isset($args['_prop_extra'][0]) ? $args['_prop_extra'][0] : '';

$prop_rooms      = (isset($args['_prop_rooms'][0]) && $args['_prop_rooms'][0] != 0) ? $args['_prop_rooms'][0] : '';
$prop_sup        = (isset($args['_prop_sup'][0]) && $args['_prop_sup'][0] != 0) ? $args['_prop_sup'][0] : '';
$prop_dormrooms  = (isset($args['_prop_dormrooms'][0]) && $args['_prop_dormrooms'][0] != 0) ? $args['_prop_dormrooms'][0] : '';
$prop_bathrooms  = (isset($args['_prop_bathrooms'][0]) && $args['_prop_bathrooms'][0] != 0) ? $args['_prop_bathrooms'][0] : '';
$prop_garage     = (isset($args['_prop_garage'][0]) && $args['_prop_garage'][0] != 0) ? $args['_prop_garage'][0] : '';
$prop_time       = (isset($args['_prop_time'][0]) && $args['_prop_time'][0] != 0) ? $args['_prop_time'][0] : '';

//ahora estan parts/price-block.php
//$prop_sale       = ($args['_prop_price_sale'][0]!= '0,00') ? $args['_prop_price_sale'][0] : '';
//$prop_rent       = ($args['_prop_price_rent'][0]!= '0,00') ? $args['_prop_price_rent'][0] : '';
//$prop_currency   = currency()[$args['_prop_currency'][0]];
//$cur_symbol      = $prop_currency ? 'U$S' : '$';



$type            = get_the_terms($post, 'tipo')[0];
$prop_loc        = get_location($post);
 ?>
<div class="media is-align-items-center">
    <div class="media-left">
        <?php echo sprintf('<a class="image" href="%s"><img src="%s" /></a>', get_permalink(),  $thumb); ?>
    </div>
    <div class="media-content">
        <div class="prop-info mb-1">
            <span class="title is-6">
                <?php the_title(); ?>
            </span>
            <span class="subtitle is-5">
                <?php
                if($prop_address):
                    echo $prop_address;
                endif;
                if ($prop_loc):
                    echo sprintf('- %s', $prop_loc);
                endif;
                ?>
            </span>
        </div>
        <div>
            <span class="is-block mb-3">
                <?php
                //$args = $args;
                //pase todos los contenidos a un template
                //get_template_part('parts/price','block', $data)
                //echo price_block($data);
                echo price_block($post->ID);
                ?>
            </span>
            <div class="level mb-3">
                <ul class="level-left">
                    <?php if(isset($prop_dormrooms)):
                        $dorms = intval($prop_dormrooms);
                        ?>
                        <li class="level-item">
                            <span class="icon-text">
                                <span class="icon material-icons icon-small" title="<?php echo ($dorms == 1) ? "$dorms Dormitorio" : "$dorms Dormitorios"; ?>">
                                    hotel
                                </span>
                                <span><?php echo sprintf("%d", $dorms); ?></span>
                            </span>
                        </li>
                    <?php endif; ?>
                    <?php
                    if(isset($prop_bathrooms)):
                        $baths = intval($prop_bathrooms);
                        ?>
                        <li class="level-item">
                            <span class="icon-text">
                                <span class="icon material-icons icon-small" title="<?php echo ($baths == 1) ? "$baths Baño" : "$baths Baños";?>">
                                    bathtub
                                </span>
                                <span><?= sprintf("%d", $baths);?></span>
                            </span>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php /*
            <ul class="prop-list flush">
                <?php if($prop_rooms): ?>
                <li title="<?php echo __('Ambientes') ?>">
                        <i class="icons-big icon-rooms"></i>
                        &nbsp;
                        <?php echo $prop_rooms; ?>
                </li>
                <?php endif; ?>
                <?php if($prop_sup): ?>
                <li title="<?php echo __('Superficie') ?>">
                        <i class="icons-big icon-sup"></i>
                        &nbsp;
                        <?php echo $prop_sup; ?>
                        m<sup>2</sup>
                </li>
                <?php endif; ?>
                <?php if($prop_dormrooms): ?>
                <li title="<?php echo __('Dormitorios') ?>">
                        <i class="icons-big icon-bed"></i>
                        &nbsp;
                        <?php echo $prop_dormrooms; ?>
                </li>
                <?php endif; ?>
                <?php if($prop_bathrooms): ?>
                <li title="<?php echo __('Baños') ?>">
                        <i class="icons-big icon-bath"></i>
                        &nbsp;
                        <?php echo $prop_bathrooms; ?>
                </li>
                <?php endif; ?>
                <?php if($prop_garage): ?>
                <li title="<?php echo __('Cochera') ?>">
                        <i class="icons-big icon-garage"></i>
                        &nbsp;
                        <?php echo $prop_garage; ?>
                </li>
                <?php endif; ?>
                <?php if($prop_time): ?>
                <li title="<?php echo __('Antigüedad') ?>">
                        <i class="icons-big icon-time"></i>
                        &nbsp;
                        <?php echo $prop_time; ?>
                </li>
                <?php endif; ?>
            </ul>
            */ ?>

            <?php /*
            <div class="price-block">
                <?php if(!$prop_sale && !$prop_rent): ?>
                    <strong>Precio: </strong>
                    <?php echo __('Consultar') ?>
                <?php else: ?>
                    <?php if($prop_rent): ?>
                        <strong>Alquiler: </strong>
                        <?php if(isset($_GET['operacion']) && $_GET['operacion'] == 'alquiler'){
                            echo '<strong class="highlight">'.'$'.$prop_rent.'</strong>';
                        }else{
                            echo '$'.$prop_rent;
                        } ?>
                    <?php endif; ?>
                    <?php if($prop_sale && $prop_rent): ?>
                        <?php echo ' | ' ?>
                    <?php endif; ?>
                    <?php if($prop_sale): ?>
                        <strong>Venta: </strong>
                        <?php if(isset($_GET['operacion']) && $_GET['operacion'] != 'alquiler'){
                            echo '<strong class="highlight">'.'$'.$prop_sale.'</strong>';
                        }else{
                            echo '$'.$prop_sale;
                        } ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            */ ?>
            <div class="is-flex is-justify-content-end">
                <a class="button is-primary" href="<?php the_permalink() ?>">
                    <?php echo __('Mas Info') ?>
                </a>
            </div>
        </div>
    </div>
    <?php /*
    <?php if(isset($type)): ?>
        <div class="media-right">
            <a class="prop-icon-type" href="<?= isset($type) ? get_term_link($type) : home_url().'/?s='; ?>" title="<?php echo __('Tipo de propiedad') ?>">
                <span class="material-icons md-36" <?= isset($type) ? $type->name : __('Propiedad', 'tnb'); ?>>business</span>
                <span>
                    <?= $type->name  ?>
                </span>
            </a>
        </div>
    <?php endif; ?>
    */ ?>
    <?php /*
    <?php if($type): ?>
    <h4 class="h4">
    <a href="<?php echo get_term_link($type); ?>">
    <?php echo $type->name; ?>
    </a>
    </h4>
    <?php endif; ?>
    */ ?>
</div>
