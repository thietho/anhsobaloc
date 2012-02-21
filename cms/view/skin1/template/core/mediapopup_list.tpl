<div class="section">
    <div class="section-content padding1">
    
    	<div class="left">
            
            <h3><?php echo $heading_title?></h3>
        
        </div>
        
    	<div class="right">
        	
            <input type="button" class="button" value="Chọn" onclick="selectCallBack()"/>
        </div>
        <div class="clearer">&nbsp;</div>
        
        <div>
        	<form id="postlist" name="postlist" method="post" action="">
            <table class="data-table" width="100%">
            
            	<thead>
                	<th></th>
                    <th width="20%">Tiêu đề</th>
                    <th width="40%">Tóm tắt</th>
                    <th width="20%">Hình</th>
                    
                </thead>
                
                <tbody>
                	<?php foreach($medias as $media) {?>
                	<tr>
                    	<td><input type="checkbox" class="selectmedia" name="select[<?php echo $media['mediaid']?>]" value="<?php echo $media['mediaid']?>"/></td>
                        <td><b><?php echo $media['title']?></b>&nbsp;</td>
                        <td><?php echo html_entity_decode($media['summary'])?>&nbsp;</td>
                        <td><?php echo $media['imagepreview']?>&nbsp;</td>
                       
                    </tr>
                    <?php } ?>
                </tbody>
            
            </table>
			</form>
        </div>
        
        
        
    </div>

</div>

<script>
var DIR_DELETE = '<?php echo $DIR_DELETE?>';
$(document).ready(function() { 
	$('#removelist').attr('title','Delete selected item').click(function(){deletelist();});  
});

function deletelist()
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	$.post(DIR_DELETE, $("#postlist").serialize(), function(data){
		window.location.reload()
	});	
}

</script>
