<?php
  // Menus
  register_nav_menus( array(
    'main_menu' => 'Main Menu',
  ));
  // Sidebar
  register_sidebar( array(
    'name' => __( 'Sidebar' ),
    'id' => 'sidebar',
    'before_widget' => '<div class="widget">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));

  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
  add_theme_support( 'automatic-feed-links' );	
  add_theme_support( 'title-tag' );

  // RSS 피드 사이트 아이콘 크기 변경
  function rss2_site_icon_512() {
    $rss_title = get_wp_title_rss();
    if ( empty( $rss_title ) ) {
      $rss_title = get_bloginfo_rss( 'name' );
    }
  
    $url = get_site_icon_url(512);
    if ( $url ) {
      echo '
<image>
  <url>' . convert_chars( $url ) . '</url>
  <title>' . $rss_title . '</title>
  <link>' . get_bloginfo_rss( 'url' ) . '</link>
  <width>512</width>
  <height>512</height>
</image> ' . "\n";
    }
  }
  remove_action( 'rss2_head', 'rss2_site_icon' );
  add_action( 'rss2_head', 'rss2_site_icon_512' );

  // RSS 피드 description에 전체 내용 넣기
  add_filter( 'the_excerpt_rss', 'the_content' );

  // 섬네일 자동 생성 설정 페이지
  add_action( 'admin_menu', 'gamjaa_post_options_add_admin_menu' );
  add_action( 'admin_init', 'gamjaa_post_options_init' );

  function gamjaa_post_options_add_admin_menu(  ) { 
    add_options_page( '섬네일 자동 생성', '섬네일 자동 생성', 'manage_options', 'gamjaa_post_options', 'gamjaa_post_options_page' );
  }

  function gamjaa_post_options_init(  ) { 
    register_setting( 'gamjaa_post_options_grp', 'gamjaa_post_options' );

    add_settings_section(
      'gamjaa_post_options_section', 
      '섬네일 자동 생성 설정',
      'gamjaa_post_options_section_callback', 
      'gamjaa_post_options_grp'
    );

    add_settings_field( 
      'auto_thumb_default', 
      '오픈그래프 기본 이미지 URL(포스트 제외한 페이지에서 출력)', 
      'auto_thumb_default_render', 
      'gamjaa_post_options_grp', 
      'gamjaa_post_options_section' 
    );

    add_settings_field( 
      'auto_thumb_background_image', 
      '오픈그래프 자동 생성 섬네일 배경 이미지 URL(해당 이미지에 글 제목 합성해 출력)', 
      'auto_thumb_background_image_render', 
      'gamjaa_post_options_grp', 
      'gamjaa_post_options_section' 
    );

    add_settings_field( 
      'auto_thumb_background_color', 
      '오픈그래프 자동 생성 섬네일 배경색 코드(배경 이미지 없을 때 사용)', 
      'auto_thumb_background_color_render', 
      'gamjaa_post_options_grp', 
      'gamjaa_post_options_section' 
    );
  }

  function auto_thumb_default_render(  ) { 
    $options = get_option( 'gamjaa_post_options' );
?>
    <input type='url' name='gamjaa_post_options[auto_thumb_default]' value='<?= esc_attr($options['auto_thumb_default']) ?>'>
<?php
  }

  function auto_thumb_background_color_render(  ) { 
    $options = get_option( 'gamjaa_post_options' );
?>
    <input type='text' name='gamjaa_post_options[auto_thumb_background_color]' placeholder='#CCA94C' value='<?= esc_attr($options['auto_thumb_background_color']) ?>'>
<?php
  }

  function auto_thumb_background_image_render(  ) { 
    $options = get_option( 'gamjaa_post_options' );
?>
    <input type='url' name='gamjaa_post_options[auto_thumb_background_image]' value='<?= esc_attr($options['auto_thumb_background_image']) ?>'>
<?php
  }

  function gamjaa_post_options_section_callback(  ) { 
    echo '포스트 섬네일 자동 생성 설정 페이지';
  }

  function gamjaa_post_options_page(  ) { 
?>
      <form action='options.php' method='post'>
<?php
          settings_fields( 'gamjaa_post_options_grp' );
          do_settings_sections( 'gamjaa_post_options_grp' );
          submit_button();
?>
      </form>
<?php
  }

  // 포스트 별 섬네일 자동 생성 / 광고 출력 설정
  add_action( 'add_meta_boxes', function() {
    add_meta_box( 
      'gamjaa_post_options_grp',
      '섬네일 자동 생성 / 광고 출력',
      'gamjaa_post_options_callback',
      'post',
      'side'
    );
  } );

  add_action( 'save_post', 'gamjaa_post_options_save' );

  function gamjaa_post_options_callback( $post )
  {
      // Use nonce for verification
      wp_nonce_field( 'gamjaa_post_options_fields_nonce', 'gamjaa_post_options_noncename' );

      $current_disable_auto_thumb = get_post_meta( $post->ID, 'disable_auto_thumb', true );
      $current_include_ads = get_post_meta( $post->ID, 'include_ads', true );

      echo '<input type="checkbox" name="disable_auto_thumb" value="1" id="disable_auto_thumb" '.checked($current_disable_auto_thumb, 1, false).'/>'.'<label for="disable_auto_thumb">섬네일 자동 생성 끄기</label><br>'
      .'<input type="checkbox" name="include_ads" value="1" id="include_ads" '.checked($current_include_ads, 1, false).'/>'.'<label for="include_ads">광고 표시 하기</label>';
  }

  function gamjaa_post_options_save( $post_id ) 
  {
        // verify if this is an auto save routine. 
        // If it is our form has not been submitted, so we dont want to do anything
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
            return;

        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        $noncename = 'gamjaa_post_options_noncename';
        if ( !isset($_POST[$noncename]) || !wp_verify_nonce( $_POST[$noncename], 'gamjaa_post_options_fields_nonce' ) )
            return;

        if ( isset($_POST['disable_auto_thumb']) && $_POST['disable_auto_thumb'] != "" ){
          update_post_meta( $post_id, 'disable_auto_thumb', sanitize_text_field($_POST['disable_auto_thumb']) );
        } else {
          delete_post_meta( $post_id, 'disable_auto_thumb' );
        }

        if ( isset($_POST['include_ads']) && $_POST['include_ads'] != "" ){
          update_post_meta( $post_id, 'include_ads', sanitize_text_field($_POST['include_ads']) );
        } else {
          delete_post_meta( $post_id, 'include_ads' );
        }
  }

function gamjaa_theme_scripts() {
    // Google Analytics
    $ga_id = 'G-MSPCPW3CW1'; // This could be an option in the future.
    wp_enqueue_script( 'gtag', 'https://www.googletagmanager.com/gtag/js?id=' . $ga_id, array(), null, true );
    $ga_code = "window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '$ga_id');";
    wp_add_inline_script( 'gtag', $ga_code );

    // Main Stylesheet
    wp_enqueue_style( 'main-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
}
add_action( 'wp_enqueue_scripts', 'gamjaa_theme_scripts' );

function is_allow_robots() {
    if ((is_home() || is_page()) && !is_paged()) {
        return true;
    }

    if (is_single()) {
        global $post;
        $categories = get_the_category($post->ID);
        // 카테고리가 일상으로만 설정돼있으면 로봇 차단
        if (count($categories) == 1 && $categories[0]->term_id == 5) {
            return false;
        }

        return true;
    }

    return false;
}

function tags2keywords() {
    $tags = get_the_tags();
    $keywords = '';
    if ($tags) {
        foreach ($tags as $tag) {
            $keywords .= $tag->name . ',';
        }
    }
    return $keywords;
}
?>