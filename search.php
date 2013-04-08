<?php get_header(); ?>

<div id="content" class="grid_8">
     <h1>Search Results for: <?php the_search_query(); ?></h1>
     <?php if (have_posts()) : ?>
          <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	     <div <?php post_class('p_thumb'); ?> >
	          <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
		  <?php the_excerpt('read more'); ?>
	     </div>
          <?php endwhile; endif; ?>

          <div class="navigation">
               <div><?php next_posts_link('&laquo; Older Entries') ?></div>
               <div><?php previous_posts_link('Newer Entries &raquo;') ?></div>
          </div>
     <?php else : ?>
          <h2>No posts found. Try a different search?</h2>
          <?php include (TEMPLATEPATH . '/searchform.php'); ?>
     <?php endif; ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>