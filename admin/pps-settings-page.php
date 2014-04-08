<?php
function pps_settings_page(){
global $wpdb, $pps_new_table_name;

include('pps-settings-checked.php');

if(isset($_GET['to']) and isset($_GET['from'])) {
	$fromdate = $_GET['from'];
	$fromdate = date_i18n("Y-m-d",strtotime($fromdate)); 
	$todate = $_GET['to'];
	$todate = date_i18n("Y-m-d",strtotime($todate));
	
	$_POST['from'] = $fromdate;
	$_POST['to'] = $todate ;
	$notset = false;
}
if(!isset($_POST['to']) and !isset($_POST['from'])) {
  $_POST['from'] = date_i18n('Y-m-d');
  $_POST['to'] = date_i18n('Y-m-d');
  $notset = true;
}

$setfromdate = $_POST['from'];
$settodate = $_POST['to'];

// THIS IS THE ENTERPRISE VERSION
if(is_plugin_active('post-profit-stats-ent/post-profit-stats-ent.php')) { 
	global $slickpps_ent_table_name_new;
	global $slickpps_db;
	
	if($notset = false) {
	
		$select = "
		SELECT *, SUM(hit_count) as 'view_count'
		FROM $slickpps_ent_table_name_new
		WHERE create_date >='".$_POST['from']."' 
		AND create_date<='".$_POST['to']."' 
		GROUP BY post_id desc, post_author
		";
	} else {
		$select = "
		SELECT *, SUM(hit_count) as 'view_count'
		FROM $slickpps_ent_table_name_new
		WHERE create_date >='".$_POST['from']."' 
		AND create_date<='".$_POST['to']."'
		GROUP BY post_id desc, post_author 
		";
	}
	
	$tabledata = $slickpps_db->get_results($select);
}// CLOSE ENTERPRISE VERSION
else	{
	
	if( $notset == false) {
	
		$select = "
		SELECT *, SUM(hit_count) as 'view_count'
		FROM $pps_new_table_name
		WHERE create_date >='".$_POST['from']."' 
		AND create_date<='".$_POST['to']."' 
		GROUP BY post_id desc, post_author
		";
	} else {
		$select = "
		SELECT *, SUM(hit_count) as 'view_count'
		FROM $pps_new_table_name 
		WHERE create_date >='".$_POST['from']."' 
		AND create_date<='".$_POST['to']."'
		GROUP BY post_id desc, post_author 
		";
	}
	
	$tabledata = $wpdb->get_results($select);
}
// CLOSE ENTERPRISE VERSION

?>
<?php
$excluded = "0";  // To exclude IDs 1
    

?>
<div data-role="page" id="page" style="position:relative;">

  <div data-role="header" data-theme="c" class="sr-header"><a href="#mypanel" class="ui-btn-right header-settings-btn" style="margin-right: 35px; margin-top: 15px;" data-role="button" data-theme="b" data-icon="bars" data-display="overlay">Settings & Info</a>
  
<h2><?php if(is_plugin_active('post-profit-stats-pro/post-profit-stats-pro.php')) {
     
    $customPageName =  get_option('my_option_name55');
    if ($customPageName == ' ' || $customPageName == '') { ?> 
    Post Profit Stats
<?php } 
    else { 
         echo get_option('my_option_name55');
        }
    }
        else {
            echo'Post Profit Stats';		
        }
?></h2>
    <div class="clear"></div>
    <form method="post" action="admin.php?page=pps-settings-page" data-theme="c" id="slick-date-selector">
      <div data-role="fieldcontain" class="slickpps-start-date-input-wrap">
        <label for="start_date" >From</label><input class="date-pick date-input"  data-role="date" data-mini="true" type="text" name="from"  id="from" value="<?php if(!empty($setfromdate)) {echo $setfromdate;} else {echo date_i18n('Y-m-d');}  ?>" />
        <!--want the date to be monthly, use this -> date('Y-m-d',strtotime("-1 month")); -->  
      </div>
      <div data-role="fieldcontain" class="slickpps-end-date-input-wrap">
        <label for="end_date">To</label><input type="text" data-role="date" data-mini="true" class="date-pick date-input" name="to"  id="to" value="<?php if(!empty($settodate)) {echo $settodate;} else {echo date_i18n('Y-m-d');} ?>" />
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
	$comments_counts = 0;
	$i =1;
	$post_counter = 0;

if ($tabledata)	{	
	
    foreach($tabledata as $data) {
	  $posts = get_post($data->post_id);  	
	  
	  $post_id = $posts->ID;
	  $data_id = $data->post_id;
	  $post_author = $posts->post_author;
	  $data_author = $data->post_author;
	  $user_profile_field= esc_attr( get_user_meta( $data_author, 'pps_percentage',true));
	  $comments_counts = $posts->comment_count;
	  $views_count = $data->view_count;
	  
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
  		 
		 $slickpostauthor[$data->post_author]['post_count'] += $post_counter;
		 $slickpostauthor[$data->post_author]['view_count'] += $views_count;
		 $slickpostauthor[$data->post_author]['comments_count'] += $comments_counts;
		 $slickpostauthor[$data->post_author]['profits_count'] += $profits_count;	
	  }

	
}// End if $tabledata
else	{
	// echo '<br/><div style="text-align:center;"><strong>Please click the settings option and add your database info.<br/>Double check your info including your host if you are still seeing this message after saving your settings.</strong></div>';
}// End else $tabledata
	
	if (get_option('my_option_name2') == '') {
		$rows_per_page  = '1';
	}
	else{
		$rows_per_page = get_option('my_option_name2');
	}
	
	if ($pps_checked == "yes"){
		$numrows = count($slickpostauthor);
		if ($rows_per_page > '50'){
		  $rows_per_page = $rows_per_page ;
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
   echo "<a href='admin.php?page=pps-settings-page&pageno=1&from=".$setfromdate."&to=".$settodate."'>First</a>";
   $prevpage = $pageno-1;
   echo "<a href='admin.php?page=pps-settings-page&pageno=".$prevpage."&from=".$setfromdate."&to=".$settodate."'>Previous</a>&nbsp;&nbsp;";
}

// Display current page or pages
echo "Page $pageno of $lastpage";

// next/last pagination hyperlinks
if ($pageno == $lastpage) {
} else {
   $nextpage = $pageno+1;
   echo "&nbsp;&nbsp;<a href='admin.php?page=pps-settings-page&pageno=".$nextpage."&from=".$setfromdate."&to=".$settodate."'>Next</a>";
   echo "<a href='admin.php?page=pps-settings-page&pageno=".$lastpage."&from=".$setfromdate."&to=".$settodate."'>Last</a>";
}
?>
      </div>
      <div class="clear"></div>
    </div>
    <!--/sr_split_plugin_wrap--> 
<?php $customPageName =  get_option('my_option_name55');
  		if ($customPageName == ' ' || $customPageName == '') { ?> 
    		<a class="pps-settings-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a>
<?php }?> </div>
  <?php include('includes/panel.php'); ?>
</div>
<!--/page-->

<?php 
	//Merge old DB wit new.
	if (isset($_POST['pps_merge_db'])) { 
		merge_pps_old_new_dbs();
	}
} 
?>