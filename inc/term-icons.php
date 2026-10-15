<?php
/**
 * Lucide icon selector for taxonomy terms (tipo, features, services).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const TNB_ICON_META_KEY = '_tnb_icon';

/**
 * Default icons used by the theme, to seed a few common terms on demand.
 */
function tnb_icon_defaults() {
	return array(
		'casa'          => 'house',
		'departamento'  => 'building-2',
		'terreno'       => 'trees',
		'cochera'       => 'car-front',
		'local'         => 'store',
		'oficina'       => 'briefcase',
	);
}

/**
 * Build the picker markup.
 *
 * @param string $value Current icon name.
 */
function tnb_icon_picker_html( $value = '' ) {
	$value = (string) $value;

	ob_start();
	?>
	<div class="tnb-icon-picker">
		<input type="hidden" class="tnb-icon-picker__value" name="tnb_icon" value="<?php echo esc_attr( $value ); ?>">
		<div class="tnb-icon-picker__current">
			<span class="tnb-icon-picker__preview"></span>
			<span class="tnb-icon-picker__name"><?php echo $value ? esc_html( $value ) : esc_html__( 'Sin icono', 'tnb' ); ?></span>
			<button type="button" class="button tnb-icon-picker__toggle"><?php esc_html_e( 'Elegir icono', 'tnb' ); ?></button>
			<button type="button" class="button-link tnb-icon-picker__clear"><?php esc_html_e( 'Quitar', 'tnb' ); ?></button>
		</div>
		<div class="tnb-icon-picker__panel" hidden>
			<input type="text" class="tnb-icon-picker__search regular-text" placeholder="<?php esc_attr_e( 'Buscar icono...', 'tnb' ); ?>">
			<div class="tnb-icon-picker__grid"></div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Field shown on the "Add term" screen.
 */
function tnb_term_icon_add_field() {
	?>
	<div class="form-field tnb-icon-picker-field">
		<label><?php esc_html_e( 'Icono', 'tnb' ); ?></label>
		<?php echo tnb_icon_picker_html( '' ); ?>
		<p><?php esc_html_e( 'Elegí un icono de Lucide (lucide.dev/icons).', 'tnb' ); ?></p>
	</div>
	<?php
}

/**
 * Field shown on the "Edit term" screen.
 *
 * @param WP_Term $term Term being edited.
 */
function tnb_term_icon_edit_field( $term ) {
	$value = get_term_meta( $term->term_id, TNB_ICON_META_KEY, true );
	?>
	<tr class="form-field tnb-icon-picker-field">
		<th scope="row"><label><?php esc_html_e( 'Icono', 'tnb' ); ?></label></th>
		<td>
			<?php echo tnb_icon_picker_html( $value ); ?>
			<p class="description"><?php esc_html_e( 'Elegí un icono de Lucide (lucide.dev/icons).', 'tnb' ); ?></p>
		</td>
	</tr>
	<?php
}

/**
 * Persist the icon on term create/edit.
 *
 * @param int $term_id Term ID.
 */
function tnb_save_term_icon( $term_id ) {
	if ( ! isset( $_POST['tnb_icon'] ) ) {
		return;
	}

	$value = sanitize_text_field( wp_unslash( $_POST['tnb_icon'] ) );

	if ( '' === $value ) {
		delete_term_meta( $term_id, TNB_ICON_META_KEY );
	} else {
		update_term_meta( $term_id, TNB_ICON_META_KEY, $value );
	}
}

/**
 * Add an icon column to the terms list table.
 */
function tnb_term_icon_column( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'name' === $key ) {
			$new['tnb_icon'] = __( 'Icono', 'tnb' );
		}
	}

	return $new;
}

/**
 * Render the icon column content.
 *
 * @param string $content Current content.
 * @param string $column  Column key.
 * @param int    $term_id Term ID.
 */
function tnb_term_icon_column_content( $content, $column, $term_id ) {
	if ( 'tnb_icon' !== $column ) {
		return $content;
	}

	$icon = tnb_get_term_icon( $term_id );

	return $icon ? tnb_icon( $icon, '', 22 ) : '&mdash;';
}

foreach ( tnb_icon_taxonomies() as $tnb_icon_tax ) {
	add_action( $tnb_icon_tax . '_add_form_fields', 'tnb_term_icon_add_field' );
	add_action( $tnb_icon_tax . '_edit_form_fields', 'tnb_term_icon_edit_field' );
	add_action( 'created_' . $tnb_icon_tax, 'tnb_save_term_icon' );
	add_action( 'edited_' . $tnb_icon_tax, 'tnb_save_term_icon' );

	add_filter( 'manage_edit-' . $tnb_icon_tax . '_columns', 'tnb_term_icon_column' );
	add_filter( 'manage_' . $tnb_icon_tax . '_custom_column', 'tnb_term_icon_column_content', 10, 3 );
}

/**
 * Load the picker assets only on the relevant term screens.
 *
 * @param string $hook Current admin page.
 */
function tnb_icon_admin_assets( $hook ) {
	$screen = get_current_screen();

	if ( ! $screen || ! in_array( $screen->taxonomy, tnb_icon_taxonomies(), true ) ) {
		return;
	}

	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style(
		'tnb-icon-picker',
		$uri . '/inc/lucide/tnb-icon-picker.css',
		array(),
		file_exists( $dir . '/inc/lucide/tnb-icon-picker.css' ) ? filemtime( $dir . '/inc/lucide/tnb-icon-picker.css' ) : '1.0.0'
	);

	wp_enqueue_script(
		'lucide',
		$uri . '/inc/lucide/lucide.min.js',
		array(),
		'1.57.0',
		true
	);

	wp_enqueue_script(
		'tnb-icons',
		$uri . '/inc/lucide/tnb-icons.js',
		array( 'lucide' ),
		'1.0.0',
		true
	);

	wp_enqueue_script(
		'tnb-icon-picker',
		$uri . '/inc/lucide/tnb-icon-picker.js',
		array( 'lucide' ),
		file_exists( $dir . '/inc/lucide/tnb-icon-picker.js' ) ? filemtime( $dir . '/inc/lucide/tnb-icon-picker.js' ) : '1.0.0',
		true
	);
}
add_action( 'admin_enqueue_scripts', 'tnb_icon_admin_assets' );
