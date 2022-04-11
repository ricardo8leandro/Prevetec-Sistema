$(document).on('click','.btn-remove',function(){
	var img = $(this).attr('value');

	$('input.remove').val(img);
	$('form.remove').trigger('submit');
});