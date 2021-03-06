<?php
$u_agent = null;
			if( is_null($u_agent) && isset($_SERVER['HTTP_USER_AGENT']) ) $u_agent = $_SERVER['HTTP_USER_AGENT'];

    $platform = null;
    $browser  = null;
    $version  = null;

    $empty = array( 'platform' => $platform, 'browser' => $browser, 'version' => $version );

    if( !$u_agent ) return $empty;

    if( preg_match('/\((.*?)\)/im', $u_agent, $parent_matches) ) {

        preg_match_all('/(?P<platform>Android|CrOS|iPhone|iPad|Linux|Macintosh|Windows(\ Phone\ OS)?|Silk|linux-gnu|BlackBerry|PlayBook|Nintendo\ (WiiU?|3DS)|Xbox)
            (?:\ [^;]*)?
            (?:;|$)/imx', $parent_matches[1], $result, PREG_PATTERN_ORDER);

        $priority           = array( 'Android', 'Xbox' );
        $result['platform'] = array_unique($result['platform']);
        if( count($result['platform']) > 1 ) {
            if( $keys = array_intersect($priority, $result['platform']) ) {
                $platform = reset($keys);
            } else {
                $platform = $result['platform'][0];
            }
        } elseif( isset($result['platform'][0]) ) {
            $platform = $result['platform'][0];
        }
    }

    if( $platform == 'linux-gnu' ) {
        $platform = 'Linux';
    } elseif( $platform == 'CrOS' ) {
        $platform = 'Chrome OS';
    }

    preg_match_all('%(?P<browser>Camino|Kindle(\ Fire\ Build)?|Firefox|Iceweasel|Safari|MSIE|Trident/.*rv|AppleWebKit|Chrome|IEMobile|Opera|OPR|Silk|Lynx|Midori|Version|Wget|curl|NintendoBrowser|PLAYSTATION\ (\d|Vita)+)
            (?:\)?;?)
            (?:(?:[:/ ])(?P<version>[0-9A-Z.]+)|/(?:[A-Z]*))%ix',
        $u_agent, $result, PREG_PATTERN_ORDER);


    // If nothing matched, return null (to avoid undefined index errors)
    if( !isset($result['browser'][0]) || !isset($result['version'][0]) ) {
        return $empty;
    }

    $browser = $result['browser'][0];
    $version = $result['version'][0];

    $find = function ( $search, &$key ) use ( $result ) {
        $xkey = array_search(strtolower($search),array_map('strtolower',$result['browser']));
        if( $xkey !== false ) {
            $key = $xkey;

            return true;
        }

        return false;
    };

    $key = 0;
    if( $browser == 'Iceweasel' ) {
        $browser = 'Firefox';
    }elseif( $find('Playstation Vita', $key) ) {
        $platform = 'PlayStation Vita';
        $browser  = 'Browser';
    } elseif( $find('Kindle Fire Build', $key) || $find('Silk', $key) ) {
        $browser  = $result['browser'][$key] == 'Silk' ? 'Silk' : 'Kindle';
        $platform = 'Kindle Fire';
        if( !($version = $result['version'][$key]) || !is_numeric($version[0]) ) {
            $version = $result['version'][array_search('Version', $result['browser'])];
        }
    } elseif( $find('NintendoBrowser', $key) || $platform == 'Nintendo 3DS' ) {
        $browser = 'NintendoBrowser';
        $version = $result['version'][$key];
    } elseif( $find('Kindle', $key) ) {
        $browser  = $result['browser'][$key];
        $platform = 'Kindle';
        $version  = $result['version'][$key];
    } elseif( $find('OPR', $key) ) {
        $browser = 'Opera Next';
        $version = $result['version'][$key];
    } elseif( $find('Opera', $key) ) {
        $browser = 'Opera';
        $find('Version', $key);
        $version = $result['version'][$key];
    }elseif ( $find('Chrome', $key) ) {
        $browser = 'Chrome';
        $version = $result['version'][$key];
    } elseif( $find('Midori', $key) ) {
        $browser = 'Midori';
        $version = $result['version'][$key]; 
    } elseif( $browser == 'AppleWebKit' ) {
        if( ($platform == 'Android' && !($key = 0)) ) {
            $browser = 'Android Browser';
        } elseif( $platform == 'BlackBerry' || $platform == 'PlayBook' ) {
            $browser = 'BlackBerry Browser';
        } elseif( $find('Safari', $key) ) {
            $browser = 'Safari';
        }

        $find('Version', $key);

        $version = $result['version'][$key];
    } elseif( $browser == 'MSIE' || strpos($browser, 'Trident') !== false ) {
        if( $find('IEMobile', $key) ) {
            $browser = 'IEMobile';
        } else {
            $browser = 'MSIE';
            $key     = 0;
        }
        $version = $result['version'][$key];
    } elseif( $key = preg_grep("/playstation \d/i", array_map('strtolower', $result['browser']))) {
        $key = reset($key);

        $platform = 'PlayStation ' . preg_replace('/[^\d]/i', '', $key);
        $browser  = 'NetFront';
    }
	
	$platforms = array(
    'Desktop' => array('Windows','Linux','Macintosh','Chrome OS'),
    'Mobile' => array('Android','iPhone','Windows Phone OS','BlackBerry'),
	'Tablet' => array('iPad','Kindle','Kindle Fire','Playbook'),
    'Console' => array('Nintendo 3DS','Nintendo Wii','Nintendo WiiU','PlayStation 3','PlayStation Vita','Xbox 360')
	);
	
	foreach($platforms as $k=>$v){
		foreach($v as $pl){if($pl == $platform){$device = $k;break;}                        
		}
	}
			
			
			$unknown_browser ='yes';
			  if ($browser =='Chrome'){
				  $browser_column = 'chrome_views';
					  $unknown_browser='no';
			  }
			  if ($browser =='Safari'){
				  $browser_column = 'safari_views';
					  $unknown_browser='no';
			  }
			  if ($browser =='Firefox'){
				  $browser_column = 'firefox_views';
					  $unknown_browser='no';
			  }
			  if ($browser =='Opera' or $browser =='Opera Next'){
				  $browser_column = 'opera_views';
					  $unknown_browser='no';
			  }
			  if ($browser =='MSIE'){
				  $browser_column = 'ie_views';
					  $unknown_browser='no';
			  }
			  if($unknown_browser =='yes') {
				  $browser_column = 'unknown_views';
  			  }
			  				
			  //Device
			  if ($device =='Desktop'){
				  $device_column = 'desktop_views';
			  }
			  if ($device =='Mobile'){
				  $device_column = 'mobile_views';
			  }
			  if ($device =='Tablet'){
				  $device_column = 'tablet_views';
			  }
			  if ($device =='Console'){
				  $device_column = 'console_views';
			  } 
		 
?>