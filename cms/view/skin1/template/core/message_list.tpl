<div class="section">

	<div class="section-title">
    	<?php echo $heading_title?>
    </div>
    
    <div class="section-content padding1">
    
    	<div class="left">
        	<a class="button <?php echo $inboxclass?>" href="<?php echo $inbox?>"><?php echo $button_inbox?></a>&nbsp;
            <a class="button <?php echo $sendclass?>" href="<?php echo $send?>"><?php echo $button_sendbox?></a>
        </div>
        
    	<div class="right">
        	<a class="button" href="<?php echo $insert?>"><?php echo $button_send?></a>&nbsp;
            <a class="button" onclick="deletelist()">Xóa</a>&nbsp;
        </div>
        <div class="clearer">&nbsp;</div>
        <p>&nbsp;</p>
        <div>
        	<form id="postlist" name="postlist" method="post" action="">
            <table class="data-table" width="100%">
            
            	<thead>
                	<th><input class="inputchk" type="checkbox" onclick="$('input[name*=\'delete\']').attr('checked', this.checked);"></th>
                	<th width="25%"><?php echo $column_from?></th>
                    <th width="35%"><?php echo $column_title?></th>
                    <th width="15%"><?php echo $column_date?></th>
                    <th width="15%"><img src="<?php echo DIR_IMAGE."icon/dinhkem.png"?>"></th>
                    
                </thead>
                
                <tbody>
                	<?php 
                    	foreach($messages as $item) 
                        {
                        	$read="";
                        	if($item['status']=="")
                            	$read='class="even"';
                    ?>
                	<tr <?php echo $read?>>
                    	<td class="check-column"><input class="inputchk" type="checkbox" name="delete[<?php echo $item['messageid']?>]" value="<?php echo $item['messageid']?>" ></td>
                    	<td><?php echo $item['from']?>&nbsp;</td>
                        <td><a href="<?php echo $view?>&messageid=<?php echo $item['messageid']?>"><?php echo $item['title']?>&nbsp;</a></td>
                        <td><?php echo $this->date->formatMySQLDate($item['senddate'])?>&nbsp;</td>
                        <td><?php if($item['attachment']) echo '<img src="'.DIR_IMAGE.'icon/dinhkem.png">';?>&nbsp;</td>
                        
                    </tr>
                    <?php } ?>
                </tbody>
            
            </table>
			</form>
        </div>
        
        <div>
        	<?php echo $pager?>
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
	$.post('?route=core/message/delete&folder=<?php echo $_GET["folder"]?>', $("#postlist").serialize(), function(data){
		window.location.reload()
	});	
}

</script>
