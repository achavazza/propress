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
        'not_found_in_trash' => __('No se encontraron propiedades en la papelera'),
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
        'menu_position'      => 8,
        'menu_icon'          => 'dashicons-admin-multisite',
        'supports'           => array('title', 'editor', 'thumbnail'),
        // Fixed: Added 'prestaciones' to taxonomies array so it works like Servicios
        'taxonomies'         => array('tipo', 'operacion', 'location', 'status', 'prestaciones')
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
    elseif ('edit-propiedades' == $screen->id) {
        $contextual_help = '<p>' . __('Una lista de todos los galerias aparece debajo. para editar un galeria haga click en el título.') . '</p>';
    }
    return $contextual_help;
}
*/

// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_propiedad_taxonomies', 0 );

function create_propiedad_taxonomies() {

    // Tipos de propiedades (Casa, Cabaña, Depto, etc.)
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name'                       => _x( 'Tipo', 'taxonomy general name' ),
        'singular_name'              => _x( 'Tipo', 'taxonomy singular name' ),
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
        'menu_name'                  => __( 'Tipo' ),
        'back_to_items'              => __( '← Volver a Tipos', 'tnb' ),
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
        'rewrite'               => array( 'slug' => 'propiedad-tipo' ),
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
        'back_to_items'              => __( '← Volver a Operaciones', 'tnb' ),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => true,
        //'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'propiedad-operacion' ),
    );

    register_taxonomy( 'operacion', 'propiedad', $args );



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
        'back_to_items'              => __( '← Volver a Localidades', 'tnb' ),
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


    // Estados (Reservado, o cualquiera similar)
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name'                       => _x( 'Estado', 'taxonomy general name' ),
        'singular_name'              => _x( 'Estado', 'taxonomy singular name' ),
        'search_items'               => __( 'Buscar estados' ),
        'popular_items'              => __( 'Estados populares' ),
        'all_items'                  => __( 'Todas los estados' ),
        'parent_item'                => __( 'Estado padre' ),
        'parent_item_colon'          => __( 'Estado padre:' ),
        'edit_item'                  => __( 'Editar estado' ),
        'update_item'                => __( 'Actualizar estado' ),
        'add_new_item'               => __( 'Agregar estado' ),
        'new_item_name'              => __( 'Nombre del estado' ),
        'separate_items_with_commas' => __( 'Separar los estados con comas' ),
        'add_or_remove_items'        => __( 'Agregar o quitar estados' ),
        'choose_from_most_used'      => __( 'Elige de los estados más populares' ),
        'not_found'                  => __( 'No se encontraron estados' ),
        'menu_name'                  => __( 'Estados' ),
        'back_to_items'              => __( '← Volver a Estados', 'tnb' ),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => true,
        //'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'status' ),
        'description'           => __('Definimos estados como "en construccion", "apta credito", "en sucesion", etc.'),
    );

    register_taxonomy( 'status', 'propiedad', $args );


    // Prestaciones (Patio, Baño, Etc)
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name'                       => _x( 'Prestaciones', 'taxonomy general name' ),
        'singular_name'              => _x( 'Prestación', 'taxonomy singular name' ),
        'search_items'               => __( 'Buscar prestaciones' ),
        'popular_items'              => __( 'prestaciones populares' ),
        'all_items'                  => __( 'Todas las prestaciones' ),
        'parent_item'                => __( 'Prestación padre' ),
        'parent_item_colon'          => __( 'Prestación padre:' ),
        'edit_item'                  => __( 'Editar prestación' ),
        'update_item'                => __( 'Actualizar prestación' ),
        'add_new_item'               => __( 'Agregar prestación' ),
        'new_item_name'              => __( 'Nombre de la prestación' ),
        'separate_items_with_commas' => __( 'Separar las prestaciones con comas' ),
        'add_or_remove_items'        => __( 'Agregar o quitar prestaciones' ),
        'choose_from_most_used'      => __( 'Elige de las prestaciones más populares' ),
        'not_found'                  => __( 'No se encontraron prestaciones' ),
        'menu_name'                  => __( 'Prestaciones' ),
        'back_to_items'              => __( '← Volver a Prestaciones', 'tnb' ),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => true,
        //'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'features' ),
        'description'           => __('Definimos prestaciones como "patio", "balcón", etc.'),
    );

    register_taxonomy( 'features', 'propiedad', $args );


    // Servicios (Agua, luz, gas)
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name'                       => _x( 'Servicios', 'taxonomy general name' ),
        'singular_name'              => _x( 'Servicio', 'taxonomy singular name' ),
        'search_items'               => __( 'Buscar servicios' ),
        'popular_items'              => __( 'Servicios populares' ),
        'all_items'                  => __( 'Todas los servicios' ),
        'parent_item'                => __( 'Servicio padre' ),
        'parent_item_colon'          => __( 'Servicio padre:' ),
        'edit_item'                  => __( 'Editar servicio' ),
        'update_item'                => __( 'Actualizar servicio' ),
        'add_new_item'               => __( 'Agregar servicio' ),
        'new_item_name'              => __( 'Nombre del servicio' ),
        'separate_items_with_commas' => __( 'Separar los servicios con comas' ),
        'add_or_remove_items'        => __( 'Agregar o quitar servicio' ),
        'choose_from_most_used'      => __( 'Elige de los servicios más populares' ),
        'not_found'                  => __( 'No se encontraron servicios' ),
        'menu_name'                  => __( 'Servicios' ),
        'back_to_items'              => __( '← Volver a Servicios', 'tnb' ),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => true,
        //'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'services' ),
        'description'           => __('Definimos servicios como "agua corriente", "electricidad", etc.'),
    );

    register_taxonomy( 'services', 'propiedad', $args );


    $labels = array(
        'name'                       => _x( 'Etiquetas', 'taxonomy general name' ),
        'singular_name'              => _x( 'Etiquetas', 'taxonomy singular name' ),
        'search_items'               => __( 'Buscar etiquetas' ),
        'popular_items'              => __( 'Etiquetass populares' ),
        'all_items'                  => __( 'Todas las etiquetas' ),
        'parent_item'                => __( 'Etiqueta padre' ),
        'parent_item_colon'          => __( 'Etiqueta padre:' ),
        'edit_item'                  => __( 'Editar etiqueta' ),
        'update_item'                => __( 'Actualizar etiqueta' ),
        'add_new_item'               => __( 'Agregar etiqueta' ),
        'new_item_name'              => __( 'Nombre de la etiqueta' ),
        'separate_items_with_commas' => __( 'Separar las etiquetas con comas' ),
        'add_or_remove_items'        => __( 'Agregar o quitar etiquetas' ),
        'choose_from_most_used'      => __( 'Elige de las etiquetas más populares' ),
        'not_found'                  => __( 'No se encontraron etiquetas' ),
        'menu_name'                  => __( 'Etiquetas' ),
        'back_to_items'              => __( '← Volver a Etiquetas', 'tnb' ),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => true,
        //'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'propiedad-tag' ),
        'description'           => __('Definimos estados como "en construccion", "apta credito", "en sucesion", etc.'),
    );

    register_taxonomy( 'tag', 'propiedad', $args );
}



