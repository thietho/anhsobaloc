
	<div class="ben-section-title">Thông tin thành viên</div>
    <div class="ben-section-content">
    	<p>
    		<?php echo $member['fullname']?> (<?php echo $member['username']?>)
    	</p>
        <p>
        	<a href="<?php echo $this->document->createLink('memberinfor')?>">Thông tin cá nhân</a>
        </p>
        <p>
        	<a href="<?php echo $this->document->createLink('changepass')?>">Đổi mật khẩu</a>
        </p>
        <p>
        	<a href="<?php echo $this->document->createLink('historyorder')?>">Lịch sử mua hàng</a>
        </p>
        <p>
        	<a href="<?php echo $this->document->createLink('message')?>">Hộp thư</a>
        </p>
        <p>
        	<a href="#" onclick="logout()">Đăng xuất</a>
        </p>
    </div>

<script language="javascript">
function logout()
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.get("<?php echo HTTP_SERVER?>?route=sitebar/login/logout", 
		function(data){
			if(data == "true")
			{
				alert("Bạn đã đăng xuất thành công!");
				//window.location = "<?php echo HTTP_SERVER?>site/default/login";
				window.location = HTTP_SERVER;
			}
			else
			{
				
				$('#error').html(data).show('slow');
				
				
			}
			$.unblockUI();
		}
	);	
}
</script>