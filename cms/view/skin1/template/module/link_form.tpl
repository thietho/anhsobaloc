<div class="section" id="sitemaplist">

	<div class="section-title">Liên kết</div>
    
    <div class="section-content padding1">
    
    	<form name="frm" id="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        
        	<div class="button right">
            	<input type="button" value="Lưu" class="button" onClick="save()"/>
     	        <input type="button" value="Bỏ qua" class="button" onclick="linkto('?route=module/link&sitemapid=<?php echo $sitemap['sitemapid']?>')"/>   
     	        <input type="hidden" name="mediaid" value="<?php echo $item['mediaid']?>">
                <input type="hidden" id="status" name="status" value="<?php echo $item['status']?>" />
             	<input type="hidden" id="mediatype" name="mediatype" value="<?php echo $item['mediatype']?>" />
             	<input type="hidden" id="refersitemap" name="refersitemap" value="<?php echo $item['refersitemap']?>" />
            </div>
            <div class="clearer">^&nbsp;</div>
        	<div id="error" class="error" style="display:none"></div>
        	<div>        
                <p>
            		<label>Tiêu đề</label><br />
					<input type="text" name="title" value="<?php echo $item['title']?>" class="text" size=60 />
            	</p>
               	<p>
                    <label>Liên kết</label><br />
                    <textarea name="Link"><?php echo $item['Link']?></textarea>
                    
                </p>
            </div>
            
        </form>
    
    </div>
    
</div>
<script language="javascript">
function save()
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
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


</script>
