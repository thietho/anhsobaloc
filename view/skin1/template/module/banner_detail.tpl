<div class="ben-post">
	<?php if($post['imagethumbnail'] !=""){ ?>
	<img src='<?php echo $post['imagethumbnail']?>' class='ben-alignleft' />
	<?php }?>
    <h2><?php echo $post['title']?></h2>
    <div class="ben-post-date"><?php echo $post['statusdate']?></div>
    <div class="ben-post-body">
        <p><b><?php echo $post['summary']?></b></p>
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



<div class="clearer">&nbsp;</div>