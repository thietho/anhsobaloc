<div class="section" id="sitemaplist">

	<div class="section-title">USER PROFILE</div>
    
    <div class="section-content padding1">
    	
        <form name="frm" action="" method="post" enctype="multipart/form-data">
            <div class="button right">
            	<input class="button" type="submit" name="save" value="Save/Send request"/>    
            	<input class="button" type="button" name="cancel" value="Back to homepage" onclick="linkto('index.php')"/>  
            </div>
            <div class="clearer">^&nbsp;</div>
            
            <div class="profile">
            	
            	<p>
                	<label>Fullname</label>
					<b><?php echo $userProfile['fullname']?></b>
                </p>
                
                <p>
                	<label>Username</label>
					<b><?php echo $userProfile['username']?></b>
                </p>
                
                <p>
                	<label>Password</label>
					<a href="?route=common/changepassword">Change password</a>
                </p>
                
                <p>
                	<label>Email</label>
					<?php echo $userProfile['email']?>
                </p>
                
                <p>
                	<label>Personal ID</label>
					<?php echo $userProfile['personalid']?>
                </p>
                
                <p>
                	<label>Birthday</label>
					<?php echo $userProfile['birthday']?>
                </p>
                
                <p>
                	<label>Phone</label>
					<?php echo $userProfile['phone']?>
                </p>
                
                <p>
                	<label>Address</label>
					<?php echo $userProfile['address']?>
                </p>
                
                <p>
                	<label>Provine/City</label>
					<?php echo $userProfile['provincecity']?>
                </p>
                
                <p>
                	<label>Country</label>
					<?php echo $userProfile['country']?>
                </p>
                
            
            </div>
        
        </form>
    </div>

</div>

<style>
	.profile label{display:inline-block; width:100px}
</style>