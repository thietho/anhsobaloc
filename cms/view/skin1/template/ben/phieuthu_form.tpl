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
                    <textarea name="ghichu"><?php echo $item['ghichu']?></textarea>
                </p>
                <div class="clearer">&nbsp;</div>
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
