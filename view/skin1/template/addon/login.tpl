<div>
    <form id="frmLogin" method="post">
    	<div id="error" class="ben-error" style="display:none"></div>
        <table>
            <tr>
                <td class="ben-right"><label>Tên đăng nhập</label></td>
                <td><input type="text" id="username" name="username" class="ben-textbox"></td>
            </tr>
            <tr>
                <td class="ben-right"><label>Mật khẩu</label></td>
                <td><input type="password" id="password" name="password" class="ben-textbox"></td>
            </tr>
            <tr>
                <td class="ben-right"></td>
                <td>
                    <p>
                        <input type="button" class="ben-button" id="btnLogin" value="Đăng nhập"> <a href="<?php echo HTTP_SERVER?>site/<?php echo $this->member->getSiteId()?>/register">Đăng ký</a>
                    </p>
                    
                    <input type="checkbox" name="remember" value="1"> Ghi nhớ
                    
                </td>
            </tr>
        </table>
    </form>
</div>
<script language="javascript">
$("#btnLogin").click(function(){
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.post("<?php echo HTTP_SERVER?>?route=addon/login/login", $("#frmLogin").serialize(),
		function(data){
			if(data == "true")
			{
				alert("Bạn đã đăng nhập thành công!");
				window.location = "<?php echo HTTP_SERVER?>";
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