<?php
/**
 * Audit UX functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Audit_UX
 */

if ( ! defined( '_S_VERSION' ) ) {
  // Replace the version number of the theme on each release.
  define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'audit_ux_setup' ) ) :
  /**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   */
  function audit_ux_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Audit UX, use a find and replace
     * to change 'audit-ux' to the name of your theme in all the template files.
     */
    load_theme_textdomain( 'audit-ux', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
      array(
        'menu-1' => esc_html__( 'Navigation', 'audit-ux' ),
        'contact-menu' => esc_html__( 'Contact', 'audit-ux' ),
        'footer-social' => esc_html__( 'Réseaux sociaux', 'audit-ux' ),
        'footer-legal' => esc_html__( 'Informations légales', 'audit-ux' ),
      )
    );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
      'html5',
      array(
        'gallery',
        'caption',
        'style',
        'script',
      )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
      'custom-background',
      apply_filters(
        'audit_ux_custom_background_args',
        array(
          'default-color' => 'ffffff',
          'default-image' => '',
        )
      )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
      'custom-logo',
      array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
      )
    );
  }
endif;
add_action( 'after_setup_theme', 'audit_ux_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function audit_ux_content_width() {
  $GLOBALS['content_width'] = apply_filters( 'audit_ux_content_width', 640 );
}
add_action( 'after_setup_theme', 'audit_ux_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function audit_ux_widgets_init() {
  register_sidebar(
    array(
      'name'          => esc_html__( 'Footer', 'audit-ux' ),
      'id'            => 'footer-1',
      'description'   => esc_html__( 'Add widgets here. They will appear in the footer', 'audit-ux' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
  );
  register_sidebar(
    array(
      'name'          => esc_html__( 'Newsletter', 'audit-ux' ),
      'id'            => 'newsletter-1',
      'description'   => esc_html__( 'Add widgets here. They will appear before the footer & be hidden on front page', 'audit-ux' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
  );
}
add_action( 'widgets_init', 'audit_ux_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function audit_ux_scripts() {
  wp_enqueue_style( 'audit-ux-style', get_stylesheet_uri(), array(), _S_VERSION );
  wp_style_add_data( 'audit-ux-style', 'rtl', 'replace' );

  wp_enqueue_script( 'audit-ux-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'audit_ux_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Breadcrumbs.
 */
require get_template_directory() . '/inc/breadcrumbs.php';

/**
 * Reusable block widget.
 */
require get_template_directory() . '/inc/reuse-widget.php';

/**
 * Newsletter widget.
 */
require get_template_directory() . '/inc/newsletter-widget.php';

/**
 * Custom menu walker.
 */
require get_template_directory() . '/inc/walker.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
  require get_template_directory() . '/inc/jetpack.php';
}
/**
 * Disable unused widgets
 */
function remove_default_widgets() {
  unregister_widget( 'WP_Widget_Pages' );
  unregister_widget( 'WP_Widget_Calendar' );
  unregister_widget( 'WP_Widget_Archives' );
  unregister_widget( 'WP_Widget_Links' );
  unregister_widget( 'WP_Widget_Media_Audio' );
  unregister_widget( 'WP_Widget_Media_Image' );
  unregister_widget( 'WP_Widget_Media_Video' );
  unregister_widget( 'WP_Widget_Media_Gallery' );
  unregister_widget( 'WP_Widget_Meta' );
  unregister_widget( 'WP_Widget_Search' );
  unregister_widget( 'WP_Widget_Categories' );
  unregister_widget( 'WP_Widget_Recent_Posts' );
  unregister_widget( 'WP_Widget_Recent_Comments' );
  unregister_widget( 'WP_Widget_RSS' );
  unregister_widget( 'WP_Widget_Tag_Cloud' );
  unregister_widget( 'WP_Nav_Menu_Widget' );
}
add_action( 'widgets_init', 'remove_default_widgets' );
/**
 * We don't want Gutenberg styles
 */
function remove_guntenberg_css(){
  wp_dequeue_style('wp-block-library');
}
add_action( 'wp_enqueue_scripts', 'remove_guntenberg_css' );
