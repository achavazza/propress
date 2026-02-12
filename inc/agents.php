
<?php
/*
$args = array(
	'post_type'  	 => 'agent',
	'posts_per_page' => 4,
	'order'			 => 'DESC',
	'orderby'		 => 'ID'

);
$related = new WP_Query( $args );
if ( $related->have_posts()) {
	echo '<div class="panel">';
		echo sprintf('<div class="panel-head"><h3 class="h5">%s</h3></div>', __('Asesores'));
		echo '<div class="panel-content">';
		echo '<div class="columns">';
			while ($related->have_posts()): $related->the_post();
				echo '<div class="column is-half">';
					get_template_part('parts/agent','loop');
				echo '</div>';
			endwhile;
		echo '</div>';
		echo '</div>';
	echo '</div>';
}
wp_reset_postdata();
*/
?>

<?php
$attached_agents = get_post_meta( get_the_ID(), '_prop_attached_agents', true );
if($attached_agents){
echo '<div class="card block">';
	echo sprintf('<div class="card-header"><h3 class="card-header-title">%s</h3></div>', __('Asesores'));
		echo '<div class="card-content">';
		foreach ( $attached_agents as $attached_agent ) {
			$agent = get_post( $attached_agent );
			//pr($agent);
			//pr(get_post_meta($agent->ID));
			set_query_var( 'agent', $agent );
			get_template_part('parts/agent','attached');
			//get_template_part('parts/agent','loop');
            $contact = get_post_meta($attached_agent)['_agent_contact'][0];
            if($contact){
                echo '<hr />';
                echo do_shortcode($contact, true);
            }
		}
        do_shortcode($notification_form, true);
	echo '</div>';
echo '</div>';
}

?>
