


<div class="section" id="sitemaplist">

	<div class="section-title">Change Password</div>
    
    <div class="section-content padding1">
    	<div class="error hidden"></div>
       <form id="fchangepass" name="f" action="" method="post">
            <div class="button right">
            	<input class="button" type="button" name="save" value="Change" onclick="changePass()"/>
            	<input class="button" type="button" name="cancel" value="<?php echo $button_cancel?>" onclick="linkto('index.php')"/>
            </div>
            <div class="clearer">^&nbsp;</div>
            
            <div class="profile">
            	
                <p>
                	<label>Current Password</label><br />
					<b><input class="text" size="50" name="oldpassword" type="password" value=""/></b>
                </p>
                
                <p>
                	<label>New Password</label><br />
					<b><input class="text" size="50" name="newpassword" type="password"/></b>
                </p>
                
                <p>
                	<label>Confirm New Password</label><br />
					<b><input class="text" size="50" name="confirmpassword" type="password"/></b>
                </p>
            </div>
        
        </form>
    </div>

</div>

<script language="javascript">
function changePass()
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	$.post('?route=common/changepassword/update', $("#fchangepass").serialize(), function(data){
		if(data=="true")
		{
			$.blockUI({ message: "<h1>Your password has been changed</h1>" }); 
			window.location = '?'
		}
		else
		{
			$(".error").html(data).show('slow');
			$.unblockUI();
		}
	});	
}
</script>
      