<?php
get_header(); ?>
<style>
/* fix bulma minireset */
html{overflow:hidden}</style>
<?php wp_enqueue_script('gmaps'); ?>
<div id="map-container" style="height:calc(100vh - 110px);">
	<div class="map-layout" id="gmap_canvas"></div>
	<div class="container map-search">
		<div class="search-panel">
			<?php tnb_get_search_form(); ?>
		</div>

		<script type="text/javascript">
			// create variables>
			var body = [];
			var markers = [];
			var locations = [];
			var infoBubble;
			var json_props;
		</script>
		<?php
		// Open this line to Debug what's query WP has just run
		// Show the results
		//pr(query_posts(array( 'post_type' => 'propiedad')));
		if(have_posts() ) :

			$i = 0;
			echo '<div class="column">';
			echo '<div class="columns is-same-height is-multiline">';
			//echo '<div class="row">';
			while (have_posts()) : the_post();
				echo '<div class="column is-half">';
		        require('inc/map-search/map-post.php');
					get_template_part('parts/post','loop');
				echo '</div>';
				$i++;
				//echo ($i % 2 == 0) ? '</div><div class="row">':'';
			endwhile;
			echo '</div>';
			echo '</div>';

			$prop_json = json_encode($props);
			?>
			<script type="text/javascript">
				json_props = <?php echo json_encode(json_decode($prop_json,TRUE)); ?>;
				for (i = 0; i < json_props.length; i++) {
					locations.push(json_props[i]['latlng']);
					body.push(json_props[i]['body']);
				}
			</script>
			<?php
			else :
				echo '<div class="map-layout">';
					echo '<div class="content-wrap">';
						    echo sprintf('<h2>%s</h2>', _e( 'Lo sentimos :(', 'propress' ));
						    echo sprintf('<p>%s</p>', _e( 'no encontramos ninguna propiedad con esa búsqueda', 'propress' ));
					echo '</div>';
				echo '</div>';
			endif;
			wp_reset_postdata();
			?>
		</div>
	</div>
<?php //get_footer(); ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
