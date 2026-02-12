<?php
/*
 * Register a Custom Post Type (Product)
 */
add_action('init', 'project_init');
function project_init() {
  $labels = array(
    'name' => _x('Proyectos', 'post type general name'),
    'singular_name' => _x('Proyecto', 'post type singular name'),
    'add_new' => _x('Agregar Nuevo', 'project'),
    'add_new_item' => __('Agregar Nuevo Proyecto'),
    'edit_item' => __('Editar Proyecto'),
    'new_item' => __('Nuevo Proyecto'),
    'view_item' => __('Ver Proyecto'),
    'search_items' => __('Buscar Proyectos'),
    'not_found' => __('No se encontraron Proyectos'),
    'not_found_in_trash' => __('No no se encontraron Proyectos en la papelera'),
    'parent_item_colon' => '',
    'menu_name' => 'Proyectos'
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => 'project',
    'hierarchical' => false,
    'menu_position' => 3,
    'supports' => array('title', 'editor', 'thumbnail'),
    'taxonomies' => array('project-category', 'project-tag')
  );
  register_post_type('project', $args);
}

/* Update Proyecto Messages */
add_filter('post_updated_messages', 'project_updated_messages');
function project_updated_messages($messages) {
  global $post, $post_ID;
  $messages['project'] = array(
    0 => '',
    1 => sprintf(__('Proyecto actualizado.'), esc_url(get_permalink($post_ID))),
    2 => __('Custom field actualizado.'),
    3 => __('Custom field deleted.'),
    4 => __('Proyecto actualizado.'),
    5 => isset($_GET['revision']) ? sprintf(__('Proyecto restaurado de revisión desde %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
    6 => sprintf(__('Proyecto publicado.'), esc_url(get_permalink($post_ID))),
    7 => __('Proyecto guardado.'),
    8 => sprintf(__('Proyecto publicado.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
    9 => sprintf(__('Proyecto archivado para: <strong>%1$s</strong>. '), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
    10 => sprintf(__('Proyecto borrador actualizado.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
  );
  return $messages;
}

/* Update Proyecto Help - deprecated contextual_help, using get_current_screen() instead */
add_action('current_screen', 'project_help_text');
function project_help_text($screen) {
  if ('project' == $screen->id) {
    $screen->add_help_tab(
        array(
            'id'      => 'project_help',
            'title'   => __('Ayuda Proyectos', 'tnb'),
            'content' =>
                '<p>' . __('Cosas para recordar a la hora de agregar un proyecto:') . '</p>' .
                '<ul>' .
                '<li>' . __('Darle un título al proyecto. El título será usado como cabecera') . '</li>' .
                '<li>' . __('Agregar una imagen destacada para darle el fondo al proyecto.') . '</li>' .
                '<li>' . __('Agregar texto. El texto aparecerá en cada proyecto durante la transición.') . '</li>' .
                '</ul>',
        )
    );
  }
  elseif ('edit-project' == $screen->id) {
    $screen->add_help_tab(
        array(
            'id'      => 'project_edit_help',
            'title'   => __('Ayuda Editar', 'tnb'),
            'content' =>
                '<p>' . __('Una lista de todos los proyectos aparece debajo. para editar un Proyecto haga click en el título.') . '</p>',
        )
    );
  }
}
  elseif ('edit-project' == $screen->id) {
    $contextual_help = '<p>' . __('Una lista de todos los proyectos aparece debajo. para editar un Proyecto haga click en el título.') . '</p>';
  }
  return $contextual_help;
}
?>