<?php if(count($medias)){ ?>
	<link rel="stylesheet" type="text/css" href="<?php echo DIR_VIEW?>css/preview.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo DIR_VIEW?>css/wt-rotator.css"/>
	<script type="text/javascript" src="<?php echo DIR_VIEW?>js/jquery.wt-rotator.min.js"></script>
	<script type="text/javascript" src="<?php echo DIR_VIEW?>js/preview.js"></script>
    <div class="container">
        <div class="wt-rotator">
            <a href="#"></a>            
            <div class="desc"></div>
            <div class="preloader"></div>
            <div class="c-panel">
                <div class="buttons">
                    <div class="prev-btn"></div>
                    <div class="play-btn"></div>    
                    <div class="next-btn"></div>               
                </div>
                <div class="thumbnails">
                    <ul>
                    	<?php foreach($medias as $media) {?>
                        <li>
                            <a href="<?php echo $media['imagethumbnail']?>"></a>
                            
                            <?php if($media['title']!=""){?>
                            <div style="left:<?php echo rand(100,587)?>px; top:34px; width:306px;">
                               <span class="cap-title"><?php echo $media['title']?></span><br/>
                               <?php echo $media['summary']?>
                            </div>
                            <?php }?>                          
                        </li>
                        <?php }?>
                    </ul>
                </div>     
            </div>
        </div>	
  	</div>
<?php } ?>