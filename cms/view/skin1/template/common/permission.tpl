<script>
	$(document).ready(function() {	
		<?php foreach($hiddencontrols as $ctrl) {?>
			$('.<?php echo $ctrl?>').hide();
		<?php } ?>
	});
</script>