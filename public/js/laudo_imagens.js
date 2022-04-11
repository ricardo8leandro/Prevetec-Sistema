$(document).on('click','.btnAddImage',function(e){

	let nr = e.target.value;

	if(typeof nrAnexosPorDiv[nr] !== 'undefined'){
		nrAnexosPorDiv[nr] = eval(nrAnexosPorDiv[nr] + 1);
	}else{
		nrAnexosPorDiv[nr] = 1;
	}

	id_image = nrAnexosPorDiv[nr];

	let code = nr+'_'+id_image;

	/* inputs de texto header e footer */
	
	$.ajax({
		url: PAINEL + 'laudo/estrutura-anexo',
		method: 'post',
		dataType: 'html',
		data: {'code': code},
		success: function(data){
			$('#anexos_'+nr).append(data);
		},
		error: function(data){
			console.log(data);
		}
	});
});

$(document).on('change','.inpt_anexo', function(){
	imagePreview(this);
});

$(document).on('click','.btnAnexoFile',function(){
	let input_id = $(this).attr('value');
	console.log(input_id);
	$('#anexo_'+input_id).trigger('click');
});

$(document).on('click','.btnRemoveAnexo',function(){
	let div_id = $(this).attr('value');
	let id_anexo = $('#id_anexo_'+div_id).val();

	if(id_anexo != ''){
		$.ajax({
			url: PAINEL + 'laudo/remove-laudo-item-anexo/'+id_anexo,
			method: 'post',
			dataType: 'html',
			success: function(data){
				console.log('ok');
				console.log(data);
			},
			error: function(data){
				console.log(data);
			}
		});
	}

	$('#div_'+div_id).remove();
});

function imagePreview(input){
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		let name = input.name;
		console.log(name);
		
		reader.onload = function (e) {
		    $('#img_'+name).attr('src',e.target.result);
		};

		reader.readAsDataURL(input.files[0]);

		var file = input.files[0];

	    if (file) {
	      orientation(file, function(base64img, value) {
	        var rotated = $('#img_'+name).attr('src', base64img);
	        if (value) {
	          rotated.css('transform', rotation[value]);
	          rotated.css('height','');
	          rotated.css('width','200px');
	        }
	      });
	    }

		$('#btn_remove_'+name).css('display','block');
	}
}


// Exif orientation value to css transform mapping
// Does not include flipped orientations
var rotation = {
  1: 'rotate(0deg)',
  3: 'rotate(180deg)',
  6: 'rotate(90deg)',
  8: 'rotate(270deg)'
};

function _arrayBufferToBase64(buffer) {
  var binary = ''
  var bytes = new Uint8Array(buffer)
  var len = bytes.byteLength;
  for (var i = 0; i < len; i++) {
    binary += String.fromCharCode(bytes[i])
  }
  return window.btoa(binary);
}
var orientation = function(file, callback) {
  var fileReader = new FileReader();
  fileReader.onloadend = function() {
    var base64img = "data:" + file.type + ";base64," + _arrayBufferToBase64(fileReader.result);
    var scanner = new DataView(fileReader.result);
    var idx = 0;
    var value = 1; // Non-rotated is the default
    if (fileReader.result.length < 2 || scanner.getUint16(idx) != 0xFFD8) {
      // Not a JPEG
      if (callback) {
        callback(base64img, value);
      }
      return;
    }
    idx += 2;
    var maxBytes = scanner.byteLength;
    while (idx < maxBytes - 2) {
      var uint16 = scanner.getUint16(idx);
      idx += 2;
      switch (uint16) {
        case 0xFFE1: // Start of EXIF
          var exifLength = scanner.getUint16(idx);
          maxBytes = exifLength - idx;
          idx += 2;
          break;
        case 0x0112: // Orientation tag
          // Read the value, its 6 bytes further out
          // See page 102 at the following URL
          // http://www.kodak.com/global/plugins/acrobat/en/service/digCam/exifStandard2.pdf
          value = scanner.getUint16(idx + 6, false);
          maxBytes = 0; // Stop scanning
          break;
      }
    }
    if (callback) {
      callback(base64img, value);
    }
  }
  fileReader.readAsArrayBuffer(file);
};