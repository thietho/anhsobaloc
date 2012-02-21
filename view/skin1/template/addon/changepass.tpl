<div>
	<form id="frmChangepass" method="post">
    	<div id="error" class="ben-error" style="display:none"></div>
    	<table>
        	<tr>
            	<td><label>Tên đăng nhập</label></td>
                <td><?php echo $this->member->getId()?></td>
            </tr>
            <tr>
            	<td><label>Mật khẩu củ</label></td>
                <td><input type="password" id="oldpassword" name="oldpassword" class="ben-textbox" size="40"></td>
            </tr>
           <tr>
            	<td><label>Mật khẩu mới</label></td>
                <td><input type="password" id="newpassword" name="newpassword" class="ben-textbox" size="40"></td>
            </tr>
            <tr>
            	<td><label>Xác nhận mật khẩu</label></td>
                <td><input type="password" id="confirmpassword" name="confirmpassword" class="ben-textbox" size="40"></td>
            </tr>
            <tr>
            	<td></td>
                <td>
                	<input type="button" id="btnChangepass" name="btnChangepass" class="ben-button" value="Thay đổi">
                    
                </td>
            </tr>
        </table>
    </form>
</div>
<div class="clearer">&nbsp;</div>
<script language="javascript">
$("#btnChangepass").click(function(){
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.post("<?php echo HTTP_SERVER?>?route=addon/changepass/change", $("#frmChangepass").serialize(),
		function(data){
			if(data == "true")
			{
				alert("Bạn đã đổi mật khẩu thành công!");
				window.location = "<?php echo $this->document->createLink('memberinfor')?>";
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