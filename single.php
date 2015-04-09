<?php get_header(); ?>
<section id="content" role="main">

  <header class="section-header">
    <div class="container">
      <a href="<?php echo get_bloginfo('url'); ?>/news/"><h1>SHARE News</h1></a>
    </div>
  </header>
  
  <div class="container">
    
    <div id="main-content" class="main-content">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php get_template_part('entry'); ?>
      <?php endwhile; endif; ?>
      <footer class="post-footer">
        <div class="metadata">
          <span class="byline">By</span>
          <?php the_field('author_name'); ?><br />
          <?php if (get_field('phone_number')) { the_field('phone_number'); } echo '<br />'; ?>
          <?php if (get_field('email_address')) { echo '<a href="mailto:' . get_field('email_address') . '">' . get_field('email_address') . '</a>'; } echo '<br />'; ?>
        </div>
        <div class="tags">
          <span class="tag-title">
            Tags
          </span>
          <?php echo get_the_tag_list('',', ',''); ?>
        </div>
      </footer>
      <div class="clearfix"></div>
    </div> <!-- .main-content -->

    <?php get_sidebar(); ?>

  </div> <!-- .container -->

</section>

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4ed2944f1c6caccb" async="async"></script>

<?php get_footer(); ?>