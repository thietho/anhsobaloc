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
            <div id="ben-search">
            	<p>
                    <label>Số biên nhận</label>
                    <input type="text" id="sophieu" name="sophieu" class="text"/>
                    <label>Ngày lập</label>
                    từ
                    <input type="text" id="tungay" name="tungay" class="text ben-datepicker" />
                    đến
                    <input type="text" id="denngay" name="denngay" class="text ben-datepicker" />
                    <label>Tên khách hàng</label>
                    <input type="text" id="kehoachngay" name="kehoachngay" class="text"/>
                    <label>Số diện thoai</label>
                    <input type="text" id="kehoachngay" name="kehoachngay" class="text"/>
                </p>
                <p>
                <label>Số tiền</label>
                từ
                <input type="text" id="sotientu" name="sotientu" class="text number" />
                đến
                <input type="text" id="sotienden" name="sotienden" class="text number" />
                
                <label>Tình trạng</label>
                <select id="tinhtrang" name="tinhtrang">
                	<option value=""></option>
                    <?php foreach($this->document->tinhtrangbiennhan as $key => $val){ ?>
                    <option value="<?php echo $key?>"><?php echo $val?></option>
                    <?php } ?>
                </select>
                
                </p>
                <input type="button" class="button" name="btnSearch" value="Tìm" onclick="searchForm()"/>
                <input type="button" class="button" name="btnSearch" value="Xem tất cả" onclick="window.location = '?route=quanlykho/phieunhapvattuhanghoa'"/>
            </div>
            <div class="sitemap treeindex">
                <table class="data-table" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr class="tr-head">
                        <th width="1%"><input class="inputchk" type="checkbox" onclick="$('input[name*=\'delete\']').attr('checked', this.checked);"></th>
                        
                        <th>Số biên nhận</th>
                        <th>Ngày lập</th>
                        <th>Ngày hẹn</th>
                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Tổng số tiền</th>
                        <th>Tạm ứng</th>
                        <th>Còn lại</th>
                        <th>Tình trạng</th>
                        <th></th>                                  
                    </tr>
        
        
        <?php
            foreach($datas as $item)
            {
        ?>
                    <tr>
                        <td class="check-column"><input class="inputchk" type="checkbox" name="delete[<?php echo $item['dichvuid']?>]" value="<?php echo $item['biennhanid']?>" ></td>
                        <td><a onclick="view('<?php echo $item['biennhanid']?>')"><?php echo $item['sobiennhan']?></a></td>
                        <td><?php echo  $this->date->formatMySQLDate($item['ngaylap'])?></td>
                        <td><?php echo  $this->date->formatMySQLDate($item['ngayhen'])?></td>
                        <td><?php echo $item['tenkhachhang']?></td>
                        <td><?php echo $item['sodienthoai']?></td>
                        <td class="number"><?php echo $this->string->numberFormate($item['tongtien'])?></td>
                        <td class="number"><?php echo $this->string->numberFormate($item['tamung'])?></td>
                        <td class="number"><?php echo $this->string->numberFormate($item['tongtien']-$item['tamung'])?></td>
                        <td><?php echo $this->document->tinhtrangbiennhan[$item['tinhtrang']]?></td>
                        
                		
                        <td class="link-control">
                            <input type="button" class="button" name="btnEdit" value="Sửa" onClick="window.location='<?php echo $item['link_edit']?>'">
                           
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
	$("#popup").attr('title','Chọn khách hàng');
				$( "#popup" ).dialog({
					autoOpen: false,
					show: "blind",
					hide: "explode",
					width: 800,
					height: 500,
					modal: true,
					buttons: {
						'Đóng': function() {
							$( this ).dialog( "close" );
						},
						'In': function(){
							$( this ).dialog( "close" );
						},
					}
				});
			
				
	$("#popup-content").load("?route=addon/biennhan/view&biennhanid="+biennhanid+"dialog=true",function(){
		$("#popup").dialog("open");	
	});
}
</script>