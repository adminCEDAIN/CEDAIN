<?php

function thim_hex2rgb( $hex ) {
	$hex = str_replace( "#", "", $hex );
	if ( strlen( $hex ) == 3 ) {
		$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
		$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
		$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	} else {
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
	}
	$rgb = array( $r, $g, $b );

	return $rgb; // returns an array with the rgb values
}

function thim_getExtraClass( $el_class ) {
	$output = '';
	if ( $el_class != '' ) {
		$output = " " . str_replace( ".", "", $el_class );
	}

	return $output;
}

function thim_getCSSAnimation( $css_animation ) {
	$output = '';
	if ( $css_animation != '' ) {
		$output = ' wpb_animate_when_almost_visible wpb_' . $css_animation;
	}

	return $output;
}

function thim_excerpt( $limit ) {
	$content = get_the_excerpt();
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );
	$content = explode( ' ', $content, $limit );
	array_pop( $content );
	$content = implode( " ", $content );

	return $content;
}

/************ List Comment ***************/
if ( ! function_exists( 'thim_comment' ) ) {
	function thim_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		//extract( $args, EXTR_SKIP );
		if ( 'div' == $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo ent2ncr( $tag ) . ' '; ?><?php comment_class( 'description_comment' ) ?> id="comment-<?php comment_ID() ?>">
		<div class="wrapper-comment">
			<?php
			if ( $args['avatar_size'] != 0 ) {
				echo get_avatar( $comment, $args['avatar_size'] );
			}
			?>
			<div class="comment-right">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'charitywp' ) ?></em>
				<?php endif; ?>

				<div class="comment-extra-info">
					<div
						class="author"><?php printf( '<span class="author-name">%s</span>', get_comment_author_link() ) ?></div>
					<div class="date">
						<?php printf( get_comment_date(), get_comment_time() ) ?></div>
					<?php edit_comment_link( esc_html__( 'Edit', 'charitywp' ), '', '' ); ?>

					<?php comment_reply_link( array_merge( $args, array(
						'add_below' => $add_below,
						'depth'     => $depth,
						'max_depth' => $args['max_depth']
					) ) ) ?>
				</div>

				<div class="content-comment">
					<?php comment_text() ?>
				</div>
			</div>
		</div>
		<?php
	}
}
/************end list comment************/

function thim_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;

	return $fields;
}

add_filter( 'comment_form_fields', 'thim_move_comment_field_to_bottom' );


/********************************************************************
 * Get image attach
 ********************************************************************/
function thim_feature_image( $width = 1024, $height = 768, $link = true ) {
	global $post;
	if ( has_post_thumbnail() ) {
		if ( $link != true && $link != false ) {
			the_post_thumbnail( $post->ID, $link );
		} else {
			$get_thumbnail = simplexml_load_string( get_the_post_thumbnail( $post->ID, 'full' ) );
			if ( $get_thumbnail ) {
				$thumbnail_src = $get_thumbnail->attributes()->src;
				$img_url       = $thumbnail_src;
				$data          = @getimagesize( $img_url );
				$width_data    = $data[0];
				$height_data   = $data[1];
				if ( $link ) {
					if ( ( $width_data < $width ) || ( $height_data < $height ) ) {
						echo '<div class="thumbnail"><a href="' . esc_url( get_permalink() ) . '" title = "' . get_the_title() . '">';
						echo '<img src="' . $img_url[0] . '" alt= "' . get_the_title() . '" title = "' . get_the_title() . '" />';
						echo '</a></div>';
					} else {
						$image_crop = aq_resize( $img_url[0], $width, $height, true );
						echo '<div class="thumbnail"><a href="' . esc_url( get_permalink() ) . '" title = "' . get_the_title() . '">';
						echo '<img src="' . $image_crop . '" alt= "' . get_the_title() . '" title = "' . get_the_title() . '" />';
						echo '</a></div>';
					}
				} else {
					if ( ( $width_data < $width ) || ( $height_data < $height ) ) {
						return '<img src="' . $img_url[0] . '" alt= "' . get_the_title() . '" title = "' . get_the_title() . '" />';
					} else {
						$image_crop = aq_resize( $img_url[0], $width, $height, true );

						return '<img src="' . $image_crop . '" alt= "' . get_the_title() . '" title = "' . get_the_title() . '" />';
					}
				}
			}
		}
	}
}

#remove field in Display settings
require THIM_DIR . 'inc/wrapper-before-after.php';

add_filter( 'thim_mtb_setting_after_created', 'thim_mtb_setting_after_created', 10, 2 );
function thim_mtb_setting_after_created( $mtb_setting ) {
	$mtb_setting->removeOption( array( 1, 6, 9, 10, 11 ) );

	$settings = array(
		'name' => esc_html__( 'No Padding Content', 'charitywp' ),
		'id'   => 'mtb_no_padding',
		'type' => 'checkbox',
		'desc' => ' ',
	);

	$mtb_setting->insertOptionBefore( $settings, 15 );

	return $mtb_setting;
}

//thim_excerpt_length
function thim_excerpt_length() {
	$theme_options_data = get_theme_mods();
	if ( isset( $theme_options_data['thim_archive_excerpt_length'] ) ) {
		$length = $theme_options_data['thim_archive_excerpt_length'];
	} else {
		$length = '50';
	}

	return $length;
}

add_filter( 'excerpt_length', 'thim_excerpt_length', 999 );
function thim_wp_new_excerpt( $text ) {
	if ( $text == '' ) {
		$text           = get_the_content( '' );
		$text           = strip_shortcodes( $text );
		$text           = apply_filters( 'the_content', $text );
		$text           = str_replace( ']]>', ']]>', $text );
		$text           = strip_tags( $text );
		$text           = nl2br( $text );
		$excerpt_length = apply_filters( 'excerpt_length', 55 );
		$words          = explode( ' ', $text, $excerpt_length + 1 );
		if ( count( $words ) > $excerpt_length ) {
			array_pop( $words );
			array_push( $words, '' );
			$text = implode( ' ', $words );
		}
	}

	return $text;
}

remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
add_filter( 'get_the_excerpt', 'thim_wp_new_excerpt' );

function thim_post_share() {
	$theme_options_data = get_theme_mods();
	$post_type          = get_post_type();

	$prefix = 'thim_archive_';
	if ( $post_type === 'tp_event' ) {
		$prefix = 'thim_event_';
	}
	$facebook  = isset( $theme_options_data[$prefix . 'sharing_facebook'] ) ? $theme_options_data[$prefix . 'sharing_facebook'] : true;
	$twitter   = isset( $theme_options_data[$prefix . 'sharing_twitter'] ) ? $theme_options_data[$prefix . 'sharing_twitter'] : true;
	$pinterest = isset( $theme_options_data[$prefix . 'sharing_pinterest'] ) ? $theme_options_data[$prefix . 'sharing_pinterest'] : true;
	$fancy     = isset( $theme_options_data[$prefix . 'sharing_fancy'] ) ? $theme_options_data[$prefix . 'sharing_fancy'] : true;
	$google    = isset( $theme_options_data[$prefix . 'sharing_google'] ) ? $theme_options_data[$prefix . 'sharing_google'] : true;

	if ( $facebook || $twitter || $pinterest || $fancy || $google ) {
		echo '<ul class="social-share">';

		if ( $fancy ) {
			echo '<li class="fancy">
							<script type="text/javascript" src="//fancy.com/fancyit/v2/fancyit.js" id="fancyit" async="async" data-count="right"></script>
						</li>';
		}

		if ( $google ) {
			echo '<li class="google">
							<script src="https://apis.google.com/js/platform.js" async></script>
							<div class="g-plusone" data-size="medium"></div>
						</li>';
		}

		if ( $pinterest ) {
			echo '<li class="pinterest">
							<a data-pin-do="buttonBookmark" href="//www.pinterest.com/pin/create/button/"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" alt=""/></a>
							<script async src="//assets.pinterest.com/js/pinit.js"></script>
						</li>';
		}

		if ( $twitter ) {
			echo '<li class="twitter">
							<a href="' . esc_url( get_permalink() ) . '" class="twitter-share-button">Tweet</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\'://platform.twitter.com/widgets.js\';fjs.parentNode.insertBefore(js,fjs);}}(document, \'script\', \'twitter-wjs\');</script>
						</li>';
		}

		if ( $facebook ) {

			echo '<li class="facebook">
							<div id="fb-root"></div>
							<script>(function(d, s, id) {
							  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) return;
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, \'script\', \'facebook-jssdk\'));</script>
							<div class="fb-share-button" data-href="' . esc_url( get_permalink() ) . '" data-layout="button_count"></div>
						</li>';
		}

		echo '</ul>';
	}

}

add_action( 'thim_social_share', 'thim_post_share' );


add_filter( 'wp_nav_menu_args', 'thim_select_main_menu' );
function thim_select_main_menu( $args ) {
	global $post;
	if ( $post ) {
		if ( get_post_meta( $post->ID, 'thim_select_menu_one_page', true ) != 'default' && ( $args['theme_location'] == 'primary' ) ) {
			$menu         = get_post_meta( $post->ID, 'thim_select_menu_one_page', true );
			$args['menu'] = $menu;
		}
	}

	return $args;
}

add_filter( 'wpcf7_support_html5_fallback', '__return_true' );


/**
 * About the author
 */
function thim_about_author() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	?>
	<div class="thim-about-author">
		<div class="author-wrapper">
			<div class="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'email' ), 100 ); ?>
				<p class="name">
					<?php the_author_link(); ?>

				</p>

				<?php if ( get_the_author_meta( 'job' ) ) : ?>
					<p class="job">
						<?php echo get_the_author_meta( 'job' ); ?>
					</p>
				<?php endif; ?>
			</div>
			<div class="author-details">
				<div class="author-bio">


					<p class="description"><?php echo get_the_author_meta( 'description' ); ?></p>

					<?php if ( get_the_author_meta( 'user_url' ) || get_the_author_meta( 'facebook' ) || get_the_author_meta( 'twitter' ) || get_the_author_meta( 'skype' ) || get_the_author_meta( 'pinterest' ) ): ?>
						<ul class="user-social">

							<?php if ( get_the_author_meta( 'user_url' ) ) : ?>
								<li class="user_url">
									<a href="<?php echo get_the_author_meta( 'user_url' ); ?>" target="_blank"><i
											class="fa fa-globe"></i></a>
								</li>
							<?php endif; ?>

							<?php if ( get_the_author_meta( 'facebook' ) ) : ?>
								<li class="facebook">
									<a href="<?php echo get_the_author_meta( 'facebook' ); ?>" target="_blank"><i
											class="fa fa-facebook"></i></a>
								</li>
							<?php endif; ?>

							<?php if ( get_the_author_meta( 'twitter' ) ) : ?>
								<li class="twitter">
									<a href="<?php echo get_the_author_meta( 'twitter' ); ?>" target="_blank"><i
											class="fa fa-twitter"></i></a>
								</li>
							<?php endif; ?>

							<?php if ( get_the_author_meta( 'skype' ) ) : ?>
								<li class="skype">
									<a href="<?php echo get_the_author_meta( 'skype' ); ?>" target="_blank"><i
											class="fa fa-skype"></i></a>
								</li>
							<?php endif; ?>

							<?php if ( get_the_author_meta( 'pinterest' ) ) : ?>
								<li class="pinterest">
									<a href="<?php echo get_the_author_meta( 'pinterest' ); ?>" target="_blank"><i
											class="fa fa-pinterest"></i></a>
								</li>
							<?php endif; ?>

						</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
}

add_action( 'thim_about_author', 'thim_about_author' );


