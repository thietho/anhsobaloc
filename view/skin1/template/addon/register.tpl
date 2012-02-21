<script src='<?php echo HTTP_SERVER.DIR_JS?>ui.datepicker.js' type='text/javascript' language='javascript'> </script>
<div class="ben-post">
	<form id="frmRegister" method="post">
    	<div id="error" class="ben-error" style="display:none"></div>
    	<table class="ben-form">
        	<tr>
            	<td><label>Tên đăng nhập</label></td>
                <td><input type="text" id="username" name="username" class="ben-textbox" size="40"></td>
            </tr>
            <tr>
            	<td><label>Mật khẩu</label></td>
                <td><input type="password" id="password" name="password" class="ben-textbox" size="40"></td>
            </tr>
            <tr>
            	<td><label>Xác nhận mật khẩu</label></td>
                <td><input type="password" id="confirmpassword" name="confirmpassword" class="ben-textbox" size="40"></td>
            </tr>
            <tr>
            	<td><label>Họ và tên</label></td>
                <td><input type="text" id="fullname" name="fullname" class="ben-textbox" size="40"></td>
            </tr>
            <tr>
            	<td><label>Email</label></td>
                <td><input type="text" id="email" name="email" class="ben-textbox" size="40"></td>
            </tr>
            <tr>
            	<td><label>Địa chỉ</label></td>
                <td><input type="text" id="address" name="address" class="ben-textbox" size="40"></td>
            </tr>
            <tr>
            	<td><label>Điện thoại</label></td>
                <td><input type="text" id="phone" name="phone" class="ben-textbox" size="40"></td>
            </tr>
            <tr>
            	<td><label>Ngày sinh</label></td>
                <script language="javascript">
					$(function() {
						$("#birthday").datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'dd-mm-yy'
								});
						});
				 </script>
                <td><input type="text" id="birthday" name="birthday" class="ben-textbox" size="40"></td>
            </tr>
            <tr>
            	<td></td>
                <td><textarea class="ben-textbox" readonly="readonly">Điều khoảng đăng ký</textarea></td>
            </tr>
            <tr>
            	<td></td>
                <td>
                	<input type="checkbox" id="chkaccept" name="chkaccept" value="accept" class="ben-textbox">
                    Tôi đồng ý với điều khoảng trên
                </td>
            </tr>
            <tr>
            	<td></td>
                <td>
                	<input type="button" id="btnRegister" name="btnRegister" class="ben-button" value="Đăng ký">
                </td>
            </tr>
        </table>
    </form>
</div>
<div class="clearer">&nbsp;</div>
<script language="javascript">
$("#btnRegister").click(function(){
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.post("<?php echo HTTP_SERVER?>?route=addon/register/save", $("#frmRegister").serialize(),
		function(data){
			if(data == "true")
			{
				$('#error').html("Bạn đã đăng ký thành công! Mã kích hoạt tài khoảng đã đươc gửi tới email của bạn! <a href='<?php echo HTTP_SERVER?>site/<?php echo $this->member->getSiteId()?>/active'>Kích hoạt tài khoảng click vào đây</a>").show('slow');
				$("#frmRegister").hide();
			}
			else
			{
				
				$('#error').html(data).show('slow');
				
				
			}
			$.unblockUI();
		}
	);					   
});
</script>