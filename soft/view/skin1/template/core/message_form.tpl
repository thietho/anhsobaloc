<div class="section">

	<div class="section-title">
    	<?php echo $heading_send_title?>
    </div>
    
    <div class="section-content padding1">
    
    	<form id="fromMessage" name="InsertContent"  action="" method="post" enctype="multipart/form-data">
        
    	<div class="right">
            <input class="button" type="button" value="<?php echo $button_send?>" onclick="sendMessage()" />
            <a class="button" href="index.php?route=core/message"><?php echo $button_cancel?></a>
        </div>
        <div class="clearer">&nbsp;</div>
        
        
        <div id="container">
        	
            
			<!--<ul>
                <li><a href="#fragment-1"><span>Message</span></a></li>
            </ul>-->
           
            
            <div id="fragment-1">
            	<div id="error" class="error" style="display:none"></div>
                <div style="<?php echo $displaynews?>">
        			
                    <div>
                        <p>
                            <label onclick="openDialog('?route=core/message/findContact',300,500)"><?php echo $entry_to?></label><br>
                            <input class="text" type="text" name="to" value='<?php echo $message['from']?>' size="100%" />
                        </p>
                        <p>
                            <label><?php echo $entry_subject?></label><br>
                            <textarea class="text" rows="3" cols="70" name="title"><?php echo $title?></textarea>
                        </p>
                    </div>
                    
                    <div>
                        
                        <div id="errorupload" class="error" style="display:none"></div>
                        
                        <div class="loadingimage" style="display:none"></div>
                        <p>
                        	<a id="btnAddAttachment" class="button"><?php echo $button_attachment?></a><br />
                        </p>
                        <p id="attachment">
                        </p>
                    	
                        <span id="delfile"></span>
                    </div>

                    <div class="clearer">&nbsp;</div>
                
                </div>
                
                <div>
                    <p>
                        <textarea name="description" id="description" cols="80" rows="10"><?php echo $description?></textarea>
                    </p>  
                </div>
                
            </div>
        </div>
        
        </form>
    
    </div>

</div>

<script src='<?php echo DIR_JS?>ajaxupload.js' type='text/javascript' language='javascript'> </script>
<script src="<?php echo DIR_JS?>jquery.tabs.pack.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8">
var DIR_UPLOADATTACHMENT = "<?php echo $DIR_UPLOADATTACHMENT?>";
$(document).ready(function() { 
	setCKEditorType('description',2);
	$('#container').tabs({ fxSlide: true, fxFade: true, fxSpeed: 'slow' });
});

function sendMessage()
{
	var oEditor = CKEDITOR.instances['description'] ;
	var pageValue = oEditor.getData();
	$('textarea#description').val(pageValue);
	$.blockUI({ message: "<h1>Đang xử lý...</h1>" }); 
	$.post("?route=core/message/sendMessage", $("#fromMessage").serialize(),
		function(data){
			if(data == "true")
			{
				window.location = "?route=core/message";
			}
			else
			{
				$('#error').html(data).show('slow');
				$.unblockUI()
			}
			
		}
	);
}
</script>

<script src="<?php echo DIR_JS?>uploadattament.js" type="text/javascript"></script>