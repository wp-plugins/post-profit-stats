<?php function pps_system_info_page(){ ?>
<div class="pps-help-admin-wrap"> <a class="buy-extensions-btn" href="http://www.slickremix.com/product-category/wordpress-plugins/" target="_blank">Get Extensions Here!</a>
  <h2>Help & System Info </h2>
  <div class="pps-admin-help-wrap">
  
  <h3>Restart Tour</h3>
    <div class="use-of-plugin"> 
   		<ol>
   			<li><a href="#" id="retake-tour"><strong>Post Profit Stats Tour</strong></a>  </li>
		  <?php if(is_plugin_active('post-profit-stats-pro/post-profit-stats-pro.php')) {
					require_once ABSPATH . '/wp-content/plugins/post-profit-stats-pro/includes/settings-page-retour.php';
				}; ?>
       </ol>
    </div>
    <script type="text/javascript">
     jQuery('#retake-tour').click(function () {
                    //  alert('something');
                        jQuery.ajax({
                            type: 'POST',
                            url: myPPSAjax.ajaxurl,
                            //function/addaction call from functions in plugin
                            data: {action: "pps_wp_pointers_remove" },
                            success: function(data){
                              // alert(data);
                                 console.log('ReTour Worked');
                                 window.location.href = 'plugins.php'; 
                                 return data; 
                                } 
                        });
                    	return false;
       });
    </script>
 <h3>Help</h3>
  
    <div class="use-of-plugin">Are you having trouble and need help? Use our <a href="http://www.slickremix.com/support-forum/" target="_blank">Support Forum</a> and someone will respond to your request asap. Usually we will respond the same day, the latest the following day. You may also find some of the existing posts to be helpfull too, so take a look around first.<br/><br/>If you do submit a question please <a href="#" class="pps-debug-report">generate a report</a> and copy the info, ask your question in our <a href="http://www.slickremix.com/support-forum/" target="_blank">Support Forum</a> then paste the info you just copied. That will help speed things along for sure.<br/><br/>
    If you like our plugin please drop us a <a href='http://wordpress.org/support/view/plugin-reviews/post-profit-stats' target='_blank'>Review</a> on Wordpress. You can also Like Us on <a href='https://www.facebook.com/SlickRemix' target='_blank'>Facebook</a>.</div>
    <h3>System Info</h3>
    <p>Please <a href="#" class="pps-debug-report">click here to generate a report</a> You will need to  paste this information along with your question in our <a href="http://www.slickremix.com/support-forum/" target="_blank">Support Forum</a>. Ask your question then paste the copied text below it. </p>
    <textarea id="pps-debug-report" readonly="readonly"></textarea>
    <table class="wc_status_table widefat" cellspacing="0">
      <thead>
        <tr>
          <th colspan="2"><?php _e( 'Versions', 'ppssystem' ); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php _e('Post Profit Sales Plugin version','ppssystem')?></td>
          <td><?php echo ppssystem_version(); ?></td>
        </tr>
        <tr>
          <td><?php _e('WordPress version','ppssystem')?></td>
          <td><?php if ( is_multisite() ) echo 'WPMU'; else echo 'WP'; ?>
            <?php echo bloginfo('version'); ?></td>
        </tr>
        <tr>
          <td><?php _e('Installed plugins','ppssystem')?></td>
          <td><?php
             			$active_plugins = (array) get_option( 'active_plugins', array() );

             			if ( is_multisite() )
							$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );

						$active_plugins = array_map( 'strtolower', $active_plugins );

						$wc_plugins = array();

						foreach ( $active_plugins as $plugin ) {
							//if ( strstr( $plugin, 'ppssystem' ) ) {

								$plugin_data = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );

	    						if ( ! empty( $plugin_data['Name'] ) ) {

	    							$wc_plugins[] = $plugin_data['Name'] . ' ' . __('by', 'ppssystem') . ' ' . $plugin_data['Author'] . ' ' . __('version', 'ppssystem') . ' ' . $plugin_data['Version'];

	    						}
    						//}
						}

						if ( sizeof( $wc_plugins ) == 0 ) echo '-'; else echo '<ul><li>' . implode( ', </li><li>', $wc_plugins ) . '</li></ul>';

             		?></td>
        </tr>
      </tbody>
      <thead>
        <tr>
          <th colspan="2"><?php _e( 'Server Environment', 'ppssystem' ); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php _e('PHP Version','ppssystem')?></td>
          <td><?php
                    	if ( function_exists( 'phpversion' ) ) echo phpversion();
                    ?></td>
        </tr>
        <tr>
          <td><?php _e('Server Software','ppssystem')?></td>
          <td><?php
                    	echo $_SERVER['SERVER_SOFTWARE'];
                    ?></td>
        </tr>
        <tr>
          <td><?php _e('WP Max Upload Size','ppssystem'); ?></td>
          <td><?php		
                    	echo size_format(wp_max_upload_size() );
                    ?></td>
        </tr>
        <tr>
          <td><?php _e('WP Debug Mode','ppssystem')?></td>
          <td><?php if ( defined('WP_DEBUG') && WP_DEBUG ) echo '<mark class="yes">' . __('Yes', 'ppssystem') . '</mark>'; else echo '<mark class="no">' . __('No', 'ppssystem') . '</mark>'; ?></td>
        </tr>
         <tr>
          <td><?php _e('fsockopen','ftsystem')?></td>
          <td><?php
 if(function_exists('fsockopen')) {
      echo "fsockopen is ON";
 }
 else {
      echo "fsockopen is not enabled and must be set to ON for our plugin to work properly with all feeds.";
 }
 ?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <!--/pps-admin-help-faqs-wrap-->  
<?php $customPageName =  get_option('my_option_name55');
  		if ($customPageName == ' ' || $customPageName == '') { ?> 
    		<a class="pps-settings-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a>
<?php }?>
   </div>
<!--/pps-help-admin-wrap--> 
<script type="text/javascript">
		jQuery('a.pps-debug-report').click(function(){

			if ( ! jQuery('#pps-debug-report').val() ) {

				// Generate report - user can paste into forum
				var report = '`';

				jQuery('thead, tbody', '.wc_status_table').each(function(){

					$this = jQuery( this );

					if ( $this.is('thead') ) {

						report = report + "\n=============================================================================================\n";
						report = report + " " + jQuery.trim( $this.text() ) + "\n";
						report = report + "=============================================================================================\n";

					} else {

						jQuery('tr', $this).each(function(){

							$this = jQuery( this );

							report = report + $this.find('td:eq(0)').text() + ": \t";
							report = report + $this.find('td:eq(1)').text() + "\n";

						});
					}
				});
				report = report + '`';
				jQuery('#pps-debug-report').val( report );
			}
			jQuery('#pps-debug-report').slideToggle('500', function() {
				jQuery(this).select();
			});
      		return false;
		});

	</script>
<?php
}
?>