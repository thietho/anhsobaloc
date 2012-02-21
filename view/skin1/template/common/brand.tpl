<script type='text/javascript' language='javascript' src='<?php echo HTTP_SERVER.DIR_VIEW?>js/crawler.js'></script>
<div class="marquee" id="mycrawler2">
<?php foreach($nhanhieu as $item){ ?>
	<?php if($item['imagethumbnail']){ ?>
    <a href="<?php echo $this->document->createLink('brand',$item['categoryid'])?>">
		<img src="<?php echo $item['imagethumbnail']?>" />
    </a>
	<?php } ?>
<?php } ?>
</div>

<script type="text/javascript">
marqueeInit({
	uniqueid: 'mycrawler2',
	style: {
		'padding': '2px',
		'background': '#FFF',
		'height': '50px'
	},
	inc: 5, //speed - pixel increment for each iteration of this marquee's movement
	mouse: 'cursor driven', //mouseover behavior ('pause' 'cursor driven' or false)
	moveatleast: 2,
	neutral: 150,
	savedirection: true,
	random: true
});
</script>