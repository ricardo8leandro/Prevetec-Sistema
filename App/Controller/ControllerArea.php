<?php 
	namespace App\Controller;

	use App\Controller\Controller;
	use App\Model\Area;
	use App\DAO\AreaDAO;

	use Src\Classes\ClassRender;

	class ControllerArea extends Controller {

		public function novo($post = null){

			if(isset($post['novaArea'])){

				$json = [
					'status' => 0, 
					'msg' => 'Erro: nao foi possivel cadastrar a nova area'];

				$area = new Area($post);
				$res = AreaDAO::create($area);

				if(is_array($res)){
					$json['status'] = 1;
					$json['msg'] = "Area criada com sucesso!";
				}

				echo json_encode($json);
			}else{
				$render = new ClassRender;
	            $render->setTitle("Nova area");
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->setView('area/new');
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->renderizar();
			}
		}

		public function listar($post  = null){
			$area = new Area($post);

			$render = new ClassRender;
            $render->setTitle('Listar areas');
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->list += ['areas' => AreaDAO::find($area)];
            $render->setView('area/listar');
            $render->list['load_scripts'] = [
	            	'datatable'
	            ];
            $render->renderizar();
		}

		public function editar($post,$get, $param){

			if(isset($post['editArea'])){

				$msg = 'Erro: nao foi possivel editar esta Area';
				
				$json = ['status' => 0,
						 'msg' => $msg];

				$area = new Area($post);

				if(AreaDAO::edit($area)){
					$json['status'] = 1;
					$json['msg'] = "Area editada com sucesso!";
				}

				echo json_encode($json);
			}else{

				$area = new Area();
				$area->setId($param[0]);

				$render = new ClassRender;
	            $render->setTitle('Editar area');
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['editar' => AreaDAO::find($area)[0]];
	            $render->setView('area/new');
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->renderizar();
			}

		}

		public function excluir($post = null){

			$json = ['status' => 0, 
					 'msg' => 'Ops, nao foi possivel excluir esta Area'];
			$area = new Area($post);
			// print_r($grupo);
			if(AreaDAO::remove($area)){
				$json['status'] = 1;
				$json['msg'] = "Area deletada com sucesso";
			}
			echo json_encode($json);
		}
	}