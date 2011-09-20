<?php
// Locale
$_['code']                  = 'en';
$_['direction']             = 'ltr';
$_['date_format_short']     = 'd/m/Y';
$_['date_format_long']      = 'l dS F Y';
$_['time_format']           = 'h:i:s A';
$_['decimal_point']         = '.';
$_['thousand_point']        = ',';

// Text
$_['text_home']             = 'Home';
$_['text_yes']              = 'Yes';
$_['text_no']               = 'No';
$_['text_none']             = ' --- None --- ';
$_['text_separator']        = ' &gt; ';

// Buttons
$_['button_continue']       = 'Continue';
$_['button_back']           = 'Back';
$_['button_change_password']= 'Change Password';
$_['button_myprofile']     = 'My Profile';
$_['button_logout']        = 'Log out';

$_['button_add']            = 'Add';
$_['button_edit']           = 'Edit';
$_['button_delete']         = 'Delete';
$_['button_update']         = 'Update Position';
$_['button_cancel']         = 'Cancel';
$_['button_login']          = 'Login';

//Menu
$_['menu_addons']          = 'Add-ons Modules';
$_['menu_myaccount']       = 'My Account';
$_['menu_admin']       = 'Administration';


/*
$d = dir('./catalog/language/'.$filename);
while (false !== ($entry = $d->read())) {
	if($entry != '.' && $entry != '..' && substr($entry, -3, 3) != 'php')
	{
   		foreach(glob('catalog/language/'.$filename.'/'.$entry.'/*.php') as $class_filename) {
   		//echo($class_filename);
		require($class_filename);
		}
	}
}
$d->close();
*/

?>
