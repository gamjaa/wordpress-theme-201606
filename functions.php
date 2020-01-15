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

// 요약문 길이 80단어
add_filter( 'excerpt_length', function ( $length ) { return 80; } );

// 감자박스 테마 설정
function gamjaa_theme_setup() {
  // 커스텀 로고(오픈그래프 기본 이미지)
  $logo_defaults = array(
    'height'      => 560,
    'width'       => 315,
    'flex-height' => true,
    'flex-width'  => true
  );
  add_theme_support( 'custom-logo', $logo_defaults );

  // 커스텀 배경(오픈그래프 자동 생성 섬네일 배경)
  $background_defaults = array(
    'default-image'          => '',
    'default-color'          => '#CCA94C'
  );
  add_theme_support( 'custom-background', $background_defaults );

  /* Define the custom box */
  add_action( 'add_meta_boxes', function() {
    add_meta_box( 
      'auto_thumb_checkbox',
      '섬네일 자동 생성 설정',
      'auto_thumb_checkbox_callback',
      'post',
      'side'
    );
  } );

  /* Do something with the data entered */
  add_action( 'save_post', 'auto_thumb_checkbox_save' );

  /* Prints the box content */
  function auto_thumb_checkbox_callback( $post )
  {
      // Use nonce for verification
      wp_nonce_field( 'auto_thumb_checkbox_field_nonce', 'auto_thumb_checkbox_noncename' );

      $saved = get_post_meta( $post->ID, 'disable_auto_thumb' );

      echo '<input type="checkbox" name="disable_auto_thumb" value="true" id="disable_auto_thumb" '.($saved ? 'checked' : '').'/>'.'<label for="disable_auto_thumb">섬네일 자동 생성 끄기</label>';
  }

  /* When the post is saved, saves our custom data */
  function auto_thumb_checkbox_save( $post_id ) 
  {
        // verify if this is an auto save routine. 
        // If it is our form has not been submitted, so we dont want to do anything
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
            return;

        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        if ( !wp_verify_nonce( $_POST['auto_thumb_checkbox_noncename'], 'auto_thumb_checkbox_field_nonce' ) )
            return;

        if ( isset($_POST['disable_auto_thumb']) && $_POST['disable_auto_thumb'] != "" ){
          update_post_meta( $post_id, 'disable_auto_thumb', $_POST['disable_auto_thumb'] );
        } else {
          delete_post_meta( $post_id, 'disable_auto_thumb' );
        }
  }
}
add_action( 'after_setup_theme', 'gamjaa_theme_setup' );
?>