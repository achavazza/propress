<?php
/*
 * Register a Custom Post Type (Asesor)
 */
add_action('init', 'agent_init');

function agent_init() {
    $labels = array(
        'name'               => _x('Asesores', 'post type general name'),
        'singular_name'      => _x('Asesor', 'post type singular name'),
        'add_new'            => _x('Agregar Nuevo', 'asesor'),
        'add_new_item'       => __('Agregar Nuevo asesor'),
        'edit_item'          => __('Editar asesor'),
        'new_item'           => __('Nuevo asesor'),
        'view_item'          => __('Ver asesor'),
        'search_items'       => __('Buscar asesores'),
        'not_found'          => __('No se encontraron asesores'),
        'not_found_in_trash' => __('No no se encontraron asesores en la papelera'),
        'parent_item_colon'  => '',
        'menu_name'          => __('Asesores')
    );
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'has_archive'        => 'agent',
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-businessperson',
        'supports'           => array('title', 'editor', 'thumbnail'),
        'taxonomies'         => array('agent-type')
    );
    register_post_type('agent', $args);
}

/* Update interna Messages
add_filter('post_updated_messages', 'asesor_updated_messages');
function asesor_updated_messages($messages) {
    global $post, $post_ID;
    $messages['asesor'] = array(
        0 => '',
        1 => sprintf(__('interna actualizada.'), esc_url(get_permalink($post_ID))),
        2 => __('Custom field actualizado.'),
        3 => __('Custom field deleted.'),
        4 => __('Asesor actualizada.'),
        5 => isset($_GET['revision']) ? sprintf(__('Noticia interna restaurada de revisión desde %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
        6 => sprintf(__('Asesor publicada.'), esc_url(get_permalink($post_ID))),
        7 => __('Asesor guardada.'),
        8 => sprintf(__('Asesor publicada.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
        9 => sprintf(__('Asesor archivada para: <strong>%1$s</strong>. '), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
        10 => sprintf(__('Asesor en borrador actualizado.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
    );
    return $messages;
}
*/


/* Update interna Help
add_action('current_screen', 'asesor_help_text');
    function asesor_help_text($screen) {
    if ('agent' == $screen->id) {
        $screen->add_help_tab(
            array(
                'id'      => 'agent_help',
                'title'   => __('Ayuda Agentes', 'tnb'),
                'content' =>
                    '<p>' . __('Cosas para recordar a la hora de agregar un asesor inmobiliario:') . '</p>' .
                    '<ul>' .
                    '<li>' . __('Darle un título al agente. El título será usado como cabecera') . '</li>' .
                    '<li>' . __('Agregar una imagen destacada.') . '</li>' .
                    '<li>' . __('Agregar texto. El texto aparecerá en cada perfil de agente.') . '</li>' .
                    '</ul>',
            )
        );
    }
    elseif ('edit-agent' == $screen->id) {
        $screen->add_help_tab(
            array(
                'id'      => 'agent_edit_help',
                'title'   => __('Ayuda Editar', 'tnb'),
                'content' =>
                    '<p>' . __('Una lista de todos los agentes aparece debajo. para editar un agente haga click en el título.') . '</p>',
            )
        );
    }
}
*/

// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_agent_taxonomies', 0 );

function create_agent_taxonomies() {

    // Tipos de agentes (Casa, Cabaña, Depto, etc.)
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name'                       => _x( 'Tipo', 'taxonomy general name' ),
        'singular_name'              => _x( 'Tipo', 'taxonomy singular name' ),
        'search_items'               => __( 'Buscar tipo de asesor' ),
        'popular_items'              => __( 'Tipo de asesor populares' ),
        'all_items'                  => __( 'Todos los tipos de asesor' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Editar tipo de asesor' ),
        'update_item'                => __( 'Actualizar tipo de asesor' ),
        'add_new_item'               => __( 'Agregar nuevo tipo de asesor' ),
        'new_item_name'              => __( 'Nombre del tipo de asesor' ),
        'separate_items_with_commas' => __( 'Separar los tipos de agent con comas' ),
        'add_or_remove_items'        => __( 'Agregar o quitar tipos de asesor' ),
        'choose_from_most_used'      => __( 'Elige de los tipos de asesor más populares' ),
        'not_found'                  => __( 'No se encontraron tipos de asesor' ),
        'menu_name'                  => __( 'Tipo de asesor' ),
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
        'rewrite'               => array( 'slug' => 'agent_type' ),
    );

    register_taxonomy( 'agent_type', 'agent', $args );
}

/*  METABOX */

// custom metaboxes
add_action( 'cmb2_init', 'cmb2_agents' );


/**
 * Define the metabox and field configurations.
 */
function cmb2_agents() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_agent_';

    /**
     * Initiate the metabox
     */

    /* CMB ==================================== */
    $cmb = new_cmb2_box( array(
        'id'            => 'agent_metabox',
        'title'         => __( 'Información de contacto', 'cmb2' ),
        'object_types'  => array( 'agent' ), // post type
        //'show_on'       => array( 'key' => 'page-template', 'value' => 'page-products.php' ),
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );
    $cmb->add_field( array(
        'name'     => 'Elija el tipo de asesor',
        'desc'     => 'Ventas, financiacion, inversiones, etc.',
        'id'       => $prefix .'agent_type',
        'taxonomy' => 'agent_type',
        'type'     => 'taxonomy_select',
        // Optional:
        'options' => array(
            'no_terms_text' => __('Lo sentimos, no encontramos ningún tipo de asesores, agregue uno')
        ),
    ) );
    $cmb->add_field( array(
        'name'     => 'Form de contacto',
        'desc'     => 'Formulario para contactarse con este asesor',
        'id'       => $prefix .'contact',
        'type'     => 'text',
    ) );
    $cmb->add_field( array(
        'name'     => 'Teléfono',
        //'desc'     => 'Teléfono del asesor',
        'id'       => $prefix .'phone',
        'type'     => 'text',
    ) );
    $cmb->add_field( array(
        'name'     => 'Whatsapp',
        //'desc'     => 'Whatsapp del asesor',
        'id'       => $prefix .'whatsapp',
        'type'     => 'text',
    ) );
    $cmb->add_field( array(
        'name'     => 'Email',
        //'desc'     => 'Whatsapp del asesor',
        'id'       => $prefix .'email',
        'type'     => 'text_email',
    ) );

}
?>
