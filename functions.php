<?php
add_action('after_setup_theme', 'blankslate_setup');
function blankslate_setup() {
	load_theme_textdomain('blankslate', get_template_directory() . '/languages');
	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails');
	add_image_size('large', 589, '', true); // Large Thumbnail
	add_image_size('medium', 440, '', true); // Medium Thumbnail
	add_image_size('small', 120, '', true); // Small Thumbnail
	add_image_size('news-thumbnail', 230, 170, true); // News thumbnail

	global $content_width;
	if ( ! isset( $content_width ) ) $content_width = 640;
	register_nav_menus(array( // Using array to specify more menus if needed
		'header-menu' => __('Header Menu', 'blankslate'), // Main Navigation
		'footer-menu' => __('Footer Menu', 'blankslate'), // Extra Navigation if needed (duplicate as many as you need!)
		'sub-footer-menu' => __('Sub-footer Menu', 'blankslate')
	));
}
add_action('wp_enqueue_scripts', 'blankslate_load_scripts');
function blankslate_load_scripts() {
	wp_enqueue_script('jquery');
}
add_action('comment_form_before', 'blankslate_enqueue_comment_reply_script');
function blankslate_enqueue_comment_reply_script() {
	if (get_option('thread_comments')) { wp_enqueue_script('comment-reply'); }
}
add_filter('the_title', 'blankslate_title');
function blankslate_title($title) {
	if ($title == '') {
		return '&rarr;';
	} else {
		return $title;
	}
}
add_filter('wp_title', 'blankslate_filter_wp_title');
function blankslate_filter_wp_title($title) {
	return $title . esc_attr(get_bloginfo('name'));
}
add_action('widgets_init', 'blankslate_widgets_init');
function blankslate_widgets_init() {
	// Default sidebar
	register_sidebar( array (
		'name' => __('About SHARE sidebar', 'blankslate'),
		'id' => 'about-share-sidebar',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array (
		'name' => __('Projects sidebar', 'blankslate'),
		'id' => 'projects-sidebar',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array (
		'name' => __('News sidebar', 'blankslate'),
		'id' => 'news-sidebar',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array (
		'name' => __('Knowledge Base sidebar', 'blankslate'),
		'id' => 'kb-sidebar',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array (
		'name' => __('Contact sidebar', 'blankslate'),
		'id' => 'knowledge-base-sidebar',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
function blankslate_custom_pings($comment) {
	$GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
<?php 
}
add_filter('get_comments_number', 'blankslate_comments_number');
function blankslate_comments_number($count) {
	if (!is_admin()) {
	global $id;
	$comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
	return count($comments_by_type['comment']);
} else {
	return $count;
}
}


// ======================================================
//
//	SHARE SPECIFIC STUFF
//
// ======================================================

// Prettier excerpts
function new_excerpt_more( $more ) {
	return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . __('...continue reading.', 'your-text-domain') . '</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );
// Custom excerpt length
function custom_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


// ------------------------------------------------------
// Custom Post Type Creation
// ------------------------------------------------------

// About SHARE
add_action('init', 'about_share_custom_posts');
function about_share_custom_posts()
{
	register_post_type('about', // Register Custom Post Type
		array(
		'labels' => array(
			'name' => __('About SHARE', 'about-share'), // Rename these to suit
			'singular_name' => __('About SHARE', 'about-share'),
			'add_new' => __('Add New', 'about-share'),
			'add_new_item' => __('Add New Page', 'about-share'),
			'edit' => __('Edit', 'about-share'),
			'edit_item' => __('Edit Page', 'about-share'),
			'new_item' => __('New Page', 'about-share'),
			'view' => __('View Page', 'about-share'),
			'view_item' => __('View Page', 'about-share'),
			'search_items' => __('Search Pages', 'about-share'),
			'not_found' => __('No pages found', 'about-share'),
			'not_found_in_trash' => __('No pages found in Trash', 'about-share')
		),
		'public' => true,
		'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
		'has_archive' => true,
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'excerpt',
			'revisions',
			'page-attributes'
		), // Go to Dashboard Custom HTML5 Blank post for supports
		'can_export' => true, // Allows export in Tools > Export
	));
}

// Projects
add_action('init', 'projects_custom_posts');
function projects_custom_posts()
{
	register_post_type('projects', // Register Custom Post Type
		array(
		'labels' => array(
			'name' => __('Projects', 'projects'), // Rename these to suit
			'singular_name' => __('Projects', 'projects'),
			'add_new' => __('Add New', 'projects'),
			'add_new_item' => __('Add New Page', 'projects'),
			'edit' => __('Edit', 'projects'),
			'edit_item' => __('Edit Page', 'projects'),
			'new_item' => __('New Page', 'projects'),
			'view' => __('View Page', 'projects'),
			'view_item' => __('View Page', 'projects'),
			'search_items' => __('Search Pages', 'projects'),
			'not_found' => __('No pages found', 'projects'),
			'not_found_in_trash' => __('No pages found in Trash', 'projects')
		),
		'public' => true,
		'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
		'has_archive' => true,
		'capability_type' => 'page',
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'excerpt',
			'revisions',
			'page-attributes'
		), // Go to Dashboard Custom HTML5 Blank post for supports
		'can_export' => true, // Allows export in Tools > Export
	));
}

// News & Updates
// REMOVED 2015.03.16 at EFC's request
// add_action('init', 'news_custom_posts'); // Add our HTML5 Blank Custom Post Type
// function news_custom_posts()
// {
// 	// register_taxonomy_for_object_type('category', 'spotlight'); // Register Taxonomies for Category
// 	// register_taxonomy_for_object_type('post_tag', 'spotlight');
// 	register_post_type('news', // Register Custom Post Type
// 		array(
// 		'labels' => array(
// 			'name' => __('News', 'news'), // Rename these to suit
// 			'singular_name' => __('News', 'news'),
// 			'add_new' => __('Add New', 'news'),
// 			'add_new_item' => __('Add New Post', 'news'),
// 			'edit' => __('Edit', 'news'),
// 			'edit_item' => __('Edit Post', 'news'),
// 			'new_item' => __('New Post', 'news'),
// 			'view' => __('View Post', 'news'),
// 			'view_item' => __('View Post', 'news'),
// 			'search_items' => __('Search Posts', 'news'),
// 			'not_found' => __('No posts found', 'news'),
// 			'not_found_in_trash' => __('No posts found in Trash', 'news')
// 		),
// 		'public' => true,
// 		'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
// 		'has_archive' => true,
// 		'supports' => array(
// 			'title',
// 			'editor',
// 			'excerpt',
// 			'thumbnail',
// 			'excerpt',
// 			'revisions',
// 			'comments',
// 		), // Go to Dashboard Custom HTML5 Blank post for supports
// 		'can_export' => true, // Allows export in Tools > Export
// 		'taxonomies' => array(
//  			'post_tag',
//  			'category'
//  		) // Add Category and Post Tags support
// 	));
// 	// flush_rewrite_rules();
// }
// // Include News custom post types in category pages
// add_filter('pre_get_posts', 'news_query_post_type');
// function news_query_post_type($query) {
//   if(is_category() || is_tag()) {
//     $post_type = get_query_var('post_type');
// 	if($post_type)
// 	    $post_type = $post_type;
// 	else
// 	    $post_type = array('post','news');
//     $query->set('post_type',$post_type);
// 	return $query;
//     }
// }

// Knowledge Base
// CHANGED TO 'kb' on 2015.03.16 at EFC's request
// add_action('init', 'knowledge_base_custom_posts');
// function knowledge_base_custom_posts()
// {
// 	register_post_type('knowledge-base', // Register Custom Post Type
// 		array(
// 		'labels' => array(
// 			'name' => __('Knowledge Base', 'knowledge-base'), // Rename these to suit
// 			'singular_name' => __('Knowledge Base', 'knowledge-base'),
// 			'add_new' => __('Add New', 'knowledge-base'),
// 			'add_new_item' => __('Add New Page', 'knowledge-base'),
// 			'edit' => __('Edit', 'knowledge-base'),
// 			'edit_item' => __('Edit Page', 'knowledge-base'),
// 			'new_item' => __('New Page', 'knowledge-base'),
// 			'view' => __('View Page', 'knowledge-base'),
// 			'view_item' => __('View Page', 'knowledge-base'),
// 			'search_items' => __('Search Pages', 'knowledge-base'),
// 			'not_found' => __('No pages found', 'knowledge-base'),
// 			'not_found_in_trash' => __('No pages found in Trash', 'knowledge-base')
// 		),
// 		'public' => true,
// 		'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
// 		'has_archive' => true,
// 		'supports' => array(
// 			'title',
// 			'editor',
// 			'excerpt',
// 			'thumbnail',
// 			'excerpt',
// 			'revisions',
// 			'page-attributes'
// 		), // Go to Dashboard Custom HTML5 Blank post for supports
// 		'can_export' => true, // Allows export in Tools > Export
// 	));
// }

// Knowledge Base
add_action('init', 'kb_custom_post_type');
function kb_custom_post_type()
{
	register_post_type('kb', // Register Custom Post Type
		array(
		'labels' => array(
			'name' => __('Knowledge Base', 'kb'), // Rename these to suit
			'singular_name' => __('Knowledge Base', 'kb'),
			'add_new' => __('Add New', 'kb'),
			'add_new_item' => __('Add New Page', 'kb'),
			'edit' => __('Edit', 'kb'),
			'edit_item' => __('Edit Page', 'kb'),
			'new_item' => __('New Page', 'kb'),
			'view' => __('View Page', 'kb'),
			'view_item' => __('View Page', 'kb'),
			'search_items' => __('Search Pages', 'kb'),
			'not_found' => __('No pages found', 'kb'),
			'not_found_in_trash' => __('No pages found in Trash', 'kb')
		),
		'public' => true,
		'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
		'has_archive' => true,
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'excerpt',
			'revisions',
			'page-attributes'
		), // Go to Dashboard Custom HTML5 Blank post for supports
		'can_export' => true, // Allows export in Tools > Export
	));
	// flush_rewrite_rules();
}

// Contact
add_action('init', 'contact_custom_posts');
function contact_custom_posts()
{
	register_post_type('contact', // Register Custom Post Type
		array(
		'labels' => array(
			'name' => __('Contact', 'contact'), // Rename these to suit
			'singular_name' => __('Contact', 'contact'),
			'add_new' => __('Add New', 'contact'),
			'add_new_item' => __('Add New Page', 'contact'),
			'edit' => __('Edit', 'contact'),
			'edit_item' => __('Edit Page', 'contact'),
			'new_item' => __('New Page', 'contact'),
			'view' => __('View Page', 'contact'),
			'view_item' => __('View Page', 'contact'),
			'search_items' => __('Search Pages', 'contact'),
			'not_found' => __('No pages found', 'contact'),
			'not_found_in_trash' => __('No pages found in Trash', 'contact')
		),
		'public' => true,
		'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
		'has_archive' => true,
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'excerpt',
			'revisions',
			'page-attributes'
		), // Go to Dashboard Custom HTML5 Blank post for supports
		'can_export' => true, // Allows export in Tools > Export
	));
	// flush_rewrite_rules();
}

// ------------------------------------------------------
// Function to echo list of sectional pages 
// ------------------------------------------------------
function list_section_navigation() { 
	global $post; 
	$section = get_post_type($post);
	$sectionObject =  get_post_type_object($section);
	$sectionName = $sectionObject->labels->singular_name;
	if ($sectionName === 'Page') {
		$sectionName = 'Pages'; // Make this headline make more sense
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

	if ( $childpages ) {
		$string = '<ul>' . $childpages . '</ul>';
	}
	return $string;
}
add_shortcode('wpb_childpages', 'list_section_navigation');


// ------------------------------------------------------
// Knowledge Base custom taxonomy
// ------------------------------------------------------

function kb_custom_taxonomy_init() {
  // Add new "Locations" taxonomy to Posts
  register_taxonomy('section', 'kb', array(
    // Hierarchical taxonomy (like categories)
    'hierarchical' => true,
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name' => _x( 'Sections', 'taxonomy general name' ),
      'singular_name' => _x( 'Section', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Sections' ),
      'all_items' => __( 'All Sections' ),
      'parent_item' => __( 'Parent Section' ),
      'parent_item_colon' => __( 'Parent Section:' ),
      'edit_item' => __( 'Edit Section' ),
      'update_item' => __( 'Update Section' ),
      'add_new_item' => __( 'Add New Section' ),
      'new_item_name' => __( 'New Section Name' ),
      'menu_name' => __( 'Sections' ),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'section', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/locations/"
      'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
    ),
  ));
}
add_action( 'init', 'kb_custom_taxonomy_init', 0 );


// ------------------------------------------------------
// Create "Site-wide Options" options page
// ------------------------------------------------------
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Site-wide Options',
		'menu_title'	=> 'Site-wide Options',
		'menu_slug' 	=> 'site-wide-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));	
}

// ------------------------------------------------------
// Echo post thumbnail
// ------------------------------------------------------
function the_post_thumbnail_caption() {
  global $post;

  $thumbnail_id    = get_post_thumbnail_id($post->ID);
  $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

  if ($thumbnail_image && isset($thumbnail_image[0])) {
    echo '<span>'.$thumbnail_image[0]->post_excerpt.'</span>';
  }
}

// ------------------------------------------------------
// Allow Jetpack's Related Posts to use News posts
// ------------------------------------------------------
function allow_my_post_types($allowed_post_types) {
    $allowed_post_types[] = 'news';
    return $allowed_post_types;
}
add_filter( 'rest_api_allowed_post_types', 'allow_my_post_types' );


// ------------------------------------------------------
// User SHARE logo for og-image if no featured image is
// present, or featured image is too small.
// ------------------------------------------------------
function jeherve_custom_image( $media, $post_id, $args ) {
    if ( $media ) {
        return $media;
    } else {
        $permalink = get_permalink( $post_id );
        $url = apply_filters( 'jetpack_photon_url', get_bloginfo('template_url') . '/img/og-logo-200x200.png' );
     
        return array( array(
            'type'  => 'image',
            'from'  => 'custom_fallback',
            'src'   => esc_url( $url ),
            'href'  => $permalink,
        ) );
    }
}
add_filter( 'jetpack_images_get_images', 'jeherve_custom_image', 10, 3 );


// ------------------------------------------------------
// Change Jetpack's twitter card to SHARE's twitter handle
// ------------------------------------------------------
function tweakjp_custom_twitter_site( $og_tags ) {
	$og_tags['twitter:site'] = '@SHARE_research';
	return $og_tags;
}
add_filter( 'jetpack_open_graph_tags', 'tweakjp_custom_twitter_site', 11 );

// ------------------------------------------------------
// Get excerpts of a custom length
// ------------------------------------------------------
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt);
  } else {
    $excerpt = implode(" ",$excerpt);
  } 
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}

function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content);
  } else {
    $content = implode(" ",$content);
  } 
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}