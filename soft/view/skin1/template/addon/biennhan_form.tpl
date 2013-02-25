<div class="section" id="sitemaplist">

	<div class="section-title">Quản lý biên nhận</div>
    
    <div class="section-content padding1">
    
    	<form name="frm" id="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="biennhanid" value="<?php echo $item['biennhanid']?>">	
            <div class="button right">
                <a class="button save" onclick="save('')">Lưu</a>
                <a class="button save" onclick="save('print')">Lưu & In</a>
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
                    <input type="hidden" id="khachhangid" name="khachhangid" value="<?php echo $item['khachhangid']?>">
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
                    <label>Ngày hẹn</label><br />
                    <input type="text" name="ngayhen" value="<?php echo $this->date->formatMySQLDate($item['ngayhen'])?>" class="text ben-datepicker"/>
                    
                </p>
                <p>
                    <label>Ghi chú</label><br />
                    <textarea name="ghichu" class="ghichu"><?php echo $item['ghichu']?></textarea>
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
                        	
                            <th>Tên dịch vụ</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Số tiền</th>
                            
                        </tr>
                    </thead>
                    <tbody id="listdichvu">
                    	
                    </tbody>
                   	<tfoot>
                    	<tr>
                        	<td></td>
                            <td></td>
                            <td></td>
                            <td class="number">Tổng cộng: <span id="total"></span></td>
                            
                        </tr>
                    	
                        <tr>
                        	<td></td>
                            <td></td>
                            <td></td>
                            <td class="number">Giảm giá: <input type="text" class="text number" id="giamgia" name="giamgia" value="<?php echo $item['giamgia']?>"/></td>
                            
                        </tr>
                        <tr>
                        	<td></td>
                            <td></td>
                            <td></td>
                            <td class="number">Phần trăm giảm giá: <input type="text" class="text number" id="phantramgiamgia" name="phantramgiamgia" value="<?php echo $item['phantramgiamgia']?>"/></td>
                            
                        </tr>
                        <tr>
                        	<td></td>
                            <td></td>
                            <td></td>
                            <td class="number">Tổng tiền: <span id="totalfinal"></span></td>
                            
                        </tr>
                        <tr>
                        	<td></td>
                            <td></td>
                            <td></td>
                            <td class="number">Tạm ứng: <input type="text" class="text number" id="tamung" name="tamung" value="<?php echo $item['tamung']?>"/></td>
                            
                        </tr>
                        <tr>
                        	<td></td>
                            <td></td>
                            <td></td>
                            <td class="number">Còn lại: <span id="remain"></span></td>
                            
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
                                	$.getJSON("?route=core/user/getUser&id="+this.value,function(data){
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
    biennhan.addRow(0,0,'',0,0,0,'');
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
				biennhan.addRow("<?php echo $ct['id']?>","<?php echo $ct['dichvuid']?>","<?php echo $ct['tendichvu']?>","<?php echo $ct['soluong']?>","<?php echo $ct['dongia']?>","<?php echo $ct['sotien']?>","<?php echo $ct['ghichu']?>");
	<?php
		 	}
		}
	 ?>
		});
	}
	this.addRow = function(id,dichvuid,tendichvu,soluong,dongia,sotien,ghichu)
	{
		
		var coldichvu = '<td><input type="hidden" id="id-'+this.index+'" name="id['+this.index+']" value="'+id+'"><input type="hidden" id="dichvuid-'+this.index+'" name="dichvuid['+this.index+']" value="'+dichvuid+'"><input type="text" class="text" id="tendichvu-'+this.index+'" name="tendichvu['+this.index+']" value="'+tendichvu+'"></td>';
		var colsoluong = '<td class="number"><input type="text" class="text number soluong" id="soluong-'+this.index+'" name="soluong['+this.index+']" value="'+soluong+'" ref="'+this.index+'"></td>';
		var coldongia = '<td class="number"><input type="text" class="text number dongia" id="dongia-'+this.index+'" name="dongia['+this.index+']" value="'+dongia+'" ref="'+this.index+'"></td>';
		var colsotien = '<td class="number"><input type="text" class="text number tinhtong" id="sotien-'+this.index+'" name="sotien['+this.index+']" value="'+sotien+'" readonly></td>';
		var colghichu = '<td><textarea id="ghichuct-'+this.index+'" name="ghichuct['+this.index+']">'+ghichu+'</textarea></td>';
		var row = '<tr id="row-'+this.index+'">'+coldichvu+colsoluong+coldongia+colsotien+'</tr>';
		
		$('#listdichvu').append(row);
		$('#dichvuid-'+ this.index).val(dichvuid);
		this.index++;
		numberReady();
		this.getTotal();
		$('.soluong').keyup(function(e) {
			var p = $(this).attr('ref');
			
			biennhan.getSubTotal(p);
		});
		$('.dongia').keyup(function(e) {
			var p = $(this).attr('ref');
			
			biennhan.getSubTotal(p);
		});
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
	this.getSubTotal = function(pos)
	{
		
		var soluong = String($('#soluong-'+pos).val()).replace(/,/g,"");
		var dongia = String($("#dongia-"+pos).val()).replace(/,/g,"");
		var subtotal = Number(soluong) * Number(dongia);
		$("#sotien-"+pos).val(formateNumber(subtotal));
		this.getTotal();
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
			
			$('#remain').html(formateNumber(biennhan.sum - Number(tamung) - giamgia));
    	});
	}
}
var biennhan = new BienNhan();
function save(action)
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.post("?route=addon/biennhan/save", $("#frm").serialize(),
		function(data){
			var arr = data.split("-");
			if(arr[0] == "true")
			{
				if(action == 'print')
				{
					view(arr[1])
				}
				else
				{
					window.location = "?route=addon/biennhan";	
				}
			}
			else
			{
			
				$('#error').html(data).show('slow');
				$.unblockUI();
				
			}
			
		}
	);
}
function view(biennhanid)
{
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
							window.location = "?route=addon/biennhan";
						},
						'In': function(){
							openDialog("?route=addon/biennhan/view&biennhanid="+biennhanid+"&dialog=print",800,500)
							window.location = "?route=addon/biennhan";
						},
					}
				});
			
				
	$("#popup-content").load("?route=addon/biennhan/view&biennhanid="+biennhanid+"&dialog=true",function(){
		$("#popup").dialog("open");	
	});
}
</script>
