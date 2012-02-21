<div>
    <div>
    
    	<form id="fromMessage" name="InsertContent"  action="" method="post" enctype="multipart/form-data">
        
    	<div class="ben-right">
            <input class="ben-button" type="button" value="Gửi" onclick="sendMessage()" />
            <a class="ben-button" href="index.php?route=addon/message">Quay về</a>
        </div>
        <div class="clearer">&nbsp;</div>
        
        
        <div id="container">
        	
            
			<!--<ul>
                <li><a href="#fragment-1"><span>Message</span></a></li>
            </ul>-->
           
            
            <div id="fragment-1">
            	<div id="error" class="ben-error" style="display:none"></div>
                <div style="<?php echo $displaynews?>">
        			
                    <div>
                        
                        <p>
                            <label>Tiêu đề</label><br>
                            
                            <input type="text" class="ben-textbox" name="title" size="60"/>
                        </p>
                    </div>
                    
                    <div>
                        
                        <div id="errorupload" class="error" style="display:none"></div>
                        
                        <div class="loadingimage" style="display:none"></div>
                        <p>
                        	<a id="btnAddAttachment" class="ben-button">Đính kèm file</a><br />
                        </p>
                        <p id="attachment">
                        </p>
                    	<div id="errorupload" class="error" style="display:none"></div>
                    
                    	<div class="loadingimage" style="display:none"><img src="<?php echo HTTP_SERVER.DIR_IMAGE?>loadingimage.gif"></div>
                        <span id="delfile"></span>
                    </div>

                    <div class="clearer">&nbsp;</div>
                
                </div>
                
                <div>
                    <p>
                        <textarea name="description" id="description" cols="80" rows="10"></textarea>
                    </p>  
                </div>
                
            </div>
        </div>
        
        </form>
    
    </div>

</div>

<script src='<?php echo HTTP_SERVER.DIR_JS?>ajaxupload.js' type='text/javascript' language='javascript'> </script>
<script src="<?php echo HTTP_SERVER.DIR_JS?>jquery.tabs.pack.js" type="text/javascript"></script>

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
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	$.post(HTTP_SERVER+"?route=addon/compose/sendMessage", $("#fromMessage").serialize(),
		function(data){
			if(data == "true")
			{
				window.location = "<?php echo $this->document->createLink('message')?>";
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

<script src="<?php echo HTTP_SERVER.DIR_JS?>uploadattament.js" type="text/javascript"></script>