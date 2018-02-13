<?php
/*
Author: Eddie Machado
URL: http://themble.com/face/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, etc.
*/

// LOAD face CORE (if you remove this, the theme will break)
require_once( 'library/face.php' );



// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

/*********************
LAUNCH face
Let's get everything up and running.
*********************/



function face_ahoy() {

  //Allow editor style.
  add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  // let's get language support going, if you need it
  load_theme_textdomain( 'facetheme', get_template_directory() . '/library/translation' );



  // launching operation cleanup
  add_action( 'init', 'face_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'face_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'face_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'face_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'face_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'face_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  face_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'face_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'face_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'face_excerpt_more' );

} /* end face ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'face_ahoy' );


require 'theme-update-checker.php';
$example_update_checker = new ThemeUpdateChecker(
'face-master',
'https://milkycocoa.com/theme_update-info.json'
);

/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 680;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'face-thumb-600', 600, 150, true );
add_image_size( 'face-thumb-300', 300, 100, true );

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 100 sized image,
we would use the function:
<?php the_post_thumbnail( 'face-thumb-300' ); ?>
for the 600 x 150 image:
<?php the_post_thumbnail( 'face-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'face_custom_image_sizes' );

function face_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'face-thumb-600' => __('600px by 150px'),
        'face-thumb-300' => __('300px by 100px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* THEME CUSTOMIZE *********************/

/*
  A good tutorial for creating your own Sections, Controls and Settings:
  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722

  Good articles on modifying the default options:
  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162

  To do:
  - Create a js for the postmessage transport method
  - Create some sanitize functions to sanitize inputs
  - Create some boilerplate Sections, Controls and Settings
*/

function face_theme_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections

  // $wp_customize->remove_section('title_tagline');
   $wp_customize->remove_section('colors');
   $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');

  // Uncomment the following to change the default section titles
  // $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
  // $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'face_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function face_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'facetheme' ),
		'description' => __( 'The first (primary) sidebar.', 'facetheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'facetheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'facetheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function face_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'facetheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'facetheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'facetheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'facetheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function face_fonts() {
  wp_enqueue_style('googleFonts', '//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
}

add_action('wp_enqueue_scripts', 'face_fonts');



function delcss() {
	global $template;

	wp_enqueue_style( 'defalt-style', get_template_directory_uri() . '/library/css/bulma.css', array(), '1.0' );

	$template_name = basename( $template, '.php' );

	if ( $template_name == 'front_page' ) {
		wp_deregister_style( 'face-stylesheet' );
	} else {
		wp_deregister_style( 'defalt-style' );
	}
}
add_action( 'wp_enqueue_scripts', 'delcss', 11 );

function bulma_css() {
   wp_enqueue_style( 'bulmacss', get_bloginfo( 'stylesheet_directory') . '/library/css/bulma.css', array(), null, 'all');
}
add_action( 'wp_enqueue_scripts', 'bulma_css');

function main_css() {
   wp_enqueue_style( 'maincss', get_bloginfo( 'stylesheet_directory') . '/library/css/main.min.css', array(), null, 'all');
}
add_action( 'wp_enqueue_scripts', 'main_css');

function animation_css() {
   wp_enqueue_style( 'animationcss', get_bloginfo( 'stylesheet_directory') . '/library/css/animate.min.css', array(), null, 'all');
}
add_action( 'wp_enqueue_scripts', 'animation_css');



function inview_js() {
    wp_enqueue_script( 'inview', get_bloginfo( 'stylesheet_directory') . '/library/js/inview.min.js', array(), false, true );
}
add_action( 'wp_enqueue_scripts', 'inview_js');

function content_js() {
    wp_enqueue_script( 'content', get_bloginfo( 'stylesheet_directory') . '/library/js/content.js', array(), false, true );
}
add_action( 'wp_enqueue_scripts', 'content_js');




define('LOGO_SECTION', 'logo_section'); //セクションIDの定数化
define('LOGO_IMAGE_URL', 'logo_image_url'); //セッティングIDの定数化
function themename_theme_customizer( $wp_customize ) {
 $wp_customize->add_section( LOGO_SECTION , array(
 'title' => 'テーマオプション', //セクション名
 'priority' => 200, //カスタマイザー項目の表示順
 'description' => '各種設定。', //セクションの説明
 ) );

 $wp_customize->add_setting( LOGO_IMAGE_URL );
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, LOGO_IMAGE_URL, array(
 'label' => 'ヘッダーの画像', //設定ラベル
 'section' => LOGO_SECTION, //セクションID
 'settings' => LOGO_IMAGE_URL, //セッティングID
 'description' => '画像をアップロードするとヘッダーにあるデフォルトの画像と入れ替わります。',
 ) ) );

}
add_action( 'customize_register', 'themename_theme_customizer' );//カスタマイザーに登録



