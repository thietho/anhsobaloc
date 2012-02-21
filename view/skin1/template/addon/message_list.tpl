<div class="section">
    
    <div class="section-content padding1">
        <div class="ben-left">
        	<a class="ben-button" href="<?php echo $this->document->createLink('message','folder','inbox')?>">Hộp thư đến</a>
            <a class="ben-button" href="<?php echo $this->document->createLink('message','folder','send')?>">Thư đã gửi</a>
        </div>
    	<div class="ben-right">
        	<a class="ben-button" href="<?php echo $this->document->createLink('compose')?>">Soạn tin</a>&nbsp;
            <a class="ben-button" onclick="deletelist()">Xóa</a>&nbsp;
        </div>
        <div class="clearer">&nbsp;</div>
        <p>&nbsp;</p>
        <div>
        	<form id="postlist" name="postlist" method="post" action="">
            <table class="ben-data-table" width="100%">
            
            	<thead>
                	<th><input class="inputchk" type="checkbox" onclick="$('input[name*=\'delete\']').attr('checked', this.checked);"></th>
                    <th>Tiêu đề</th>
                    <th>Ngày</th>
                    <th><img src="<?php echo HTTP_SERVER.DIR_IMAGE."icon/dinhkem.png"?>"></th>
                    
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
                    	<td class="ben-center"><input class="inputchk" type="checkbox" name="delete[<?php echo $item['messageid']?>]" value="<?php echo $item['messageid']?>" ></td>
                    	
                        <td><a href="<?php echo $this->document->createLink('message',$item['messageid'])?>"><?php echo $item['title']?>&nbsp;</a></td>
                        <td><?php echo $this->date->formatMySQLDate($item['senddate'])?>&nbsp;</td>
                        <td><?php if($item['attachment']) echo '<img src="'.HTTP_SERVER.DIR_IMAGE.'icon/dinhkem.png">';?>&nbsp;</td>
                        
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
	$.post('?route=addon/message/delete&folder=<?php echo $_GET["folder"]?>', $("#postlist").serialize(), function(data){
		window.location.reload()
	});	
}

</script>
