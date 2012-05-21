<?php echo $pager?>
<?php foreach($files as $file){ ?>
<div class="filelist left text-center" id="image<?php echo $file['fileid']?>" ondblclick="selectFile('<?php echo $file['fileid']?>')">
	<img src="<?php echo $file['imagethumbnail']?>" />
	<p class="filename"><?php echo $file['filename']?></p>
    <?php if($_GET['edit']=='true'){ ?>
    <p><input type="checkbox" class="chkfile" name="chkfile" value="<?php echo $file['fileid']?>"></p>
    <?php } ?>
</div>
<?php } ?>

<div class="clearer">^&nbsp;</div>

<script language="javascript">
$(document).ready(function(e) {
    $('.chkfile').each(function(index, element) {
        if(arrfileid.indexOf(this.value)!=-1)
		{
			this.checked = true;
		}
    });
});
$('.chkfile').click(function(e) {
	if(this.checked == true)
	{
		arrfileid.push(this.value);
		
	}
	else
	{
		var pos = arrfileid.indexOf(this.value);
		if(pos > -1)
		{
			arrfileid.splice(pos,1);	
		}
		
	}
});	
$('.filelist').hover(
	function(){
		$(this).css('background-color','#ccc');
		$(this).children('.filename').css('overflow','visible');
	},
	function(){
		$(this).css('background-color','transparent');
		$(this).children('.filename').css('overflow','hidden');
	});
</script>