function thim_modify_contact_methods( $profile_fields ) {
	$profile_fields['job']       = 'Job';
	$profile_fields['facebook']  = 'Facebook';
	$profile_fields['twitter']   = 'Twitter';
	$profile_fields['skype']     = 'Skype';
	$profile_fields['pinterest'] = 'Pinterest';

	return $profile_fields;
}

add_filter( 'user_contactmethods', 'thim_modify_contact_methods' );


/**
 * Optimize script files
 */
function thim_optimize_scripts() {
	global $wp_scripts;
	if ( ! is_a( $wp_scripts, 'WP_Scripts' ) ) {
		return;
	}
	foreach ( $wp_scripts->registered as $handle => $script ) {
		$wp_scripts->registered[$handle]->ver = null;
	}
}

add_action( 'wp_print_scripts', 'thim_optimize_scripts', 999 );
add_action( 'wp_print_footer_scripts', 'thim_optimize_scripts', 999 );
/**
 * Optimize style files
 */
function thim_optimize_styles() {
	global $wp_styles;
	if ( ! is_a( $wp_styles, 'WP_Styles' ) ) {
		return;
	}
	foreach ( $wp_styles->registered as $handle => $style ) {
		$wp_styles->registered[$handle]->ver = null;
	}
}

add_action( 'admin_print_styles', 'thim_optimize_styles', 999 );
add_action( 'wp_print_styles', 'thim_optimize_styles', 999 );


/**
 * Display favicon
 */
function thim_favicon() {

	if ( function_exists( 'wp_site_icon' ) ) {
		if ( function_exists( 'has_site_icon' ) ) {
			if ( ! has_site_icon() ) {
				// Icon default
				$thim_favicon_src = get_template_directory_uri() . "/images/favicon.png";
				echo '<link rel="shortcut icon" href="' . esc_url( $thim_favicon_src ) . '" type="image/x-icon" />';

				return;
			}

			return;
		}
	}

	/**
	 * Support WordPress < 4.3
	 */
	$theme_options_data = thim_options_data();
	$thim_favicon_src   = '';
	if ( isset( $theme_options_data['thim_favicon'] ) ) {
		$thim_favicon       = $theme_options_data['thim_favicon'];
		$favicon_attachment = wp_get_attachment_image_src( $thim_favicon, 'full' );
		$thim_favicon_src   = $favicon_attachment[0];
	}
	if ( ! $thim_favicon_src ) {
		$thim_favicon_src = get_template_directory_uri() . "/images/favicon.png";
	}
	echo '<link rel="shortcut icon" href="' . esc_url( $thim_favicon_src ) . '" type="image/x-icon" />';

}

add_action( 'wp_head', 'thim_favicon' );


/**
 * Display post thumbnail by default
 *
 * @param $size
 */
function thim_default_get_post_thumbnail( $size ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'thim-framework/tp-framework.php' ) ) {
		return;
	}
	if ( get_the_post_thumbnail( get_the_ID(), $size ) ) {
		?>
		<div class='post-formats-wrapper'>
			<a class="post-image" href="<?php echo esc_url( get_permalink() ); ?>">
				<?php echo get_the_post_thumbnail( get_the_ID(), $size ); ?>
			</a>
		</div>
		<?php
	}
}

add_action( 'thim_entry_top', 'thim_default_get_post_thumbnail', 20 );


// Custom loading image for contact form 7
add_filter( 'wpcf7_ajax_loader', 'thim_wpcf7_ajax_loader' );
function thim_wpcf7_ajax_loader() {
	return THIM_URI . 'images/loading.gif';
}


