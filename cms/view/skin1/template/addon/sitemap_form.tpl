<div class="section" id="sitemaplist">

	<div class="section-title"><?php echo $heading_title?></div>
    
    <div class="section-content padding1">
    	
        <form name="frm" action="" method="post" enctype="multipart/form-data">
        	<div class="button left">
            	<h3>Add New Sitemap</h3>
            </div>
            
            <div class="button right">
            	<input type="submit" value="Save" class="button"/>
	            <input type="button" value="Cancel" class="button" onclick="linkto('?route=core/sitemap')"/>
            </div>
            <div class="clearer">^&nbsp;</div>
        	<p>
            	<label>ID</label><br />
            	<input type="text" name="sitemapid" value="<?php echo $sitemap['sitemapid']?>" class="text" size="80"/>
                <?php echo $errors['sitemapid']?>
            </p>
            <p>
            	<label>Parent</label><br />
            	<select name="sitemapparent">
                    <option value="">Root</option>
<?php
foreach($sitemapparent as $result)
{
    
?>
                    <option value="<?php echo $result['sitemapid']?>" <?php if($sitemap['sitemapparent']==$result['sitemapid']) echo "selected" ?> ><?php echo $result['sitemapname']?></option>
<?php
    
}
?>    
                </select>
                <?php echo $errors['sitemapparent']?>
            </p>
        
        	<p>
            	<label>Name</label><br />
            	<input type="text" name="sitemapname" value="<?php echo $sitemap['sitemapname']?>" class="text" size="80"/>
                <?php echo $errors['sitemapname']?>
            </p>
            
            
            
            <p>
                <label>Module</label>
            	<select name="moduleid">
<?php
	foreach($modules as $key => $item)
    {
?>
                    <option value="<?php echo $key?>" <?php if($key==$sitemap['moduleid']) echo "selected" ?>><?php echo $item?></option>
<?php
}
?>
                </select>
                 &nbsp;&nbsp;&nbsp;&nbsp;
                <label><?php echo $text_status?></label>
                <select name="status">
<?php
foreach($status as $key=>$val)
{
?>
                    <option value="<?php echo $key?>" <?php if($sitemap['status']==$key) echo "selected"?> >-- <?php echo $val?> --</option>
<?php
}
?>
                        
                                                       
                    </select>
            </p>
            
            
        
        </form>
    
    </div>
    
</div>       
<!-- main indent-->
