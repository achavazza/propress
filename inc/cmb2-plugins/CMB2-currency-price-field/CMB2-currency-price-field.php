<?php
/**
 * Returns options markup for a currency select field.
 * @param  mixed $value Selected/saved currency
 * @return string       html string containing all currency options
 */
function cmb2_get_currency_options( $value = false ) {
    $currencies = function_exists( 'tnb_currencies' )
        ? tnb_currencies()
        : array(
            '$'   => array( 'label' => '$',   'symbol' => '$' ),
            'U$S' => array( 'label' => 'U$S', 'symbol' => 'U$S' ),
            'otro' => array( 'label' => 'Otro', 'symbol' => '' ),
        );

	$currency_options = '';
	foreach ( $currencies as $code => $currency ) {
		$label = $currency['label'];
		if ( 'otro' !== $code && $currency['symbol'] !== '' ) {
			$label .= ' (' . $currency['symbol'] . ')';
		}
		$currency_options .= '<option value="'. esc_attr( $code ) .'" '. selected( $value, $code, false ) .'>'. esc_html( $label ) .'</option>';
	}

	return $currency_options;
}

/**
 * Render Price Field
 */
function cmb2_render_price_field_callback( $field, $value, $object_id, $object_type, $field_type ) {

    //pr($field);
    // make sure we specify each part of the value we need.
	$value = wp_parse_args( $value, array(
        'currency'   => '',
        'symbol'     => '',
		'value'      => '',
	) );

	$show_custom = ( 'otro' === $value['currency'] ) ? 'flex' : 'none';

	?>
    <div class="tnb-currency-price">
        <div class="tnb-currency-price__item">
            <?php echo $field_type->select( array(
                'name'     => $field_type->_name( '[currency]' ),
                'id'       => $field_type->_id( '_currency' ),
                'options'  => cmb2_get_currency_options( $value['currency'] ),
                'class'    => 'cmb2_select cmb2_currency_select',
                'onchange' => "var row=this.closest('.cmb-row');var box=row?row.querySelector('.cmb2_currency_custom'):null;if(box){box.style.display=(this.value==='otro')?'flex':'none';}",
                'desc'     => '',
            ) ); ?>
        </div>
        <div class="tnb-currency-price__item tnb-currency-price__custom cmb2_currency_custom" style="display:<?php echo esc_attr( $show_custom ); ?>">
            <?php echo $field_type->input( array(
                'class'       => 'cmb_text_small',
                'type'        => 'text',
                'name'        => $field_type->_name( '[symbol]' ),
                'id'          => $field_type->_id( '_symbol' ),
                'value'       => $value['symbol'],
                'placeholder' => __( 'Símbolo', 'tnb' ),
                'desc'        => '',
            ) ); ?>
        </div>
        <div class="tnb-currency-price__item tnb-currency-price__value">
            <?php echo $field_type->input( array(
                'class' => 'cmb_text_small',
                'name'  => $field_type->_name( '[value]' ),
                'id'    => $field_type->_id( '_value' ),
                'value' => $value['value'],
                'desc'  => '',
            ) ); ?>
        </div>
    </div>
	<?php
	echo $field_type->_desc( true );

}
add_filter( 'cmb2_render_currency_price', 'cmb2_render_price_field_callback', 10, 5 );
?>
