<div>
	
    	<h4>Thông tin đơn hàng</h4>
    	<table class="ben-form">
        	<tr>
            	<td><label>Mã đơn hàng</label></td>
                <td><?php echo $order['orderid']?></td>
            </tr>
            <tr>
            	<td><label>Họ và tên</label></td>
                <td><?php echo $order['customername']?></td>
            </tr>
            <tr>
            	<td><label>Địa chỉ</label></td>
                <td><?php echo $order['address']?></td>
            </tr>
            <tr>
            	<td><label>Email</label></td>
                <td><?php echo $order['email']?></td>
            </tr>
            <tr>
            	<td><label>Điện thoại</label></td>
                <td><?php echo $order['phone']?></td>
            </tr>
            <tr>
            	<td><label>Trạng thái</label></td>
                <td><?php echo $this->document->status[$order['status']]?></td>
            </tr>
            <tr>
            	<td><label>Ghi chú</label></td>
                <td><?php echo $order['comment']?></td>
            </tr>
        </table>
</div>
<div>
<h4>Chi tiết đơn hàng</h4>
<table class="ben-table">
	<thead>
        <tr>
            <th>Hình</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
           
        </tr>
    </thead>
    <tbody>
	<?php 
    	$sum = 0;
    	foreach($medias as $media) {
        $sum += $media['subtotal'];
    ?>
        <tr>
            <td><img src="<?php echo $media['imagethumbnail']?>" class="ben-center"/></td>
            <td><?php echo $media['title']?></td>
            <td class="number"><?php echo $this->string->numberFormate($media['price'])?></td>
            <td class="number"><?php echo $this->string->numberFormate($media['quantity'])?></td>
            <td class="number"><?php echo $this->string->numberFormate($media['subtotal'])?></td>
            
        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    	<tr>
        	<td></td>
            <td></td>
            <td></td>
            <td>Tông cộng</td>
            <td class="number"><?php echo $this->string->numberFormate($sum)?></td>
        </tr>
    </tfoot>
</table>
</div>
<div class="clearer">&nbsp;</div>