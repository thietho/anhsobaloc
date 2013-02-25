<div class="section">
	<?php if($ispopup == ''){ ?>
	<div class="section-title">Quản lý đánh giá</div>
    <?php } ?>
    <div class="section-content">
    	
        <form action="" method="post" id="listitem" name="listitem">
        	
        	<div class="button right">
            	<?php if($ispopup == ''){ ?>
            	<input type="button" class="button" value="Tất cả" onclick="window.location='?route=core/comment'">
            	<input type="button" class="button" value="Mới" onclick="window.location='?route=core/comment&status=new'">
            	<input type="button" class="button" value="Đã duyệt" onclick="window.location='?route=core/comment&status=published'">
                <input type="button" class="button" value="Không duyệt" onclick="window.location='?route=core/comment&status=denial'">
                <?php } ?>
            	<input class="button" type="button" name="delete_all" value="Delete" onclick="deleteitem()"/>
                
                	
            </div>
            <div class="clearer">^&nbsp;</div>
            
            <div class="sitemap treeindex">
                <table class="data-table" cellpadding="0" cellspacing="0">
                <thead>
                    <tr class="tr-head">
                        <th width="1%">
                        	<?php if($dialog!=true){ ?>
                        	<input class="inputchk" type="checkbox" onclick="$('input[name*=\'delete\']').attr('checked', this.checked);">
                            <?php } ?>
                        </th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Đánh giá</th>
                        <th>Đánh giá về</th>
                        <th>Ngày</th>
                        <th>Nội dung</th>
                        
                        
                        
                        <?php if($dialog!=true){ ?>
                        <th>Control</th>     
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
        
        
        <?php
            foreach($datas as $key => $item)
            {
        ?>
                    <tr <?php echo ($item['status']=='new')?'class="new"':''?>>
                        <td class="check-column"><input class="inputchk" type="checkbox" name="delete[<?php echo $item['id']?>]" value="<?php echo $item['id']?>" ></td>
                        
                        
                        <td>
                        	<?php echo $item['fullname']?>
                        </td>
                        <td><?php echo $item['email']?></td>
                        <td><?php echo $item['level']?> sao</td>
                        <td><?php echo $this->document->getMedia($item['mediaid'])?></td>
                       	<td><?php echo $this->date->formatMySQLDate($item['commentdate'],'longdate')?></td> 
                        <td><?php echo $item['description']?></td>
                        
                        
                        <td class="link-control">
                        	<?php if($item['status'] == 'published'){ ?>
                           	
                            <input type="button" class="button" value="Không duyệt" onclick="kiemduyet(<?php echo $item['id']?>,'denial')">
                            <?php }else{ ?>
               				<input type="button" class="button" value="Duyệt" onclick="kiemduyet(<?php echo $item['id']?>,'published')">	             
                            <?php } ?>
                            
                        </td>
                        
                    </tr>
        <?php
            }
        ?>
                        
                                                    
                </tbody>
                </table>
            </div>
        	<?php echo $pager?>
        
        </form>
        
    </div>
    
</div>
<script language="javascript">

function deleteitem()
{
	var answer = confirm("Bạn có muốn xóa không?")
	if (answer)
	{
		$.post("?route=core/comment/delete", 
				$("#listitem").serialize(), 
				function(data)
				{
					if(data!="")
					{
						<?php if($ispopup == ''){ ?>
						alert(data)
						window.location.reload();
						<?php } else{ ?>
						callbackLoadCommnet();
						<?php } ?>
					}
				}
		);
	}
}



function kiemduyet(id,status)
{
	$.post("?route=core/comment/kiemduyet", 
			{
				id:id,
				status:status
			},
			function(data)
			{
				if(data=="true")
				{
					<?php if($ispopup == ''){ ?>
					window.location.reload();
					<?php } else{ ?>
					callbackLoadCommnet();
					<?php } ?>
				
				}
			}
	);
}


</script>