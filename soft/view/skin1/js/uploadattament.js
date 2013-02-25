// JavaScript Document
var imageindex = 0;
new AjaxUpload(jQuery('#btnAddAttachment'), {
	action: DIR_UPLOADATTACHMENT,
	name: 'image2[]',
	responseType: 'json',
	
	onChange: function(file, ext){
	},
	onSubmit: function(file, ext){
		$('.loadingimage').show();
		// Allow only images. You should add security check on the server-side.
		/*if (ext && /^(jpg|png|jpeg|gif)$/i.test(ext)) {                            
			$('#pnImage').hide();
			$('.loadingimage').show();
		} else {
			alert('Your selection is not image');
			return false;
		}        */                    
	},
	onComplete: function(file, response){
		//alert(response);
		for(i in response.files)
		{
			if(response.files[i].error == 'none')
			{
				$('#attachment').append(creatAttachmentRow(response.files[i].imageid,response.files[i].imagename,response.files[i].imagethumbnail));
				//$('input#attimageid'+imageindex).val(response.files.imageid);
				//$('#attachment').append()
				/*$('input#imagepath').val(response.files.imagepath);
				$('input#imagethumbnail').val(response.files.imagethumbnail);
				$('#preview').attr("src", response.files.imagethumbnail);
				$('#errorupload').hide();*/
				
				
			}
			else
			{
				$('#errorupload').html(response.files.error);
				$('#errorupload').show();
			}
			
		}
		$('#pnImage').show();
		$('.loadingimage').hide();
		
	}
});

function removeAttachmentRow(index)
{
	//alert($("#attimageid"+index).val())
	$("#delfile").append('<input type="hidden" id="attimageid'+imageindex+'" name="delfile['+index+']" value="'+$("#attimageid"+index).val()+'" />');
	$("#attrows"+index).html("")
	
}

function creatAttachmentRow(iid,path,thums)
{
	row = '<div id="attrows'+imageindex+'"><img src="'+thums+'" /><input type="hidden" id="attimageid'+imageindex+'" name="attimageid['+imageindex+']" value="'+iid+'" />'+path+' <a id="removerow'+imageindex+'" onclick="removeAttachmentRow('+imageindex+')" class="button" >Remove</a></div>';
	imageindex++;
	return row;
}

function creatAttachmentRowView(iid,name,path,thums)
{
	row = '<div id="attrows'+imageindex+'"><img src="'+thums+'" /><input type="hidden" id="attimageid'+imageindex+'" name="attimageid['+imageindex+']" value="'+iid+'" />'+'<a href="'+path+'" target="_blank">'+name+'</a>';
	imageindex++;
	return row;
}