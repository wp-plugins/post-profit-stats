<?php
function pps_single_author (){

global $wpdb, $pps_new_table_name;

if(isset($_GET["pps_user_id"])) {
	$_POST["pps_user_id"] = $_GET["pps_user_id"];
}

if(isset($_GET["fromdate"])) {
	$fromdate = $_GET["fromdate"];
}
if(isset($_GET["todate"])) {
	$todate = $_GET["todate"];
} 	  
	//  $fromdate = date_i18n("Y-m-d",strtotime($fromdate));  
	//  $todate = date_i18n("Y-m-d",strtotime($todate));
	  
if(is_plugin_active('post-profit-stats-ent/post-profit-stats-ent.php')) { 
	
	global $slickpps_ent_table_name_new;
	global $slickpps_db;
	
	if(isset($_GET["todate"]) and isset($_GET["fromdate"])) {
	
	  $select = "
	  SELECT *, SUM(hit_count) as 'view_count'
	  ,SUM(chrome_views) as 'chrome_views_total'
	  ,SUM(safari_views) as 'safari_views_total'
	  ,SUM(firefox_views) as 'firefox_views_total'
	  ,SUM(opera_views) as 'opera_views_total'
	  ,SUM(ie_views) as 'ie_views_total'
	  ,SUM(unknown_views) as 'unknown_views_total'
	  ,SUM(desktop_views) as 'desktop_views_total'
	  ,SUM(mobile_views) as 'mobile_views_total'
	  ,SUM(tablet_views) as 'tablet_views_total'
	  ,SUM(console_views) as 'console_views_total'
	  FROM $slickpps_ent_table_name_new
	  WHERE create_date >='".$fromdate."' 
	  AND create_date<='".$todate."'
	  AND post_author ='".$_POST['pps_user_id']."'  
	  GROUP BY post_id desc
	  ";
	
	}
	if(!isset($_POST['to']) and !isset($_POST['from']) and !isset($_GET["todate"]) and !isset($_GET["fromdate"])) {
	  $_POST['from'] = date_i18n('Y-m-d');
	  $_POST['to'] = date_i18n('Y-m-d');
	  
	  $select = "
		SELECT *, SUM(hit_count) as 'view_count'
		,SUM(chrome_views) as 'chrome_views_total'
		,SUM(safari_views) as 'safari_views_total'
		,SUM(firefox_views) as 'firefox_views_total'
		,SUM(opera_views) as 'opera_views_total'
		,SUM(ie_views) as 'ie_views_total'
		,SUM(unknown_views) as 'unknown_views_total'
		,SUM(desktop_views) as 'desktop_views_total'
		,SUM(mobile_views) as 'mobile_views_total'
		,SUM(tablet_views) as 'tablet_views_total'
		,SUM(console_views) as 'console_views_total'
		FROM $slickpps_ent_table_name_new
		WHERE create_date >='".$_POST['from']."' 
		AND create_date<='".$_POST['to']."'
		AND post_author ='".$_POST['pps_user_id']."'  
		GROUP BY post_id desc
		";
	}
	if(isset($_POST['to']) and isset($_POST['from'])) {
	
		$select = "
		 SELECT *, SUM(hit_count) as 'view_count'
		,SUM(chrome_views) as 'chrome_views_total'
		,SUM(safari_views) as 'safari_views_total'
		,SUM(firefox_views) as 'firefox_views_total'
		,SUM(opera_views) as 'opera_views_total'
		,SUM(ie_views) as 'ie_views_total'
		,SUM(unknown_views) as 'unknown_views_total'
		,SUM(desktop_views) as 'desktop_views_total'
		,SUM(mobile_views) as 'mobile_views_total'
		,SUM(tablet_views) as 'tablet_views_total'
		,SUM(console_views) as 'console_views_total'
		FROM $slickpps_ent_table_name_new
		WHERE create_date >='".$_POST['from']."' 
		AND create_date<='".$_POST['to']."' 
		AND post_author ='".$_POST['pps_user_id']."'  
		GROUP BY post_id desc
		
		";
	} 
	
	$tabledata = $slickpps_db->get_results($select);
}// CLOSE ENTERPRISE VERSION
	 
else {	
	
	if(isset($_GET["todate"]) and isset($_GET["fromdate"])) {
		 
		$select = "
		 SELECT *, SUM(hit_count) as 'view_count'
		,SUM(chrome_views) as 'chrome_views_total'
		,SUM(safari_views) as 'safari_views_total'
		,SUM(firefox_views) as 'firefox_views_total'
		,SUM(opera_views) as 'opera_views_total'
		,SUM(ie_views) as 'ie_views_total'
		,SUM(unknown_views) as 'unknown_views_total'
		,SUM(desktop_views) as 'desktop_views_total'
		,SUM(mobile_views) as 'mobile_views_total'
		,SUM(tablet_views) as 'tablet_views_total'
		,SUM(console_views) as 'console_views_total'
		FROM $pps_new_table_name
		WHERE create_date >='".$fromdate."' 
		AND create_date<='".$todate."'
		AND post_author ='".$_POST['pps_user_id']."'  
		GROUP BY post_id desc
	    ";
	
	}
	if(!isset($_POST['to']) and !isset($_POST['from']) and !isset($_GET["todate"]) and !isset($_GET["fromdate"])) {
	  $_POST['from'] = date_i18n('Y-m-d');
	  $_POST['to'] = date_i18n('Y-m-d');
	  
	  $select = "
		 SELECT *, SUM(hit_count) as 'view_count'
		,SUM(chrome_views) as 'chrome_views_total'
		,SUM(safari_views) as 'safari_views_total'
		,SUM(firefox_views) as 'firefox_views_total'
		,SUM(opera_views) as 'opera_views_total'
		,SUM(ie_views) as 'ie_views_total'
		,SUM(unknown_views) as 'unknown_views_total'
		,SUM(desktop_views) as 'desktop_views_total'
		,SUM(mobile_views) as 'mobile_views_total'
		,SUM(tablet_views) as 'tablet_views_total'
		,SUM(console_views) as 'console_views_total'
		FROM $pps_new_table_name
		WHERE create_date >='".$_POST['from']."' 
		AND create_date<='".$_POST['to']."'
		AND post_author ='".$_POST['pps_user_id']."'  
		GROUP BY post_id desc
		";
	}
	if(isset($_POST['to']) and isset($_POST['from'])) {
	
		$select = "
		 SELECT *, SUM(hit_count) as 'view_count'
		,SUM(chrome_views) as 'chrome_views_total'
		,SUM(safari_views) as 'safari_views_total'
		,SUM(firefox_views) as 'firefox_views_total'
		,SUM(opera_views) as 'opera_views_total'
		,SUM(ie_views) as 'ie_views_total'
		,SUM(unknown_views) as 'unknown_views_total'
		,SUM(desktop_views) as 'desktop_views_total'
		,SUM(mobile_views) as 'mobile_views_total'
		,SUM(tablet_views) as 'tablet_views_total'
		,SUM(console_views) as 'console_views_total'
		FROM $pps_new_table_name
		WHERE create_date >='".$_POST['from']."' 
		AND create_date<='".$_POST['to']."' 
		AND post_author ='".$_POST['pps_user_id']."'  
		GROUP BY post_id desc
		
		";
	} 
	
	$tabledata = $wpdb->get_results($select);
}

if(isset($_POST["pps_user_id"])) {
	$userid = $_POST["pps_user_id"];
}
if(isset($_POST["from"])) {
	$setfromdate = $_POST['from'];
}
if(isset($_POST['to'])) {
	$settodate = $_POST['to'];
}


 
?>
<div data-role="page" id="page" style="position:relative;">
  <div data-role="header" data-theme="c" class="sr-header">
    <?php if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {  ?>
 <a href="#mypanel" class="ui-btn-right header-settings-btn" style="margin-right: 35px; margin-top: 15px;" data-role="button" data-theme="b" data-icon="bars" data-display="overlay">Settings & Info</a>
      <?php   }
else { 
	 // we do not want to show the setting options for the author   
} ?>
    <h2><?php if(is_plugin_active('post-profit-stats-pro/post-profit-stats-pro.php')) {
   
    $customPageName = get_option('my_option_name55');
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
    <?php if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) { 
		?>
   <div class="slick-click-on-username-note-detail-page">To search a specific user please enter their ID number.</div>
    <?php
       }
else { ?>
     <div class="slick-click-on-username-note-detail-page">Click submit to view your totals for today or change dates to view different totals.</div>
    <?php } ?>
    <form method="post" data-theme="c" action="admin.php?page=pps-single-author" id="slick-date-selector">
      <?php if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
      ?>
      <div data-role="fieldcontain" class="slickpps-pps-user-id-date-input-wrap">
        <label for="start_date" >User ID</label>
        <input type="text" data-role="none" class="pps_user_id" data-theme="c" name="pps_user_id"  id="pps_user_id" value="<?php
    if (isset($_POST['pps_user_id'])){echo $_POST["pps_user_id"];}?>" />
      </div>
      
      <?php }
	  
