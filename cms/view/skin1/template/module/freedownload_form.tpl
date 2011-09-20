<div class="section">

	<div class="section-title">
    	<?php echo $breadcrumb?>
    </div>
    
    <div class="section-content padding1">
    
    	<form name="frm" id="frm" action="" method="post" enctype="multipart/form-data">
    
    	<div class="left">
            
            <h3><?php echo $heading_title?></h3>
        
        </div>
        
    	<div class="right">
        	 <input type="button" value="Lưu" class="button" onClick="save()"/>
     	     <input type="button" value="Bỏ qua" class="button" onclick="linkto('?route=module/freedownload&sitemapid=<?php echo $sitemap['sitemapid']?>')"/>   
             <input type="hidden" id="status" name="status" value="<?php echo $item['status']?>" />
             <input type="hidden" id="mediaid" name="mediaid" value="<?php echo $item['mediaid']?>" />
             <input type="hidden" id="mediatype" name="mediatype" value="<?php echo $item['mediatype']?>" />
             <input type="hidden" id="refersitemap" name="refersitemap" value="<?php echo $item['refersitemap']?>" />
        </div>
        <div class="clearer">&nbsp;</div>
        
        
        <div id="container">
        	
            
        	
           
            
            <div id="fragment-content">
            	<div id="error" class="error" style="display:none"></div>
                <div style="<?php echo $displaynews?>">
        			
                    <div class="col2 left">
                    	
                       
                        <p>
                            <label>Tiêu đề</label><br>
                            <input class="text" type="text" name="title" value="<?php echo $item['title']?>" size="60" />
                        </p>
                       
                        <p>
                            
                            
                            <label for="file">File</label><br />
                            <a id="btnAddFile" class="button">Select file</a><br />
                            <span id="filename"><a target="_blank" href="<?php echo DIR_FILE.$item['filepath']?>"><?php echo $this->string->getFileName($item['filepath'])?></a></span>
                            <input type="hidden" id="filepath" name="filepath" value="<?php echo $item['filepath']?>" />
                            <input type="hidden" id="fileid" name="fileid" value="<?php echo $item['fileid']?>" />
                        
                    	</p>
                    
                    
                    <div id="errorupload" class="error" style="display:none"></div>
                    
                    <div class="loadingimage" style="display:none"></div>
                        </p>
                       
                    </div>
                    
                    <div class="col2 right">
                    	
                    	<p id="pnImage">
                            <label for="image">Image</label><br />
                            <a id="btnAddImage" class="button">Select image</a><br />
                            <img id="preview" src="<?php echo $item['imagethumbnail']?>" />
                            <input type="hidden" id="imagepath" name="imagepath" value="<?php echo $item['imagepath']?>" />
                            <input type="hidden" id="imageid" name="imageid" value="<?php echo $item['imageid']?>" />
                            <input type="hidden" id="imagethumbnail" name="imagethumbnail" value="<?php echo $item['imagethumbnail']?>" />
                        </p>
                        
                        
                        <div id="errorupload" class="error" style="display:none"></div>
                        
                        <div class="loadingimage" style="display:none"></div>
                        
                    </div>
                    
                    <div class="clearer">&nbsp;</div>
                
                </div>
                
                <div>
                  
                
                </div>
                
            </div>
            
        
        </div>
        
        </form>
    
    </div>

</div>
<div id="popup" class="hidden"></div>
<script src='<?php echo DIR_JS?>ajaxupload.js' type='text/javascript' language='javascript'> </script>


<script type="text/javascript" charset="utf-8">
function save()
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.post("?route=module/freedownload/save", $("#frm").serialize(),
		function(data){
			
			if(data == "true")
			{
				window.location = "?route=module/freedownload&sitemapid=<?php echo $sitemap['sitemapid']?>";
			}
			else
			{
			
				$('#error').html(data).show('slow');
				$.unblockUI();
				
			}
			
		}
	);
}

var DIR_UPLOADPHOTO = "<?php echo $DIR_UPLOADPHOTO?>";
var DIR_UPLOADATTACHMENT = "<?php echo $DIR_UPLOADATTACHMENT?>";

</script>

<script src="<?php echo DIR_JS?>uploadpreview.js" type="text/javascript"></script>
<script src="<?php echo DIR_JS?>uploadfile.js" type="text/javascript"></script>


