<?php
/*
 * Register a Custom Post Type (Interna)
 */
add_action('init', 'internal_init');

function internal_init() {
    $labels = array(
        'name'               => _x('Noticias Internas', 'post type general name'),
        'singular_name'      => _x('Interna', 'post type singular name'),
        'add_new'            => _x('Agregar Nueva', 'internal'),
        'add_new_item'       => __('Agregar Nueva Noticia Interna'),
        'edit_item'          => __('Editar Interna'),
        'new_item'           => __('Nueva Interna'),
        'view_item'          => __('Ver Interna'),
        'search_items'       => __('Buscar Internas'),
        'not_found'          => __('No se encontraron Noticias Internas'),
        'not_found_in_trash' => __('No no se encontraron Noticias Internas en la papelera'),
        'parent_item_colon'  => '',
        'menu_name'          => 'Internas'
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
        'has_archive'        => 'internal',
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'supports'           => array('title', 'editor', 'thumbnail'),
        'taxonomies'         => array('internal-category', 'internal-tag')
    );
    register_post_type('internal', $args);
}

/* Update interna Messages */
add_filter('post_updated_messages', 'internal_updated_messages');
function internal_updated_messages($messages) {
    global $post, $post_ID;
    $messages['internal'] = array(
        0 => '',
        1 => sprintf(__('interna actualizada.'), esc_url(get_permalink($post_ID))),
        2 => __('Custom field actualizado.'),
        3 => __('Custom field deleted.'),
        4 => __('Interna actualizada.'),
        5 => isset($_GET['revision']) ? sprintf(__('Noticia interna restaurada de revisión desde %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
        6 => sprintf(__('Interna publicada.'), esc_url(get_permalink($post_ID))),
        7 => __('Interna guardada.'),
        8 => sprintf(__('Interna publicada.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
        9 => sprintf(__('Interna archivada para: <strong>%1$s</strong>. '), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
        10 => sprintf(__('Interna en borrador actualizado.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
    );
    return $messages;
}

/* Update interna Help - deprecated contextual_help, using get_current_screen() instead */
add_action('current_screen', 'internal_help_text');
    function internal_help_text($screen) {
    if ('internal' == $screen->id) {
        $screen->add_help_tab(
            array(
                'id'      => 'internal_help',
                'title'   => __('Ayuda Noticias Internas', 'tnb'),
                'content' =>
                    '<p>' . __('Cosas para recordar a la hora de agregar una noticia interna:') . '</p>' .
                    '<ul>' .
                    '<li>' . __('Darle un título a la noticia. El título será usado como cabecera') . '</li>' .
                    '<li>' . __('Agregar una imagen destacada.') . '</li>' .
                    '<li>' . __('Agregar texto. El texto aparecerá en cada noticia.') . '</li>' .
                    '</ul>',
            )
        );
    }
    elseif ('edit-internal' == $screen->id) {
        $screen->add_help_tab(
            array(
                'id'      => 'internal_edit_help',
                'title'   => __('Ayuda Editar', 'tnb'),
                'content' =>
                    '<p>' . __('Una lista de todos los internas aparece debajo. para editar un interna haga click en el título.') . '</p>',
            )
        );
    }
}
?>
