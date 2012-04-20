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
<div>
            	<input type="button" class="button" id="btnThemDong" value="Thêm"/>
                <input type="button" class="button" id="btnXoaDong" value="Xóa"/>
                <input type="hidden" id="delchitietid" name="delchitietid" />
            	<table>
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
                        <tr>
                        	
                            <td class="text-right">Tạm ứng:</td>
                            <td class="number"><?php echo $this->string->numberFormate($item['tamung'])?></td>
                            
                        </tr>
                        <tr>
                        	
                            <td class="text-right">Còn lại:</td>
                            <td class="number"><?php echo $this->string->numberFormate($item['tongtien']-$item['tamung'])?></td>
                            
                        </tr>
                    </tfoot>
                </table>
                
            </div>