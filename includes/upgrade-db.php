<?php
function pps_upgrade_db_page(){?>

	<form method="post" action="admin.php?page=pps-upgrade-db-page" id="pps-update-db">
        <label>Be sure to back up database! Are you ready to upgrade the database?</label>
        <input type="hidden" id="pps_merge_db" name="pps_merge_db"  value="yes"/>
        <input type="submit" name="pps_update_db" value="Update It!" />
    </form>

<?php
	//Merge old DB wit old.
	if ($_POST['pps_merge_db']) { 
		merge_pps_old_new_dbs();
	}
} 
?>