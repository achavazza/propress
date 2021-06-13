<?php
/*
Template Name: Home
*/
get_header();
//get_template_part('parts/home','slider'); ?>
<?php
$home  = get_option('page_on_front');
//$img   = get_the_post_thumbnail_url($home, 'slide');
$data  = get_post_meta($home);
/*
$title = $data['_home_title'][0];
$subt  = $data['_home_subtitle'][0];

if($img){
	$bg = ' style="background:url('.$img.')" ';
}*/
?>

<?php include('inc/slider.php'); ?>
<div class="section has-background-dark has-text-light">
	<div class="container">
		<?php echo get_search_form(); ?>
	</div>
</div>

<?php /*
<div id="hero-featured">
	<div class="container">
		<?php
		$args = array(
	    'post_type'      => 'propiedad',
		'posts_per_page' => 3,
	    'meta_query'  => array(
	            array(
	                'key'     => '_prop_featured',
	                //'value'   => true,
					'compare' => '=',
	            )
	        )
		);
		$loop = new WP_Query( $args );
		$featPosts =  Array();
		if ( $loop->have_posts() ) : ?>
			<?php $i = 0 ?>

			<h2 class="h1">Propiedades destacadas</h2>
			<div class="columns">

			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
				<?php
					array_push($featPosts, get_the_ID());
				?>
				<div class="triad-1">
					<?php get_template_part('parts/post','loop') ?>
				</div>
				<?php if(++$i % 3 === 0): ?>
				</div><div class="columns">
				<?php endif; ?>
			<?php endwhile; ?>

			</div>
			<div class="columns">
				<div class="triad-1 prefix-1 suffix-1">
					<a href="<?php echo get_page_url('tpl-featured') ?>" class="button is-primary is-medium is-fullwidth">
						<?php echo _e('Ver Propiedades Destacadas') ?>
					</a>
				</div>
			</div>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</div>
*/  ?>

<div class="container">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<div class="entry">
				<?php the_content(); ?>
			</div>
		</div>
		<?php //comments_template(); ?>
	<?php endwhile; endif; ?>
	<?php
	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		//'category_name'       => 'current',
		//'ignore_sticky_posts' => 1,
		//'paged'               => $paged
		'post__not_in'        => $featPosts
	);
	$loop = new WP_Query( $args );
	if ( $loop->have_posts() ) :
		$i = 0 ?>
		<h2 class="h1 title">Noticias</h2>
		<div class="columns is-same-height">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<div class="column is-one-third">
				<?php get_template_part('parts/blog','loop') ?>
			</div>
			<?php $i++; ?>
			<?php echo ($i % 3 == 0) ? '</div><div class="columns">':'' ?>
		<?php endwhile; ?>
		</div>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
	<?php if (get_option( 'page_for_posts' )): ?>
	<div class="columns is-mobile is-centered">
		<div class="column is-half">
				<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) )  ?>" class="button is-primary is-medium is-fullwidth">
					<?php echo _e('Ver Todas las noticias') ?>
				</a>
		</div>
	</div>
	<?php endif; ?>
</div>
<div class="container">
	<?php
	$args = array(
		//'ignore_sticky_posts' => 1,
		//'paged'               => $paged
		'post_type'      => 'propiedad',
		'posts_per_page' => 12,
		'post__not_in'   => $featPosts
	);
	$loop = new WP_Query( $args );
	if ( $loop->have_posts() ) :
		$i = 0 ?>

		<?php echo sprintf('<h2 class="h1 title">%s</h2>', __('Últimas propiedades sumadas', 'tnb')); ?>

		<div class="columns is-same-height">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<div class="column is-one-third">
				<?php get_template_part('parts/post','loop') ?>
			</div>

			<?php
			$i++;
			echo ($i % 3 == 0) ? '</div><div class="columns">' : ''; ?>
		<?php endwhile; ?>
		</div>

	<?php endif; ?>
	<div class="columns is-mobile is-centered">
		<div class="column is-half">
				<a href="<?php echo get_bloginfo('home').'/?s=' ?>" class="button is-primary is-medium is-fullwidth">
					<?php echo _e('Ver Todas las propiedades') ?>
				</a>
		</div>
	</div>
	<?php //include (TEMPLATEPATH . '/inc/nav.php' ); ?>
	<?php wp_reset_postdata(); ?>
</div>

<?php get_footer(); ?>
