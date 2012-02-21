<div class="section">

	<div class="section-title">
    	<?php echo $breadcrumb?>
    </div>
    
    <div class="section-content padding1">
    
    	<form name="InsertContent"  action="" method="post" enctype="multipart/form-data">
    
    	<div class="left">
            
            <h3><?php echo $heading_title?>Message</h3>
        
        </div>
        
    	<div class="right">
            <a class="button" href="<?php echo $reply?>"/>Reply</a>
            <a class="button" href="#" onclick="javascript:history.go(-1)"/>Cancel</a>
        </div>
        <div class="clearer">&nbsp;</div>
        
        
        <div id="container">           
            
            <div id="fragment-1">
            	
                <div style="<?php echo $displaynews?>">
        			
                    <div>
                        <p>
                            <label>From:</label><br>
                            <?php echo $from?>
                        </p>
                        <p>
                            <label>To:</label><br>
                            <?php echo $to?>
                        </p>
                        <p>
                            <label>Subject:</label><br>
                            <?php echo $title?>
                        </p>
                    </div>                
                </div>
                <div>
<?php
                
		if(count($attachmentfile)>0)
		{
			
			foreach($attachmentfile as $item)
			{
				if(count($item))
				{
?>
					<p>
						<img src="<?php echo $item['imagethumbnail']?>" />
                        <?php echo $item['filename']?>
                        <a href="<?php echo DIR_FILE?><?php echo $item['filepath']?>" target="_blank">Download</a>
                    </p>
<?php
				}
			}
		}
?>
					
				</div>
                <div>
                    <p>
                        <?php echo html_entity_decode($description)?>
                    </p>  
                </div>
                
            </div>
        </div>
        
        </form>
    
    </div>

</div>

<script src='<?php echo DIR_JS?>ajaxupload.js' type='text/javascript' language='javascript'> </script>
<script src="<?php echo DIR_JS?>jquery.tabs.pack.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8">
var DIR_UPLOADATTACHMENT = "<?php echo $DIR_UPLOADATTACHMENT?>";
</script>

<script src="<?php echo DIR_JS?>uploadattament.js" type="text/javascript"></script>