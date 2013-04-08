<!DOCTYPE html>

<!--[if lt IE 7 ]> <html class="ie ie6 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]>  <html class="no-js" <?php language_attributes(); ?>> <![endif]-->

<html lang="en-GB" class="no-js">
<head>
<title><?php wp_title(); ?></title>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css' />

<?php wp_enqueue_script('jquery');?>
<?php wp_head(); ?>

</head> 

<body <?php body_class(); ?>>
   <div id="wrapper" class="container_12">   	
      <header> 
         <div id="logo" class="grid_4">
			<h1><?php bloginfo('name'); ?></h1>
			<a href="<?php echo home_url(); ?>" ><img src="<?php bloginfo( 'template_url' ); ?>/images/logo.png" width="150" height="" alt="<?php bloginfo('name'); ?>" /></a>
			</div>
		<div class="grid_8 omega">
            <?php include ('searchform.php'); ?>
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Header') ) : ?><?php endif; ?>
         </div>
         <?php wp_nav_menu( array( 'theme_location' => 'topnav' ) ); ?>
      </header>
		
		