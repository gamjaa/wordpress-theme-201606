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

  // 섬네일 자동 생성 설정 페이지
  add_action( 'admin_menu', 'auto_thumb_add_admin_menu' );
  add_action( 'admin_init', 'auto_thumb_settings_init' );

  function auto_thumb_add_admin_menu(  ) { 
    add_options_page( '섬네일 자동 생성', '섬네일 자동 생성', 'manage_options', 'auto_thumb_generator', 'auto_thumb_options_page' );
  }

  function auto_thumb_settings_init(  ) { 
    register_setting( 'auto_thumb', 'auto_thumb_settings' );

    add_settings_section(
      'auto_thumb_setting_section', 
      '섬네일 자동 생성 설정', 
      'auto_thumb_settings_section_callback', 
      'auto_thumb'
    );

    add_settings_field( 
      'auto_thumb_default', 
      '오픈그래프 기본 이미지 URL(포스트 제외한 페이지에서 출력)', 
      'auto_thumb_default_render', 
      'auto_thumb', 
      'auto_thumb_setting_section' 
    );

    add_settings_field( 
      'auto_thumb_background_image', 
      '오픈그래프 자동 생성 섬네일 배경 이미지 URL(해당 이미지에 글 제목 합성해 출력)', 
      'auto_thumb_background_image_render', 
      'auto_thumb', 
      'auto_thumb_setting_section' 
    );

    add_settings_field( 
      'auto_thumb_background_color', 
      '오픈그래프 자동 생성 섬네일 배경색 코드(배경 이미지 없을 때 사용)', 
      'auto_thumb_background_color_render', 
      'auto_thumb', 
      'auto_thumb_setting_section' 
    );
  }

  function auto_thumb_default_render(  ) { 
    $options = get_option( 'auto_thumb_settings' );
?>
    <input type='url' name='auto_thumb_settings[auto_thumb_default]' value='<?= $options['auto_thumb_default'] ?>'>
<?php
  }

  function auto_thumb_background_color_render(  ) { 
    $options = get_option( 'auto_thumb_settings' );
?>
    <input type='text' name='auto_thumb_settings[auto_thumb_background_color]' placeholder='#CCA94C' value='<?= $options['auto_thumb_background_color'] ?>'>
<?php
  }

  function auto_thumb_background_image_render(  ) { 
    $options = get_option( 'auto_thumb_settings' );
?>
    <input type='url' name='auto_thumb_settings[auto_thumb_background_image]' value='<?= $options['auto_thumb_background_image'] ?>'>
<?php
  }

  function auto_thumb_settings_section_callback(  ) { 
    echo '포스트 섬네일 자동 생성 설정 페이지';
  }

  function auto_thumb_options_page(  ) { 
?>
      <form action='options.php' method='post'>
<?php
          settings_fields( 'auto_thumb' );
          do_settings_sections( 'auto_thumb' );
          submit_button();
?>
      </form>
<?php
  }

  // 포스트 별 섬네일 자동 생성 기능 끄기
  add_action( 'add_meta_boxes', function() {
    add_meta_box( 
      'auto_thumb_checkbox',
      '섬네일 자동 생성 설정',
      'auto_thumb_checkbox_callback',
      'post',
      'side'
    );
  } );

  add_action( 'save_post', 'auto_thumb_checkbox_save' );

  function auto_thumb_checkbox_callback( $post )
  {
      // Use nonce for verification
      wp_nonce_field( 'auto_thumb_checkbox_field_nonce', 'auto_thumb_checkbox_noncename' );

      $saved = get_post_meta( $post->ID, 'disable_auto_thumb' );

      echo '<input type="checkbox" name="disable_auto_thumb" value="1" id="disable_auto_thumb" '.checked(1, $saved, false).'/>'.'<label for="disable_auto_thumb">섬네일 자동 생성 끄기</label>';
  }

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
?>