<?php 
	namespace App\Controller;

	use App\Controller\Controller;
	use App\Model\Usuario;
	use App\Model\Chat;

	use App\DAO\ChatDAO;
	use App\DAO\UsuarioDAO;	

	use Src\Classes\ClassRender;

	class ControllerChat extends Controller {

		public function get_chats(){
			
			$chat = new Chat();
			$chat->setStatus('esperando');

			$res = ChatDAO::find($chat);
			if(is_array($res)){
				$chats = count($res);
			}else{
				$chats = 0;
			}

			echo json_encode(['chats' => $chats]);
		}

		public function connect($post){

			$_SESSION['prev_user_id'];

			$chat = new Chat();
			$res = ChatDAO::create($chat);

			if(is_numeric($res)){
				
				$_SESSION['prev_cd_chat'] = $res;

				$json['status'] = 'success';
				$json['msg']	= 'conectado.';

			}else{

				$json['status'] = 'error';
				$json['msg']	= 'não foi possivel conectar.';

			}

			echo json_encode($json);
		}

		public function listen($post = null){

			$msg_lidas 	= $post['msgs_lidas'];

			$chat 		= new Chat();
			$chat->setId($_SESSION['prev_cd_chat']);

			$msgs 		=  ChatDAO::get_messages();
		}

		public function message(){

		}

		public function close(){

		}
	}