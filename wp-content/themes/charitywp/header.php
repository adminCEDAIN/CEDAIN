<?php
	/**
	 * The Header for our theme.
	 *
	 * Displays all of the <head> section and everything up till <div id="content">
	 *
	 * @package thim
	 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php esc_url( bloginfo( 'pingback_url' ) ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<?php do_action('thim_loading'); ?>
	
	<?php get_template_part( 'inc/header/main-menu' ); ?>
	
	<div id="wrapper-container" class="wrapper-container">
		<div class="content-pusher <?php thim_site_layout() ?>">

				<?php if ( !(is_page() && basename(get_page_template()) == 'comingsoon.php') ) : ?>

					<?php do_action('thim_header_toolbar'); ?>

					<?php do_action('thim_header_site'); ?>

				<?php endif; ?>
				<div id="main-content">