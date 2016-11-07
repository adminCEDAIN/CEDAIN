<?php
/**
 * thim functions and definitions
 *
 * @package thim
 */

define('THIM_DIR', trailingslashit(get_template_directory()));
define('THIM_URI', trailingslashit(get_template_directory_uri()));

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset($content_width)) {
    $content_width = 640; /* pixels */
}

if (!function_exists('thim_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function thim_setup()
    {

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on thim, use a find and replace
         * to change 'charitywp' to the name of your theme in all the template files
         */
        load_theme_textdomain('charitywp', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');
        add_theme_support('woocommerce');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary Menu', 'charitywp'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'audio'
        ));

        add_theme_support("title-tag");
        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('thim_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));
    }

endif; // thim_setup
add_action('after_setup_theme', 'thim_setup');

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */

function thim_widgets_init()
{
    $theme_options_data = get_theme_mods();
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'charitywp'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Display in sidebar left or right', 'charitywp'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title"><span>',
        'after_title' => '</span></h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Toolbar', 'charitywp'),
        'id' => 'toolbar',
        'description' => esc_html__('Display in Toolbar', 'charitywp'),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Header Sidebar', 'charitywp'),
        'id' => 'top_sidebar',
        'description' => esc_html__('Display on header', 'charitywp'),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Menu Sidebar', 'charitywp'),
        'id' => 'menu_sidebar',
        'description' => esc_html__('Display on Menu', 'charitywp'),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer', 'charitywp'),
        'id' => 'footer',
        'description' => esc_html__('Display in footer of site.', 'charitywp'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Bottom', 'charitywp'),
        'id' => 'footer-bottom',
        'description' => esc_html__('Fixed in bottom of footer', 'charitywp'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

}

add_action('widgets_init', 'thim_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function thim_scripts()
{
    global $current_blog;
    $theme_options_data = get_theme_mods();
    wp_enqueue_style('thim-css-style', THIM_URI . 'assets/css/custom-style.css', array());

    if (is_multisite()) {
        if (file_exists(THIM_DIR . 'style-' . $current_blog->blog_id . '.css')) {
            wp_enqueue_style('thim-style', get_template_directory_uri() . '/style-' . $current_blog->blog_id . '.css', array());
        } else {
            wp_enqueue_style('thim-style', get_stylesheet_uri());
        }
    } else {
        wp_enqueue_style('thim-style', get_stylesheet_uri());
    }


    if (isset($theme_options_data['thim_rtl_support']) && $theme_options_data['thim_rtl_support'] == '1') {
        wp_enqueue_style('thim-css-style-rtl', THIM_URI . 'rtl.css', array());
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    wp_enqueue_script('thim-main', THIM_URI . 'assets/js/main.min.js', array('jquery'), '', true);
    wp_enqueue_script('thim-custom-script', THIM_URI . 'assets/js/custom-script.js', array('thim-main'), '', true);

    wp_dequeue_style('thim_press_donate_magnific');
    wp_dequeue_style('tp-donate-css-0');
    wp_dequeue_style('thim-event-countdown-css');
    wp_dequeue_style('thim-event-owl-carousel-css');
    wp_dequeue_style('tp-event-site-css-events.css');

    wp_dequeue_script('thim_press_donate_magnific');
    wp_dequeue_script('thim-event-countdown-js');
    wp_dequeue_script('thim-event-owl-carousel-js');
    wp_dequeue_script('thim-event-countdown-plugin-js');


    if (class_exists('TP_Event')) {
        wp_localize_script( 'thim-main', 'TP_Event', tp_event_l18n() );
    }
    
    if (isset($theme_options_data['thim_enable_smoothscroll']) && ($theme_options_data['thim_enable_smoothscroll'] === true) ) {
        wp_enqueue_script('thim-custom-scroll', THIM_URI . 'assets/js/custom-scroll.min.js', array('jquery'), '', true);
    }

}

add_action('wp_enqueue_scripts', 'thim_scripts');

function thim_custom_admin_scripts()
{
    wp_enqueue_style('thim-custom-admin', THIM_URI . 'assets/css/custom-admin.css', array());
}

add_action('admin_enqueue_scripts', 'thim_custom_admin_scripts');


function thim_show_script_id($tag, $handle, $src)
{
    $tag = str_replace('<script', '<script id="' . $handle . '"', $tag);
    return $tag;
}

add_filter('script_loader_tag', 'thim_show_script_id', 100, 3);


// Require library
require THIM_DIR . 'inc/libs/class-tgm-plugin-activation.php';
require THIM_DIR . 'inc/libs/theme-wrapper.php';
require THIM_DIR . 'inc/libs/tax-meta-class/Tax-meta-class.php';
require THIM_DIR . 'inc/libs/custom-export.php';

// Require plugins
if (is_admin() && current_user_can('manage_options')) {
    require THIM_DIR . 'inc/admin/plugins-require.php';
}


// require
require THIM_DIR . 'inc/custom-functions.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

require THIM_DIR . 'inc/aq_resizer.php';

/**
 * Customizer additions.
 */
require THIM_DIR . 'inc/header/logo.php';

include_once(ABSPATH . 'wp-admin/includes/plugin.php');

if (is_plugin_active('thim-framework/tp-framework.php')) {

    require THIM_DIR . 'inc/widgets/widgets.php';

    require THIM_DIR . 'inc/admin/customize-options.php';

    require THIM_DIR . 'inc/tax-meta.php';
}

if (class_exists('WooCommerce')) {
    require get_template_directory() . '/woocommerce/woocommerce.php';
}

if (class_exists('TP_Event')) {
    require get_template_directory() . '/tp-event/functions.php';
}

if (class_exists('ThimPress_Donate')) {
    require get_template_directory() . '/tp-donate/custom-function.php';
}

//pannel Widget Group
function thim_widget_group($tabs)
{
    $tabs[] = array(
        'title' => esc_html__('Thim Widget', 'charitywp'),
        'filter' => array(
            'groups' => array('thim_widget_group')
        )
    );

    return $tabs;
}

add_filter('siteorigin_panels_widget_dialog_tabs', 'thim_widget_group', 19);

function thim_remove_post_custom_fields()
{
    remove_meta_box('erm_menu_shortcode', 'erm_menu', 'side');
    remove_meta_box('erm_footer_item', 'erm_menu', 'normal');
}

add_action('add_meta_boxes', 'thim_remove_post_custom_fields');

add_action('init', 'thim_add_excerpts_to_pages');
function thim_add_excerpts_to_pages()
{
    add_post_type_support('page', 'excerpt');
}


add_filter('siteorigin_panels_row_style_fields', 'thim_row_style_fields');
function thim_row_style_fields($fields)
{

    $fields['overlay'] = array(
        'name' => esc_html__('Overlay', 'charitywp'),
        'type' => 'select',
        'group' => 'design',
        'description' => esc_html__('If enabled, the background image will have a Overlay effect.', 'charitywp'),
        'priority' => 11,
        'options' => array(
            '' => esc_html__('No', 'charitywp'),
            'thim-overlay-color' => esc_html__('Simple Color', 'charitywp')
        )
    );


    return $fields;
}

function thim_row_style_attributes($attributes, $args)
{

    if (!empty($args['parallax'])) {
        array_push($attributes['class'], 'thim-parallax');
    }

    if (!empty($args['row_stretch']) && $args['row_stretch'] == 'full-stretched') {
        array_push($attributes['class'], 'thim-fix-stretched');
    }

    if (!empty($args['overlay'])) {
        array_push($attributes['class'], $args['overlay']);
    }

    return $attributes;
}

add_filter('siteorigin_panels_row_style_attributes', 'thim_row_style_attributes', 10, 2);