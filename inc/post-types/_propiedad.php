<?php
/*
 * Register a Custom Post Type (Propiedad)
 */
add_action('init', 'propiedad_init');

function propiedad_init() {
    $labels = array(
        'name'               => _x('Propiedades', 'post type general name'),
        'singular_name'      => _x('Propiedad', 'post type singular name'),
        'add_new'            => _x('Agregar Nueva', 'propiedades'),
        'add_new_item'       => __('Agregar Nueva propiedad'),
        'edit_item'          => __('Editar propiedad'),
        'new_item'           => __('Nueva propiedad'),
        'view_item'          => __('Ver propiedad'),
        'search_items'       => __('Buscar propiedades'),
        'not_found'          => __('No se encontraron propiedades'),
        'not_found_in_trash' => __('No no se encontraron propiedades en la papelera'),
        'parent_item_colon'  => '',
        'menu_name'          => 'Propiedades'
    );
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        //'show_in_nav_menus'  => true,
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'has_archive'        => 'propiedad',
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-admin-multisite',
        'supports'           => array('title', 'editor', 'thumbnail'),
        // Fixed: Removed 'tipo' and 'operacion' from taxonomies array
        // These are now handled by CMB2 fields in 'Detalles de la operación' metabox
        // Only keep taxonomies that should appear in the sidebar
        'taxonomies'         => array('location')
    );
    register_post_type('propiedad', $args);
}

/* Update galeria Messages */
add_filter('post_updated_messages', 'propiedades_updated_messages');