add_action( 'thim_loading_logo', 'thim_loading_logo', 10 );
// loading logo
if ( ! function_exists( 'thim_loading_logo' ) ) :
	function thim_loading_logo() {
		$theme_options_data = get_theme_mods();
		$thim_logo_src      = get_template_directory_uri( 'template_directory' ) . "/images/loading.gif";
		if ( isset( $theme_options_data['thim_loading_logo'] ) && $theme_options_data['thim_loading_logo'] <> '' ) {
			$thim_logo_src = $theme_options_data['thim_loading_logo'];
			if ( is_numeric( $thim_logo_src ) ) {
				$logo_attachment = wp_get_attachment_image_src( $thim_logo_src, 'full' );
				$thim_logo_src   = $logo_attachment[0];
			}
		}
		echo '<img src="' . esc_url( $thim_logo_src ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" />';
	}
endif;


/**
 * BreadcrumbList
 * http://schema.org/BreadcrumbList
 */
function thim_breadcrumbs() {
	// Settings
	$separator        = '';
	$breadcrums_id    = 'thim_breadcrumbs';
	$breadcrums_class = 'thim-breadcrumbs';
	$home_title       = esc_html__( 'Home', 'charitywp' );

	// If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
	$custom_taxonomy_list = 'product_cat,dn_campaign_cat';

	// Get the query & post information
	global $post, $wp_query;
	// Do not display on the homepage
	if ( ! is_front_page() ) {
		// Build the breadcrums
		echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '" itemscope itemtype="http://schema.org/BreadcrumbList">';

		// Home page
		echo '<li class="item-home" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '"><span itemprop="name">' . $home_title . '</span></a></li>';
		echo '<li class="separator separator-home"> ' . $separator . ' </li>';

		if ( is_archive() && ! is_tax() && ! is_category() && ! is_tag() ) {

			echo '<li class="item-current item-archive" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span class="bread-current bread-archive" itemprop="name">' . esc_html__( 'All', 'charitywp' ) . ' ' . post_type_archive_title( '', false ) . '</span></li>';

		} else if ( is_archive() && is_tax() && ! is_category() && ! is_tag() ) {

			// If post is a custom post type
			$post_type = get_post_type();

			// If it is a custom post type display name and link
			if ( $post_type != 'post' ) {

				$post_type_object  = get_post_type_object( $post_type );
				$post_type_archive = get_post_type_archive_link( $post_type );

				echo '<li class="item-cat item-custom-post-type-' . $post_type . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '"><span itemprop="name">' . $post_type_object->labels->name . '</span></a></li>';
				echo '<li class="separator"> ' . $separator . ' </li>';

			}

			$custom_tax_name = get_queried_object()->name;
			echo '<li class="item-current item-archive" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" class="bread-current bread-archive">' . $custom_tax_name . '</span></li>';

		} else if ( is_single() ) {

			// If post is a custom post type
			$post_type = get_post_type();


			// If it is a custom post type display name and link
			if ( $post_type != 'post' ) {

				$post_type_object  = get_post_type_object( $post_type );
				$post_type_archive = get_post_type_archive_link( $post_type );
				$post_title        = $post_type_object->labels->name;

				if ( $post_type === 'tp_event' ) {
					$post_title = esc_html__( 'All Events', 'charitywp' );
				}

				echo '<li class="item-current item-cat item-custom-post-type-' . $post_type . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '"><span itemprop="name">' . $post_title . '</span></a></li>';

			}

			// Get post category info
			$category = get_the_category();

			if ( ! empty( $category ) ) {

				// Get last category post is in
				$last_category = end( ( array_values( $category ) ) );

				// Get parent any categories and create array
				$get_cat_parents = rtrim( get_category_parents( $last_category->term_id, true, ',' ), ',' );
				$cat_parents     = explode( ',', $get_cat_parents );

				// Loop through parent categories and store in variable $cat_display
				$cat_display = '';
				foreach ( $cat_parents as $parents ) {
					$cat_display .= '<li class="item-current item-cat" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . $parents . '</span></li>';
				}

			}

			// If it's a custom post type within a custom taxonomy
			$custom_taxonomys = explode( ',', $custom_taxonomy_list );

			foreach ( $custom_taxonomys as $key => $custom_taxonomy ) {
				$taxonomy_exists = taxonomy_exists( $custom_taxonomy );
				if ( empty( $last_category ) && ! empty( $custom_taxonomy ) && $taxonomy_exists ) {
					$taxonomy_terms       = get_the_terms( $post->ID, $custom_taxonomy );
					$taxonomy_terms_first = (array) $taxonomy_terms[0];
					$cat_id               = isset( $taxonomy_terms_first['term_id'] ) ? $taxonomy_terms_first['term_id'] : '';
					$cat_nicename         = isset( $taxonomy_terms_first['slug'] ) ? $taxonomy_terms_first['slug'] : '';
					if ( isset( $taxonomy_terms_first['term_id'] ) ) {
						$cat_link = get_term_link( $taxonomy_terms_first['term_id'], $custom_taxonomy );
					}
					$cat_name = isset( $taxonomy_terms_first['name'] ) ? $taxonomy_terms_first['name'] : '';
				}
			}


			// Check if the post is in a category
			if ( ! empty( $last_category ) ) {
				echo ent2ncr( $cat_display );

				// Else if post is in a custom taxonomy
			} else if ( ! empty( $cat_id ) ) {

				echo '<li class="separator"> ' . $separator . ' </li>';
				echo '<li class="item-current item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '"><span itemprop="name">' . $cat_name . '</span></a></li>';

			} else {
				if ( $post_type != 'tp_event' ) {
					echo '<li class="separator"> ' . $separator . ' </li>';
					echo '<li class="item-current item-' . $post->ID . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
				}
			}

		} else if ( is_category() ) {

			// Category page
			echo '<li class="item-current item-cat" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" class="bread-current bread-cat">' . single_cat_title( '', false ) . '</span></li>';

		} else if ( is_page() ) {

			if ( $post->post_parent ) {

				// If child page, get parents
				$anc = get_post_ancestors( $post->ID );

				// Get parents in the right order
				$anc = array_reverse( $anc );

				// Parent page loop
				$parents = '';
				foreach ( $anc as $ancestor ) {
					$parents .= '<li class="item-parent item-parent-' . $ancestor . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink( $ancestor ) . '" title="' . get_the_title( $ancestor ) . '"><span itemprop="name">' . get_the_title( $ancestor ) . '</span></a></li>';
					$parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
				}

				// Display parent pages
				echo ent2ncr( $parents );

				// Current page
				echo '<li class="item-current item-' . $post->ID . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . get_the_title() . '"> ' . get_the_title() . '</span></li>';

			} else {

				// Just display current page if not parents
				echo '<li class="item-current item-' . $post->ID . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</span></li>';

			}

		} else if ( is_tag() ) {

			// Tag page

			// Get tag information
			$term_id       = get_query_var( 'tag_id' );
			$taxonomy      = 'post_tag';
			$args          = 'include=' . $term_id;
			$terms         = get_terms( $taxonomy, $args );
			$get_term_id   = $terms[0]->term_id;
			$get_term_slug = $terms[0]->slug;
			$get_term_name = $terms[0]->name;

			// Display the tag name
			echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</span></li>';

		} elseif ( is_day() ) {

			// Day archive

			// Year link
			echo '<li class="item-year item-year-' . get_the_time( 'Y' ) . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" class="bread-year bread-year-' . get_the_time( 'Y' ) . '" href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( 'Y' ) . '"><span itemprop="name">' . get_the_time( 'Y' ) . esc_html__( ' Archives', 'charitywp' ) . '</span></a></li>';
			echo '<li class="separator separator-' . get_the_time( 'Y' ) . '"> ' . $separator . ' </li>';

			// Month link
			echo '<li class="item-month item-month-' . get_the_time( 'm' ) . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" class="bread-month bread-month-' . get_the_time( 'm' ) . '" href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '" title="' . get_the_time( 'M' ) . '"><span itemprop="name">' . get_the_time( 'M' ) . esc_html__( ' Archives', 'charitywp' ) . '</span></a></li>';
			echo '<li class="separator separator-' . get_the_time( 'm' ) . '"> ' . $separator . ' </li>';

			// Day display
			echo '<li class="item-current item-' . get_the_time( 'j' ) . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" class="bread-current bread-' . get_the_time( 'j' ) . '"> ' . get_the_time( 'jS' ) . ' ' . get_the_time( 'M' ) . esc_html__( ' Archives', 'charitywp' ) . '</span></li>';

		} else if ( is_month() ) {

			// Month Archive

			// Year link
			echo '<li class="item-year item-year-' . get_the_time( 'Y' ) . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" class="bread-year bread-year-' . get_the_time( 'Y' ) . '" href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( 'Y' ) . '"><span itemprop="name">' . get_the_time( 'Y' ) . esc_html__( ' Archives', 'charitywp' ) . '</span></a></li>';
			echo '<li class="separator separator-' . get_the_time( 'Y' ) . '"> ' . $separator . ' </li>';

			// Month display
			echo '<li class="item-month item-month-' . get_the_time( 'm' ) . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" class="bread-month bread-month-' . get_the_time( 'm' ) . '" title="' . get_the_time( 'M' ) . '">' . get_the_time( 'M' ) . esc_html__( ' Archives', 'charitywp' ) . ' </span></li>';

		} else if ( is_year() ) {

			// Display year archive
			echo '<li class="item-current item-current-' . get_the_time( 'Y' ) . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" class="bread-current bread-current-' . get_the_time( 'Y' ) . '" title="' . get_the_time( 'Y' ) . '">' . get_the_time( 'Y' ) . esc_html__( ' Archives', 'charitywp' ) . ' </span></li>';

		} else if ( is_author() ) {

			// Auhor archive

			// Get the author information
			global $author;
			$userdata = get_userdata( $author );

			// Display author name
			echo '<li class="item-current item-current-' . $userdata->user_nicename . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . esc_html__( 'Author: ', 'charitywp' ) . $userdata->display_name . '</span></li>';

		} else if ( get_query_var( 'paged' ) ) {

			// Paginated archives
			echo '<li class="item-current item-current-' . get_query_var( 'paged' ) . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" class="bread-current bread-current-' . get_query_var( 'paged' ) . '" title="Page ' . get_query_var( 'paged' ) . '">' . esc_html__( 'Page', 'charitywp' ) . ' ' . get_query_var( 'paged' ) . '</span></li>';

		} else if ( is_search() ) {

			// Search results page
			echo '<li class="item-current item-current-' . get_search_query() . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" class="bread-current bread-current-' . get_search_query() . '" title="Search results">' . esc_html__( 'Search results', 'charitywp' ) . '</span></li>';

		} elseif ( is_404() ) {

			// 404 page
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html__( '404 Error', 'charitywp' ) . '</span></li>';
		} elseif ( is_home() ) {

			// Blog page
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . wp_title( '', false, '' ) . '</span></li>';
		}

		echo '</ul>';

	}
}


function thim_ssl_secure_url( $sources ) {
	$scheme = parse_url( site_url(), PHP_URL_SCHEME );
	if ( 'https' == $scheme ) {
		if ( stripos( $sources, 'http://' ) === 0 ) {
			$sources = 'https' . substr( $sources, 4 );
		}

		return $sources;
	}

	return $sources;
}

function thim_ssl_secure_image_srcset( $sources ) {
	$scheme = parse_url( site_url(), PHP_URL_SCHEME );
	if ( 'https' == $scheme ) {
		foreach ( $sources as &$source ) {
			if ( stripos( $source['url'], 'http://' ) === 0 ) {
				$source['url'] = 'https' . substr( $source['url'], 4 );
			}
		}

		return $sources;
	}

	return $sources;
}

add_filter( 'wp_calculate_image_srcset', 'thim_ssl_secure_image_srcset' );
add_filter( 'wp_get_attachment_url', 'thim_ssl_secure_url', 1000 );
add_filter( 'image_widget_image_url', 'thim_ssl_secure_url' );


function thim_remove_script_version( $src ) {
	$parts = explode( '?ver', $src );

	return $parts[0];
}

add_filter( 'script_loader_src', 'thim_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'thim_remove_script_version', 15, 1 );


/**
 * Remove Emoji scripts
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );


function thim_display_loading() {
	$theme_options_data = get_theme_mods();
	if ( isset( $theme_options_data['thim_display_loading_show'] ) && true === $theme_options_data['thim_display_loading_show'] ): ?>
		<div class="thim-loading">
			<?php do_action( 'thim_loading_logo' ); ?>
		</div>
		<?php
	endif;
}

add_action( 'thim_loading', 'thim_display_loading', 10 );


function thim_header_toolbar_show() {
	$theme_options_data = get_theme_mods();
	if ( isset( $theme_options_data['thim_header_toolbar_show'] ) && true === $theme_options_data['thim_header_toolbar_show'] ): ?>
		<!-- toolbar/start -->
		<div class="toolbar-sidebar">
			<div class="container">
				<?php
				if ( is_active_sidebar( 'toolbar' ) ) {
					dynamic_sidebar( 'toolbar' );
				}
				?>
			</div>
		</div>
		<!-- toolbar/end -->
	<?php endif;
}

add_action( 'thim_header_toolbar', 'thim_header_toolbar_show', 10 );


function thim_header_site_style() {
	$theme_options_data = get_theme_mods();
	$menu_line          = isset( $theme_options_data['thim_header_menu_line'] ) ? $theme_options_data['thim_header_menu_line'] : '';
	?>
	<header id="masthead" class="site-header <?php echo esc_attr( $menu_line ) ?>">
		<?php if ( isset( $theme_options_data['thim_header_style'] ) && 'style2' === $theme_options_data['thim_header_style'] ): ?>
			<?php get_template_part( 'inc/header/header-style2' ); ?>
		<?php elseif ( isset( $theme_options_data['thim_header_style'] ) && 'style3' === $theme_options_data['thim_header_style'] ): ?>
			<?php get_template_part( 'inc/header/header-style3' ); ?>
		<?php elseif ( isset( $theme_options_data['thim_header_style'] ) && 'style4' === $theme_options_data['thim_header_style'] ): ?>
			<?php get_template_part( 'inc/header/header-style4' ); ?>
		<?php else: ?>
			<?php get_template_part( 'inc/header/header' ); ?>
		<?php endif; ?>
	</header>
	<?php
}

add_action( 'thim_header_site', 'thim_header_site_style', 10 );


function thim_rtl_support() {
	$theme_options_data = get_theme_mods();
	if ( isset( $theme_options_data['thim_rtl_support'] ) && $theme_options_data['thim_rtl_support'] == '1' ) {
		echo " dir=\"rtl\"";
	}
}

add_filter( 'language_attributes', 'thim_rtl_support', 10 );


function thim_site_layout() {
	$theme_options_data = get_theme_mods();
	$class_boxed        = '';
	if ( isset( $theme_options_data['thim_box_layout'] ) && $theme_options_data['thim_box_layout'] === 'boxed' ) {
		$class_boxed = 'boxed-area';
	}
	echo ent2ncr( $class_boxed );
}


function thim_back_to_top() {
	$theme_options_data = get_theme_mods();
	if ( isset( $theme_options_data['thim_show_to_top'] ) && $theme_options_data['thim_show_to_top'] == 1 ) { ?>
		<a id='back-to-top' class="scrollup show" title="<?php esc_attr_e( 'Go To Top', 'charitywp' ); ?>"></a>
	<?php }
}

// Remove metabox of portfolio plugin

if ( class_exists( 'THIM_Portfolio' ) ) {
	remove_filter( 'thim_meta_boxes', array( THIM_Portfolio::instance(), 'register_metabox' ), 20 );
	remove_action( 'admin_init', 'thim_register_meta_boxes' );

	/**
	 * Register meta boxes via a filter
	 * Advantages:
	 * - prevents incorrect hook
	 * - prevents duplicated global variables
	 * - allows users to remove/hide registered meta boxes
	 * - no need to check for class existences
	 *
	 * @return void
	 */
	function thim_extend_register_meta_boxes() {
		$meta_boxes = apply_filters( 'thim_meta_boxes', array() );
		foreach ( $meta_boxes as $meta_box ) {
			new Thim_Meta_Box( $meta_box );
		}
	}

	add_action( 'admin_init', 'thim_extend_register_meta_boxes' );

//	if( class_exists( 'THIM_Meta_Box' ) ) {
//		class Thim_Extend_Meta_Box extends THIM_Meta_Box {
//
//			/**
//			 * @var array Meta box information
//			 */
//			public $meta_box;
//
//			public function __construct( $args ) {
//				parent::__construct( $args );
//				remove_action('save_post', array($this, 'save_data'));
//				add_action('save_post', array($this, 'save_portfolio_data'));
//			}
//
//			// Save data from meta box
//			public function save_portfolio_data($post_id)
//			{
//				// verify nonce
//				if (!isset($_POST['thim_meta_box_nonce']) || !wp_verify_nonce($_POST['thim_meta_box_nonce'], basename(__FILE__))) {
//					return $post_id;
//				}
//				// check autosave
//				if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
//					return $post_id;
//				}
//				// check permissions
//				if ('page' == $_POST['post_type']) {
//					if (!current_user_can('edit_page', $post_id)) {
//						return $post_id;
//					}
//				} elseif (!current_user_can('edit_post', $post_id)) {
//					return $post_id;
//				}
//
//				foreach ($this->meta_box['fields'] as $field) {
//					$old = get_post_meta($post_id, $field['id'], true);
//					$new = $_POST[$field['id']];
//					if ($new && $new != $old) {
//						update_post_meta($post_id, $field['id'], $new);
//					} elseif ('' == $new && $old) {
//						delete_post_meta($post_id, $field['id'], $old);
//					}
//				}
//			}
//
//			// Callback function, uses helper function to print each meta box
//			public function meta_boxes_callback( $post, $fields ) {
//				$custom_field = array();
//				foreach ( $fields['args'] as $key => $field ) {
//					if ( $field['type'] == 'image' ) {
//						$custom_field[ $key ] = $field;
//						unset( $fields['args'][ $key ] );
//					}
//				}
//				parent::meta_boxes_callback( $post, $fields );
//				$fields['args'] = array_merge( $custom_field, $fields['args'] );
//				foreach ( $fields['args'] as $field ) {
//					if ( $field['type'] == 'single_image' ) {//continue;
//						$this->single_image( $field, $post->ID );
//					} elseif( $field['type'] == 'image' ) {
//						$this->images( $field, $post->ID );
//					}
//				}
//			}
//
//			private function images( $field, $post_id ) {
//
//				// Make sure scripts for new media uploader in WordPress 3.5 is enqueued
//				wp_enqueue_media();
//
//				wp_enqueue_style('thim-image', CORE_PLUGIN_URL . '/lib/meta-boxes/css/image.css', array(), "");
//				wp_enqueue_script('thim-image-js', CORE_PLUGIN_URL . '/lib/meta-boxes/js/image.js', array('jquery-ui-sortable'), "", true);
//
//
//				$images = get_post_meta($post_id, $field['id'], false);
//
//				$reorder_nonce = wp_create_nonce("thim-reorder-images_{$field['id']}");
//				$delete_nonce = wp_create_nonce("thim-delete-file_{$field['id']}");
//				$post_meta = get_post_meta($post_id, $field['id'], true);
//				if (isset($field['class'])) {
//					$extra_class = " " . $field['class'];
//				} else $extra_class = "";
//				echo '<div class="thim-field' . $extra_class . '">';
//
//				echo '<div class="thim-label"><label>' . $field['name'] . '</label></div>';
//
//				echo '<div class="thim-input">';
//				echo '<ul class="thim-images thim-uploaded ui-sortable" data-field_id="' . $field['id'] . '" data-reorder_nonce="' . $reorder_nonce . '" data-delete_nonce="' . $delete_nonce . '">';
//				foreach ($images as $image) {
//					$img_url = wp_get_attachment_image_src($image, 'thumbnail');
//					$link = get_edit_post_link($image);
//					echo '
//                    <li id="item_' . $image . '">
//                        <img src="' . $img_url[0] . '" />
//                        <div class="thim-image-bar">
//                            <a title="Edit" class="thim-edit-file" href="' . $link . '" target="_blank">Edit</a> |
//                            <a title="Delete" class="thim-delete-file" href="#" data-attachment_id="' . $image . '">×</a>
//                        </div>
//                    </li>
//                ';
//				}
//				echo '</ul>';
//				$attach_nonce = wp_create_nonce("thim-attach-media_" . $field['id']);
//				echo '<a href="#" class="button thim-image-advanced-upload hide-if-no-js new-files" data-attach_media_nonce="' . $attach_nonce . '">Select or Upload Images</a>';
//				echo '<div class="desc">' . $field['desc'] . '</div>';
//				echo '</div>';
//
//				echo '</div>';
//			}
//
//			private function single_image( $field, $post_id ) {
//				// Make sure scripts for new media uploader in WordPress 3.5 is enqueued
//				wp_enqueue_media();
//
//				wp_enqueue_style( 'thim-portfolio-image', THIM_URI . 'portfolio/css/image.css', array(), "" );
//				wp_enqueue_script( 'thim-portfolio-image-js', THIM_URI . 'portfolio/js/image.js', array( 'jquery-ui-sortable' ), "", true );
//
//
//				$images = get_post_meta( $post_id, $field['id'], false );
//
//				$reorder_nonce = wp_create_nonce( "thim-reorder-images_{$field['id']}" );
//				$delete_nonce  = wp_create_nonce( "thim-delete-file_{$field['id']}" );
//				$post_meta     = get_post_meta( $post_id, $field['id'], true );
//				if ( isset( $field['class'] ) ) {
//					$extra_class = " " . $field['class'];
//				} else {
//					$extra_class = "";
//				}
//				echo '<div class="thim-field' . $extra_class . '">';
//
//				echo '<div class="thim-label"><label>' . $field['name'] . '</label></div>';
//
//				echo '<div class="thim-input">';
//				echo '<ul class="thim-images thim-uploaded ui-sortable" data-field_id="' . $field['id'] . '" data-max_file_uploads="' . $field['max_file_uploads'] . '" data-reorder_nonce="' . $reorder_nonce . '" data-delete_nonce="' . $delete_nonce . '">';
//				foreach ( $images as $image ) {
//					$img_url = wp_get_attachment_image_src( $image, 'thumbnail' );
//					$link    = get_edit_post_link( $image );
//					echo '
//                    <li id="item_' . $image . '">
//                        <img src="' . $img_url[0] . '" />
//                        <div class="thim-image-bar">
//                            <a title="Edit" class="thim-edit-file" href="' . $link . '" target="_blank">Edit</a> |
//                            <a title="Delete" class="thim-delete-file" href="#" data-attachment_id="' . $image . '">×</a>
//                        </div>
//                    </li>
//                ';
//				}
//				echo '</ul>';
//				$attach_nonce = wp_create_nonce( "thim-attach-media_" . $field['id'] );
//				echo '<a href="#" class="button thim-single-image-upload hide-if-no-js new-files" data-attach_media_nonce="' . $attach_nonce . '">' . esc_html__( 'Select or Upload Images', 'charitywp' ) . '</a>';
//				echo '<div class="desc">' . $field['desc'] . '</div>';
//				echo '</div>';
//
//				echo '</div>';
//			}
//		}
//	}

	/**
	 * Register Portfolio Metabox
	 *
	 * @return array
	 * @since  1.0
	 */
	function register_metabox( $meta_boxes ) {
		$meta_boxes[] = array(
			'id'     => 'portfolio_settings',
			'title'  => esc_html__( 'Portfolio Settings', 'tp-portfolio' ),
			'pages'  => array( 'portfolio' ),
			'fields' => array(
				array(
					'name'    => esc_html__( 'Multigrid Size', 'tp-portfolio' ),
					'id'      => 'feature_images',
					'type'    => 'select',
					'desc'    => esc_html__( 'This config will working for portfolio layout style.', 'tp-portfolio' ),
					'std'     => 'Random',
					'options' => array(
						'random' => "Random",
						'size11' => "Size 1x1(480 x 320)",
						'size12' => "Size 1x2(480 x 640)",
						'size21' => "Size 2x1(960 x 320)",
						'size22' => "Size 2x2(960 x 640)"
					),
				),
				array(
					'name'     => esc_html__( 'Portfolio Type', 'tp-portfolio' ),
					'id'       => "selectPortfolio",
					'type'     => 'select',
					'options'  => array(
						'portfolio_type_image'        => __( 'Image', 'tp-portfolio' ),
						'portfolio_type_slider'       => __( 'Slider', 'tp-portfolio' ),
						'portfolio_type_video'        => __( 'Video', 'tp-portfolio' ),
					),
					// Select multiple values, optional. Default is false.
					'multiple' => false,
					'std'      => 'portfolio_type_image',
				),

				array(
					'name'     => esc_html__( 'Video', 'tp-portfolio' ),
					'id'       => 'project_video_type',
					'type'     => 'select',
					'class'    => 'portfolio_type_video',
					'options'  => array(
						'youtube' => 'Youtube',
						'vimeo'   => 'Vimeo',
					),
					'multiple' => false,
					'std'      => array( 'no' )
				),

				array(
					'name'  => esc_html__( "Video URL", 'tp-portfolio' ),
					'id'    => 'project_video_embed',
					'desc'  => wp_kses(
						__( "Just paste the url of the video (E.g. http://www.youtube.com/watch?v=GUEZCxBcM78 or https://vimeo.com/169395236) you want to show.<br /> <strong>Notice:</strong> The Preview Image will be the Image set as Featured Image..", 'tp-portfolio' ),
						array(
							'a'      => array(
								'href'  => array(),
								'title' => array()
							),
							'br'     => array(),
							'em'     => array(),
							'strong' => array(),
						)
					),
					'type'  => 'textarea',
					'class' => 'portfolio_type_video',
					'std'   => "",
					'cols'  => "40",
					'rows'  => "8"
				),

				array(
					'name'             => esc_html__( 'Upload Image', 'tp-portfolio' ),
					'desc'             => esc_html__( 'Upload an image. Notice: The Preview Image will be the Image set as Featured Image.', 'tp-portfolio' ),
					'id'               => 'project_item_slides',
					'type'             => 'image',
					'max_file_uploads' => 1,
					'class'            => 'portfolio_type_image portfolio_type_gallery portfolio_type_vertical_stacked',
				),

				array(
					'name'             => esc_html__( 'Upload Image', 'tp-portfolio' ),
					'desc'             => esc_html__( 'Upload the images for a slider - or only one to display a single image. Notice: The Preview Image will be the Image set as Featured Image.', 'tp-portfolio' ),
					'id'               => 'portfolio_image_sliders',
					'type'             => 'image_video',
					'class'            => 'portfolio_type_sidebar_slider portfolio_type_slider portfolio_type_left_floating_sidebar portfolio_type_right_floating_sidebar',
					'max_file_uploads' => 20,
				),
			)
		);

		return $meta_boxes;
	}

	add_filter( 'thim_meta_boxes', 'register_metabox', 20 );
}

function thim_portfolio_related() {
	$category = get_the_terms( get_the_ID(), 'portfolio_category' );
	?>
	<?php //Get Related posts by category	-->
	$category_id = isset( $category[0]->term_id ) ? $category[0]->term_id : '';
	$ids         = array( get_the_ID() );
	if ( $category_id != '' ) {
		$args = array(
			'posts_per_page' => 3,
			'post_type'      => 'portfolio',
			'post_status'    => 'publish',
			'post__not_in'   => array( get_the_ID() ),
			'tax_query'      => array(
				array(
					'taxonomy' => 'portfolio_category',
					'field'    => 'id',
					'terms'    => $category_id
				)
			)
		);
	} else {
		$args = array(
			'posts_per_page' => 3,
			'post_not_in'    => array( get_the_ID() ),
			'post_type'      => 'portfolio',
			'post_status'    => 'publish'
		);
	}
	$port_post = get_posts( $args );
	?>
	<?php if( count($port_post) > 0 ) : ?>
	<div class="related-portfolio col-md-12">
		<div class="module_title"><h3
				class="widget-title"><?php _e( 'VIEW OTHER RELATED ITEMS', 'charitywp' ); ?></h3>
		</div>
		<ul class="row">
			<?php
			foreach ( $port_post as $post ) : setup_postdata( $post );
				?>
				<li class="col-sm-4">
					<?php
					// check postfolio type
					$data_href = "";
					$imclass   = "";
					if ( get_post_meta( $post->ID, 'selectPortfolio', true ) == "portfolio_type_video" ) {
						$imclass = "video-popup";
						if ( get_post_meta( $post->ID, 'project_video_embed', true ) != "" ) {
							$imImage = get_post_meta( $post->ID, 'project_video_embed', true );
						} else if ( has_post_thumbnail( $post->ID ) ) {
							$image   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
							$imImage = $image[0];
						} else {
							$imclass  = "";
							$imImage  = get_permalink( $post->ID );
							$btn_text = "View More";
						}
					} else {
						$imclass = "image-popup-01";
						if ( has_post_thumbnail( $post->ID ) ) {// using thumb
							$image   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
							$imImage = $image[0];
						} else {// no thumb and no overide image
							$imclass  = "";
							$imImage  = get_permalink( $post->ID );
							$btn_text = "View More";
						}
					}
					/* end check portfolio type */

					$images_size = 'portfolio_size11';
					$image_id    = get_post_thumbnail_id( $post->ID );
					//$image_url = wp_get_attachment_image( $image_id, $images_size, false, array( 'alt' => get_the_title(), 'title' => get_the_title() ) );
					$dimensions = isset( $portfolio_data['thim_portfolio_option_dimensions'] ) ? $portfolio_data['thim_portfolio_option_dimensions'] : array();
					$w          = isset( $dimensions['width'] ) ? $dimensions['width'] : '480';
					$h          = isset( $dimensions['height'] ) ? $dimensions['height'] : '320';

					$crop       = true;
					$imgurl     = wp_get_attachment_image_src( $image_id, 'full' );
					$image_crop = $imgurl[0];
					if ( $imgurl[1] >= $w && $imgurl[2] >= $h ) {
						$image_crop = aq_resize( $imgurl[0], $w, $h, $crop );
					}
					$image_url = '<img src="' . $image_crop . '" alt="' . get_the_title() . '" title="' . get_the_title() . '" />';

					echo '<div class="portfolio-image">' . $image_url . '
					<div class="portfolio-hover"><div class="thumb-bg"><div class="mask-content">';
					echo '<span class="p_line"></span>';
					echo '<div class="portfolio_zoom"><a href="' . esc_url( $imImage ) . '" title="' . esc_attr( get_the_title( $post->ID ) ) . '" class="btn_zoom ' . $imclass . '" ' . $data_href . '><i class="fa fa-search"></i></a></div>';
					echo '<div class="portfolio_title"><h3><a href="' . esc_url( get_permalink( $post->ID ) ) . '" title="' . esc_attr( get_the_title( $post->ID ) ) . '" >' . get_the_title( $post->ID ) . '</a></h3></div>';
					echo '</div></div></div></div>';
					?>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php wp_reset_postdata(); ?>
	</div><!--#portfolio_related-->
	<?php endif;
}