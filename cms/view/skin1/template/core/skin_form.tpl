<div class="section" id="sitemaplist">
	<div class="section-title"><?php echo $header_title?></div>
    
    <div class="section-content padding1">
    
    	<form id="frm" name="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        	
            <div class="left">
            	<h3><?php echo $header_title?></h3>
            </div>
        	<div class="button right">
            	<a class="button" onclick="save()">Save</a>
                
     	        <a class="button" href="index.php?route=addon/visa">Cancel</a>
                
            </div>
            <div class="clearer">&nbsp;</div>
        	<div class="error hidden"></div>
        	<div>
            	<div class="col2 left">
                	<p>
                        <label>Skin id:</label><br>
                        
                        <input type="text" class="text" size="40" id="skinid" name="skinid" value="<?php echo $item[skinid]?>"/>(*)
                        
                    </p>
                    <p>
                        <label>Skin name:</label><br>
                        
                        <input type="text" class="text" size="40" id="skinname" name="skinname" />(*)
                        
                    </p>
          		</div>
                
                <div class="col2 right">
                    
                    <p id="pnImage">
                        <label for="image">Image</label><br />
                        <a id="btnAddImage" class="button">Select photo</a><br />
                        <img id="preview" src="<?php echo $imagethumbnail?>" />
                        <input type="hidden" id="imagepath" name="imagepath"  />
                        <input type="hidden" id="imageid" name="imageid"  />
                        <input type="hidden" id="imagethumbnail" name="imagethumbnail"  />
                    </p>
                    
                    
                    <div id="errorupload" class="error" style="display:none"></div>
                    
                    <div class="loadingimage" style="display:none"></div>
                   
                </div>    	

            </div>
        </form>
    
    </div>
    
</div>

<script src='<?php echo DIR_JS?>ajaxupload.js' type='text/javascript' language='javascript'> </script>

<script language="javascript">
var DIR_UPLOADPHOTO = "<?php echo $DIR_UPLOADPHOTO?>";
function save()
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	$.post("index.php?route=<?php echo $route?>/save", 
		   $("#frm").serialize(),
		   function(data)
		   {
				if(data=="true")
					window.location = '?route=<?php echo $route?>';
				else
				{
					$(".error").html(data).show('slow');
					$.unblockUI(); 
				}
				
			}
		   );
		
	
}
$(document).ready(function() {
  	if($("#skinid").val()!="")
	{
		$("#skinid").val("<?php echo $item['skinid']?>");
		$("#skinname").val("<?php echo $item['skinname']?>");
		$("#imagepath").val("<?php echo $item['imagepath']?>");
		$("#imageid").val("<?php echo $item['imageid']?>");
		$("#imagethumbnail").val("<?php echo $item['imagethumbnail']?>");
		$("#preview").attr('src',"<?php echo $item['imagethumbnail']?>")
	}
});
</script>
<script src="<?php echo DIR_JS?>uploadpreview.js" type="text/javascript"></script>