function propiedades_updated_messages($messages) {
    global $post, $post_ID;
    $messages['propiedad'] = array(
        0 => '',
        1 => sprintf(__('Propiedad actualizada.'), esc_url(get_permalink($post_ID))),
        2 => __('Custom field actualizado.'),
        3 => __('Custom field deleted.'),
        4 => __('Propiedad actualizada.'),
        5 => isset($_GET['revision']) ? sprintf(__('Propiedad restaurada de revisión desde %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
        6 => sprintf(__('Propiedad publicada.'), esc_url(get_permalink($post_ID))),
        7 => __('Propiedad guardada.'),
        8 => sprintf(__('Propiedad publicada.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
        9 => sprintf(__('Propiedad archivada para: <strong>%1$s</strong>. '), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
        10 => sprintf(__('Propiedad en borrador actualizado.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
    );
    return $messages;
}

/* Update galeria Help - deprecated contextual_help, using get_current_screen() instead
add_action('current_screen', 'propiedades_help_text');
    function propiedades_help_text($screen) {
    if ('propiedades' == $screen->id) {
        $screen->add_help_tab(
            array(
                'id'      => 'propiedades_help',
                'title'   => __('Ayuda Propiedades', 'tnb'),
                'content' =>
                    '<p>' . __('Cosas para recordar a la hora de agregar una propiedad:') . '</p>' .
                    '<ul>' .
                    '<li>' . __('El campo Tipo es obligatorio y debe seleccionarse siempre', 'tnb') . '</li>' .
                    '<li>' . __('La Operación (Venta/Alquiler) también es requerida', 'tnb') . '</li>' .
                    '<li>' . __('Complete todos los campos importantes para mejor visibilidad', 'tnb') . '</li>' .
                    '</ul>',
            )
        );
    }
    elseif ('edit-propiedades' == $screen->id) {
        $screen->add_help_tab(
            array(
                'id'      => 'propiedades_edit_help',
                'title'   => __('Ayuda Editar', 'tnb'),
                'content' =>
                    '<p>' . __('Cosas para recordar a la hora de editar una propiedad:') . '</p>' .
                    '<ul>' .
                    '<li>' . __('Mantenga actualizada la información del Tipo y Operación', 'tnb') . '</li>' .
                    '<li>' . __('Verifique que todas las coordenadas del mapa sean correctas', 'tnb') . '</li>' .
                    '</ul>',
            )
        );
    }
}
*/

// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_propiedad_taxonomies', 0 );

function create_propiedad_taxonomies() {

    // Tipos de propiedades (Casa, Cabaña, Depto, etc.)
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name'                       => _x( 'Tipo de propiedades', 'taxonomy general name' ),
        'singular_name'              => _x( 'Tipo de propiedad', 'taxonomy singular name' ),
        'search_items'               => __( 'Buscar tipo de propiedades' ),
        'popular_items'              => __( 'Tipo de propiedades populares' ),
        'all_items'                  => __( 'Todos los tipos de propiedad' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Editar tipo de propiedad' ),
        'update_item'                => __( 'Actualizar tipo de propiedad' ),
        'add_new_item'               => __( 'Agregar nuevo tipo de propiedad' ),
        'new_item_name'              => __( 'Nombre del tipo de propiedad' ),
        'separate_items_with_commas' => __( 'Separar los tipos de propiedad con comas' ),
        'add_or_remove_items'        => __( 'Agregar o quitar tipos de propiedad' ),
        'choose_from_most_used'      => __( 'Elige de los tipos de propiedades más populares' ),
        'not_found'                  => __( 'No se encontraron tipos de propiedad' ),
        'menu_name'                  => __( 'Tipos de propiedades' ),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => true,
        'show_in_quick_edit'    => true,
        //'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'tipo' ),
    );

    register_taxonomy( 'tipo', 'propiedad', $args );

    // Tipos de operación (Compra, venta, inversión, etc.)
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name'                       => _x( 'Operaciones', 'taxonomy general name' ),
        'singular_name'              => _x( 'Tipo de operación', 'taxonomy singular name' ),
        'search_items'               => __( 'Buscar operaciones' ),
        'popular_items'              => __( 'Operaciones populares' ),
        'all_items'                  => __( 'Todas las operaciones' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Editar operación' ),
        'update_item'                => __( 'Actualizar operación' ),
        'add_new_item'               => __( 'Agregar operación' ),
        'new_item_name'              => __( 'Nombre del tipo de operación' ),
        'separate_items_with_commas' => __( 'Separar los tipos de operación con comas' ),
        'add_or_remove_items'        => __( 'Agregar o quitar tipos de operación' ),
        'choose_from_most_used'      => __( 'Elige de las operaciones más populares' ),
        'not_found'                  => __( 'No se encontraron tipos de operación' ),
        'menu_name'                  => __( 'Operaciones' ),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => true,
        //'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'operacion' ),
    );

    register_taxonomy( 'operacion', 'propiedad', $args );


    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name'                       => _x( 'Estado', 'taxonomy general name' ),
        'singular_name'              => _x( 'Tipo de estado', 'taxonomy singular name' ),
        'search_items'               => __( 'Buscar estados' ),
        'popular_items'              => __( 'Estados populares' ),
        'all_items'                  => __( 'Todos los estados' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Editar estado' ),
        'update_item'                => __( 'Actualizar operación' ),
        'add_new_item'               => __( 'Agregar estado' ),
        'new_item_name'              => __( 'Nombre del estados' ),
        'separate_items_with_commas' => __( 'Separar los estados con comas' ),
        'add_or_remove_items'        => __( 'Agregar o quitar estados' ),
        'choose_from_most_used'      => __( 'Elige de los estados más populares' ),
        'not_found'                  => __( 'No se encontraron estados' ),
        'menu_name'                  => __( 'Estados' ),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => true,
        //'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'estado' ),
    );

    register_taxonomy( 'estado', 'propiedad', $args );



    // Tipos de operación (Compra, venta, inversión, etc.)
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name'                       => _x( 'Localidad', 'taxonomy general name' ),
        'singular_name'              => _x( 'Localidad', 'taxonomy singular name' ),
        'search_items'               => __( 'Buscar localidades' ),
        'popular_items'              => __( 'Localidades populares' ),
        'all_items'                  => __( 'Todas las localidades' ),
        'parent_item'                => __( 'Localidad padre' ),
        'parent_item_colon'          => __( 'Localidad padre:' ),
        'edit_item'                  => __( 'Editar localidad' ),
        'update_item'                => __( 'Actualizar localidad' ),
        'add_new_item'               => __( 'Agregar localidad' ),
        'new_item_name'              => __( 'Nombre de la localidad' ),
        'separate_items_with_commas' => __( 'Separar las localidades con comas' ),
        'add_or_remove_items'        => __( 'Agregar o quitar localidades' ),
        'choose_from_most_used'      => __( 'Elige de las localidades más populares' ),
        'not_found'                  => __( 'No se encontraron localidades' ),
        'menu_name'                  => __( 'Localidades' ),
    );

    $args = array(
        'hierarchical'          => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => true,
        //'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'location' ),
        'description'           => __('Vamos a usar localidades para localizar las propiedades, tanto Ciudad como Zona barrio, etc.'),
    );

    register_taxonomy( 'location', 'propiedad', $args );
}
?>

<?php

// custom metaboxes
add_action( 'cmb2_init', 'cmb2_propiedades' );


/**
 * Define the metabox and field configurations.
 */
function cmb2_propiedades() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_prop_';

    /**
     * Initiate the metabox
     */

    /* CMB ==================================== */
    $cmb = new_cmb2_box( array(
        'id'            => 'op_metabox',
        'title'         => __( 'Detalles de la operación', 'cmb2' ),
        'object_types'  => array( 'propiedad' ), // post type
        //'show_on'       => array( 'key' => 'page-template', 'value' => 'page-products.php' ),
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

    $cmb->add_field( array(
        'name'     => 'Elija el tipo de propiedad',
        'desc'     => 'Casa, Depto, Cabaña, etc.',
        'id'       => $prefix .'tipo',
        'taxonomy' => 'tipo',
        'type'     => 'taxonomy_select',
        // Optional:
        'options' => array(
            'no_terms_text' => __('Lo sentimos, no encontramos un tipo de propiedad, agregue una') // Change default text. Default: "No terms"
        ),
    ) );
    $cmb->add_field( array(
        'name'     => 'Elija el tipo de operación',
        'desc'     => 'Venta, Alquiler, inversión, etc.',
        'id'       => $prefix .'operacion',
        'taxonomy' => 'operacion',
        'select_all_button' => false,
        'type'     => 'taxonomy_multicheck',
        // Optional:
        'options' => array(
            'no_terms_text' => __('Lo sentimos, no encontramos un tipo de operación, agregue una') // Change default text. Default: "No terms"
        ),
    ) );
    $cmb->add_field( array(
        'name'     => 'Valor Alquiler',
        'desc'     => '(Solo se muestra en caso de que la operación sea alquiler)',
        'id'       => $prefix .'price_rent',
        'type'     => 'text',
        'attributes' => array(
            'type' => 'number',
            'pattern' => '\d*',
        ),
        'sanitization_cb' => 'absint',
        'escape_cb'       => 'absint',
        //'type'     => 'text_money',
    ) );
    $cmb->add_field( array(
        'name'     => 'Valor Venta',
        'desc'     => '(Solo se muestra en caso de que la operación sea venta)',
        'id'       => $prefix .'price_sale',
        'type' => 'text',
        'attributes' => array(
            'type' => 'number',
            'pattern' => '\d*',
        ),
        'sanitization_cb' => 'absint',
        'escape_cb'       => 'absint',
        //'escape_cb'       => 'intval',
        //'type'     => 'text_money',
    ) );

    /* CMB2 ==================================== */

    $cmb2 = new_cmb2_box( array(
        'id'            => 'prop_metabox',
        'title'         => __( 'Información de la propiedad', 'cmb2' ),
        'object_types'  => array( 'propiedad' ), // post type
        //'show_on'       => array( 'key' => 'page-template', 'value' => 'page-products.php' ),
        'context'       => 'normal',
        'priority'      => 'low',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );
    $cmb2->add_field( array(
        'name'     => 'Dirección',
        'id'       => $prefix .'address',
        'type'     => 'text',
    ) );

    $cmb2->add_field( array(
        'name'     => 'Extra',
        'desc'     => 'Por si se desea agregar 1er piso A, Contrafrente, etc.',
        'id'       => $prefix .'extra',
        'type'     => 'text',
    ) );

    /*
    LO saco de aca, voy a usar taxonomies
    $cmb2->add_field( array(
        'name'     => 'Localidad',
        'id'       => $prefix .'location',
        'type'     => 'select',
        'options'  => location(),
    ) );
    $cmb2->add_field( array(
        'name'       => 'Zona',
		'id'         => $prefix . 'zone',
		'type'       => 'select',
        'options'    => zones(),
	) );
    */

    $cmb2->add_field( array(
        'name' => 'Lugar',
        'desc' => 'Elija la dirección, si no aparece, arrastre el marcador hasta el punto exacto',
        'id'   => $prefix . 'map',
        'type' => 'pw_map',
        // 'split_values' => true, // Save latitude and longitude as two separate fields
    ));


    /* CMB3 ==================================== */

    $cmb3 = new_cmb2_box( array(
        'id'            => 'detail_metabox',
        'title'         => __( 'Detalles de la propiedad', 'cmb2' ),
        'object_types'  => array( 'propiedad' ), // post type
        //'show_on'       => array( 'key' => 'page-template', 'value' => 'page-products.php' ),
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );
    $cmb3->add_field( array(
        'name'        => 'Ambientes',
        'id'          => $prefix . 'rooms',
        'type'        => 'text',
        'sanitization_cb' => 'sanitize_int',
        'attributes'  => array(
            'type'    => 'number',
            'pattern' => '\d*',
        ),
    ) );
    $cmb3->add_field( array(
        'name'        => 'Superficie',
        'desc'        => 'en Metros Cuadrados',
        'id'          => $prefix . 'sup',
        'type'        => 'text',
        'sanitization_cb' => 'sanitize_int',
        'attributes'  => array(
            'type'    => 'number',
            'pattern' => '\d*',
        ),
    ) );
    $cmb3->add_field( array(
        'name'        => 'Antigüedad',
        'desc'        => 'Antiguedad de la propiedad (en años)',
        'id'          => $prefix . 'time',
        'type'        => 'text',
        'sanitization_cb' => 'sanitize_int',
        'attributes'  => array(
            'type'    => 'number',
            'pattern' => '\d*',
        ),
    ) );
    $cmb3->add_field( array(
        'name'        => 'Dormitorios',
        'id'          => $prefix . 'dormrooms',
        'type'        => 'text',
        'sanitization_cb' => 'sanitize_int',
        'attributes'  => array(
            'type'    => 'number',
            'pattern' => '\d*',
        ),
    ) );
    $cmb3->add_field( array(
        'name'        => 'Baños',
        'id'          => $prefix . 'bathrooms',
        'type'        => 'text',
        'sanitization_cb' => 'sanitize_int',
        'attributes'  => array(
            'type'    => 'number',
            'pattern' => '\d*',
        ),
    ) );
    $cmb3->add_field( array(
        'name'        => 'Garage',
        'id'          => $prefix . 'garage',
        'type'        => 'text',
        'sanitization_cb' => 'sanitize_int',
        'attributes'  => array(
            'type'    => 'number',
            'pattern' => '\d*',
        ),
    ) );
    $cmb3->add_field( array(
    	'name'              => 'Servicios',
    	'id'                => $prefix .'services',
    	'type'              => 'multicheck',
        'select_all_button' => true,
    	'options'           => services(),
    	/*'options' => array(
    		1 => 'Agua Corriente',
    		2 => 'Gas Natural',
    		3 => 'Conexión Eléctrica',
    	),*/
    ));
    $cmb3->add_field( array(
    	'name'              => 'Estado',
    	'id'                => $prefix .'status',
    	'type'              => 'multicheck',
        'select_all_button' => false,
        'options'           => status(),
    	/*'options' => array(
    		1 => 'En construcción',
    		2 => 'Apta crédito',
    		3 => 'En Sucesión',
    	),*/
    ));

    $cmb3->add_field( array(
        'name'             => 'Frase',
        'id'               => $prefix . 'phrase',
        'desc'             => 'Frases llamadoras de atención',
        'type'             => 'select',
        'show_option_none' => true,
        'options'          => phrases(),
    ) );

    $cmb3->add_field( array(
        'name'             => 'Destacado',
        'id'               => $prefix .'featured',
        'desc'             => 'Marcar como propiedad destacada',
        'type'             => 'checkbox',
    ) );


    /* CMB4 ==================================== */

    $cmb4 = new_cmb2_box( array(
        'id'            => 'gallery_metabox',
        'title'         => __( 'Galería de imágenes', 'cmb2' ),
        'object_types'  => array( 'propiedad' ), // post type
        //'show_on'       => array( 'key' => 'page-template', 'value' => 'page-products.php' ),
        'context'       => 'normal',
        'priority'      => 'low',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

    $cmb4->add_field( array(
        'name'            => 'Imágenes',
        'desc'            => 'Subir y administrar imágenes',
        'button'          => 'Administrar Galería', // Optionally set button label
        'id'              => $prefix . 'images',
        'type'            => 'pw_gallery',
        'sanitization_cb' => 'pw_gallery_field_sanitise',
    ));

}


function sanitize_int( $value, $field_args, $field ) {
	// Don't keep anything that's not numeric
	if ( ! is_numeric( $value ) ) {
		$sanitized_value = '';
	} else {
		// Ok, let's clean it up.
		$sanitized_value = absint( $value );
	}
	return $sanitized_value;
}

?>
