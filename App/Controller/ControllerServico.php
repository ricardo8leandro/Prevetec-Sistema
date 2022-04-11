<?php 
	namespace App\Controller;

	use App\Controller\Controller;
	use App\Model\Servico;
	use App\DAO\ServicoDAO;
	use Src\Classes\ClassRender;

	class ControllerServico extends Controller {

		public function novo($post = null){

			if(isset($post['novoServico'])){

				$json = [
					'status' => 0, 
					'msg' => 'Erro: nao foi possivel cadastrar o novo serviço'
				];

				$servico = new Servico($post);
				$res = ServicoDAO::create($servico);

				if(is_array($res)){
					$json['status'] = 1;
					$json['msg'] = "Serviço criado com sucesso!";
				}

				echo json_encode($json);

			}else{
				$render = new ClassRender;
	            $render->setTitle("Novo Serviço");
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->setView('servico/new');
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->renderizar();
			}
		}

		public function listar($post  = null){
			$servicos = new Servico($post);

			$render = new ClassRender;
            $render->setTitle('Listar serviços');
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->list += ['servicos' => ServicoDAO::find($servicos)];
            $render->setView('servico/listar');
            $render->list['load_scripts'] = [
            	'datatable'
            ];
            $render->renderizar();
		}

		public function editar($post,$get, $param){

			if(isset($post['editServico'])){

				$msg = 'Erro: nao foi possivel editar este serviço';
				
				$json = [
					'status' => 0,
					'msg' => $msg
				];

				$servico = new Servico($post);

				if(ServicoDAO::edit($servico)){
					$json['status'] = 1;
					$json['msg'] = "Serviço editado com sucesso!";
				}

				echo json_encode($json);
			}else{
			
				$servico = new Servico();
				$servico->setId($param[0]);

				$render = new ClassRender;
	            $render->setTitle('Editar tipo de serviço');
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['editar' => ServicoDAO::find($servico)[0]];
	            $render->setView('servico/new');
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->renderizar();
			}

		}

		public function excluir($post = null){

			$json = ['status' => 0, 
					 'msg' => 'Ops, nao foi possivel excluir este serviço'];
			$ts = new Servico($post);
			// print_r($grupo);
			if(ServicoDAO::remove($ts)){
				$json['status'] = 1;
				$json['msg'] = "Serviço deletado com sucesso";
			}
			echo json_encode($json);
		}
	}