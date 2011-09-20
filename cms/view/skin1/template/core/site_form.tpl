<div class="section" id="sitemaplist">

	<div class="section-title"><?php echo $heading_title?></div>
    
    <div class="section-content padding1">
    
    	<form name="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        
        	<div class="button right">
            	<input type="submit" value="Save" class="button"/>
     	        <input type="button" value="Cancel" class="button" onclick="linkto('<?php echo $cancel?>')"/>   
     	        <input type="hidden" name="id" value="<?php echo $site['id']?>" />   
            </div>
            <div class="clearer">^&nbsp;</div>
        
        	<div>
            	<p>
            		<label><?php echo $entry_siteid?></label><br />
					<input type="text" name="siteid" value="<?php echo $site['siteid']?>" class="text" size=60 />
                    <i class="error"><?php echo $error['siteid']?></i>
            	</p>
                
                <p>
            		<label><?php echo $entry_sitename?></label><br />
					<input type="text" name="sitename" value="<?php echo $site['sitename']?>" class="text" size=60 />
                    <i class="error"><?php echo $error['sitename']?></i>
            	</p>
                
                <p>
            		<label><?php echo $entry_siteurl?></label><br />
					<input type="text" name="siteurl" value="<?php echo $site['siteurl']?>" class="text" size=60 />
            	</p>
                
                <p>
            		<label><?php echo $entry_language?></label><br />
					<input type="text" name="language" value="<?php echo $site['language']?>" class="text" size=60 />
            	</p>
                
                <p>
            		<label><?php echo $entry_pagetopic?></label><br />
					<input type="text" name="pagetopic" value="<?php echo $site['pagetopic']?>" class="text" size=60 />
            	</p>
                
                <p>
            		<label><?php echo $entry_description?></label><br />
					<input type="text" name="description" value="<?php echo $site['description']?>" class="text" size=60 />
            	</p>
                
                <p>
            		<label><?php echo $entry_status?></label><br />
					<select name="status">
                    <?php
                        foreach($status as $key=>$val)
                        {
                    ?>
						<option value="<?php echo $key?>" <?php if($site['status']==$key) echo "selected"?> >-- <?php echo $val?> --</option>
                    <?php
                        }
                    ?>                                                      
                    </select>
            	</p>
                
            </div>
            
        </form>
    
    </div>
    
</div>

