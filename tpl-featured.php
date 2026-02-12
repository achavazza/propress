<?php
/*
Template Name: Destacadas
Template Post Type: page
*/
get_header(); ?>

<div class="grid">
<?php //the_breadcrumb(); ?>
	<?php
		$args = array(
			'post_type'           => 'propiedad',
			//'category_name'       => 'current',
			//'ignore_sticky_posts' => 1,
			//'paged'               => $paged
			'meta_query'  => array(
		            array(
		                'key'     => '_prop_featured',
		                //'value'   => true,
						'compare' => '=',
		            )
		        )
		);
		$loop = new WP_Query( $args );
	?>
	<div class="columns">
		<div class="column is-8">
			<?php if ( $loop->have_posts() ) : ?>
				<?php $i = 0 ?>
				<div class="post-list">
					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
						<?php get_template_part('parts/post','list') ?>
					<?php endwhile; ?>
				</div>
			<?php else : ?>
					<div class="notification is-warning" style="text-align: center; padding: 2rem; margin: 2rem 0;">
						<h3 style="margin-bottom: 1rem; color: #d96b11;"><?php echo _e('No hay propiedades destacadas', 'tnb') ?></h3>
						<p><?php echo _e('Actualmente no hay propiedades destacadas. Por favor, revisa todas las propiedades disponibles.', 'tnb') ?></p>
						<div style="margin-top: 1.5rem;">
							<a href="<?php echo home_url('/'); ?>" class="button is-primary">
								<?php echo _e('Ver todas las propiedades', 'tnb') ?>
							</a>
						</div>
					</div>
			<?php endif; ?>
			<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>
				<?php /*
				<?php if (  $loop->max_num_pages > 1 ) : ?>
					<div id="nav-below" class="navigation">
						<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Previous', 'domain' ) ); ?></div>
						<div class="nav-next"><?php previous_posts_link( __( 'Next <span class="meta-nav">&rarr;</span>', 'domain' ) ); ?></div>
					</div>
				<?php endif; ?>
				*/ ?>
			<?php wp_reset_postdata(); ?>
		</div>
		<div class="column is-4">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
