<?php 

	namespace App\Controller;

	use App\Controller\Controller;
	use App\Controller\ContollerPropostaPDF;

	use App\Model\Usuario;
	use App\Model\Proposta;
	use App\Model\PropostaPDF;
	use App\Model\TipoServico;
	use App\Model\Edificio;
	use App\Model\ConfigPDF;
	use App\Model\Documento;
	use App\Model\Area;
	use App\Model\Anexo;
	use App\Model\Servico;
	use App\Model\CondicaoDePagamento;
	use App\Model\PropostaArea;
	use App\Model\PropostaAreaServico;
	use App\Model\Regiao;

	use App\DAO\UsuarioDAO;
	use App\DAO\PropostaDAO;
	use App\DAO\PropostaPDFDAO;
	use App\DAO\TipoServicoDAO;
	use App\DAO\EdificioDAO;
	use App\DAO\ConfigPDFDAO;
	use App\DAO\DocumentoDAO;
	use App\DAO\AreaDAO;
	use App\DAO\AnexoDAO;
	use App\DAO\ServicoDAO;
	use App\DAO\CondicaoDePagamentoDAO;
	use App\DAO\PropostaAreaDAO;
	use App\DAO\PropostaAreaServicoDAO;
	use App\DAO\RegiaoDAO;

	use Src\Classes\ClassRender;
	use Src\Classes\GeradorPDF;
	use Src\Classes\GeradorLAUDOPDF;

	class ControllerProposta extends Controller {

		use \Src\Traits\TraitVariaveisPDF;

		public function novo($post = null, $url = null, $p3 = null){

			unset($_SESSION['prev_areas']);

			if(isset($post) && isset($post['novaProposta']) ){

			}else{
				clearstatcache();

				$cliente = new Usuario();

				/* status 1 = ativo*/
				$cliente->setStatus(1);

				/* grupo 6 = cliente */
				$cliente->setGrupo(6);

				$cols = "cd_usuario, nm_usuario";
				$ts = new TipoServico();
				$ts->setStatus(1);

				$te = new Edificio();
				$te->setStatus(1);

				$cpdf =  new ConfigPDF();
				$cpdf->setStatus(1);

				$doc = new Documento();
				$doc->setStatus(1);

				$eng = new Usuario;
				$eng->setGrupo(11);

				$area = new Area;
				$area->setStatus(1);

				$anexo = new Anexo;
				$anexo->setStatus(1);

				$condPagto = new CondicaoDePagamento;
				$condPagto->setStatus(1);

				$regiao = new Regiao(['ic_regiao' => 1]);

				// $this->debug($clientes);

				$render = new ClassRender;

	            $render->setTitle('Nova proposta');

	            $render->setMenu($_SESSION['prev_user_permissao']);	

	            $render->list += ['clientes' => UsuarioDAO::find($cliente,$cols,false,'nm_usuario')];
	            $render->list += ['tipoServicos'  => TipoServicoDAO::find($ts,'ds_titulo')];
	            $render->list += ['tipoEdificios' => EdificioDAO::find($te,'ds_titulo')];
	            $render->list += ['configPDFs' 	  => ConfigPDFDAO::find($cpdf,'ds_titulo')];
	            $render->list += ['docs'		  => DocumentoDAO::find($doc,'ds_titulo')];
	            $render->list += ['engs' 		  => UsuarioDAO::find($eng,$cols,false,'nm_usuario')];
	            $render->list += ['areas' 		  => AreaDAO::find($area,'ds_titulo')];
	            $render->list += ['anexos' 		  => AnexoDAO::find($anexo,'ds_titulo')];
	            $render->list += ['condPagto' 	  => CondicaoDePagamentoDAO::find($condPagto,'ds_titulo')];
	            $render->list += ['regioes' 	  => RegiaoDAO::find($regiao,'nm_regiao')];

	            $render->setDir('proposta');
	            $render->setView('proposta/new_edit');
	            $render->list['load_scripts'] = [
	            	'editor'
	            ];

	            $render->renderizar();
			}
		}

		public function listar($param = null){

			$filters = [
				'status' 		=> isset($_GET['status'])? $_GET['status']:false,
				'regiao' 		=> isset($_GET['regiao'])? $_GET['regiao']:false,
				'cliente'		=> isset($_GET['cliente'])? $_GET['cliente']:false,
				'tipoServico'	=> isset($_GET['tipoServico'])? $_GET['tipoServico']:false,
			];

			$proposta = $this->filterProposta();

			if( isset($_SESSION['prev_user_regiao']) ){
				if($_SESSION['prev_user_regiao'] != 7 && $_SESSION['prev_user_regiao'] != "0"){
					$proposta->setRegiao($_SESSION['prev_user_regiao']);
				}
			}

			$propostas = PropostaDAO::find($proposta,'cd_proposta DESC');

			$regiao = new Regiao;
			$regiao->setStatus('1');

			$cliente = new Usuario(['grupo' => '6','active' => '1']);
			$colsCliente = "cd_usuario, nm_usuario";

			$tipoServico = new TipoServico(['cd_situacao' => '1']);

			$render = new ClassRender;

            $render->setTitle('Nova proposta');
            $render->setMenu($_SESSION['prev_user_permissao']);	

            $render->list += ['propostas' 	=> $propostas];
            $render->list += ['regioes'   	=> RegiaoDAO::find($regiao)];
            $render->list += ['clientes'  	=> UsuarioDAO::find($cliente,$colsCliente,false,'nm_usuario')];
            $render->list += ['tipoServico' => TipoServicoDAO::find($tipoServico,'ds_titulo')];
            $render->list += ['filters'   	=> $filters];
            $render->list['load_scripts'] = [
            	'datatable'
            ];

			$render->setDir('proposta');
            $render->setView('proposta/listar');
            $render->renderizar();
		}

		public function listar_proposta_pdfs($post, $get, $proposta){

			$proposta = $proposta[0];

			if(is_numeric($proposta) && $proposta > 0){

				$pdfs = PropostaPDFDAO::find(new PropostaPDF(['proposta' => $proposta]));

				$render = new ClassRender;
	            $render->setTitle('Proposta Histórico PDF');
	            $render->setMenu($_SESSION['prev_user_permissao']);	

	            $render->list +=['pdfs' => $pdfs];

				$render->setDir('proposta');
	            $render->setView('proposta/listar-pdfs');
	            $render->list['load_scripts'] = [
	            	'datatable'
	            ];

	            $render->renderizar();

			}else{
				header('Location: '.DIR_PAINEL);
			}
		}

		public function editar($post, $get, $proposta_id){

			clearstatcache();
			unset($_SESSION['prev_areas']);

			$proposta_id = $proposta_id[0];
			$cliente = new Usuario();

			/* status 1 = ativo*/

			$cliente->setStatus(1);
			/* grupo 6 = cliente */

			$cliente->setGrupo(6);

			$cols = "cd_usuario, nm_usuario";

			$ts = new TipoServico();
			$ts->setStatus(1);

			$te = new Edificio();
			$te->setStatus(1);

			$cpdf =  new ConfigPDF();
			$cpdf->setStatus(1);

			$doc = new Documento();
			$doc->setStatus(1);

			$eng = new Usuario;
			$eng->setGrupo(11);

			$area = new Area;
			$area->setStatus(1);

			$anexo = new Anexo;
			$anexo->setStatus(1);

			$condPagto = new CondicaoDePagamento;
			$condPagto->setStatus(1);

			$proposta = PropostaDAO::find(new Proposta(['id' => $proposta_id]))[0];

			$pdfs = PropostaPDFDAO::find(new PropostaPDF(['proposta' => $proposta_id]));
			$pa = PropostaAreaDAO::find(new PropostaArea(['proposta'=> $proposta_id]),' cd_indice ASC ');

			if(is_array($pa)){

				foreach($pa as $key => $value){

					$pas = PropostaAreaServicoDAO::find(
						new PropostaAreaServico(['propostaArea'=>$value['cd_proposta_area']]),
							' cdindice ASC '
						);

					$pa[$key]['servicos'] = $pas;
				}
			}

			$regiao = new Regiao(['ic_regiao' => 1]);

			$render = new ClassRender;
            $render->setTitle('Editar proposta');
            $render->setMenu($_SESSION['prev_user_permissao']);

            $render->list += ['proposta_id' 	=> $proposta_id ];
            $render->list += ['clientes' 		=> UsuarioDAO::find($cliente,$cols,false,'nm_usuario')];
            $render->list += ['tipoServicos' 	=> TipoServicoDAO::find($ts,'ds_titulo')];
            $render->list += ['tipoEdificios' 	=> EdificioDAO::find($te,'ds_titulo')];
            $render->list += ['configPDFs' 		=> ConfigPDFDAO::find($cpdf,'ds_titulo')];
            $render->list += ['docs'			=> DocumentoDAO::find($doc,'ds_titulo')];
            $render->list += ['engs' 			=> UsuarioDAO::find($eng,$cols,false,'nm_usuario')];
            $render->list += ['areas' 			=> AreaDAO::find($area,'ds_titulo')];
            $render->list += ['anexos' 			=> AnexoDAO::find($anexo,'ds_titulo')];
            $render->list += ['condPagto' 		=> CondicaoDePagamentoDAO::find($condPagto,'ds_titulo')];
            $render->list += ['editar' 			=> $proposta];
            $render->list += ['propostaArea' 	=> $pa];
            $render->list += ['pdfs' 			=> $pdfs];
            $render->list += ['regioes' 	  => RegiaoDAO::find($regiao,'nm_regiao')];
            $render->list['load_scripts'] = [
            	'editor'
            ];

            $render->setDir('proposta');
            $render->setView('proposta/new_edit');
            $render->renderizar();
		}

		public function excluir($post, $get, $param){

			$json['status'] = 0;

			$json['msg'] =  "Erro: não foi possivel excluir a proposta!";

			

			$proposta = PropostaDAO::find(new Proposta($post))[0];

			

			$data = ['proposta' => $proposta['cd_proposta'] ];

			$propostaAreas = PropostaAreaDAO::find(new PropostaArea($data));

			$ppdfs =  PropostaPDFDAO::find(new PropostaPDF($data));

			$this->removerArquivosPPDF($ppdfs);



			if(is_array($propostaAreas)){
				
				$pas_query = "";
				
				foreach($propostaAreas as $prop_area){
					if($pas_query != "") $pas_query .= " OR ";
					$pas_query .= " cdpropostaarea = ".$prop_area['cd_proposta_area'];
				}

				PropostaAreaServicoDAO::remove_by_area($pas_query);
			}

			
			PropostaAreaDAO::remove_by_proposta($proposta['cd_proposta']);
			PropostaPDFDAO::remove(new PropostaPDF($data));

			$file = $proposta['ds_path_proposta_pdf'];

			if(!empty($file) && file_exists(DIR_PDFs.$file)) unlink(DIR_PDFs.$file);

		

			if(PropostaDAO::remove(new Proposta($post))){

				$json['status'] = 1;

				$json['msg'] = 'Proposta excluida com sucesso!';

			}

			echo json_encode($json);
		}

		private function removerArquivosPPDF($ppdfs){
			if(is_array($ppdfs)){
				foreach($ppdfs as $key => $pdf){
					if(file_exists(DIR_PDFs.$pdf['ds_path_pdf']))
						unlink(DIR_PDFs.$pdf['ds_path_pdf']);
				}
			}
		}

		public function carregarEstrutura($post, $get, $param){

			$tipo = $param[0];

			if($tipo == 'area'){
				include DIR_VIEW.'proposta/estrutura-area.php';
			}else if($tipo == 'servico'){
				include DIR_VIEW.'proposta/estrutura-servico.php';
			}
		}

		public function listaServicos($post, $get, $param){

			$servico  = new servico;
			$servico->setStatus(1);

			if(count($post) > 0){
				foreach($post as $key => $value) $servico->setIgnoredIds($value['id']);
				echo json_encode(ServicoDAO::FilterIgnoredIds($servico,'ds_titulo'));
			}else{
				echo json_encode(ServicoDAO::find($servico,'ds_titulo'));
			}
		}

		public function ajax_areas(){
			$id = $_POST['area']['id'];
			$_SESSION['prev_areas']['area_'. $id] = $_POST['area'];
		}

		public function gerarProposta($post, $get, $param){

			if(isset($_SESSION['prev_areas'])){
				$post['areas'] = $_SESSION['prev_areas'];	
			}else{
				$post['areas'] = [];
			}
			

			unset($_SESSION['prev_areas']);
			clearstatcache();

			if(isset($post['proposta_id'])){
				$id_proposta = $this->editarProposta($post);
			}else{
				$id_proposta = $this->salvarProposta($post);
			}

			if(!is_numeric($id_proposta)){

				$json['status'] = 0;
				$json['msg']	= 'não foi possivel cadastrar a proposta';
				echo json_encode($json);

				return;
			}

			if(isset($post['areas'])){
				$this->salvarPropostaAreas($id_proposta, $post['areas']);
			}

			$prop = new Proposta(['id' => $id_proposta]);
			$proposta = PropostaDAO::find($prop)[0];

			$ConfigPDF = new ConfigPDF;
			$ConfigPDF->setId($post['ConfigPDF']);

			$ConfigPDF = ConfigPDFDAO::find($ConfigPDF)[0];

			$tipoServico = new TipoServico;
			$tipoServico->setId($post['tipoServico']);
			$tipoServico = TipoServicoDAO::find($tipoServico)[0];

			if(isset($post['areas']) && is_array($post['areas']) && count($post['areas']) > 0){

				$areas  = PropostaAreaDAO::find(new PropostaArea(['proposta'=> $id_proposta]),'cd_indice');

				foreach($areas as $key => $area){

					$pas = PropostaAreaServicoDAO::find(
						new PropostaAreaServico(['propostaArea'=> $area['cd_proposta_area']]),
							' cdindice ASC '
						);

					$areas[$key]['servicos'] = $pas;
				}

				$servicos = $this->montaServicosPDF($areas);

			}else{
				$servicos = "";
			}

			$conteudo = $ConfigPDF['ds_conteudo'];

			$arrayVars = $this->get_campos_substituiveis(
				[
					'documento' => $proposta['cd_documento'],
					'proposta'	=> $proposta,
					'cliente'	=> $proposta['cd_cliente'],
					'engenheiro'=> $proposta['cd_profissional'],
					'edificio'  => $proposta['cd_tipo_edificio']
				]
			);

			/* tipos de servicos */
			$arrayVars['de']   =  array_merge($arrayVars['de'],array('{{PROPOSTA.TIPO_SERVICO}}'));
			$arrayVars['para'] =  array_merge($arrayVars['para'],array($tipoServico['ds_descricao']));

			/* servicos */
			$arrayVars['de']   =  array_merge($arrayVars['de'],array('{{PROPOSTA.SERVICOS}}'));
			$arrayVars['para'] =  array_merge($arrayVars['para'],array($servicos));

			/* valor de pagamento */
			$pag_vl = $post['pagamento']['valor'];
			$arrayVars['de']   =  array_merge($arrayVars['de'],array('{{PROPOSTA.VALOR}}'));
			$arrayVars['para'] =  array_merge($arrayVars['para'],array($pag_vl));

			/* condicao de pagamento */
			$pag_cont = $post['pagamento']['conteudo'];
			$arrayVars['de']   =  array_merge($arrayVars['de'],array('{{PROPOSTA.CONDICAO_PAGTO}}'));
			$arrayVars['para'] =  array_merge($arrayVars['para'],array($pag_cont));

			$conteudo = str_replace($arrayVars['de'],$arrayVars['para'],$conteudo);

			$pdf2 = new GeradorLAUDOPDF();

			$header = $ConfigPDF['ds_cabecalho'];
			$footer = $ConfigPDF['ds_rodape'];

			$pdf2->Content('',$conteudo,false,'proposta', $header, $footer);

			$nome = date('d-m-y-h-i-s')."_c".$proposta['cd_cliente']."_p".$id_proposta.".pdf";

			$this->salvarUrlPDF($id_proposta, $nome);

			$res = $pdf2->gerar($nome,DIR_PDFs);

			$json['status'] = 0;

			if($res){
				$json['id_proposta'] = $id_proposta;
				$json['status'] = 1;
				$json['url'] = DIR_PAGE.'public/PDFs/'.$res;
			}

			echo json_encode($json);
		}

		private function salvarUrlPDF($proposta, $nome){

			$prop = new Proposta(['id' => $proposta]);
			$p = PropostaDAO::find($prop)[0];

			if(!empty($p['ds_path_proposta_pdf'])){

				$old = $p['ds_path_proposta_pdf'];

				PropostaPDFDAO::create(new PropostaPDF([
					'proposta' => $proposta,
					'path'	=> $old,
					'dtRegistro' => $p['dt_registro'],
					'status' => 1 
				]));
			}

			$prop->setPathPDF($nome);
			$prop->setDtRegistro(date('Y-m-d h:i:s'));
			PropostaDAO::edit($prop);
		}

		private function montaServicosPDF($areas){

			$estrutura = "";
			$b_style   = "font-weight:bold;font-family: sans-serif;color:#222";

			if(is_array($areas)){

				foreach($areas as $indice => $area){

					$servicos = null;

					if(isset($area['servicos'])){
						$servicos = $area['servicos'];
					}

					$ObjArea = new Area(['id'=> $area['cd_area']]);

					$ObjArea = AreaDAO::find($ObjArea)[0];

					$estrutura .=  "<b style='".$b_style."'>".$ObjArea['ds_titulo']."</b><br>";

					if(is_array($servicos)){

						foreach($servicos as $i => $servico){
							// $estrutura .= $servico['ds_titulo'];
							$estrutura .= $servico['ds_descricao'];
						}
					}
				}
			}

			return $estrutura;
		}

		private function salvarProposta($proposta){

			$proposta = new Proposta($proposta);
			$proposta->setDtRegistro(date('Y-m-d h:i:s'));
			$proposta = PropostaDAO::create($proposta);

			if($proposta['error'] == ""){
				return $proposta['data']['cd_proposta'];
			}

			return false;
		}

		private function editarProposta($proposta){

			$prop = new Proposta($proposta);

			$prop->setDtRegistro(date('Y-m-d h:i:s'));
			$prop->setId($proposta['proposta_id']);

			if(PropostaDAO::edit($prop)){
				return $proposta['proposta_id'];
			}			
			return false;
		}

		private function salvarPropostaAreas($id_proposta, $areas){

			$where = "";

			foreach($areas as $area => $data){

				if($where != ""){
					$where .= " OR ";
					$where .= "proposta_area.cd_area = ". $data['id'];
				}else{
					$where .= "cd_area = ". $data['id'];
					$where .= " AND proposta_area.cd_proposta = ".$id_proposta;
				}

			}

			$propareas = PropostaAreaDAO::find_or($where);

			foreach($areas as $area => $data){

				/* preparando o array pra criar o objeto*/
				$data['area'] 		= $data['id'];
				$data['id'] 		= null;
				$data['proposta'] 	= $id_proposta;

				$proparea = new PropostaArea($data);

				$acao = 'criar';

				if(is_array($propareas)){

					foreach($propareas as $key => $p_area){

						/* passando o valor para variaveis menores. */
						$cd_proposta = $p_area['cd_proposta'];
						$cd_area 	 = $p_area['cd_area'];

						if($cd_area == $data['area'] && $cd_proposta == $id_proposta){
							$acao 	 = 'editar';
							$proparea->setId($p_area['cd_proposta_area']);
						}

					}

				}

				if($acao == 'criar'){
					$pa = PropostaAreaDAO::create($proparea);
				}else{

					if(PropostaAreaDAO::edit($proparea)){
						$pa['error'] = "";
						$pa['data']['cd_proposta_area'] = $proparea->getId();
					}else{
						$pa['error'] = "nao foi possivel editar a area";
					}

				}

				if($pa['error'] == ""){

					$cd_pa = $pa['data']['cd_proposta_area'];

					if(isset($data['servicos']) && is_array($data['servicos'])){
						$this->salvarPropostaAreaServicos($cd_pa,$data['servicos']);
					}

				}
			}
		}

		private function salvarPropostaAreaServicos($cd_pa, $servicos){

			$where = "";

			foreach($servicos as $servico => $data){
				if($where != ""){
					$where .= " OR ";
					$where .= "tpropostaareaservico.cdpropostaarea = ". $cd_pa;
				}else{
					$where .= "cdpropostaarea = ". $data['id'];
					$where .= " AND tpropostaareaservico.cdservico = ".$data['id'];
				}
			}

			$propAreaServicos = PropostaAreaServicoDAO::find_or($where);

			foreach($servicos as $key => $srv){

				/* preparando o array pra criar o objeto*/
				$data['propostaArea'] = $cd_pa;
				$data['servico'] = $srv['id'];
				$data['id'] = null;
				$data['indice'] = $srv['indice'];

				$obj_pas = new PropostaAreaServico($data);

				$acao = 'criar';

				if(is_array($propAreaServicos)){
					foreach($propAreaServicos as $key => $pas){

						/* passando o valor para variaveis menores. */
						$cd_proparea = $pas['cdpropostaarea'];
						$cd_servico  = $pas['cdservico'];

						if($cd_servico == $data['servico'] && $cd_proparea == $cd_pa){
							$acao = 'editar';
							$obj_pas->setId($pas['cdpropostaareaservico']);
						}
					}
				}

				if($acao == 'criar'){
					PropostaAreaServicoDAO::create($obj_pas);
				}else{
					PropostaAreaServicoDAO::edit($obj_pas);
				}
			}
		}

		public function excluir_pdf($post, $get, $param){

			$json['status'] = 0;
			$json['msg'] = "Erro: Não foi possivel excluir o PDF!";

			$ppdfs = PropostaPDFDAO::find(new PropostaPDF($post));
			$this->removerArquivosPPDF($ppdfs);

			if(PropostaPDFDAO::remove(new PropostaPDF($post))){
				$json['status'] = 1;
				$json['msg'] = "PDF excluido com sucesso!";
			}

			$json['teste'] = $post;

			echo json_encode($json);
		}

		public function removerArea($post, $get, $param){

			$proparea = new PropostaArea($post);
			$obj = PropostaAreaDAO::find($proparea);

			if(is_array($obj)){
				$post['propostaArea'] = $obj[0]['cd_proposta_area'];
				$this->removerPropostaAreaServico($post);
			}

			if(PropostaAreaDAO::remove($proparea)){
				echo 'excluido';
			}else{
				echo "nao excluido";
			}
		}

		public function removeAreaServico($post, $get, $param){

			$proparea = new PropostaArea($post);
			$obj = PropostaAreaDAO::find($proparea);

			$data['propostaArea'] = $obj[0]['cd_proposta_area'];
			$data['servico'] = $post['servico'];

			$this->removerPropostaAreaServico($data);
		}

		public function removerPropostaAreaServico($post){
			$pas = new PropostaAreaServico($post);
			return PropostaAreaServicoDAO::remove($pas);
		}

		public function proposta_aceita ($post, $get, $param){

			$status = $post['status'];
			$id 	= $post['id'];

			if($status == 1){
				$msg = 'Proposta aprovada com sucesso';
			}else{
				$msg = 'Proposta recusada com sucesso';
			}

			$prop = new Proposta(['aprovada'=> $status, 'id'=> $id]);

			if(PropostaDAO::aprovacao($prop)){
				echo $msg;
			}else{
				echo "Erro: não foi possivel atualizar a proposta";
			}
		}

		private function filterProposta(){

			$status = $this->filter_exists('status');
			$regiao = $this->filter_exists('regiao');
			$cliente= $this->filter_exists('cliente');

			return new Proposta(
				[
				'status'	=> $status,
				'regiao'	=> $regiao,
				'cliente'	=> $cliente
				]
			);
		}

		private function filter_exists($filter){

			if(isset($_GET[$filter])){
				return addslashes($_GET[$filter]);
			}
			return null;
		}
	}