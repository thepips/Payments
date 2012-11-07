<?php
/**
* @package IPNListener.php
* @copyright (c) DougA http://action-replay.co.uk 2011
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
define('IN_PHPBB', true);
$phpbb_root_path = './'; // See phpbb_root_path documentation
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

// Start session
$user->session_begin();

include($phpbb_root_path . 'includes/paypal_class.' . $phpEx);  			// include the class file

global $db, $user, $auth, $template;
global $config, $phpbb_root_path, $phpEx;

// Paypal is calling page for Express Checkout validation...
$p = new paypal_class();
$result = $p->validate_ipn();
if ($result != 'fail') 
{
	$payment_type = $p->fields['return'];
	if ($payment_type == 'application')
	{
		include($phpbb_root_path . 'includes/'. $payment_type.'_ipn' . $phpEx);
	}
	$p->ipn_processing(); 
}
?>
