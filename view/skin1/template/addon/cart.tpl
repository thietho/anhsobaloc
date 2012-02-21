<style>
.ben-cart
{
	border:thin solid #CCC;	
	padding:5px;
}
</style>
<div id="addoncartlist" class="ben-post">

</div>
<div align="center">
	<input type="button" class="ben-button" value="Tiếp tục mua hàng" onclick="window.location='<?php echo HTTP_SERVER?>'"/>
    <input type="button" class="ben-button" value="Thanh toán" onclick="window.location='<?php echo $this->document->createLink('checkout')?>'"/>
</div>
<script language="javascript">
$(document).ready(function() {
	$("#addoncartlist").load(HTTP_SERVER+"?route=addon/cart/getList");
});
</script>