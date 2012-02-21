<div class=" ben-section-title">Nhận xét về <?php echo $post['title']?></div>
<div class="ben-post ben-comment">
    <?php foreach($comments as $key => $comment){ ?>
    <div class="ben-comment-item">
    	<?php echo $key+1?> <strong><?php echo $comment['fullname']?></strong> - gửi vào <?php echo $this->date->formatMySQLDate($comment['commentdate'],'longdate')?> - đánh giá: <img height="12px" src="<?php echo HTTP_SERVER.DIR_IMAGE?>comment/s<?php echo $comment['level']?>.gif"><br>
        <?php echo $comment['description']?>
    </div>
    <?php } ?>
</div>