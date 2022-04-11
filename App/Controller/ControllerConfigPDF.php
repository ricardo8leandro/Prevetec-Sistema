<?php 
	namespace App\Controller;

	use App\Controller\Controller;
	use App\Model\ConfigPDF;
	use App\DAO\ConfigPDFDAO;

	use Src\Classes\ClassRender;

	class ControllerConfigPDF extends Controller {

		public function novo($post = null){

			if(isset($post['novaConfigPDF'])){

				$json = [
					'status' => 0, 
					'msg' => 'Erro: nao foi possivel cadastrar a nova configuração de PDF'];

				$ConfigPDF = new ConfigPDF($post);
				$res = ConfigPDFDAO::create($ConfigPDF);

				if(is_array($res)){
					$json['status'] = 1;
					$json['msg'] = "Configuração de PDF criada com sucesso!";
				}

				echo json_encode($json);
			}else{
				$render = new ClassRender;
	            $render->setTitle("Nova configuração de PDF");
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->setView('ConfigPDF/new');
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->renderizar();
			}
		}

		public function listar($post  = null){
			$ConfigPDF = new ConfigPDF($post);

			$render = new ClassRender;
            $render->setTitle('Listar Configurações de PDF');
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->list += ['ConfigPDFs' => ConfigPDFDAO::find($ConfigPDF)];
            $render->setView('ConfigPDF/listar');
            $render->list['load_scripts'] = [
            	'datatable'
            ];
            $render->renderizar();
		}


		public function editar($post,$get, $param){

			if(isset($post['editConfigPDF'])){

				$msg = 'Erro: nao foi possivel editar esta configuração de PDF';
				
				$json = ['status' => 0,
						 'msg' => $msg];

				$ConfigPDF = new ConfigPDF($post);

				if(ConfigPDFDAO::edit($ConfigPDF)){
					$json['status'] = 1;
					$json['msg'] = "Configuração de PDF editado com sucesso!";
				}

				echo json_encode($json);
			}else{

				$ConfigPDF = new ConfigPDF();
				$ConfigPDF->setId($param[0]);

				$render = new ClassRender;
	            $render->setTitle('Editar ConfigPDF');
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['editar' => ConfigPDFDAO::find($ConfigPDF)[0]];
	            $render->setView('ConfigPDF/new');
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->renderizar();
			}
		}

		public function excluir($post = null){

			$json = ['status' => 0, 
					 'msg' => 'Ops, nao foi possivel excluir esta configuração de PDF'];
			$ConfigPDF = new ConfigPDF($post);
			// print_r($grupo);
			if(ConfigPDFDAO::remove($ConfigPDF)){
				$json['status'] = 1;
				$json['msg'] = "Configuração de PDF deletado com sucesso";
			}
			echo json_encode($json);
		}
	}