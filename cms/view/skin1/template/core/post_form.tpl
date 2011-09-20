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
        	<input class="button" type="submit" value="<?php echo $button_save?>" />
            <a class="button" href="<?php echo $DIR_CANCEL?>"><?php echo $button_cancel?></a>
             <input type="hidden" id="status" name="status" value="<?php echo $status?>" />
             <input type="hidden" id="mediaid" name="mediaid" value="<?php echo $mediaid?>" />
             <input type="hidden" id="mediatype" name="mediatype" value="<?php echo $mediatype?>" />
             <input type="hidden" id="refersitemap" name="refersitemap" value="<?php echo $refersitemap?>" />
        </div>
        <div class="clearer">&nbsp;</div>
        
        
        <div id="container">
        	
            
        	<ul>
                <li><a href="#fragment-content"><span><?php echo $tab_editcontent?></span></a></li>
                <li><a href="#fragment-detail"><span>Detail</span></a></li>
                <?php if($hasVideo) {?>
                <li><a href="#fragment-video"><span>Video</span></a></li>
                <?php }?>
                <?php if($hasSubInfor) {?>
                <li><a href="#fragment-subinfor"><span>Information</span></a></li>
                <?php }?>
                <?php if($hasTabMap) {?>
                <li><a href="#fragment-map"><span><?php echo $tab_map?></span></a></li>
                
                 <?php } ?>
                 
                <?php if($hasEmail) {?>
                <li><a href="#fragment-email"><span>Email</span></a></li>
                <?php } ?>
                
            </ul>
           
            
            <div id="fragment-content">
            	
                <div style="<?php echo $displaynews?>">
        			
                    <div class="col2 left">
                    	
                        <?php if($hasTitle) {?>
                        <p>
                            <label><?php echo $entry_title?></label><br>
                            <input class="text" type="text" name="title" value="<?php echo $title?>" size="60" />
                        </p>
                        <?php } ?>
                        
                        <?php if($hasSummary) {?>
                        <p>
                            <label><?php echo $entry_summary?></label><br>
                            <textarea class="text" rows="3" cols="70" name="summary"><?php echo $summary?></textarea>
                        </p>
                        <?php } ?>
                    	<?php if($hasPrice) {?>
                        <p>
                            <label>Price</label><br>
                            <input class="text number" type="text" name="price" value="<?php echo $this->string->numberFormate($price)?>" size="60" />
                        </p>
                        <?php } ?>
                    </div>
                    <?php if($hasFile) {?>
                    <div class="col2 right">
                    	
                    	<p id="pnImage">
                            <label for="image"><?php echo $entry_image?></label><br />
                            <a id="btnAddImage" class="button"><?php echo $entry_selectphoto?></a><br />
                            <img id="preview" src="<?php echo $imagethumbnail?>" />
                            <input type="hidden" id="imagepath" name="imagepath" value="<?php echo $imagepath?>" />
                            <input type="hidden" id="imageid" name="imageid" value="<?php echo $imageid?>" />
                            <input type="hidden" id="imagethumbnail" name="imagethumbnail" value="<?php echo $imagethumbnail?>" />
                        </p>
                        
                        
                        <div id="errorupload" class="error" style="display:none"></div>
                        
                        <div class="loadingimage" style="display:none"></div>
                        <p>
                        	<a id="btnAddAttachment" class="button"><?php echo $entry_attachment?></a><br />
                        </p>
                        <p id="attachment">
                        </p>
                    	
                        <span id="delfile"></span>
                    </div>
                    <?php }?>
