<?php
function pps_settings_page(){
global $wpdb;

include('pps-settings-checked.php');

if(isset($_GET['to']) and isset($_GET['from'])) {
	$fromdate = $_GET['from'];
	$fromdate = date_i18n("Y-m-d",strtotime($fromdate)); 
	$todate = $_GET['to'];
	$todate = date_i18n("Y-m-d",strtotime($todate));
	
	$_POST['from'] = $fromdate;
	$_POST['to'] = $todate ;
}

if(!isset($_POST['to']) and !isset($_POST['from'])) {
  $_POST['from'] = date_i18n('Y-m-d');
  $_POST['to'] = date_i18n('Y-m-d');
}

$setfromdate = $_POST['from'];
$settodate = $_POST['to'];

// THIS IS THE ENTERPRISE VERSION
if(is_plugin_active('post-profit-stats-ent/post-profit-stats-ent.php')) { 
	global $slickpps_ent_table_name;
	global $slickpps_db;
	
	if(isset($_POST['to']) and isset($_POST['from'])) {
	
		$select = "
		SELECT *,count(*) as countslick
		FROM $slickpps_ent_table_name
		WHERE create_date >='".$_POST['from']."' 
		AND create_date<='".$_POST['to']."' 
		GROUP BY post_id desc
		";
	} else {
		$select = "
		SELECT *,count(*) as countslick
		FROM $slickpps_ent_table_name
		WHERE 1=1
		GROUP BY post_id desc
		";
	}
	
	$tabledata = $slickpps_db->get_results($select);
}// CLOSE ENTERPRISE VERSION
else	{
	$table_name = $wpdb->prefix . "slick_post_profit_stats";
	
	if(isset($_POST['to']) and isset($_POST['from'])) {
	
		$select = "
		SELECT *,count(*) as countslick
		FROM $table_name
		WHERE create_date >='".$_POST['from']."' 
		AND create_date<='".$_POST['to']."' 
		GROUP BY post_id desc
		";
	} else {
		$select = "
		SELECT *,count(*) as countslick
		FROM $table_name
		WHERE 1=1
		GROUP BY post_id desc
		";
	}
	
	$tabledata = $wpdb->get_results($select);
}
// CLOSE ENTERPRISE VERSION

?>
<?php
$excluded = "0";  // To exclude IDs 1
     

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
    <form method="post" action="admin.php?page=pps-settings-page" data-theme="c" id="slick-date-selector">
      <div data-role="fieldcontain" class="slickpps-start-date-input-wrap">
        <label for="start_date" >From: </label>
        <input class="date-pick"  data-role="none" data-mini="true" type="date" name="from" data-theme="c" id="from" value="<?php if(!empty($setfromdate)) {echo $setfromdate; $setfromdate = str_replace('-', '', $setfromdate);} else {echo date_i18n('Y-m-d');}  ?>" />
        <!--want the date to be monthly, use this -> date('Y-m-d',strtotime("-1 month")); --> 
      </div>
      <div data-role="fieldcontain" class="slickpps-end-date-input-wrap">
        <label for="end_date">To: </label>
        <input type="date"    data-role="none" data-mini="true" class="date-pick" name="to" data-theme="c" id="to" value="<?php if(!empty($settodate)) {echo $settodate; $settodate = str_replace('-', '', $settodate);} else {echo date_i18n('Y-m-d');} ?>" />
      </div>
      <div class="slickpps-submit-date-search-input-wrap">
        <input type="submit"  data-inline="true" class="button" data-theme="c" value="<?php _e('Submit') ?>" />
      </div>
      <div class="clear"></div>
    </form>
  </div>
  <div data-role="content" class="sr-content">
    <div class="thumbnail sr_split_plugin_wrap">
      <div class="slick-click-on-username-note">Click any username to view details</div>
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
	   
	  if($post_id == $data_id && $post_author == $data_author){
	  
		  $amount_per_view = get_option('my_option_name1');
		  
		  if (get_option('my_option_name1') == '') {
			$amount_per_view  = '.002';
		  }
		  else{
			$rows_per_page = get_option('my_option_name1');
		  }
		
		  if (!empty($user_profile_field) && $user_profile_field !== ' '){
			$slickremixCountX = $views_count * $user_profile_field;
		  }
		  else	{
			  $slickremixCountX = $views_count * $amount_per_view;
		  }
	  
	  
	  $post_counter = +1;
	  //Count up Profit and round it to the nearest Decimal.
	  $profits_count = round($slickremixCountX, 4);
  		 
		 $slickpostauthor[$posts->post_author]['post_count'] += $post_counter;
		 $slickpostauthor[$posts->post_author]['view_count'] += $views_count;
		 $slickpostauthor[$posts->post_author]['comments_count'] += $comments_counts;
		 $slickpostauthor[$posts->post_author]['profits_count'] += $profits_count;	
	  }
	}
	
	
	if (get_option('my_option_name2') == '') {
		$rows_per_page  = '1';
	}
	else{
		$rows_per_page = get_option('my_option_name2');
	}
	
	if ($pps_checked == "yes"){
		$numrows = count($slickpostauthor);
		if ($rows_per_page > '50'){
		  $rows_per_page = '50';
		}
	}
	
	if ($pps_checked== "no"){
		$numrows = count($slickpostauthor);
		if ($numrows > '10'){
		  $numrows = '10';
		}
		if ($rows_per_page > '10'){
		  $rows_per_page = '10';
		}
	}
	
	// Calculate number of $lastpage
	$lastpage = ceil($numrows/$rows_per_page);
	
	// condition inputs/set default
	if (isset($_GET['pageno'])) {
	   $pageno = $_GET['pageno'];
	} else {
	   $pageno = 1;
	}
	
	// validate/limit requested $pageno
	$pageno = (int)$pageno;
	if ($pageno > $lastpage) {
	   $pageno = $lastpage;
	}
	if ($pageno < 1) {
	   $pageno = 1;
	}
	
	// Find start and end array index that corresponds to the reuqeted pageno
	$start = ($pageno - 1) * $rows_per_page;
	$end = $start + $rows_per_page -1;
	
	// limit $end to highest array index
	if($end > $numrows - 1){
		$end = $numrows - 1;
	}
	
	$i = 0;
	
	foreach($slickpostauthor as $key => $value)  { 
	
	if($i >= $start && $i <= $end){
	
	$author_name = get_userdata($key);
	$final_author_name = $author_name->display_name;

			
	?>
      <h2><a href="admin.php?page=pps-single-author&pps_user_id=<?php echo $key; ?><?php if(isset($_POST['to']) and isset($_POST['from'])) { echo "&fromdate=".$setfromdate."&todate=".$settodate."";}?>"><?php echo $final_author_name; ?></a></h2>
      <div class="span3 thumbnail custom-sr-wrap">
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
		$grand_total_posts_count += $slickpostauthor[$key]['post_count'];
		$grand_total_views_count += $slickpostauthor[$key]['view_count'];
		$grand_total_comments_count += $slickpostauthor[$key]['comments_count'];
		$grand_total_profits_count += $slickpostauthor[$key]['profits_count'];
	
	}$i++; } 
	
	?>
      <h2>Grand Totals</h2>
      <div class='span3 thumbnail custom-sr-wrap'>
        <div class='trans-colum'>
          <div class='trans-header-total'> &nbsp;</div>
          <!--/trans-header-->
          
          <div class='transaction-wrap'>
            <h1 class='totals'><?php echo $grand_total_posts_count;?></h1>
            <h3>Total Posts</h3>
          </div>
          <!--/transaction-wrap-->
          
          <div class='transaction-wrap'>
            <h1 class='totals'><?php echo $grand_total_views_count;?></h1>
            <h3>Total Views</h3>
          </div>
          <!--/transaction-wrap-->
          
          <div class='transaction-wrap'>
            <h1 class='totals'><?php echo $grand_total_comments_count; ?></h1>
            <h3>Total Comments</h3>
          </div>
          <!--/transaction-wrap-->
          
          <div class='transaction-wrap'>
            <h1 class='totals'>$<?php echo $grand_total_profits_count; ?></h1>
            <h3>Total Profit</h3>
          </div>
          <!--/transaction-wrap-->
          
          <div class="clear"></div>
        </div>
        <!--/trans-colum-->
        
        <div class="clear"></div>
      </div>
      <!--/ custom-sr-wrap-->
      <div class="slick-pagination-wrap">
        <?php

