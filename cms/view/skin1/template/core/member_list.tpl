<div class="section">

	<div class="section-title">Quản lý khách hàng</div>
    
    <div class="section-content">
    	
        <form action="" method="post" id="listuser" name="listuser">
        
        	<div class="button right">
               	<?php if($_GET['dialog'] != 'true'){ ?>
                
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
                <input type="button" class="button" name="btnSearch" value="Xem tất cả" onclick="window.location = '?route=core/member'"/>
            </div>
            <div class="sitemap treeindex">
                <table class="data-table" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr class="tr-head">
                        <th width="1%"><input class="inputchk" type="checkbox" onclick="$('input[name*=\'delete\']').attr('checked', this.checked);"></th>
                        
                        <th>Tên đăng nhập</th>
                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Email</th>
                        <th>Trang thái</th>
                        <?php if($_GET['dialog'] != 'true'){ ?>                 
                        <th width="10%">Control</th>                                  
                        <?php } ?>
                    </tr>
        
        
        <?php
            foreach($users as $user)
            {
        ?>
                    <tr>
                        <td class="check-column"><input class="inputchk" type="checkbox" name="delete[<?php echo $user['id']?>]" value="<?php echo $user['id']?>" ></td>
                        
                        <td><?php echo $user['username']?></td>
                        <td><?php echo $user['fullname']?></td>
                        <td><?php echo $user['phone']?></td>
                        <td><?php echo $user['address']?></td>
                        <td><?php echo $user['email']?></td>
                		<td><?php echo $this->document->userstatus[$user['status']]?></td>
                        <?php if($_GET['dialog'] != 'true'){ ?>
                        <td class="link-control">
                            <input type="button" class="button" value="<?php echo $user['text_edit']?>" onclick="window.location='<?php echo $user['link_edit']?>'"/>
                            <input type="button" class="button" value="<?php echo $user['text_active']?>" onclick="activeUser('<?php echo $user['id']?>')"/>
                        </td>
                        <?php } ?>
                    </tr>
        <?php
            }
        ?>
                        
                                                    
                </tbody>
                </table>
            </div>
        	<?php echo $pager?>
        
        </form>
        
    </div>
    
</div>
<script language="javascript">
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
function searchForm()
{
	var url =  "?route=core/member";
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
	
	window.location = url;
}

$("#username").val("<?php echo $_GET['username']?>");
$("#fullname").val("<?php echo $_GET['fullname']?>");
$("#phone").val("<?php echo $_GET['phone']?>");
$("#address").val("<?php echo $_GET['address']?>");
$("#email").val("<?php echo $_GET['email']?>");
$("#status").val("<?php echo $_GET['status']?>");
</script>