function get_the_logo_image_url(){
 return   get_theme_mod( LOGO_IMAGE_URL ) ;
}



   function mytheme_customize_register( $wp_customize ) {
       // セクション、テーマ設定、コントロールを追加します。


       $wp_customize->add_setting( 'key_backgroundcolor' , array(
      'default'     => '#b3d3db',
      'transport'   => 'refresh',

  ) );

  $wp_customize->add_section( 'colors' , array(
      'title' => '色設定',
      'priority'   => 30,
  ) );

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'key_backgroundcolor', array(
       'label'        => 'セクション2の背景色',
       'section'    => 'colors',
       'settings'   => 'key_backgroundcolor',
   ) ) );

   $wp_customize->add_setting( 'key_backgroundcolor2' , array(
  'default'     => '#f6ef82',
  'transport'   => 'refresh',

) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'key_backgroundcolor2', array(
     'label'        => 'セクション3の背景色',
     'section'    => 'colors',
     'settings'   => 'key_backgroundcolor2',
     'type' => 'color',
 ) ) );

 $wp_customize->add_setting( 'key_backgroundcolor3' , array(
'default'     => '#b3d3db',
'transport'   => 'refresh',
'type'  => 'theme_mod',

) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'key_backgroundcolor3', array(
   'label'        => 'セクション4の背景色',
   'section'    => 'colors',
   'settings'   => 'key_backgroundcolor3',
   'type' => 'color',
) ) );

$wp_customize->add_setting( 'key_textcolor' , array(
'default'     => '#e3e3e3',
'transport'   => 'refresh',
'type'  => 'theme_mod',

) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'key_textcolor', array(
  'label'        => 'テキストカラー設定',
  'section'    => 'colors',
  'settings'   => 'key_textcolor',
  'type' => 'color',
) ) );

$wp_customize->add_setting( 'key_linkcolor' , array(
'default'     => '#a0ccdb',
'transport'   => 'refresh',
'type'  => 'theme_mod',

) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'key_linkcolor', array(
  'label'        => 'リンクカラー設定',
  'section'    => 'colors',
  'settings'   => 'key_linkcolor',
  'type' => 'color',
) ) );

$wp_customize->add_setting( 'key_titlecolor' , array(
'default'     => '#2d2d2d',
'transport'   => 'refresh',
'type'  => 'theme_mod',

) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'key_titlecolor', array(
  'label'        => 'タイトルカラー設定',
  'section'    => 'colors',
  'settings'   => 'key_titlecolor',
  'type' => 'color',
) ) );

$wp_customize->add_setting( 'key_blogcardcolor' , array(
'default'     => '#ededed',
'transport'   => 'refresh',
'type'  => 'theme_mod',

) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'key_blogcardcolor', array(
  'label'        => 'ブログカードの背景色設定',
  'section'    => 'colors',
  'settings'   => 'key_blogcardcolor',
  'type' => 'color',
) ) );

   }
   add_action( 'customize_register', 'mytheme_customize_register' );




   function top_background_color(){
    return   get_theme_mod( 'background_color');
   }

   function background_color2(){
    return   'style="background-color:' .get_theme_mod( 'key_backgroundcolor', '#d1eaea').';"';
   }

   function background_color3(){
    return   'style="background-color:' .get_theme_mod( 'key_backgroundcolor2', '#f6ef82').';"';
   }

   function background_color4(){
    return   'style="background-color:' .get_theme_mod( 'key_backgroundcolor3', '#d1eaea').';"';
   }

   function top_text_color(){
    return   get_theme_mod( 'key_textcolor', '#333 ');
   }

   function top_link_color(){
    return   get_theme_mod( 'key_linkcolor', '#333 ');
   }


   function top_title_color(){
    return    'style="color:' .get_theme_mod( 'key_titlecolor', '#2d2d2d').';"';
   }

   function top_blog_backgroundcolor(){
    return    'style="background-color:' .get_theme_mod( 'key_blogcardcolor', '#ededed').';"';
   }


