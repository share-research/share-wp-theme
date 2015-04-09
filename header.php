<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title><?php wp_title(' | ', true, 'right'); ?></title>
		
		<link href='http://fonts.googleapis.com/css?family=Arvo:400,700,400italic,700italic|Open+Sans:400italic,600italic,800italic,600,800,400' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/fonts/ss-social-circle.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />

		<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/modernizr-2.6.2.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/conditionizr.min.js"></script>

		<!-- Icons -->
		<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo('template_url'); ?>/favicon.ico">
		<link rel="apple-touch-icon" href="<?php bloginfo('template_url'); ?>/img/touch-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php bloginfo('template_url'); ?>/img/touch-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo('template_url'); ?>/img/touch-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php bloginfo('template_url'); ?>/img/touch-icon-152x152.png">

		<!-- Open Graph sharing stuff -->
		

		<?php wp_head(); ?>
	</head>
	
	<body <?php
	global $post;
	$slug = get_post( $post )->post_name;
	body_class($slug);
	?>>

		<a href="#main-content" class="skip" tabindex="0">Skip to main content</a>
		
		<div id="wrapper" class="hfeed grid-container">
		
			<header id="page-header" role="banner">

				<div class="container">
		
					<section id="branding">
						<h1><a class="fill" href="<?php echo esc_url(home_url('/')); ?>" title="<?php esc_attr_e( get_bloginfo('name'), 'blankslate' ); ?>" rel="home"><?php echo esc_html( get_bloginfo('name') ); ?></a></h1>
					</section>
					
					<nav id="main-nav" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
						<a class="handle icon"></a>
						<a class="fill"></a>
					</nav>

				</div> <!-- .container -->
		
			</header> <!-- header#page-header -->