<div class="ben-post">
	<form id="frmActive" method="post">
    	<div id="error" class="ben-error" style="display:none"></div>
    	<table>
        	<tr>
            	<td class="ben-right"><label>Tên đăng nhập</label></td>
                <td><input type="text" id="username" name="username" class="ben-textbox" size="40"></td>
            </tr>
            <tr>
            	<td class="ben-right"><label>Mã kích hoạt</label></td>
                <td><input type="text" id="activecode" name="activecode" class="ben-textbox" size="40"></td>
            </tr>
           
            <tr>
            	<td class="ben-right"></td>
                <td>
                	<input type="button" id="btnActive" name="btnActive" class="ben-button" value="Kích hoạt">
                    
                </td>
            </tr>
        </table>
    </form>
</div>
<div class="clearer">&nbsp;</div>
<script language="javascript">
$("#btnActive").click(function(){
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.get("<?php echo HTTP_SERVER?>?route=addon/active/active", $("#frmActive").serialize(),
		function(data){
			if(data == "true")
			{
				alert("Bạn đã kích hoạt tài khoảng thành công!");
				window.location = "<?php echo $this->document->createLink('login')?>";
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