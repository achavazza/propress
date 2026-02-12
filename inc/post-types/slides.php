<?php
/*
 * Register a Custom Post Type (slide)
 */
add_action('init', 'slide_init');

function slide_init() {
    $labels = array(
        'name'               => _x( 'Slides', 'post type general name', 'tnb' ),
		'singular_name'      => _x( 'Slide', 'post type singular name', 'tnb' ),
		'name_admin_bar'     => _x( 'Slide', 'add new on admin bar', 'tnb' ),
		'add_new'            => _x( 'Agregar nuevo slide', 'slide', 'tnb' ),
		'add_new_item'       => __( 'Agregar Nuevo Slide', 'tnb' ),
		'new_item'           => __( 'Nuevo Slide', 'tnb' ),
		'edit_item'          => __( 'Editar Slide', 'tnb' ),
		'view_item'          => __( 'Ver Slide', 'tnb' ),
		'all_items'          => __( 'Todos los Slides', 'tnb' ),
		'search_items'       => __( 'Buscar Slides', 'tnb' ),
		'parent_item_colon'  => __( 'Slides padre:', 'tnb' ),
        'not_found'          => __('No se encontraron slides', 'tnb'),
        'not_found_in_trash' => __('No se encontraron slides en la papelera', 'tnb'),
        'menu_name'          => _x( 'Slides', 'admin menu', 'tnb' ),
    );
    $args = array(
        'labels'             => $labels,
        //'public'             => false,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'has_archive'        => 'slide',
        'hierarchical'       => false,
        'menu_position'      => 3,
        'menu_icon'          => 'dashicons-images-alt2',
        'supports'           => array('title', 'editor', 'thumbnail'),
        'show_in_rest'       => true,
        'taxonomies'         => array('slider'),
    );
    register_post_type('slide', $args);


    $labels_slider = array(
		'name'                       => _x( 'Sliders', 'taxonomy general name', 'tnb' ),
		'singular_name'              => _x( 'Slider', 'taxonomy singular name', 'tnb' ),
		'search_items'               => __( 'Buscar Sliders', 'tnb' ),
		'popular_items'              => __( 'Sliders mas usados', 'tnb' ),
		'all_items'                  => __( 'Todos los sliders', 'tnb' ),
        'parent_item'                => __( 'Slider Padre', 'tnb' ),
        'parent_item_colon'          => __( 'Slider Padre:', 'tnb' ),
		'edit_item'                  => __( 'Editar Slider', 'tnb' ),
		'update_item'                => __( 'Actualizar Slider', 'tnb' ),
		'add_new_item'               => __( 'Agregar Nuevo Slider', 'tnb' ),
		'new_item_name'              => __( 'Nuevo Nombre', 'tnb' ),
		'separate_items_with_commas' => __( 'Separar sliders con comas', 'tnb' ),
		'add_or_remove_items'        => __( 'Agregar o quitar sliders', 'tnb' ),
		'choose_from_most_used'      => __( 'Elija de los sliders mas usados', 'tnb' ),
		'not_found'                  => __( 'No se encontraron sliders.', 'tnb' ),
		'menu_name'                  => __( 'Sliders', 'tnb' ),
        'back_to_items'              => __( '← Volver a Sliders', 'tnb' ),
	);

	$args_slider = array(
		'hierarchical'          => true,
		'labels'                => $labels_slider,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
        'description'           => false,
		'rewrite'               => array( 'slug' => 'slider' ),
	);

    register_taxonomy( 'slider', 'slide', $args_slider );
}

