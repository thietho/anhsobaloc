<div class="section" id="sitemaplist">

	<div class="section-title">Quản lý biên nhận</div>
    
    <div class="section-content padding1">
    
    	<form name="frm" id="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="biennhanid" value="<?php echo $item['biennhanid']?>">	
            <div class="button right">
                <a class="button save" onclick="save()">Lưu</a>
                <a class="button cancel" href="?route=addon/biennhan">Bỏ qua</a>    
        	</div>
            <div class="clearer">&nbsp;</div>
        	<div id="error" class="error" style="display:none"></div>
        	<div>   
                
                <p class="left">
                    <label>Ngày lập</label><br />
                    <input type="text" name="ngaylap" value="<?php echo $this->date->formatMySQLDate($item['ngaylap'])?>" class="text ben-datepicker"/>
                    <input type="button" class="button" id="btnSelectKhachHang" value="Chọn khách hàng">
                </p>
                <div class="clearer">&nbsp;</div>
                <p class="left">
                    <label>Tên khách hàng</label><br />
                    <input type="hidden" id="khachhangid" name="khachhangid" value="<?php echo $item['tenkhachhang']?>">
                    <input type="text" id="tenkhachhang" name="tenkhachhang" value="<?php echo $item['tenkhachhang']?>" class="text" size=60 />
                </p>
                
                <p class="left">
                    <label>Số điện thoại</label><br />
                    <input type="text" id="sodienthoai" name="sodienthoai" value="<?php echo $item['sodienthoai']?>" class="text" size=60 />
                </p>
                <p class="left">
                    <label>Email</label><br />
                    <input type="text" id="email" name="email" value="<?php echo $item['email']?>" class="text" size=60 />
                </p>
                
                <p class="left">
                    <label>Địa chỉ</label><br />
                    <input type="text" id="diachi" name="diachi" value="<?php echo $item['diachi']?>" class="text" size=60 />
                </p>
                <div class="clearer">&nbsp;</div>
                <p>
                    <label>Ghi chú</label><br />
                    <textarea name="ghichu"><?php echo $item['ghichu']?></textarea>
                </p>
                <div class="clearer">&nbsp;</div>
            </div>
            <div>
            	<input type="button" class="button" id="btnThemDong" value="Thêm"/>
                <input type="button" class="button" id="btnXoaDong" value="Xóa"/>
                <input type="hidden" id="delchitietid" name="delchitietid" />
            	<table>
                	<thead>
                    	<tr>
                        	<th width="1%"><input type="checkbox" onclick="$('.chitietbn').attr('checked', this.checked);"></th>
                            <th>Tên dịch vụ</th>
                            <th>Số tiền</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody id="listdichvu">
                    	
                    </tbody>
                   	<tfoot>
                    	<tr>
                        	<td></td>
                            <td></td>
                            <td class="number">Tổng cộng: <span id="total"></span></td>
                            <td></td>
                        </tr>
                    	
                        <tr>
                        	<td></td>
                            <td></td>
                            <td class="number">Giảm giá: <input type="text" class="text number" id="giamgia" name="giamgia" value="<?php echo $item['giamgia']?>"/></td>
                            <td></td>
                        </tr>
                        <tr>
                        	<td></td>
                            <td></td>
                            <td class="number">Phần trăm giảm giá: <input type="text" class="text number" id="phantramgiamgia" name="phantramgiamgia" value="<?php echo $item['phantramgiamgia']?>"/></td>
                            <td>%</td>
                        </tr>
                        <tr>
                        	<td></td>
                            <td></td>
                            <td class="number">Tổng tiền: <span id="totalfinal"></span></td>
                            <td></td>
                        </tr>
                        <tr>
                        	<td></td>
                            <td></td>
                            <td class="number">Tạm ứng: <input type="text" class="text number" id="tamung" name="tamung" value="<?php echo $item['tamung']?>"/></td>
                            <td></td>
                        </tr>
                        <tr>
                        	<td></td>
                            <td></td>
                            <td class="number">Còn lại: <span id="remain"></span></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                
            </div>
        </form>
    
    </div>
    
</div>

<script language="javascript">
$('#btnSelectKhachHang').click(function(e) {
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
						'Chọn': function(){
							$("#listuser input[name*=\'delete\']'").each(function(index, element) {
								if(this.checked == true)
								{
                                	$.getJSON("?route=core/user/getUser&userid="+this.value,function(data){
										$('#khachhangid').val(data.id);
										$('#tenkhachhang').val(data.fullname);
										$('#sodienthoai').val(data.phone);
										$('#email').val(data.email);
										$('#diachi').val(data.address);
										
									});
								}
                            });
							$( this ).dialog( "close" );
						},
						
					}
				});
			
				
				$("#popup-content").load("?route=core/member&dialog=true",function(){
					$("#popup").dialog("open");	
				});
    
});
$('#btnThemDong').click(function(e) {
    biennhan.addRow('','',0,'');
});
$('#btnXoaDong').click(function(e) {
    $('.chitietbn').each(function(index, element) {
        if(this.checked == true)
		{
			var pos = $(this).attr('ref');
			biennhan.removeRow(pos);
		}
    });
});

