<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <div>
    <label class="screen-reader-text" for="s"><?php _x( 'Search for:', 'label' ); ?></label>
    <input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="Search the Knowledge Base" />
    <?php if (get_post_type() === 'kb') { ?><input type="hidden" name="post_type" value="kb" /><?php } ?>
    <input type="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" />
    <div class="clearfix"></div>
  </div>
</form>