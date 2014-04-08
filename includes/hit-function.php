<?php	
//Make sure WP_Query is reset wp_query before starting new query!
wp_reset_query();

global $wp_query, $wpdb;

$final_list_post_authors = array();
if	(function_exists( 'get_coauthors' )){
	
	$list_authors = get_coauthors();
	foreach ($list_authors as $authors){
		//Only shows matching Author to authors List
		$final_list_post_authors[] = $authors->ID;

	}
}
  
if	(!empty($final_list_post_authors) && isset($_GET['ID']) && in_array($_GET['ID'], $final_list_post_authors)){
	$current_author_id = $_GET['ID'];
	$no_hit = FALSE;	  
}
if(!empty($final_list_post_authors) && !isset($_GET['ID'])) {
	$current_author_id = $final_list_post_authors[0];
	$no_hit = FALSE;
}
if(empty($final_list_post_authors)) {
	$current_author_id = $wp_query->post->post_author;
	$no_hit = FALSE;
}

if(!empty($final_list_post_authors) && isset($_GET['ID']) && (!in_array($_GET['ID'], $final_list_post_authors))) {
	$no_hit = TRUE;
}

if($no_hit !== TRUE) {
	
	$current_post_id = $wp_query->post->ID;
?>
	
<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>
	
<script type="text/javascript">
jQuery(document).ready(function(){
	  var postID = '<?php echo $current_post_id; ?>';
	  console.log(postID);
	  var postAuthor = '<?php echo $current_author_id; ?>';
	  console.log(postAuthor);
	  
	  jQuery.ajax({
		  type: 'POST',
		  url: myPPSAjax.ajaxurl,
		  <?php if(is_plugin_active('post-profit-stats-ent/post-profit-stats-ent.php')) {  ?>
		  data: {action: "view_site_description_custom", post_id: postID, post_author: postAuthor},
		  <?php }else {?>
			data: {action: "view_site_description", post_id: postID, post_author: postAuthor},
		  <?php }?>
		  success: function(data){
			  // alert(data);
			   console.log('Count Processed')
			   return data; 
			  } 
	  });
	return false;
});
</script>
<?php
}//end else?>