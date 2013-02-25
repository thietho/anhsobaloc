<script src='<?php echo DIR_JS?>ui.datepicker.js' type='text/javascript' language='javascript'> </script>
<div class="section" id="sitemaplist">

	<div class="section-title">Traning</div>
    
    <div class="section-content padding1">
    
    	<form name="frm" id="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        
        	<div class="button right">
            	<input type="button" value="Save" class="button" onClick="save()"/>
     	        <input type="button" value="Cancel" class="button" onclick="linkto('?route=module/traning&sitemapid=<?php echo $sitemap['sitemapid']?>')"/>   
     	        <input type="hidden" name="mediaid" value="<?php echo $item['mediaid']?>">
                <input type="hidden" id="status" name="status" value="<?php echo $item['status']?>" />
             	<input type="hidden" id="mediatype" name="mediatype" value="traning" />
             	<input type="hidden" id="refersitemap" name="refersitemap" value="<?php echo $item['refersitemap']?>" />
            </div>
            <div class="clearer">^&nbsp;</div>
        	<div id="error" class="error" style="display:none"></div>
            <div id="container">
        	
            
                <ul>
                    <li><a href="#fragment-content"><span>Traning information</span></a></li>
                    <li><a href="#fragment-detail"><span>Detail</span></a></li>
                </ul>
                <div id="fragment-content">
                    
                    <div>
                        
                        <div class="col2 left">
                            
                            
                            <p>
                                <label><?php echo $text_title?></label><br>
                                <input class="text" type="text" name="title" value="<?php echo $item['title']?>" size="60" />
                            </p>
                            
                            
                            
                            <p>
                                <label>Summary</label><br>
                                <textarea class="text" rows="3" cols="70" name="summary"><?php echo $item['summary']?></textarea>
                            </p>
                            
                            <p>
                            	<script language="javascript">
									$(function() {
										$("#startdate").datepicker({
												changeMonth: true,
												changeYear: true,
												dateFormat: 'dd-mm-yy'
												});
										});
								 </script>
                                <label>Start date</label><br>
                                <input class="text" type="text" id="startdate" name="startdate" value="<?php echo $this->date->formatMySQLDate($item['startdate'])?>" size="60" />
                            </p>
                            
                            <p>
                            	<script language="javascript">
									$(function() {
										$("#enddate").datepicker({
												changeMonth: true,
												changeYear: true,
												dateFormat: 'dd-mm-yy'
												});
										});
								 </script>
                                <label>End date</label><br>
                                <input class="text" type="text" id="enddate" name="enddate" value="<?php echo $this->date->formatMySQLDate($item['enddate'])?>" size="60" />
                            </p>
                            
                        </div>
                        
                        <div class="col2 right">
                            
                            <p id="pnImage">
                                <label for="image">Image</label><br />
                                <a id="btnAddImage" class="button">Select photo</a><br />
                                <img id="preview" src="<?php echo $item['imagethumbnail']?>" />
                                <input type="hidden" id="imagepath" name="imagepath" value="<?php echo $item['imagepath']?>" />
                                <input type="hidden" id="imageid" name="imageid" value="<?php echo $item['imageid']?>" />
                                <input type="hidden" id="imagethumbnail" name="imagethumbnail" value="<?php echo $item['imagethumbnail']?>" />
                            </p>
                            
                            
                            <div id="errorupload" class="error" style="display:none"></div>
                            
                            <div class="loadingimage" style="display:none"></div>
                            <p>
                                <a id="btnAddAttachment" class="button">Other photo</a><br />
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
                    
                    <div>
                        
                        
                        
                  
                       
                    
                    </div>
                    
                </div>
                
                <div id="fragment-detail">
                    <a class="button" onclick="browserFileEditor()">Select image</a>
                    <input type="hidden" id="listselectfile" name="listselectfile" />
                    <div>
                        <p>
                            <textarea name="description" id="description" cols="80" rows="10"><?php echo $item['description']?></textarea>
                        </p>
                    </div>
                </div>
            </div>
                
            
        </form>
    
    </div>
    
</div>
<script src="<?php echo DIR_JS?>jquery.tabs.pack.js" type="text/javascript"></script>
<script language="javascript">
var DIR_UPLOADPHOTO = "<?php echo $DIR_UPLOADPHOTO?>";
var DIR_UPLOADATTACHMENT = "<?php echo $DIR_UPLOADATTACHMENT?>";

$(document).ready(function() { 
	setCKEditorType('description',2);
	
	$('#container').tabs({ fxSlide: true, fxFade: true, fxSpeed: 'slow' });
	
});

function save()
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	var oEditor = CKEDITOR.instances['description'] ;
	var pageValue = oEditor.getData();
	$('textarea#description').val(pageValue);
	
	$.post("?route=module/traning/save", $("#frm").serialize(),
		function(data){
			if(data == "true")
			{
				window.location = "?route=module/traning&sitemapid=<?php echo $sitemap['sitemapid']?>";
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
<script src='<?php echo DIR_JS?>ajaxupload.js' type='text/javascript' language='javascript'> </script>
<script src="<?php echo DIR_JS?>uploadpreview.js" type="text/javascript"></script>
<script src="<?php echo DIR_JS?>uploadattament.js" type="text/javascript"></script>