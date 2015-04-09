<?php get_header(); ?>
<section id="content" role="main">

  <header class="section-header">
    <div class="container">
      <h1 class="entry-title">The SHARE Knowledge Base</h1>
    </div>
  </header>

  <div class="container knowledge-base">
    
    <div id="main-content" class="main-content full-width">

      <div class="search">
        <?php get_search_form(true); ?>
      </div>
      
      <?php 
        // Sort posts into sections
        $post_type = 'knowledge-base'; // Only get knowledge-base posts
        $terms = get_terms( 'section' ); // Gets every term within Sections to get the respective posts

        // echo '<pre>';
        // print_r($terms);
        // echo '</pre>';

        foreach( $terms as $term ) : 

          echo '<div class="section">';
          echo '<h2>' . $term->name . '</h2>';
          echo '<ul>';

          $posts = new WP_Query( "taxonomy=section&term=$term->slug" );

          if( $posts->have_posts() ): while( $posts->have_posts() ) : $posts->the_post();
              echo '<li>';
              echo '<a href="' . get_the_permalink() . '" title="' . get_the_title() . '" rel="bookmark">' . get_the_title() . '</a>';
              echo '</li>';
          endwhile; endif;

          echo '</ul>';
          echo '</div> <!-- .section -->';

        endforeach;

      ?>

    </div>

    <?php // get_sidebar(); ?>

  </div> <!-- .container -->

  <div class="clear"></div>
</section> <!-- #content -->

<?php get_footer(); ?>