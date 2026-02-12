<?php
/*
Template Name: Contacto
Template Post Type: page
*/
get_header(); ?>

<div class="grid">
<?php //the_breadcrumb(); ?>
<h2 class="h2 title title-primary"><?php the_title(); ?></h2>
<div class="columns">
	<div class="column is-8">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div <?php post_class() ?>id="post-<?php the_ID(); ?>">
			<?php //include (TEMPLATEPATH . '/inc/meta.php' ); ?>
			<div class="entry">
				<?php the_content(); ?>
			</div>
			<?php //wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
			<?php //edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
			<div class="panel panel-alt">
				<?php include ('inc/admin/contact-form.php' ); ?>
			</div>
		</div>

		<?php //comments_template(); ?>
		<?php endwhile; endif; ?>
	</div>
	<div class="column is-4" id="sidebar">
		<?php
			get_sidebar();
		?>
	</div>
	</div>
</div>
</div>
<?php get_footer(); ?>
