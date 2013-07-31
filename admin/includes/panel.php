<div data-role="panel" id="mypanel">
  <h3>Information</h3>
  <p>Setting this up could not be easier. Just add the amount per view you are paying your authors or whomever. That's it. our system will calculate the total number of views your webpage has received and multiply that by the amount you entered in the field below. We have also added a few color options too.</p>
  <p class="margin-plus"><a href="#popupDialog" data-rel="popup" data-position-to="window" data-role="button" data-mini="true" data-inline="false" data-transition="pop" data-icon="info" data-theme="a">More Details</a></p>
  <div data-role="popup" id="popupDialog" data-overlay-theme="a" data-theme="a" data-dismissible="false" style="max-width:450px;" class="ui-corner-all">
    <div data-role="header" data-theme="a" class="ui-corner-top">
      <h1>SlickRemix's Post Profit Stats</h1>
    </div>
    <div data-role="content" data-theme="c" class="ui-corner-bottom ui-content" >
      <h3 class="ui-title">A Few more details about this plugin</h3>
      <p>The basic idea of this plugin is so you can see the total number of views per user or author with a total and grand total.</p>
      <p>The way we have developed this plugin as you will see, organizes the Author and there totals. Then if you click on an Author you will be taken to that Authors page displaying all of there posts including stats.</p>
      <p>As a bonus we have made it possible for you to change the Sales figures color, and also the Total Sales color too. We figured why not let you have some style while viewing your stats.</p>
      <a href="#" data-role="button" data-inline="true" data-mini="true" data-rel="back" data-theme="c" >close</a> </div>
  </div>
  <style type="text/css">
.sr_split_plugin_wrap .span3 h1, .sr_split_plugin_wrap .transaction-wrap  a {
	color: <?php echo get_option('my_option_name10'); ?> !important;
	text-decoration:none;
}
.sr_split_plugin_wrap .span3 h1.totals, .sr_split_plugin_wrap h2 {
	color: <?php echo get_option('my_option_name11'); ?> !important;
}
</style>
 
  <form method="post" action="options.php">
 <?php
if(is_plugin_active('post-profit-stats-pro/post-profit-stats-pro.php')) { ?>
 
     
  <?php include('../wp-content/plugins/post-profit-stats-pro/includes/pps-pro-settings-fields.php'); } ?>
   
   
    <?php	if(is_plugin_active('post-profit-stats-ent/post-profit-stats-ent.php')) {
          echo ' <br/>';
		  include('../wp-content/plugins/post-profit-stats-ent/includes/pps-ent-settings-fields.php'); }
		 ?>
	
    
    <?php settings_fields( 'myoption-group-pps' ); ?>
   
    <?php	if(is_plugin_active('post-profit-stats-pro/post-profit-stats-pro.php')) {
          echo '<br/><h3>Settings</h3><label for="text-1">Amount Per View.</label>'; }
   			else {
				echo'<h3>Settings</h3><p>This FREE version shows up to 10 users with stats, and one amount per view for all authors. Get up to 50 users and set amount for individual authors per view with our <a href="http://www.slickremix.com/product/post-profit-stats-pro-extension/" target="_blank">Pro Version</a>.</p><label for="text-1">Amount Per View.</label>';		
			}
		 ?>
        
    <input type="text" data-clear-btn="true" name="my_option_name1" id="text-1" value="<?php echo get_option('my_option_name1'); ?>" placeholder="default is .002">
    <label for="text-2">
     <?php	if(is_plugin_active('post-profit-stats-pro/post-profit-stats-pro.php')) {
          echo 'How many users to show per page. Max 50'; }
   			else {
				echo'How many users to show per page. Max. 10';		
			}
		 ?>
         </label>
    <input type="text" data-clear-btn="true" name="my_option_name2" id="text-2" value="<?php echo get_option('my_option_name2'); ?>" placeholder="default is 1">
    
    <!-- additional fields for future use 
    <label for="text-9">Text Here</label>
    <input type="text" data-clear-btn="true" name="my_option_name9" id="text-9" value="< ?php echo get_option('my_option_name9'); ?>" placeholder="default is .30">--> 
    
    <br/>
    <h3>Color Options</h3>
    <label for="text-10">The color for the stats numbers</label>
    <input type="color" data-clear-btn="true" name="my_option_name10" id="text-10" value="<?php echo get_option('my_option_name10'); ?>">
    <label for="text-11">The color of the grand total stats and author detail stats username</label>
    <input type="color" data-clear-btn="true" name="my_option_name11" id="text-11" value="<?php echo get_option('my_option_name11'); ?>">
    <div class="sr-form-border"> <a href="#mypanel"   data-role="button" data-mini="true" data-inline="true">Cancel</a>
      <input type="submit"  data-role="button" data-mini="true" data-inline="true" data-icon="check" data-theme="b" value="<?php _e('Save') ?>" />  
    </div><br/> <br/>
  </form>
  <!-- /panel --> 
</div>