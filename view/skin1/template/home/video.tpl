<?php
	$media = $medias[0];
?>
    <div id="ben-player">
    	<embed id="player2" width="520" height="360" wmode="transparent" flashvars="file=<?php echo HTTP_SERVER.DIR_FILE.$media['filepath']?>&image=<?php echo $media['imagethumbnail']?>&provider=video" allowfullscreen="true" allowscriptaccess="always" src="<?php echo HTTP_SERVER.DIR_COMPONENT?>player/mediaplayer.swf" name="player2" type="application/x-shockwave-flash">
       
        <div class="ben-right ben-viewmore">
        	<a href="<?php echo $this->document->createLink('video')?>">Xem thêm>></a>
        </div>
        
    </div>
    <div class="clearer">&nbsp;</div>