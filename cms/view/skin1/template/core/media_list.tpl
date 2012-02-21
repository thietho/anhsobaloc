<script src='<?php echo DIR_JS?>ui.datepicker.js' type='text/javascript' language='javascript'> </script>
<div class="section">

	<div class="section-title">Quãn lý bài viết</div>
    
    <div class="section-content">
    	
        <form action="" method="post" id="listitem" name="listitem">
        	<div id="ben-search">
            	<label>Từ khóa</label>
                <input type="text" id="keyword" name="keyword" class="text" value="" />
                <label>Loại</label>
                <select id="type" name="type">
                    <option value=""></option>
                    <?php foreach($module as $key => $val){ ?>
                    <option value="<?php echo $key?>"><?php echo $val?></option>
                    <?php } ?>
                </select>
                <label>Danh mục</label>
                <select id="sitemapid" name="sitemapid">
                    <option value=""></option>
                    
                </select>
                <label>Tác giả</label>
                <select id="userid" name="userid">
                    <option value=""></option>
                    <?php foreach($users as $key => $val){ ?>
                    <option value="<?php echo $val['userid']?>"><?php echo $val['fullname']?></option>
                    <?php } ?>
                </select>
                <br />
                <label>Từ ngày</label>
                <script language="javascript">
					$(function() {
						$("#tungay").datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'dd-mm-yy'
								});
						});
				 </script>
                <input id="tungay" name="tungay" type="text" class="text" />
                <label>Đến ngày</label>
                <script language="javascript">
					$(function() {
						$("#denngay").datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'dd-mm-yy'
								});
						});
				 </script>
                <input id="denngay" name="denngay" type="text" class="text" />
               
                <br />
                <input type="button" class="button" name="btnSearch" value="Tìm" onclick="searchForm()"/>
                <input type="button" class="button" name="btnSearch" value="Xem tất cả" onclick="window.location = '?route=core/media'"/>
            </div>
        	<div class="button right">
               
            	<input class="button" type="button" name="delete_all" value="Delete" onclick="deleteItem()"/>  
            </div>
            <div class="clearer">^&nbsp;</div>
            
            <div class="sitemap treeindex">
                <table class="data-table" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr class="tr-head">
                        <th width="1%"><input class="inputchk" type="checkbox" onclick="$('input[name*=\'delete\']').attr('checked', this.checked);"></th>
                        
                        <th>Tiêu đề</th>
                        <th>Tắt giả</th>
                        <th>Loại</th>
                        <th>Danh muc</th>
                        <th>Ngày</th>
                        <th>Hình</th>                 
                        <th>Control</th>                                  
                    </tr>
        
        
        <?php
            foreach($medias as $item)
            {
        ?>
                    <tr>
                        <td class="check-column"><input class="inputchk" type="checkbox" name="delete[<?php echo $item['mediaid']?>]" value="<?php echo $item['mediaid']?>" ></td>
                        
                        <td><?php echo $item['title']?></td>
                        <td><?php echo $item['fullname']?></td>
                        <td><?php echo $item['typename']?></td>
                		<td><?php echo $item['sitemapnames']?></td>
                        <td><?php echo $this->date->formatMySQLDate($item['statusdate'],'longdate')?></td>
                        <td><?php echo $item['imagepreview']?></td>
                        <td class="link-control">
                            <a class="button" href="<?php echo $item['link_edit']?>" title="<?php echo $item['text_edit']?>"><?php echo $item['text_edit']?></a>
                            <?php echo $item['btnMap']?>
                        </td>
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

function deleteItem()
{
	var answer = confirm("Bạn có muốn xóa không?")
	if (answer)
	{
		$.post("?route=core/media/delete", 
				$("#listitem").serialize(), 
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

function selectSiteMap(mediaid,moduleid)
{
	$('#popup-content').load('?route=core/media/mapmoduleform&mediaid='+mediaid+'&moduleid='+moduleid,
			function()
			{
				
				showPopup('#popup', 700, 500, true );
				//numberReady();
			});		
}

function searchForm()
{
	var url =  "?route=core/media";
	
	
	if($("#keyword").val() != "")
		url += "&keyword="+ $("#keyword").val();
	if($("#type").val() != "")
		url += "&type=" + $("#type").val();
	if($("#sitemapid").val() != "")
		url += "&sitemapid=" + $("#sitemapid").val();
	if($("#userid").val() != "")
		url += "&userid=" + $("#userid").val();
	if($("#tungay").val() != "")
		url += "&tungay=" + $("#tungay").val();
	if($("#denngay").val() != "")
		url += "&denngay=" + $("#denngay").val();
	if("<?php echo $_GET['opendialog']?>" == "true")
	{
		url += "&opendialog=true";
	}
	
	window.location = url;
}




$('#type').change(function(e) {
    $.getJSON("?route=core/media/getListSiteMap&module="+this.value, 
	function(data) 
	{
		$('#sitemapid').val('<option value=""></option>');
		for(i in data.sitemaps)
		{
			
			var str = '<option value="'+data.sitemaps[i].sitemapid+'">'+data.sitemaps[i].sitemapname+'</option>';
			
			$('#sitemapid').append(str);
		}
		$("#sitemapid").val("<?php echo $_GET['sitemapid']?>");
	});
});
$("#keyword").val("<?php echo $_GET['keyword']?>");
$("#type").val("<?php echo $_GET['type']?>");
$("#userid").val("<?php echo $_GET['userid']?>");
$("#tungay").val("<?php echo $_GET['tungay']?>");
$("#denngay").val("<?php echo $_GET['denngay']?>");
$(document).ready(function(e) {
    $('#type').change();
	
});
</script>