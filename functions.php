<?php

@define( 'PARENT_DIR', get_template_directory() );
require_once (PARENT_DIR . '/shortcodes.php');

// Saftey first
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'functions.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly!');

// Add Scripts
function add_my_scripts() {
   wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', array(), '2.6.2', false );
}
add_action('wp_enqueue_scripts', 'add_my_scripts');

// Clean up the <head>
function removeHeadLinks()
{
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'wp_generator');
}
add_action('init', 'removeHeadLinks');

// Add ?v=[last modified time] to style sheets
function versioned_stylesheet($relative_url, $add_attributes=""){
	echo '<link rel="stylesheet" href="'.versioned_resource($relative_url).'" '.$add_attributes.'>'."\n";
}

// Adds excerpts for pages
add_post_type_support( 'page', 'excerpt' );

// Enable Shortcodes in excerpts and widgets
add_filter('widget_text', 'do_shortcode');
add_filter( 'the_excerpt', 'do_shortcode');
add_filter('get_the_excerpt', 'do_shortcode');

// Enable PHP in widgets
add_filter('widget_text','execute_php',100);
function execute_php($html){
     if(strpos($html,"<"."?php")!==false){
          ob_start();
          eval("?".">".$html);
          $html=ob_get_contents();
          ob_end_clean();
     }
     return $html;
}

// Register Menus
if (function_exists( 'add_theme_support' ))
{
	add_theme_support('post-thumbnails', array( 'post', 'page', services ) );
	add_theme_support('menus');
	add_theme_support('automatic-feed-links');
	register_nav_menus(
  		array(
  		  'topnav' => 'Top Menu',
  		  'sidenav' => 'Sidebar Menu',
		  'footnav' => 'Footer Menu'
  		)
  	);
}

// Register Sidebars
if ( function_exists('register_sidebar') )
	register_sidebar(array('name' => 'Header','before_widget' => '<div class="widget">','after_widget' => '</div>',));
    register_sidebar(array('name' => 'Sidebar','before_widget' => '<div class="widget">','after_widget' => '</div>',));
    register_sidebar(array('name' => 'Footer 1','before_widget' => '<div class="widget">','after_widget' => '</div>',));
    register_sidebar(array('name' => 'Footer 2','before_widget' => '<div class="widget">','after_widget' => '</div>',));
    register_sidebar(array('name' => 'Footer 3','before_widget' => '<div class="widget">','after_widget' => '</div>',));

// Register Custom Post Types - Services
register_post_type('services', array(
'label' => 'Services',
'public' => true,
'show_ui' => true,
'capability_type' => 'post',
'hierarchical' => true,
'rewrite' => array('slug' => 'services'),
'query_var' => true,
'supports' => array('title', 'editor', 'excerpt', 'thumbnail')
) );

// Puts link in excerpts more tag
function new_excerpt_more($more) {
	global $post;
	return '<a class="moretag" href="'. get_permalink($post->ID) . '">Read More</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

// Custom Excerpt Lenght
function new_excerpt_length($length) {
	return 100;
}
add_filter('excerpt_length', 'new_excerpt_length');

// Limit Post Title
function shortened_title() {
$original_title = get_the_title();
$title = html_entity_decode($original_title, ENT_QUOTES, "UTF-8");
// Set Limit
$limit = "55";
// Set End Text
$ending="...";
if(strlen($title) >= ($limit+3)) {
$title = substr($title, 0, $limit) . $ending; }
echo $title;
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Displays the comment authors gravatar if available
function dp_gravatar($size=50, $attributes='', $author_email='') {
global $comment, $settings;
if (dp_settings('gravatar')=='enabled') {
if (empty($author_email)) {
ob_start();
comment_author_email();
$author_email = ob_get_clean();
}
$gravatar_url = 'http://www.gravatar.com/avatar/' . md5(strtolower($author_email)) . '?s=' . $size . '&amp;d=' . dp_settings('gravatar_fallback');
?><img src="<?php echo $gravatar_url; ?>" <?php echo $attributes ?>/><?php
}
}

if (!function_exists('get_image_path'))  {
function get_image_path() {
	global $post;
	$id = get_post_thumbnail_id();
	// check to see if NextGen Gallery is present
	if(stripos($id,'ngg-') !== false && class_exists('nggdb')){
	$nggImage = nggdb::find_image(str_replace('ngg-','',$id));
	$thumbnail = array(
	$nggImage->imageURL,
	$nggImage->width,
	$nggImage->height
	);
	// otherwise, just get the wp thumbnail
	} else {
	$thumbnail = wp_get_attachment_image_src($id,'full', true);
	}
	$theimage = $thumbnail[0];
	return $theimage;
}
}

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );


// MISC
remove_filter('term_description','wpautop');

class WPMUDEV_Update_Notifications {}


?>