<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-touch-icon.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
            <meta name="theme-color" content="#121212">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>
		<style>
		body{
		color:<?php echo top_text_color(); ?>;
	   }
		a, a:visited {
    color:<?php echo top_link_color(); ?>;
	  }

		a:hover, a:focus, a:visited:hover, a:visited:focus {
    color: <?php echo top_link_color(); ?>;
    }

   nav > ul > li > a{
		 color:<?php echo top_text_color(); ?> !important;
		 text-decoration: none;
	 }

	 nav > ul > li > a:hover{
		 color:<?php echo top_text_color(); ?> !important;
		 text-decoration: none;
	 }
</style>

<?php if ( is_front_page() && is_home() ) :?>

<?php elseif ( is_front_page() ) :?>

<?php elseif ( is_home() ) :?>
<style>
.hero.is-large .hero-body {
	padding-bottom: 2rem;
  padding-top: 7rem;
 }
 .topmain_img{
	 border-bottom-right-radius: 45% 20%;
    border-bottom-left-radius: 45% 20%;
 background-position: center center;
}
</style>
<?php elseif(is_page()) :?>
<style>
.hero.is-large .hero-body {
	padding-bottom: 2rem;
  padding-top: 7rem;
 }
 .topmain_img{
	 border-bottom-right-radius: 45% 20%;
    border-bottom-left-radius: 45% 20%;
 background-position: center center;
}
</style>
<?php else :?>
<style>
.hero.is-large .hero-body {
	padding-bottom: 2rem;
	padding-top: 7rem;
 }
 .topmain_img{
	 border-bottom-right-radius: 45% 20%;
		border-bottom-left-radius: 45% 20%;
 background-position: center center;
}
</style>
<?php endif ?>

	</head>
	<?php
	global $section1;
	global $section2;
	global $section3;
	global $section4;
	global $section5;
	global $blogcount;
	$section1 = get_option('theme_setion1check');
	$section2 = get_option('theme_setion2check');
	$section3 = get_option('theme_setion3check');
	$section4 = get_option('theme_setion4check');
	$section5 = get_option('theme_setion5check');
	$blogcount = get_option('theme_blogcount');
	?>

	<body style="background:#<?php echo top_background_color(); ?>;" itemscope itemtype="http://schema.org/WebPage">

		<section class="hero is-info is-large topmain_img animated" style="background-image:url(<?php if (get_the_logo_image_url()): ?><?php echo get_the_logo_image_url(); ?>)<?php else : ?>aa<?php endif; ?>;">
  <div class="hero-body over">
    <div class="container">
      <h1 class="title has-text-centered">
				<?php // to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> ?>
				<p id="logo" itemscope itemtype="http://schema.org/Organization"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php bloginfo('name'); ?></a></p>
      </h1>
      <h2 class="subtitle has-text-centered">
				<?php // if you'd like to use the site description you can un-comment it below ?>
				<?php echo bloginfo('description'); ?>
      </h2>
    </div>
  </div>
</section>

		<div id="container">
			<header id="top-head">
			  <div class="inner">
			    <div id="mobile-head">
			      <h1 class="logo"></h1>
			      <div id="nav-toggle">
			          <div>
			              <span></span>
			              <span></span>
			              <span></span>
			          </div>
			      </div>
			    </div><!---mobile-head end -->

          <nav id="global-nav" role="navigation">
            <?php
              wp_nav_menu(
                array(
                  'menu' => __( 'The Main Menu', 'facetheme' ),
                  'menu_class'      => 'clearfix',
                  'menu_id'         => 'gnav-ul',
                  'container'       => 'div',
                  'container_id'    => 'gnav-container',
                  'container_class' => 'gnav-container'
                )
              );?>
          </nav>

			  </div><!---inner end------>
			</header>
