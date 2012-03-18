<script src='<?php echo DIR_JS?>ui.datepicker.js' type='text/javascript' language='javascript'> </script>
<div class="section">

	<div class="section-title">Quản lý dich vụ</div>
    
    <div class="section-content">
    	
        <form action="" method="post" id="listitem" name="listitem">
        	
        	<div class="button right">
            	
                <input class="button" type="button" name="btnAdd" value="Thêm" onclick="window.location='<?php echo $insert?>'"/>  
            	<input class="button" type="button" name="delete_all" value="Xóa" onclick="deleteorder()"/>  
            </div>
            <div class="clearer">&nbsp;</div>
            
            <div class="sitemap treeindex">
                <table class="data-table" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr class="tr-head">
                        <th width="1%"><input class="inputchk" type="checkbox" onclick="$('input[name*=\'delete\']').attr('checked', this.checked);"></th>
                        
                        <th>Tên dịch vụ</th>
                        <th>Giá mặc định</th>
                        <th width="10%"></th>                                  
                    </tr>
        
        
        <?php
            foreach($datas as $item)
            {
        ?>
                    <tr>
                        <td class="check-column"><input class="inputchk" type="checkbox" name="delete[<?php echo $item['dichvuid']?>]" value="<?php echo $item['dichvuid']?>" ></td>
                        <td><?php echo $item['tendichvu']?></td>
                        <td class="number"><?php echo $this->string->numberFormate($item['giamatdinh'])?></td>
                		
                        <td class="link-control">
                            <input type="button" class="button" name="btnEdit" value="Sữa" onClick="window.location='<?php echo $item['link_edit']?>'">
                        </td>
                    </tr>
        <?php
            }
        ?>
                        
                                                    
                </tbody>
                </table>
            </div>
        
        
        </form>
        
    </div>
    
</div>
<script language="javascript">
function deleteorder()
{
	var answer = confirm("Are you sure delete?")
	if (answer)
	{
		$.post("?route=addon/order/delete", 
				$("#listitem").serialize(), 
				function(data)
				{
					if(data!="")
					{
						alert(data)
						window.location.reload();
					}
				}
		);
	}
}

function searchForm()
{
	var url =  "?route=addon/order";
	
	if($("#dichvuid").val() != "")
		url += "&dichvuid=" + $("#dichvuid").val();
	if($("#userid").val() != "")
		url += "&userid="+ $("#userid").val();
	if($("#tendichvu").val() != "")
		url += "&tendichvu="+ $("#tendichvu").val();
	if($("#giamatdinh").val() != "")
		url += "&giamatdinh="+ $("#giamatdinh").val();
	if($("#email").val() != "")
		url += "&email="+ $("#email").val();
	if($("#phone").val() != "")
		url += "&phone="+ $("#phone").val();
	if($("#status").val() != "")
		url += "&status="+ $("#status").val();
	if($("#fromdate").val() != "")
		url += "&fromdate="+ $("#fromdate").val();
	if($("#todate").val() != "")
		url += "&todate="+ $("#todate").val();
	
	window.location = url;
}

$("#dichvuid").val("<?php echo $_GET['dichvuid']?>");
$("#userid").val("<?php echo $_GET['userid']?>");
$("#tendichvu").val("<?php echo $_GET['tendichvu']?>");
$("#giamatdinh").val("<?php echo $_GET['giamatdinh']?>");
$("#email").val("<?php echo $_GET['email']?>");
$("#phone").val("<?php echo $_GET['phone']?>");
$("#status").val("<?php echo $_GET['status']?>");
$("#fromdate").val("<?php echo $_GET['fromdate']?>");
$("#todate").val("<?php echo $_GET['todate']?>");
</script>