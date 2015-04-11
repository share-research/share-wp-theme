<?php
/*
Plugin Name: SHARE-research.org Plugin
Description: Custom, site specific code and widgets for SHARE-research.org. Contact ian@colorcrate.com with questions.
*/

include_once( ABSPATH . 'wp-content/plugins/advanced-custom-fields-pro/acf.php' );

// =====================================================
//
//  SECTIONAL NAVIGATION WIDGET
//
// ===================================================== 

class display_section_navigation extends WP_Widget {

  function __construct() {
    parent::__construct(
      'display_section_navigation', // Widget base ID
      __('Display Section Navigation', 'display_section_navigation_domain'),  // Widget name in UI
      array( 'description' => __( 'Displays subnavigation tree for the parent section.', 'display_section_navigation_domain' ), ) // Widget description
    );
  }

  // Creating widget front-end
  public function widget( $args, $instance ) {
    global $post; 
    $section = get_post_type($post); // Get the post type (aka 'section')
    $sectionObject =  get_post_type_object($section); // Get the post type object
    $sectionName = $sectionObject->labels->singular_name; // Get the section's name for rendering in markup
    if ($sectionName === 'Page') { // In the case that the parent section is named "Page", give it a better name.
      $sectionName = 'Pages';
    }

    $childpages = wp_list_pages(
      array(
        'authors'      => '',
        'child_of'     => 0,
        'date_format'  => get_option('date_format'),
        'depth'        => 0,
        'echo'         => 1,
        'exclude'      => '',
        'include'      => '',
        'link_after'   => '',
        'link_before'  => '',
        'post_type'    => $section,
        'post_status'  => 'publish',
        'show_date'    => '',
        'sort_column'  => 'menu_order, post_title',
              'sort_order'   => '',
        'title_li'     => __('<h3>' . $sectionName . '</h3>'), 
        'walker'       => ''
    ));

    if ( $childpages ) { // If there are child pages, create a navigation list
      $string = '<ul>' . $childpages . '</ul>';
    }

    // Echo front-end results
    echo __( $string, 'display_section_navigation_domain' );
    // echo $args['after_widget'];
  }
    
  // Widget Backend 
  public function form( $instance ) {
    

  // Widget admin form
?>
<?php 
  }
  
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    return $instance;
  }
} // Class display_section_navigation ends here

// Register and load the widget
function display_section_navigation_load() {
  register_widget( 'display_section_navigation' );
}
add_action( 'widgets_init', 'display_section_navigation_load' );

// =====================================================
//
//  END SECTIONAL NAVIGATION WIDGET
//
// =====================================================






// =====================================================
//
//  RELATED POSTS WIDGET
//
// ===================================================== 

class display_related_posts extends WP_Widget {

  function __construct() {
    parent::__construct(
      'display_related_posts', // Widget base ID
      __('Display Related Posts', 'display_related_posts_domain'),  // Widget name in UI
      array( 'description' => __( 'Displays posts related to a single News item automatically chosen based on tag similarity.', 'display_related_posts_domain' ), ) // Widget description
    );
  }

  // Creating widget front-end
  public function widget( $args, $instance ) {
    if (is_single()) {
      global $post;
      $tags = wp_get_post_tags($post->ID);

      // Post has tags, look for related posts
      if ($tags) {  
        
        $tag_ids = array();  
        
        foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;  
      
        // Construct a wp_query to find related posts by tags
        $args=array(  
        'tag__in' => $tag_ids,  
        'post__not_in' => array($post->ID),  
        'posts_per_page'=> 2, // How many related posts should be displayed?
        'ignore_sticky_posts'=> true
        );
        $my_query = new wp_query( $args );  
        
        $posts = '<li class="pagenav">';
        $posts .= '<h3>Related Posts</h3>';
        $posts .= '<ul class="related-posts">';
        while( $my_query->have_posts() ) {  
          $my_query->the_post();
          $posts .= '<li class="post">';
          $posts .= '<span class="date">' . get_the_date('F j, Y') . '</span>';
          $posts .= '<a class="post-title" href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
          $posts .= '<p class="excerpt">' . excerpt(20) . ' <a href="' . get_the_permalink() . '">... read more.</a></p>';
          $posts .= '</li>';
        }
        $posts .= '</ul>';
        $posts .= '</li>';
        
        wp_reset_query();

        $related_posts = array(
          'has_posts' => true,
          'posts' => $posts,
          'tags' => $tags
        );
      }
      
      // Echo front-end results
      echo __( $related_posts['posts'], 'display_related_posts_domain' );
    }
  }
    
  // Widget Backend 
  public function form( $instance ) {
    

  // Widget admin form
?>
<?php 
  }
  
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    return $instance;
  }
} // Class display_related_posts ends here

// Register and load the widget
function display_related_posts_load() {
  register_widget( 'display_related_posts' );
}
add_action( 'widgets_init', 'display_related_posts_load' );

// =====================================================
//
//  END RELATED POSTS WIDGET
//
// =====================================================




// =====================================================
//
//  KNOWLEDGE BASE NAVIGATION WIDGET
//
// ===================================================== 

class display_knowledge_base_navigation extends WP_Widget {

  function __construct() {
    parent::__construct(
      'display_knowledge_base_navigation', // Widget base ID
      __('Display Knowledge Domain Navigation', 'display_knowledge_base_navigation_domain'),  // Widget name in UI
      array( 'description' => __( 'Displays posts related to a single News item automatically chosen based on tag similarity.', 'display_knowledge_base_navigation_domain' ), ) // Widget description
    );
  }

