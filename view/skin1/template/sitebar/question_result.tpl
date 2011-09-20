<div class="ben-section">

	<div class="ben-section-title">Kết quả thăm do</div>
    
    <div class="ben-section-content">
    
    	
        <p>
        	<?php echo $media['title']?>
        </p>
        	<p>
            <table>
        	<?php foreach($media['answers'] as $answer){ ?>
            	
                	<tr>
                    	<td>
                        	<?php echo $answer['title']?>
                        </td>
                        <td>
                        	<div class="ben-answer" style="width:<?php echo $answer['mark']*100/$media['total']?>px">&nbsp;</div>
                        </td>
                        <td>
                        	<?php echo $answer['mark']?>(<?php echo $this->string->numberFormate($answer['mark']*100/$media['total'],2)?>%)
                        </td>
                    </tr>
                
                
            <?php } ?>
            </table>
            </p>
        
    	<p>
        	<input type="button" class="ben-button"  value="Đóng" onClick="closePopup()"/>
        </p>
    
    </div>

</div>