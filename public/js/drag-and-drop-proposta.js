$(document).on('click','.moveAreaUp',function(){
	var current = $(this).parent().parent();
  	current.prev().before(current);
});

$(document).on('click','.moveAreaDown',function(){
	var current = $(this).parent().parent();
  	current.next().after(current);	
});

$(document).on('click','.moveServicoUp',function(){
	var current = $(this).parent();
  	current.prev().before(current);
});

$(document).on('click','.moveServicoDown',function(){
	var current = $(this).parent();
  	current.next().after(current);	
});