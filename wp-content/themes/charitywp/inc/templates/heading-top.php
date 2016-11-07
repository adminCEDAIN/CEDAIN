<?php
global $wp_query;
$theme_options_data = get_theme_mods();
/***********custom Top Images*************/
$text_color = $custom_title = $subtitle = $bg_color = $bg_header = $class_full = $text_color_header =
$bg_image = $thim_custom_heading = $cate_top_image_src = $front_title = '';

$hide_breadcrumbs = $hide_title = 0;
// color theme options
$cat_obj = $wp_query->get_queried_object();

if (isset($cat_obj->term_id)) {
    $cat_ID = $cat_obj->term_id;
} else {
    $cat_ID = "";
}

switch (get_post_type()) {
    case 'product':
        $prefix = 'thim_woo';
        break;
    case 'our_team':
        $prefix = 'thim_our_team';
        break;
    case 'portfolio':
        $prefix = 'thim_portfolio';
        break;
    case 'tp_event':
        $prefix = 'thim_event';
        break;
    case 'dn_campaign':
        $prefix = 'thim_donate';
        break;
    default:
        $prefix = 'thim';
        break;
}

$text_color = $bg_color = $cate_top_image_src = '';

// single and archive
switch (get_post_type()) {
    case 'our_team':
        $prefix_inner = '_';
        break;
    case 'portfolio':
        $prefix_inner = '_';
        break;
    case 'tp_event':
        $prefix_inner = '_';
        break;
    case 'dn_campaign':
        $prefix_inner = '_';
        break;

    default:
        if (is_404()) {
            $prefix_inner = '_404_';
        } elseif (is_page()) {
            $prefix_inner = '_page_';
        } else {
            if (is_single()) {
                $prefix_inner = '_single_';
            } elseif (is_front_page()) {
                $prefix_inner = '_front_page_';
            } else {
                $prefix_inner = '_archive_';
            }
        }
        break;
}

// get data for theme customizer

if (isset($theme_options_data[$prefix . $prefix_inner . 'custom_title']) && $theme_options_data[$prefix . $prefix_inner . 'custom_title'] <> '') {
    $custom_title = $theme_options_data[$prefix . $prefix_inner . 'custom_title'];
}

if (isset($theme_options_data[$prefix . $prefix_inner . 'sub_title']) && $theme_options_data[$prefix . $prefix_inner . 'sub_title'] <> '') {
    $subtitle = $theme_options_data[$prefix . $prefix_inner . 'sub_title'];
}