add_action('admin_menu', 'theme_menu');

function theme_menu() {
    add_menu_page('テーマオプション', 'テーマオプション', 'manage_options', 'theme_menu', 'theme_options_page');
    add_action( 'admin_init', 'register_theme_settings' );
}

function register_theme_settings() {
    register_setting( 'theme-settings-group', 'theme_setion1check' );
    register_setting( 'theme-settings-group', 'theme_setion1title' );
    register_setting( 'theme-settings-group', 'theme_setion1text' );
    register_setting( 'theme-settings-group', 'theme_setion1title2' );
    register_setting( 'theme-settings-group', 'theme_setion1text2' );
    register_setting( 'theme-settings-group', 'theme_setion1title3' );
    register_setting( 'theme-settings-group', 'theme_setion1text3' );
    register_setting( 'theme-settings-group', 'theme_setion2check' );
    register_setting( 'theme-settings-group', 'theme_setion2title' );
    register_setting( 'theme-settings-group', 'theme_setion2text' );
    register_setting( 'theme-settings-group', 'theme_setion3check' );
    register_setting( 'theme-settings-group', 'theme_setion3title' );
    register_setting( 'theme-settings-group', 'theme_setion3text' );
    register_setting( 'theme-settings-group', 'theme_setion4check' );
    register_setting( 'theme-settings-group', 'theme_setion4title' );
    register_setting( 'theme-settings-group', 'theme_setion4text' );
    register_setting( 'theme-settings-group', 'theme_setion5check' );
    register_setting( 'theme-settings-group', 'theme_blogcount' );
}


