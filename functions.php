<?php
  // Menus
register_nav_menus( array(
  'main_menu' => 'Main Menu',
));
  // Sidebar
register_sidebar( array(
  'name' => __( 'Sidebar' ),
  'before_widget' => '<div class="widget">',
  'after_widget' => '</div>',
  'before_title' => '<h3>',
  'after_title' => '</h3>',
));
add_theme_support( 'post-thumbnails' );
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
add_theme_support( 'automatic-feed-links' );	
add_theme_support( 'title-tag' );

add_filter( 'excerpt_length', function ( $length ) { return 80; } );
?>