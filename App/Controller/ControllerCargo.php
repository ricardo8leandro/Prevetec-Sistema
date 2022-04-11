<?php 
	namespace App\Controller;

	use App\Controller\Controller;
	
	use App\Model\Cargo;
	// use App\Model\Permissao;
	
	use App\DAO\CargoDAO;
	use App\DAO\PermissaoDAO;
	use App\DAO\ModuloDAO;

	use Src\Classes\ClassRender;

	class ControllerCargo extends Controller{

		public function novo($post){

			if(isset($post['novoCargo'])){
				$json = ['status' => 0, 'msg' => 'Erro: nao foi possivel cadastrar o cargo'];

				$cargo = new Cargo($post);
				$res = CargoDAO::create($cargo);

				if(is_array($res)){
					$json['status'] = 1;
					$json['msg'] = "Cargo criado com sucesso!";
				}

				echo json_encode($json);
			}else{
				$render = new ClassRender;
	            $render->setTitle("Novo Cargo");
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            // $render->list += ['grupos' => GrupoDAO::find($grupo)];
	            $render->setView('cargo/new');
	            $render->renderizar();
			}
		}

		public function editar($post,$get,$param){
			if(isset($post['editCargo'])){
				$json = ['status' => 0, 'msg' => 'Erro: nao foi possivel editar o cargo'];

				$cargo = new Cargo($post);

				if(CargoDAO::edit($cargo)){
					$json['status'] = 1;
					$json['msg'] = "Cargo editado com sucesso!";
				}

				echo json_encode($json);
			}else{

				$cargo = new Cargo();
				$cargo->setId($param[0]);

				$render = new ClassRender;
	            $render->setTitle('Editar Cargo');
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['editar' => CargoDAO::find($cargo)[0]];
	            $render->list += ['permissoes' => PermissaoDAO::getPermissoes(null,$param[0])];
	            $render->list += ['modulos' => ModuloDAO::find(1)];
	            $render->setView('cargo/new');
	            $render->renderizar();
			}
		}

		public function listar($post,$get,$params){

			$cargo = new Cargo($post);

			$render = new ClassRender;
            $render->setTitle('Painel');
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->list += ['cargos' => CargoDAO::find($cargo)];
            $render->setView('cargo/listar');
            $render->list['load_scripts'] = [
            	'datatable'
            ];
            $render->renderizar();
		}

		public function excluir($post){
			$json = ['status' => 0, 'msg' => 'Ops, nao foi possivel excluir este cargo'];
			$cargo = new Cargo($post);
			// print_r($grupo);
			if(CargoDAO::remove($cargo)){
				$json['status'] = 1;
				$json['msg'] = "Cargo deletado com sucesso";
			}
			echo json_encode($json);
		}
	}