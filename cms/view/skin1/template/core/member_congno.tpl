<h3>Thông tin khách hàng</h3>
<p>
	<label>Tên khách hàng:</label> <?php echo $user['fullname']?>
    <label>Số điện thoai:</label> <?php echo $user['phone']?>
</p>
<p>
    <label>Địa chỉ:</label> <?php echo $user['address']?>
    <label>Email:</label> <?php echo $user['email']?>
</p>
<h3>Dach sách biên nhận</h3>
<table>
	<tr>
    	<th width="30%">Số biên nhận</th>
        <th width="30%">Ngày lập</th>
        <th>Tổng số tiền</th>
    </tr>
    <?php foreach($data_biennhan as $item){ ?>
    <tr>
    	<td><a onclick="viewBienNhan(<?php echo $item['biennhanid']?>)"><?php echo $item['sobiennhan']?></a></td>
        <td><?php echo $this->date->formatMySQLDate($item['ngaylap'])?></td>
        <td class="number"><?php echo $this->string->numberFormate($item['tongtien'])?></td>
    </tr>
    <?php } ?>
    <tr>
    	<td></td>
        <td class="text-right">Tổng phải trả:</td>
        <td class="number"><?php echo $this->string->numberFormate($tongbiennhan)?></td>
    </tr>
</table>
<h3>Dach sách phiếu thu</h3>
<table>
	<tr>
    	<th width="30%">Số phiếu</th>
        <th width="30%">Ngày lập</th>
        <th>Số tiền</th>
    </tr>
    <?php foreach($data_phieuthu as $item){ ?>
    <tr>
    	<td><a onclick="viewPhieuThu(<?php echo $item['maphieu']?>)"><?php echo $item['sophieu']?></a></td>
        <td><?php echo $this->date->formatMySQLDate($item['ngaylap'])?></td>
        <td class="number"><?php echo $this->string->numberFormate($item['quidoi'])?></td>
    </tr>
    <?php } ?>
    <tr>
    	<td></td>
        <td class="text-right">Tổng đã trả:</td>
        <td class="number"><?php echo $this->string->numberFormate($tongphieuthu)?></td>
    </tr>
</table>
<h3>Tổng công nợ: <?php echo $this->string->numberFormate($congno)?></h3>
<script language="javascript">
function viewBienNhan(biennhanid)
{
	openDialog("?route=addon/biennhan/view&biennhanid="+biennhanid+"&dialog=print",800,500);
}
function viewPhieuThu(maphieu)
{
	openDialog("?route=ben/phieuthu/view&maphieu="+maphieu+"&dialog=print",800,500);
}
</script>