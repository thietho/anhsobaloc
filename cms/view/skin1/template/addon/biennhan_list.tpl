<script src='<?php echo DIR_JS?>ui.datepicker.js' type='text/javascript' language='javascript'> </script>
<div class="section">

	<div class="section-title">Quản lý biên nhận</div>
    
    <div class="section-content">
    	
        <form action="" method="post" id="listitem" name="listitem">
        	
        	<div class="button right">
            	
                <input class="button" type="button" name="btnAdd" value="Thêm" onclick="window.location='<?php echo $insert?>'"/>  
            	<input class="button" type="button" name="delete_all" value="Xóa" onclick="deleteorder()"/>  
            </div>
            <div class="clearer">&nbsp;</div>
            
            <div class="sitemap treeindex">
                <table class="data-table" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr class="tr-head">
                        <th width="1%"><input class="inputchk" type="checkbox" onclick="$('input[name*=\'delete\']').attr('checked', this.checked);"></th>
                        
                        <th>Số biên nhận</th>
                        <th>Ngày lập</th>
                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Tổng số tiền</th>
                        <th>Tạm ứng</th>
                        <th>Còn lại</th>
                        <th>Tình trạng</th>
                        <th width="10%"></th>                                  
                    </tr>
        
        
        <?php
            foreach($datas as $item)
            {
        ?>
                    <tr>
                        <td class="check-column"><input class="inputchk" type="checkbox" name="delete[<?php echo $item['dichvuid']?>]" value="<?php echo $item['biennhanid']?>" ></td>
                        <td><?php echo $item['sobiennhan']?></td>
                        <td><?php echo  $this->date->formatMySQLDate($item['ngaylap'])?></td>
                        <td><?php echo $item['tenkhachhang']?></td>
                        <td><?php echo $item['sodienthoai']?></td>
                        <td class="number"><?php echo $this->string->numberFormate($item['tongsotien'])?></td>
                        <td class="number"><?php echo $this->string->numberFormate($item['tamung'])?></td>
                        <td class="number"><?php echo $this->string->numberFormate($item['tongsotien']-$item['tamung'])?></td>
                        <td><?php echo $this->document->tinhtrangbiennhan[$item['tinhtrang']]?></td>
                        
                		
                        <td class="link-control">
                            <input type="button" class="button" name="btnEdit" value="Sửa" onClick="window.location='<?php echo $item['link_edit']?>'">
                            <input type="button" class="button" value="Xem" onclick="view('<?php echo $item['biennhanid']?>')"/>
                        </td>
                    </tr>
        <?php
            }
        ?>
                        
                                                    
                </tbody>
                </table>
            </div>
        
        
        </form>
        
    </div>
    
</div>
<script language="javascript">
function deleteorder()
{
	var answer = confirm("Are you sure delete?")
	if (answer)
	{
		$.post("?route=addon/order/delete", 
				$("#listitem").serialize(), 
				function(data)
				{
					if(data!="")
					{
						alert(data)
						window.location.reload();
					}
				}
		);
	}
}
function view(biennhanid)
{
	
	openDialog("?route=addon/biennhan/view&biennhanid="+biennhanid,800,500)
}
</script>