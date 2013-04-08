<?php get_header(); ?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

<section id="banner">
   <div id="banner-title" class="grid_6">
      <h1><?php the_title(); ?></h1>
      <?php if(get_field('subtitle' ) != ""): ?>
         <p><?php the_field('subtitle'); ?></p>
      <?php endif; ?>
   </div>   
   <div class="breadcrumbs"><?php if(function_exists('bcn_display')){bcn_display();}?></div>
</section>
	
<div id="content" <?php post_class('grid_8'); ?> >
   <?php the_content(); ?>
</div>
<?php endwhile; endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>