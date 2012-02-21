<?php if(count($medias)){ ?>
<div>
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
        $sum += $media['price'] * $media['qty'];
    ?>
        <tr>
            <td><img src="<?php echo $media['imagethumbnail']?>" class="ben-center"/></td>
            <td><?php echo $media['title']?></td>
            <td class="number"><?php echo $this->string->numberFormate($media['price'])?><?php echo $this->document->setup['Currency']?></td>
            <td class="number"><?php echo $this->string->numberFormate($media['qty'])?></td>
            <td class="number"><?php echo $this->string->numberFormate($media['price'] * $media['qty'])?><?php echo $this->document->setup['Currency']?></td>
            
        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    	<tr>
        	<td></td>
            <td></td>
            <td></td>
            <td>Tông cộng</td>
            <td class="number"><?php echo $this->string->numberFormate($sum)?><?php echo $this->document->setup['Currency']?></td>
        </tr>
    </tfoot>
</table>
</div>
<div>
	<form id="frmCheckOut" method="post">
    	<div id="error" class="ben-error" style="display:none"></div>
    	<table class="ben-form">
        	
            <input type="hidden" id="userid" name="userid" value="<?php echo $member['username']?>" size="40">
            <tr>
            	<td><label>Họ và tên</label></td>
                <td><input type="text" id="customername" name="customername" value="<?php echo $member['fullname']?>" class="ben-textbox" size="40" <?php echo $readonly?>></td>
            </tr>
            <tr>
            	<td><label>Email</label></td>
                <td><input type="text" id="email" name="email" value="<?php echo $member['email']?>" class="ben-textbox" size="40" <?php echo $readonly?>></td>
            </tr>
            <tr>
            	<td><label>Địa chỉ</label></td>
                <td><input type="text" id="address" name="address" value="<?php echo $member['address']?>" class="ben-textbox" size="40" <?php echo $readonly?>></td>
            </tr>
            <tr>
            	<td ><label>Điện thoại</label></td>
                <td><input type="text" id="phone" name="phone" value="<?php echo $member['phone']?>" class="ben-textbox" size="40" <?php echo $readonly?>></td>
            </tr>
            
            <tr>
            	<td>Ghi chú</td>
                <td><textarea name="comment"></textarea></td>
            </tr>
            
            <tr>
            	<td ></td>
                <td>
                	<input type="button" id="btnCheckout" name="btnCheckout" class="ben-button" value="Thanh toán">
                </td>
            </tr>
        </table>
    </form>
</div>
<div class="clearer">&nbsp;</div>
<script language="javascript">
$("#btnCheckout").click(function(){
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.post("<?php echo HTTP_SERVER?>?route=addon/checkout/checkout", $("#frmCheckOut").serialize(),
		function(data){
			var arr = data.split("-")
			if(arr[0] == "true")
			{
				window.location = HTTP_SERVER+"checkoutcomplete/"+arr[1]+".html";
			}
			else
			{
				
				$('#error').html(data).show('slow');
				
				
			}
			$.unblockUI();
		}
	);					   
});
</script>
<?php }else{ ?>
Chưa có sản phẩm trong giỏ hàng
<?php } ?>
