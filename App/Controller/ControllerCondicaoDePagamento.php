<?php 
	namespace App\Controller;

	use App\Controller\Controller;

	use App\Model\CondicaoDePagamento;
	use App\DAO\CondicaoDePagamentoDAO;

	use Src\Classes\ClassRender;

	class ControllerCondicaoDePagamento extends Controller {

		public function novo($post = null){

			if(isset($post['novaCondicaoDePagamento'])){

				$json = [
					'status' => 0, 
					'msg' => 'Erro: nao foi possivel cadastrar a nova condição de pagamento'];

				$cp = new CondicaoDePagamento($post);
				$res = CondicaoDePagamentoDAO::create($cp);

				if(is_array($res)){
					$json['status'] = 1;
					$json['msg'] = "Condição de pagamento criada com sucesso!";
				}

				echo json_encode($json);
			}else{
				$render = new ClassRender;
	            $render->setTitle("Nova Condição de pagamento");
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->setView('condicao_pagamento/new');
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->renderizar();
			}
		}

		public function listar($post  = null){
			$cp = new CondicaoDePagamento($post);

			$render = new ClassRender;
            $render->setTitle('Listar edificios');
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->list += ['condicoes' => CondicaoDePagamentoDAO::find($cp)];
            $render->setView('condicao_pagamento/listar');
            $render->list['load_scripts'] = [
            	'datatable'
            ];
            $render->renderizar();
		}


		public function editar($post,$get, $param){

			if(isset($post['editCondicaoDePagamento'])){

				$msg = 'Erro: nao foi possivel editar esta condição de pagamento';
				
				$json = ['status' => 0,
						 'msg' => $msg];

				$cp = new CondicaoDePagamento($post);

				if(CondicaoDePagamentoDAO::edit($cp)){
					$json['status'] = 1;
					$json['msg'] = "Condição de pagamento editada com sucesso!";
				}

				echo json_encode($json);
			}else{

				$cp = new CondicaoDePagamento();
				$cp->setId($param[0]);

				$render = new ClassRender;
	            $render->setTitle('Editar condição de pagamento');
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['editar' => CondicaoDePagamentoDAO::find($cp)[0]];
	            $render->setView('condicao_pagamento/new');
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->renderizar();
			}

		}

		public function excluir($post = null){

			$json = ['status' => 0, 
					 'msg' => 'Ops, nao foi possivel excluir esta condicao de pagamento'];
			$cp = new CondicaoDePagamento($post);
			// print_r($grupo);
			if(CondicaoDePagamentoDAO::remove($cp)){
				$json['status'] = 1;
				$json['msg'] = "Condicao de pagamento deletada com sucesso";
			}
			echo json_encode($json);
		}
	}