if (isset($theme_options_data[$prefix . $prefix_inner . 'top_image']) && $theme_options_data[$prefix . $prefix_inner . 'top_image'] <> '') {
    $cate_top_image = $theme_options_data[$prefix . $prefix_inner . 'top_image'];
    $cate_top_image_src = $cate_top_image;

    if (is_numeric($cate_top_image)) {
        $cate_top_attachment = wp_get_attachment_image_src($cate_top_image, 'full');
        $cate_top_image_src = $cate_top_attachment[0];
    }
}
if (isset($theme_options_data[$prefix . $prefix_inner . 'hide_title'])) {
    $hide_title = $theme_options_data[$prefix . $prefix_inner . 'hide_title'];
}
if (is_page() || is_home() || is_single('post')) {
    if (is_page()) {
        $postid = get_the_ID();
        $using_custom_heading = get_post_meta($postid, 'thim_mtb_using_custom_heading', true);
        if ($using_custom_heading) {
            $hide_title = get_post_meta($postid, 'thim_mtb_hide_title_and_subtitle', true);
            $custom_title = get_post_meta($postid, 'thim_mtb_custom_title', true);
            $subtitle = get_post_meta($postid, 'thim_subtitle', true);

            $text_color_1 = get_post_meta($postid, 'thim_mtb_text_color', true);
            if ($text_color_1 <> '') {
                $text_color = $text_color_1;
            }
            $bg_color_1 = get_post_meta($postid, 'thim_mtb_bg_color', true);
            if ($bg_color_1 <> '') {
                $bg_color = $bg_color_1;
            }

            $cate_top_image = get_post_meta($postid, 'thim_mtb_top_image', true);

            if ($cate_top_image != '') {
                $post_page_top_attachment = wp_get_attachment_image_src($cate_top_image, 'full');
                $cate_top_image_src = $post_page_top_attachment[0];
            } else {
                $cate_top_image_src = '';
            }
        }
    }

} else {
    $thim_custom_heading = get_tax_meta($cat_ID, 'thim_custom_heading', true);
    if (class_exists('WooCommerce')) {
        if (get_woocommerce_term_meta($cat_ID, 'thumbnail_id')) { // Custom woocommerce cat image
            $thumbnail_id = get_woocommerce_term_meta($cat_ID, 'thumbnail_id');
            $cate_top_image_src = wp_get_attachment_url($thumbnail_id);
        } else if ($thim_custom_heading == 'custom') {
            $text_color_1 = get_tax_meta($cat_ID, $prefix . '_cate_heading_text_color', true);
            $bg_color_1 = get_tax_meta($cat_ID, $prefix . '_cate_heading_bg_color', true);
            if ($text_color_1 != '#') {
                $text_color = $text_color_1;
            }
            if ($bg_color_1 != '#') {
                $bg_color = $bg_color_1;
            }
            $hide_title = get_tax_meta($cat_ID, $prefix . '_cate_hide_title', true);
            $cate_top_image = get_tax_meta($cat_ID, $prefix . '_top_image', true);
            if ($cate_top_image) {
                $cate_top_image_src = $cate_top_image['src'];
            }
        }
    } else {
        if ($thim_custom_heading == 'custom') {
            $text_color_1 = get_tax_meta($cat_ID, $prefix . '_cate_heading_text_color', true);
            $bg_color_1 = get_tax_meta($cat_ID, $prefix . '_cate_heading_bg_color', true);
            if ($text_color_1 != '#') {
                $text_color = $text_color_1;
            }
            if ($bg_color_1 != '#') {
                $bg_color = $bg_color_1;
            }
            $hide_title = get_tax_meta($cat_ID, $prefix . '_cate_hide_title', true);
            $cate_top_image = get_tax_meta($cat_ID, $prefix . '_top_image', true);
            if ($cate_top_image) {
                $cate_top_image_src = $cate_top_image['src'];
            }
        }
    }

}


$hide_title = ($hide_title === 'on') ? '1' : $hide_title;
// css
$c_css_style = $css_line = '';
$c_css_style .= ($text_color != '') ? 'color: ' . $text_color . ';' : '';
$c_css_style .= ($bg_color != '') ? 'background-color: ' . $bg_color . ';' : '';
$css_line .= ($text_color != '') ? 'background-color: ' . $text_color . ';' : '';

//css background and color
$c_css = ($c_css_style != '') ? 'style="' . $c_css_style . '"' : '';

$c_css_1 = ($bg_color != '') ? 'style="background-color:' . $bg_color . '"' : '';

if (!is_plugin_active('thim-framework/tp-framework.php')) {
    $cate_top_image_src = get_template_directory_uri('template_directory') . "/images/page_top_image.jpg";
}

if ($cate_top_image_src != '') {
    $c_css .= 'style="background-image: url(' . $cate_top_image_src . ')"';
}

// css inline line
$c_css_line = ($css_line != '') ? 'style="' . $css_line . '"' : '';

