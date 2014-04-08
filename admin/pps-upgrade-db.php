<?php
function pps_upgrade_db_page(){
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
?>

<div class="pps-help-admin-wrap">
  <h2>Post Profit Stats, Upgrade Database</h2>
  
  <?php
	//Merge old DB with new

	if (isset($_POST['pps_merge_db'])) { 
		$pps_db_update = merge_pps_old_new_dbs();
		
		if ($pps_db_update['status'] === 'Failed')	{
			echo '<div class="error pps-message-admin"><p>Warning: <strong>Post Profit Stats</strong> Database update failed! If you continue to get this message please contact support@slickremix.com</p></div>';
		}
		// Success, but no rows were updated
		if ($pps_db_update['status'] == 'Success' && isset($pps_db_update['rows']) && $pps_db_update['rows'] == '0'){
			echo '<div id="message" class="updated pps-error-admin"><p>Notice: The <strong>Post Profit Stats</strong> It appears as though you already have upgraded your database and are good to go! You are now ok to delete old data.</p></div>';
		}
		// Success, and updates were done. $result is the number of affected rows.
		if ($pps_db_update['status'] == 'Success' && isset($pps_db_update['rows']) && $pps_db_update['rows'] != '0'){
			echo '<div id="message" class="updated pps-message-admin"><p>';
			 echo '<div class="pps_db_update"><strong>Rows Updates:</strong> '.$pps_db_update['rows'].'</div>';
			 echo '<div class="pps_db_update"><strong>Memory Used:</strong> '.$pps_db_update['memory_used'].'</div>';
			 echo '<div class="pps_db_update"><strong>It worked!</strong> Your database has succussfully been updated to work with the newest version of Post Profit Stats! You are now ok to delete old data.</div>';
			echo '</p></div>';
			
			if(is_plugin_active('post-profit-stats-ent/post-profit-stats-ent.php')) {
				global $slickpps_ent_table_version;
			 	update_option( "slickpps_ent_table_version", $slickpps_ent_table_version );
			}
			else	{
				global $slickpps_table_version;
			 	update_option( "slickpps_table_version", $slickpps_table_version );
			}
		}
	} 
?>
    
  <div class="pps-admin-help-wrap">
    <form method="post" action="admin.php?page=pps-upgrade-db-submenu-page" id="pps-update-db">
      <input  type="hidden" id="pps_merge_db" name="pps_merge_db" value="yes"/>
      <div class="use-of-plugin">
        <label>This upgrade is ONLY for current users of our plugin. Be sure to back up your database first, just in case something goes wrong.<br/>
          Click "Update It" when you are ready to upgrade.</label>
        <p><input type="submit" name="pps_update_db" value="Update It!" id="backupDBpps" class="button button-primary" /></p>
        
      </div>
    </form>

<?php 

if (!isset($_POST['deleteDBpps_check']) && !isset($_POST['deleteDBpps'])) {?>   
  <form method="post" action="admin.php?page=pps-upgrade-db-submenu-page" id="pps-delete-table">
   	  <label><em>**NOTE**  Be sure you have updated the database first... unless you don't care about the old stats.</em> <br/><br/></label>
	  <input type="submit" name="deleteDBpps_check" value="Delete old data?" id="deleteDBpps_check" class="button button-primary" />
  </form>

<?php } //END DELETE CHECK

//START DELETE
if (isset($_POST['deleteDBpps_check'])) {?>
  <form method="post" action="admin.php?page=pps-upgrade-db-submenu-page" id="pps-delete-table">
  	  <label><strong>Are you sure you want to delete the old data?</strong><br/><br/></label>
	  <input type="submit" name="deleteDBpps" value="I'm sure. Delete it!" id="deleteDBpps" class="button button-primary" />
  </form>
  
      <?php
}
	  if (get_option("slickpps_old_table_exists" ) == 'old_table_exists' && isset($_POST['deleteDBpps']) or get_option( "slickpps_ent_old_table_exists" ) == 'old_table_exists'	&& isset($_POST['deleteDBpps']) ) {
	$current_user = wp_get_current_user();
	$user_role = $current_user->roles[0];
	
  if (isset($_POST['deleteDBpps']) && $user_role = 'administrator') { 	
  		if(is_plugin_active('post-profit-stats-ent/post-profit-stats-ent.php')) {
			global $slickpps_db, $slickpps_ent_table_name_old;
			// Drop MySQL Tables
			$SQL = "DROP TABLE $slickpps_ent_table_name_old";
			
			if($slickpps_db->query($SQL)){
				echo '<div id="message" class="updated pps-message-admin"><p>';
				 echo '<div class="pps_db_update"><strong>It worked!</strong> Your old database has succussfully been removed and is no longer taking up extra space!</div>';
				echo '</p></div>';
				
				update_option( "slickpps_ent_old_table_exists", "no_old_table_exists" );
			}
			else	{
				echo '<div class="error" class="updated pps-message-admin"><p>Warning: <strong>Post Profit Stats</strong> old table removal failed! If you continue to get this message please contact support@slickremix.com</p></div>';
				die("An unexpected error occured.".mysql_error());
			}
		}//enterprise
		else {
			global $wpdb, $pps_old_table_name;
			// Drop MySQL Tables
			$SQL = "DROP TABLE $pps_old_table_name";
			if($wpdb->query($SQL)){
				echo '<div id="message" class="updated pps-message-admin"><p>';
				 echo '<div class="pps_db_update"><strong>It worked!</strong> Your old database has succussfully been removed and is no longer taking up extra space!</div>';
				echo '</p></div>';
				
				update_option( "slickpps_old_table_exists", "no_old_table_exists" );
			}
			else	{
				echo '<div class="error" class="updated pps-message-admin"><p>Warning: <strong>Post Profit Stats</strong> old table removal failed! If you continue to get this message please contact support@slickremix.com</p></div>';
				die("An unexpected error occured.".mysql_error());
			}
		}//NOT enterprise
		
		
		
		
  }
  elseif(isset($_POST['deleteDBpps']) && $user_role != 'administrator')	{
	  echo '<div id="message" class="updated pps-message-admin"><p>Notice: You do not have Permission to delete table. Please contact Administrator for assistance.</p></div>';
  }
  ?>
 
  
<?php }//endif old table exists?>
  </div>
</div>

<?php } ?>