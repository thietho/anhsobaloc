<h3 style="text-align:center">Phiếu thu</h3>
<p style="text-align:center">Ngày <?php echo $this->date->getDay($item['ngaylap'])?> tháng <?php echo $this->date->getMonth($item['ngaylap'])?> năm <?php echo $this->date->getYear($item['ngaylap'])?></p>
<p style="text-align:center">
	<label>Số:</label> <?php echo $item['sophieu']?>
</p>
<p>
	<label>Tên khách hàng:</label> <?php echo $item['tenkhachhang']?>
    <label>Số điện thoại</label> <?php echo $item['dienthoai']?>
    <label>Email:</label> <?php echo $item['email']?>
    
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

<table style="margin:15px 0">
	<tr>
    	<th width="20%">Thủ trưởng đơn vị</th>
        <th width="20%">Kế toán trưởng</th>
        <th width="20%">Người lập phiếu</th>
        <th width="20%">Người nộp</th>
        <th width="20%">Thủ quỷ</th>
    </tr>
    <tr>
    	<td align="center"><i>(Ký, Họ tên, Đóng dấu)</i></td>
        <td align="center"><i>(Ký, Họ tên)</i></td>
        <td align="center"><i>(Ký, Họ tên)</i></td>
        <td align="center"><i>(Ký, Họ tên)</i></td>
        <td align="center"><i>(Ký, Họ tên)</i></td>
    </tr>
</table>
          	
         