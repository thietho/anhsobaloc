<table>
	<?php foreach($medias as $media) {?>
	<tr>
    	<td><img src="<?php echo $media['imagethumbnail']?>" class="ben-center"/></td>
    	<td><?php echo $media['title']?></td>
        <td class="number"><?php echo $this->string->numberFormate($media['qty'])?></td>
    </tr>
    <?php } ?>
</table>