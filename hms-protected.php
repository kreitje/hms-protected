<?php
/*
Plugin Name: HMS Protected
Plugin URI: http://hitmyserver.com
Description: Display a portion of your page or post to guests. Display the full content to loggedin users.
Version: 1.0
Author: HitMyServer LLC
Author URI: http://hitmyserver.com
*/

add_filter('the_content', 'hms_protected_filter');

function hms_protected_filter($content) {

	$pattern = '/\[hms-protected( show_form=\"?(.+?)\"?)?\]/';

	if (!is_user_logged_in()) {
		preg_match($pattern, $content, $matches);
		
		$count = count($matches);
		if ($count>0) {
			$old_content = explode($matches[0], $content);
			$content = $old_content[0];

			if ($count > 2) {
				if ($matches[2] == "true") {
					$content .= wp_login_form(array('echo' => false));
				}		
			}
		}

 	} else
 		$content = preg_replace($pattern, '', $content);
 	
	return $content;
}