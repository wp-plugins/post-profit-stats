<?php
/**
 * Theme Activation Tour For Post Profit Stats Main Plugin
 *
 * This class handles the pointers used in the introduction tour.
 * @package Popup Demo
 *
 */
 
class WordImpress_Theme_Tour {
 
    private $pointer_close_id = 'postprofitstats_tour13'; 
	// MUST CHANGE THIS NAME FOR EACH PLUGIN UPDATE IF WE WANT TO TELL PEOPLE ABOUT NEW CHANGES. THE NUMBER IS THE VERSION OF PLUGIN
    /**
     * Class constructor.
     *
     * If user is on a pre pointer version bounce out.
     */
    function __construct() {
        global $wp_version;
 
        //pre 3.3 has no pointers
        if (version_compare($wp_version, '3.4', '<'))
            return false;
 
        //version is updated ::claps:: proceed
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }
 
    /**
     * Enqueue styles and scripts needed for the pointers.
     */
    function enqueue() {
        if (!current_user_can('manage_options'))
            return;
 
        // Assume pointer shouldn't be shown
        $enqueue_pointer_script_style = false;
 
        // Get array list of dismissed pointers for current user and convert it to array
        $dismissed_pointers = explode(',', get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));
 
        // Check if our pointer is not among dismissed ones
        if (!in_array($this->pointer_close_id, $dismissed_pointers)) {
            $enqueue_pointer_script_style = true;
 
            // Add footer scripts using callback function
            add_action('admin_print_footer_scripts', array($this, 'intro_tour'));
        }
 
