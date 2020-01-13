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
function mytheme_custom_excerpt_length( $length ) {
  return 80;
}
add_filter( 'excerpt_length', 'mytheme_custom_excerpt_length', 999 );
?>