<?php
if(is_plugin_active('post-profit-stats-pro/post-profit-stats-pro.php')) { 

	$themac = pps_get_checked();
	
	if ($themac !== "no") {
		update_option('pps_get_checked', "yes");
		 $pps_checked = get_option('pps_get_checked');
	}
	else {
		update_option('pps_get_checked', "no");
	 $pps_checked = get_option('pps_get_checked');
	}
}	
else	{
	 $pps_checked = "no";
}
?>