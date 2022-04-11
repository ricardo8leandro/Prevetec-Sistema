<?php 
	namespace App\Controller;

	use App\Controller\Controller;
	use App\Model\Documento;
	use App\DAO\DocumentoDAO;

	use Src\Classes\ClassRender;

	class ControllerDocumento extends Controller {

		public function novo($post = null){

			if(isset($post['novoDocumento'])){

				$json = [
					'status' => 0, 
					'msg' => 'Erro: nao foi possivel cadastrar o novo documento'];

				$doc = new Documento($post);
				$res = DocumentoDAO::create($doc);

				if(is_array($res)){
					$json['status'] = 1;
					$json['msg'] = "Documento criado com sucesso!";
				}

				echo json_encode($json);
			}else{
				$render = new ClassRender;
	            $render->setTitle("Novo Documento");
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->setView('documento/new');
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->renderizar();
			}
		}

		public function listar($post  = null){
			$doc = new Documento($post);

			$render = new ClassRender;
            $render->setTitle('Listar documentos');
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->list += ['documentos' => DocumentoDAO::find($doc)];
            $render->setView('documento/listar');
            $render->list['load_scripts'] = [
            	'datatable'
            ];
            $render->renderizar();
		}


		public function editar($post,$get, $param){

			if(isset($post['editDocumento'])){

				$msg = 'Erro: nao foi possivel editar este Documento';
				$json = ['status' => 0,'msg' => $msg];
				
				$doc = new Documento($post);

				if(DocumentoDAO::edit($doc)){
					$json['status'] = 1;
					$json['msg'] = "Documento editado com sucesso!";
				}

				echo json_encode($json);
			}else{

				$doc = new Documento();
				$doc->setId($param[0]);

				$render = new ClassRender;
	            $render->setTitle('Editar documento');
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['editar' => DocumentoDAO::find($doc)[0]];
	            $render->setView('documento/new');
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->renderizar();
			}
		}

		public function excluir($post = null){

			$json = ['status' => 0, 
					 'msg' => 'Ops, nao foi possivel excluir este documento'];
			$doc = new Documento($post);
			// print_r($grupo);
			if(DocumentoDAO::remove($doc)){
				$json['status'] = 1;
				$json['msg'] = "Documento deletado com sucesso";
			}

			echo json_encode($json);
		}
	}