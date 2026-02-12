<?php
/**
 * Returns options markup for a currency select field.
 * @param  mixed $value Selected/saved currency
 * @return string       html string containing all currency options
 */
function cmb2_get_currency_options( $value = false ) {
    $currency_list = array('$'=>'$', 'U$S'=>'U$S');
	//$currency_list = array( 'AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut','DE'=>'Delaware','DC'=>'District Of Columbia','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois','IN'=>'Indiana','IA'=>'Iowa','KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland','MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma','OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming' );

	$currency_options = '';
	foreach ( $currency_list as $abrev => $currency ) {
		$currency_options .= '<option value="'. $abrev .'" '. selected( $value, $abrev, false ) .'>'. $currency .'</option>';
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
		'value'      => '',
	) );

	?>
    <div class="alignleft">
        <?php echo $field_type->select( array(
            'name'    => $field_type->_name( '[currency]' ),
            'id'      => $field_type->_id( '_currency' ),
            'options' => cmb2_get_currency_options( $value['currency'] ),
            'desc'    => '',
        ) ); ?>
    </div>
	<div class="alignleft">
		<?php echo $field_type->input( array(
			'class' => 'cmb_text_small',
			'name'  => $field_type->_name( '[value]' ),
			'id'    => $field_type->_id( '_value' ),
			'value' => $value['value'],
			'desc'  => '',
		) ); ?>
	</div>
	<br class="clear">
	<?php
	echo $field_type->_desc( true );

}
add_filter( 'cmb2_render_currency_price', 'cmb2_render_price_field_callback', 10, 5 );
?>
