<div class="ben-section-title">Đăng nhập</div>

<div class="ben-section-content">
    <form id="frmLoginSiteBar" method="post">
    <table>
        <tr>
            <td><label>Tài khoản</label></td>
            <td><input type="text" id="username" name="username" class="ben-textbox"></td>
        </tr>
        <tr>
            <td><label>Mật khẩu</label></td>
            <td><input type="password" id="password" name="password" class="ben-textbox"></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <p>
                    <input type="button" class="ben-button" id="btnLoginSiteBar" value="Đăng nhập"> <a href="<?php echo $this->document->createLink('register')?>">Đăng ký</a>
                </p>
                
                <input type="checkbox" name="remember" value="1"> Ghi nhớ
                
            </td>
        </tr>
    </table>
    </form>

</div>
<script language="javascript">
$("#btnLoginSiteBar").click(function(){
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.post("<?php echo HTTP_SERVER?>?route=addon/login/login", $("#frmLoginSiteBar").serialize(),
		function(data){
			if(data == "true")
			{
				alert("Bạn đã đăng nhập thành công!");
				//window.location = "<?php echo HTTP_SERVER?>";
				$("#ben-member").load("<?php echo HTTP_SERVER?>?route=sitebar/login/login");
			}
			else
			{
				
				window.location = "<?php echo $this->document->createLink('login')?>";
				
				
			}
			$.unblockUI();
		}
	);					   
});
</script>