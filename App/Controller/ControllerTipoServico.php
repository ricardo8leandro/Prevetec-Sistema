<?php 
	namespace App\Controller;

	use App\Controller\Controller;
	
	use App\Model\TipoServico;
	use App\Model\ConfigPDF;

	use App\DAO\TipoServicoDAO;
	use App\DAO\ConfigPDFDAO;

	use Src\Classes\ClassRender;

	class ControllerTipoServico extends Controller {

		public function novo($post = null){

			if(isset($post['novoTipoServico'])){

				$json = [
					'status' => 0, 
					'msg' => 'Erro: nao foi possivel cadastrar o novo tipo de serviço'
				];

				$configPDF = new ConfigPDF();
				$configPDF->setId($post['ConfigPDF']);

				$ts = new TipoServico($post);
				$ts->setConfigPDF($configPDF);

				$res = TipoServicoDAO::create($ts);

				if(is_array($res)){
					$json['status'] = 1;
					$json['msg'] = "Tipo de serviço criado com sucesso!";
				}

				echo json_encode($json);
			}else{
				$PDFs = new ConfigPDF;
				$PDFs->setStatus('1');
				$PDFs = ConfigPDFDAO::find($PDFs);

				$render = new ClassRender;
	            $render->setTitle("Novo Tipo de Serviço");
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['configPDFs' => $PDFs];
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];

	            $render->setView('tipo_servico/new');
	            $render->renderizar();
			}
		}

		public function listar($post  = null){
			$ts = new TipoServico($post);

			$render = new ClassRender;
            $render->setTitle('Listar Tipos de serviços');
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->list += ['ts' => TipoServicoDAO::find($ts)];
            $render->setView('tipo_servico/listar');
            $render->list['load_scripts'] = [
            	'datatable'
            ];
            $render->renderizar();
		}

		public function editar($post,$get, $param){

			if(isset($post['editTipoServico'])){

				$msg = 'Erro: nao foi possivel editar este tipo de serviço';
				
				$json = ['status' => 0,
						 'msg' => $msg,
						 'post' => json_encode($post)];

				$configPDF = new ConfigPDF();
				$configPDF->setId($post['ConfigPDF']);

				$ts = new TipoServico($post);
				$ts->setConfigPDF($configPDF);

				if(TipoServicoDAO::edit($ts)){
					$json['status'] = 1;
					$json['msg'] = "Tipo de serviço editado com sucesso!";
				}

				echo json_encode($json);
			}else{
				$PDFs = new ConfigPDF;
				$PDFs->setStatus('1');
				$PDFs = ConfigPDFDAO::find($PDFs);

				$ts = new TipoServico();
				$ts->setId($param[0]);

				$render = new ClassRender;
	            $render->setTitle('Editar tipo de serviço');
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['editar' => TipoServicoDAO::find($ts)[0]];
	            $render->list += ['configPDFs' => $PDFs];
	            $render->setView('tipo_servico/new');
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];
	            $render->renderizar();
			}

		}

		public function excluir($post = null){

			$json = ['status' => 0, 
					 'msg' => 'Ops, nao foi possivel excluir este tipo de serviço'];
			$ts = new TipoServico($post);
			// print_r($grupo);
			if(TipoServicoDAO::remove($ts)){
				$json['status'] = 1;
				$json['msg'] = "Tipo de serviço deletado com sucesso";
			}
			echo json_encode($json);
		}
	}