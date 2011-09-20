<div class="ben-post">
    <h2><?php echo $post['title']?></h2>
    <div class="ben-post-date"><?php echo $post['statusdate']?></div>
    <div class="ben-post-body">
        <p><b><?php echo $post['summary']?></b></p>
    </div>
    <div class="clearer">&nbsp;</div>
</div>
<div id="ben-player">
    <embed id="player2" width="520" height="360" wmode="transparent" flashvars="file=<?php echo HTTP_SERVER.DIR_FILE.$post['filepath']?>&image=<?php echo $post['imagethumbnail']?>&provider=video" allowfullscreen="true" allowscriptaccess="always" src="<?php echo HTTP_SERVER.DIR_COMPONENT?>player/mediaplayer.swf" name="player2" type="application/x-shockwave-flash">    
</div>
<div class="ben-hline"></div>
<p>
    <?php echo $post['description']?>
</p>
<p class="ben-text-right">
	<b><?php echo $post['source']?></b>
</p>
<div class="ben-hline"></div>

<?php if($othernews) {?>
<h3>Các tin khác</h3>             
<div>
    <ul>
    	<?php foreach($othernews as $media) {?>
        <li><a href="<?php echo $media['link']?>"><?php echo $media['title']?>&nbsp;<span class="ben-other">(<?php echo $media['statusdate']?>)</span></a></li>
        <?php } ?>    
    </ul>
</div>
<?php } ?>

<div class="clearer">&nbsp;</div>