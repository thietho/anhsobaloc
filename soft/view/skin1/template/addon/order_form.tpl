<div class="section" id="sitemaplist">

	<div class="section-title"><?php echo $heading_title?></div>
    
    <div class="section-content padding1">
    
    	<form name="frm" action="<?php echo $action?>" method="post" enctype="multipart/form-data">
        
        	<div class="button right">
            	
     	        <a class="button" href="index.php?route=addon/order"><?php echo $button_cancel?></a>
                
            </div>
            <div class="clearer">^&nbsp;</div>
        
        	<div>
            	<p>
            		<label>Order id</label><br />
					<?php echo $order['orderid']?>
            	</p>
                <p>
            		<label><?php echo $entry_customername?></label><br />
					<?php echo $order['customername']?>
            	</p>
                <p>
            		<label><?php echo $entry_email?></label><br />
					<?php echo $order['email']?>
            	</p><p>
            		<label><?php echo $entry_address?></label><br />
					<?php echo $order['address']?>
            	</p>
                <p>
            		<label><?php echo $entry_phone?></label><br />
					<?php echo $order['phone']?>
            	</p>
                <p>
            		<label><?php echo $entry_orderdate?></label><br />
					<?php echo $this->date->formatMySQLDate($order['orderdate'])?>
            	</p>
                <p>
            		<label><?php echo $entry_status?></label><br />
					<select id="status<?php echo $order['orderid']?>" onchange="order.updateStatus('<?php echo $order['orderid']?>',this.value)">
                        <?php foreach($this->document->status as $key => $val) { ?>
                        <option value="<?php echo $key?>" <?php echo ($order['status'] == $key)?'selected="selected"':''?>><?php echo $val?></option>
                        <?php } ?>
                    </select>
            	</p>
                <p>
            		<label><?php echo $entry_message?></label><br />
					<?php echo $order['comment']?>
            	</p>
            </div>
            <div>
            	<table>
                	<thead>
                    	<tr>
                            <th><?php echo $column_productname?></th>
                            <th><?php echo $column_productimage?></th>
                            <th><?php echo $column_productqty?></th>
                            <th>Price</th>
                            <th>Sub total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $sum = 0;
                    foreach($detail as $item)
                    {
                    	$sum += $item['subtotal'];
                    ?>
                    	<tr>
                            <td><?php echo $item['title']?></td>
                            <td><?php echo $item['imagepreview']?></td>
                            <td class="number"><?php echo $this->string->numberFormate($item['quantity'])?></td>
                            <td class="number"><?php echo $this->string->numberFormate($item['price'])?></td>
                            <td class="number"><?php echo $this->string->numberFormate($item['subtotal'])?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                    	<tr>
                        	<td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="number"><?php echo $this->string->numberFormate($sum)?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </form>
    
    </div>
    
</div>