/*  METABOX */

// custom metaboxes
// Start with an underscore to hide fields from custom fields list
$prefix = '_prop_';

/**
 * Define the metabox and field configurations.
 */
function cmb2_prop_base() {

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
        'name'     => 'Tipo de Propiedad *',
        'desc'     => 'Casa, Depto, Cabaña, etc. (Campo obligatorio)',
        'id'       => $prefix .'tipo',
        'taxonomy' => 'tipo',
        'required' => true, // Campo obligatorio
        // Optional:
        'options' => array(
            'no_terms_text' => __('Lo sentimos, no encontramos un tipo de propiedad, agregue una') // Change default text. Default: "No terms"
        ),
        // Default values for common property types
        'default' => array(
            0 => 'casa', // Casa por defecto
        ),
    ) );
    $cmb->add_field( array(
        'name'     => 'Operación *',
        'desc'     => 'Venta, Alquiler, etc. (Campo obligatorio)',
        'id'       => $prefix .'operacion',
        'taxonomy' => 'operacion',
        'select_all_button' => false,
        'type'     => 'taxonomy_multicheck',
        'required' => true, // Campo obligatorio
        // Default values for common operations
        'default' => array(
            0 => 'venta', // Venta por defecto
        ),
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
    $cmb->add_field( array(
        'name'     => 'Moneda',
        'id'       => $prefix .'currency',
        'type'     => 'select',
        'options'  => currency(),
    ) );

    /*
    $group_rent_years = $cmb->add_field( array(
        'id'       => $prefix .'rent',
        'type'        => 'group',
        'description' => __( 'Generates reusable form entries', 'cmb2' ),
        // 'repeatable'  => false, // use false if you want non-repeatable group
        'options'     => array(
            'group_title'       => __( 'Importe Año {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
            'add_button'        => __( 'Agregar importe', 'cmb2' ),
            'remove_button'     => __( 'Eliminar importe', 'cmb2' ),
            'sortable'          => true,
            // 'closed'         => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
        ),
    ) );

    */

}

add_action( 'cmb2_init', 'cmb2_prop_base' );

/**
 * Hide default taxonomy metaboxes from sidebar using CSS and JavaScript
 * Since Tipo and Operacion are now handled by CMB2 fields in 'Detalles de la operación' metabox
 */
function hide_propiedad_taxonomy_metaboxes() {
    // Only on propiedad edit screen
    $screen = get_current_screen();
    if ($screen && $screen->post_type === 'propiedad') {
        // CSS approach - hides immediately
        echo '<style>
            /* Hide Tipo taxonomy metabox */
            #tagsdiv-tipo,
            #tipodiv,
            .postbox#tagsdiv-tipo {
                display: none !important;
                visibility: hidden !important;
            }
            
            /* Hide Operacion taxonomy metabox */
            #tagsdiv-operacion,
            #operaciondiv,
            .postbox#tagsdiv-operacion {
                display: none !important;
                visibility: hidden !important;
            }
        </style>';
        
        // JavaScript approach - ensures they stay hidden even after AJAX
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                // Hide Tipo metabox
                var tipoBox = document.getElementById("tagsdiv-tipo");
                if (tipoBox) {
                    tipoBox.style.display = "none";
                    tipoBox.style.visibility = "hidden";
                }
                
                // Hide Operacion metabox
                var operacionBox = document.getElementById("tagsdiv-operacion");
                if (operacionBox) {
                    operacionBox.style.display = "none";
                    operacionBox.style.visibility = "hidden";
                }
            });
        </script>';
    }
}
add_action('admin_head', 'hide_propiedad_taxonomy_metaboxes', 100);