  // Creating widget front-end
  public function widget( $args, $instance ) {
    if (!is_search()) {
      // Build subnavigation based on the section this knowledge domain is in
      global $post;
      $currentPageID = $post->ID;
      $terms = wp_get_post_terms($post->ID, 'section');

      foreach( $terms as $term ) : 
        
        $return = '<li class="pagenav knowledge-base-items">';
        $return .= '<h3>' . $term->name . '</h3>';
        $return .= '<ul>';

        $posts = new WP_Query( "taxonomy=section&term=$term->slug" );

        if( $posts->have_posts() ): while( $posts->have_posts() ) : $posts->the_post();
            if (get_the_ID() === $currentPageID) { // Mark current item as active
              $return .= '<li class="current_page_item">';
            }
            else {
              $return .= '<li>';
            }
            $return .= '<a href="' . get_the_permalink() . '" title="' . get_the_title() . '" rel="bookmark">' . get_the_title() . '</a>';
            $return .= '</li>';
        endwhile; endif;

        $return .= '<li><a href="' . get_bloginfo('url') . '/kb/" title="SHARE Knowledge Base">&laquo; SHARE Knowledge Base home</a></li>';
        $return .= '</ul>';
        $return .= '</li>';

      endforeach;
    }
    // Sidbar for Knowledge Base search results
    else {
      $return = '<li class="pagenav knowledge-base-items">';
      $return .= '<h3>Knowledge Base</h3>';
      $return .= '<a href="' . get_bloginfo('url') . '/kb/" title="SHARE Knowledge Base">&laquo; SHARE Knowledge Base home</a>';
      $return .= '</li>';
    }

    // Echo front-end results
    echo __( $return, 'display_knowledge_base_navigation_domain' );
  }
    
  // Widget Backend 
  public function form( $instance ) {
    

  // Widget admin form
?>
<?php 
  }
  
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    return $instance;
  }
} // Class display_knowledge_base_navigation ends here

// Register and load the widget
function display_knowledge_base_navigation_load() {
  register_widget( 'display_knowledge_base_navigation' );
}
add_action( 'widgets_init', 'display_knowledge_base_navigation_load' );

// =====================================================
//
//  END KNOWLEDGE BASE NAVIGATION WIDGET
//
// =====================================================





// =====================================================
//
//  CONTACT INFORMATION WIDGET
//
// ===================================================== 

class display_contact_information extends WP_Widget {

  function __construct() {
    parent::__construct(
      'display_contact_information', // Widget base ID
      __('Display Contact Information', 'display_contact_information_domain'),  // Widget name in UI
      array( 'description' => __( 'Displays contact information and social media icons included on the Site-wide Options page.', 'display_contact_information_domain' ), ) // Widget description
    );
  }

  // Creating widget front-end
  public function widget( $args, $instance ) {

    $return = '<li class="social-media">';
    $return .= '<h3>Get In Touch</h3>';
    $return .= '<address>' . get_field('address', 'option') . '</address>';

    // Grab social media links from Site-wide Options page
    if(get_field('social_media_links', 'option')):
      $return .= '<ul class="social">';
      while(has_sub_field('social_media_links', 'option')):
        $return .= '<li><a href="' . get_sub_field('url') . '" target="_blank"><span class="ss-icon ss-' . get_sub_field('icon') . '"></span> ' . get_sub_field('title') . '</a></li>';
      endwhile;
      $return .= '</ul>';
    endif;
    $return .= '</li>';

    // Echo front-end results
    echo __( $return, 'display_contact_information_domain' );
  }
    
  // Widget Backend 
  public function form( $instance ) {
    

  // Widget admin form
?>
<?php 
  }
  
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    return $instance;
  }
} // Class display_contact_information ends here

// Register and load the widget
function display_contact_information_load() {
  register_widget( 'display_contact_information' );
}
add_action( 'widgets_init', 'display_contact_information_load' );

// =====================================================
//
//  END CONTACT INFORMATION WIDGET
//
// =====================================================






// =====================================================
//
//  TWITTER FEED WIDGET
//
// ===================================================== 

class twitter_feed extends WP_Widget {

  function __construct() {
    parent::__construct(
      'twitter_feed', // Widget base ID
      __('@SHARE_research Twitter Feed', 'twitter_feed_domain'),  // Widget name in UI
      array( 'description' => __( 'Displays recent tweets from @SHARE_research in the default Twitter embed.', 'twitter_feed_domain' ), ) // Widget description
    );
  }

  // Creating widget front-end
  public function widget( $args, $instance ) {

    $return = '<li class="widget-container">';
    $return .= '<h3>@SHARE_research</h3>';
    $return .= '<a class="twitter-timeline" href="https://twitter.com/SHARE_research" data-widget-id="568555918565335040">Tweets by @SHARE_research</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
    $return .= '</li>';

    // Echo front-end results
    echo __( $return, 'twitter_feed_domain' );
  }
    
  // Widget Backend 
  public function form( $instance ) {
    

  // Widget admin form
?>
<?php 
  }
  
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    return $instance;
  }
} // Class twitter_feed ends here

// Register and load the widget
function twitter_feed_load() {
  register_widget( 'twitter_feed' );
}
add_action( 'widgets_init', 'twitter_feed_load' );

// =====================================================
//
//  END TWITTER FEED WIDGET
//
// =====================================================

?>