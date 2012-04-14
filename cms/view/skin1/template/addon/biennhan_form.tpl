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
                <input type="hidden" id="delchitietid" name="delchitietid" />
            	<table>
                	<thead>
                    	<tr>
                        	<th width="1%"><input type="checkbox"></th>
                            <th>Tên dịch vụ</th>
                            <th>Số tiền</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody id="listdichvu">
                    	
                    </tbody>
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
				biennhan.addRow("<?php echo $ct['id']?>","<?php echo $ct['dichvuid']?>","<?php echo $ct['sotien']?>","<?php echo $ct['sotien']?>");
	<?php
		 	}
		}
	 ?>
		});
	}
	this.addRow = function(id,dichvuid,sotien,ghichu)
	{
		var colchk = '<td></td>';
		var coldichvu = '<td><select id="dichvuid-'+ this.index +'" name="dichvuid['+this.index+']" onchange="biennhan.fillPrice(this.value,'+  this.index +')">'+ this.cbDichVu +'</select></td>';
		var colsotien = '<td><input type="text" class="text number" id="sotien-'+this.index+'" name="sotien['+this.index+']" value="'+sotien+'"></td>';
		var colghichu = '<td><textarea id="ghichuct-'+this.index+'" name="ghichuct['+this.index+']">'+ghichu+'</textarea></td>';
		var row = '<tr id="row-'+this.index+'">'+colchk+coldichvu+colsotien+colghichu+'</tr>';
		
		$('#listdichvu').append(row);
		$('#dichvuid-'+ this.index).val(dichvuid);
		this.index++;
		numberReady();
		
	}
	
	this.fillPrice = function(dichvuid,pos)
	{
		$.getJSON("?route=addon/dichvu/getDichVu&dichvuid="+dichvuid,function(data){
			$('#sotien-'+pos).val(data.giamatdinh);
			numberReady();
		});	
	}
}
var biennhan = new BienNhan();
function save()
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.post("?route=addon/biennhan/save", $("#frm").serialize(),
		function(data){
			if(data == "true")
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
