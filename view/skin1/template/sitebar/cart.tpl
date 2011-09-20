<div class="ben-section">

	<div class="ben-section-title">Giỏ hàng</div>
    
    <div id="sitebarcartlist" class="ben-section-content">
    	
    	
    	
    </div>
    <div class="ben-section-content">
		<a href="<?php echo HTTP_SERVER?>site/<?php echo $this->member->getSiteId()?>/cart">Xem giỏ hàng</a>
    </div>
</div>
<script language="javascript">
$(document).ready(function() {
	$("#sitebarcartlist").load(HTTP_SERVER+"?route=sitebar/cart/getList");
});
</script>