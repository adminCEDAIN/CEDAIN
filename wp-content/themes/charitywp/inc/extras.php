<?php

/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package thim
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function thim_page_menu_args($args) {
    $args['show_home'] = true;
    return $args;
}

add_filter('wp_page_menu_args', 'thim_page_menu_args');

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */

    
    if ( isset( $theme_options_data['thim_box_layout'] ) && $theme_options_data['thim_box_layout'] === 'boxed' ) {
        $class_boxed = 'boxed-area';
    }else{
        $class_boxed = '';
    }
function thim_body_classes($classes) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    $theme_options_data = get_theme_mods();
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }


    if (isset($theme_options_data['thim_display_loading_show']) && true === $theme_options_data['thim_display_loading_show']) {
        $classes[] = 'loading';
    }

    $theme_options_data['thim_header_style'] = isset($theme_options_data['thim_header_style']) ? $theme_options_data['thim_header_style'] : 'default';

    if (isset($theme_options_data['thim_header_style'])) {
        $classes[] = 'thim_header_custom_style';
        $classes[] = 'thim_header_'.$theme_options_data['thim_header_style'];
        if (isset($theme_options_data['thim_header_fixedmenu']) && true === $theme_options_data['thim_header_fixedmenu']) {
            $classes[] = 'thim_fixedmenu';
        }
    }

    $classes[] = (isset($theme_options_data['thim_header_overlay']) && true === $theme_options_data['thim_header_overlay']) ? 'thim_header_overlay' : '';

    return $classes;
}

add_filter('body_class', 'thim_body_classes');


/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function thim_setup_author() {
    global $wp_query;

    if ($wp_query->is_author() && isset($wp_query->post)) {
        $GLOBALS['authordata'] = get_userdata($wp_query->post->post_author);
    }
}

add_action('wp', 'thim_setup_author');
