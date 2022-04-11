<?php 
	namespace App\Controller;

	use App\Controller\Controller;
	use Src\Classes\ClassRender;

	use App\Model\LaudoModelo;
	use App\Model\LaudoItem;
	use App\DAO\LaudoModeloDAO;

	class ControllerLaudoModelo extends Controller {

		use \Src\Traits\TraitOrderItemTitles;

		public function novo($post = null){

			if(isset($post['novoLaudoModelo'])){

				$json = [
					'status' => 0, 
					'msg' => 'Erro: nao foi possivel cadastrar o novo modelo de laudo'
				];

				$lm  = new LaudoModelo($post);
				$res = LaudoModeloDAO::create($lm);

				if(is_array($res)){
					$json['status'] = 1;
					$json['msg'] = "Modelo de laudo cadastrado com sucesso!";
				}

				echo json_encode($json);

			}else{
				$render = new ClassRender;
	            $render->setTitle("Novo Modelo de Laudo");
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->setView('laudo/modelo_laudo');
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->renderizar();
			}
		}

		public function listar($post  = null){
			$lm = new LaudoModelo($post);

			$render = new ClassRender;
            $render->setTitle('Listar Modelos de Laudo');
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->list += ['modelos' => LaudoModeloDAO::find($lm)];
            $render->setView('laudo/listar_modelo_laudo');
            $render->list['load_scripts'] = [
            	'datatable'
            ];
            $render->renderizar();
		}

		public function editar($post,$get, $param){

			if(isset($post['editLaudoModelo'])){

				// print_r($post);
				// exit;

				$msg = 'Erro: nao foi possivel editar este modelo de laudo';
				
				$json = ['status' => 0,
						 'msg' => $msg];

				$lm = new LaudoModelo($post);

				if(LaudoModeloDAO::edit($lm)){
					$json['status'] = 1;
					$json['msg'] = "Modelo de laudo editado com sucesso!";
				}

				echo json_encode($json);
			}else{

				$lm = new LaudoModelo();
				$lm->setId($param[0]);

				$render = new ClassRender;
	            $render->setTitle('Editar Modelo de Laudo');
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['editar' => LaudoModeloDAO::find($lm)[0]];
	            $render->setView('laudo/modelo_laudo');
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->renderizar();
			}
		}

		public function excluir($post = null){

			$json = ['status' => 0, 
					 'msg' => 'Ops, nao foi possivel excluir este modelo de laudo'];
			$lm = new LaudoModelo($post);
			// print_r($grupo);
			if(LaudoModeloDAO::remove($lm)){
				$json['status'] = 1;
				$json['msg'] = "Modelo de laudo deletado com sucesso";
			}

			echo json_encode($json);
		}

		// METODO DOS ITENS DO LAUDO

		public function item($post = null, $get, $param){
			if(count($param) > 0){
				switch ($param[0]) {
					case 'editar':
						$this->editar_item($post, $param[1]);
						break;
					case 'excluir':
						$this->excluir_item($post);
						break;
					case 'listar':
						$this->listar_itens($post,$param[1]);
						break;
					case 'novo':
						$this->novo_item($post,$param[1]);
						break;
				}
				// $this->editarItem($param[1]);
			}
		}

		private function novo_item($post, $id_modelo_laudo){

			if(isset($post['novoLaudoItem'])){

				$json = [
					'status' => 0, 
					'msg' => 'Erro: nao foi possivel cadastrar o novo item de laudo'
				];

				$li = new LaudoItem();
				$li->setLaudoModelo($_SESSION['id_modelo_laudo']);

				if($post['parent'] > 0 ) $li->setParent($post['parent']);
				
				$laudoItens = LaudoModeloDAO::find_itens($li);

				if(is_array($laudoItens)){
					$indice = count($laudoItens);	
				}else{
					$indice = 0;
				}

				$li  = new LaudoItem($post);
				$li->setLaudoModelo($_SESSION['id_modelo_laudo']);
				$li->setIndice($indice);
				$res = LaudoModeloDAO::new_item($li);

				if(is_array($res)){
					$json['status'] = 1;
					$json['msg'] = "Item de laudo cadastrado com sucesso!";
				}

				echo json_encode($json);

			}else{

				$li = new LaudoItem();
				$li->setLaudoModelo($id_modelo_laudo);
				$laudoItens = LaudoModeloDAO::find_itens_by_indice($li);

				$titulos = $this->orderItemTitles($laudoItens);

				$_SESSION['id_modelo_laudo'] = $id_modelo_laudo;
				$lm = new LaudoModelo(['status' => 'ativo', 'id' => $id_modelo_laudo]);

				$render = new ClassRender;
	            $render->setTitle("Novo Item de Laudo");
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['itens' 	=> $titulos ];
	            $render->list += ['modelo' 	=> LaudoModeloDAO::find($lm)[0]];
	            $render->setView('laudo/laudo_item');
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->renderizar();
			}
		}

		private function editar_item($post, $id){

			if(count($post) > 0 && isset($post['editLaudoItem'])){
				$msg = 'Erro: nao foi possivel editar este item de laudo';
				$json = ['status' => 0, 'msg' => $msg];

				$li = new LaudoItem($post);
				$li->setLaudoModelo($_SESSION['id_modelo_laudo']);
				
				if(LaudoModeloDAO::edit_item($li)){
					$json['status'] = 1;
					$json['msg'] = "Item de laudo editado com sucesso!";
				}

				echo json_encode($json);

			}else{

				$li = new LaudoItem(['id' => $id]);
				$li = LaudoModeloDAO::find_itens($li)[0];

				$lm = new LaudoModelo(['status' => 'ativo','id' => $li['id_laudo_modelo']]);
				$modelo = LaudoModeloDAO::find($lm)[0];

				$_SESSION['id_modelo_laudo'] = $modelo['cd_laudo_modelo'];

				//-----------------------------------------------------------------
				$li2 = new LaudoItem();
				$li2->setLaudoModelo($modelo['cd_laudo_modelo']);
				$laudoItens = LaudoModeloDAO::find_itens_by_indice($li2);

				$titulos = $this->orderItemTitles($laudoItens);
				//-----------------------------------------------------------------

				$render = new ClassRender;
	            $render->setTitle("Editar Item de Laudo");
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['modelo' => $modelo];
	            $render->list += ['itens' 	=> $titulos ];
	            $render->list += ['editar' => $li];
	            $render->setView('laudo/laudo_item');
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->renderizar();
			}

		}

		private function listar_itens($post  = null){
			$li = new LaudoItem($post);

			$laudoItens = LaudoModeloDAO::find_itens($li);
			
			$render = new ClassRender;
            $render->setTitle('Listar Modelos de Laudo');
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->list += ['itens' => $laudoItens];
            $render->setView('laudo/listar_laudo_itens');
            $render->list['load_scripts'] = [
            	'datatable'
            ];
            $render->renderizar();
		}

		public function excluir_item($post = null){

			$json['status'] = 0; 
			$json['msg'] 	= 'Ops, nao foi possivel excluir este item de laudo';
			
			$li = new LaudoItem($post);
			// print_r($grupo);
			if(LaudoModeloDAO::remove_item($li)){
				$json['status'] = 1;
				$json['msg'] = "Item de laudo deletado com sucesso";
			}

			echo json_encode($json);
		}

		public function indice($post, $get, $param){

			if(count($post) > 0 && isset($post['modelo'])){
				
				$id_modelo = $post['modelo'];

				$json = [
					'status' => 0, 
					'msg' => 'Ops, editar os indices deste modelo de laudo'
				];
				
				$msg = "";

				$sql = "";

				foreach($post['itens'] as $key => $item){

					$sql .= "UPDATE laudo_modelo_item SET indice = '".$item['indice']."' ";
					$sql .= " WHERE cd_laudo_item = ".$item['item'].";";

					// $data = ['id' => $id,'indice' => $key,'LaudoModelo' => $id_modelo];
					// $li = new LaudoItem($data);
				}

				// echo $sql;
				// exit;

				if(!(LaudoModeloDAO::update_item_indice($sql))){
					$msg .= "Erro ao alterar o indice!\r\n";
				}

				if($msg == ""){
					$json['msg'] = "Ordem atualizada com sucesso!";
				}else{
					$json['status'] = 1;
					$json['msg'] = $msg;
				}

				echo json_encode($json);

			}else{
				$lm = new LaudoModelo(['id' => $param[0]]);
				$lm = LaudoModeloDAO::find($lm)[0];

				$li = new LaudoItem();
				$li->setLaudoModelo($param[0]);
				$laudoItens = LaudoModeloDAO::find_itens_by_indice($li);

				$laudoItens = $this->orderItemTitles($laudoItens);
				
				$render = new ClassRender;
	            $render->setTitle('Ordenar Itens do Modelo de Laudo');
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['modelo' => $lm];
	            $render->list += ['itens' => $laudoItens];
	            $render->setDir('laudo');
	            $render->setView('laudo/laudo_modelo_indice');
	            $render->renderizar();
			}
		}
	}