function cmb2_prop_taxes(){

    $prefix = '_prop_';

    $cmb6 = new_cmb2_box( array(
        'id'            => 'tax_metabox',
        'title'         => __( 'Gastos iniciales', 'cmb2' ),
        'object_types'  => array( 'propiedad' ), // post type
        //'show_on'       => array( 'key' => 'page-template', 'value' => 'page-products.php' ),
        'context'       => 'normal',
        'priority'      => 'low',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        //'closed'     => true, // Keep the metabox closed by default
    ) );
    $cmb6->add_field(array(
        'name' => 'Importe',
        'desc' => 'Monto total de los gastos iniciales',
        'id'   => '_prop_tax_title',
        'type' => 'text_money',
        //'type' => 'text',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ));
    $cmb6->add_field(array(
        'name' => 'Description',
        'id'   => '_prop_tax_desc',
        'type' => 'wysiwyg',
        'options' => array(
            'wpautop' => true, // use wpautop?
            'textarea_rows' => get_option('default_post_edit_rows', 3),
            'media_buttons' => false, // show insert/upload button(s)
        ),
        //'type' => 'textarea',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ));
    $cmb6 = new_cmb2_box( array(
        'id'            => 'tax_month_metabox',
        'title'         => __( 'Gastos mensuales', 'cmb2' ),
        'object_types'  => array( 'propiedad' ), // post type
        //'show_on'       => array( 'key' => 'page-template', 'value' => 'page-products.php' ),
        'context'       => 'normal',
        'priority'      => 'low',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        //'closed'     => true, // Keep the metabox closed by default
    ) );
    $cmb6->add_field(array(
        'name' => 'Importe',
        'desc' => 'Monto total de los gastos iniciales',
        'id'   => '_prop_tax_month_title',
        'type' => 'text_money',
        //'type' => 'text',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ));
    $cmb6->add_field(array(
        'name' => 'Description',
        'id'   => '_prop_tax_month_desc',
        'type' => 'wysiwyg',
        'options' => array(
            'wpautop' => true, // use wpautop?
            'textarea_rows' => get_option('default_post_edit_rows', 3),
            'media_buttons' => false, // show insert/upload button(s)
        ),
        //'type' => 'textarea',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ));

    $cmb5 = new_cmb2_box( array(
        'id'            => 'price_metabox',
        'title'         => __( 'Importes', 'cmb2' ),
        'object_types'  => array( 'propiedad' ), // post type
        //'show_on'       => array( 'key' => 'page-template', 'value' => 'page-products.php' ),
        'context'       => 'normal',
        'priority'      => 'low',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );
    /*$cmb5->add_field(array(
        'name' => 'Description',
        'id'   => '_prop_rent_desc',
        'type' => 'textarea_small',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ));*/
    $group_rent_years = $cmb5->add_field( array(
        'name'        => 'Importes por período',
        'id'          => '_prop_rent',
        'type'        => 'group',
        'description' => __( 'Lista los importes de alquiler periodo a periodo', 'cmb2' ),
        // 'repeatable'  => false, // use false if you want non-repeatable group
        'options'     => array(
            'group_title'       => __( 'Importe {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
            'add_button'        => __( 'Agregar', 'cmb2' ),
            'remove_button'     => __( 'Eliminar', 'cmb2' ),
            'sortable'          => true,
            'closed'         => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
        ),
    ) );
    $cmb5->add_group_field( $group_rent_years, array(
        'name' => 'Concepto',
        'id'   => 'concept',
        'default' => 'Importe Año',
        'type' => 'text',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ));
    $cmb5->add_group_field( $group_rent_years, array(
        'name' => 'Valor',
        'id'   => 'value',
        'type' => 'text',
        'sanitization_cb' => 'sanitize_int',
        'attributes'  => array(
            'type'    => 'number',
            'pattern' => '\d*',
            //'pattern' => '\^\d{1,3}(\.\d{3})*(,\d{2})?$',
        ),

        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ));
    /*
    $cmb5 = new_cmb2_box( array(
        'id'            => 'price_metabox',
        'title'         => __( 'Gastos', 'cmb2' ),
        'object_types'  => array( 'propiedad' ), // post type
        //'show_on'       => array( 'key' => 'page-template', 'value' => 'page-products.php' ),
        'context'       => 'normal',
        'priority'      => 'low',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );
    $group_taxes = $cmb5->add_field( array(
        'id'       => $prefix .'rent',
        'type'        => 'group',
        'description' => __( 'Lista los conceptos y valores de gastos administrativos', 'cmb2' ),
        // 'repeatable'  => false, // use false if you want non-repeatable group
        'options'     => array(
            'group_title'       => __( 'Gasto {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
            'add_button'        => __( 'Agregar', 'cmb2' ),
            'remove_button'     => __( 'Eliminar', 'cmb2' ),
            'sortable'          => true,
            // 'closed'         => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
        ),
    ) );
    $cmb5->add_group_field( $group_taxes, array(
        'name' => 'Concepto',
        'id'   => 'concept',
        'type' => 'text',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ));
    $cmb5->add_group_field( $group_taxes, array(
        'name' => 'Valor',
        'id'   => 'value',
        'type' => 'text_money',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ));
    */
}
add_action( 'cmb2_init', 'cmb2_prop_taxes' );

function cmb2_prop_address() {

    $prefix = '_prop_';

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
    $cmb2->add_field( array(
        'name'     => 'Botones de mapa',
        'desc'     => 'Mostrar u ocultar los botones de mapa en la propiedad',
        'id'       => $prefix .'map-buttons',
        'type'    => 'multicheck',
        'default'  => array('map','street'),
        'select_all_button' => false,
        'options' => array(
            'map'    => __('Botón de Mapa', 'tnb'),
            'street' => __('Botón de Street View', 'tnb'),
        ),
    ) );
}

add_action( 'cmb2_init', 'cmb2_prop_address' );

function cmb2_prop_details() {

    $prefix = '_prop_';

    /* CMB3 ==================================== */

    $cmb3 = new_cmb2_box( array(
        'id'            => 'detail_metabox',
        'title'         => __( 'Detalles de la propiedad', 'cmb2' ),
        'object_types'  => array( 'propiedad' ), // post type
        //'show_on'       => array( 'key' => 'page-template', 'value' => 'page-products.php' ),
        'context'       => 'normal',
        'priority'      => 'side',
        //'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );
    /*
    AMBIENTES
    $cmb3->add_field( array(
        'name'        => 'Ambientes',
        'id'          => $prefix . 'rooms',
        'type'        => 'text',
        'sanitization_cb' => 'sanitize_int',
        'attributes'  => array(
            'type'    => 'number',
            'pattern' => '\d*',
        ),
    ) );*/
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
    /*$cmb3->add_field( array(
        'name'        => 'Antigüedad',
        'desc'        => 'Antiguedad de la propiedad (en años)',
        'id'          => $prefix . 'time',
        'type'        => 'text',
        'sanitization_cb' => 'sanitize_int',
        'attributes'  => array(
            'type'    => 'number',
            'pattern' => '\d*',
        ),
    ) );*/
    $cmb3->add_field( array(
        'name'        => 'Dormitorios',
        'id'          => $prefix . 'dormrooms',
        'type'        => 'text',
        'default'     => 1,
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
        'default'     => 1,
        'sanitization_cb' => 'sanitize_int',
        'attributes'  => array(
            'type'    => 'number',
            'pattern' => '\d*',
        ),
    ) );
    /*$cmb3->add_field( array(
        'name'        => 'Garage',
        'id'          => $prefix . 'garage',
        'type'        => 'text',
        'sanitization_cb' => 'sanitize_int',
        'attributes'  => array(
            'type'    => 'number',
            'pattern' => '\d*',
        ),
    ) );*/
    $cmb3->add_field( array(
        'name'           => 'Prestaciones',
        'id'             => $prefix .'features',
        'taxonomy'       => 'features', //Enter Taxonomy Slug
	    'type'           => 'taxonomy_multicheck',
        //'select_all_button' => false,
        'text'           => array(
            'no_terms_text' => __('Lo sentimos, no encontramos ninguna prestación, agregue una') // Change default text. Default: "No terms"
        ),
	    'remove_default' => 'true', // Removes the default metabox provided by WP core.
	    // Optionally override the args sent to the WordPress get_terms function.
        'query_args' => array(
		// 'orderby' => 'slug',
		// 'hide_empty' => true,
	    ),
        'options_cb' => 'get_service_list'
    ));

    /*$cmb3->add_field( array(
    	'name'              => 'Servicios',
    	'id'                => $prefix .'services',
    	'type'              => 'multicheck',
        'select_all_button' => true,
        //'default'           => set_default_services(true),
    	'options'           => services(),
        'default_cb'        => 'set_default_services',
    ));*/

    $cmb3->add_field( array(
    	'name'              => 'Servicios',
    	'id'                => $prefix .'services',
        'taxonomy'          => 'services', //Enter Taxonomy Slug
    	'type'              => 'taxonomy_multicheck',
        'select_all_button' => true,
        'text'              => array(
            'no_terms_text' => __('Lo sentimos, no encontramos ningún servicio cargado, agregue una') // Change default text. Default: "No terms"
        ),
        //'default'           => set_default_services(true),
    	//'options'           => services(),
        'options_cb'        => 'get_service_list'
        //'default_cb'        => 'set_default_services',
    ));
    /*
    $cmb3->add_field( array(
    	'name'              => 'Estado',
    	'id'                => $prefix .'status',
    	'type'              => 'multicheck',
        'select_all_button' => false,
        'options'           => status(),
        //'options' => array(
    	//	1 => 'En construcción',
    	//	2 => 'Apta crédito',
    	//	3 => 'En Sucesión',
    	//),
    ));
    */

    $cmb3->add_field( array(
    	'name'              => 'Orientación',
    	'id'                => $prefix .'orientation',
    	'type'              => 'select',
        'show_option_none'  => true,
        'options'           => orientation(),
    ));
    $cmb3->add_field( array(
    	'name'              => 'Ubicación',
    	'id'                => $prefix .'front',
    	'type'              => 'select',
        'show_option_none'  => true,
        'options'           => front(),
    ));
    $cmb3->add_field( array(
        'name'              => 'Estado',
        'id'                => $prefix .'status',
        'taxonomy'          => 'status',
        'type'              => 'taxonomy_select',
        // Optional:
        'options' => array(
            'no_terms_text' => __('Lo sentimos, no encontramos un tipo de propiedad, agregue una') // Change default text. Default: "No terms"
        ),
    ) );

    /*$cmb3->add_field( array(
        'name'             => 'Frase',
        'id'               => $prefix . 'phrase',
        'desc'             => 'Frases llamadoras de atención',
        'type'             => 'select',
        'show_option_none' => true,
        'options'          => phrases(),
    ) );*/

    $cmb3->add_field( array(
        'name'             => 'Destacado',
        'id'               => $prefix .'featured',
        'desc'             => 'Marcar como propiedad destacada',
        'type'             => 'checkbox',
    ) );
}

add_action( 'cmb2_init', 'cmb2_prop_details' );

function cmb2_gallery() {

    $prefix = '_prop_';


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
        'name' => 'Imágenes',
        'desc' => 'Subir y administrar imágenes',
        'id'   => '_prop_images',
        //'id'   => $prefix . 'images',
        'type' => 'file_list',
        // 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
        'query_args' => array( 'type' => 'image' ), // Only images attachment
        // Optional, override default text strings
        'text' => array(
	           'add_upload_files_text' => 'Agregar Imágenes', // default: "Add or Upload Files"
	            'remove_image_text' => 'Eliminar', // default: "Remove Image"
	            'file_text' => 'Archivo:', // default: "File:"
	            'file_download_text' => 'Descarga', // default: "Download"
	            'remove_text' => 'Eliminar', // default: "Remove"
        ),
    ) );
    /*$cmb4->add_field( array(
        'name'            => 'Imágenes',
        'desc'            => 'Subir y administrar imágenes',
        'button'          => 'Administrar Galería', // Optionally set button label
        'id'              => $prefix . 'images',
        'type'            => 'pw_gallery',
        'sanitization_cb' => 'pw_gallery_field_sanitise',
    ));*/

    /*$cmb4->add_field( array(
        'name'            => 'Imágenes',
        'desc'            => 'Subir y administrar imágenes',
        'button'          => 'Administrar Galería', // Optionally set button label
        'id'              => $prefix . 'images',
        'type'            => 'pw_gallery',
        'sanitization_cb' => 'pw_gallery_field_sanitise',
    ));*/
}
add_action( 'cmb2_init', 'cmb2_gallery' );

function cmb2_attached_agents() {

    $prefix = '_prop_';


	$example_meta = new_cmb2_box( array(
		'id'           => 'cmb2_attached_agents',
		'title'        => __( 'Asesores', 'tnb' ),
		'object_types' => array( 'propiedad' ), // Post type
		'context'      => 'normal',
		//'context'      => 'normal',
		'priority'     => 'low',
		'show_names'   => false, // Show field names on the left
	) );

	$example_meta->add_field( array(
		'name'    => __( 'Asesores', 'tnb' ),
		'desc'    => __( 'Asignar asesores a la propiedad', 'yourtextdomain' ),
		'id'      => '_prop_attached_agents',
		'type'    => 'custom_attached_posts',
		'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
		'options' => array(
			'show_thumbnails' => true, // Show thumbnails on the left
			'filter_boxes'    => true, // Show a text box for filtering the results
			'query_args'      => array(
				'posts_per_page' => 4,
				'post_type'      => 'agent',
			), // override the get_posts args
		),
	) );
}
add_action( 'cmb2_init', 'cmb2_attached_agents' );




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
function sanitize_money( $value, $field_args, $field ) {

    //$sanitized_value = absint( $value );
    $sanitized_value = number_format( $value, 2, ',', '.');

    return $sanitized_value;
}
/*function set_default_services($default) {
    return isset( $_GET['post'] ) ? '' : ( $default ? (string) $default : '' );
}*/
function set_default_services() {
    return array(1,2,3);
}


function get_service_list() {
  $taxonomy_list = array();
  $taxonomy_query = get_terms(array(
    'taxonomy'   => 'features',
    'hide_empty' => false //you can change this if you need, chech get_terms() documentation
  ));

  foreach ($taxonomy_query as $taxonomy_term) {
    // creates an array of 'term-slug' => 'Term Name'
    $taxonomy_list[$taxonomy_term->slug] = $taxonomy_term->name;
  }
  return $taxonomy_list;
}
function get_status_list() {
  $taxonomy_list = array();
  $taxonomy_query = get_terms(array(
    'taxonomy'   => 'status',
    'hide_empty' => false //you can change this if you need, chech get_terms() documentation
  ));

  foreach ($taxonomy_query as $taxonomy_term) {
    // creates an array of 'term-slug' => 'Term Name'
    $taxonomy_list[$taxonomy_term->slug] = $taxonomy_term->name;
  }
  return $taxonomy_list;
}


?>
