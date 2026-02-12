<?php
/*
Plugin Name: CMB2 Field Type: Google Maps
Plugin URI: https://github.com/mustardBees/cmb_field_map
GitHub Plugin URI: https://github.com/mustardBees/cmb_field_map
Description: Google Maps field type for CMB2.
Version: 2.1.2
Author: Phil Wylie
Author URI: http://www.philwylie.co.uk/
License: GPLv2+
*/

/**
 * Class PW_CMB2_Field_Google_Maps
 */

define( 'CMB2_FIELDMAP_URL', get_template_directory_uri().'/inc/cmb2-plugins/CMB2_field_map/');
class PW_CMB2_Field_Google_Maps {

	/**
	 * Current version number
	 */
	const VERSION = '2.1.1';

	/**
	 * Initialize the plugin by hooking into CMB2
	 */
	public function __construct() {
		add_filter( 'cmb2_render_pw_map', array( $this, 'render_pw_map' ), 10, 5 );
		add_filter( 'cmb2_sanitize_pw_map', array( $this, 'sanitize_pw_map' ), 10, 4 );
	}

	/**
	 * Render field
	 */
	public function render_pw_map( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {
		$this->setup_admin_scripts();


		echo $field_type_object->input( array(
			'type'       => 'text',
			'name'       => $field->args('_name') . '[address]',
			'value'      => isset( $field_escaped_value['address'] ) ? $field_escaped_value['address'] : '',
			'class'      => 'large-text pw-map-search',
			'id'         => $field->args( 'id' ),
			'desc'       => '',
		) );

		//echo '<input type="text" class="large-text pw-map-search" id="' . $field->args( 'id' ) . '" />';

		echo '<div class="pw-map"></div>';

		$field_type_object->_desc( true, true );

		echo $field_type_object->input( array(
			'type'       => 'hidden',
			'name'       => $field->args('_name') . '[latitude]',
			'value'      => isset( $field_escaped_value['latitude'] ) ? $field_escaped_value['latitude'] : '',
			'class'      => 'pw-map-latitude',
			'desc'       => '',
		) );
		echo $field_type_object->input( array(
			'type'       => 'hidden',
			'name'       => $field->args('_name') . '[longitude]',
			'value'      => isset( $field_escaped_value['longitude'] ) ? $field_escaped_value['longitude'] : '',
			'class'      => 'pw-map-longitude',
			'desc'       => '',
		) );

		//pr($field_type_object);
	}

	/**
	 * Optionally save the latitude/longitude values into two custom fields
	 */
	public function sanitize_pw_map( $override_value, $value, $object_id, $field_args ) {

		if ( ! empty( $value['address'] ) ) {
			update_post_meta( $object_id, $field_args['id'] . '_address', $value['address'] );
		}

		if ( isset( $field_args['split_values'] ) && $field_args['split_values'] ) {
			if ( ! empty( $value['latitude'] ) ) {
				update_post_meta( $object_id, $field_args['id'] . '_latitude', $value['latitude'] );
			}

			if ( ! empty( $value['longitude'] ) ) {
				update_post_meta( $object_id, $field_args['id'] . '_longitude', $value['longitude'] );
			}
		}

		return $value;
	}

	/**
	 * Enqueue scripts and styles
	 */

	public function setup_admin_scripts() {
		// Check if GMaps key is available
		if (!defined('GMAPS_KEY') || empty(GMAPS_KEY)) {
			// Display admin notice for missing GMaps key
			add_action('admin_notices', function() {
				?>
				<div class="notice notice-warning is-dismissible">
					<p><strong><?php _e('Map Field Warning:', 'cmb2'); ?></strong> <?php _e('Google Maps API key is required for map fields to work. Please configure it in Theme Options.', 'cmb2'); ?></p>
				</div>
				<?php
			});
			return;
		}

		wp_register_script( 'pw-google-maps-api', '//maps.googleapis.com/maps/api/js?libraries=places&amp;key='.GMAPS_KEY, null, null );
		//wp_enqueue_script( 'pw_gallery_init', PW_GALLERY_URL . '/js/script.js', array( 'jquery' ), null );
		//wp_enqueue_style ( 'pw_gallery_init', PW_GALLERY_URL . '/css/style.css');

		wp_enqueue_script( 'pw-google-maps', CMB2_FIELDMAP_URL . 'js/script.js'  , array( 'pw-google-maps-api' ), self::VERSION );
		wp_enqueue_style( 'pw-google-maps',  CMB2_FIELDMAP_URL . 'css/style.css' , array(), self::VERSION );
	}
}
$pw_cmb2_field_google_maps = new PW_CMB2_Field_Google_Maps();
