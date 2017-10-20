<?php
  // Menus
register_nav_menus( array(
  'main_menu' => 'Main Menu',
));
  // Sidebar
register_sidebar( array(
  'name' => __( 'Left Sidebar' ),
  'before_widget' => '<div class="widget">',
  'after_widget' => '</div>',
  'before_title' => '<h3>',
  'after_title' => '</h3>',
));
// TinyMCE 4 포맷 스타일 추가
function mce_add_editor_styles(){
	add_editor_style( 'editor-style.css' );	
}
add_action( 'admin_init', 'mce_add_editor_styles' );
?>