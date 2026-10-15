<?php
function price_block($ID){

$ops = get_the_terms($ID, 'operacion');

// Each operation (alquiler / venta) stores its own currency + symbol + value.
$price_sale = get_post_meta( $ID, '_prop_price_sale', true );
$price_rent = get_post_meta( $ID, '_prop_price_rent', true );

$sale_empty = tnb_price_is_empty( $price_sale );
$rent_empty = tnb_price_is_empty( $price_rent );

ob_start();
?>
<span class="price-block level">
    <span class="level-left">
        <?php if($sale_empty && $rent_empty):
            echo '<span class="level-item">';
            echo sprintf('<span>Precio: <strong>%s</strong></span>', __('Consultar'));
            echo '</span>';
        else:
            if(has_term('alquiler','operacion') && !$rent_empty):
                $val = tnb_format_price( $price_rent );
                echo '<span class="level-item">';
                echo sprintf('<span class="rent-price" title="Precio de alquiler">%s</span>', $val);
                echo '</span>';
            endif;
            if(has_term('alquiler','operacion') && has_term('venta','operacion')):
                echo '<span class="level-item">';
                echo ' | ';
                echo '</span>';
            endif;
            if(has_term('venta','operacion') && !$sale_empty):
                $val = tnb_format_price( $price_sale );
                echo '<span class="level-item">';
                echo sprintf('<span class="sale-price" title="Precio de venta">%s</span>', $val);
                echo '</span>';
            endif;
        endif;
        ?>
    </span>
</span>
<?php
$out = ob_get_contents();
ob_end_clean();
return $out;
}
?>
