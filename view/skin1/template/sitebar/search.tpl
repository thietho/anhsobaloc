<div class="ben-section">

	<div class="ben-section-title">Tìm kiếm</div>
    
    <div class="ben-section-content">
    	<input type="text" class="ben-textbox" id="txt_search" name="txt_search" value="<?php echo $_GET['keyword']?>">
        <input type="button" class="ben-button" id="btnSearch" value="Tìm">
    </div>
</div>
<script language="javascript">
$("#btnSearch").click(function(){
	var keyword = trim($("#txt_search").val()," ");
	if(keyword!="")
		window.location = HTTP_SERVER+"search/keyword/"+keyword+".html";							   
});
</script>