        // Enqueue pointer CSS and JS files, if needed
        if ($enqueue_pointer_script_style) {
            wp_enqueue_style('wp-pointer');
            wp_enqueue_script('wp-pointer');
        }
 
    }
 
 
    /**
     * Load the introduction tour
     */
    function intro_tour() {
 
        $adminpages = array(
 
            //array name is the unique ID of the screen @see: http://codex.wordpress.org/Function_Reference/get_current_screen
            'plugins' => array(
                'content' => "<h3>" . __("Welcome to Post Profit Stats", 'textdomain') . "</h3>"
                    . "<p>" . __("You have just installed Post Profit Stats. Congrats! Please take a moment and take our short tour.", 'textdomain') . "</p>", //Content for this pointer
                'id' => 'menu-plugins', //ID of element where the pointer will point
                'position' => array(
                    'edge' => 'left', //Arrow position; change depending on where the element is located
                    'align' => 'center' //Alignment of Pointer
                ),
				'button2' => __('Next', 'textdomain'), //text for the next button
                'function' => 'window.location="' . admin_url('admin.php?page=pps-settings-page&welcome_tour=1') . '";' //where to take the user
            ),
			
			
            'pps-settings-page' => array(
                'content' => '<h3>' . __('Author Total Stats', 'textdomain') . '</h3><p>' . __('This is where you will be able to view the total stats about your Authors and the Grand Totals, make changes to the settings and read more about setting this plugin up.', 'textdomain') . '</p>',
                'id' => 'toplevel_page_pps-settings-page',
                'button2' => __('Next', 'textdomain'),
                'function' => 'window.location="' . admin_url('admin.php?page=pps-single-author&welcome_tour=2') . '";'
            ),
			
			
            'pps-single-author' => array(
                'content' => "<h3>" . __("Author Detail Stats", 'textdomain') . "</h3>"
                    . "<p>" . __("You can view an authors detailed stats here. If you click on an authors name on the previous page it will automatically load this page so you don't have to enter a specific ID to view the detailed stats.", 'textdomain') . "</p>",
                'id' => 'toplevel_page_pps-settings-page',
                'button2' => __('Next', 'textdomain'),
                'function' => 'window.location="' . admin_url('admin.php?page=pps-system-info-submenu-page&welcome_tour=3') . '";',
            ),
			
			
            'pps-system-info-submenu-page' => array(
                'content' => "<h3>" . __("Help / System Info", 'textdomain') . "</h3>"
                    . "<p>" . __("Here you can find more help and info. If you would like to post on our forum about a particular problem please make sure to copy the info about your system info. <br/><br/>If you like our plugin please drop us a <a href='http://wordpress.org/support/view/plugin-reviews/post-profit-stats' target='_blank'>review</a> on wordpress. You can also Like Us on <a href='https://www.facebook.com/SlickRemix' target='_blank'>facebook</a>. Thanks for taking our tour!", 'textdomain') . "</p>",
                'id' => 'toplevel_page_pps-settings-page',
            ),
        );
 
        $page = '';
        $screen = get_current_screen();
 
 
        //Check which page the user is on
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }
        if (empty($page)) {
            $page = $screen->id;
        }
 
        $function = '';
        $button2 = '';
        $opt_arr = array();
 
        //Location the pointer points
        if (!empty($adminpages[$page]['id'])) {
            $id = '#' . $adminpages[$page]['id'];
        } else {
            $id = '#' . $screen->id;
        }
 
 
        //Options array for pointer used to send to JS
        if ('' != $page && in_array($page, array_keys($adminpages))) {
            $align = (is_rtl()) ? 'right' : 'left';
            $opt_arr = array(
                'content' => $adminpages[$page]['content'],
                'position' => array(
                    'edge' => (!empty($adminpages[$page]['position']['edge'])) ? $adminpages[$page]['position']['edge'] : 'left',
                    'align' => (!empty($adminpages[$page]['position']['align'])) ? $adminpages[$page]['position']['align'] : $align
                ),
                'pointerWidth' => 400
            );
			
            if (isset($adminpages[$page]['button2']) && isset($adminpages[$page]['button2'])) {
                $button2 = (!empty($adminpages[$page]['button2'])) ? $adminpages[$page]['button2'] : __('Next', 'textdomain');
            }
            if (isset($adminpages[$page]['function'])) {
                $function = $adminpages[$page]['function'];
            }
			 if (isset($adminpages[$page]['function2'])) {
                $function = $adminpages[$page]['function2'];
            }
        }
 
        $this->print_scripts($id, $opt_arr, __("Close", 'textdomain'), $button2, $function, $button3, $function2);
    }
 
 
    /**
     * Prints the pointer script
     *
     * @param string $selector The CSS selector the pointer is attached to.
     * @param array $options The options for the pointer.
     * @param string $button1 Text for button 1
     * @param string|bool $button2 Text for button 2 (or false to not show it, defaults to false)
     * @param string $button2_function The JavaScript function to attach to button 2
     * @param string $button1_function The JavaScript function to attach to button 1
     */
    function print_scripts($selector, $options, $button1, $button2 = false, $button2_function = '', $button1_function = '') {
        
		
		?>
        <script>

            //<![CDATA[
            (function ($) {
                var wordimpress_pointer_options = <?php echo json_encode( $options ); ?>, setup;
                //Userful info here
                wordimpress_pointer_options = $.extend(wordimpress_pointer_options, {
                    buttons: function (event, t) {
                        button = jQuery('<a id="pointer-close" class="button-secondary">' + '<?php echo $button1; ?>' + '</a> ');
                        button.bind('click.pointer', function () {
                            t.element.pointer('close');
                        });
                        return button;
                    }
                });
 
                setup = function () {
                    $('<?php echo $selector; ?>').pointer(wordimpress_pointer_options).pointer('open');
				 jQuery('#pointer-close').after('<style>body.plugins-php #pointer-back { display:none }</style><a id="pointer-back" class="button-primary" style="float:left;" href="javascript:history.back();">Back</a>');
                    <?php 
                    if ( $button2 ) { ?>
                    jQuery('#pointer-close').after('<a id="pointer-primary" class="button-primary" style=" float:left; margin-right:5px;">' + '<?php echo $button2; ?>' + '</a> ');
                    <?php } ?>
					
					
                    jQuery('#pointer-primary').click(function () {
                        <?php echo $button2_function; ?>
                    });
                    jQuery('#pointer-close').click(function () {
                        <?php if ( $button1_function == '' ) { ?>
                        $.post(ajaxurl, {
                            pointer: '<?php echo $this->pointer_close_id; ?>', // pointer ID
                            action: 'dismiss-wp-pointer',
							success: function(data){
							// alert(data);
							 console.log('Count Processed')
							 // this if statement says if this plugin is active and the pointer key is not found in the DB then take the user back to the plugin.php page to restart the next tour
							 <?php if(is_plugin_active('post-profit-stats-pro/post-profit-stats-pro.php')) {
								 require_once ABSPATH . '/wp-content/plugins/post-profit-stats-pro/includes/welcome-notes-includes.php';
							   }; ?>
							 return data; 
							} 
                        });
                        <?php } else { ?>
                        <?php echo $button1_function; } ?>
                    });
                };
 
                if (wordimpress_pointer_options.position && wordimpress_pointer_options.position.defer_loading) {
                    $(window).bind('load.wp-pointers', setup);
                } else {
 
                    $(document).ready(setup);
                }
 
            })(jQuery);
            //]]>
        </script>
    <?php
    }
}
$wordimpress_theme_tour = new WordImpress_Theme_Tour();