<script src='<?php echo DIR_JS?>ui.datepicker.js' type='text/javascript' language='javascript'> </script>
<div class="section">

	<div class="section-title"><?php echo $heading_title?></div>
    
    <div class="section-content">
    	
        <form action="" method="post" id="listitem" name="listitem">
        	<div id="ben-search">
            	<label>Order Id</label>
                <input type="text" id="orderid" name="orderid" class="text" value="" />
                <label>MemberID</label>
                <input type="text" id="userid" name="userid" class="text" value="" />
                <label>Customer name</label>
                <input type="text" id="customername" name="customername" class="text" value="" />
                <label>Address</label>
                <input type="text" id="address" name="address" class="text" value="" /><br />
                <label>Email</label>
                <input type="text" id="email" name="email" class="text" value="" />
                <label>Phone</label>
                <input type="text" id="phone" name="phone" class="text" value="" />
                <label>Status</label>
                <select id="status" name="status">
                	<option value=""></option>
                    <?php foreach($this->document->status as $key => $val) { ?>
                    <option value="<?php echo $key?>" ><?php echo $val?></option>
                    <?php } ?>
                </select>
                <br />
                <label>From date</label>
				<script language="javascript">
                    $(function() {
                        $("#fromdate").datepicker({
                                changeMonth: true,
                                changeYear: true,
                                dateFormat: 'dd-mm-yy'
                                });
                        });
                 </script>
                 <input type="text" id="fromdate" name="fromdate" value="" class="text" />
                 
                <label>To date</label>
				<script language="javascript">
                $(function() {
                    $("#todate").datepicker({
                            changeMonth: true,
                            changeYear: true,
                            dateFormat: 'dd-mm-yy'
                            });
                    });
                </script>
                 <input type="text" id="todate" name="todate" value="" class="text"/>
                <br />
                <input type="button" class="button" name="btnSearch" value="Search" onclick="searchForm()"/>
                <input type="button" class="button" name="btnSearch" value="View all" onclick="window.location = '?route=addon/order'"/>
            </div>
        	<div class="button right">
            	<input class="button" type="button" name="delete_all" value="Delete" onclick="deleteorder()"/>  
            </div>
            <div class="clearer">&nbsp;</div>
            
            <div class="sitemap treeindex">
                <table class="data-table" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr class="tr-head">
                        <th width="1%"><input class="inputchk" type="checkbox" onclick="$('input[name*=\'delete\']').attr('checked', this.checked);"></th>
                        <th>ID</th>
                        <th width="25%"><?php echo $column_customername?></th>
                        <th width="35%"><?php echo $column_address?></th>
                        <th width="15%"><?php echo $column_phone?></th>
                        <th width="15%"><?php echo $column_orderdate?></th>                    
                        <th width="10%"><?php echo $column_orderstatus?></th>                                  
                    </tr>
        
        
        <?php
            foreach($orders as $order)
            {
        ?>
                    <tr>
                        <td class="check-column"><input class="inputchk" type="checkbox" name="delete[<?php echo $order['orderid']?>]" value="<?php echo $order['orderid']?>" ></td>
                        <td><a href="?route=addon/order/view&orderid=<?php echo $order['orderid']?>"><?php echo $order['orderid']?></a></td>
                        <td><?php echo $order['customername']?></td>
                        <td><?php echo $order['address']?></td>
                		<td><?php echo $order['email']?></td>
                        <td><?php echo $this->date->formatMySQLDate($order['orderdate'])?> <?php echo $this->date->getTime($order['orderdate'])?></td>
                        <td class="link-control">
                            <!--<select id="status<?php echo $order['orderid']?>" onchange="order.updateStatus('<?php echo $order['orderid']?>',this.value)">
                            	<?php foreach($this->document->status as $key => $val) { ?>
                                <option value="<?php echo $key?>" <?php echo ($order['status'] == $key)?'selected="selected"':''?>><?php echo $val?></option>
                                <?php } ?>
                            </select>-->
                            <?php echo $this->document->status[$order['status']]?>
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
	
	if($("#orderid").val() != "")
		url += "&orderid=" + $("#orderid").val();
	if($("#userid").val() != "")
		url += "&userid="+ $("#userid").val();
	if($("#customername").val() != "")
		url += "&customername="+ $("#customername").val();
	if($("#address").val() != "")
		url += "&address="+ $("#address").val();
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

$("#orderid").val("<?php echo $_GET['orderid']?>");
$("#userid").val("<?php echo $_GET['userid']?>");
$("#customername").val("<?php echo $_GET['customername']?>");
$("#address").val("<?php echo $_GET['address']?>");
$("#email").val("<?php echo $_GET['email']?>");
$("#phone").val("<?php echo $_GET['phone']?>");
$("#status").val("<?php echo $_GET['status']?>");
$("#fromdate").val("<?php echo $_GET['fromdate']?>");
$("#todate").val("<?php echo $_GET['todate']?>");
</script>