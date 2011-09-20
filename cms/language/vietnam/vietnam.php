<?php
// Locale
$_['code']                  = 'vn';
$_['direction']             = 'ltr';
$_['date_format_short']     = 'd/m/Y';
$_['date_format_long']      = 'l dS F Y';
$_['time_format']           = 'h:i:s A';
$_['decimal_point']         = '.';
$_['thousand_point']        = ',';

// Text
$_['text_home']             = 'Trang chủ';

$_['text_time']             = 'Page created in %s seconds';
$_['text_yes']              = 'Yes';
$_['text_no']               = 'No';
$_['text_none']             = ' --- None --- ';
$_['text_select']           = ' --- Please Select --- ';
$_['text_all_zones']        = 'All Zones';
$_['text_pagination']       = 'Showing %s to %s of %s (%s Pages)';
$_['text_separator']        = ' &gt; ';

// Buttons
$_['button_continue']       = 'Tiếp tục';
$_['button_back']           = 'Trở về';
$_['button_change_password']= 'Thay đổi mật khẩu';
$_['button_myprofile']     = 'Thông tin đăng ký';
$_['button_logout']        = 'Đăng xuất';

$_['button_add']            = 'Thêm';
$_['button_edit']           = 'Sửa';
$_['button_delete']         = 'Xóa';
$_['button_update']         = 'Cập nhật Vị trí';
$_['button_cancel']         = 'Bỏ qua';
$_['button_login']          = 'Đăng nhập';


//Menu
$_['menu_addons']          = 'Các chức năng bổ sung';
$_['menu_myaccount']       = 'Cài đặt tài khoản';
$_['menu_admin']       = 'Quản trị hệ thống';

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
