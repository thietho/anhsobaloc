<script src='<?php echo DIR_JS?>ui.datepicker.js' type='text/javascript' language='javascript'> </script>
<div class="section" id="sitemaplist">

	<div class="section-title"><?php echo $heading_title?>User</div>
    
    <div class="section-content padding1">
    
    	<form name="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        
        	<div class="button right">
            	<input type="submit" value="Save" class="button"/>
     	        <input type="button" value="Cancel" class="button" onclick="linkto('<?php echo $cancel?>')"/>   
     	        <input type="hidden" name="id" value="<?php echo $user['id']?>" />
            </div>
            <div class="clearer">^&nbsp;</div>
        
        	<div>
            	<p>
            		<label>User name</label><br />
					<input type="text" name="username" value="<?php echo $user['username']?>" class="text" size=60 <?php echo $usernamereadonly?>/>
                    <i class="error"><?php echo $error['username']?></i>
            	</p>
              	<?php if($haspass){?>
                <p>
            		<label>Password</label><br />
					<input type="password" name="password" value="<?php echo $user['password']?>" class="text" size=60 />
                    <i class="error"><?php echo $error['password']?></i>
            	</p>
                <p>
            		<label>Confrim password</label><br />
					<input type="password" name="confrimpassword" value="<?php echo $user['confrimpassword']?>" class="text" size=60 />
                    <i class="error"><?php echo $error['confrimpassword']?></i>
            	</p>
                <?php }?>
                <p>
            		<label>User type</label><br />
					<select name="usertypeid">
<?php
	foreach($usertype as $item)
    {
    	$sel="";
    	if($user['usertypeid'] == $item['usertypeid'])
        	$sel='selected="selected"';
?>
						<option value="<?php echo $item['usertypeid']?>" <?php echo $sel?>><?php echo $item[usertypename]?></option>
<?php
    }
?>
                    </select>
            	</p>
                <p>
            		<label>Full name</label><br />
					<input type="text" name="fullname" value="<?php echo $user['fullname']?>" class="text" size=60 />
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
                    <i class="error"><?php echo $error['birthday']?></i>
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
                <p>
            		<label>Country</label><br />
					<select id="country" name="country" onchange="$('#provincecity').load('?route=common/country/getzonescb&countrycode='+this.value);">
<?php
	foreach($countries as $item)
    {
    	$sel="";
    	if($selectcountry == $item['iso_code_2'])
        	$sel='selected="selected"';
?>
						<option value="<?php echo $item['iso_code_2']?>" <?php echo $sel?>><?php echo $item['countryname']?></option>
<?php
    }
?>
                    </select>
                    
            	</p>
                <p>
            		<label>Provincecity</label><br />
					<select id="provincecity" name="provincecity">
                    </select>
            	</p>
            </div>
            
        </form>
    
    </div>
    
</div>

<script src='<?php echo DIR_JS?>ajaxupload.js' type='text/javascript' language='javascript'> </script>
<script src="<?php echo DIR_JS?>jquery.tabs.pack.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8">
var DIR_UPLOADPHOTO = "<?php echo $DIR_UPLOADPHOTO?>";
$(document).ready(function() { 
	$("#provincecity").load('?route=common/country/getzonescb&countrycode='+$("#country").val()+'&selectzone=<?php echo $user["provincecity"]?>');
});
</script>

<script src="<?php echo DIR_JS?>uploadpreview.js" type="text/javascript"></script>