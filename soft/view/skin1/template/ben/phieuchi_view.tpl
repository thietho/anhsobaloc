<h3 style="text-align:center">Phiếu chi</h3>
<p style="text-align:center">Ngày <?php echo $this->date->getDay($item['ngaylap'])?> tháng <?php echo $this->date->getMonth($item['ngaylap'])?> năm <?php echo $this->date->getYear($item['ngaylap'])?></p>
<p style="text-align:center">
	<label>Số:</label> <?php echo $item['sophieu']?>
</p>
<p>
	<label>Người nhận tiền:</label> <?php echo $item['tenkhachhang']?>
</p>
<p>
	<label>Địa chỉ:</label> <?php echo $item['diachi']?>
</p>
<p>
	<label>Lý do:</label> <?php echo $item['lydo']?>
</p>
<p>
	<label>Số tiền:</label> <?php echo $this->string->numberFormate($item['quidoi'])?> <?php echo $this->document->tiente['VND']?> 
    <i>(Số tiền viết bằng chữ)</i> <?php echo $this->string->doc_so($item['quidoi'])?> <?php echo $this->document->tiente['VND']?>
</p>
<p>
	<label>Kèm theo:</label> <?php echo $item['chungtulienquan']?> chứng từ gốc
</p>
<table style="margin:15px 0">
	<tr>
    	
        <th width="20%">Người lập phiếu</th>
        <th width="20%">Người nhận</th>
        <th width="20%">Thủ quỷ</th>
    </tr>
    <tr>
    	
        <td align="center"><i>(Ký, Họ tên)</i></td>
        <td align="center"><i>(Ký, Họ tên)</i></td>
        <td align="center"><i>(Ký, Họ tên)</i></td>
    </tr>
</table>
<div style="height:80px"></div>
<p>
	<label>Đã nhận đử số tiền <i>(viết bằng chữ)</i>:</label>
</p>	
         