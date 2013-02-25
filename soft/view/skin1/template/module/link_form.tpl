<div class="section" id="sitemaplist">

	<div class="section-title">Link</div>
    
    <div class="section-content padding1">
    
    	<form name="frm" id="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        
        	<div class="button right">
            	<input type="button" value="Save" class="button" onClick="save()"/>
     	        <input type="button" value="Cancel" class="button" onclick="linkto('?route=module/link&sitemapid=<?php echo $sitemap['sitemapid']?>')"/>   
     	        <input type="hidden" name="mediaid" value="<?php echo $item['mediaid']?>">
                <input type="hidden" id="status" name="status" value="<?php echo $item['status']?>" />
             	<input type="hidden" id="mediatype" name="mediatype" value="<?php echo $item['mediatype']?>" />
             	<input type="hidden" id="refersitemap" name="refersitemap" value="<?php echo $item['refersitemap']?>" />
                
                <input type="hidden" id="handler" />
             	<input type="hidden" id="outputtype" />
                <input type="hidden" id="listselectfile" name="listselectfile" />
            </div>
            <div class="clearer">^&nbsp;</div>
        	<div id="error" class="error" style="display:none"></div>
        	<div>        
                <p>
            		<label><?php echo $text_title?></label><br />
					<input type="text" name="title" value="<?php echo $item['title']?>" class="text" size=60 />
            	</p>
               	<p>
                    <label>Link</label><br />
                    <textarea name="Link"><?php echo $item['Link']?></textarea>
                </p>
                <p id="pnImage">
                    <label for="image">Image</label><br />
                    <a class="button"  onclick="browserFileImage()">Select photo</a><br />
                    
                    <img id="imagepreview" src="<?php echo $item['imagethumbnail']?>" />
                    <input type="hidden" id="imagepath" name="imagepath" value="<?php echo $item['imagepath']?>" />
                    <input type="hidden" id="imageid" name="imageid" value="<?php echo $item['imageid']?>" />
                    <input type="hidden" id="imagethumbnail" name="imagethumbnail" value="<?php echo $item['imagethumbnail']?>" />
                </p>
                
                
                <div id="errorupload" class="error" style="display:none"></div>
                
                <div class="loadingimage" style="display:none"></div>
            </div>
            
        </form>
    
    </div>
    
</div>

<script language="javascript">
var DIR_UPLOADPHOTO = "<?php echo $DIR_UPLOADPHOTO?>";
function save()
{
	$.blockUI({ message: "<h1>Đang xử lý...</h1>" }); 
	
	$.post("?route=module/link/save", $("#frm").serialize(),
		function(data){
			if(data == "true")
			{
				window.location = "?route=module/link&sitemapid=<?php echo $sitemap['sitemapid']?>";
			}
			else
			{
			
				$('#error').html(data).show('slow');
				$.unblockUI();
				
			}
			
		}
	);
}

function browserFileImage()
{
    //var re = openDialog("?route=core/file",800,500);
	$('#handler').val('image');
	$('#outputtype').val('image');
	showPopup("#popup", 800, 500);
	$("#popup").html("<img src='view/skin1/image/loadingimage.gif' />");
	$("#popup").load("?route=core/file")
		
}

function addImageTo()
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
					switch($('#outputtype').val())
					{
						case 'editor':
							width = "";
							
							var value = "<img src='<?php echo HTTP_IMAGE?>"+data.file.filepath+"'/>";
							
							var oEditor = CKEDITOR.instances[$('#handler').val()] ;
							
							
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
							break;
						case 'image':
							var handler = $('#handler').val();
							$('#'+handler+'id').val(data.file.fileid)
							$('#'+handler+'path').val(data.file.filepath)
							$.getJSON("?route=core/file/getFile&fileid="+data.file.fileid+"&width=200", 
							function(file) 
							{
								$('#'+handler+'thumbnail').val(file.file.imagepreview)
								$('#'+handler+'preview').attr('src',file.file.imagepreview)
							});
							
							
							break;
						
					}
				});
		}
	}
}
</script>
<script src='<?php echo DIR_JS?>ajaxupload.js' type='text/javascript' language='javascript'> </script>
