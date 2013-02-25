<div>
<form id="frmmap">
	<input type="hidden" name="mediaid" value="<?php echo $mediaid?>">
	<p>
    	<label>Module</label>
        <select id="mapmodule">
        	<option value="">Chọn module</option>
            <?php foreach($modules as $key => $val){ ?>
            <option value="<?php echo $key?>"><?php echo $val?></option>
            <?php } ?>
        </select>
    </p>
    <p>
    	<label>Danh mục</label>
        <div id="listsitemap">
        	
        </div>
    </p>
    
    <input type="button" class="button" value="Lưu" onClick="save()">
</form>
</div>
<script language="javascript">
var listsitemapid = new Array();

<?php 
foreach($listsitemapid as $val)
{ 
	echo "listsitemapid.push('".$val."');";
}
?>

$('#mapmodule').change(function(e) {
	$('#listsitemap').html('');
    $.getJSON("?route=core/media/getListSiteMap&module="+this.value, 
	function(data) 
	{
		for(i in data.sitemaps)
		{
			var chk = "";
			if(listsitemapid.indexOf(data.sitemaps[i].sitemapid)!= -1)
				chk = 'checked="checked"';
			var str = '<input type="checkbox" name="sitemaplist['+data.sitemaps[i].sitemapid+']" value="'+data.sitemaps[i].sitemapid+'" '+ chk +'> ';
			str += data.sitemaps[i].sitemapname
			$('#listsitemap').append('<div class="left map-sitemap-item">'+str+'</div>');
		}
		$('#listsitemap').append('<div class="clearer">^&nbsp;</div>');
	});
});
$(document).ready(function(e) {
    $('#mapmodule').val('<?php echo $moduleid?>');
	$('#mapmodule').change();
});
function save()
{
	$.post("?route=core/media/savemap", $("#frmmap").serialize(),
		function(data){
			if(data == "true")
			{
				window.location.reload();
			}
			
			
		}
	);
}
</script>