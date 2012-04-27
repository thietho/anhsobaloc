<style>
#ben-banner
{
	margin-bottom:10px;	
}
#ben-banner-show
{
	height:300px;
	overflow:hidden;	
}
#ben-banner-icon
{
	position:absolute;
	width:990px;	
	z-index:100;
	margin-top:-25px;
}
</style>
<div id="ben-banner">
	<div id="ben-banner-show">  
    </div>
    <div id="ben-banner-icon" class="ben-right">
        <div class="ben-right">
        <?php foreach($medias as $key => $media) {?>
        <img class="ben-banner-icon" id="icon-<?php echo $key?>" src="<?php echo HTTP_SERVER.DIR_IMAGE?>banner/icon.png" />
        <?php } ?>
        </div>
    </div>
    
    
</div>
        
<div style="display:none">
<?php foreach($medias as $key => $media) {?>
	<div id="img-<?php echo $key?>">
    	<!--<img src="<?php echo HTTP_IMAGE.$media['imagepath']?>">-->
        <img src="<?php echo $media['imagethumbnail'] ?>" />
    </div>                     
<?php }?>
</div>                

<script language="javascript">
function BannerShow(count)
{
	this.count = count
	this.index = 0;
	
	this.show = function(pos)
	{
		$(".ben-banner-icon").attr("src","<?php echo HTTP_SERVER.DIR_IMAGE?>banner/icon.png");
		$("#icon-"+pos).attr("src","<?php echo HTTP_SERVER.DIR_IMAGE?>banner/icon_cur.png");
		$("#ben-banner-show").fadeOut(1000,function(){
				
				$("#ben-banner-show").html($("#img-"+pos).html());
				$("#ben-banner-show").fadeIn(1000,function(){
					$("#ben-banner-show").css('opacity',1);	
				});	
				
			});
		
		
	}
	
	this.run = function()
	{
		
		if(this.index>=this.count)
		{
			this.index=0;
			
		}
		this.show(this.index);
		this.index++;
		if(this.count > 1)
			timer = setTimeout("bs.run()",5000);
		
	}
}

$(".ben-banner-icon").click(function(){
	arr = this.id.split('-');
	key = arr[1];
	bs.index = key;
	clearTimeout(timer);
	
	bs.run();
});
var timer;
var bs = new BannerShow('<?php echo count($medias)?>');
bs.run();
</script>