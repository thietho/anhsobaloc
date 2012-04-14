<div class="section" id="sitemaplist">

	<div class="section-title">Quản lý biên nhận</div>
    
    <div class="section-content padding1">
    
    	<form name="frm" id="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="biennhanid" value="<?php echo $item['biennhanid']?>">	
            <div class="button right">
                <a class="button save" onclick="save()">Lưu</a>
                <a class="button cancel" href="?route=addon/dichvu">Bỏ qua</a>    
        	</div>
            <div class="clearer">&nbsp;</div>
        	<div id="error" class="error" style="display:none"></div>
        	<div>   
                
                <p class="left">
                    <label>Ngày lập</label><br />
                    <input type="text" name="ngaylap" value="<?php echo $item['ngaylap']?>" class="text ben-datepicker"/>
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
                    <textarea name="<?php echo $item['ghichu']?>"></textarea>
                </p>
                <div class="clearer">&nbsp;</div>
            </div>
            <div>
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
                <input type="button" class="button" id="btnThemDong" value="Thêm"/>
                <input type="hidden" id="delchitietid" name="delchitietid"
            </div>
        </form>
    
    </div>
    
</div>

<script language="javascript">
$('#btnSelectKhachHang').click(function(e) {
    openDialog("?route=core/member&dialog=true",800,500);
});
$('#btnThemDong').click(function(e) {
    biennhan.addRow('','',0,'');
});

function BienNhan()
{
	this.index = 0;
	this.cbDichVu = '';
	this.addRow = function(id,dichvuid,sotien,ghichu)
	{
		var colchk = '<td></td>';
		var coldichvu = '<td><select id="dichvuid-'+ this.index +' name="dichvuid['+this.index+']"></select></td>';
		var colsotien = '<td><input type="text" class="text number" id="sotien-'+this.index+'" name="sotien['+this.index+']" value="'+sotien+'"></td>';
		var colghichu = '<td><textarea id="ghichuct-'+this.index+'" name="ghichuct['+this.index+']">'+ghichu+'</textarea></td>';
		var row = '<tr id="row-'+this.index+'">'+colchk+coldichvu+colsotien+colghichu+'</tr>';
		
		$('#listdichvu').append(row);
		this.index++;
	}
}
var biennhan = new BienNhan();
function save()
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.post("?route=addon/dichvu/save", $("#frm").serialize(),
		function(data){
			if(data == "true")
			{
				window.location = "?route=addon/dichvu";
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
