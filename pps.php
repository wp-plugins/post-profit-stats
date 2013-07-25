<?php
/*
Plugin Name: Post Profit Stats
Plugin URI: http://slickremix.com/
Description: Do you pay authors for page views? Let our plugin calculate the amount per post view and give you totals by date.
Version: 1.0.0
Author: SlickRemix
Author URI: http://slickremix.com/
Requires at least: wordpress 3.4.0
Tested up to: wordpress 3.5.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

 * @package    			Post Profit Stats
 * @category   			extenstion
 * @author     		    SlickRemix
 * @copyright  			Copyright (c) 2013 SlickRemix

If you need support or want to tell us thanks please contact us at info@slickremix.com or use our support forum on slickremix.com
This is the main file for building the plugin into wordpress

*/

define( 'PPS_PLUGIN_PATH', plugins_url() ) ;

// Include admin
include( 'admin/pps-system-info.php' );
include( 'admin/pps-settings-page.php' );
include( 'admin/pps-single-author.php' );

// Include core files and classes
include( 'includes/pps-functions.php' );

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

add_action('wp_head','pluginname_ajaxurl');

add_option( "slickpps_db_version", "2.0" );

global $slickpps_db_version;
$slickpps_db_version = "2.0";

function slick_post_profit_work_db_install () {
	global $wpdb;
	global $slickpps_db_version;

	$table_name = $wpdb->prefix . "slick_post_profit_work";

	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {

	$slicksql = "CREATE TABLE `$table_name` (
	`id` bigint(20) NOT NULL auto_increment,
	`post_id` int(11) NOT NULL,
	`post_author` int(11) NOT NULL,
	`created_at` varchar(20) NOT NULL,
	`create_date` varchar(20) default NULL,
	PRIMARY KEY  (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($slicksql);
	
	add_option( "slickpps_db_version", $slickpps_db_version );
	}
}

register_activation_hook(__FILE__,'slick_post_profit_work_db_install');


function add_js_to_wp_footer(){ 
if(is_single())
	{
?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		
		var postID = '<?php echo the_ID(); ?>';
		console.log(postID);
		var postAuthor = '<?php echo the_author_meta('ID') ?>';
		console.log(postAuthor);
		var createdAt = '<?php echo time(); ?>';
		console.log(createdAt);
		var createdDate = '<?php echo date('Y-m-d'); ?>';
		console.log(createdDate);

		jQuery.ajax({
			type: 'POST',
            url: ajaxurl,
			data: {action: "view_site_description", post_id: postID, post_author: postAuthor, created_at: createdAt, created_date: createdDate  },
			success: function(data){
				// alert(data);
				 console.log('Count Processed')
				 return data; 
				} 
		});
	return false;
	});
</script>
<?php } }

function pluginname_ajaxurl() { ?>
	<script type="text/javascript">
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
<?php }

add_action( 'wp_footer', 'add_js_to_wp_footer' ); ?>
<?php function view_site_description(){
	
	global $post,$wpdb;
	 
		$current_user = wp_get_current_user();
		$user_role = $current_user->roles[0];
		if ( $user_role != 'administrator' ) {
			$table_name = $wpdb->prefix . "slick_post_profit_work";
			$insert = "INSERT INTO " . $table_name . "( post_id, post_author, created_at, create_date ) VALUES (" . $_POST['post_id'] . ",'" . $_POST['post_author'] . "', '" . $_POST['created_at'] . "','" . $_POST['created_date'] ."')";
			$results = $wpdb->query( $insert );
			if($results) $msg = "Updated";
		}
	 
	  echo "Updated";
	die();
}
 add_action( 'wp_ajax_view_site_description', 'view_site_description' );
 add_action( 'wp_ajax_nopriv_view_site_description', 'view_site_description' );
 ?>