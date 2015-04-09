<?php get_header(); ?>
<section id="content" role="main">

  <header class="section-header">
    <div class="container">
      <h1 class="entry-title">SHARE News</h1>
    </div>
  </header>
  
  <div class="container">
    
    <div id="main-content" class="main-content">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php get_template_part('entry'); ?>
      <?php endwhile; endif; ?>
      
      <?php get_template_part('nav', 'below'); ?>
    </div>

    <?php get_sidebar(); ?>

  </div> <!-- .container -->

  <div class="clear"></div>
</section> <!-- #content -->

<?php get_footer(); ?>