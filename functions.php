<?php
/*
 * Include CMB2 & Plugins
 * ========================================================================================================
 */

// Emergency repair functions - can be removed after fixing rewrite rules
include_once('emergency-repair.php');

//$base_path    = str_replace('\\', '/', dirname( __FILE__ ) ."/inc/cmb2");
$base_path    = str_replace('\\', '/', dirname( __FILE__ ) ."/inc/CMB2-develop");
$plugins_path = str_replace('\\', '/', dirname( __FILE__ ) ."/inc/cmb2-plugins");
//$plugins_path = str_replace('\\', '/', dirname( __FILE__ ) ."/inc/CMB2-plugins");

define('CMB_PATH', $base_path);
define('CMB_PLUGINS', $plugins_path);

if ( file_exists(CMB_PATH . '/init.php' ) ) {

    require_once (CMB_PATH . '/init.php');

    //grid
    require_once (CMB_PLUGINS . '/CMB2-grid-master/Cmb2GridPlugin.php');

    //custom show_on
    //include(CMB_PLUGINS . '/CMB2-show-on/show_on.php');

    //custom post search field
    //include(CMB_PLUGINS . '/CMB2-post-search-field/cmb2_post_search_field.php');

    //gallery plugin
    //usando file list
    //require_once (CMB_PLUGINS . '/CMB2-field-gallery/cmb-field-gallery.php');

    //gallery plugin
    require_once (CMB_PLUGINS . '/CMB2_field_map/cmb-field-map.php');

    //MetaTabs
    require_once (CMB_PLUGINS . '/CMB2-metatabs-options/cmb2-metatabs-options.php');

    //ButtonSet
    require_once (CMB_PLUGINS . '/CMB2-Buttonset-Field-master/buttonset_metafield.php');

    //require_once (CMB_PLUGINS . '/CMB2-term-select/cmb2-term-select.php');
    require_once (CMB_PLUGINS . '/CMB2-field-ajax-search/cmb2-field-ajax-search.php');

    //Attached agents
    require_once (CMB_PLUGINS . '/CMB2-attached-posts/cmb2-attached-posts-field.php');


    require_once (CMB_PLUGINS . '/CMB2-currency-price-field/CMB2-currency-price-field.php');

    //metaboxes list
    //include('inc/custom-metaboxes/contact.php');
    //include('inc/post-types/internal.php');
}
function cmb2_style_fixes() {
    wp_register_style('cmb2_style_fixes', get_template_directory_uri(). '/inc/cmb2-plugins/cmb2_fixes.css', false, '1.0.0' );
    wp_enqueue_style('cmb2_style_fixes');
}
add_action( 'admin_enqueue_scripts', 'cmb2_style_fixes');

// post-types & metaboxes - RE-ENABLED STEP BY STEP
require_once ('inc/post-types/propiedad.php');
// require_once ('inc/post-types/slides.php');
// require_once ('inc/post-types/agents.php');
// require_once ('inc/custom-metaboxes/gallery.php');
// require_once ('inc/custom-metaboxes/extra.php');

