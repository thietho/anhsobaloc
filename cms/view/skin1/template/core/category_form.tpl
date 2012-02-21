<div class="section" id="sitemaplist">

	<div class="section-title"><?php echo $heading_title?>Category</div>
    
    <div class="section-content padding1">
    
    	<form name="frm" id="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        
        	<div class="button right">
            	<input type="button" value="Save" class="button" onClick="save()"/>
     	        <input type="button" value="Cancel" class="button" onclick="linkto('?route=core/category')"/>   
     	        <input type="hidden" name="id" value="<?php echo $item['id']?>">
            </div>
            <div class="clearer">^&nbsp;</div>
        	<div id="error" class="error" style="display:none"></div>
        	<div>   
            	<p>
                    <label>Category ID</label><br />
                    <input type="text" name="categoryid" value="<?php echo $item['categoryid']?>" class="text" size=60 <?php if($item['categoryid']!="") echo 'readonly="readonly"'?>/>
                </p>     
                <p>
                    <label>Category name</label><br />
                    <input type="text" name="categoryname" value="<?php echo $item['categoryname']?>" class="text" size=60 />
                </p>
                <p>
                    <label>Parent</label><br />
                    <select id="parent" name="parent">
                        <?php foreach($datas as $it){ ?>
                        <option value="<?php echo $it['categoryid']?>"><?php echo $this->string->getPrefix("&nbsp;&nbsp;&nbsp;&nbsp;",$it['level']) ?><?php echo $it['categoryname']?></option>
                        <?php } ?>
                    </select>
                </p>
                
            </div>
            
        </form>
    
    </div>
    
</div>
<?php
	$parent =$item['parent'];
	if($_GET['parent'] !="")
    	$parent = $_GET['parent'];
    
?>
<script language="javascript">
function save()
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.post("?route=core/category/save", $("#frm").serialize(),
		function(data){
			if(data == "true")
			{
				window.location = "?route=core/category";
			}
			else
			{
			
				$('#error').html(data).show('slow');
				$.unblockUI();
				
			}
			
		}
	);
}
$(document).ready(function() {
	
	$("#parent").val("<?php echo $parent?>");
	
	
});

</script>
