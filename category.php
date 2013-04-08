<?php get_header(); ?>

<section id="banner">
   <div id="banner-title" class="grid_6">
      <h1><?php single_cat_title(); ?></h1>
      <?php echo category_description(); ?>
   </div>   
   <div class="breadcrumbs"><?php if(function_exists('bcn_display')){bcn_display();}?></div>
</section>

<div id="content" class="grid_8">
   <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <div <?php post_class('p_thumb'); ?> >
         <h2><?php the_title(); ?></h2>
         <div class="meta">
            <span class="categories">
               <?php foreach((get_the_category()) as $category) {
                  if ($category->cat_name != 'Front Page') {
                     echo '<a href="' . get_category_link( $category->term_id ) . '"  ' . '>' . $category->name.'</a>  |  ';
                  }
               } ?>
            </span>
            <span class="comments"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?> | </span>
            <span class="date"><?php the_time('F jS, Y') ?> | </span>
            <span class="author">by <?php the_author_posts_link(); ?> </span>
         </div>		           	
         <?php the_excerpt(); ?>
         <a class="read-more" href="<?php the_permalink(); ?>">Read More</a>
      </div>
   <?php endwhile; endif; wp_reset_query(); ?>
   
   <div class="pagination">
      <?php wp_pagination(); ?>
   </div>
	
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>