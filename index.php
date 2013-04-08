<?php get_header(); ?>

<div id="content">
   <div id="slider" class="grid_12">
      <?php echo get_new_royalslider(1); ?>
   </div>
   
   <div id="promo-box">  
      <?php query_posts('post_type=promo&posts_per_page=1'); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	   <div class="grid_12">
	      <?php the_content(); ?>
	      <a href="contact">Contact Us</a>
	   </div>
	<?php endwhile; endif; wp_reset_query(); ?>
   </div>

   <section id="services">
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Services') ) : ?><?php endif; ?>
   </section>

   <section id="events" class="grid_12">
      <h2>Events</h2>
      
   </section>
	
   <div class="grid_8">
      <h2>Blog</h2>
      <?php query_posts('category_name=blog&posts_per_page=2'); ?>
         <?php while (have_posts()) : the_post(); ?>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <div class="meta">
               <span class="date"><?php the_time('F jS, Y') ?> | </span>
               <span class="author"><?php the_author_posts_link(); ?> | </span>
               <span class="categories">
                  <?php foreach((get_the_category()) as $category) {
                     if ($category->cat_name != 'Front Page') {
                        echo '<a href="' . get_category_link( $category->term_id ) . '"  ' . '>' . $category->name.'</a>   ';
		      }
                  } ?>
               </span>
            </div>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>      
            <?php the_excerpt(); ?>
         <?php endwhile;?>
   </div>

   <div class="grid_4">
      <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Case Studies') ) : ?><?php endif; ?>
   </div>
</div>

<?php get_footer(); ?>