<div class="section" id="sitemaplist">

	<div class="section-title">USERTYPE MANAGEMENT</div>
    
    <div class="section-content padding1">
    
    	<form id="frm" name="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        
        	<div class="button right">
            	<input type="button" value="Save" class="button" onclick="save()"/>
     	        <input type="button" value="Cancel" class="button" onclick="linkto('?route=core/usertype')"/>   
     	        <input type="hidden" name="usertypeid" value="<?php echo $usertype['usertypeid']?>" />
                <input type="hidden" id="permission" name="permission" value="<?php echo $usertype['permission']?>"/>
            </div>
            <div class="clearer">^&nbsp;</div>
        	<input type="checkbox"  class="checkbox" onclick="$('input').attr('checked', this.checked);" value=""/> All
        	<div>
            	<h1><?php echo $usertype['usertypename']?></h1>
                <h2>Modules sitemap</h2>
				<?php foreach($sitemaps as $item){ ?>
                <p>
                	<label><?php echo $item['prefix']?><?php echo $item['sitemapname']?></label><br />
                    <?php foreach($listPermission as $key => $val){ ?>
                    	<?php 
                        	
                        ?>
                    <input type="checkbox" class="<?php echo $item['sitemapid']?> checkbox"  name="<?php echo $item['sitemapid']?>[<?php echo $key?>]" value="<?php echo $item['sitemapid']?>-<?php echo $key?>"/> <?php echo $val?>
                    <?php } ?>
                </p>
                <?php } ?>
                <h2>Modules</h2>
                <?php foreach($modules as $k => $item)
                   { 
                		$cls = str_replace("/","",$k);
                ?>
                <p>
                	<label><?php echo $item?></label> <br />
                    <?php foreach($listPermission as $key => $val){ ?>
                    <input type="checkbox" class="module<?php echo $cls?> checkbox" name="<?php echo $k?>[<?php echo $key?>]" value="<?php echo $k?>-<?php echo $key?>"/> <?php echo $val?>
                    <?php } ?>
                </p>
                <?php } ?>
            </div>
            
        </form>
    
    </div>
    
</div>
<script language="javascript">
$(".checkbox").click(function(){
	$("#permission").val('');
	$(".checkbox").each(function(){
		
		if(this.checked == true && $(this).val()!="")
		{
			var temp = $("#permission").val() + "["+$(this).val()+"]";
			$("#permission").val(temp);
		}
		
	})
	
})

function save()
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	$.post("?route=core/usertype/save", 
		   $("#frm").serialize(),
		   function(data)
		   {
			   if(data=="true")
				{
					window.location = '?route=core/usertype';
				}
				
			}
		 );
		
	
}
$(document).ready(function() {
	$(".checkbox").each(function(){
		var myMatch = $("#permission").val().search($(this).val());
		if(myMatch > 0)
		{
			this.checked = true;	
		}
		else
		{
			this.checked = false;	
		}
	})
});
</script>
