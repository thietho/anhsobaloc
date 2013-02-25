new AjaxUpload(jQuery('#btnAddFile'), {
	action: DIR_UPLOADATTACHMENT,
	name: 'image2',
	responseType: 'json',
	onChange: function(file, ext){
	},
	onSubmit: function(file, ext){
		// Allow only images. You should add security check on the server-side.
		/*if (ext && /^(flv|avi|mpg|mp4)$/i.test(ext)) {                            
			$('#pnVideo').hide();
			$('.loadingimage').show();
		} else {
			alert('Your selection is not video');
			return false;
		}       */                     
	},
	onComplete: function(file, response){
		//alert(response);
		if(response.files.error == 'none')
		{
			
			$('input#fileid').val(response.files.imageid);
			$('input#filepath').val(response.files.imagepath);
			$('#filename').html(response.files.imagename);
			
			$('#errorupload').hide();
			
		}
		else
		{
			$('#errorupload').html(response.files.error);
			$('#errorupload').show();
		}
		$('#pnVideo').show();
		$('.loadingimage').hide();
		
	}
});

