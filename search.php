<?php get_header(); ?>
<section id="content" role="main">
  
  <header class="section-header">
    <div class="container">
      <a href="<?php bloginfo('url'); ?>/kb/"><h1>The SHARE Knowledge Base</h1></a>
    </div>
  </header>

  <div class="container">

    <div id="main-content" class="main-content">
      <header class="header category-header">
        <h2 class="entry-title"><?php printf( __( 'Search Results for: %s', 'blankslate' ), get_search_query() ); ?></h2>
        <hr />
      </header>

      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <?php get_template_part('entry'); ?>
      <?php endwhile; 
            else : 
            _e( 'Sorry, nothing matched your search. Please go back and try again.', 'blankslate' );
            endif; ?>
      <?php get_template_part('nav', 'below'); ?>
    </div> <!-- .main-content -->
    
    <?php get_sidebar(); ?>
  </div> <!-- .container -->
  
  <div class="clearfix"></div>
</section>
<?php get_footer(); ?>