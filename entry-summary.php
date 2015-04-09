<section class="entry-summary">
  <div class="thumbnail">
    <?php if ( has_post_thumbnail() ) { the_post_thumbnail('news-thumbnail'); } ?>
  </div>
  <div class="excerpt">
    <?php the_excerpt('...continue reading.'); ?>
  </div>
  <?php if(is_search()) { ?><div class="entry-links"><?php wp_link_pages(); ?></div><?php } ?>
  <div class="clearfix"></div>
</section>