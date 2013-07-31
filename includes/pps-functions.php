<?php
/************************************************
 	Function file for pps
************************************************/
if(is_admin()){
	add_action('admin_menu', 'pps_Main_Menu');
function pps_Main_Menu() {
//call register settings function to save my options
add_action( 'admin_init', 'pps_register_mysettings' ); 
add_menu_page('Post Profit Stats', 'Post Profit Stats', 'manage_options', 'pps-settings-page', 'pps_settings_page', 'div', 98);
add_submenu_page( 'pps-settings-page', 'Authors Total Stats' , 'Authors Total Stats', 'manage_options', 'pps-settings-page', 'pps_settings_page');
add_submenu_page( 'pps-settings-page', 'Author Detail Stats' , 'Author Detail Stats', 'read', 'pps-single-author', 'pps_single_author');
add_submenu_page( 'pps-settings-page', 'System Info' , 'Help / System Info', 'manage_options', 'pps-system-info-submenu-page', 'pps_system_info_page');
	}
}
//setting options
function pps_register_mysettings() {
	register_setting( 'myoption-group-pps', 'my_option_name1');
	register_setting( 'myoption-group-pps', 'my_option_name2' );
	register_setting( 'myoption-group-pps', 'my_option_name3' );
	register_setting( 'myoption-group-pps', 'my_option_name4' );
	register_setting( 'myoption-group-pps', 'my_option_name5' );
	register_setting( 'myoption-group-pps', 'my_option_name6' );
	register_setting( 'myoption-group-pps', 'my_option_name7' );
	register_setting( 'myoption-group-pps', 'my_option_name8' );
	register_setting( 'myoption-group-pps', 'my_option_name9' );
	register_setting( 'myoption-group-pps', 'my_option_name10' );
	register_setting( 'myoption-group-pps', 'my_option_name11' );
 } 
add_action('admin_enqueue_scripts', 'pps_admin_css');
// THIS GIVES US SOME OPTIONS FOR STYLING THE ADMIN AREA
function pps_admin_css() {
    wp_register_style( 'pps_admin', plugins_url( 'admin/css/admin.css', dirname(__FILE__) ) );  
	wp_enqueue_style('pps_admin');
}
if (isset($_GET['page']) && $_GET['page'] == 'pps-system-info-submenu-page') {
  add_action('admin_enqueue_scripts', 'pps_system_info_css');
  // THIS GIVES US SOME OPTIONS FOR STYLING THE ADMIN AREA
  function pps_system_info_css() {
	  wp_register_style( 'pps_settings_admin_css', plugins_url( 'admin/css/admin-settings.css',  dirname(__FILE__) ) );
	  wp_enqueue_style('pps_settings_admin_css'); 
  }
}
if (isset($_GET['page']) && $_GET['page'] == 'pps-settings-page' || isset($_GET['page']) && $_GET['page'] == 'pps-single-author')   {
  add_action('admin_enqueue_scripts', 'pps_settings');
  // THIS GIVES US SOME OPTIONS FOR STYLING THE ADMIN AREA
  function pps_settings() {
	  wp_register_style( 'pps_settings_css', plugins_url( 'admin/css/settings-page.css',  dirname(__FILE__) ) );
	  wp_enqueue_style('pps_settings_css'); 
	 // wp_enqueue_script( 'pps_settings_js', plugins_url( 'admin/js/admin.js',  dirname(__FILE__) ) ); 
  }
}
function add_theme_caps() {
   $role = get_role( 'author' );
   $role->add_cap( 'read' );
}
add_action( 'admin_init', 'add_theme_caps');
?>