$('#tamung').keyup(function(e) {
    biennhan.getTotal();
});
$('#giamgia').keyup(function(e) {
    biennhan.getTotal();
	var giamgia = Number(String($('#giamgia').val()).replace(/,/g,""));
	var phantramgiamgia = giamgia/biennhan.sum*100;
	$('#phantramgiamgia').val(formateNumber(phantramgiamgia));
});
$('#phantramgiamgia').keyup(function(e) {
    var phantramgiamgia = Number(String($('#phantramgiamgia').val()).replace(/,/g,""));
	var giamgia = phantramgiamgia * biennhan.sum /100;
	$('#giamgia').val(formateNumber(giamgia));
	biennhan.getTotal();
});
$(document).ready(function(e) {
	biennhan.loadCbDichVu();
});

function BienNhan()
{
	this.index = 0;
	this.cbDichVu = '';
	
	this.loadCbDichVu = function()
	{
		$.get("?route=addon/dichvu/getCbDichVu",function(data){
			biennhan.cbDichVu = data
	<?php 
		if(count($data_chitiet))
		{ 
			foreach($data_chitiet as $ct)
			{
	?>
				biennhan.addRow("<?php echo $ct['id']?>","<?php echo $ct['dichvuid']?>","<?php echo $ct['sotien']?>","<?php echo $ct['ghichu']?>");
	<?php
		 	}
		}
	 ?>
		});
	}
	this.addRow = function(id,dichvuid,sotien,ghichu)
	{
		var colchk = '<td><input type="checkbox" class="chitietbn" ref="'+ this.index +'" value="'+id+'"><input type="hidden" id="id-'+this.index+'" name="id['+this.index+']" value="'+id+'"></td>';
		var coldichvu = '<td><select id="dichvuid-'+ this.index +'" name="dichvuid['+this.index+']" onchange="biennhan.fillPrice(this.value,'+  this.index +')">'+ this.cbDichVu +'</select></td>';
		var colsotien = '<td class="number"><input type="text" class="text number tinhtong" id="sotien-'+this.index+'" name="sotien['+this.index+']" value="'+sotien+'"></td>';
		var colghichu = '<td><textarea id="ghichuct-'+this.index+'" name="ghichuct['+this.index+']">'+ghichu+'</textarea></td>';
		var row = '<tr id="row-'+this.index+'">'+colchk+coldichvu+colsotien+colghichu+'</tr>';
		
		$('#listdichvu').append(row);
		$('#dichvuid-'+ this.index).val(dichvuid);
		this.index++;
		numberReady();
		this.getTotal();
		$('.tinhtong').keyup(function(e) {
			biennhan.getTotal();
		});
	}
	
	this.removeRow = function(pos)
	{
		var id = $('#id-'+pos).val();
		$('#delchitietid').val($('#delchitietid').val()+","+id);
		$('#row-'+pos).remove();
	}
	
	this.fillPrice = function(dichvuid,pos)
	{
		$.getJSON("?route=addon/dichvu/getDichVu&dichvuid="+dichvuid,function(data){
			$('#sotien-'+pos).val(data.giamatdinh);
			numberReady();
			biennhan.getTotal();
		});	
	}
	this.getTotal = function()
	{
		biennhan.sum = 0;
		$('.tinhtong').each(function(index, element) {
        	var num = String(this.value).replace(/,/g,"");
			biennhan.sum += Number(num);
			$('#total').html(formateNumber(biennhan.sum));
			//Giam gia
			var giamgia = Number(String($('#giamgia').val()).replace(/,/g,""));
			var phantramgiamgia = Number(String($('#phantramgiamgia').val()).replace(/,/g,""));
			$('#totalfinal').html(formateNumber(biennhan.sum - giamgia))
			var tamung = String($('#tamung').val()).replace(/,/g,"");
			
			$('#remain').html(formateNumber(biennhan.sum - Number(tamung)));
    	});
	}
}
var biennhan = new BienNhan();
function save()
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.post("?route=addon/biennhan/save", $("#frm").serialize(),
		function(data){
			var arr = data.split("-");
			if(arr[0] == "true")
			{
				window.location = "?route=addon/biennhan";
			}
			else
			{
			
				$('#error').html(data).show('slow');
				$.unblockUI();
				
			}
			
		}
	);
}
</script>
