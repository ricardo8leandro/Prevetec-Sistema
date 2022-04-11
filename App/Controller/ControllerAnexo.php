<?php 
	namespace App\Controller;

	use App\Controller\Controller;
	use App\Model\Anexo;
	use App\DAO\AnexoDAO;

	use Src\Classes\ClassRender;

	class ControllerAnexo extends Controller {

		public function novo($post = null){

			if(isset($post['novoAnexo'])){

				$json = [
					'status' => 0, 
					'msg' => 'Erro: nao foi possivel cadastrar o novo anexo'];

				$cp = new Anexo($post);
				$res = AnexoDAO::create($cp);

				if(is_array($res)){
					$json['status'] = 1;
					$json['msg'] = "Anexo criado com sucesso!";
				}

				echo json_encode($json);
			}else{
				$render = new ClassRender;
	            $render->setTitle("Novo anexo");
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->setView('anexo/new');
		        $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->renderizar();
			}
		}

		public function listar($post  = null){
			$cp = new Anexo($post);

			$render = new ClassRender;
            $render->setTitle('Listar anexos');
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->list += ['anexos' => AnexoDAO::find($cp)];
            $render->setView('anexo/listar');
            $render->list['load_scripts'] = [
            	'datatable'
            ];
            $render->renderizar();
		}


		public function editar($post,$get, $param){

			if(isset($post['editAnexo'])){

				$msg = 'Erro: nao foi possivel editar este anexo';
				
				$json = ['status' => 0,
						 'msg' => $msg];

				$cp = new Anexo($post);

				if(AnexoDAO::edit($cp)){
					$json['status'] = 1;
					$json['msg'] = "Anexo editado com sucesso!";
				}

				echo json_encode($json);
			}else{

				$cp = new Anexo();
				$cp->setId($param[0]);

				$render = new ClassRender;
	            $render->setTitle('Editar Anexo');
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['editar' => AnexoDAO::find($cp)[0]];
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->setView('anexo/new');
	            $render->renderizar();
			}

		}

		public function excluir($post = null){

			$json = ['status' => 0, 
					 'msg' => 'Ops, nao foi possivel excluir este anexo'];
			$cp = new Anexo($post);
			// print_r($grupo);
			if(AnexoDAO::remove($cp)){
				$json['status'] = 1;
				$json['msg'] = "Anexo deletado com sucesso";
			}
			echo json_encode($json);
		}
	}