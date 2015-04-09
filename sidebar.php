<aside id="sidebar" role="complementary">
  <div id="primary" class="widget-area">
    <ul class="xoxo">
    <?php 
      // News sidebar
      if (is_home() || is_singular('post') || is_archive() && get_post_type() != 'kb' && !is_search()) {
        dynamic_sidebar('news-sidebar');
      }
      // Knowledge Base sidebar
      else if (get_post_type() === 'kb' || is_search()) {
        dynamic_sidebar('kb-sidebar');
      }
      // Contact sidebar
      else if (get_post_type() === 'contact') {
        dynamic_sidebar('contact-sidebar');
      }
      else if (get_post_type() === 'about') {
        dynamic_sidebar('about-share-sidebar');
      }
    ?>

    </ul>
  </div>
</aside>