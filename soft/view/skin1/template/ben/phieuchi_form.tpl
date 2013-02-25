<div class="section" id="sitemaplist">

	<div class="section-title">Quản lý phiếu chi</div>
    
    <div class="section-content padding1">
    
    	<form name="frm" id="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="maphieu" value="<?php echo $item['maphieu']?>">
        <input type="hidden" name="sophieu" value="<?php echo $item['sophieu']?>">
        <input type="hidden" name="ngaylap" value="<?php echo $item['ngaylap']?>">	
            <div class="button right">
                <a class="button save" onclick="save('')">Lưu</a>
                <a class="button save" onclick="save('print')">Lưu & In</a>
                <a class="button cancel" href="?route=ben/phieuchi">Bỏ qua</a>    
        	</div>
            <div class="clearer">&nbsp;</div>
        	<div id="error" class="error" style="display:none"></div>
        	<div>   
                
                <p class="left">
                    
                    <input type="button" class="button" id="btnSelectKhachHang" value="Chọn khách hàng">
                </p>
                
                <div class="clearer">&nbsp;</div>
                <p class="left">
                    <label>Tên người nhận tiền</label><br />
                    <input type="hidden" id="makhachhang" name="makhachhang" value="<?php echo $item['makhachhang']?>">
                    <input type="text" id="tenkhachhang" name="tenkhachhang" value="<?php echo $item['tenkhachhang']?>" class="text" size=60 />
                </p>
                
                <p class="left">
                    <label>Số điện thoại</label><br />
                    <input type="text" id="dienthoai" name="dienthoai" value="<?php echo $item['dienthoai']?>" class="text" size=60 />
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
                	<label>Số chứng từ:</label><br />
                    <input type="text" name="chungtulienquan" value="<?php echo $item['chungtulienquan']?>" class="text" size=60/>
                </p>
                <p>
                	<label>Tài khoản chi</label><br>
                    <select id="taikhoanthuchi" name="taikhoanthuchi">
                    	<?php foreach($chiphi as $val){?>
                        <option value="<?php echo $val['categoryid']?>"><?php echo $val['categoryname']?></option>
                        <?php } ?>
                    </select>
                </p>
                <p>
                    <label>Số tiền</label><br />
                    <input type="text" name="sotien" value="<?php echo $item['sotien']?>" class="text number"/>
                    <input type="hidden" id="donvi" name="donvi" value="VND" />
                    
                </p>
                <p>
                	<label>Hình thức thanh toán</label><br />
                    <select id="hinhthucthanhtoan" name="hinhthucthanhtoan">
                    <?php foreach($this->document->payment as $key => $val){ ?>
                    <option value="<?php echo $key?>"><?php echo $val?></option>
                    <?php } ?>
                    </select>
                </p>
                <p>
                    <label>Lý do chi</label><br />
                    <textarea name="lydo" class="ghichu"><?php echo $item['lydo']?></textarea>
                </p>
                <div class="clearer">&nbsp;</div>
            </div>
            
        </form>
    
    </div>
    
</div>

<script language="javascript">
$('#taikhoanthuchi').val("<?php echo $item['taikhoanthuchi']?>");
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
										$('#makhachhang').val(data.id);
										$('#tenkhachhang').val(data.fullname);
										$('#dienthoai').val(data.phone);
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


function save(action)
{
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.post("?route=ben/phieuchi/save", $("#frm").serialize(),
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
					window.location = "?route=ben/phieuchi";
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
function view(maphieu)
{
	$("#popup").attr('title','Chọn khách hàng');
				$( "#popup" ).dialog({
					autoOpen: false,
					show: "blind",
					hide: "explode",
					width: 800,
					height: 500,
					modal: true,
					close: function(event, ui) {
						window.location = "?route=ben/phieuchi";
					},
					buttons: {
						'Đóng': function() {
							$( this ).dialog( "close" );
							window.location = "?route=ben/phieuchi";
						},
						'In': function(){
							openDialog("?route=ben/phieuchi/view&maphieu="+maphieu+"&dialog=print",800,500)
							window.location = "?route=ben/phieuchi";
						},
					}
				});
			
				
	$("#popup-content").load("?route=ben/phieuchi/view&maphieu="+maphieu+"&dialog=true",function(){
		$("#popup").dialog("open");	
	});
}
</script>
