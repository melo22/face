<?php
/**
 * Template Name: フロントページ
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 */

?>

 <?php get_header(); ?>
<?php
if ( $section1 == 'checked') : ?>
 <div class="container is-fluid section1 animated">
  <div class="notification">

    <div class="tile columns">
      <div class="tile column is-one-third animated">
        <div class="tile is-parent is-vertical sec_Left_title">
           <article class="tile is-child notification">
          <p class="title has-text-centered" <?php echo top_title_color(); ?>><?php echo get_option('theme_setion1title');?></p>
          <p class="subtitle has-text-centered"><?php echo get_option('theme_setion1text');?></p>
        </article>
        </div>

      </div>
      <div class="tile column">
        <div class="tile is-parent is-vertical sec_Center_title animated">
          <article class="tile is-child notification">
         <p class="title has-text-centered" <?php echo top_title_color(); ?>><?php echo get_option('theme_setion1title2');?></p>
         <p class="subtitle has-text-centered"><?php echo get_option('theme_setion1text2');?></p>
       </article>
        </div>
      </div>

      <div class="tile column">
        <div class="tile is-parent is-vertical sec_Right_title animated">
          <article class="tile is-child notification">
         <p class="title has-text-centered" <?php echo top_title_color(); ?>><?php echo get_option('theme_setion1title3');?></p>
         <p class="subtitle has-text-centered">  <?php echo get_option('theme_setion1text3');?></p>
       </article>
      </div>
    </div>

  </div>


</div>
</div>
<?php else : ?>
<?php endif; ?>

<?php if ( $section2 == 'checked') : ?>
<section class="hero is-large section2 has-text-centered" <?php echo background_color2();?>>
  <div class="hero-body">
    <div class="container animated">
      <div class="title is-2 is-spaced" <?php echo top_title_color(); ?>>
        <?php echo get_option('theme_setion2title');?>
      </div>
      <div class="subtitle is-4 animetext">
        <?php echo get_option('theme_setion2text');?>
      </div>
    </div>
  </div>
</section>
<?php else : ?>
<?php endif; ?>

<?php if ( $section3 == 'checked') : ?>
<section class="hero is-large section3 has-text-centered" <?php echo background_color3();?>>
  <div class="hero-body">
    <div class="container animated">
      <div class="title is-2 is-spaced" <?php echo top_title_color(); ?>>
        <?php echo get_option('theme_setion3title');?>
      </div>
      <div class="subtitle is-4 animetext">
        <?php echo get_option('theme_setion3text');?>
      </div>
    </div>
  </div>
</section>
<?php else : ?>
<?php endif; ?>

<?php if ( $section4 == 'checked') : ?>
<section class="hero is-large section4 has-text-centered" <?php echo background_color4();?>>
  <div class="hero-body">
    <div class="container animated">
      <div class="title is-2 is-spaced" <?php echo top_title_color(); ?>>
        <?php echo get_option('theme_setion4title');?>
      </div>
      <div class="subtitle is-4 animetext">
        <?php echo get_option('theme_setion4text');?>
      </div>
    </div>
  </div>
</section>
<?php else : ?>
<?php endif; ?>

<?php if ( $section5 == 'checked') : ?>
<div class="container" itemtype="http://schema.org/Blog">
  <h2 class="title is-2 is-spaced has-text-centered animated" <?php echo top_title_color(); ?>>News</h2>
  <div class="columns is-multiline blog_section">
  <?php $paged = (int) get_query_var('paged');
      $args = array(
      	'posts_per_page' => $blogcount,
      	'paged' => $paged,
      	'orderby' => 'post_date',
      	'order' => 'DESC',
      	'post_type' => 'post',
      	'post_status' => 'publish'
      );
    $the_query = new WP_Query($args); ?>
  <?php  if ( $the_query->have_posts() ) :
  	while ( $the_query->have_posts() ) : $the_query->the_post();
  ?>
  <div class="column is-one-third animated">
     <article class="tile is-child box" <?php echo top_blog_backgroundcolor();?>>
     <!-- <div class="tile is-child box"> -->
      <a href="<?php the_permalink();?>"><h1 class="title"><?php the_title(); ?></h1></a>
      		<?php the_excerpt(); ?>
    </article>
    </div>
    <!-- </div> -->
  <?php endwhile; ?>
  <?php else: ?>
  <?php endif; ?>
<?php else : ?>
<?php endif; ?>


</div>
</div>












 <?php get_footer(); ?>
