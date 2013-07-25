<?php
function pps_single_author (){

global $wpdb;


$table_name = $wpdb->prefix . "slick_post_profit_work";

if(isset($_GET["pps_user_id"])) {
	$_POST["pps_user_id"] = $_GET["pps_user_id"];
}
	 
	
if(isset($_GET["todate"]) and isset($_GET["fromdate"])) {
	
	$fromdate = $_GET["fromdate"];
	$fromdate = date("Y-m-d",strtotime($fromdate)); 
	$todate = $_GET["todate"];
	$todate = date("Y-m-d",strtotime($todate));

	$select = "
	SELECT *,count(*) as countslick
	FROM $table_name
	WHERE create_date >='".$fromdate."' 
	AND create_date<='".$todate."' 
	GROUP BY post_id desc
";

}
if(!isset($_POST['to']) and !isset($_POST['from']) and !isset($_GET["todate"]) and !isset($_GET["fromdate"])) {
  $_POST['from'] = date('Y-m-d');
  $_POST['to'] = date('Y-m-d');
  
  $select = "
	SELECT *,count(*) as countslick
	FROM $table_name
	WHERE create_date >='".$_POST['from']."' 
	AND create_date<='".$_POST['to']."' 
	GROUP BY post_id desc
	";
}
if(isset($_POST['to']) and isset($_POST['from'])) {

	$select = "
	SELECT *,count(*) as countslick
	FROM $table_name
	WHERE create_date >='".$_POST['from']."' 
	AND create_date<='".$_POST['to']."' 
	GROUP BY post_id desc
	";
} 

$userid = $_POST["pps_user_id"];

$setfromdate = $_POST['from'];
$settodate = $_POST['to'];

 
$tabledata = $wpdb->get_results($select);
?>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.css" />
<script type="text/javascript">
jQuery(document).bind("mobileinit", function () {
    jQuery.mobile.ajaxEnabled = false;
});
</script>
<script src="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.js"></script>
<script type="text/javascript">
jQuery( "#close-settings-panel" ).panel( "close" );
</script>
<div data-role="page" id="page" style="position:relative;">
  <div data-role="header" data-theme="c" class="sr-header"><a href="#mypanel" class="ui-btn-right header-settings-btn" style="margin-right: 35px; margin-top: 15px;" data-role="button" data-theme="b" data-icon="bars" data-display="overlay">Settings & Info</a>
    <h2> Post Profit Stats</h2>
    <div class="clear"></div>
    <div class="slick-click-on-username-note-detail-page">To search a specific user please enter their ID number.</div>
    <form method="post" data-theme="c" action="admin.php?page=pps-single-author" id="slick-date-selector">
      <div data-role="fieldcontain" class="slickpps-pps-user-id-date-input-wrap">
        <label for="start_date" >User ID: </label>
        <input type="text" data-role="none" class="pps_user_id" data-theme="c" name="pps_user_id"  id="pps_user_id" value="<?php if (isset($_POST['pps_user_id'])){echo $_POST["pps_user_id"];}?>" />
      </div>
      <div data-role="fieldcontain" class="slickpps-start-date-input-wrap">
        <label for="start_date" >From: </label>
        <input class="date-pick" data-role="none"  data-mini="true" type="date" name="from" data-theme="c" id="from" value="<?php if(isset($_GET["fromdate"])) {echo $fromdate;} else {if(!empty($setfromdate)) {echo $setfromdate;} else {echo date('Y-m-d');}} ?>" />
      </div>
      <div data-role="fieldcontain" class="slickpps-end-date-input-wrap">
        <label for="end_date">To: </label>
        <input type="date" data-role="none"  data-mini="true" class="date-pick" name="to" data-theme="c" id="to" value="<?php if(isset($_GET["todate"])) {echo $todate;} else { if(!empty($settodate)) {echo $settodate;} else {echo date('Y-m-d');}} ?>" />
      </div>
      <div class="slickpps-submit-date-search-input-wrap"> 
        <!--<a id="myslicksubmit" data-role="button">Submit</a>-->
        <input type="submit"  data-inline="true" class="button" data-theme="c" value="<?php _e('Submit') ?>" />
      </div>
      <div class="clear"></div>
    </form>
  </div>
  <div data-role="content" class="sr-content">
    <div class="thumbnail sr_split_plugin_wrap">
  <?php if(!empty($_POST['pps_user_id'])) { ?>
      <?php 
	$slickpostauthor= array();
	
	//Grand Totals
	$grand_total_comments_count = 0;
	$grand_total_views_count = 0;
	$grand_total_profits_count = 0;
	$grand_total_posts_count = 0;
	
	//regular
	$views_count = 0;
	$profits_count = 0;
	$slickremixCountX = 0;
	$comments_counts == 0;
	$i =1;
	$post_counter = 0;
	
    foreach($tabledata as $data) {
	  $posts = get_post($data->post_id);  	
	  
	  $post_id = $posts->ID;
	  $data_id = $data->post_id;
	  $post_author = $posts->post_author;
	  $data_author = $data->post_author;
	  $user_profile_field= esc_attr( get_user_meta( $data_author, 'pps_percentage',true));
	  $comments_counts = $posts->comment_count;
	  $views_count = $data->countslick;
	  
	  if (get_option('my_option_name1') == '') {
			$amount_per_view  = '.002';
	   }
	   else{
			$amount_per_view  = get_option('my_option_name1');
	   }
		  
	  if($post_id == $data_id && $post_author == $data_author){
	  
	  if (!empty($user_profile_field) && $user_profile_field !== ' '){
	  	$slickremixCountX = $views_count * $user_profile_field;
	  }
	  else	{
		  $slickremixCountX = $views_count * $amount_per_view;
	  }	
	  
	 
	  
	  $post_counter = +1;
	  //Count up Profit and round it to the nearest Decimal.
	  $profits_count = round($slickremixCountX, 4);
  		 
		 $slickpostauthor[$posts->post_author]['post_count'] += $post_counter  ;
		 $slickpostauthor[$posts->post_author]['view_count'] += $views_count;
		 $slickpostauthor[$posts->post_author]['comments_count'] += $comments_counts;
		 $slickpostauthor[$posts->post_author]['profits_count'] += $profits_count;	
	  }
	}

//echo "<pre>";
//print_r($slickpostauthor);
//echo "</pre>";

		
	foreach($slickpostauthor as $key => $value ) { 
		
	   	
	   
	if ($key == $userid)	{
	
	$author_name = get_userdata($key);
	$final_author_name = $author_name->display_name;
	 
	?>
      <h2><?php echo $final_author_name; ?></h2>
      <div class="span3 thumbnail custom-sr-wrap">
        <?php
	  		$views_count = 0;
			 foreach($tabledata as $data) { 
			
			  $posts = get_post($data->post_id); 
			  $title = $posts->post_title;
			  $data_author = $data->post_author;
			  $user_info = get_userdata($posts->post_author);
			  $this_post_author = $posts->post_author;
			  $user_profile_field= esc_attr( get_user_meta( $data_author, 'pps_percentage',true));
			  
			  
			  if($key == $this_post_author) {
				  $views_count = $data->countslick;
        ?>
        <div class='trans-colum'>
          <div class='trans-header'><a target="_blank" href="<?php echo get_permalink( $data->post_id ); ?>"><?php echo $title?$title:'(No Title)' ?></a></div>
          <!--/trans-header-->
          
          <div class='transaction-wrap'>
            <h1><a target="_blank" href="<?php echo get_option('siteurl').'/wp-admin/post.php?post='.$data->post_id.'&action=edit' ?>"><?php echo $data->post_id ?></a></h1>
            <h3>Post ID</h3>
          </div>
          <!--/transaction-wrap-->
          
          <div class='transaction-wrap'>
            <h1><?php echo $views_count ?></h1>
            <h3>Views</h3>
          </div>
          <!--/transaction-wrap-->
          
          <div class='transaction-wrap'>
            <h1><?php echo $posts->comment_count ?></h1>
            <h3>Comments</h3>
          </div>
          <!--/transaction-wrap-->
          
          <div class='transaction-wrap'>
            <h1>$
            
              <?php
			  
			 if (!empty($user_profile_field) && $user_profile_field !== ' '){
				$slickremixCountX = $views_count * $user_profile_field;
			  }
			  else	{
				  $slickremixCountX = $views_count * $amount_per_view;
			 }
			echo $slickremixCountX ?>
            </h1>
            <h3>Author Profit</h3>
          </div>
          <!--/transaction-wrap--> 
          
        </div>
        <!--/trans-colum-->
        
        
        <?php 
				} 
			
				
		} 
			
?>
        <div class='trans-colum'>
          <div class='trans-header-total'>
            <div class='transaction-wrap-total'>
              <h1 class='totals'><?php echo $slickpostauthor[$key]['post_count'];?></h1>
              <h3>Total Posts</h3>
            </div>
            <!--/transaction-wrap-->
            
            <div class='transaction-wrap-total'>
              <h1 class='totals'><?php echo $slickpostauthor[$key]['view_count'];?></h1>
              <h3>Total Views</h3>
            </div>
            <!--/transaction-wrap-->
            
            <div class='transaction-wrap-total'>
              <h1 class='totals'><?php echo $slickpostauthor[$key]['comments_count']; ?></h1>
              <h3>Total Comments</h3>
            </div>
            <!--/transaction-wrap-->
            
            <div class='transaction-wrap-total'>
              <h1 class='totals'>$<?php echo $slickpostauthor[$key]['profits_count']; ?></h1>
              <h3>Total Profit</h3>
            </div>
            <!--/transaction-wrap--></div>
          <!--/trans-header--> 
          
        </div>
        <!--/trans-colum-->
        <div class='clear'></div>
      </div>
      <!--/ custom-sr-wrap--> 
    <?php 
		}
	} 
	
  }
	?>
    </div>
    <!--/sr-split-plugin-wrap-->
    <a class="glogo-logo" href="http://guardianlv.com/" target="_blank"></a> <a class="pps-settings-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a> </div>
  <!--/sr-content-->
  <?php include('includes/panel.php'); ?>
</div>
<!--/page--> 

<script type="text/javascript">
   var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script> 
<script type="text/javascript">
jQuery( "#close-settings-panel" ).panel( "close" );
	jQuery('#myslicksubmit').live('click', function(){
	
		var userID = jQuery('#pps_user_id').val();
		console.log(userID);
		var fromDate = jQuery('#from').val();
		console.log(fromDate);
		var toDate = jQuery('#to').val();
		console.log(toDate);

		jQuery.ajax({
			type: 'POST',
            url: ajaxurl,
			data: {action: "slick_fetch_date", user_ID: userID, from_date: fromDate, to_date: toDate  },
		   // dataType: 'json',
			success: function(data){
				 
			//	 var my_id = data[0].id
			//	 var mypost_id = data[0].post_id
			//	var data = jQuery.parseJSON(response);
				jQuery('.sr_split_plugin_wrap').hide();
			//	jQuery('.sr_split_plugin_wrap').html("<b>db ID: </b>"+my_id+"<b> post ID: </b>"+mypost_id).fadeIn('fast'); 
				
				jQuery('.sr_split_plugin_wrap').html(data).fadeIn('fast'); 
			//	console.log(data[0].id);
			//	console.log(data[0].post_id);
			//	var post_id = jQuery.parseJSON(data);
				 console.log('Form Processed');  
				
				return false;
				} 
		});
	return false;
	});
</script>
<?php  } ?>