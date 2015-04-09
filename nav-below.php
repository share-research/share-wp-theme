  <?php global $wp_query; if ( $wp_query->max_num_pages > 1 ) { ?>
<nav id="nav-below" class="navigation" role="navigation">
<div class="nav-previous"><?php next_posts_link(sprintf(__( '&lt; Older Posts', 'blankslate' ), '<span class="meta-nav"><</span>' )) ?></div>
<div class="nav-next"><?php previous_posts_link(sprintf(__( 'Newer Posts &gt;', 'blankslate' ), '<span class="meta-nav">></span>' )) ?></div>
</nav>
<?php } ?>