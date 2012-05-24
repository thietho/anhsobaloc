<div class="section" id="sitemaplist">

	<div class="section-title"><?php echo $heading_title?></div>
    
    <div class="section-content padding1">
    	
        <form id="frmSiteMap" name="frm" action="" method="post" enctype="multipart/form-data">
        	<div class="button left">
            	<h3>Add New Sitemap</h3>
            </div>
            
            <div class="button right">
            	<input type="button" value="Save" class="button" onclick="save()"/>
	            <input type="button" value="Cancel" class="button" onclick="linkto('?route=core/sitemap')"/>
                <input type="hidden" name="id" value="<?php echo $sitemap['id']?>" />
                
                <input type="hidden" id="listselectfile" name="listselectfile" />
                <input type="hidden" id="handler" />
             	<input type="hidden" id="outputtype" />
            </div>
            <div class="clearer">^&nbsp;</div>
            <div id="error" class="error" style="display:none"></div>
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
                <label>Status</label>
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
            
            <p>
            	<label>Image</label><br />
            	<input type="button" value="Chọn hình" class="button" onclick="browserFileImage()"/>
                <input type="button" value="Xóa hinh" class="button" onclick="removeImage()"/>
                <br />
                
                <input type="hidden" id="imageid" name="imageid" value="<?php echo $sitemap['imageid']?>" /> 
                <input type="hidden" id="imagepath" name="imagepath" value="<?php echo $sitemap['imagepath']?>" />
                <input type="hidden" id="imagethumbnail" name="imagethumbnail" value="<?php echo $sitemap['thumbnail']?>" />
                <img id="imagepreview" src="<?php echo $sitemap['thumbnail']?>" />
                <input type="hidden" name="position" value="<?php echo $sitemap['position']?>">
            </p>
        
        </form>
    
    </div>
    
</div>       
<!-- main indent-->
<script src='<?php echo DIR_JS?>ajaxupload.js' type='text/javascript' language='javascript'> </script>
<script language="javascript">
function save()
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	$.post("?route=core/sitemap/save", $("#frmSiteMap").serialize(),
		function(data){
			var arr = data.split("-");
			if(arr[0] == "true")
			{
				window.location = "?route=core/sitemap";
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
    //var re = openDialog("?route=core/file&dialog=true",800,500);
	$('#handler').val('image');
	$('#outputtype').val('image');
	showPopup("#popup", 800, 500);
	$("#popup").html("<img src='view/skin1/image/loadingimage.gif' />");
	$("#popup").load("?route=core/file&dialog=true")
		
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
function removeImage()
{
	$('#imagepath').val("");
	$('#imageid').val("");
	$('#imagepreview').attr("src","<?php echo $noimage?>");
	$('#imagethumbnail').val("");
}
</script>
