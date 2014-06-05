<?php
/*
Plugin Name: Post Profit Stats
Plugin URI: http://slickremix.com/
Description: Do you pay authors for page views? Let our plugin calculate the amount per post view and give you totals by date.
Version: 1.0.9
Author: SlickRemix
Author URI: http://slickremix.com/
Requires at least: wordpress 3.4.0
Tested up to: wordpress 3.9.1
Stable tag: 1.0.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

 * @package    			Post Profit Stats
 * @category   			extension
 * @author     		    SlickRemix
 * @copyright  			Copyright (c) 2014 SlickRemix

If you need support or want to tell us thanks please contact us at info@slickremix.com or use our support forum on slickremix.com
This is the main file for building the plugin into wordpress

*/

include( 'updates/update-functions.php' );

define( 'PPS_PLUGIN_PATH', plugins_url() ) ;
global $wpdb;
//Old Table
global $pps_old_table_name;
$pps_old_table_name = $wpdb->prefix . "slick_post_profit_stats";

//New Table
global $pps_new_table_name;
$pps_new_table_name = $wpdb->prefix . "slick_post_profit_stats2";

//Table Version
add_option( "slickpps_table_version", "2.0" );

//Table Version
global $slickpps_table_version;
$slickpps_table_version = "2.0";

add_option( "slickpps_old_table_exists", "no_old_table_exists" );
// enterprise version add_option
add_option( "slickpps_ent_old_table_exists", "no_old_table_exists" );

// Commenting out becase don't think we are using this anymore
//add_option( "slickpps_db_version", "3.5" );

//Database Version
// global $slickpps_db_version;
// $slickpps_db_version = "2.0";

// Include admin
include( 'admin/pps-system-info.php' );
include( 'admin/pps-settings-page.php' );
include( 'admin/pps-single-author.php' );
include( 'admin/pps-upgrade-db.php' );
include( 'updates/update-functions.php' );


// Include core files and classes
include( 'includes/pps-functions.php' );

//Update Database page.

// Include Leave feedback, Get support and Plugin info links to plugin activation and update page.
add_filter("plugin_row_meta", "pps_add_leave_feedback_link", 10, 2);

	function pps_add_leave_feedback_link( $links, $file ) {
		if ( $file === plugin_basename( __FILE__ ) ) {
			$links['feedback'] = '<a href="http://wordpress.org/support/view/plugin-reviews/post-profit-stats" target="_blank">' . __( 'Leave feedback', 'gd_quicksetup' ) . '</a>';
			$links['support']  = '<a href="http://www.slickremix.com/support-forum/wordpress-plugins-group3/post-profit-stats-forum11/" target="_blank">' . __( 'Get support', 'gd_quicksetup' ) . '</a>';
			$links['plugininfo']  = '<a href="plugin-install.php?tab=plugin-information&plugin=post-profit-stats&section=changelog&TB_iframe=true&width=640&height=423" class="thickbox">' . __( 'Plugin info', 'gd_quicksetup' ) . '</a>';
		}
		return $links;
	}
// Include our own Settings link to plugin activation and update page.
add_filter("plugin_action_links_".plugin_basename(__FILE__), "pps_plugin_actions", 10, 4);

	function pps_plugin_actions( $actions, $plugin_file, $plugin_data, $context ) {
		array_unshift($actions, "<a href=\"".menu_page_url('pps-settings-page', false)."\">".__("Settings")."</a>");
		return $actions;
}

/**
 * Returns current plugin version. SRL added
 * 
 * @return string Plugin version
 */
function ppssystem_version() {
	$plugin_data = get_plugin_data( __FILE__ );
	$plugin_version = $plugin_data['Version'];
	return $plugin_version;
}

$pluginURI = get_option('siteurl').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__)); 

// Here starts our DB install and upgrade check if required, change the DB version and the upgrade db area and that's it


