<?php 
	namespace App\Controller;

	use App\Controller\Controller;
	
	use App\Model\Regiao;
	// use App\Model\Permissao;
	
	use App\DAO\RegiaoDAO;
	use App\DAO\PermissaoDAO;
	use App\DAO\ModuloDAO;

	use Src\Classes\ClassRender;

	class ControllerRegiao extends Controller{

		public function novo($post = null){

			if(isset($post['novaRegiao'])){
				$json = ['status' => 0, 'msg' => 'Erro: nao foi possivel cadastrar a região'];

				$regiao = new Regiao($post);
				$res = RegiaoDAO::create($regiao);

				if(is_array($res)){
					$json['status'] = 1;
					$json['msg'] = "Região criada com sucesso!";
				}

				echo json_encode($json);
			}else{
				$render = new ClassRender;
	            $render->setTitle("Nova região");
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            // $render->list += ['grupos' => GrupoDAO::find($grupo)];
	            $render->setView('regiao/new');
	            $render->renderizar();
			}
		}

		public function editar($post,$get,$param){
			if(isset($post['editRegiao'])){
				$json = ['status' => 0, 'msg' => 'Erro: nao foi possivel editar a região'];

				$regiao = new Regiao($post);

				if(RegiaoDAO::edit($regiao)){
					$json['status'] = 1;
					$json['msg'] = "Região editada com sucesso!";
				}

				echo json_encode($json);
			}else{

				$regiao = new Regiao();
				$regiao->setId($param[0]);

				$render = new ClassRender;
	            $render->setTitle('Editar Região');
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['editar' => RegiaoDAO::find($regiao)[0]];
	            $render->list += ['permissoes' => PermissaoDAO::getPermissoes(null,$param[0])];
	            $render->list += ['modulos' => ModuloDAO::find(1)];
	            $render->setView('regiao/new');
	            $render->renderizar();
			}
		}

		public function listar($post,$get,$params){

			$regiao = new Regiao($post);

			$render = new ClassRender;
            $render->setTitle('Painel');
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->list += ['regioes' => RegiaoDAO::find($regiao)];
            $render->setView('regiao/listar');
            $render->list['load_scripts'] = [
            	'datatable'
            ];
            $render->renderizar();
		}

		public function excluir($post){
			$json = ['status' => 0, 'msg' => 'Ops, nao foi possivel excluir esta região'];
			$regiao = new Regiao($post);
			// print_r($grupo);
			if(RegiaoDAO::remove($regiao)){
				$json['status'] = 1;
				$json['msg'] = "Região deletada com sucesso";
			}
			echo json_encode($json);
		}
	}