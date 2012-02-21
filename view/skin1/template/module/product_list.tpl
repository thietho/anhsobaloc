<div class="ben-product-list">
    <?php
    if(count($medias))
    {
    ?>
    	<?php if($sorting){ ?>
   	<div class="ben-post">
        <select id="order" class="ben-textbox ben-right" onchange="window.location = '?order='+this.value">
            <option value="new">Mới</option>
            <option value="gt">Giá tăng dần</option>
            <option value="gg">Giá giảm dần</option>
            <option value="az">Tên: A-Z</option>
        </select>
<script language="javascript">
$('#order').val('<?php echo $_GET["order"]?>');
</script>
        <div class="clearer">&nbsp;</div>
        
    </div>
    	<?php } ?>
        <?php if($paging){ ?>
    <?php echo $pager?>
    <div class="clearer">&nbsp;</div>
    <?php } ?>
    <div id="listpoduct">
        <?php foreach($medias as $media) {?>
        <div  class="ben-left product">
            <table>
                <tr>
                    <td>
                        <?php if(in_array("sanphamhot",$media['properties'])){ ?>
                        <div id="ben-icon-hot" class="ben-icon">
                            <img src="<?php echo HTTP_SERVER.DIR_IMAGE?>icon/ico-hot.png" />
                        </div>
                        <?php } ?>
                        <?php if(in_array("sanphamkhuyenmai",$media['properties'])){ ?>
                        <div id="ben-icon-sale" class="ben-icon">
                            <img src="<?php echo HTTP_SERVER.DIR_IMAGE?>icon/ico-sale.png" />
                        </div>
                        <?php } ?>
                        <?php if(in_array("sanphammoi",$media['properties'])){ ?>
                        <div id="ben-icon-new" class="ben-icon">
                            <img src="<?php echo HTTP_SERVER.DIR_IMAGE?>icon/ico-new.png" />
                        </div>
                        <?php } ?>
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
                            <a href="<?php echo $media['link']?>">Chi tiết</a><!-- || <a onclick="cart.add('<?php echo $media['mediaid']?>')">Đặt hàng</a>-->
                        </div>
                    </td>
                </tr>
            </table>
            
            
            
            
        </div>
        <?php } ?>
        <div class="clearer">&nbsp;</div>
    </div>
        
    
    
    <div class="clearer">&nbsp;</div>
    	<?php if($paging){ ?>
    <div class="ben-post">
    	<?php echo $pager?>
    </div>
    	<?php } ?>
    <div class="clearer">&nbsp;</div>
    <?php
    }
    ?>
</div>