function slick_post_profit_stats5_db_install () {
	global $wpdb, $slickpps_db_version,$pps_new_table_name, $pps_old_table_name;
	
	if($wpdb->get_var("SHOW TABLES LIKE '$pps_old_table_name'") == $pps_old_table_name) {
		update_option( "slickpps_old_table_exists", "old_table_exists" );
	}
	else	{
		update_option( "slickpps_old_table_exists", "no_old_table_exists" );
	}


	if($wpdb->get_var("show tables like '$pps_new_table_name'") != $pps_new_table_name) {
	// install the db
	$slicksql = "CREATE TABLE IF NOT EXISTS `$pps_new_table_name` (
	post_id int(11) NOT NULL,
	post_author int(11) NOT NULL,
	create_date varchar(20) NOT NULL,
	hit_count bigint NOT NULL,
	chrome_views bigint NOT NULL,
	safari_views bigint NOT NULL,
	firefox_views bigint NOT NULL,
	opera_views bigint NOT NULL,
	ie_views bigint NOT NULL,
	unknown_views bigint NOT NULL,
	desktop_views bigint NOT NULL,
	mobile_views bigint NOT NULL,
	tablet_views bigint NOT NULL,
	console_views bigint NOT NULL,
	PRIMARY KEY  (`post_id`,`post_author`,`create_date`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1";
	
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta( $slicksql );
	// Commenting out becase don't think we are using this anymore
	// add_option( "slickpps_db_version", $slickpps_db_version );
	}

} // END slick_post_profit_stats5_db_install

register_activation_hook(__FILE__,'slick_post_profit_stats5_db_install');

//Table Version Error
$installed_table_ver = get_option( "slickpps_table_version" );
	
if($installed_table_ver != $slickpps_table_version && get_option( "slickpps_old_table_exists" ) != 'no_old_table_exists') {
	//Database Upgrade notice
	add_action( 'admin_notices', 'pps_upgrade_db_notice' );
	function pps_upgrade_db_notice() {
		
		  echo '<div class="error"><p>' . __( 'Warning: The <strong>Post Profit Stats</strong> plugin needs to UPDATE THE DATABASE <a href="admin.php?page=pps-upgrade-db-submenu-page"><strong>Click here to go to update Page.</strong></a> ', 'my-theme' ) . '</p></div>';
	  }
}

// Add our ajax url and jquery for the hit count on the front end
function my_slick_pps_script_enqueuer() {
   // nothing in this script yet, just prepped for future use.	
   wp_register_script( "my_ppsChecker_script", WP_PLUGIN_URL.'/post-profit-stats/admin/js/my_ppsChecker_script.js', array('jquery') );
   wp_localize_script( 'my_ppsChecker_script', 'myPPSAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        

   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'my_ppsChecker_script' );

}
add_action( 'init', 'my_slick_pps_script_enqueuer' );
	

// add the hit-function to the footer of the single pages
 function add_js_to_wp_footer(){ 
   if(is_single()) {
		require_once(ABSPATH . 'wp-content/plugins/post-profit-stats/includes/hit-function.php');
	}
 }
 add_action( 'wp_footer', 'add_js_to_wp_footer' );


// Ajax on the front end Fires this for new counts to the database
function view_site_description(){
	global $post,$wpdb, $pps_new_table_name;
	
	// This contains the browser and device check			
	require_once(ABSPATH . 'wp-content/plugins/post-profit-stats/includes/browser-stats-functions.php');
			
		$create_date = date_i18n('Y-m-d');
		$current_user = wp_get_current_user();
		$user_role = $current_user->roles[0];
			
		if ($user_role != 'author' && $user_role != 'administrator' && $user_role != 'uploader' && $user_role != 'editor' && $user_role != 'contributor') {	
				$insert = "INSERT IGNORE INTO " . $pps_new_table_name . "( post_id, post_author, create_date, hit_count, {$browser_column}, {$device_column} ) VALUES (" . $_POST['post_id'] . ",'" . $_POST['post_author'] . "','" . $create_date . "','1','1','1') 
				ON DUPLICATE KEY UPDATE hit_count=hit_count + 1, {$browser_column}= {$browser_column} + 1, {$device_column}= {$device_column} + 1 
				";
				$results = $wpdb->query($wpdb->prepare($insert));
				$wpdb->show_errors();
			}
		 
		die();
	}
	 add_action( 'wp_ajax_view_site_description', 'view_site_description' );
	 add_action( 'wp_ajax_nopriv_view_site_description', 'view_site_description' );
	 
	 
	 
/**
 * Display memory useage
 *
 * @example
 * $before = get_memory_usage();
 * // run the function/whatever
 * // Then echo the function and drop the value from {$before} in it
 * get_memory_usage( $before );
 *
 * @param (integer) $before | The memory useage before the tracked function
 * @return (string) $result | The needed memory
 */
function pps_get_memory_usage( $before = '' )
{
    $mem_usage = memory_get_usage( true );
 
    // get resulting useage
    $diff_usage = $mem_usage - $before;
 
    // prepare output for easier reading
    if  ( $diff_usage < 1024 )
    {
        $result = $diff_usage.' bytes';
    }
    elseif ( $diff_usage < 1048576 )
    {
        $result = round( $diff_usage / 1024,2 ).' kB';
    }
    else
    {
        $result = round( $diff_usage / 1048576,2 ).' MB';
    }
 
    return $result;
}	 
	 
	 
function merge_pps_old_new_dbs(){
	
			if(is_plugin_active('post-profit-stats-ent/post-profit-stats-ent.php')) {  
				global $slickpps_db, $slickpps_ent_table_name_new, $slickpps_ent_table_name_old;
								
				// upgrade the db if required
				 $insert = "INSERT IGNORE INTO $slickpps_ent_table_name_new (post_id, post_author, create_date, hit_count, unknown_views, desktop_views)
					 select post_id, post_author, create_date, count(*) as hit_count, count(*) as unknown_views, count(*) as desktop_views
					 from $slickpps_ent_table_name_old
					 GROUP by post_id, post_author, create_date
					 ";
					 
				  $final_merge_array = array();
				  $results = $slickpps_db->query($insert);
				  
					  // Fail -- the "===" operator compares type as well as value
					  if ($results === false)	{
						  $final_merge_array['status'] = 'Failed';
						  $final_merge_array['rows'] = '0';
						  $final_merge_array['memory_used'] = pps_get_memory_usage();
					  }
					  // Success, but no rows were updated
					  if ($results === 0){
						   $final_merge_array['status'] = 'Success';
						   $final_merge_array['rows'] = '0';
						   $final_merge_array['memory_used'] = pps_get_memory_usage();
					  }
					  // Success, and updates were done. $result is the number of affected rows.
					  if ($results > 0){
						   $final_merge_array['status'] = 'Success';
						   $final_merge_array['rows'] = $results;
						   $final_merge_array['memory_used'] = pps_get_memory_usage();
					  }
				  
				return $final_merge_array;
			}
	
			else {
				global $wpdb, $pps_old_table_name, $pps_new_table_name;
				
				// upgrade the db if required
				 $insert = "INSERT IGNORE INTO $pps_new_table_name (post_id, post_author, create_date, hit_count, unknown_views, desktop_views)
					 select post_id, post_author, create_date, count(*) as hit_count, count(*) as unknown_views, count(*) as desktop_views
					 from $pps_old_table_name
					 GROUP by post_id, post_author, create_date
					 ";
					 
				  $final_merge_array = array();
				  $results = $wpdb->query($insert);
				  
					  // Fail -- the "===" operator compares type as well as value
					  if ($results === false)	{
						  $final_merge_array['status'] = 'Failed';
						  $final_merge_array['rows'] = '0';
						  $final_merge_array['memory_used'] = pps_get_memory_usage();
					  }
					  // Success, but no rows were updated
					  if ($results === 0){
						   $final_merge_array['status'] = 'Success';
						   $final_merge_array['rows'] = '0';
						   $final_merge_array['memory_used'] = pps_get_memory_usage();
					  }
					  // Success, and updates were done. $result is the number of affected rows.
					  if ($results > 0){
						   $final_merge_array['status'] = 'Success';
						   $final_merge_array['rows'] = $results;
						   $final_merge_array['memory_used'] = pps_get_memory_usage();
					  }
				  
				return $final_merge_array;
			}	  			
	}
?>