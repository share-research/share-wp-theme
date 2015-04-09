<section class="entry-content">
  <?php if ( has_post_thumbnail() ) { ?>
  <div class="thumbnail">
    <?php the_post_thumbnail(); ?>
    <div class="caption">
      <?php the_post_thumbnail_caption(); ?>
    </div>
  </div>
  <?php } ?>
<?php the_content(); ?>
<div class="clearfix"></div>
</section>