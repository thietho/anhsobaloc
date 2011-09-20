<div class="section">

	<div class="section-title">
    	<?php echo $breadcrumb?>
    </div>
    
    <div class="section-content padding1">
    
    	<div class="left">
            
            <h3><?php echo $heading_title?></h3>
        
        </div>
        
    	<div class="right">
        	<?php if($permissionAdd){?>
        	<a class="button" href="<?php echo $DIR_ADD?>"><?php echo $button_add?></a>&nbsp;
            <?php }?>
            <?php if($permissionDelete){?>
            <a class="button" id="removelist"><?php echo $button_remove?></a>&nbsp;
            <?php }?>
            <a class="button" href="index.php"><?php echo $button_cancel?></a>
        </div>
        <div class="clearer">&nbsp;</div>
        
        <div>
        	<form id="postlist" name="postlist" method="post" action="">
            <table class="data-table" width="100%">
            
            	<thead>
                	<th width="10%"><?php echo $column_position?></th>
                    <th width="20%"><?php echo $column_title?></th>
                    <th width="40%"><?php echo $column_summary?></th>
                    <th width="20%"><?php echo $column_image?></th>
                    <th width="10%"><?php echo $column_control?></th>
                </thead>
                
                <tbody>
                	<?php foreach($medias as $media) {?>
                	<tr>
                    	<td><?php echo $media['firstcolumn']?>&nbsp;</td>
                        <td><b><?php echo $media['title']?></b>&nbsp;</td>
                        <td><?php echo $media['summary']?>&nbsp;</td>
                        <td><?php echo $media['imagepreview']?>&nbsp;</td>
                        <td>
                        	<?php if($permissionEdit){?>
                        	<?php echo $media['link']?>&nbsp;
                            <?php }?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            
            </table>
			</form>
        </div>
        
        <div>
        	<?php echo $nextlink?>
            <?php echo $prevlink?>
            <div class="clearer">&nbsp;</div>
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