else {
	global $current_user;
      get_currentuserinfo(); ?>
      <input type="hidden" data-role="none" class="pps_user_id" data-theme="c" name="pps_user_id"  id="pps_user_id" value="<?php echo $current_user->ID; ?>" />
      <?php } ?>
     <div data-role="fieldcontain" class="slickpps-start-date-input-wrap">
        <label for="start_date" >From</label> 
         <input class="date-pick date-input"  data-role="date" data-mini="true" type="text" name="from"  id="from" value="<?php  if(isset($_GET["fromdate"])) {echo $fromdate;} else {if(!empty($setfromdate)) {echo $setfromdate;} else {echo date_i18n('Y-m-d');}}  ?>" />
        <!--want the date to be monthly, use this -> date('Y-m-d',strtotime("-1 month")); -->  
      </div>
      <div data-role="fieldcontain" class="slickpps-end-date-input-wrap">
        <label for="end_date">To</label>
        <input type="text" data-role="date" data-mini="true" class="date-pick date-input" name="to"  id="to" value="<?php if(isset($_GET["todate"])) {echo $todate;} else { if(!empty($settodate)) {echo $settodate;} else {echo date_i18n('Y-m-d');}} ?>" />
      </div>
      <div class="slickpps-submit-date-search-input-wrap">
        <input type="submit"  data-inline="true" class="button" data-theme="c" value="<?php _e('Submit') ?>" />
      </div>
      <div class="clear"></div>  
    </form>
  </div>
  <div data-role="content" class="sr-content">
  
  <?php if (get_option('my_option_name9') == '') {
			
	   }
	   else{
			
			if (is_user_logged_in() && current_user_can( 'author' ) || is_user_logged_in() && current_user_can( 'administrator' )) {
			?><div class="author-note"><?php echo get_option('my_option_name9'); ?></div><?php
	  		 }
	   		
	   }
	   ?>
       
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
	$comments_counts = 0;
	$i =1;
	$post_counter = 0;
	
	/* echo "<pre>";
	print_r($tabledata);
	echo "</pre>"*/;
	
    foreach($tabledata as $data) {
	  $posts = get_post($data->post_id);  	
	  
	  $post_id = $posts->ID;
	  $data_id = $data->post_id;
	  $post_author = $posts->post_author;
	  $data_author = $data->post_author;
	  $user_profile_field= esc_attr( get_user_meta( $data_author, 'pps_percentage',true));
	  $comments_counts = $posts->comment_count;
	  $views_count = $data->view_count;
	  
	  if (get_option('my_option_name1') == '') {
			$amount_per_view  = '.002';
	   }
	   else{
			$amount_per_view  = get_option('my_option_name1');
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
	

/*echo "<pre>";
print_r($slickpostauthor);
echo "</pre>";*/
		
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
			  $more_infos = json_decode($data->more_info_counted, true);
			  
			  echo "<pre>";
print_r($more_infos);
echo "</pre>";
			  
			  if($key == $data_author) {
				  $views_count = $data->view_count;
        ?>
       <div class='trans-colum'>
               
 <?php if (get_option('my_option_name13') == '2') { 
	   }
	   else {
			?>
             <a href="#popupInfo<?php echo $data->post_id ?>" data-rel="popup" data-transition="slide" class="info-icon-pps my-tooltip-btn ui-btn ui-alt-icon ui-btn-inline ui-icon-info ui-btn-icon-notext" title="Learn more"></a>
            <div data-role="popup" id="popupInfo<?php echo $data->post_id ?>" class="ui-content" data-theme="a" style="min-width:100px;">
<a href="#" data-rel="back" class="pps-popup-stats ui-btn ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
        <ul class="browser-stats-wrap">
		 <?php
		 	echo '<li class="chrome-icon">'.$data->chrome_views_total.'</li>';
            echo '<li class="safari-icon">'.$data->safari_views_total.'</li>';
            echo '<li class="firefox-icon">'.$data->firefox_views_total.'</li>';
            echo '<li class="opera-icon">'.$data->opera_views_total.'</li>';
            echo '<li class="ie-icon">'.$data->ie_views_total.'</li>';
            echo '<li class="unknown-icon">'.$data->unknown_views_total.'</li>';
		?>
           
            <!-- <li class="total">0</li> -->
        </ul> 
        <ul class="browser-stats-wrap2">
        <?php
				echo '<li class="computer-icon">'.$data->desktop_views_total.'</li>';
				echo '<li class="mobile-icon">'.$data->mobile_views_total.'</li>';
				echo '<li class="tablet-icon">'.$data->tablet_views_total.'</li>';
				echo '<li class="console-icon">'.$data->console_views_total.'</li>';
		?>
             <!-- <li class="total">0</li> -->
        </ul> 
       <div class="clear"></div>           
</div><!--/popup-->

	   		
	  <?php  } ?>  
       

            <div class='trans-header'><a target="_blank" href="<?php echo get_permalink($data->post_id); ?>"><?php echo $title?$title:'(No Title)' ?></a></div>
          <!--/trans-header-->
          
         <div class='transaction-wrap'>
            <h1>
	
			<?php if (get_option('my_option_name12') == '2') {
			  echo $data->post_id;
	   }
	   else{
			?><a target="_blank" href="<?php echo get_option('siteurl').'/wp-admin/post.php?post='.$data->post_id.'&action=edit' ?>"><?php echo $data->post_id; ?></a>
	   		
	  <?php  } ?>
 
       
       </h1>
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
    
<?php $customPageName =  get_option('my_option_name55');
  		if ($customPageName == ' ' || $customPageName == '') { ?> 
    		<a class="pps-settings-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a>
<?php }?> </div>
  <!--/sr-content-->
  <?php include('includes/panel.php'); ?>
</div>
<!--/page--> 

<!-- <script type="text/javascript"> 
// working on this previously... not near done... trying to retrieve the info from database and display via ajax.
   var ajaxurl = '< ?php echo admin_url('admin-ajax.php'); ?>';
   
	jQuery('#myslicksubmit').on ('click', function(){
	
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
</script> -->
<?php  } ?>