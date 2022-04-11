<?php
header('Access-Control-Allow-Origin: *');
$total = count($_FILES['file']['name']);
$error_msg = "";
$imageUploadERROR = false;

for( $i=0 ; $i < $total ; $i++ ) {

  $tmpFilePath = $_FILES['file']['tmp_name'][$i];

  if ($tmpFilePath != ""){
    $newFilePath = "./uploads/" . $_FILES['file']['name'][$i];

    if(move_uploaded_file($tmpFilePath, $newFilePath) === FALSE){
      $error_msg .= "Erro ao enviar imagem nº ". ($i + 1) ." \n";
      $imageUploadERROR = true;
    }else{
      $error_msg .= "Imagem nº ". ($i + 1) ." enviada com sucesso\n";
    }
  } else{
    $error_msg .= "Erro ao enviar imagem nº ". ($i + 1) ." \n";
    $imageUploadERROR = true;
  }
}

if ($imageUploadERROR) {
  header('Content-type: application/json');
  $data = ['success' => FALSE, 'message' => $error_msg];
  echo json_encode( $data );
} else {
  header('Content-type: application/json');
  $data = ['success' => true, 'message' => 'Todas as imagens foram enviadas com sucesso'];
  echo json_encode( $data );
}