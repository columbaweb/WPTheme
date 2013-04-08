<?php /* Template Name: Services */  ?>

<?php get_header(); ?>

<div id="content">
	<div class="grid_12">
		<?php while ( have_posts() ) : the_post(); ?>
			<div <?php post_class('p_thumb'); ?> >
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>
	</div>
	
	<?php query_posts('post_type=services'); ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="grid_4" id="post-<?php the_ID(); ?>">
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<a class="post-thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
			<?php the_excerpt(); ?>
			<a class="read-more" href="<?php the_permalink(); ?>">Read More</a>
		</div>
		<?php endwhile; endif; ?>


</div>

<?php get_footer(); ?>