// theme settings - RE-ENABLED STEP BY STEP
require_once 'inc/custom-functions.php';
// require_once 'inc/admin/disable-comments.php';
// require_once 'inc/admin/wp-cpt-archives-in-menu.php';
// require_once 'inc/admin/theme-options-sub.php';
// require_once 'inc/WDS-Simple-Page-Builder/wds-simple-page-builder.php';




    /*
     * INIT
     * ========================================================================================================
     */

    //add_action('wp_head', 'show_template');

    function show_template() {
      global $template;
      global $current_user;
      // deprecated: get_currentuserinfo() is deprecated since WordPress 4.5.0
      get_currentuserinfo();
      if ($current_user->user_level == 10 ) print_r($template);
    }

    /*
    // DEBUG: Show template and query info on frontend for admin users
    // To enable, uncomment this block
    add_action('wp_footer', 'propress_debug_template', 999);
    function propress_debug_template() {
        if (!current_user_can('manage_options')) return;
        global $template, $wp_query;
        echo '<div style="background:#222;color:#0f0;padding:20px;margin:20px;font-family:monospace;z-index:99999;position:relative;">';
        echo '<h3>DEBUG INFO</h3>';
        echo '<p><strong>Template:</strong> ' . $template . '</p>';
        echo '<p><strong>Is 404:</strong> ' . (is_404() ? 'YES' : 'NO') . '</p>';
        echo '<p><strong>Is Page:</strong> ' . (is_page() ? 'YES' : 'NO') . '</p>';
        echo '<p><strong>Is Single:</strong> ' . (is_single() ? 'YES' : 'NO') . '</p>';
        echo '<p><strong>Is Home:</strong> ' . (is_home() ? 'YES' : 'NO') . '</p>';
        echo '<p><strong>Query Vars:</strong> '; print_r($wp_query->query_vars); echo '</p>';
        echo '</div>';
    }
    */

    // New function using wp_get_current_user() - WordPress 4.5.0+
    function show_template_modern() {
      global $template;
      $current_user = wp_get_current_user();
      if ( user_can( $current_user, 'manage_options' ) ) print_r($template);
    }

    function pr($out){
        echo '<pre>';
        print_r($out);
        echo '</pre>';
    }

    function check($out){
        if(isset($out) && !empty($out)){
            return true;
        }
        return false;
    }

    // Fixed: Check if option exists before accessing array key
    $tnb_options = get_option('tnb_setup_options');
    if(empty($tnb_options['tnb_setup_API'])){
        // Admin notice for missing GMaps API key
        function tnb_gmaps_admin_notice() {
            if (is_admin()) {
                ?>
                <div class="notice notice-error is-dismissible">
                    <h3><?php _e('Falta clave API de Google Maps', 'tnb'); ?></h3>
                    <p><?php _e('Es importante configurar una clave API de Google Maps. Sin ella, las siguientes funcionalidades no funcionarán correctamente:', 'tnb'); ?></p>
                    <ul>
                        <li><?php _e('Mapas de propiedades', 'tnb'); ?></li>
                        <li><?php _e('Búsqueda por ubicación', 'tnb'); ?></li>
                        <li><?php _e('Geolocalización', 'tnb'); ?></li>
                        <li><?php _e('Filtros de búsqueda avanzados', 'tnb'); ?></li>
                    </ul>
                    <p><strong><?php _e('Para configurar:', 'tnb'); ?></strong> <?php _e('Ve a Ajustes > Opciones del Theme > Configuración General y agrega tu clave API de Google Maps.', 'tnb'); ?></p>
                </div>
                <?php
            }
        }
        add_action('admin_notices', 'tnb_gmaps_admin_notice');
    }
    define('GMAPS_KEY', $tnb_options['tnb_setup_API'] ?? '');

    // Helper function to check if GMaps key is available
    function tnb_has_gmaps_key() {
        return !empty(GMAPS_KEY);
    }

    // Function to display GMaps error message
    function tnb_gmaps_required_notice($echo = true) {
        $message = '<div class="alert alert-warning" style="background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 12px; border-radius: 4px; margin: 10px 0;">';
        $message .= '<strong>' . __('Atención:', 'tnb') . '</strong> ';
        $message .= __('Se necesita una clave API de Google Maps para que esta funcionalidad funcione correctamente.', 'tnb');
        $message .= '<br><small>' . __('Configúrala en: Ajustes > Opciones del Theme', 'tnb') . '</small>';
        $message .= '</div>';

        if ($echo) {
            echo $message;
        } else {
            return $message;
        }
    }

    /*
     * Properly enqueue of styles and scripts
     */
    function theme_name_scripts() {

        //wp_enqueue_style( 'qs'      , get_template_directory_uri().'/css/qs.min.css' );
        wp_enqueue_style( 'style'      , get_template_directory_uri().'/css/style.min.css' );
        //wp_enqueue_style( 'goglefonts',    '//fonts.googleapis.com/css2?family=Oxygen:wght@400;700&display=swap' );
        //wp_enqueue_style( 'opensans', '//fonts.googleapis.com/css?family=Open+Sans:400' );
        wp_enqueue_style( 'roboto', '//fonts.googleapis.com/css?family=Roboto:400,400i,700,700i&display=swap' );
        wp_enqueue_style( 'icons',  '//fonts.googleapis.com/icon?family=Material+Icons' );
        //wp_enqueue_style( 'icons',  '//fonts.googleapis.com/css2?family=Material+Icons' );

        //wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
        if ( !is_admin() ) {
           wp_deregister_script('jquery');
        }
        wp_register_script('jquery'       , get_template_directory_uri().'/js/jquery.slim.min.js', array(), '3.5.1', true);
        //wp_register_script('bootstrap'    , get_template_directory_uri().'/js/bootstrap.bundle.min.js', array('jquery'), '5.0.0-alpha1', true);

        wp_register_script('photoswipe'        , get_template_directory_uri().'/js/plugins/photoswipe.min.js', array(), '4.1.3', true);
        wp_register_script('photoswipe-ui'     , get_template_directory_uri().'/js/plugins/photoswipe-ui-default.min.js', array('photoswipe'), '4.1.3', true);
        wp_register_script('photoswipe-init'   , get_template_directory_uri().'/js/photoswipe.init.js', array('photoswipe','photoswipe-ui','jquery'), '1.0.0', true);
        wp_register_script('validate'          , get_template_directory_uri().'/js/jquery.validate.min.js', array('jquery'), '1.0.0', true);
        wp_register_script('form'              , get_template_directory_uri().'/js/form.js', array('jquery','validate'), '1.0.0', true);
        wp_register_script('siema'             , get_template_directory_uri().'/js/plugins/siema.min.js', array(), '1.5.1', true);
        wp_register_script('siema-init'        , get_template_directory_uri().'/js/plugins/siema-init.js', array('siema'), '1', true);
        wp_register_script('lity'              , get_template_directory_uri().'/js/plugins/lity.js', array('jquery'), '2.4.1', true);

        wp_register_script('infobubble'   , (get_template_directory_uri().'/js/plugins/infobubble.js'), array(), null, true);
        wp_register_script('initmaps'     , (get_template_directory_uri().'/js/map-search/initmaps.js'), array('infobubble'), '1.0.0', true);

        // Only register GMaps scripts if API key is available
        if (tnb_has_gmaps_key()) {
            wp_register_script('gmaps'        , ('http://maps.google.com/maps/api/js?&key='.GMAPS_KEY.'&callback=initMap'), array('initmaps'), null, true);
            //wp_register_script('gmapscluster' , (''), array('gmaps'), null, true);
            wp_register_script('map'          , ('http://maps.google.com/maps/api/js?&key='.GMAPS_KEY), array(), null, true);
            wp_register_script('renderMap'     , (get_template_directory_uri().'/js/map-search/renderMap.js'), array('map', 'infobubble', 'jquery'), '1.0.0', true);
        }

        //wp_register_script('scripts'      , get_template_directory_uri().'/js/scripts.js', array('bootstrap', 'jquery'), null, true);
        wp_register_script('scripts'      , get_template_directory_uri().'/js/scripts.js', array('jquery'), null, true);
        //wp_register_script('scripts'      , get_template_directory_uri().'/js/scripts.js', array('jquery', 'bootstrap'), null, true);

        wp_enqueue_script('scripts');
    }
    add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

    /* bulma y cf7 */
    /*
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if (is_plugin_active( 'contact-form-7/wp-contact-form-7.php' )) {
       wp_enqueue_script('cf7_loading', get_template_directory_uri().'/js/cf7bulma.js' , array('jquery'), null, true);
    }
    */
    add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');
    function wpcf7_autop_return_false() {
        return false;
    }


    //wp_enqueue_script('jquery');
    //wp_enqueue_script('scripts');



    /*
    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => 'Sidebar Widgets',
            'id'   => 'sidebar-widgets',
            'description'   => 'These are widgets for the sidebar.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));
    }
    */

    /*
     * Add support RSS feed, thumbnails and stuff
     * ========================================================================================================
     */
    require_once 'inc/admin/add-support.php';
    require_once 'inc/the_search_string.php';
    require_once 'inc/pagenavi.php';
    require_once 'inc/breadcrumb.php';


    //require_once(get_template_directory().'/inc/price-block.php');
    require_once 'inc/price-block.php';

  /*
     * Cunstom frontend functions
     * ========================================================================================================
     */
    function currency(){
         global $currency;
         $currency = array(
             1 => __('$', 'tnb' ),
             2 => __('U$S', 'tnb' ),
         );
         return $currency;
    }
    function orientation(){
        global $orientation;
        $orientation = array(
            1 => 'Norte',
    		2 => 'Este',
    		3 => 'Sur',
    		4 => 'Oeste',
        );
        return $orientation;
    }
    function front(){
        global $front;
        $front = array(
            1 => 'Frente',
     		2 => 'Contrafrente',
            3 => 'Interna',
        );
        return $front;
    }
    function phrases(){
         global $phrases;
         $phrases = array(
             1   => __('Apta para crédito', 'tnb' ),
             2   => __('Destacados', 'tnb' ),
             3   => __('Inversiones desde el pozo', 'tnb' ),
             4   => __('Oportunidad', 'tnb' ),
         );
         return $phrases;
    }
    function status(){
        global $status;
        $status = array(
            1 => __('En construcción', 'tnb' ),
            2 => __('Apta crédito', 'tnb' ),
            3 => __('En sucesión', 'tnb' ),
        );
        return $status;
    }
    function services(){
        global $services;
        $services = array(
            1 => __('Agua Corriente', 'tnb' ),
            2 => __('Gas Natural', 'tnb' ),
            3 => __('Conexión Eléctrica', 'tnb' ),
        );
        return $services;
    }

    /*
     * Register nav menus and sidebars
      * ========================================================================================================
      */

    //require_once('inc/admin/bs4navwalker.php');

    //https://github.com/Poruno/Bulma-Navwalker
    require_once('inc/admin/navwalker.php');
    // Las funciones register_menus() y propress_create_default_menus() están integradas en el hook principal
    // function register_menus() ha sido eliminada para evitar duplicación


    function register_menus() {
        // Register navigation menus
        register_nav_menus(
            array(
                'header-menu' => __( 'Menu Header' ),
                'search-menu' => __( 'Menu en el panel de búsqueda' ),
                //'footer-menu' => __( 'Menu Footer' )
            )
        );

        // Register sidebars
        if (function_exists('register_sidebar')) {
            register_sidebar(array(
                'name' => 'Sidebar Widgets',
                'id'   => 'sidebar-widgets',
                'description'   => 'Estos son los widgets del sidebar.',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title'  => '<h2>',
                'after_title'   => '</h2>'
            ));
            register_sidebar(array(
                'name' => 'Sidebar Propiedad Widgets',
                'id'   => 'sidebar-propiedad-widgets',
                'description'   => 'Estos son los widgets del sidebar de la propiedad.',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title'  => '<h2>',
                'after_title'   => '</h2>'
            ));
            register_sidebar(array(
                'name' => 'Footer 1',
                'id'   => 'footer-1-widgets',
                'description'   => 'Estos son los widgets de la columna 1 del footer.',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title'  => '<h2>',
                'after_title'   => '</h2>'
            ));
            register_sidebar(array(
                'name' => 'Footer 2',
                'id'   => 'footer-2-widgets',
                'description'   => 'Estos son los widgets de la columna 2 del footer.',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title'  => '<h2>',
                'after_title'   => '</h2>'
            ));
            register_sidebar(array(
                'name' => 'Footer 3',
                'id'   => 'footer-3-widgets',
                'description'   => 'Estos son los widgets de la columna 3 del footer.',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title'  => '<h2>',
                'after_title'   => '</h2>'
            ));
        }
    }
