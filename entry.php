<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<header>
<?php 
  // Entry meta
  if (is_singular('post') || is_home() || is_archive() && get_post_type() != 'kb') {
    get_template_part('entry', 'meta');
  }

  // Headline
  if ( is_singular() && get_post_type() != 'page') {
    echo '<h2 class="entry-title">';
    echo get_the_title();
    echo '</h2>';
  } elseif (get_post_type() === 'page') {
    // Do nothing!
  } else {
    echo '<h2 class="entry-title">';
    echo '<a href="' . get_the_permalink() . '" title="' . get_the_title() . '" rel="bookmark">' . get_the_title() . '</a>';
    echo '</h2>';
  } ?>
</header>
<?php get_template_part('entry', (is_home() || is_archive() || is_search() ? 'summary' : 'content')); ?>
<?php if (!is_search()) get_template_part('entry-footer'); ?>
</article>