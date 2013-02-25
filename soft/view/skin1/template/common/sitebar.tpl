<div class="section" id="sitemaplist">

	<div class="section-title">Setting</div>
    
    <div class="section-content padding1">
    
    	<form name="frm" id="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        
        	<div class="button right">
            	<input type="button" value="Lưu" class="button" onClick="save()"/>
     	        <input type="button" value="Bỏ qua" class="button" onclick="linkto('?route=module/link&sitemapid=<?php echo $sitemap['sitemapid']?>')"/>   
     	        <input type="hidden" name="mediaid" value="<?php echo $item['mediaid']?>">
                
            </div>
            <div class="clearer">^&nbsp;</div>
        	<div id="error" class="error" style="display:none"></div>
        	
            <div>
            	<h3>Cài đặt nhản hiệu ở bên phải</h3>
                <?php foreach($menu as $key => $val){ ?>
                <p>
                	<label><?php echo $this->document->getSiteMap($key,$this->user->getSiteId())?></label>
                   	
                    <div>
                    	<?php foreach($val as $it){ ?>
                    	<div class="left" style="width:200px;">
                        	<input type="checkbox" name="<?php echo $key?>[<?php echo $it?>]" value="<?php echo $it?>" <?php echo (in_array($it,$sitebar[$key]))?'checked="checked"':'';?>/> <?php echo $this->document->getCategory($it)?>
                        </div>
                        <?php } ?>
                        <div class="clearer">^&nbsp;</div>
                    </div>
                </p>
                <?php } ?>
            </div>
            
        </form>
    
    </div>
    
</div>

<script language="javascript">
function save()
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	/*var oEditor = CKEDITOR.instances['editor1'] ;
	var pageValue = oEditor.getData();
	$('textarea#editor1').val(pageValue);*/
	$.post("?route=common/sitebar/save", $("#frm").serialize(),
		function(data){
			if(data == "true")
			{
				$.unblockUI();
			}
		}
	);
}

</script>
