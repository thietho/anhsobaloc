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

$_['text_news']        		= 'Tin tức & Sự kiện';
$_['text_hitcounter']       = 'Số lượt truy cập';
$_['text_numberonline']     = 'Số người đang online';
$_['text_numberaccess']       = 'Số lượt truy cập';

$_['text_detail']       = 'Chi tiết';
$_['text_order']       	= 'Đặt hàng';
$_['text_hotline']       	= 'HOTLINE';

$_['text_cart']       	= 'Giỏ hàng';
$_['text_viewcart']       	= 'Xem giỏ hàng';
$_['text_image']       	= 'Hình';
$_['text_productname']       	= 'Tên sản phẩm';
$_['text_price']       	= 'Giá';
$_['text_qty']       	= 'Số lượng';
$_['text_subtolal']       	= 'Thành tiền';
$_['text_tolal']       	= 'Tổng cộng';
$_['text_continueshopping']       	= 'Tiếp tục mua hàng';
$_['text_payment']       	= 'Thanh toán';

$_['text_orderinformation']       	= 'Thông tin đơn hàng';
$_['text_fullname']       	= 'Họ và tên';
$_['text_email']       	= 'Email';
$_['text_address']       	= 'Địa chỉ';
$_['text_phone']       	= 'Điện thoại';
$_['text_fax']       	= 'Fax';
$_['text_company']       	= 'Công ty';
$_['text_note']       	= 'Ghi chú';


$_['text_register']       	= 'Đăng ký thành viên';
$_['text_login']       	= 'Đăng nhập tài khoản';
$_['text_customerinformation']       	= 'Thông tin khách hàng';

//Warring
$_['war_usernamenotnull'] = 'Bạn chưa nhập tên đăng nhập';
$_['war_usernamenotavailable'] = 'Tên đăng nhập đã đươc sử dụng';
$_['war_passwordnotnull'] = 'Bạn chưa nhập mật khẩu';
$_['war_passwordnotcorrect'] = 'Mật khẩu không đúng';
$_['war_confirmpasswordnotnull'] = 'Bạn chưa nhập xác nhận mật khẩu';
$_['war_confirmpasswordnotcorrect'] = 'Bạn chưa nhập xác nhận mật khẩu';
$_['war_fullnamenotnull'] = 'Bạn chưa nhập họ tên';
$_['war_emailnotnull'] = 'Bạn chưa nhập email';
$_['war_emailnotformate'] = 'Email không đúng định dạng';
$_['war_emailhasused'] = 'Email đã được sử dụng';
$_['war_emailnotavailable'] = 'Không tồn tại email này';
$_['war_addressnotnull'] = 'Bạn chưa nhập địa chỉ';
$_['war_phonenotnull'] = 'Bạn chưa nhập số điên thoại';
$_['war_descriptionnotnull'] = 'Bạn chưa nhập lời nhắn';
$_['war_accountnotactive1'] = 'Tài khoản của bạn chưa được kích hoạt!';
$_['war_accountnotactive2'] = 'Kích hoạt tài khoản click vào đây';

$_['war_younotagree'] = 'Bạn chưa đồng ý với chúng tôi';

$_['war_contactsuccess'] = 'Thông tin của bạn đã gửi đến chúng tôi';


// Buttons
$_['button_continue']       = 'Tiếp tục';
$_['button_back']           = 'Trở về';
$_['button_change_password'] = 'Thay đổi mật khẩu';
$_['button_edit']           = 'Sửa';
$_['button_delete']         = 'Xóa';
$_['button_reviews']        = 'Nhận xét';
$_['button_write']          = 'Viết nhận xét';
$_['button_login']          = 'Đăng nhập';
$_['button_update']         = 'Cập nhật';
$_['button_shopping']       = 'Tiếp tục mua hàng';
$_['button_checkout']       = 'Đặt hàng';
$_['button_view']           = 'Xem chi tiết';
$_['button_search']         = 'Tìm kiếm';
$_['button_close']         = 'Đóng';
$_['button_send']        	= 'Gửi đến chúng tôi';
$_['button_reset']         = 'Làm lại';

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
