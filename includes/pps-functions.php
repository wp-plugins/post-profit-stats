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
 if(is_user_logged_in() && current_user_can( 'author' ) || current_user_can( 'editor' ) || current_user_can( 'contributor' ) || is_user_logged_in() && current_user_can( 'administrator' ))  {    
     add_submenu_page( 'pps-settings-page', 'Author Detail Stats' , 'Author Detail Stats', 'read', 'pps-single-author', 'pps_single_author');
	  }  
 add_submenu_page( 'pps-settings-page', 'System Info' , 'Help / System Info', 'manage_options', 'pps-system-info-submenu-page', 'pps_system_info_page');
 add_submenu_page( 'pps-settings-page', '', 'Restart Tour', 'manage_options', 'pps-system-info-submenu-page', 'pps_system_info_page');
 
 		//table version check
	   //global $slickpps_table_version;
//	   $installed_table_ver = get_option( "slickpps_table_version" );
	   if(get_option( "slickpps_old_table_exists" ) != 'no_old_table_exists' or get_option( "slickpps_ent_old_table_exists" ) != 'no_old_table_exists') {
		   add_submenu_page( 'pps-settings-page', '', 'Update Database', 'manage_options', 'pps-upgrade-db-submenu-page', 'pps_upgrade_db_page');
	   }
	   else	{
	   	   remove_submenu_page( 'pps-settings-page', 'pps-upgrade-db-submenu-page');
	   }
	}
}
  
//setting options
function pps_register_mysettings() {
	// Enterprise Settings
	register_setting( 'myoption-group-pps', 'pps_ent_my_option_hosting_name' );
	register_setting( 'myoption-group-pps', 'pps_ent_my_option_database_name' );
	register_setting( 'myoption-group-pps', 'pps_ent_my_option_username' );
	register_setting( 'myoption-group-pps', 'pps_ent_my_option_db_password' );
	// FREE and Pro Settings
	register_setting( 'myoption-group-pps', 'my_option_name1');
	register_setting( 'myoption-group-pps', 'my_option_name2' );
	register_setting( 'myoption-group-pps', 'my_option_name3' );
	register_setting( 'myoption-group-pps', 'my_option_name4' );
	register_setting( 'myoption-group-pps', 'my_option_name55' );
	register_setting( 'myoption-group-pps', 'my_option_name9' );
	register_setting( 'myoption-group-pps', 'my_option_name10' );
	register_setting( 'myoption-group-pps', 'my_option_name11' );
	register_setting( 'myoption-group-pps', 'my_option_name12' );
	register_setting( 'myoption-group-pps', 'my_option_name13' );
 } 
add_action('admin_enqueue_scripts', 'pps_admin_css');
// THIS GIVES US SOME OPTIONS FOR STYLING THE ADMIN AREA
function pps_admin_css() {
    wp_register_style( 'pps_admin', plugins_url( 'admin/css/admin.css', dirname(__FILE__) ) );  
	wp_enqueue_style('pps_admin');
}
if (isset($_GET['page']) && $_GET['page'] == 'pps-system-info-submenu-page' || isset($_GET['page']) && $_GET['page'] == 'pps-upgrade-db-submenu-page' ) {
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
	 
	  wp_register_style( 'pps_admin_jquery_mobile_css', plugins_url( 'admin/js/jquery.mobile/jquery.mobile-1.4.2.min.css',  dirname(__FILE__) ) );
	  wp_enqueue_style('pps_admin_jquery_mobile_css');
	  
	  wp_enqueue_script( 'pps_admin_js_mobile', plugins_url( 'admin/js/jquery.mobile/jquery.mobile-1.4.2.min.js',  dirname(__FILE__) ) ); 
	  wp_enqueue_script( 'pps_admin_js_datepicker', plugins_url( 'admin/js/jquery.ui.datepicker.js',  dirname(__FILE__) ) ); 
	  wp_enqueue_script( 'pps_admin_js_mobile_datepicker', plugins_url( 'admin/js/jquery.mobile.datepicker.js',  dirname(__FILE__) ) ); 
	  
  }
}
function add_theme_caps() {
   $role = get_role( 'author' );
   $role->add_cap( 'read' );
}
add_action( 'admin_init', 'add_theme_caps');

