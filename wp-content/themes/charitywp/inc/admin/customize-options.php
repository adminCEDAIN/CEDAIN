<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of customizer-options
 *
 * @author Tuannv
 */
require_once( THIM_DIR . "inc/admin/generate-less-to-css.php" );

class Thim_Customize_Options {

	function __construct() {
		add_action( 'tf_create_options', array( $this, 'create_customizer_options' ) );
		add_action( 'customize_save_after', array( $this, 'generate_to_css' ) );

		/* Unregister Default Customizer Section */
		add_action( 'customize_register', array( $this, 'unregister' ) );
	}

	function unregister( $wp_customize ) {

		$wp_customize->remove_section( 'colors' );
		$wp_customize->remove_section( 'background_image' );
		$wp_customize->remove_section( 'nav' );

	}

	function create_customizer_options() {
		$titan                                       = TitanFramework::getInstance( 'thim' );
		TitanFrameworkOptionFontColor::$webSafeFonts = array(
			'Arial, Helvetica, sans-serif'                         => 'Arial',
			'"Arial Black", Gadget, sans-serif'                    => 'Arial Black',
			'"Comic Sans MS", cursive, sans-serif'                 => 'Comic Sans',
			'"Courier New", Courier, monospace'                    => 'Courier New',
			'Georgia, serif'                                       => 'Geogia',
			'Impact, Charcoal, sans-serif'                         => 'Impact',
			'"Lucida Console", Monaco, monospace'                  => 'Lucida Console',
			'"Lucida Sans Unicode", "Lucida Grande", sans-serif'   => 'Lucida Sans',
			'"Palatino Linotype", "Book Antiqua", Palatino, serif' => 'Palatino',
			'Tahoma, Geneva, sans-serif'                           => 'Tahoma',
			'"Times New Roman", Times, serif'                      => 'Times New Roman',
			'"Trebuchet MS", Helvetica, sans-serif'                => 'Trebuchet',
			'Verdana, Geneva, sans-serif'                          => 'Verdana',
		);
		/* Register Customizer Sections */
		//include heading
		include THIM_DIR . "/inc/admin/customizer-sections/logo.php";
		include THIM_DIR . "/inc/admin/customizer-sections/header.php";
		include THIM_DIR . "/inc/admin/customizer-sections/header-settings.php";
		include THIM_DIR . "/inc/admin/customizer-sections/header-sticky-settings.php";
		include THIM_DIR . "/inc/admin/customizer-sections/header-toolbar.php";
		include THIM_DIR . "/inc/admin/customizer-sections/header-submenu.php";
		include THIM_DIR . "/inc/admin/customizer-sections/header-menu.php";
		include THIM_DIR . "/inc/admin/customizer-sections/header-mobile-menu.php";

		//include styling
		include THIM_DIR . "/inc/admin/customizer-sections/styling.php";
		include THIM_DIR . "/inc/admin/customizer-sections/styling-layout.php";
		include THIM_DIR . "/inc/admin/customizer-sections/styling-color.php";
		include THIM_DIR . "/inc/admin/customizer-sections/styling-pattern.php";
		include THIM_DIR . "/inc/admin/customizer-sections/styling-rtl.php";

		//include display setting
		include THIM_DIR . "/inc/admin/customizer-sections/display.php";
		include THIM_DIR . "/inc/admin/customizer-sections/display-archive.php";
		include THIM_DIR . "/inc/admin/customizer-sections/display-frontpage.php";
		include THIM_DIR . "/inc/admin/customizer-sections/display-page.php";
		include THIM_DIR . "/inc/admin/customizer-sections/display-post.php";
		include THIM_DIR . "/inc/admin/customizer-sections/display-404.php";
		include THIM_DIR . "/inc/admin/customizer-sections/display-sharing.php";
		include THIM_DIR . "/inc/admin/customizer-sections/display-loading.php";

		//include woocommerce
		if ( class_exists( 'WooCommerce' ) ) {
			include THIM_DIR . "/inc/admin/customizer-sections/woocommerce.php";
			include THIM_DIR . "/inc/admin/customizer-sections/woocommerce-archive.php";
			include THIM_DIR . "/inc/admin/customizer-sections/woocommerce-setting.php";
			include THIM_DIR . "/inc/admin/customizer-sections/woocommerce-sharing.php";
			include THIM_DIR . "/inc/admin/customizer-sections/woocommerce-single.php";
		}
		//include typography
		include THIM_DIR . "/inc/admin/customizer-sections/typography.php";

		//include footer
		include THIM_DIR . "/inc/admin/customizer-sections/footer.php";
		include THIM_DIR . "/inc/admin/customizer-sections/footer-copyright.php";

		//include Custom Css
		include THIM_DIR . "/inc/admin/customizer-sections/custom-css.php";
		//include Import/Export
		include THIM_DIR . "/inc/admin/customizer-sections/import-export.php";
		// Coming soon
		include THIM_DIR . "/inc/admin/metabox-sections/comingsoon.php";

		include THIM_DIR . "/inc/admin/customizer-sections/support.php";

		//include woocommerce
		if ( class_exists( 'THIM_Our_Team' ) ) {
			include THIM_DIR . "/inc/admin/customizer-sections/our-team.php";
			include THIM_DIR . "/inc/admin/customizer-sections/our-team-setting.php";
		}

		//include Event
		if ( class_exists( 'TP_Event' ) ) {
			include THIM_DIR . "/inc/admin/customizer-sections/event.php";
			include THIM_DIR . "/inc/admin/customizer-sections/event-sharing.php";
		}

		//include Donate
		if ( class_exists( 'ThimPress_Donate' ) ) {
			include THIM_DIR . "/inc/admin/customizer-sections/donate.php";
			include THIM_DIR . "/inc/admin/customizer-sections/donate-sharing.php";
		}

		//include Portfolio
		if( class_exists('THIM_Portfolio') ) {
			include THIM_DIR . "/inc/admin/customizer-sections/portfolio.php";
			include THIM_DIR . "/inc/admin/customizer-sections/portfolio-archive.php";
			include THIM_DIR . "/inc/admin/customizer-sections/portfolio-single.php";
		}

	}

	function generate_to_css() {
		$options = get_theme_mods();
		thim_options_variation( $options );
		thim_generate( THIM_DIR . 'style', '.css', $options );
	}
}

new Thim_Customize_Options();