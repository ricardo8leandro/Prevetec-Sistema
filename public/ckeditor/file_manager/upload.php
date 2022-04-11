<?php 


$http = 'https://';

if($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off"){
    $http = 'https://';
}

$dir_base = $http.$_SERVER['HTTP_HOST'];

if(isset($_FILES['upload'])){
  	
    $file = $_FILES['upload']['tmp_name']; 
    $file_name = $_FILES['upload']['name'];
    $file_name_array = explode('.',$file_name);
    $extension = end($file_name_array);
    $new_image_name = md5(date('U')).'.'.$extension;
    
    chmod($_SERVER['DOCUMENT_ROOT'].'/public/ckeditor/uploads',0777);

    $allowed_extension = array('jpg','gif','png');

    if(in_array($extension,$allowed_extension)){
    	move_uploaded_file($file, $_SERVER['DOCUMENT_ROOT'].'/public/ckeditor/uploads/'.$new_image_name);
    	$url = $dir_base.'/public/ckeditor/uploads/'.$new_image_name;
    	$message  = '';

    	$json = [
    		'uploaded' 	=> 1,
    		'fileName' 	=> $new_image_name,
    		'url' 		=> $url
    	];

    	
    }else{
		$json = [
    		'uploaded' 	=> 1,
    		'fileName' 	=> '',
    		'url' 		=> '',
    		'error'		=> array(
    			'message'	=> 'Extensão Inválida!'
    		)
    	];    	
    }

    echo json_encode($json);
}