/* Update slide Messages */
add_filter('post_updated_messages', 'slide_updated_messages');
function slide_updated_messages($messages) {
    global $post, $post_ID;
    $messages['slide'] = array(
        0 => '',
        1 => sprintf(__('slide actualizado.'), esc_url(get_permalink($post_ID))),
        2 => __('Custom field actualizado.'),
        3 => __('Custom field deleted.'),
        4 => __('slide actualizado.'),
        5 => isset($_GET['revision']) ? sprintf(__('slide restaurado de revisión desde %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
        6 => sprintf(__('slide publicado.'), esc_url(get_permalink($post_ID))),
        7 => __('slide guardada.'),
        8 => sprintf(__('slide publicado.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
        9 => sprintf(__('slide archivado para: <strong>%1$s</strong>. '), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
        10 => sprintf(__('slide en borrador actualizado.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
    );
    return $messages;
}

/* Update slide Help - deprecated contextual_help, using get_current_screen() instead */
add_action('current_screen', 'slide_help_text');
    function slide_help_text($screen) {
    if ('slide' == $screen->id) {
        $screen->add_help_tab(
            array(
                'id'      => 'slide_help',
                'title'   => __('Ayuda Slides', 'tnb'),
                'content' =>
                    '<p>' . __('Cosas para recordar a la hora de agregar un slide:') . '</p>' .
                    '<ul>' .
                    '<li>' . __('Darle un título. El título será usado como cabecera') . '</li>' .
                    '<li>' . __('Agregar una imagen destacada.') . '</li>' .
                    '<li>' . __('Agregar texto. El texto aparecerá en cada slide.') . '</li>' .
                    '</ul>',
            )
        );
    }
    elseif ('edit-slide' == $screen->id) {
        $screen->add_help_tab(
            array(
                'id'      => 'slide_edit_help',
                'title'   => __('Ayuda Editar', 'tnb'),
                'content' =>
                    '<p>' . __('Una lista de todos los slides del home aparece debajo. para editar un slide haga click en el título.') . '</p>',
            )
        );
    }
}

function slide_metabox() {
	$prefix = 'slide_prop_';
	/**
	 * Metabox to add fields to categories and tags
	 */
	$cmb = new_cmb2_box( array(
		'id'               => $prefix . 'info',
		'title'            => __( 'Opciones de slide', 'tnb' ), // Doesn't output for term boxes
		'object_types'     => array( 'slide' ), // Tells CMB2 to use term_meta vs post_meta
		//'taxonomies'       => array( 'slider' ), // Tells CMB2 which taxonomies should have these fields
        //'context'       => 'normal',
        'priority'      => 'high',
		//'new_term_section' => true, // Will display in the "Add New Category" section
	) );
    $cmb->add_field( array(
		'name' => __( 'Alineación del contenido', 'tnb' ),
		//'desc' => __( 'field description (optional)', 'tnb' ),
		'id'   => $prefix . 'align',
        'type'     => 'select',
        'show_option_none' => true,
        'options'  => array(
            'center-center' => 'Centrado al Medio',
            'center-top'    => 'Centrado Superior',
            'center-bottom' => 'Centrado Inferior',
            'left-center'   => 'Izquierda Centrado',
            'left-top'      => 'Izquierda Superior',
            'left-bottom'   => 'Izquierda Inferior',
            'right-center'  => 'Derecha Centrado',
            'right-top'     => 'Derecha Superior',
            'right-bottom'  => 'Derecha Inferior',
            ),
	) );
    /*
	$cmb->add_field( array(
		'name' => __( 'Term Image', 'tnb' ),
		'desc' => __( 'field description (optional)', 'tnb' ),
		'id'   => $prefix . 'avatar',
		'type' => 'file',
	) );
    */
    /*
	$cmb->add_field( array(
		'name'    => __( 'Encabezado', 'tnb' ),
		'desc'    => __( 'Texto primario', 'tnb' ),
		'id'      => $prefix . 'content',
		'attributes' => array('cols'=>250, 'rows'=>5,'style'=>'width:100%'),
		'type'    => 'textarea',
	));
	$cmb->add_field( array(
		'name'    => __( 'Tipo de encabezado', 'tnb' ),
	    'id'      => $prefix . 'title_type',
	    'type'    => 'buttonset',
	    'options' => array(
            "h1" => __("h1", 'tnb'),
            "h2" => __("h2", 'tnb'),
            "h3" => __("h3", 'tnb'),
            "h4" => __("h4", 'tnb'),
            "h5" => __("h5", 'tnb'),
            "h6" => __("h6", 'tnb'),
            "p" => __("p", 'tnb')
	    ),
	    'default' => 'none'
    ));
	$cmb->add_field( array(
		'name'    => __( 'Leyenda', 'tnb' ),
		'desc'    => __( 'Texto secundario', 'tnb' ),
		'id'      => $prefix . 'legend',
		'attributes' => array('cols'=>250, 'rows'=>5,'style'=>'width:100%'),
		'type'    => 'textarea',
	));
    $cmb->add_field( array(
		'name'    => __( 'Tipo de leyenda', 'tnb' ),
	    'id'      => $prefix . 'legend_type',
	    'type'    => 'buttonset',
	    'options' => array(
            "h1" => __("h1", 'tnb'),
            "h2" => __("h2", 'tnb'),
            "h3" => __("h3", 'tnb'),
            "h4" => __("h4", 'tnb'),
            "h5" => __("h5", 'tnb'),
            "h6" => __("h6", 'tnb'),
            "p" => __("p", 'tnb')
	    ),
	    'default' => 'none'
    ));
	$cmb->add_field( array(
		'name'    => __( 'Botón #1', 'tnb' ),
		'id'      => $prefix . 'button-1',
		'type'    => 'textarea_code',
	));
	$cmb->add_field( array(
		'name'    => __( 'Botón #2', 'tnb' ),
		'id'      => $prefix . 'button-2',
		'type'    => 'textarea_code',
	));
    */

    //if(!is_admin()){ return; }
    /*
    $cmb2Grid = new \Cmb2Grid\Grid\Cmb2Grid($cmb);
    $row = $cmb2Grid->addRow();
    $row->addColumns(array($f1, $f2));
    $row->addColumns(array(
        array($field1, 'class' => 'col-md-8'),
        array($field2, 'class' => 'col-md-4')
    ));
    */

}
add_action( 'cmb2_admin_init', 'slide_metabox' );

function slider_taxonomy_metabox() {
	$prefix = 'slider_term_';
	/**
	 * Metabox to add fields to categories and tags
	 */
	$cmb_term = new_cmb2_box( array(
		'id'               => $prefix . 'info',
		'title'            => __( 'Propiedades slider', 'tnb' ), // Doesn't output for term boxes
		'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array( 'slider' ), // Tells CMB2 which taxonomies should have these fields
        'context'       => 'normal',
        'priority'      => 'high',
		//'new_term_section' => true, // Will display in the "Add New Category" section
	) );
    /*
	$cmb_term->add_field( array(
		'name' => __( 'Term Image', 'tnb' ),
		'desc' => __( 'field description (optional)', 'tnb' ),
		'id'   => $prefix . 'avatar',
		'type' => 'file',
	) );
    */
	//$f1 =
    $cmb_term->add_field( array(
		'name'    => __( 'Ancho', 'tnb' ),
		'desc'    => __( 'Ancho de la imagen de slider (en px)', 'tnb' ),
		'default' => 1200,
		'id'      => $prefix . 'w',
		'type'    => 'text',
    	'attributes' => array(
    		'type' => 'number',
    		'pattern' => '\d*',
    	),
	) );
    //$f2 =
    $cmb_term->add_field( array(
		'name'    => __( 'Alto', 'tnb' ),
		'desc'    => __( 'Alto  de la imagen de slider (en px)', 'tnb' ),
		'default' => 400,
		'id'      => $prefix . 'h',
		'type'    => 'text',
    	'attributes' => array(
    		'type' => 'number',
    		'pattern' => '\d*',
    	),
	) );

    //if(!is_admin()){ return; }
    /*$cmb2Grid = new \Cmb2Grid\Grid\Cmb2Grid($cmb_term);
    $row = $cmb2Grid->addRow();
    $row->addColumns(array($f1, $f2));*/

    $cmb_term->add_field( array(
		'name'    => __( 'Animado', 'tnb' ),
		'desc'    => __( 'Controla si el slide se anima o no', 'tnb' ),
		'id'      => $prefix . 'animated',
		'type'    => 'checkbox',
        'default' => true,
	) );
    $cmb_term->add_field( array(
		'name'    => __( 'Bucle', 'tnb' ),
		'desc'    => __( 'Controla si el slide se anima indefinidamente en bucle', 'tnb' ),
		'id'      => $prefix . 'loop',
		'type'    => 'checkbox',
        'default' => true,
	) );


    $cmb_term->add_field( array(
		'name'    => __( 'Tiempo', 'tnb' ),
		'desc'    => __( 'Tiempo de animacion entre diapositivas (en ms)', 'tnb' ),
		'default' => __( '5000', 'tnb' ),
		'id'      => $prefix . 'time',
		'type'    => 'text',
		'attributes' => array(
			'type' => 'number',
			'min'  => '100',
		),
	) );

    /*
    $row->addColumns(array(
        array($field1, 'class' => 'col-md-8'),
        array($field2, 'class' => 'col-md-4')
    ));
    */
}
add_action( 'cmb2_admin_init', 'slider_taxonomy_metabox' );

?>
