<?php
//register settings
//http://www.wpexplorer.com/wordpress-theme-options/
function theme_site_options_init(){
    add_option( 'site_options');
    register_setting( 'site_options', 'site_options' );
}
//add settings page to menu
function add_settings_page() {
    add_menu_page( __( 'Opciones' ), __( 'Opciones' ), 'manage_options', 'settings', 'theme_site_options_page');
}

//add actions
add_action( 'admin_init', 'theme_site_options_init' );
add_action( 'admin_menu', 'add_settings_page' );

function ilc_admin_tabs( $current = 'homepage' ) {
    $tabs = array( 'homepage' => 'Home', 'contacto' => 'Contacto');
    $links = array();
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=settings&tab=$tab'>$name</a>";

    }
    echo '</h2>';
}


//start settings page
function theme_site_options_page() {
        if ( ! isset( $_REQUEST['updated'] )) $_REQUEST['updated'] = false;
    ?>
    <div class="wrap">
        <h2><?php _e( 'Opciones del sitio' ) //your admin panel title ?></h2>
        <?php
        //show saved options message
        if ( false !== $_REQUEST['updated'] ) : ?>
            <div><p><strong><?php _e( 'Opciones guardadas' ); ?></strong></p></div>
        <?php endif; ?>

        <?php if ( isset ( $_GET['tab'] ) ) ilc_admin_tabs($_GET['tab']); else ilc_admin_tabs('homepage'); ?>

        <form method="post" action="options.php">

            <?php
                settings_fields('site_options');
                $options = get_option( 'site_options' );
            ?>

            <?php
            //defaults
            if(!$options['projects-on-home'] || $options['projects-on-home'] == 0){
                $options['projects-on-home'] = 12;
            }

            if(!$options['email']){
                $admin_email = get_option( 'admin_email' );
                $options['email'] = $admin_email;
            }

            ?>

            <?php
            if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab'];
                else $tab = 'homepage';
                ?>
            <table class="form-table">
            <?php
            switch ( $tab ){
                case 'homepage' : ?>
                        <tr valign="top">
                            <th scope="row">
                                <label for="site_options[projects-on-home]">
                                    <?php _e( 'Proyectos en home' ); ?>
                                </label>
                            </th>
                            <td>
                                <input class="regular-text" id="site_options[projects-on-home]" type="text" size="36" name="site_options[projects-on-home]" value="<?php echo intval( $options['projects-on-home'] ); ?>" />
                                <p class="description"><?php _e('Cuantos proyectos mostramos en home (por defecto 12)')?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="site_options[phone-home]">
                                    <?php _e( 'Teléfono en home' ); ?>
                                </label>
                            </th>
                            <td>
                                <input class="regular-text" id="site_options[phone-home]" type="text" size="36" name="site_options[phone-home]" value="<?php echo esc_attr_e( $options['phone-home'] ); ?>" />
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="site_options[mail-home]">
                                    <?php _e( 'Mail en home' ); ?>
                                </label>
                            </th>
                            <td>
                                <input class="regular-text" id="site_options[mail-home]" type="text" size="36" name="site_options[mail-home]" value="<?php echo esc_attr_e( $options['mail-home'] ); ?>" />
                            </td>
                        </tr>
                        <?php /*
                        <tr valign="top">
                            <th scope="row">
                                <label for="site_options[blank-boxes]">
                                    <?php _e( 'Espacios en blanco' ); ?>
                                </label>
                            </th>
                            <td>
                                <input class="regular-text" id="site_options[blank-boxes]" type="text" size="36" name="site_options[blank-boxes]" value="<?php echo intval( $options['blank-boxes'] ); ?>" />
                                <p class="description"><?php _e('Cada cuantos cuadros mostramos un blanco en la grilla de proyectos')?></p>
                                <br />
                                <br />
                            </td>
                        </tr>
                        */ ?>
           <?php
                break;
                case 'contacto': ?>
                        <tr  valign="top">
                            <th scope="row">
                                <label for="site_options[email]">
                                    <?php _e( 'Email' ); ?>
                                </label>
                            </th>
                            <td>
                                <input class="regular-text" id="site_options[email]" type="text" size="36" name="site_options[email]" value="<?php echo is_email( $options['email'] ); ?>" /><br />
                                <p class="description"><?php _e('Se creará un enlace con esta información si no se introduce ninguno, se usara el email del admin del sitio')?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="site_options[phone]">
                                    <?php _e( 'Teléfono' ); ?>
                                </label>
                            </th>
                            <td>
                                <input class="regular-text" id="site_options[phone]" type="text" size="36" name="site_options[phone]" value="<?php esc_attr_e( $options['phone'] ); ?>" /><br />
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="site_options[pinterest]">
                                    <?php _e( 'Perfil de Pinterest' ); ?>
                                </label>
                            </th>
                            <td>
                                <input class="regular-text" id="site_options[pinterest]" type="text" size="36" name="site_options[pinterest]" value="<?php echo esc_url( $options['pinterest'] ); ?>" /><br />
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="site_options[facebook]">
                                    <?php _e( 'Perfil de Facebook' ); ?>
                                </label>
                            </th>
                            <td>
                                <input class="regular-text" id="site_options[facebook]" type="text" size="36" name="site_options[facebook]" value="<?php echo esc_url( $options['facebook'] ); ?>" /><br />
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="site_options[google-plus]">
                                    <?php _e( 'Perfil de Google Plus' ); ?>
                                </label>
                            </th>
                            <td>
                                <input class="regular-text" id="site_options[google-plus]" type="text" size="36" name="site_options[google-plus]" value="<?php echo esc_url( $options['google-plus'] ); ?>" /><br />
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="site_options[twitter]">
                                    <?php _e( 'Perfil de Twitter' ); ?>
                                </label>
                            </th>
                            <td>
                                <input class="regular-text" id="site_options[twitter]" type="text" size="36" name="site_options[twitter]" value="<?php echo esc_url( $options['twitter'] ); ?>" /><br />
                            </td>
                        </tr>
                        <?php /*
                        <tr class="form-field">
                            <th scope="row"><label for="site_options[phone]"><?php _e( 'Perfil de facebook' ); ?></label></th>
                            <td>
                                <input class="widefat" id="site_options[fb_link]" type="text" size="36" name="site_options[fb_link]" value="<?php esc_attr_e( $options['fb_link'] ); ?>" /><br />
                                <label>Se creará un enlace con esta información</label>
                            </td>
                        </tr>
                        <tr class="form-field">
                            <th scope="row"><label for="site_options[phone]"><?php _e( 'Perfil de twitter' ); ?></label></th>
                            <td>
                                <input class="widefat" id="site_options[twitterid]" type="text" size="36" name="site_options[twitterid]" value="<?php esc_attr_e( $options['twitterid'] ); ?>" /><br />
                                <label>Se creará un enlace con esta información</label>
                            </td>
                        </tr>
                        */ ?>
            <?php break;
            } ?>
            </table>
            <hr />
            <p><input class="button button-primary" name="submit" id="submit" value="Guardar cambios" type="submit"></p>
        </form>
    </div>
<?php } ?>