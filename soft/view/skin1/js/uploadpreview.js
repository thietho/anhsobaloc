new AjaxUpload(jQuery('#btnAddImage'), {
	action: DIR_UPLOADPHOTO,
	name: 'image2',
	responseType: 'json',
	onChange: function(file, ext){
	},
	onSubmit: function(file, ext){
		
		// Allow only images. You should add security check on the server-side.
		if (ext && /^(jpg|png|jpeg|gif)$/i.test(ext)) {                            
			$('#pnImage').hide();
			$('.loadingimage').show();
		} else {
			alert('Your selection is not image');
			return false;
		}                            
	},
	onComplete: function(file, response){
		
		if(response.files.error == 'none')
		{
			$('input#imageid').val(response.files.imageid);
			$('input#imagepath').val(response.files.imagepath);
			$('input#imagethumbnail').val(response.files.imagethumbnail);
			$('#preview').attr("src", response.files.imagethumbnail);
			$('#errorupload').hide();
			
		}
		else
		{
			$('#errorupload').html(response.files.error);
			$('#errorupload').show();
		}
		$('#pnImage').show();
		$('.loadingimage').hide();
		
	}
});

