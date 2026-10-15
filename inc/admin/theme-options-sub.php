<?php

/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function tnb_main_options_metabox() {

	/**
	 * Registers main options page menu item and form.
	 */
	$info_options = new_cmb2_box( array(
		'id'           => 'tnb_main_options_page',
		'title'        => esc_html__( 'Información', 'cmb2' ),
		'object_types' => array( 'options-page' ),

		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

		'option_key'      => 'tnb_main_options', // The option key and admin menu page slug.
		// 'icon_url'        => 'dashicons-palmtree', // Menu icon. Only applicable if 'parent_slug' is left empty.
		// 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
		// 'parent_slug'     => 'themes.php', // Make options page a submenu item of the themes menu.
		// 'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'tnb_options_page_message_callback',
	) );

	/**
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */
	// $info_options->add_field( array(
	// 	'name'    => esc_html__( 'Site Background Color', 'cmb2' ),
	// 	'desc'    => esc_html__( 'field description (optional)', 'cmb2' ),
	// 	'id'      => 'bg_color',
	// 	'type'    => 'colorpicker',
	// 	'default' => '#ffffff',
	// ) );
	$info_options->add_field( array(
 		'name' 		 => 'Email',
 		'id'   		 => 'tnb_options_email',
 		'desc' 		 => 'A que email se enviaran los correos del formulario',
 		'type' 		 => 'text_email',
 	) );
 	$info_options->add_field( array(
 		'name'       => 'Teléfono/s',
 		'id'         => 'tnb_options_phone',
 		'type'       => 'text',
 		'repeatable' => true
 	));
 	$info_options->add_field( array(
 		'name'       => 'Fax',
 		'id'         => 'tnb_options_fax',
 		'type'       => 'text',
 	));

 	$info_options->add_field( array(
 		'name'      => 'Dirección',
 		'id'        => 'tnb_options_address',
 		'type'      => 'textarea',
 	));
 	$info_options->add_field( array(
 		'name'      => 'Localidad',
 		'id'        => 'tnb_options_location',
 		'type'      => 'textarea',
 	));
 	$info_options->add_field( array(
 		'name'         => 'Mapa',
 		'desc'         => 'Mover el marcador a la localidad exacta',
 		'id'           => 'tnb_options_map',
 		'type'         => 'pw_map',
 		'save_address' => true,
 		// 'split_values' => true, // Save latitude and longitude as two separate fields
 	));

	/**
	 * Registers extra options page, and set main item as parent.
	 */
	$extra_options = new_cmb2_box( array(
		'id'           => 'tnb_extra_options_page',
		'title'        => esc_html__( 'Extras', 'cmb2' ),
		'object_types' => array( 'options-page' ),

		'option_key'   => 'tnb_extra_options',
		'parent_slug'  => 'tnb_main_options',

		// 'icon_url'        => 'dashicons-palmtree', // Menu icon. Only applicable if 'parent_slug' is left empty.
		// 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
		// 'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'tnb_options_page_message_callback',
	) );

	$extra_options->add_field( array(
 		'name'     => 'Formulario de aviso',
		'id'       => 'tnb_options_notification_form',
		'desc'     => 'Insertar el shortcode del formulario de aviso de baja de precio',
 		'type'     => 'text',
 	));
	$extra_options->add_field( array(
 		'name'     => 'Formulario de consulta',
		'id'       => 'tnb_options_contact_form',
		'desc'     => 'Insertar el shortcode del formulario de aviso de contacto',
 		'type'     => 'text',
 	));
	/*
	$extra_options->add_field( array(
		'name'    => esc_html__( 'Test Radio', 'cmb2' ),
		'desc'    => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'      => 'radio',
		'type'    => 'radio',
		'options' => array(
			'option1' => esc_html__( 'Option One', 'cmb2' ),
			'option2' => esc_html__( 'Option Two', 'cmb2' ),
			'option3' => esc_html__( 'Option Three', 'cmb2' ),
		),
	) );
	*/

	/**
	 * Registers extra options page, and set main item as parent.
	 */
	$setup_options = new_cmb2_box( array(
		'id'           => 'tnb_setup_options_page',
		'title'        => esc_html__( 'Configuración', 'cmb2' ),
		'object_types' => array( 'options-page' ),

		'option_key'   => 'tnb_setup_options',
		'parent_slug'  => 'tnb_main_options',

		// 'icon_url'        => 'dashicons-palmtree', // Menu icon. Only applicable if 'parent_slug' is left empty.
		// 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
		// 'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'tnb_options_page_message_callback',
	) );

	$setup_options->add_field( array(
 		'name'     => 'API Key',
		'id'       => 'tnb_setup_API',
		'desc'     => 'API de Google maps',
 		'type'     => 'text',
 	));

	$setup_options->add_field( array(
 		'name'     => 'Map ID',
		'id'       => 'tnb_setup_map_id',
		'desc'     => 'Map ID de Google Maps (obligatorio para los marcadores avanzados). Creá uno en Google Cloud Console. Si se deja vacío se usa "DEMO_MAP_ID" (solo pruebas).',
 		'type'     => 'text',
 	));

	$setup_options->add_field( array(
 		'name'     => 'Latitud',
		'id'       => 'tnb_setup_lat',
		'desc'     => 'Latitud por defecto',
 		'type'     => 'text',
 	));

	$setup_options->add_field( array(
 		'name'     => 'Longitud',
		'id'       => 'tnb_setup_lon',
		'desc'     => 'Longitud por defecto',
 		'type'     => 'text',
 	));

	$setup_options->add_field( array(
 		'name'     => 'Miniaturas en galería',
		'id'       => 'tnb_setup_options_gallery',
		'desc'     => 'muestra hasta X imagenes, luego de este numero, listara "1 más"',
 		'type'     => 'text',
 		'default'     => '5',
		'attributes' => array(
			'type' => 'number',
			'min'  => '1',
		),
 	));

	/**
	 * Registers tertiary options page, and set main item as parent.
	 */
	 /*
	$tertiary_options = new_cmb2_box( array(
		'id'           => 'tnb_tertiary_options_page',
		'title'        => esc_html__( 'Tertiary Options', 'cmb2' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'tnb_tertiary_options',
		'parent_slug'  => 'tnb_main_options',
	) );

	$tertiary_options->add_field( array(
		'name' => esc_html__( 'Test Text Area for Code', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textarea_code',
		'type' => 'textarea_code',
	) );
	*/

}
add_action( 'cmb2_admin_init', 'tnb_main_options_metabox' );
