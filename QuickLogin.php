<?php /*

**************************************************************************

Plugin Name:  Quick Login
Plugin URI:   https://github.com/danielpunkass/QuickLogin
Version:      1.0
Description:  Adds a keyboard shortcut to your blog for easily logging in.
Author:       Daniel Jalkut, Red Sweater Softwaregit
Author URI:   http://www.red-sweater.com/blog/

**************************************************************************/

// If you want to use another keystroke besides ESC, set it here
$triggerKeyCode = 27;

// We depend upon get-current-user type functions, which are not defined by default
// until AFTER the plugin is given a chance to override.
require_once(ABSPATH . WPINC . '/pluggable.php');

// We depend upon jQuery that is bundled with WordPress, for easy keystroke detection
wp_enqueue_script("jquery"); 

function insertQuickLoginTrigger() {

	// When the user "logs in" we send them to the appropriate login page URL, redirecting to current URL
	$loginPageURL = wp_login_url(get_permalink());
	global $triggerKeyCode;
	
	echo <<<TRIGGEREND
	<script type="text/javascript">
	<!-- QuickLogin by Red Sweater Software

	var triggerKeyCode = $triggerKeyCode;

	jQuery(document).keyup(function(e) {
		if (e.keyCode == triggerKeyCode) {
			promptForWordPressLogin();
		}
	});

	function promptForWordPressLogin() {
		document.location.href="$loginPageURL";
	}

	-->
	</script>
TRIGGEREND;
}

$isLoggedIn = is_user_logged_in();

if ($isLoggedIn == False) {
	add_action('wp_head', 'insertQuickLoginTrigger');
}

?>