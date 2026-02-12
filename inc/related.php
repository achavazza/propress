<?php
// Fixed: Declare global $post and check if it exists
global $post;

// Fixed: Safely get term IDs
$operacion_terms = wp_get_post_terms($post->ID, 'operacion');
$location_terms  = wp_get_post_terms($post->ID, 'location');

$operacion_term_id = !empty($operacion_terms) && !is_wp_error($operacion_terms) ? $operacion_terms[0]->term_id : 0;
$location_term_id  = !empty($location_terms) && !is_wp_error($location_terms) ? $location_terms[0]->term_id : 0;

$tax_query = array();

if ($operacion_term_id) {
    $tax_query[] = array(
        'taxonomy'     => 'operacion',
        'field'        => 'id',
        'terms'        => $operacion_term_id,
    );
}

if ($location_term_id) {
    $tax_query[] = array(
        'taxonomy'     => 'location',
        'field'        => 'id',
        'terms'        => $location_term_id,
    );
}

$args = array(
	'post_type'  	 => 'propiedad',
	'posts_per_page' => 2,
	'order'			 => 'DESC',
	'orderby'		 => 'ID',
	'post__not_in'   => array($post->ID),
	'tax_query'      => $tax_query,
    /*
    'meta_query'  => array(
        array(
            'key'     => '_prop_featured',
            //'value'   => true,
            'compare' => '=',
        )
    )
    */
);
$related = new WP_Query( $args );
//pr($related);
if ( $related->have_posts()) {
	echo '<h2 class="h3 title">Propiedades Similares</h2>';
	echo '<div class="colums is-same-height">';
	while ($related->have_posts()): $related->the_post();
		echo '<div class="columns is-one-third">';
		get_template_part('parts/post','loop');
		echo '</div>';
	endwhile;
	echo '</div>';
}
wp_reset_postdata();
?>