<script language="javascript">
	$(document).ready(function() {
   	// put all your jQuery goodness in here.
<?php
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
                    
                    
                    
              
                    <?php if($hasSource) {?>
                    <p>
                        <label><?php echo $entry_source?></label><br>
                        <input class="text" type="text" name="source" value="<?php echo $source?>" size="40" />
                    </p>
                    <?php } ?>
                
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
            <?php if($hasVideo) {?>
            <div id="fragment-video">
                    <p id="pnVideo">
                        <label for="file">File</label><br />
                        <a id="btnAddVideo" class="button">Select file</a><br />
                        <span id="filename"><?php echo $filepath?></span>
                        <input type="hidden" id="filepath" name="filepath" value="<?php echo $filepath?>" />
                        <input type="hidden" id="fileid" name="fileid" value="<?php echo $fileid?>" />
                        <div id="sub_errorupload" class="error" style="display:none"></div>
                        
                        
                    </p>
                    
                    
                    <div id="errorupload" class="error" style="display:none"></div>
                    
                    <div class="loadingimage" style="display:none"></div>
            </div>
            <?php } ?>
            <?php if($hasSubInfor) {?>
            <div id="fragment-subinfor">
            	<input type="hidden" name="sub_mediaid" id="sub_mediaid" />
            	<div>
                	<p>
                        Tiêu đề:<br />
                        <input class="text" type="text" name="sub_title" id="sub_title" value="" size="40" />
                    </p>
                    <p id="sub_pnImage">
                        <label for="image">Image</label><br />
                        <a id="btnAddSubImage" class="button">Select Image</a><br />
                        <img id="sub_preview" src="" />
                        <input type="hidden" id="sub_imagepath" name="sub_imagepath" />
                        <input type="hidden" id="sub_imageid" name="sub_imageid"  />
                        <input type="hidden" id="sub_imagethumbnail" name="sub_imagethumbnail" />
                    </p>
                    <p>
                    	<textarea name="sub_description" id="sub_description" cols="80" rows="10"></textarea>
                    </p>
                    <p>
                    	<input type="button" class="button" value="<?php echo $button_save?>" onclick="postSubInfor()"/>
                        <input type="button" class="button" value="<?php echo $button_cancel?>"/>
                    </p>
                </div>
                <div id="subinforlist">
                </div>
            </div>
<script language="javascript">
$(document).ready(function() { 
	setCKEditorType('sub_description',2);
	$("#subinforlist").load("?route=core/postcontent/loadSubInfor&mediaid="+$("#mediaid").val());
})
</script>
            <?php }?>
            <?php if($hasTabMap) {?>
            <div id="fragment-map">
                <div>
                	<table>
                    	<thead>
                        	<th width="50%"><?php echo $column_menu?></th>
                            <th width="50%"><?php echo $column_parent?></th>
                        </thead>
                        <tbody>
                        	<?php echo $listReferSiteMap?>
                        </tbody>
                    </table>
                	
                
                </div>
            </div>
            <?php } ?>
            
            <?php if($hasEmail) {?>
                <div id="fragment-email">
                    <p>
                        <label>Email 1</label><br>
                        <input class="text" type="text" name="email1" value="<?php echo $email1?>" size="60" />
                    </p>
                    <p>
                        <label>Email 2</label><br>
                        <input class="text" type="text" name="email2" value="<?php echo $email2?>" size="60" />
                    </p>
                    <p>
                        <label>Email 3</label><br>
                        <input class="text" type="text" name="email3" value="<?php echo $email3?>" size="60" />
                    </p>
                </div>
            <?php } ?>
        
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
<?php if($hasFile) {?>
<script src="<?php echo DIR_JS?>uploadpreview.js" type="text/javascript"></script>
<script src="<?php echo DIR_JS?>uploadsubimage.js" type="text/javascript"></script>
<script src="<?php echo DIR_JS?>uploadattament.js" type="text/javascript"></script>
<?php }?>
<?php if($hasVideo) {?>
<script src="<?php echo DIR_JS?>uploadvideo.js" type="text/javascript"></script>
<?php }?>

<script language="javascript">
function postSubInfor()
{
	var oEditor = CKEDITOR.instances['sub_description'] ;
	var pageValue = oEditor.getData();
	$('textarea#sub_description').val(pageValue);
	$.post("?route=core/postcontent/savepost", 
					{
						mediaid : $("#sub_mediaid").val(), 
						mediaparent : $("#mediaid").val(),
						title : $("#sub_title").val(), 
						
						description : $("#sub_description").val(),
						imageid : $("#sub_imageid").val(),
						imagepath : $("#sub_imagepath").val()
					},
		function(data){
			if(data=="true")
			{
				$("#subinforlist").load("?route=core/postcontent/loadSubInfor&mediaid="+$("#mediaid").val());
				$("#sub_mediaid").val("");
				$("#sub_title").val("");
				$("#sub_summary").val("");
				$("#sub_author").val("");
				$("#sub_imageid").val("");
				$("#sub_imagepath").val("");
				$("#sub_preview").attr("src", "");
				var oEditor = CKEDITOR.instances.sub_description ;
				oEditor.setData("") ;
				$("#subimageerror").hide('slow');
			}
			else
			{
				$("#subimageerror").html(data);
				$("#subimageerror").show('slow');
			}
			
		});
}
function editeSubInfor(mediaid)
{
	
	$.getJSON("?route=core/postcontent/getSubInfor&mediaid="+mediaid, 
			function(data) 
			{
				//alert(data.subimage.imagepreview);
				$("#sub_mediaid").val(data.subinfor.mediaid);
				$("#sub_title").val(data.subinfor.title);
				$("#sub_summary").val(data.subinfor.summary);
				$("#sub_author").val(data.subinfor.author);
				$("#sub_imageid").val(data.subinfor.imageid);
				$("#sub_imagepath").val(data.subinfor.imagepath);
				$("#sub_imagethumbnail").val(data.subinfor.imagepreview);
				$("#sub_preview").attr("src", data.subinfor.imagepreview);
				var oEditor = CKEDITOR.instances.sub_description ;
				oEditor.setData(data.subinfor.description);
				
			});
}

function removeSubInfor(mediaid)
{
	//$.blockUI({ message: "<h1>Please wait...</h1>" });
	$.ajax({
		url: "?route=core/postcontent/removeSubImage&mediaid="+mediaid, 
		cache: false,
		success: function(html)
		{
			$("#subinforlist").load("?route=core/postcontent/loadSubInfor&mediaid="+$("#mediaid").val());
		}
	});
	
}

function browserFileEditor()
{
    //var re = openDialog("?route=core/file",800,500);
	showPopup("#popup", 800, 500);
	$("#popup").html("<img src='view/skin1/image/loadingimage.gif' />");
	$("#popup").load("?route=core/file")
		
}

function addImageToDescription()
{
	var str= trim($("#listselectfile").val(),",");
	var arr = str.split(",");
	
	if(str!="")
	{
		for (i=0;i<arr.length;i++)
		{
			$.getJSON("?route=core/file/getFile&fileid="+arr[i], 
				function(data) 
				{
					
					width = "";
					if(data.file.width >600)
						width = 'width="600px"'
					var value = "<img src='<?php echo HTTP_IMAGE?>"+data.file.filepath+"' " + width +"/>";
					
					var oEditor = CKEDITOR.instances['editor1'] ;
					
					
					// Check the active editing mode.
					if (oEditor.mode == 'wysiwyg' )
					{
						// Insert the desired HTML.
						oEditor.insertHtml( value ) ;
						$("#listselectfile").val('');
						var temp = oEditor.getData()
						oEditor.setData( temp );
					}
					else
						alert( 'You must be on WYSIWYG mode!' ) ;
				});
		}
	}
}
</script>