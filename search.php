<?php get_header(); ?>
<div class="search-panel block">
	<div class="container">
		<?php tnb_get_search_form(); ?>
	</div>
</div>
<div class="container">
    <?php the_breadcrumb(); ?>
    <h2 class="title is-3">
        <?php echo get_search_string($wp_query); ?>
        <?php //get_template_part('parts/toggle', 'search'); ?>
    </h2>

    <div class="columns">
        <div class="column is-three-quarters">
        <?php if (have_posts()) : ?>
            <?php $i = 0 ?>
            <?php while (have_posts()) : the_post(); ?>
				    <?php get_template_part('parts/post','list') ?>
                <?php $i++; ?>
				<?php //echo ($i % 2 == 0) ? '</div><div class="row">':'' ?>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="notification is-info" style="text-align: center; padding: 2rem; margin: 2rem 0;">
                <h3 style="margin-bottom: 1rem; color: #3273dc;"><?php echo _e('No hay resultados de búsqueda', 'tnb') ?></h3>
                <p><?php echo _e('No encontramos propiedades que coincidan con tus criterios. Por favor, intenta con otros filtros o términos de búsqueda.', 'tnb') ?></p>
                <div style="margin-top: 1.5rem;">
                    <a href="<?php echo home_url('/'); ?>" class="button is-primary">
                        <?php echo _e('Ver todas las propiedades', 'tnb') ?>
                    </a>
                </div>
            </div>
        <?php endif; ?>
        <?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>

        </div>
        <div class="column is-one-quarter">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
