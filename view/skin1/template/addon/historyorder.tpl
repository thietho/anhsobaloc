<div>
    <table class="ben-table">
		<thead>
        	<tr>
                <th>Mã đơn hàng</th>
                <th>Tên khách hàng</th>
                <th>Địa chỉ</th>
                <th>Điện thoại</th>
                <th>Ngày đặt</th>
                <th>Tình trạng</th>
            </tr>
        </thead> 
        <tbody>
        	<?php foreach($orders as $order){ ?>
            <tr>
            	<td><a href="<?php echo $this->document->createLink('checkoutcomplete',$order['orderid'])?>"><?php echo $order['orderid']?></a></td>
                <td><?php echo $order['customername']?></td>
                <td><?php echo $order['address']?></td>
                <td><?php echo $order['phone']?></td>
                <td><?php echo $this->date->formatMySQLDate($order['orderdate'])?> <?php echo $this->date->getTime($order['orderdate'])?></td>
                <td><?php echo $this->document->status[$order['status']]?></td>
            </tr>
            <?php } ?>
        </tbody>   
    </table>
</div>