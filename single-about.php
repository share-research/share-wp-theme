<?php get_header(); ?>
<section id="content" role="main">

  <header class="section-header">
    <div class="container">
      <a href="<?php echo get_bloginfo('url'); ?>/about/about-share/"><h1>Learn more about SHARE</h1></a>
    </div>
  </header>

  <div class="container">
    
    <div id="main-content" class="main-content">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php get_template_part('entry'); ?>
      <?php endwhile; endif; ?>
    </div> <!-- .main-content -->

    <?php get_sidebar(); ?>
    
    <div class="clear"></div>

  </div> <!-- .container -->

</section>
<?php get_footer(); ?>