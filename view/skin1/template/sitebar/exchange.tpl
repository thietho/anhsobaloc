<style>
#container td
{
	border:thin solid;
	padding:2px;
	text-align:right;
}
#container th
{
	border:thin solid;
	padding:2px;
}
</style>
</style>
<div class="ben-section">

	<div class="ben-section-title">Thông tin cần biết</div>
    
    <div class="ben-section-content">
    	 <div id="container">
            <ul class="tabs-nav">
                <li class="tabs-selected"><a href="#fragment-tigia"><span>Tỉ giá</span></a></li>
                <li class="tabs"><a href="#fragment-giavang"><span>Giá vàng</span></a></li>
            </ul>
            <div id="fragment-tigia" class="tabs-container">
            	<?php echo $tygia?>
            </div>
            <div id="fragment-giavang" class="tabs-container">
            	<?php echo $giavang?>
            </div>
         </div>
    	
    	
    </div>

</div>
<script language="javascript">
$(document).ready(function() {
	$('#container').tabs({ fxSlide: true, fxFade: true, fxSpeed: 'slow' });
});
</script>