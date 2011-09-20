<link rel='stylesheet' type='text/css' href='<?php echo HTTP_SERVER.DIR_VIEW?>css/product.css'>
<h2><?php echo $sitemap['breadcrumb']?></h2>
<h2><?php echo $sitemap['sitemapname']?></h2>
<!--<div class="ben-item-separator"></div>-->
<?php
if(count($medias))
{
?>
<div id="listpoduct">
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
    


<div class="clearer">&nbsp;</div>
<?php echo $pager?>
<?php
}
?>
