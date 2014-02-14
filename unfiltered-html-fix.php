<?php
/**
 * Plugin Name: Unfiltered_html fix
 * Plugin URI: https://github.com/andreascreten/unfiltered-html-fix
 * Description: Fix issue with unfiltered_html on WordPress Networks
 * Version: 1.0
 * Author: Andreas Creten
 * Author URI: http://twitter.com/andreascreten
 */

add_filter('map_meta_cap','unfiltered_html_fix', 10, 4);

/**
 * Modify the caps list to add the unfiltered_html cap again if needed
 *
 * @param $caps
 * @param $cap
 * @param $user_id
 * @param $args
 * @return array Updated list of caps
 */
function unfiltered_html_fix($caps, $cap, $user_id, $args) {
	// Check if the unfilter_html cap is requested
	if('unfiltered_html' == $cap) {
		// Check if there is a not allowed entry
		$key = array_search('do_not_allow', $caps);
		if (is_int($key)) {
			// Get the users' data
			$userdata = get_userdata($user_id);

			// I fthe user has the unfiltered_html cap, remove the do_not_allow entry from the caps array
			if(array_key_exists('unfiltered_html', $userdata->allcaps) && $userdata->allcaps['unfiltered_html']) {
				unset($caps[$key]);
			}
		}
	}

	// Return the updated caps
	return $caps;
}