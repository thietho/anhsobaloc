<div class="section" id="sitemaplist">

	<div class="section-title">Quản lý dịch vụ</div>
    
    <div class="section-content padding1">
    
    	<form name="frm" id="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="dichvuid" value="<?php echo $item['dichvuid']?>">	
            <div class="button right">
                <a class="button save" onclick="save()">Lưu</a>
                <a class="button cancel" href="?route=addon/dichvu">Bỏ qua</a>    
        	</div>
            <div class="clearer"></div>
        	<div id="error" class="error" style="display:none"></div>
        	<div>   
                
                <p>
                    <label>Tên dịch vụ</label><br />
                    <input type="text" name="tendichvu" value="<?php echo $item['tendichvu']?>" class="text" size=60 />
                </p>
                <p>
                    <label>Giá mặt định</label><br />
                    <input type="text" name="giamatdinh" value="<?php echo $item['giamatdinh']?>" class="text number" size=60 />
                </p>
                
            </div>
            
        </form>
    
    </div>
    
</div>

<script language="javascript">
function save()
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.post("?route=addon/dichvu/save", $("#frm").serialize(),
		function(data){
			if(data == "true")
			{
				window.location = "?route=addon/dichvu";
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
