
<div class="section" id="sitemaplist">

	<div class="section-title"><?php echo $heading_title?>User</div>
    
    <div class="section-content padding1">
    
    	<form name="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        
        	<div class="button right">
            	
     	        <input type="button" value="Back" class="button" onclick="linkto('<?php echo $cancel?>')"/>   
     	       
            </div>
            <div class="clearer">^&nbsp;</div>
        
        	<div>
            	<p>
            		<label>User name</label><br />
					<?php echo $user['username']?>
            	</p>
              	
                <p>
            		<label>Full name</label><br />
					<?php echo $user['fullname']?>
                    
            	</p>
                <p>
            		<label>Birthday</label><br />
					<?php echo $this->date->formatMySQLDate($user['birthday'])?>
                    
            	</p>
                <p>
            		<label>Email</label><br />
					<?php echo $user['email']?>
                    
            	</p>
                <p>
            		<label>Phone</label><br />
					<?php echo $user['phone']?>
                   
            	</p>
                <p>
            		<label>Address</label><br />
					<?php echo $user['address']?>
            	</p>
                <p>
            		<label>Avatar</label><br />
                    <img id="preview" src="<?php echo $user['imagethumbnail']?>" />
            	</p>
                
            
        </form>
    
    </div>
    
</div>

