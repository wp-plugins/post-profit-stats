<?php
/************************************************
 	Function file for pps
************************************************/



// This is our function we will fire when the restart tour button is clicked. You will need a new one for each Plugin tour you add.
/**************************************************************************************************************************************/
function pps_wp_pointers_remove() { // MUST CHANGE THIS NAME FOR EACH PLUGIN
   $user_meta = get_user_meta(get_current_user_id(), "dismissed_wp_pointers", TRUE);
   $user_key = 'postprofitstats_tour13'; // MUST CHANGE THIS NAME ON NEW UPDATES IF WE WANT A NEW TOUR
   $my_options = array(','.$user_key, $user_key.',', $user_key);
   
   $fixd_meta = str_replace($my_options, '', $user_meta);
	   if ($user_meta) {
			 update_user_meta(get_current_user_id(), 'dismissed_wp_pointers', $fixd_meta);
	}
  // Print meta data for testing to make sure the user key info is deleted. 
  // Test by clicking your close button on the pointer, then go to the plugins page, you should see the tour again.
  		// Uncomment the next 2 lines to see array coming from database under, user_meta / dismissed_wp_pointers
		// $meta_data_check = get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true);
 	   // echo Print_r ($meta_data_check);
}
add_action( 'wp_ajax_pps_wp_pointers_remove', 'pps_wp_pointers_remove' ); // MUST CHANGE THIS NAME FOR EACH PLUGIN


// Function to Fire the Activation/Deactivation Notes. This is only active when the pointer has not been closed.
function my_pps_activate() { // MUST CHANGE THIS NAME FOR EACH PLUGIN
  add_option( 'Activated_Plugin', 'Post-Profit-Stats' ); // MUST CHANGE THIS NAME FOR EACH PLUGIN
}
register_activation_hook( __FILE__, 'my_pps_activate' ); // MUST CHANGE THIS NAME FOR EACH PLUGIN

function load_pps() { // MUST CHANGE THIS NAME FOR EACH PLUGIN
    if ( is_admin()) {
        delete_option( 'Activated_Plugin', 'Post-Profit-Stats' ); // MUST CHANGE THIS NAME FOR EACH PLUGIN
        /* do stuff once right after activation */
        include_once dirname( __FILE__ ) . '/welcome-notes.php';
    }
}
add_action( 'admin_init', 'load_pps' ); // MUST CHANGE THIS NAME FOR EACH PLUGIN
// end activation notes
/**************************************************************************************************************************************/


if(is_admin()){
	add_action('admin_menu', 'pps_Main_Menu');
function pps_Main_Menu() {
	
//call register settings function to save my options
add_action( 'admin_init', 'pps_register_mysettings' ); 
// add custom name option
if(is_plugin_active('post-profit-stats-pro/post-profit-stats-pro.php')) {    
   $customPageName = get_option('my_option_name55');
	 if ($customPageName == ' ' || $customPageName == '') {  
	  $customPageName = 'Post Profit Stats';	
	  }    
	  else { $customPageName = get_option('my_option_name55'); }
}
else {  $customPageName = 'Post Profit Stats'; }

 add_menu_page($customPageName, $customPageName, 'manage_options', 'pps-settings-page', 'pps_settings_page', 'div', 98);
 add_submenu_page( 'pps-settings-page', 'Authors Total Stats' , 'Authors Total Stats', 'manage_options', 'pps-settings-page', 'pps_settings_page');
 // only show the menu option if the user is an author
 if(is_user_logged_in() && current_user_can( 'author' ) || is_user_logged_in() && current_user_can( 'administrator' ))  {    
     add_submenu_page( 'pps-settings-page', 'Author Detail Stats' , 'Author Detail Stats', 'read', 'pps-single-author', 'pps_single_author');
	  }  
 add_submenu_page( 'pps-settings-page', 'System Info' , 'Help / System Info', 'manage_options', 'pps-system-info-submenu-page', 'pps_system_info_page');
 add_submenu_page( 'pps-settings-page', '', 'Restart Tour', 'manage_options', 'pps-system-info-submenu-page', 'pps_system_info_page');
  
	}
}
  
//setting options
function pps_register_mysettings() {
	register_setting( 'myoption-group-pps', 'my_option_name1');
	register_setting( 'myoption-group-pps', 'my_option_name2' );
	register_setting( 'myoption-group-pps', 'my_option_name3' );
	register_setting( 'myoption-group-pps', 'my_option_name4' );
	register_setting( 'myoption-group-pps', 'my_option_name5' );
	register_setting( 'myoption-group-pps', 'my_option_name55' );
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