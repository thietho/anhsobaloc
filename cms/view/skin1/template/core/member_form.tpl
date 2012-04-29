<script src='<?php echo DIR_JS?>ui.datepicker.js' type='text/javascript' language='javascript'> </script>
<div class="section" id="sitemaplist">

	<div class="section-title"><?php echo $heading_title?>User</div>
    
    <div class="section-content padding1">
    
    	<form id="frm" name="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        
        	<div class="button right">
            	<input type="button" value="Save" class="button" onclick="save()"/>
     	        <input type="button" value="Cancel" class="button" onclick="linkto('<?php echo $cancel?>')"/>   
     	        <input type="hidden" name="id" value="<?php echo $user['id']?>" />   
                <input type="hidden" name="usertypeid" value="member" />   
            </div>
            <div class="clearer">^&nbsp;</div>
        	<div id="error" class="error" style="display:none"></div>
        	<div>
            	<p>
            		<label>User name</label><br />
					<input type="text" name="username" value="<?php echo $user['username']?>" class="text" size=60 <?php echo $usernamereadonly?>/>
                    <i class="error"><?php echo $error['username']?></i>
            	</p>
              	
                <p>
            		<label>Password</label><br />
					<input type="password" name="password"  class="text" size=60 />
                    
            	</p>
                <p>
            		<label>Confrim password</label><br />
					<input type="password" name="confrimpassword" class="text" size=60 />
                    
            	</p>
                
                
                <p>
            		<label>Full name</label><br />
					<input type="text" name="fullname" value="<?php echo $user['fullname']?>" class="text" size=60 autocomplete="on" />
                    <i class="error"><?php echo $error['fullname']?></i>
            	</p>
                <p>
            		<label>Birthday</label><br />
<script language="javascript">
 	$(function() {
		$("#birthday").datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd-mm-yy'
				});
		});
 </script>
					<input type="text" id="birthday" name="birthday" value="<?php echo $this->date->formatMySQLDate($user['birthday'])?>" class="text" size=60/>
                    
            	</p>
                <p>
            		<label>Email</label><br />
					<input type="text" name="email" value="<?php echo $user['email']?>" class="text" size=60 />
                    <i class="error"><?php echo $error['email']?></i>
            	</p>
                <p>
            		<label>Phone</label><br />
					<input type="text" name="phone" value="<?php echo $user['phone']?>" class="text" size=60 />
                    <i class="error"><?php echo $error['phone']?></i>
            	</p>
                <p>
            		<label>Address</label><br />
					<input type="text" name="address" value="<?php echo $user['address']?>" class="text" size=60 />
            	</p>
                <p>
            		<label>Avatar</label><br />
					<p id="pnImage">
                        <label for="image"><?php echo $entry_image?></label><br />
                        <a id="btnAddImage" class="button">Select photo</a><br />
                        <img id="preview" src="<?php echo $user['imagethumbnail']?>" />
                        <input type="hidden" id="imagepath" name="imagepath" value="<?php echo $user['imagepath']?>" />
                        <input type="hidden" id="imageid" name="imageid" value="<?php echo $user['imageid']?><?php echo $imageid?>" />
                        <input type="hidden" id="imagethumbnail" name="imagethumbnail" value="<?php echo $user['imagethumbnail']?>" />
                    </p>
                        
                        
                    <div id="errorupload" class="error" style="display:none"></div>
                    
                    <div class="loadingimage" style="display:none"></div>
            	</p>
            </div>
            
        </form>
    
    </div>
    
</div>
<script language="javascript">
function save()
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.post("?route=core/member/save", $("#frm").serialize(),
		function(data){
			var arr = data.split("-");
			if(arr[0] == "true")
			{
				window.location = "?route=core/member";
			}
			else
			{
			
				$('#error').html(data).show('slow');
				$.unblockUI();
				
			}
			
		}
	);
}
</script>