function theme_options_page() {

    ?>

    <div class="wrap">
        <h2>テーマの設定</h2>
       <form method="post" action="options.php">
            <?php
            settings_fields( 'theme-settings-group' );
            do_settings_sections( 'theme-settings-group' );
            ?>
            <table class="form-table">
                <tbody>
                  <tr>
                    <th>
                      <p>セクション1</p>
                    </th>
                  </tr>
                  <tr>
                    <th>
                        <label>セクション1の表示</label>
                    </th>
                    <td>
                      <input type="checkbox" name="theme_setion1check" value="checked" <?php if(get_option('theme_setion1check') == "checked"){echo "checked";}?>>
                    </td>

                  </tr>
                <tr>
                    <th scope="row">
                        <label for="theme_url">左タイトル</label>
                    </th>
                    <td><input type="text" name="theme_setion1title" maxlength="30" value="<?php if(get_option('theme_setion1title')){echo get_option('theme_setion1title');}?>">
                    </td>

                </tr>

                <tr>
                    <th scope="row">
                        <label for="theme_url">左本文</label>
                    </th>
                    <td><textarea name="theme_setion1text" maxlength="130"><?php if(get_option('theme_setion1text')){echo get_option('theme_setion1text');}?></textarea>
                    </td>

                </tr>

                <tr>
                    <th scope="row">
                        <label for="theme_url">中央タイトル</label>
                    </th>
                    <td><input type="text" name="theme_setion1title2" maxlength="30" value="<?php if(get_option('theme_setion1title2')){echo get_option('theme_setion1title2');}?>">
                    </td>

                </tr>

                <tr>
                    <th scope="row">
                        <label for="theme_url">中央本文</label>
                    </th>
                    <td><textarea name="theme_setion1text2" maxlength="130"><?php if(get_option('theme_setion1text2')){echo get_option('theme_setion1text2');}?></textarea>
                    </td>

                </tr>

                <tr>
                    <th scope="row">
                        <label for="theme_url">右タイトル</label>
                    </th>
                    <td><input type="text" name="theme_setion1title3" maxlength="30" value="<?php if(get_option('theme_setion1title3')){echo get_option('theme_setion1title3');}?>">
                    </td>

                </tr>

                <tr>
                    <th scope="row">
                        <label for="theme_url">右本文</label>
                    </th>
                    <td><textarea name="theme_setion1text3" maxlength="130"><?php if(get_option('theme_setion1text3')){echo get_option('theme_setion1text3');}?></textarea>
                    </td>

                </tr>
                <tr>
                  <th>
                    <p>セクション2</p>
                  </th>
                </tr>
                <tr>
                  <th>
                      <label>セクション2の表示</label>
                  </th>
                  <td>
                    <input type="checkbox" name="theme_setion2check" value="checked" <?php if(get_option('theme_setion2check') == "checked"){echo "checked";}?>>
                  </td>

                </tr>
                <tr>
                    <th scope="row">
                        <label for="theme_url">タイトル</label>
                    </th>
                    <td><input type="text" name="theme_setion2title" maxlength="30" value="<?php if(get_option('theme_setion2title')){echo get_option('theme_setion2title');}?>">
                    </td>

                </tr>

                <tr>
                    <th scope="row">
                        <label for="theme_url">本文</label>
                    </th>
                    <td><textarea name="theme_setion2text" maxlength="130"><?php if(get_option('theme_setion2text')){echo get_option('theme_setion2text');}?></textarea>
                    </td>

                </tr>


                <tr>
                  <th>
                    <p>セクション3</p>
                  </th>
                </tr>
                <tr>
                  <th>
                      <label>セクション3の表示</label>
                  </th>
                  <td>
                    <input type="checkbox" name="theme_setion3check" value="checked" <?php if(get_option('theme_setion3check') == "checked"){echo "checked";}?>>
                  </td>

                </tr>
                <tr>
                    <th scope="row">
                        <label for="theme_url">タイトル</label>
                    </th>
                    <td><input type="text" name="theme_setion3title" maxlength="30" value="<?php if(get_option('theme_setion3title')){echo get_option('theme_setion3title');}?>">
                    </td>

                </tr>

                <tr>
                    <th scope="row">
                        <label for="theme_url">本文</label>
                    </th>
                    <td><textarea name="theme_setion3text" maxlength="130"><?php if(get_option('theme_setion3text')){echo get_option('theme_setion3text');}?></textarea>
                    </td>

                </tr>


                <tr>
                  <th>
                    <p>セクション4</p>
                  </th>
                </tr>
                <tr>
                  <th>
                      <label>セクション4の表示</label>
                  </th>
                  <td>
                    <input type="checkbox" name="theme_setion4check" value="checked" <?php if(get_option('theme_setion4check') == "checked"){echo "checked";}?>>
                  </td>

                </tr>
                <tr>
                    <th scope="row">
                        <label for="theme_url">タイトル</label>
                    </th>
                    <td><input type="text" name="theme_setion4title" maxlength="30" value="<?php if(get_option('theme_setion4title')){echo get_option('theme_setion4title');}?>">
                    </td>

                </tr>

                <tr>
                    <th scope="row">
                        <label for="theme_url">本文</label>
                    </th>
                    <td><textarea name="theme_setion4text" maxlength="130"><?php if(get_option('theme_setion4text')){echo get_option('theme_setion4text');}?></textarea>
                    </td>

                </tr>

                <tr>
                  <th>
                    <p>ブログセクション</p>
                  </th>
                </tr>
                <tr>
                  <th>
                      <label>ブログの表示</label>
                  </th>
                  <td>
                    <input type="checkbox" name="theme_setion5check" value="checked" <?php if(get_option('theme_setion5check') == "checked"){echo "checked";}?>>
                  </td>

                </tr>
                <tr>
                  <th>
                      <label>表示する記事数</label>
                  </th>
                  <td>
                    <input type="number" name="theme_blogcount" max="40" value="<?php if(get_option('theme_blogcount')){echo get_option('theme_blogcount');}?>">
                  </td>
                </tr>

                </tbody>
            </table>

            <?php submit_button(); ?>
        </form>

    </div>
    <?php
}


/* DON'T DELETE THIS CLOSING TAG */
?>
