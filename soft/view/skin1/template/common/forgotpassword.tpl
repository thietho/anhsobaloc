<div id="login" class="section">

    <div class="section-title">Quên mật khẩu</div>
	<form id="forgetpassword">
    <div class="error" style="display:none"></div>
    <div class="section-content">
    	<div class="col2 left">  	
            <div>
                <p>
                    <label for="username">Email</label><br>
                    <input type="text" class="text" id="email" name="email" />
                </p>
                <p>
                    <input type="button" class="button" id="btnquenmatkhau" name="btnquenmatkhau" value="Lấy lại mật khẩu"/>
            	</p>
            </div>
        </div>
        <div class="clearer">&nbsp;</div>
    </div>
    </form>
</div>
<script language="javascript">
$('#btnquenmatkhau').click(function(){
	$.post("?route=common/forgotpassword/resetPassword", $("#forgetpassword").serialize(),function(data){
		if(data=='true')
		{
			alert("Bạn vô mail để nhận mật khẩu mới");
			window.location = '?route=common/login';
		}
		else
		{
			$('.error').html(data).show('slow');
		}
	});
});
</script>