?>
<?php if ($hide_title != '1') { ?>
    <div class="top_site_main<?php if ($cate_top_image_src == '') {
        echo ' top-site-no-image';
    } else {
        echo ' thim-parallax-image';
    } ?>" <?php echo ent2ncr($c_css); ?> data-stellar-background-ratio="0.5">
        <span class="overlay-top-header"></span>
        <div class="page-title-wrapper">
            <div class="banner-wrapper container article_heading">
                <div class="row">
                    <div class="col-xs-6">
                        <?php
                        $typography = 'h1';

                        if ((is_page() || is_single()) && get_post_type() != 'product') {
                            if (is_single()) {

                                $single_title = get_the_title(get_the_ID());

                                // Get post category info
                                $category = get_the_category();
                                if (!empty($category)) {
                                    // Get last category post is in
                                    $last_category = end((array_values($category)));
                                    $single_title = $last_category->cat_name;
                                }

                                switch (get_post_type()) {

                                    case 'tp_event':
                                        $single_title = esc_html__('All Events', 'charitywp');
                                        break;

                                    case 'portfolio':
                                        $single_title = esc_html__('Project Detail', 'charitywp');
                                        break;

                                    case 'dn_campaign':
                                        $single_title = esc_html__('Cause Detail', 'charitywp');
                                        break;

                                    default:
                                        # code...
                                        break;

                                }

                                echo '<' . $typography . ' class="heading__primary">';
                                echo ($custom_title != '') ? $custom_title : $single_title;
                                echo '</' . $typography . '>';
                                echo ($subtitle != '') ? '<div class="banner-description"><p class="heading__secondary">' . $subtitle . '</p></div>' : '';
                            } else {
                                echo '<' . $typography . ' class="heading__primary">';
                                echo ($custom_title != '') ? $custom_title : get_the_title(get_the_ID());
                                echo '</' . $typography . '>';
                                echo ($subtitle != '') ? '<div class="banner-description"><p class="heading__secondary">' . $subtitle . '</p></div>' : '';
                            }
                        } elseif (get_post_type() == 'product') {
                            echo '<' . $typography . ' class="heading__primary">' . esc_html__('Shop', 'charitywp') . '</' . $typography . '>';
                        } elseif (is_front_page() || is_home()) {
//                            var_dump($theme_options_data['thim_custom_title']);
                            if (isset($theme_options_data['thim_custom_title']) && $theme_options_data['thim_custom_title']) {
                                $custom_title = $theme_options_data['thim_custom_title'];
                            }
                            echo '<' . $typography . ' class="heading__primary">';
                            echo ($custom_title != '') ? $custom_title : 'Blog';
                            echo '</' . $typography . '>';
                            echo ($subtitle != '') ? '<div class="banner-description"><p class="heading__secondary">' . $subtitle . '</p></div>' : '';
                        } elseif (is_404()) {
                            echo '<' . $typography . ' class="heading__primary">';
                            echo ($custom_title != '') ? $custom_title : esc_html__('404 Error', 'charitywp');
                            echo '</' . $typography . '>';
                            echo ($subtitle != '') ? '<div class="banner-description"><p class="heading__secondary">' . $subtitle . '</p></div>' : '';
                        } else {
                            echo '<' . $typography . ' class="heading__primary">';
                            echo ($custom_title != '') ? $custom_title : thim_the_archive_title();
                            echo '</' . $typography . '>';
                            echo ($subtitle != '') ? '<div class="banner-description"><p class="heading__secondary">' . $subtitle . '</p></div>' : '';
                        }
                        ?>
                    </div>
                    <div class="col-xs-6">
                        <?php
                        thim_breadcrumbs();
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Display sidebar -->
    <?php if (is_active_sidebar('after_heading') && !is_single()) { ?>
        <div class="after-heading-sidebar thim-animated" data-animate="fadeInUp">
            <?php dynamic_sidebar('after_heading'); ?>
        </div>  <!--slider_sidebar-->
    <?php } else { ?>
        <div class="not-heading-sidebar"></div>
    <?php } ?>


<?php } ?>


<?php if ($cate_top_image_src != '' && $hide_title == '1' && $c_css_1 != '') { ?>
    <div class="top_site_main<?php if ($cate_top_image_src == '') {
        echo ' top-site-no-image-custom';
    } ?>" <?php echo ent2ncr($c_css_1); ?>>
    </div>
<?php } ?>