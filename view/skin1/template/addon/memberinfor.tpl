<script src='<?php echo HTTP_SERVER.DIR_JS?>ui.datepicker.js' type='text/javascript' language='javascript'> </script>
<style>
.text
{
	cursor:pointer;
}

.date
{
	cursor:pointer;
}
</style>
<div class="ben-post">
	<form id="frmRegister" method="post">
    	<div id="error" class="ben-error" style="display:none"></div>
    	<table>
        	<tr>
            	<td><label>Tên đăng nhập</label></td>
                <td><?php echo $member['username']?></td>
            </tr>
            
            <tr>
            	<td><label>Họ và tên</label></td>
                <td id="fullname" class="text"><?php echo $member['fullname']?></td>
            </tr>
            <tr>
            	<td><label>Email</label></td>
                <td><?php echo $member['email']?></td>
            </tr>
            <tr>
            	<td><label>Địa chỉ</label></td>
                <td id="address" class="text"><?php echo $member['address']?></td>
            </tr>
            <tr>
            	<td><label>Điện thoại</label></td>
                <td id="phone" class="text"><?php echo $member['phone']?></td>
            </tr>
            <tr>
            	<td><label>Ngày sinh</label></td>
                <script language="javascript">
					$(function() {
						$("#birthday").datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'dd-mm-yy'
								});
						});
				 </script>
                <td id="birthday" class="date"><?php echo $this->date->formatMySQLDate($member['birthday'])?></td>
            </tr>
            <tr>
            	<td><label>Ảnh đại diện</label></td>
                <td>
                	<p id="pnImage">
                        
                        <input id="btnAddImage" type="button" class="ben-button" value="Select photo"><br />
                        <img id="preview" src="<?php echo $member['imagethumbnail']?>" />
                        <input type="hidden" id="imagepath" name="imagepath" value="<?php echo $member['imagepath']?>" />
                        <input type="hidden" id="imageid" name="imageid" value="<?php echo $member['imageid']?>" />
                        <input type="hidden" id="imagethumbnail" name="imagethumbnail" value="<?php echo $member['imagethumbnail']?>" />
                    </p>
                        
                        
                    <div id="errorupload" class="error" style="display:none"></div>
                    
                    <div class="loadingimage" style="display:none"><img src="<?php echo HTTP_SERVER.DIR_IMAGE?>loadingimage.gif"></div>
                </td>
            </tr>
            
        </table>
    </form>
</div>
<div class="clearer">&nbsp;</div>
<script src='<?php echo HTTP_SERVER.DIR_JS?>ajaxupload.js' type='text/javascript' language='javascript'> </script>
<script type="text/javascript" charset="utf-8">
var DIR_UPLOADPHOTO = "<?php echo $DIR_UPLOADPHOTO?>";
var isedit = true
function editText(eid)
{
	if(isedit)
	{
		var text = $("#"+eid).html();
		var html = '<input type="text" class="ben-textbox" id="text-'+eid+'" value="'+text+'">';
		html+=' <input id="btnSaveInfor" type="button" class="ben-button" value="Save" onclick="saveInfor(\''+eid+'\')">';
		
						
		$("#"+eid).html(html);
		$("#"+eid).unbind('click');
		
	}
	
}

$(".text").click(function(){
	
	 editText(this.id);

});

function editDate(eid)
{
	if(isedit)
	{
		var text = $("#"+eid).html();
		var html = '<input type="text" class="ben-textbox" id="text-'+eid+'" value="'+text+'">';
		html+=' <input id="btnSaveInfor" type="button" class="ben-button" value="Save" onclick="saveDate(\''+eid+'\')">';
		
		$("#"+eid).html(html);
		$("#text-"+eid).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-yy'
		});
		$("#"+eid).unbind('click');
		
	}
	
}
$(".date").click(function(){
	
	 editDate(this.id);

});
function saveInfor(eid)
{
	isedit = false;
	$.post("<?php echo HTTP_SERVER?>?route=addon/memberinfor/saveInfor", { userid: "<?php echo $member['username']?>", colname: eid , value: $("#text-"+eid).val()},
		function(data){
			if(data == "true")
			{
				
			}
			
		}
	);
	$("#"+eid).html($("#text-"+eid).val());
	$("#"+eid).bind('click', function() {
		 editText(this.id);
		 isedit = true;
	});
}
function saveDate(eid)
{
	isedit = false;
	$.post("<?php echo HTTP_SERVER?>?route=addon/memberinfor/saveDate", { userid: "<?php echo $member['username']?>", colname: eid , value: $("#text-"+eid).val()},
		function(data){
			if(data == "true")
			{
				
			}
			
		}
	);
	$("#"+eid).html($("#text-"+eid).val());
	$("#"+eid).bind('click', function() {
		 editDate(this.id);
		 isedit = true;
	});
}
function callbackfunc(objfile)
{
	$.post("<?php echo HTTP_SERVER?>?route=addon/memberinfor/saveAvatar", { userid: "<?php echo $member['username']?>", imageid: objfile.imageid , imagepath: objfile.imagepath},
		function(data){
			if(data == "true")
			{
				
			}
			
		}
	);
}
</script>

<script src="<?php echo HTTP_SERVER.DIR_JS?>uploadpreview.js" type="text/javascript"></script>
