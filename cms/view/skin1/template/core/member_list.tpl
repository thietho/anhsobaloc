<div class="section">

	<div class="section-title">Quản lý khách hàng</div>
    
    <div class="section-content">
    	
        <form action="" method="post" id="listuser" name="listuser">
        
        	<div class="button right">
               	<?php if($_GET['dialog'] != 'true'){ ?>
                <input type="button" class="button" value="Thêm" onclick="window.location='<?php echo $insert?>'" />
            	<input class="button" type="button" name="delete_all" value="Xóa" onclick="deleteUser()"/>  
                <?php }?>
            </div>
            <div class="clearer">^&nbsp;</div>
            <div id="ben-search">
            	<p>
                    <label>Tên đăng nhập</label>
                    <input type="text" id="username" name="username" class="text"/>
                    
                    <label>Tên khách hàng</label>
                    <input type="text" id="fullname" name="fullname" class="text"/>
                    <label>Số diện thoai</label>
                    <input type="text" id="phone" name="phone" class="text"/>
                    <label>Địa chỉ</label>
                    <input type="text" id="address" name="address" class="text"/>
                    <label>Email</label>
                    <input type="text" id="email" name="email" class="text"/>
                </p>
                <p>
                
                
                <label>Tình trạng</label>
                <select id="status" name="status">
                	<option value=""></option>
                    <?php foreach($this->document->userstatus as $key => $val){ ?>
                    <option value="<?php echo $key?>"><?php echo $val?></option>
                    <?php } ?>
                </select>
                
                </p>
                <input type="button" class="button" name="btnSearch" value="Tìm" onclick="searchForm()"/>
                <input type="button" class="button" name="btnSearch" value="Xem tất cả" onclick="viewAll()"/>
            </div>
            <div class="sitemap treeindex" id="memberlist">
                
            </div>
        	
        
        </form>
        
    </div>
    
</div>
<script language="javascript">
$(document).ready(function(e) {
    viewAll();
});


function activeUser(userid)
{
	$.ajax({
			url: "?route=core/member/active&id="+userid,
			cache: false,
			success: function(html){
			alert(html)
			linkto("?<?php echo $refres?>")
		  }
	});
}

function deleteUser()
{
	var answer = confirm("Bạn có muốn xóa không?")
	if (answer)
	{
		$.post("?route=core/member/delete", 
				$("#listuser").serialize(), 
				function(data)
				{
					if(data!="")
					{
						alert(data)
						linkto("?<?php echo $refres?>")
					}
				}
		);
	}
}
function viewAll()
{
	var dialog = "<?php echo $_GET['dialog']?>";

	var urldialog = "";
	if(dialog == "true")
	{
		urldialog = "dialog=true";	
	}
	$('#memberlist').load("?route=core/member/loadTableMember"+"&"+urldialog);
}
function searchForm()
{
	var url = "?route=core/member/loadTableMember";
	if($("#username").val() != "")
		url += "&username=" + $("#username").val();
	if($("#fullname").val() != "")
		url += "&fullname="+ $("#fullname").val();
	if($("#phone").val() != "")
		url += "&phone="+ $("#phone").val();
	if($("#address").val() != "")
		url += "&address="+ $("#address").val();
	if($("#email").val() != "")
		url += "&email="+ $("#email").val();
	if($("#status").val() != "")
		url += "&status="+ $("#status").val();
	var dialog = "<?php echo $_GET['dialog']?>";
	var urldialog = "";
	if(dialog == "true")
	{
		urldialog = "dialog=true";	
	}
	$('#memberlist').load(url+"&"+urldialog);
}

$("#username").val("<?php echo $_GET['username']?>");
$("#fullname").val("<?php echo $_GET['fullname']?>");
$("#phone").val("<?php echo $_GET['phone']?>");
$("#address").val("<?php echo $_GET['address']?>");
$("#email").val("<?php echo $_GET['email']?>");
$("#status").val("<?php echo $_GET['status']?>");

function moveto(url,eid)
{
	$('#'+eid).load(url);
}
</script>