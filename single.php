<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<section id="banner">
   <div id="banner-title" class="grid_6">
      <h1><?php the_title(); ?></h1>
      <?php if(get_field('subtitle' ) != ""): ?>
         <p><?php the_field('subtitle'); ?></p>
      <?php endif; ?>
   </div>   
   <div class="breadcrumbs"><?php if(function_exists('bcn_display')){bcn_display();}?></div>
</section>

<div id="content" class="grid_8">
   <div <?php post_class('p_thumb'); ?> >
      <?php the_content(''); ?>
   </div>
   <?php if(comments_open()): ?>
      <section id="comments">
         <?php comments_template(); ?>
      </section>
   <?php endif; ?>
   <?php endwhile; else: ?>
      <p>Sorry, no posts matched your criteria.</p>
   <?php endif; ?>
   <div class="p_nav">
      <div class="alignright"><?php next_post_link('%link', 'Next &raquo;', TRUE, '3'); ?></div>
      <div class="alignleft"><?php previous_post_link('%link', '&laquo; Previous', TRUE, '3'); ?> </div>
   </div>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>