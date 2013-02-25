<div class="section" id="moduleform">

	<div class="section-title"><?php echo $title?></div>
    
     <div class="section-content padding1">
     
     	<form name="frm" action="" method="post" enctype="multipart/form-data">
        
        	<div class="button right">
            	<p>
                <input type="submit" value="Save" class="button"/>
           		<input type="button" value="Cancel" class="button" onclick="linkto('?route=core/module')"/>
                </p>
            </div>
            <div class="clearer">^&nbsp;</div>
            
            <div>
            	<p>
                	<label>MouduleID</label><br />
					<input type="text" name="moduleid" value="<?php echo $module['moduleid']?>" class="text" size=60 />
                </p>
                <p>
                	<label>Name</label><br />
					<input type="text" name="modulename" value="<?php echo $module['modulename']?>" class="text" size=60 />
                </p>
                <p>
                	<label>Status</label><br />
					 <select name="status">
                    <?php
                        foreach($status as $key=>$val)
                        {
                    ?>
						<option value="<?php echo $key?>" <?php if($module['status']==$key) echo "selected"?> >-- <?php echo $val?> --</option>
                    <?php
                        }
                    ?>                                                      
                    </select>
                    <input type="hidden" name="position" value="<?php echo $module['position']?>">
                </p>
                <p>
                	<label>Path</label><br />
					<input type="text" name="modulepath" value="<?php echo $module['modulepath']?>" class="text" size=60 />
                </p>
                <p>
                	<label>Permission</label><br />
					<input type="text" name="permission" value="<?php echo $module['permission']?>" class="text" size=60 />
                </p>
            </div>
        
        </form>
     
     </div>

</div>
 
    