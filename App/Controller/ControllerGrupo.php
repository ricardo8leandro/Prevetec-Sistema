<?php 
	namespace App\Controller;

	use App\Controller\Controller;
	use App\Model\Grupo;
	
	use App\DAO\GrupoDAO;
	use App\DAO\ModuloDAO;
	use App\DAO\PermissaoDAO;

	use Src\Classes\ClassRender;

	class ControllerGrupo extends Controller {

		public function listar($post = null,$get,$params){

			$grupo = new Grupo($post);

			$render = new ClassRender;
            $render->setTitle('Painel');
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->list += ['grupos' => GrupoDAO::find($grupo)];
            $render->setView('grupos/listar');
            $render->list['load_scripts'] = [
            	'datatable'
            ];
            $render->renderizar();
		}

		public function novo($post){
			if(isset($post['novoGrupo'])){
				$json = ['status' => 0, 'msg' => 'Erro: nao foi possivel cadastrar o grupo'];
				$grupo = new Grupo($post);
				$grupo->setCreatedAt(date('Y-m-d h:i:s'));
				$grupo->setUpdatedAt(date('Y-m-d h:i:s'));

				$res = GrupoDAO::create($grupo);

				if(is_array($res)){
					$grupo = $res['data'];
					$json['status'] = 1;
					$json['msg'] = 'Grupo cadastrado com sucesso!';

					foreach($post as $key => $nivel){

						if(substr($key,0,6) == 'radio_'){
							$modulo = substr($key,6,(strlen($key) -6));
							if(!(PermissaoDAO::create($grupo['cd_grupo'],$modulo,$nivel))){
								$json['status'] = 0;
								$json['msg'] = 'Ops, ocorreu um erro';
							}
						}
					}
				}
				echo json_encode($json);

			}else{
				$render = new ClassRender;
            	$render->setTitle('Novo Grupo');
	            $render->setMenu($_SESSION['prev_user_permissao']);

	            $render->list += ['modulos' => ModuloDAO::find(1)];
	            $render->setView('grupos/novo_edit');
	            $render->renderizar();	
			}
		}

		public function editar($post = null, $get = null, $param){

			if(isset($post['editGrupo'])){
				$json = ['status' => 0, 'msg' => 'Ops, nao foi possivel editar este grupo'];

				$grupo = new Grupo($post);
				$grupo->setUpdatedAt(date('Y-m-d h:i:s'));

				if(GrupoDAO::edit($grupo)){
					$json['status'] = 1;
					$json['msg'] = 'Grupo atualizado com sucesso!';

					foreach($post as $key => $nivel){

						if(substr($key,0,6) == 'radio_'){
							$modulo = substr($key,6,(strlen($key) -6));
							if(PermissaoDAO::exists($grupo->getId(),$modulo)){
								if(!(PermissaoDAO::edit($grupo->getId(),$modulo,$nivel))){
									$json['status'] = 0;
									$msg = "Ops, ocorreu um erro ao adicionar radio_".$key;
									$json['msg'] += "\r\n".$msg;
								}
							}else{
								if(!(PermissaoDAO::create($grupo->getId(),$modulo,$nivel))){
									$json['status'] = 0;
									$msg = "Ops, ocorreu um erro ao adicionar radio_".$key;
									$json['msg'] += "\r\n".$msg;
								}
							}
							
						}
					}
				}
				
				echo json_encode($json);

			}else{
				$grupo = new Grupo();
				$grupo->setId($param[0]);

				$render = new ClassRender;
	            $render->setTitle('Editar Grupo');
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['editar' => GrupoDAO::find($grupo)[0]];

	            $render->list += ['permissoes' => PermissaoDAO::getPermissoes(null,$param[0])];
	            $render->list += ['modulos' => ModuloDAO::find(1)];
	            $render->setView('grupos/novo_edit');
	            $render->renderizar();
			}			
		}

		public function excluir($post, $get){
			$json = ['status' => 0, 'msg' => 'Ops, nao foi possivel excluir este grupo'];
			// $grupo = new Grupo($post);
			// print_r($grupo);
			// if(GrupoDAO::remove($grupo)){
			// 	$json['status'] = 1;
			// 	$json['msg'] = "Grupo deletado com sucesso";
			// }
			echo json_encode($json);
		}
	}