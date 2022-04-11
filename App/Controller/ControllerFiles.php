<?php
	namespace App\Controller;

	use App\Controller\Controller;

	use Src\Classes\ClassRender;

	class ControllerFiles extends Controller {

		public function browse($req){
			header("Content-Type: text/html; charset=utf-8\n");  
			header("Cache-Control: no-cache, must-revalidate\n");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

			$actual_link  = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
			$actual_link .= "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

			if(isset($_POST['remove'])){
				$this->remove($_POST,$actual_link);
			}

			$render = new ClassRender;
            $render->setTitle('Imagens');
            $render->setView('painel/browse-files');
            $render->list['load_scripts'] = [
                'datatable'
            ];

            $render->renderizar();
		}

		private function remove($req,$redirect){
			
			if(isset($req['remove'])){

			    if(file_exists(DIR_REQ.'public/ckeditor/uploads/'.$req['remove'])){
			        unlink(DIR_REQ.'public/ckeditor/uploads/'.$req['remove']);
			    }
			}

			header('Location: '. $redirect);
		}

		public function upload($req){

			if(isset($_FILES['upload'])){
			  	
			    $file = $_FILES['upload']['tmp_name']; 
			    $file_name = $_FILES['upload']['name'];
			    $file_name_array = explode('.',$file_name);
			    $extension = end($file_name_array);
			    $new_image_name = md5(date('U')).'.'.$extension;
			    
			    chmod(DIR_REQ.'public/ckeditor/uploads',0777);

			    $allowed_extension = array('jpg','gif','png');

			    if(in_array($extension,$allowed_extension)){
			    	
			    	$caminho = DIR_REQ.'/public/ckeditor/uploads/'.$new_image_name;
			    	
			    	move_uploaded_file($file,$caminho);

			    	$exif = @exif_read_data($caminho);
					$this->resize_img($caminho, $exif);

			    	$url = DIR_PAGE.'public/ckeditor/uploads/'.$new_image_name;
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

			}else{
				$json = [
		    		'uploaded' 	=> 0,
		    		'fileName' 	=> '',
		    		'url' 		=> '',
		    		'error'		=> array(
		    			'message'	=> 'Erro no caminho!'
		    		)
		    	];    	
			}

			echo json_encode($json);
		}
	}