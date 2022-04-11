<?php 
	namespace App\Controller;

	use App\Controller\Controller;
	use App\Model\Edificio;
	use App\DAO\EdificioDAO;

	use Src\Classes\ClassRender;

	class ControllerEdificio extends Controller {

		public function novo($post = null){
			
			if(isset($post['novoEdificio'])){
				
				$json['status'] = 0;
				$json['msg'] = "Erro: não foi possivel criar o edificio!";

				$edificio = new Edificio($post);
				$res = EdificioDAO::create($edificio);
				
				if(is_array($res)){
					$json['status'] = 1;
					$json['msg'] = "Edificio criado com sucesso!";
				}

				echo json_encode($json);

			}else{

				$render = new ClassRender;
	            $render->setTitle("Novo Edificio");
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->setView('edificio/new');
	            $render->renderizar();

			}
		}

		public function listar($post = null){
			$edificio = new Edificio($post);

			$render = new ClassRender;
            $render->setTitle('Listar edificios');
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->list += ['edificios' => EdificioDAO::find($edificio)];
            $render->setView('edificio/listar');
            $render->list['load_scripts'] = [
            	'datatable'
            ];
            $render->renderizar();
		}

		public function editar($post,$get, $param){

			if(isset($post['editEdificio'])){
				$json = ['status' => 0,
						 'msg' => 'Erro: nao foi possivel editar este tipo de edificio'];

				$edificio = new Edificio($post);

				if(EdificioDAO::edit($edificio)){
					$json['status'] = 1;
					$json['msg'] = "Tipo de edificio editado com sucesso!";
				}

				echo json_encode($json);
			}else{

				$edificio = new Edificio();
				$edificio->setId($param[0]);

				$render = new ClassRender;
	            $render->setTitle('Editar edificio');
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['editar' => EdificioDAO::find($edificio)[0]];
	            // $render->list += ['permissoes' => PermissaoDAO::getPermissoes(null,$param[0])];
	            // $render->list += ['modulos' => ModuloDAO::find(1)];
	            $render->setView('edificio/new');
	            $render->renderizar();
			}

		}

		public function excluir($post = null){
			$json = ['status' => 0, 'msg' => 'Ops, nao foi possivel excluir este tipo de edificio'];
			$edificio = new Edificio($post);
			// print_r($grupo);
			if(EdificioDAO::remove($edificio)){
				$json['status'] = 1;
				$json['msg'] = "Tipo de edificio deletado com sucesso";
			}
			echo json_encode($json);
		}
	}