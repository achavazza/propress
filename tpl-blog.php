<?php
/*
Template Name: Blog
Template Post Type: page
*/
get_header(); ?>

<div class="grid">
	<?php //the_breadcrumb(); ?>
	<h2 class="h2 title"><?php the_title(); ?></h2>
	<div class="columns">
	<div class="column is-9">
			<?php if (have_posts()) : ?>
				<?php $i = 0 ?>
				<div class="columns is-multiline">
					<?php while (have_posts()) : the_post(); ?>
						<div class="column is-half">
							<?php get_template_part('parts/post','loop') ?>
						</div>
						<?php if(++$i % 2 === 0): ?>
						</div><div class="columns is-multiline">
						<?php endif; ?>
					<?php endwhile; ?>
				</div>
			<?php else : ?>
				<div class="notification is-info" style="text-align: center; padding: 2rem; margin: 2rem 0;">
					<h3 style="margin-bottom: 1rem; color: #3273dc;"><?php echo _e('No hay artículos publicados', 'tnb') ?></h3>
					<p><?php echo _e('Actualmente no hay artículos en el blog. Por favor, vuelve más tarde para ver nuevas publicaciones.', 'tnb') ?></p>
					<div style="margin-top: 1.5rem;">
						<a href="<?php echo home_url('/'); ?>" class="button is-primary">
							<?php echo _e('Volver al inicio', 'tnb') ?>
						</a>
					</div>
				</div>
			<?php endif; ?>
			<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>

		</div>
		<div class="column is-3">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
