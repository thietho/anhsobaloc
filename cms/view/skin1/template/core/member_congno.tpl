<h3>Dach sách biên nhận</h3>
<table>
	<tr>
    	<th>Số biên nhận</th>
        <th>Ngày lập</th>
        <th>Tổng số tiền</th>
    </tr>
    <?php foreach($data_biennhan as $item){ ?>
    <tr>
    	<td><?php echo $item['sobiennhan']?></td>
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
    	<th>Số phiếu</th>
        <th>Ngày lập</th>
        <th>Số tiền</th>
    </tr>
    <?php foreach($data_phieuthu as $item){ ?>
    <tr>
    	<td><?php echo $item['sophieu']?></td>
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