/* Define the custom Post Profit Stats box on the post pages. */

// WP 3.0+
add_action( 'add_meta_boxes', 'post_options_metabox' );

// backwards compatible
add_action( 'admin_init', 'post_options_metabox', 1 );

/* Do something with the data entered */
// add_action( 'save_post', 'save_post_options' );

/**
 *  Adds a box to the main column on the Post edit screen
 * 
 */
function post_options_metabox() {
    add_meta_box( 'post_options', __( 'Post Profit Stats, Multiple Author\'s Link' ), 'pps_code_post_options', 'post', 'normal', 'high' );
}

/**
 *  Prints the box content
 */
function pps_code_post_options( $post ) { 
    wp_nonce_field( plugin_basename( __FILE__ ), $post->post_type . '_noncename' );
 ?>
<style type="text/css">
	.pps-inst-wrap  {
	}
	.pps-list-of-authors-wrap  {
		border-top:1px solid #eee;
		padding-top:0px;
	}
	ol.pps-list-of-authors li input {
		margin-top: 5px !important;
		margin-left: -17px;
	}
	ol.pps-list-of-authors li a  {
		text-decoration:none !important;
	}
	ol.pps-list-of-authors {
		margin-top:20px !important; 
	}
	ol.pps-list-of-authors li {
		margin-bottom:10px !important;
	}
</style>
     <p><strong>Assign as many authors as you want to this post and track the hits to that author, here's how it works.</strong></p>
     <div class="pps-inst-wrap">
         <ol class="pps-multiple-author-instructions">
             <li>Install the <a href="http://wordpress.org/plugins/co-authors-plus/" target="_blank">Co-Authors Plus</a> Plugin and assign all the authors you want to this post and publish the post.</li>
             <li>Now the Author or Admin can copy the link below (when co-authors plus plugin is active) to promote the post.</li>
          </ol>  <p><strong>Note: Only the first author in the list will get the hit count on this post if you don't use a custom tracking link.</strong></p> 
     </div> 
<?php if(is_plugin_active('co-authors-plus/co-authors-plus.php')) { ?>  
    <div class="pps-list-of-authors-wrap">
     <ol class="pps-list-of-authors">
       <?php 
			global $post;
			$ppsurl = get_permalink();
			$ppsurl = rtrim($ppsurl, '/');
        
			$authors = get_coauthors( $post->ID );

			$count = 1;
			foreach( $authors as $author ) :
				$args = array(
						'author_name' => $author->user_nicename,
					);
				if ( 'post' != $post->post_type )
					$args['post_type'] = $post->post_type;
				$author_filter_url = add_query_arg( $args, admin_url( 'edit.php' ) );
				?>
				<li><a href="<?php echo esc_url( $author_filter_url ); ?>"><?php echo esc_html( $author->display_name );?></a> | <a href="mailto:<?php echo esc_html( $author->user_email ); ?>"><?php echo esc_html( $author->user_email )?></a><br/><input type="text" readonly="readonly" class="pps_custom_permalink" name="_meta_info" value="<?php echo $ppsurl ?>/?ID=<?php echo esc_attr( $author->ID );?>" style="width:100%;" /><?php // echo ( $count < count( $authors ) ) ? ',' : ''; ?></li>
				<?php
				$count++;
			endforeach;
		  ?></ol>
         </div><!-- /pps-list-of-authors -->
<script type="application/javascript">
	jQuery(".pps_custom_permalink").on("click", function () {
		jQuery(this).select();
	});
</script>
 <?php
	} 
} // end if co-athours plus plugin is active
?>