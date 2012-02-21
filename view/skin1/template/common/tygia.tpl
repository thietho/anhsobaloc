        
      <p>
      Từ
       <select id="formrate">
        	<option value="1">VND</option>
<?php
	 foreach($Tygia as $item)
     {
?>
			<option value="<?php echo $item['Buy']?>"><?php echo $item['CurrencyCode']?></option>
<?php
     }
?>
          
        </select>
        Đến
        <select id="torate">
        	<option value="1">VND</option>
<?php
	 foreach($Tygia as $item)
     {
     		$sel = "";
     		if($item['CurrencyCode'] == "USD")
            	$sel = 'selected="selected"';
?>
			<option value="<?php echo $item['Buy']?>" <?php echo $sel?>><?php echo $item['CurrencyCode']?></option>
<?php
     }
?>
        </select>
        
      </p>
       
       
       
       <p><?php echo $currencyexchange_text_amount?></p>
       <p>
       	<input type="text" id="amount" class="ben-textbox number" />&nbsp;&nbsp;
        <input type="button" class="ben-button" value="Qui đổi" onclick="changeRate()"/>
       </p>
       
       
      
      
      
      
      <p><?php echo $currencyexchange_text_result?></p>
      <p>
        <input type="text" id="result" class="ben-textbox number" readonly="readonly"/>
      </p>
<script language="javascript">
function changeRate()
{
	var result = eval($("#amount").val().replace(/,/g,"")) * eval($("#formrate").val()) / eval($("#torate").val());
	$("#result").val(numberView(result));
}
$(document).ready(function() {
  // Handler for .ready() called.
  	$(".number").keyup(function (e)
		{
			//alert(formateNumber($(this).val()))
			num = formateNumber($(this).val().replace(/,/g,""));
			$(this).val(num)
		});
	$(".number").keypress(function (e)
		{
			
		  return isNumber(e.which);
		});
});
	
</script>
        <table cellspacing="1" border="0" class="tbl-exch">
        <tbody>
            <tr class="title_tygia">
                <th width="50px">Mã NT</th>
                <th width="60px">Mua</th>
                <th width="60px">Bán</th>
            </tr>
<?php
    $index=0;
    foreach($Tygia as $item)
    {
        
?>
            <tr>
                <td class="code"><?php echo $item['CurrencyCode']?></td>
                <td class="number"><?php echo $this->string->numberFormate((double)$item['Buy'],2)?></td>
                <td class="number"><?php echo $this->string->numberFormate((double)$item['Sell'],2)?></td>
            </tr>

<?php
    }
?>
    
        </tbody>
        </table>
        <div class="ben-text-left ben-other">(Nguồn: vietcombank)</div>