// first/prev pagination hyperlinks
if ($pageno == 1) {
} else {
   echo " <a href='admin.php?page=pps-settings-page&pageno=1&from=".$setfromdate."&to=".$settodate."'>First</a> ";
   $prevpage = $pageno-1;
   echo "<a href='admin.php?page=pps-settings-page&pageno=".$prevpage."&from=".$setfromdate."&to=".$settodate."'>Previous</a>";
}

// Display current page or pages
echo " ( Page $pageno of $lastpage ) ";

// next/last pagination hyperlinks
if ($pageno == $lastpage) {
} else {
   $nextpage = $pageno+1;
   echo " <a href='admin.php?page=pps-settings-page&pageno=".$nextpage."&from=".$setfromdate."&to=".$settodate."'>Next</a> ";
   echo " <a href='admin.php?page=pps-settings-page&pageno=".$lastpage."&from=".$setfromdate."&to=".$settodate."'>Last</a> ";
}
?>
      </div>
      <div class="clear"></div>
    </div>
    <!--/sr_split_plugin_wrap--> 
    
    <a class="glogo-logo" href="http://guardianlv.com/" target="_blank"></a> <a class="pps-settings-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a> </div>
  <?php include('includes/panel.php'); ?>
</div>
<!--/page-->
<?php } ?>