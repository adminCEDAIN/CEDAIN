<?php 
	$theme_options_data = get_theme_mods(); 
	$menu_line 		= isset($theme_options_data['thim_header_menu_line']) ? $theme_options_data['thim_header_menu_line'] : '';
	$mobile_line 	= isset($theme_options_data['thim_header_mobilemenu_line']) ? $theme_options_data['thim_header_mobilemenu_line'] : '';
?>
<div class="thim-menu <?php echo esc_attr($menu_line) ?> <?php echo esc_attr($mobile_line) ?>">
	<span class="close-menu"><i class="fa fa-times"></i></span>
	<div class="main-menu">
		<ul class="nav navbar-nav">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'items_wrap'     => '%3$s'
				) );
			} else {
				wp_nav_menu( array(
					'theme_location' => '',
					'container'      => false,
					'items_wrap'     => '%3$s'
				) );
			}
			?>
		</ul>
	</div>
	<div class="menu-sidebar thim-hidden-768px">
		<?php 
			if ( is_active_sidebar( 'menu_sidebar' ) ) { 
				dynamic_sidebar( 'menu_sidebar' ); 
			} 
		?>
	</div>  
</div>