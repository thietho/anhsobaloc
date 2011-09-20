<style>
.product-left
{
	width:200px;	
}
.product-right
{
	width:280px;	
}
.product-mainimage
{
	text-align:center;	
}
.product-subimage
{
	text-align:center;
	margin-top:5px;
}
</style>
<link rel='stylesheet' type='text/css' href='<?php echo HTTP_SERVER.DIR_VIEW?>css/product.css'>
<h2><?php echo $sitemap['breadcrumb']?></h2>
<div class="ben-post">
	<div class="ben-left product-left">
    	<?php if($post['imagethumbnail'] !=""){ ?>
        <div class="product-mainimage">
	        <img id="product-preview" src="<?php echo $post['imagethumbnail']?>"/>
        </div>
        
        <?php }?>
        <div class="product-subimage">
            <?php 
            if(count($subimage))
            foreach($subimage as $key => $val){ ?>
            <img id="icon-<?php echo $key?>" class="product-icon" src="<?php echo $val['imagethumbnail']?>" />
            <?php } ?>
        </div>
        <div style="display:none">
        	<?php foreach($subimage as $key => $val){ ?>
            <img id="preview-<?php echo $key?>" src="<?php echo $val['imagepreview']?>" />
            <?php } ?>
        </div>
    </div>
    <div class="ben-right product-right">
        <h2><?php echo $post['title']?></h2>
        
        <div class="ben-post-body">
            <p>
            	<b><?php echo $post['summary']?></b>
                
            </p>
        </div>
        <div class="ben-right"><?php echo $this->string->numberFormate($post[price])?> <?php echo $this->document->setup['Currency']?></div>
        <div class="clearer">&nbsp;</div>
        <div class="ben-right"><a onclick="cart.add('<?php echo $post['mediaid']?>')">Đặt hàng</a></div>
    </div>
    <div class="clearer">&nbsp;</div>
</div>
<div class="ben-hline"></div>
<p>
    <?php echo $post['description']?>
</p>

<p class="ben-text-right">
	<b><?php echo $post['source']?></b>
</p>
<?php if(count($child)){ ?>
<div id="subinfo">
        	
            
    <ul>
    	<?php foreach($child as $key => $item){ ?>
        	<li><a href="#fragment-<?php echo $key?>"><span><?php echo $item['title']?></span></a></li>	
        <?php } ?>
    </ul>
   
    <?php foreach($child as $key => $item){ ?>
    <div id="fragment-<?php echo $key?>">
    	<?php echo html_entity_decode($item['description'])?>
    </div>
    <?php } ?>
            
</div>
<?php } ?>
<div class="ben-hline"></div>

<?php if($othernews) {?>
<h3>Các sản phẩm khác</h3>             
<div>
    
    	<?php foreach($medias as $media) {?>
        <div>
        <table class="ben-left product">
            <tr>
                <td>
                    
                    <?php if($media['imagethumbnail'] !=""){ ?>
                    <a class="islink" href="<?php echo $media['link']?>"><img src='<?php echo $media['imagethumbnail']?>' class='ben-center' /></a>
                    <?php }?>
                    
                </td>
            </tr>
            <tr>
                <td>
                    <div align="center"><a href="<?php echo $media['link']?>"><h6><?php echo $media['title']?></h6></a></div>
                    <div align="center"><?php echo $this->string->numberFormate($media['price'])?> <?php echo $this->document->setup['Currency']?></div>
                    <div align="center">
                        <a href="<?php echo $media['link']?>">Chi tiết</a> || <a onclick="cart.add('<?php echo $media['mediaid']?>')">Đặt hàng</a>
                    </div>
                </td>
            </tr>
        </table>
        
        
        
        
    </div>
        <?php } ?>    
    
</div>
<?php } ?>

<div class="clearer">&nbsp;</div>

<script language="javascript">
$(".product-icon").click(function(){
	var arr = this.id.split("-");
	var key = arr[1];
	$("#product-preview").attr("src",$("#preview-"+key).attr("src"));
});


$(document).ready(function() { 
	$('#subinfo').tabs({ fxSlide: true, fxFade: true, fxSpeed: 'slow' });
	
});
</script>