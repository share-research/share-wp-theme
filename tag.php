<?php 
// Bugfix for main navigation not displaying.
// See: https://wordpress.org/support/topic/wp-nav-menu-dissapears-in-category-pages-1
// For some reason, resetting the WP_Query makes the nav
// show up, but since we're on a category page we need
// to do some extra legwork with the new WP_Query to make
// sure everything displays properly.

$wp_query = new WP_Query( array( 'post_type' => 'news' )); // Craft a new query, pretened like we don't have a category
get_header(); // Now get the header which has the nav in it since we've reset the query.
wp_reset_query(); // Now reset the query we just made so the rest of this page will actually work.
// Doesn't that make so much sense?!

?>

<section id="content" role="main">

  <header class="section-header">
    <div class="container">
      <a href="<?php echo get_bloginfo('url'); ?>/news/"><h1>SHARE News</h1></a>
    </div>
  </header>

  <div class="container">
    <div id="main-content" class="main-content">
      <header class="header tag-header">
        <h2 class="entry-title"><?php _e( 'Tag: ', 'blankslate' ); ?><span><?php single_tag_title(); ?></span></h2>
        <hr />
      </header>
  
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <?php get_template_part('entry'); ?>
      <?php endwhile; endif; ?>
      <?php get_template_part('nav', 'below'); ?>
    </div>
    
    <?php get_sidebar(); ?>    
  </div> <!-- .container -->

  <div class="clear"></div>
</section>

<?php 
// We have to do the same nonsense with the footer as with the header
// or else our navigation won't show up here eiter.
$wp_query = new WP_Query( array( 'post_type' => 'news' )); // Craft a new query, pretened like we don't have a category
get_footer(); // Now get the footer which has the nav in it since we've reset the query.
wp_reset_query(); // Now reset the query we just made so the rest of this page will actually work.
?>