<?php get_header(); ?>
<div class="search-panel block">
	<div class="container">
		<?php include locate_template('searchform.php'); ?> 
		<?php //echo get_search_form(); ?>
	</div>
</div>
<div class="container">
	<div class="columns">
		<div class="column is-three-quarters">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php get_template_part('parts/blog','list') ?>

			<?php endwhile; ?>

			<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>
			<?php else : ?>
				<div class="notification is-default" style="text-align: center; padding: 2rem; margin: 2rem 0;">
					<h3 style="margin-bottom: 1rem; color: #3273dc;"><?php echo _e('No hay propiedades disponibles', 'tnb') ?></h3>
					<p><?php echo _e('Actualmente no hay propiedades que coincidan con tus criterios de búsqueda. Por favor, intenta con otros filtros o vuelve más tarde.', 'tnb') ?></p>
					<div style="margin-top: 1rem;">
						<a href="<?php echo home_url('/'); ?>" class="button is-primary">
							<?php echo _e('Ver todas las propiedades', 'tnb') ?>
						</a>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="column is-one-quarter">
			<?php get_sidebar(); ?>
		</div>
	</div>

</div>

<?php get_footer(); ?>