add_action('init', 'register_menus');




    /*
     * Widgets
     * ========================================================================================================
     */

    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => 'Sidebar Widgets',
            'id'   => 'sidebar-widgets',
            'description'   => 'Estos son los widgets del sidebar.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));
        register_sidebar(array(
            'name' => 'Sidebar Propiedad Widgets',
            'id'   => 'sidebar-propiedad-widgets',
            'description'   => 'Estos son los widgets del sidebar de la propiedad.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));
        register_sidebar(array(
            'name' => 'Footer 1',
            'id'   => 'footer-1-widgets',
            'description'   => 'Estos son los widgets de la columna 1 del footer.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));
        register_sidebar(array(
            'name' => 'Footer 2',
            'id'   => 'footer-2-widgets',
            'description'   => 'Estos son los widgets de la columna 2 del footer.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));
        register_sidebar(array(
            'name' => 'Footer 3',
            'id'   => 'footer-3-widgets',
            'description'   => 'Estos son los widgets de la columna 3 del footer.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));

    }


    //unregister all default WP Widgets
    function unregister_default_wp_widgets() {
        //unregister_widget('WP_Widget_Pages');
        //unregister_widget('WP_Widget_Calendar');
        //unregister_widget('WP_Widget_Archives');
        //unregister_widget('WP_Widget_Links');
        //unregister_widget('WP_Widget_Meta');
        unregister_widget('WP_Widget_Search');
        //unregister_widget('WP_Widget_Text');
        //unregister_widget('WP_Widget_Categories');
        //unregister_widget('WP_Widget_Recent_Posts');
        //unregister_widget('WP_Widget_Recent_Comments');
        //unregister_widget('WP_Widget_RSS');
        //unregister_widget('WP_Widget_Tag_Cloud');
     }
    add_action('widgets_init', 'unregister_default_wp_widgets', 1);

    //require_once ('inc/widgets/widget-example.php');
    require_once ('inc/widgets/viewed-properties.php');
    require_once ('inc/widgets/widget-agent.php');
    require_once 'inc/renderMap.php';

    /*
     add_filter( 'get_the_archive_title', function ( $title ) {
     if( is_taxonomy() ) {


    /*
    add_filter( 'get_the_archive_title', function ( $title ) {
    if( is_taxonomy() ) {
       $title = 'coso';
       //$title = single_cat_title( '', false );
    }
    return $title;
    });
    */


/**
 * Theme Setup - Create default terms and menus when theme is activated
 */
function propress_theme_setup() {
    propress_create_default_terms();
    propress_create_default_menus();

    // Optional: Display admin notice on theme activation
    if (is_admin() && isset($_GET['activated']) && $_GET['activated'] == 'true') {
        ?>
        <div class="notice notice-success is-dismissible">
            <h3><?php _e('¡Theme ProPress Activado!', 'tnb'); ?></h3>
            <p><?php _e('Se han creado los elementos por defecto:', 'tnb'); ?></p>
            <ul>
                <li><strong><?php _e('Tipos de propiedad:', 'tnb'); ?></strong> Casa, Departamento, Terreno</li>
                <li><strong><?php _e('Operaciones:', 'tnb'); ?></strong> Venta, Alquiler</li>
                <li><strong><?php _e('Menús:', 'tnb'); ?></strong> Menu Header, Menu de Búsqueda</li>
            </ul>
            <p><em><?php _e('Estos valores pueden modificarse desde el panel de administración', 'tnb'); ?></em></p>
        </div>
        <?php
    }
}

/**
 * Create default taxonomy terms
 */
function propress_create_default_terms() {
    // Create default property types if they don't exist
    $default_property_types = array(
        'casa' => array(
            'name' => 'Casa',
            'slug' => 'casa',
            'description' => 'Vivienda unifamiliar con múltiples ambientes'
        ),
        'departamento' => array(
            'name' => 'Departamento',
            'slug' => 'departamento',
            'description' => 'Unidad habitacional en edificio'
        ),
        'terreno' => array(
            'name' => 'Terreno',
            'slug' => 'terreno',
            'description' => 'Lote de terreno para construcción'
        )
    );

    // Insert default property types
    foreach ($default_property_types as $slug => $term_data) {
        if (!term_exists($slug, 'tipo')) {
            wp_insert_term($term_data['name'], 'tipo', array(
                'slug' => $term_data['slug'],
                'description' => $term_data['description']
            ));
        }
    }

    // Create default operations if they don't exist
    $default_operations = array(
        'venta' => array(
            'name' => 'Venta',
            'slug' => 'venta',
            'description' => 'Propiedades en venta'
        ),
        'alquiler' => array(
            'name' => 'Alquiler',
            'slug' => 'alquiler',
            'description' => 'Propiedades en alquiler'
        )
    );

    // Insert default operations
    foreach ($default_operations as $slug => $term_data) {
        if (!term_exists($slug, 'operacion')) {
            wp_insert_term($term_data['name'], 'operacion', array(
                'slug' => $term_data['slug'],
                'description' => $term_data['description']
            ));
        }
    }
}

/**
 * Create default menus and assign them to theme locations
 */
function propress_create_default_menus() {
    $locations = get_nav_menu_locations();

    // Crear menú para header-menu si no existe
    if (empty($locations['header-menu'])) {
        $menu_id = wp_create_nav_menu('Menu Header');
        $locations['header-menu'] = $menu_id;
    }

    // Crear menú para search-menu si no existe
    if (empty($locations['search-menu'])) {
        $menu_id = wp_create_nav_menu('Menu de Búsqueda');
        $locations['search-menu'] = $menu_id;
    }

    // Update theme mod with menu locations
    set_theme_mod('nav_menu_locations', $locations);
}
// Hook changed to 'init' with priority 1 to run AFTER taxonomies are registered (priority 0)
add_action('init', 'propress_theme_setup', 1);

/**
 * Show theme activation notice
 */
function propress_theme_activation_notice() {
    // Set activation flag
    add_option('propress_activated', 'true');

    // Only redirect if not already activated to prevent infinite loop
    if (!isset($_GET['activated'])) {
        wp_safe_redirect(admin_url('themes.php?activated=true'));
        exit;
    }
}
add_action('after_switch_theme', 'propress_theme_activation_notice');

/**
 * Clear activation notice after viewing
 */
function propress_clear_activation_notice() {
    delete_option('propress_activated');
}
add_action('admin_notices', 'propress_clear_activation_notice');

    /**
     * Test if a WordPress plugin is active
     */
    /*
    if(in_array('elementor/elementor.php', apply_filters('active_plugins', get_option('active_plugins')))){
        require_once('elementor-widgets/my-widgets.php');
    }
    */
    
    /**
     * Include search form template directly
     * Fixes WordPress 6.x + PHP 8+ bug with get_search_form()
     */
    function tnb_get_search_form() {
        include locate_template('searchform.php');
    }
    
    /**
     * Hide default taxonomy metaboxes from sidebar
     * Since Tipo, Operacion, Estado, Servicios and Prestaciones are now handled by CMB2 fields
     */
    add_action('admin_head', 'hide_propiedad_taxonomy_metaboxes_admin', 999);
    function hide_propiedad_taxonomy_metaboxes_admin() {
        global $pagenow, $post_type;
        if (($pagenow == 'post.php' || $pagenow == 'post-new.php') && $post_type == 'propiedad') {
            echo '<style>
                /* Hide all taxonomy metaboxes from sidebar - handled by CMB2 fields */
                #tagsdiv-tipo, 
                #tagsdiv-operacion,
                #tagsdiv-status,
                #statusdiv,
                #tagsdiv-services,
                #servicesdiv,
                #tagsdiv-prestaciones,
                .postbox#tagsdiv-tipo, 
                .postbox#tagsdiv-operacion,
                .postbox#tagsdiv-status,
                .postbox#statusdiv,
                .postbox#tagsdiv-services,
                .postbox#servicesdiv,
                .postbox#tagsdiv-prestaciones {
                    display: none !important;
                }
            </style>';
        }
    }
    
    /**
     * Make featured image required for propiedad post type
     * COMMENTED OUT: User requested to remove this requirement
     * To re-enable, uncomment the code below
     */
    /*
    add_action('admin_footer-post.php', 'require_featured_image_propiedad');
    add_action('admin_footer-post-new.php', 'require_featured_image_propiedad');
    function require_featured_image_propiedad() {
        global $post_type;
        if ($post_type == 'propiedad') {
            echo '<script>
                jQuery(document).ready(function($) {
                    // Check on form submit
                    $("#post").on("submit", function(e) {
                        if ($("#set-post-thumbnail").find("img").length == 0) {
                            alert("' . __('Por favor, agregue una imagen destacada antes de publicar.', 'tnb') . '");
                            $("#postimagediv").focus();
                            e.preventDefault();
                            return false;
                        }
                    });
                    
                    // Visual indicator
                    if ($("#set-post-thumbnail").find("img").length == 0) {
                        $("#postimagediv h2").append(" <span style=\"color: #d63638;\">* ' . __('Requerida', 'tnb') . '</span>");
                        $("#postimagediv").css("border", "2px solid #d63638");
                    }
                });
            </script>';
        }
    }
    */
    
    // =============================================================================
    // FAKERPRESS INTEGRATION - Auto-fill CMB2 fields when generating dummy posts
    // =============================================================================
    // Este hook se ejecuta cuando FakerPress crea posts y llena automáticamente
    // los metadatos de CMB2 para testing del theme.
    // 
    // Para deshabilitar: Comenta o elimina las siguientes 3 líneas de add_action
    // =============================================================================
    
    add_action('fakerpress/post/inserted', 'propress_fakerpress_fill_meta', 10, 2);
    
    function propress_fakerpress_fill_meta($post_id, $conf) {
        // Solo para posts de tipo 'propiedad'
        if (get_post_type($post_id) !== 'propiedad') {
            return;
        }
        
        // Array de tipos de propiedad disponibles
        $tipos = array('casa', 'departamento', 'terreno');
        
        // Array de operaciones disponibles
        $operaciones = array('venta', 'alquiler');
        
        // Array de estados disponibles
        $estados = array('a-estrenar', 'en-construccion', 'renovada');
        
        // Array de localidades (ejemplos)
        $localidades = array('centro', 'norte', 'sur', 'este', 'oeste');
        
        // Seleccionar valores aleatorios
        $tipo = $tipos[array_rand($tipos)];
        $operacion = $operaciones[array_rand($operaciones)];
        $estado = $estados[array_rand($estados)];
        $localidad = $localidades[array_rand($localidades)];
        
        // Precios aleatorios
        $precio_venta = rand(50000, 500000);
        $precio_alquiler = rand(300, 3000);
        
        // Características aleatorias
        $dormitorios = rand(1, 5);
        $banos = rand(1, 3);
        $superficie = rand(40, 500);
        
        // Dirección ficticia
        $calles = array('Av. Santa Fe', 'Calle Corrientes', 'Av. Libertador', 'Calle Cordoba', 'Av. 9 de Julio');
        $direccion = $calles[array_rand($calles)] . ' ' . rand(100, 9999);
        
        // Coordenadas aproximadas de Argentina (Santa Fe/Paraná)
        $lat = -31.6330832 + (rand(-1000, 1000) / 10000);
        $lon = -60.7079291 + (rand(-1000, 1000) / 10000);
        
        // Rellenar metadatos de CMB2
        update_post_meta($post_id, '_prop_tipo', $tipo);
        update_post_meta($post_id, '_prop_operacion', array($operacion));
        update_post_meta($post_id, '_prop_status', $estado);
        update_post_meta($post_id, '_prop_price_sale', $precio_venta);
        update_post_meta($post_id, '_prop_price_rent', $precio_alquiler);
        update_post_meta($post_id, '_prop_dormrooms', $dormitorios);
        update_post_meta($post_id, '_prop_bathrooms', $banos);
        update_post_meta($post_id, '_prop_sup', $superficie);
        update_post_meta($post_id, '_prop_address', $direccion);
        update_post_meta($post_id, '_prop_location', $localidad);
        update_post_meta($post_id, '_prop_map', array(
            'latitude' => $lat,
            'longitude' => $lon
        ));
        
        // Servicios aleatorios (3-5 servicios)
        $all_services = array('agua', 'gas', 'luz', 'wifi', 'piscina', 'gimnasio', 'seguridad');
        $num_services = rand(3, 5);
        $selected_services = array_rand(array_flip($all_services), $num_services);
        if (!is_array($selected_services)) {
            $selected_services = array($selected_services);
        }
        update_post_meta($post_id, '_prop_services', $selected_services);
        
        // Prestaciones aleatorias (2-4 prestaciones)
        $all_prestaciones = array('patio', 'balcon', 'terraza', 'jardin', 'cochera', 'quincho');
        $num_prestaciones = rand(2, 4);
        $selected_prestaciones = array_rand(array_flip($all_prestaciones), $num_prestaciones);
        if (!is_array($selected_prestaciones)) {
            $selected_prestaciones = array($selected_prestaciones);
        }
        update_post_meta($post_id, '_prop_prestaciones', $selected_prestaciones);
        
        // Asignar términos de taxonomías
        wp_set_object_terms($post_id, $tipo, 'tipo');
        wp_set_object_terms($post_id, $operacion, 'operacion');
        wp_set_object_terms($post_id, $estado, 'status');
        wp_set_object_terms($post_id, $localidad, 'location');
        
        // Imagen destacada aleatoria (si está disponible)
        $args = array(
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'posts_per_page' => -1,
            'fields' => 'ids'
        );
        $images = get_posts($args);
        if (!empty($images)) {
            $random_image = $images[array_rand($images)];
            set_post_thumbnail($post_id, $random_image);
        }
    }
    // =============================================================================
    // FIN FAKERPRESS INTEGRATION
    // =============================================================================
    
    /**
     * Flush rewrite rules on theme activation to prevent 404 errors on pages
     */
    add_action('after_switch_theme', 'propress_flush_rewrite_rules');
    function propress_flush_rewrite_rules() {
        // Set flag to show notice instead of auto-flushing (can cause issues on some servers)
        add_option('propress_flush_needed', 'true');
    }
    
    /**
     * Also flush when visiting admin to ensure rules are fresh
     */
    add_action('admin_init', 'propress_maybe_flush_rules');
    function propress_maybe_flush_rules() {
        if (get_option('propress_flush_needed')) {
            flush_rewrite_rules();
            delete_option('propress_flush_needed');
        }
    }
    
/**
 * Show admin notice if rewrite rules need to be flushed
 */
add_action('admin_notices', 'propress_flush_notice');
function propress_flush_notice() {
    if (get_option('propress_flush_needed')) {
        echo '<div class="notice notice-warning is-dismissible">
            <p><strong>' . __('Acción Requerida:', 'tnb') . '</strong> ' . __('Por favor ve a <a href="' . admin_url('options-permalink.php') . '">Ajustes > Enlaces permanentes</a> y haz clic en "Guardar cambios" para regenerar las URLs.', 'tnb') . '</p>
        </div>';
    }
}

/**
 * TEMPORARY: Force flush rewrite rules on next admin visit
 * Remove this after testing 404s are resolved
 */
add_action('admin_init', 'propress_debug_flush_once', 1);
function propress_debug_flush_once() {
    // Reset the flag to force a new flush after taxonomy name change
    delete_option('propress_debug_flushed');
    if (!get_option('propress_debug_flushed_v2')) {
        flush_rewrite_rules();
        update_option('propress_debug_flushed_v2', 'done');
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success is-dismissible">
                <p><strong>Debug:</strong> Rewrite rules flushed automatically after fixing taxonomy conflict. 404s should be resolved now.</p>
            </div>';
        });
    }
}

/*
// Frontend force flush (for admin users only)
// To enable, uncomment this block
add_action('wp_footer', 'propress_debug_flush_frontend', 1);
function propress_debug_flush_frontend() {
    if (!current_user_can('manage_options')) return;
    if (isset($_GET['force_flush'])) {
        flush_rewrite_rules();
        echo '<div style="background:#d4edda;color:#155724;padding:20px;margin:20px;font-family:monospace;z-index:99999;position:relative;">
            <h3>✅ REWRITE RULES FLUSHED!</h3>
            <p>Las reglas de reescritura han sido regeneradas. Refresca la página para ver los cambios.</p>
        </div>';
    }
}
*/

    ?>