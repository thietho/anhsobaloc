<div class="section">

	<div class="section-title">
    	<?php echo $breadcrumb?>
    </div>
    
    <div class="section-content padding1">
    
    	<form name="InsertContent"  action="" method="post" enctype="multipart/form-data">
    
    	<div class="left">
            
            <h3><?php echo $heading_title?></h3>
        
        </div>
        
    	<div class="right">
        	<input class="button" type="submit" value="Save" />
            <a class="button" href="<?php echo $DIR_CANCEL?>"><?php echo $button_cancel?></a>
             <input type="hidden" id="status" name="status" value="<?php echo $post['status']?>" />
             <input type="hidden" id="mediaid" name="mediaid" value="<?php echo $post['mediaid']?>" />
             <input type="hidden" id="mediatype" name="mediatype" value="<?php echo $post['mediatype']?>" />
             <input type="hidden" id="refersitemap" name="refersitemap" value="<?php echo $post['refersitemap']?>" />
        </div>
        <div class="clearer">&nbsp;</div>
        
        
        <div id="container">
        	
            
        	<ul>
                <li><a href="#fragment-content"><span>Information</span></a></li>
               
                <li><a href="#fragment-detail"><span>Detail</span></a></li>
               
                
            </ul>
           
            
            <div id="fragment-content">
            	
                <div style="<?php echo $displaynews?>">
        			
                    <div class="col2 left">
                    	
                       
                        <p>
                            <label>Title</label><br>
                            <input class="text" type="text" name="title" value="<?php echo $post['title']?>" size="60" />
                        </p>
                        
                        
                        
                        <p>
                            <label>Summary</label><br>
                            <textarea class="text" rows="3" cols="70" name="summary"><?php echo $post['summary']?></textarea>
                        </p>
                        
                    	
                    </div>
                    
                    <div class="col2 right">
                    	
                    	<p id="pnImage">
                            <label for="image">Image</label><br />
                            <a id="btnAddImage" class="button">Select main photo</a><br />
                            <img id="preview" src="<?php echo $post['imagethumbnail']?>" />
                            <input type="hidden" id="imagepath" name="imagepath" value="<?php echo $post['imagepath']?>" />
                            <input type="hidden" id="imageid" name="imageid" value="<?php echo $post['imageid']?>" />
                            <input type="hidden" id="imagethumbnail" name="imagethumbnail" value="<?php echo $post['imagethumbnail']?>" />
                        </p>
                        
                        
                        <div id="errorupload" class="error" style="display:none"></div>
                        
                        <div class="loadingimage" style="display:none"></div>
                        <p>
                        	<a id="btnAddAttachment" class="button">Select other photo</a><br />
                        </p>
                        <p id="attachment">
                        </p>
                    	
                        <span id="delfile"></span>
                        
                    </div>
                   
<script language="javascript">
	$(document).ready(function() {
   	// put all your jQuery goodness in here.
<?php
	if(count($attachment))
		foreach($attachment as $item)
		{
			if(count($item))
			{
?>
			$('#attachment').append(creatAttachmentRow("<?php echo $item['fileid']?>","<?php echo $item['filename']?>","<?php echo $item['imagethumbnail']?>"));
<?php
			}
		}
?>
 	});

</script>
                    <div class="clearer">&nbsp;</div>
                
                </div>
                
               
                
            </div>
            
            <div id="fragment-detail">
            	<a class="button" onclick="browserFileEditor()">Select image</a>
                <input type="hidden" id="listselectfile" name="listselectfile" />
            	<div>
                	<p>
                        <textarea name="description" id="editor1" cols="80" rows="10"><?php echo $description?></textarea>
                    </p>
                </div>
            </div>
            
            
            
            
            
            
        
        </div>
        
        </form>
    
    </div>

</div>
<div id="popup" class="hidden"></div>
<script src='<?php echo DIR_JS?>ajaxupload.js' type='text/javascript' language='javascript'> </script>
<script src="<?php echo DIR_JS?>jquery.tabs.pack.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8">
var DIR_UPLOADPHOTO = "<?php echo $DIR_UPLOADPHOTO?>";
var DIR_UPLOADATTACHMENT = "<?php echo $DIR_UPLOADATTACHMENT?>";
$(document).ready(function() { 
	setCKEditorType('editor1',2);
	
	$('#container').tabs({ fxSlide: true, fxFade: true, fxSpeed: 'slow' });
	
});
</script>

<script src="<?php echo DIR_JS?>uploadpreview.js" type="text/javascript"></script>
<script src="<?php echo DIR_JS?>uploadattament.js" type="text/javascript"></script>



