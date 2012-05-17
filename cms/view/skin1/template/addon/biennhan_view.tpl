<?php
	$conlai = $item['tongtien']-$item['tamung'] - $datra
?>
<h3 style="text-align:center">Biên nhận</h3>
<p>
	<label>Số:</label> <?php echo $item['sobiennhan']?>
    <label>Ngày lập phiếu:</label> <?php echo $this->date->formatMySQLDate($item['ngaylap'])?>
    <label>Ngày hẹn:</label> <?php echo $this->date->formatMySQLDate($item['ngayhen'])?>
</p>
<p>
	<label>Tên khách hàng:</label> <?php echo $item['tenkhachhang']?>
    <label>Số điện thoại</label> <?php echo $item['sodienthoai']?>
    <label>Email:</label> <?php echo $item['email']?>
    
</p>
<p>
	<label>Địa chỉ:</label> <?php echo $item['diachi']?>
</p>
<p>
	<label>Ghi chú:</label> <?php echo $item['ghichu']?>
</p>
<?php if($_GET['dialog']!='print'){ ?>
<p>
	<label>Tình trạng:</label>
    <select id="cbtinhtrang">
    	<?php foreach($this->document->tinhtrangbiennhan as $key => $val){ ?>
        <option value="<?php echo $key?>"><?php echo $val?></option>
        <?php } ?>
    </select>
<script language="javascript">

$('#cbtinhtrang').val("<?php echo $item['tinhtrang']?>");
$('#cbtinhtrang').change(function(e) {
    $.post("?route=addon/biennhan/updateTinhTrang",{biennhanid:"<?php echo $item['biennhanid']?>",tinhtrang:$(this).val()},function(data){
		if(data=='true')
		{
			alert('Cập nhật thành công');	
		}
	})
});	
</script>
	<?php if($conlai){ ?>
	<label>Thanh toán</label>
    <input type="text" class="text number" id="txt_thanhtoan" />
    <input type="button" class="button" id="btnThanhToan" value="Thanh toán" />
    <?php } ?>
<script language="javascript">
var conlai = Number("<?php echo $conlai?>");
$('#btnThanhToan').click(function(e) {
	var thanhtoan = Number($('#txt_thanhtoan').val().replace(/,/g,""));
	if(thanhtoan > conlai)
	{
		alert("Số tiền thanh toán đã vượt quá còn lại");
		return false;
	}
    $.post("?route=addon/biennhan/thanhtoan",
		
		{biennhanid:"<?php echo $item['biennhanid']?>",thanhtoan:$('#txt_thanhtoan').val()},
		function(data)
		{
			if(data=='true')
			{
				alert('Thanh toán thành công');
				$("#popup-content").load("?route=addon/biennhan/view&biennhanid=<?php echo $item['biennhanid']?>&dialog=true");
			}
			else
			{
				alert(data);	
			}
		}
	);
});
$(document).ready(function(e) {
    numberReady();
});
</script>
</p>
<?php } ?>
<div>
            	
            	<table class="table-data">
                	<thead>
                    	<tr>
                        	
                            <th>Tên dịch vụ</th>
                            <th>Số tiền</th>
                            
                        </tr>
                    </thead>
                    <tbody id="listdichvu">
                    	<?php foreach($data_chitiet as $ct){?>
                        
                        <tr>
                        	<td><?php echo $ct['tendichvu']?></td>
                            <td width="20%" class="number"><?php echo $this->string->numberFormate($ct['sotien'])?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                   	<tfoot>
                    	<tr>
                        	
                            <td class="text-right">Tổng cộng:</td>
                            <td class="number"> <?php echo $this->string->numberFormate($item['tongcong'])?></td>
                            
                        </tr>
                    	<?php if($item['giamgia']){ ?>
                        <tr>
                        	<td class="text-right">Giảm giá:</td>
                            <td class="number"><?php echo $this->string->numberFormate($item['giamgia'])?></td>
                            
                        </tr>
                        
                        <tr>
                        	<td class="text-right">Phần trăm giảm giá:</td>
                            <td class="number"><?php echo $this->string->numberFormate($item['phantramgiamgia'])?>%</td>
                            
                        </tr>
                        
                        <tr>
                        	<td class="text-right">Tổng tiền:</td>
                            <td class="number"><?php echo $this->string->numberFormate($item['tongtien'])?></td>
                            
                        </tr>
                        <?php } ?>
                        <tr>
                        	
                            <td class="text-right">Tạm ứng:</td>
                            <td class="number"><?php echo $this->string->numberFormate($item['tamung'])?></td>
                            
                        </tr>
                        <?php if($datra){ ?>
                        <tr>
                        	
                            <td class="text-right">Đã trả:</td>
                            <td class="number"><?php echo $this->string->numberFormate($datra)?></td>
                            
                        </tr>
                        <?php } ?>
                        <tr>
                        	
                            <td class="text-right">Còn lại:</td>
                            <td class="number"><?php echo $this->string->numberFormate($conlai)?></td>
                            
                        </tr>
                    </tfoot>
                </table>
                
            </div>