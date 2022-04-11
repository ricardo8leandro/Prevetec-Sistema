<?php 
	namespace App\Controller;

	use App\Controller\Controller;

	use App\Model\Laudo;
	use App\Model\LaudoModelo;
	use App\Model\LaudoItem;
	use App\Model\Usuario;
	use App\Model\Area;
	use App\Model\Cidade;
	use App\Model\Edificio;
	use App\Model\Regiao;
	use App\Model\Estado;

	use App\DAO\LaudoDAO;
	use App\DAO\LaudoModeloDAO;
	use App\DAO\UsuarioDAO;
	use App\DAO\AreaDAO;
	use App\DAO\CidadeDAO;
	use App\DAO\EdificioDAO;
	use App\DAO\RegiaoDAO;
	use App\DAO\EstadoDAO;

	use Src\Classes\ClassRender;
	use Src\Classes\GeradorLAUDOPDF;

	class ControllerLaudo extends Controller {

		use \Src\Traits\TraitVariaveisPDF;
		use \Src\Traits\TraitOrderItemTitles;

		public function cert(){
			clearstatcache();
			$msg = '';

			$pdfs = [];
			if(isset($_FILES['cert1']) && $_FILES['cert1']['error'] != 4){
				$pdfs[] = 'cert1';
			}

			if(isset($_FILES['cert2']) && $_FILES['cert2']['error'] != 4){
				$pdfs[] = 'cert2';
			}

			if(count($pdfs) > 0 ){

				foreach($pdfs as $pdf){

					$fileName  = $_FILES[$pdf];

					$allowed = array('pdf');
					$filename = $_FILES[$pdf]['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if (!in_array(strtolower($ext), $allowed)) {
						$msg = 'O formato do arquivo deve ser PDF!';   	
					}else{

						$fileName = $pdf.".pdf";
						
						$path = DIR_REQ.'public/laudosPDF/'.$fileName;

						if(file_exists($path)) unlink($path);

						move_uploaded_file($_FILES[$pdf]['tmp_name'], $path);

						$msg = "Arquivo enviado com sucesso!";
						sleep(2);
					}
				}
			}

			$render = new ClassRender;
            $render->setTitle("Certificado do laudo");
            $render->setMenu($_SESSION['prev_user_permissao']);
            
            $render->list += ['msg' => $msg];

            $render->setDir('laudo');
            $render->setView('laudo/cert');
            $render->renderizar();
		}

		public function formatar_pdf(){

			$render = new ClassRender;
            $render->setTitle("Formatar PDF");
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->setView('laudo/formatacao_pdf');
            $render->renderizar();
		}

		public function novo($post = null){

			if(isset($post['novoLaudo'])){

				$json = [
					'status' => 0, 
					'msg' => 'Erro: nao foi possivel cadastrar o novo laudo'
				];

				$laudo = new Laudo($post);
				$laudo->setDtCadastro(date('Y-m-d h:i:s'));

				$data = LaudoDAO::create($laudo);

				if($data['error'] == ""){
					$id = $data['data']['cd_laudo'];

					/* pegando os dados do modelo  */
					$lm = new LaudoModelo(['id' => $laudo->getLaudoModelo()]);
					$lm = LaudoModeloDAO::find($lm)[0];

					unset($lm['cd_laudo_modelo']);
					unset($lm['nm_laudo_modelo']);
					unset($lm['laudo_modelo_cabecalho']);
					unset($lm['laudo_modelo_rodape']);
					unset($lm['ic_status']);

					foreach($lm as $key => $value){
						$li = new LaudoItem();
						$li->setLaudo($id);
						$li->setTitulo($key);
						$li->setStatus('ativo');
						$li->setConteudo($value);
						$li->setEditavel('');
						$li->setEstruturaModelo(1);

						LaudoDAO::create_item($li);
					}

					$li = new LaudoItem(['LaudoModelo' => $laudo->getLaudoModelo()]);
					$li->setStatus('ativo');

					$LaudoModeloItens = LaudoModeloDAO::find_itens($li);

					$LaudoModeloItens = $this->orderItemTitles($LaudoModeloItens);

					//cadastra titulos
					foreach($LaudoModeloItens as $key => $item){
						$li = new LaudoItem();
						$li->setLaudo($id);
						$li->setTitulo($item['ds_titulo']);
						$li->setStatus($item['ic_status']);
						$li->setConteudo($item['ds_conteudo']);
						$li->setEditavel($item['ic_editavel']);
						$li->setIndice($item['indice']);
						$li->setParent('');

						$res_titulo = LaudoDAO::create_item($li);

						//cadastra subtitulo nivel 1
						if($res_titulo['error'] == "" && isset($item['child']) && is_array($item['child'])){
							foreach($item['child'] as $k1 => $sub1){
								$li = new LaudoItem();
								$li->setLaudo($id);
								$li->setTitulo($sub1['ds_titulo']);
								$li->setStatus($sub1['ic_status']);
								$li->setConteudo($sub1['ds_conteudo']);
								$li->setEditavel($sub1['ic_editavel']);
								$li->setIndice($sub1['indice']);
								$li->setParent($res_titulo['data']['cd_laudo_item']);

								$res_sub1 = LaudoDAO::create_item($li);

								//cadastra subtitulo nivel 1
								if($res_sub1['error'] == "" && isset($sub1['child']) && is_array($sub1['child'])){
									foreach($sub1['child'] as $k2 => $sub2){
										$li = new LaudoItem();
										$li->setLaudo($id);
										$li->setTitulo($sub2['ds_titulo']);
										$li->setStatus($sub2['ic_status']);
										$li->setConteudo($sub2['ds_conteudo']);
										$li->setEditavel($sub2['ic_editavel']);
										$li->setIndice($sub2['indice']);
										$li->setParent($res_sub1['data']['cd_laudo_item']);

										LaudoDAO::create_item($li);
									}	
								}
							}	
						}
					}

					$json['status'] = 1;
					$json['msg']  = "Laudo cadastrado com sucesso!\r\n";
					$json['msg'] .= "Iniciando passo de edição do modelo!";
					$json['id']   = $id;

				}else{
					$msg['msg'] = $data['error'];
				}

				echo json_encode($json);

			}else{

				$regiao = new Regiao;
				$regiao->setStatus('1');

				$estado = new Estado;
				$estado->setStatus(1);

				// $te = new Edificio();
				// $te->setStatus(1);

				$lm = new LaudoModelo(['status' => 'ativo']);

				$clientes = UsuarioDAO::listClientes(1);

				$cols = 'cd_usuario,nm_usuario';
				$eng  = UsuarioDAO::find(new Usuario(['id' => 2]), $cols);

				$eng2 = UsuarioDAO::listEngenheiros(1);

				if(is_array($eng2)) $eng = array_merge($eng, $eng2);

				$render = new ClassRender;
	            $render->setTitle("Novo Laudo");
	            $render->setMenu($_SESSION['prev_user_permissao']);

	            $render->list += ['modelos' => LaudoModeloDAO::find($lm,'nm_laudo_modelo')];
	            $render->list += ['engenheiros' => $eng];
	            $render->list += ['clientes' => $clientes];
	            $render->list += ['regioes' => RegiaoDAO::find($regiao,'nm_regiao')];
	            $render->list += ['estados' => EstadoDAO::find($estado)];
	            $render->setDir('laudo');
	            $render->setView('laudo/laudo');
	            $render->renderizar();
	        }
		}

		public function laudo($post,$get, $param){

			clearstatcache();

			$cd_laudo = $param[0];
			$name = '';

			$arrLaudo = LaudoDAO::find( new Laudo(['id' => $cd_laudo]) )[0];

			$arrVars = $this->get_campos_substituiveis(
				[
					'laudo' 	=> $arrLaudo,
					'cliente' 	=> $arrLaudo['cd_cliente'],
					'engenheiro'=> $arrLaudo['cd_engenheiro']
				]
			);

			$json['status'] = '';

			if(isset($post) && count($post) > 0 ){

				foreach($post as $key => $value){
					if(substr($key,0,10) == 'laudo_item') $name = $key;
				}

				$conteudo = $post[$name];

				$name 	 = explode('_',$name);
				$cd_item = $name[3];
				$indice  = $name[2] - 1;

				if(!isset($_SESSION['laudo_itens_processados_'.$cd_laudo])){
					$_SESSION['laudo_itens_processados_'.$cd_laudo] = array();
				}

				$_SESSION['laudo_itens_'.$cd_laudo][$indice]['ds_conteudo'] = $conteudo;

				$conteudo  = str_replace($arrVars['de'],$arrVars['para'], $conteudo);

				$_SESSION['laudo_itens_processados_'.$cd_laudo][$indice]['ds_conteudo'] = $conteudo;
				
				$arrIdItens = [];

				foreach($_SESSION['laudo_itens_processados_'.$cd_laudo] as $indice => $item){
					if(isset($item['cd_laudo_item'])){
						$arrIdItens[] = $item['cd_laudo_item'];	
					}					
				}

				$this->salva_laudo_anexos($arrIdItens);
			}

			if(isset($_FILES['art'])){
				$this->salvar_laudo_anexos_art($cd_laudo);
			}

			if(isset($param[1]) && $param[1] == "salvar"){
				$this->salvar_laudo($cd_laudo);
				$res = $this->gerar_laudo_pdf($cd_laudo);
				
				if($res === 1){
					$json['status'] = '1';
					$json['msg'] = 'PDF gerado com sucesso!';
				}else if($res == 2){
					$json['status'] = '2';
					$json['msg'] = 'Erro: O PDF do certificado não está formatado corretamente';
				}else if($res == 3){
					$json['status'] = '3';
					$json['msg'] = 'Erro: O PDF do ART não está formatado corretamente';
				}else{
					$json['status'] = '0';
					$json['msg'] = 'Erro: não foi possivel gerar o PDF!';
				}
			}

			/* carregando informacoes pra VIEW */
			$laudo = new Laudo();
			$laudo->setId($cd_laudo);

			if(!isset($_SESSION['laudo_itens_'.$cd_laudo]) || true){

				$itens = [];

				$capa = LaudoDAO::get_estrutura_capa($laudo);
				$prefacio = LaudoDAO::get_estrutura_texto($laudo);
				$prefacio['ds_titulo'] = "Prefacio";

				$campos = LaudoDAO::get_laudo_itens_by_indice($laudo);

				$itensOrdenados = $this->orderItemTitles($campos);

				$campos = [];

				foreach($itensOrdenados as $key => $titulo){

					$campos[] = $titulo;

					if(isset($titulo['child'])){
						foreach($titulo['child'] as $key2 => $sub1){

							$campos[] = $sub1;

							if(isset($sub1['child'])){
								foreach($sub1['child'] as $key3 => $sub2){
									$campos[] = $sub2;
								}	
							}
						}
					}
				}

				$itens[] = $capa;
				$itens[] = $prefacio;

				if(is_array($campos)){
					foreach($campos as $campo) {
						if(isset($campo['child']) ) unset($campo['child']);
						$itens[] = $campo;
					}
				}

				// echo "<pre>";
				// print_r($itens);
				// exit;

				$itens[] = array(
					'ds_titulo' => 'CERTIFICADO',
					'link' 		=> DIR_PAGE.'public/laudosPDF/cert.pdf',
					'file'		=> DIR_REQ.'public/laudosPDF/cert.pdf'
				);

				$itens[] = array(
					'ds_titulo' => 'ART',
					'link' 		=> DIR_PAGE.'public/laudosPDF/'.$param[0].'_art.pdf',
					'file'		=> DIR_REQ.'public/laudosPDF/'.$param[0].'_art.pdf'
				);

				$_SESSION['laudo_itens_'.$cd_laudo] = $itens;


				$_SESSION['laudo_itens_processados_'.$cd_laudo] = $this->str_replace_itens(
					$arrVars, $itens
				);

			}else{
				$itens = $_SESSION['laudo_itens_'.$cd_laudo];
			}

			// echo "<pre>";
			// print_r($itens);
			// exit;

			if(isset($param[1]) && is_numeric($param[1]) && $param[1] > 0 ){
				
				$nr_item = $param[1] - 1;
				$itens[$nr_item]['is_active'] = 1;

				if(isset($itens[$nr_item]['cd_laudo_item'])){
					$anexos = LaudoDAO::get_anexos_by_item($itens[$nr_item]['cd_laudo_item']);
					$itens[$nr_item]['anexos'] = $anexos;	
				}
			} 

			$laudo = LaudoDAO::find($laudo)[0];

			$modelo = new LaudoModelo(['id' => $laudo['cd_tipo_laudo']]);
			$modelo = LaudoModeloDAO::find($modelo)[0];

			$render = new ClassRender;
            $render->setTitle($modelo['nm_laudo_modelo']);
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->list += ['editar' 			=> $laudo];
            $render->list += ['itens'			=> $itens ];
            $render->list += ['actionStatus'	=> json_encode($json)];

            $render->setDir('laudo');
            $render->setView('laudo/editar_laudo');

            $render->list['load_scripts'] = ['editor'];

            $render->renderizar();
		}

		private function str_replace_itens($arr, $itens){
			
			foreach($itens as $key => $item){
				
				if($item['ds_titulo'] == "CERTIFICADO" || $item['ds_titulo'] == "ART"){
					continue;
				}

				$cont = str_replace($arr['de'],$arr['para'], $item['ds_conteudo']);
				$itens[$key]['ds_conteudo'] = $cont;
			}

			return $itens;
		}

		private function salvar_laudo($cd_laudo){
			$msg = 'Erro: nao foi possivel editar este Laudo';
			$json = ['status' => 0,'msg' => $msg];

			$sucesso = 1;
			$sql = "";

			if( is_array($_SESSION['laudo_itens_'.$cd_laudo]) ){
				foreach($_SESSION['laudo_itens_'.$cd_laudo] as $key => $value){
					
					$ds_titulo = $_SESSION['laudo_itens_'.$cd_laudo][$key]['ds_titulo'];

					if($ds_titulo == 'CERTIFICADO' || $ds_titulo == "ART") continue;

					if($sql != '' ) $sql .= ";";

					$sql .= "UPDATE laudo_item SET ";
					$sql .= " ds_conteudo = '".$value['ds_conteudo']."' ";
					$sql .= " WHERE cd_laudo_item = ".$value['cd_laudo_item'];
				}
			}

			if(!LaudoDAO::edit_laudo_item_multiples($sql)) $sucesso = 0;

			if($sucesso){
				$json['status'] = 1;
				$json['msg'] = "Laudo editado com sucesso!\r\n";
				$json['msg'] = "O PDF foi gerado com sucesso!";
			}
		}

		public function listar($post  = null){

			$filters = [
				'status' 		=> isset($_GET['ic_status'])? $_GET['ic_status']:false,
				'regiao' 		=> isset($_GET['cd_regiao'])? $_GET['cd_regiao']:false,
				'cliente'		=> isset($_GET['cd_cliente'])? $_GET['cd_cliente']:false,
				'modelo'		=> isset($_GET['cd_laudo_modelo'])? $_GET['cd_laudo_modelo']:false,
			];

			$laudo = $this->filterLaudo();

			if( isset($_SESSION['prev_user_regiao']) ){
				if($_SESSION['prev_user_regiao'] != 7 && $_SESSION['prev_user_regiao'] != "0"){
					$laudo->setRegiao($_SESSION['prev_user_regiao']);
				}
			}

			$arrLaudo = LaudoDAO::find($laudo);


			$regiao = new Regiao;
			$regiao->setStatus('1');

			$cliente = new Usuario(['grupo' => '6','active' => '1']);
			$colsCliente = "cd_usuario, nm_usuario";

			$lm = new LaudoModelo(['status' => 'ativo']);


			$render = new ClassRender;

            $render->setTitle('Listar Laudos');
            $render->setMenu($_SESSION['prev_user_permissao']);
            
            $render->list += ['laudos' => $arrLaudo];
            $render->list += ['regioes'   	=> RegiaoDAO::find($regiao)];
            $render->list += ['modelos' => LaudoModeloDAO::find($lm)];
            $render->list += ['clientes'  	=> UsuarioDAO::find($cliente,$colsCliente)];
            $render->list += ['filters'   	=> $filters];
            $render->list['load_scripts'] = [
            	'datatable'
            ];

            $render->setView('laudo/listar_laudos');
            $render->renderizar();

		}

		public function editar($post,$get, $param){

			$id_laudo = $param[0];

			unset($_SESSION['laudo_itens_'.$id_laudo]);
			unset($_SESSION['laudo_itens_processados_'.$id_laudo]);

			if(isset($post['editLaudo'])){

				$id_laudo = $post['id'];

				$msg 	= 'Erro: nao foi possivel editar este Laudo';
				$json 	= ['status' => 0,'msg' => $msg];

				$laudo 	= new Laudo($post);

				$dataLaudo = LaudoDAO::find($laudo)[0];

				if( $dataLaudo['cd_tipo_laudo'] != $laudo->getLaudoModelo() ){
					$this->alterarLaudoModelo($laudo);
				}

				if(LaudoDAO::edit($laudo)){
					$json['status'] = 1;
					$json['msg']  	= "Laudo atualizado com sucesso!\r\n";
					$json['msg']   .= "Iniciando passo de edição do modelo!";
					$json['id']   	= $id_laudo;

				}else{
					$msg['msg'] = $data['error'];
				}

				echo json_encode($json);
			}else{

				$laudo = new Laudo();
				$laudo->setId($id_laudo);

				$dataLaudo = LaudoDAO::find($laudo)[0];

				$cidade = new Cidade(['id' => $dataLaudo['cd_cidade']]);
				$cidade = CidadeDAO::find($cidade)[0];

				$dataLaudo['cd_estado'] = $cidade['cd_estado'];

				$regiao = new Regiao;
				$regiao->setStatus('1');

				$estado = new Estado;
				$estado->setStatus(1);

				$lm = new LaudoModelo(['status' => 'ativo']);

				$cols = 'cd_usuario,nm_usuario';
				$eng  = UsuarioDAO::find(new Usuario(['id' => 2]), $cols);

				$eng2 = UsuarioDAO::listEngenheiros(1);

				if(is_array($eng2)) $eng = array_merge($eng, $eng2);

				$render = new ClassRender;
	            $render->setTitle("Editar Laudo");
	            $render->setMenu($_SESSION['prev_user_permissao']);

	            $render->list += ['modelos' => LaudoModeloDAO::find($lm)];
	            $render->list += ['profissionais' => UsuarioDAO::listChefia(1)];
	            $render->list += ['engenheiros' => $eng];
	            $render->list += ['clientes' => UsuarioDAO::listClientes(1)];
	            $render->list += ['regioes' => RegiaoDAO::find($regiao)];
	            $render->list += ['estados' => EstadoDAO::find($estado)];
	            $render->list += ['editar' => $dataLaudo];
	            $render->setDir('laudo');
	            $render->setView('laudo/laudo');
	            $render->renderizar();
			}
		}

		public function alterarLaudoModelo($laudo){
			
			$id = $laudo->getId();

			LaudoDAO::remove_laudo_itens($laudo);

			/* pegando os dados do modelo*/
			$lm = new LaudoModelo(['id' => $laudo->getLaudoModelo() ]);
			$lm = LaudoModeloDAO::find($lm)[0];

			unset($lm['cd_laudo_modelo']);
			unset($lm['nm_laudo_modelo']);
			unset($lm['laudo_modelo_cabecalho']);
			unset($lm['laudo_modelo_rodape']);
			unset($lm['ic_status']);
			
			// pegando capa e prefacio
			foreach($lm as $key => $value){
				$li = new LaudoItem();
				$li->setLaudo($id);
				$li->setTitulo($key);
				$li->setStatus('ativo');
				$li->setConteudo($value);
				$li->setEditavel('');
				$li->setEstruturaModelo(1);
				LaudoDAO::create_item($li);
			}

			// pegando os itens do modelo do laudo
			$li = new LaudoItem(['LaudoModelo' => $laudo->getLaudoModelo()]);
			$li->setStatus('ativo');

			$LaudoModeloItens = LaudoModeloDAO::find_itens($li);

			foreach($LaudoModeloItens as $key => $item){
				$li = new LaudoItem();
				$li->setLaudo($id);
				$li->setTitulo($item['ds_titulo']);
				$li->setStatus($item['ic_status']);
				$li->setConteudo($item['ds_conteudo']);
				$li->setEditavel($item['ic_editavel']);
				$li->setIndice($item['indice']);

				LaudoDAO::create_item($li);
			}
		}

		public function excluir($post, $get, $param){

			$json = ['status' => 0, 
					 'msg' => 'Ops, nao foi possivel excluir este Laudo'];

			$laudo = new Laudo($post);

			if(LaudoDAO::remove($laudo)){
				$json['status'] = 1;
				$json['msg'] = "Laudo deletado com sucesso";
			}
			echo json_encode($json);
		}

		private function gerar_laudo_pdf($laudo_id){
			clearstatcache();

			/* pegando dados do laudo*/
			$laudo = new Laudo();
			$laudo->setId($laudo_id);
			$arrLaudo = LaudoDAO::find($laudo)[0];

			/* pegando o modelo do laudo*/
			$ml = new LaudoModelo(['id' => $arrLaudo['cd_tipo_laudo']]);
			$ml = LaudoModeloDAO::find($ml)[0];

			/* pegando os itens do laudo */
			$capa 	= $_SESSION['laudo_itens_processados_'.$laudo_id][0]['ds_conteudo'];
			$texto 	= $_SESSION['laudo_itens_processados_'.$laudo_id][1]['ds_conteudo'];

			$itens = [];

			// echo "<pre>";
			// print_r($_SESSION['laudo_itens_processados_'.$laudo_id]);
			// exit;
			
			foreach($_SESSION['laudo_itens_processados_'.$laudo_id] as $key => $item){
				if($key > 1) $itens[] = $item;
			}


			$header = $ml['laudo_modelo_cabecalho'];
			$footer = $ml['laudo_modelo_rodape'];

			$pdf = new GeradorLAUDOPDF();

			$pdf->Capa($capa);

			$pageNr = 4;

			$header2 = str_replace('{{page.nr}}', $pageNr, $header);
			
			$pdf->Texto($texto);

			$footer2 = str_replace('{{page.nr}}', $pageNr, $footer );

			$sumario = "<br><br><div style='text-align:center'><h1>Sumário</h1></div>";
			$sumario .= "<br><br><div style='margin-left:5%'>";

			$itensSumario = [];

			$sItens = $this->orderItemTitles($itens);

			$nivelTitulos = $this->get_titulos_nivel($sItens);

			$sumario .= $this->criar_sumario($sItens);

			// $sItens = $this->agrupa_conteudo($sItens);

			$sumario .= "</div>";

			$pdf->Header($header2);
			$pdf->Sumario($sumario);
			$pdf->Footer($footer2);

			// colocar numero nos titulos
			$nivel1 = '';
			$nivel2 = '';

			$c1 	= 0;
			$c2 	= 0;
			$c3 	= 0;

			// echo "<pre>";
			// print_r($_SESSION['laudo_itens_processados_'.$laudo_id]);
			// exit;
			
			foreach($itens as $key => $item){

				if(isset($item['cd_laudo_item'])){
					
					if(isset($item['parent']) && $item['parent'] > 0){

						if($item['parent'] == $nivel1){
							$c2++;
							$nr_indice = $c1.".".$c2.".";
							$nivel2 = $item['cd_laudo_item'];
							

						}else if($item['parent'] == $nivel2){
							$c3++;
							$nr_indice = $c1.".".$c2.".".$c3.'.';
						}
						
					}else{
						$nivel1 = $item['cd_laudo_item'];
						$c1++;
						$c2 = 0;
						$c3 = 0;
						$nr_indice = $c1.".";
					}

					$item['ds_titulo'] = $nr_indice." ".$item['ds_titulo'];	
				}
				
				$itens[$key] = $item;
			}

			// fim de colocar numero nos titulos

			$IgnoreAddPage = 1;

			$lastTitle1 = $itens[count($itens) - 1]['ds_titulo'];
			$lastTitle2 = $itens[count($itens) - 2]['ds_titulo'];

			if($lastTitle1 == "ART" || $lastTitle1 == "CERTIFICADO"){
				$IgnoreAddPage++;
			}

			if($lastTitle2 == "ART" || $lastTitle2 == "CERTIFICADO"){
				$IgnoreAddPage++;
			}

			$itens_atualizados_com_subitens = [];

			if(is_array($itens)){
				foreach($itens as $key => $item){

					$titulo = $item['ds_titulo'];

					if($titulo == 'CERTIFICADO' || $titulo == "ART") break;

					if($nivelTitulos[ $item['cd_laudo_item'] ] == 1){
						$titulo = str_replace('{{TITULO}}',$titulo, $ml['laudo_modelo_titulo']);	
					}else if($nivelTitulos[ $item['cd_laudo_item'] ] == 2){
						$titulo = str_replace('{{SUBTITULO}}',$titulo, $ml['laudo_modelo_subtitulo1']);
					}else if($nivelTitulos[ $item['cd_laudo_item'] ] == 3){
						$titulo = str_replace('{{SUBTITULO}}',$titulo, $ml['laudo_modelo_subtitulo2']);
					}else{
						$titulo = str_replace('{{TITULO}}',$titulo, $ml['laudo_modelo_titulo']);
					}

					$anexos_item = LaudoDAO::get_anexos_by_item($item['cd_laudo_item']);

					$anexos = $this->montar_anexos_pdf($anexos_item, $item);

					$conteudo = str_replace('{{ANEXOS}}',$anexos,$item['ds_conteudo']);

					$pdf->add_laudo_item($titulo, $conteudo);

					//se nao for certificado ou ART... (imagens)
					if($key < count($itens) - $IgnoreAddPage){
						
						//se o houver proximo indice E ele existir um PARENT
						if( isset($itens[($key+1)]) && isset($itens[($key+1)]['parent']) ){

							//se o parent do proximo item estiver vazio
							if(empty($itens[($key+1)]['parent'])){
								$pdf->AddPage();
							}
						}
					}
				}
			}

			if(file_exists(DIR_REQ.'public/laudosPDF/cert1.pdf')){
				$res = $pdf->addAnexo(DIR_REQ.'public/laudosPDF/cert1.pdf');
				if(!$res) return 2;
			}

			if(file_exists(DIR_REQ.'public/laudosPDF/cert2.pdf')){
				$res = $pdf->addAnexo(DIR_REQ.'public/laudosPDF/cert2.pdf');
				if(!$res) return 2;
			}

			if(file_exists(DIR_REQ.'public/laudosPDF/'.$laudo_id.'_art.pdf')){
				$res = $pdf->addAnexo(DIR_REQ.'public/laudosPDF/'.$laudo_id.'_art.pdf');
				if(!$res) return 3;	
			}


			
			$nome = date('d-m-y-h-i-s')."_L-".$laudo_id.'.pdf';
			
			$laudo = new Laudo();
			$laudo->setId($laudo_id);
			$laudo->setPDF($nome);
			LaudoDAO::edit($laudo);

			// $pdf->Output();

			try {
				$pdf->gerar($nome,REQ_LAUDO_PDF);
				
				if(file_exists(REQ_LAUDO_PDF.'/'.$arrLaudo['ds_path_laudo_pdf'])){
					unlink(REQ_LAUDO_PDF.'/'.$arrLaudo['ds_path_laudo_pdf']);
				}

				return 1;
			} catch (Exception $e) {
				return 0;
			}
		}

		private function substituir_campos_cliente_ano($laudo, $txt){
			$txt = $this->set_campos_basicos($txt);
			return $this->set_campos_cliente($laudo['cd_cliente'], $txt);
		}

		private function filterLaudo(){
			
			$status = $this->filter_exists('ic_status');
			$regiao = $this->filter_exists('cd_regiao');
			$cliente= $this->filter_exists('cd_cliente');
			$lm 	= $this->filter_exists('cd_laudo_modelo');
			
			return new Laudo(
				[
					'ic_status'			=> $status,
					'cd_regiao'			=> $regiao,
					'cd_cliente'		=> $cliente,
					'cd_laudo_modelo' 	=> $lm
				]
			);
		}

		private function filter_exists($filter){
			if(isset($_GET[$filter])){
				return addslashes($_GET[$filter]);
			}
			return null;
		}

		private function salvar_laudo_anexos_art($id_laudo){

			if(isset($_FILES['art']) && $_FILES['art']['name'] != ''){

				$fileName = $id_laudo."_art.pdf";
				$path = DIR_REQ.'public/laudosPDF/'.$fileName;

				if(file_exists($path)) unlink($path);

				move_uploaded_file($_FILES['art']['tmp_name'], $path);
			}
		}

		private function salvar_laudo_anexos($id_laudo, $type){
			$files = $this->reArrayFiles($_FILES[$type]);
			$filaInsert = [];

			foreach ($files as $key => $file) {
		
				$dir = DIR_PDFs.'laudo_anexos';
				if(!is_dir($dir)){
					mkdir($dir,0777);
				}else{
					chmod($dir,0777);
				}

				$dir = $dir."/".$id_laudo;

				if(!is_dir($dir)){
					mkdir($dir,0777);
				}

				$fileName = $type.'_'.date('h-i-s')."_".$file['name'];

				$path = $dir.'/'.$fileName;

				if (move_uploaded_file($file['tmp_name'], $path)) {
					$filaInsert[] = $fileName;
				}
		    }

		    if(count($filaInsert) > 0){
		    	LaudoDAO::remove_anexos($id_laudo,$type);

		    	foreach($filaInsert as $key => $file){
		    		LaudoDAO::add_anexo($id_laudo, $file,$type);
		    	}
		    }
		}

		private function reArrayFiles($file_post) {

		    $file_ary = array();
		    $file_count = count($file_post['name']);
		    $file_keys = array_keys($file_post);

		    for ($i=0; $i<$file_count; $i++) {
		        foreach ($file_keys as $key) {
		            $file_ary[$i][$key] = $file_post[$key][$i];
		        }
		    }

		    return $file_ary;
		}

		public function estrutura_anexo($data){
            $code = $data['code'];
            include DIR_VIEW.'laudo/estrutura_anexo.php';
		}

		public function salva_laudo_anexos($arrIdItens){
			
			foreach($_FILES as $input_name => $file){

				$anexo_data = [];
				
				$anexo_data['header'] = '';
				if(isset($_POST['header_'.$input_name])){
					$anexo_data['header'] = $_POST['header_'.$input_name];	
				}
				
				$anexo_data['footer'] = '';
				if(isset($_POST['footer_'.$input_name])){
					$anexo_data['footer'] = $_POST['footer_'.$input_name];	
				}
				
				if(substr($input_name,0,6) == 'anexo_' && $file['name'] != ''){

					$item_id = explode('_',$input_name)[1];

					$destino = DIR_REQ.'public/laudosPDF/anexo_items';

					if(!is_dir($destino)) mkdir($destino,0777);

					$destino .= '/'.$item_id;

					if(!is_dir($destino)) mkdir($destino,0777);

					$fileNameArr = explode('.',$file['name']);

					$extensao  = end($fileNameArr);

					$file['name'] = md5($file['name']).'.'.$extensao;

					$caminho = $destino.'/'.$file['name'];

					$anexo_data['item'] 	= $item_id;
					$anexo_data['file'] 	= $file['name'];
				}

				if(isset($_POST['id_'.$input_name]) && is_numeric($_POST['id_'.$input_name]) ){
					$anexo_data['id'] = $_POST['id_'.$input_name];
				}

				if( isset($anexo_data['id'])){

					$antigo = LaudoDAO::get_anexos_by_id($anexo_data['id']);

					if(isset($anexo_data['file'])){
						
						if(file_exists($destino.'/'.$antigo['nm_anexo'])){
							unlink($destino.'/'.$antigo['nm_anexo']);
						}

						if(move_uploaded_file($file['tmp_name'],$caminho)){

							if(in_array(strtolower($extensao),array('jpg','jpeg','png'))){
								$exif = @exif_read_data($caminho);
								$this->resize_img($caminho, $exif);
							}
						}
					
					}

					LaudoDAO::edit_laudo_item_anexo($anexo_data);

				}else if( isset($anexo_data['file']) ){

					if( move_uploaded_file($file['tmp_name'], $caminho) ){

						if(in_array(strtolower($extensao),array('jpg','jpeg'))){
							$exif = @exif_read_data($caminho);
							$this->resize_img($caminho, $exif);
						}
						
						$res = LaudoDAO::create_laudo_item_anexo($anexo_data);
						$this->add_item_id_anexo_indice($item_id,$res['data']['cd_laudo_item_anexo']);
					}					
				}
			}

			$this->define_anexos_indice($arrIdItens);
		}

		private function add_item_id_anexo_indice($itemId, $id){

			if(isset($_POST['indice_anexo_'.$itemId]) && is_array($_POST['indice_anexo_'.$itemId]) ){
				foreach($_POST['indice_anexo_'.$itemId] as $indice => $anexoId){
					if($anexoId == ""){
						$_POST['indice_anexo_'.$itemId][$indice] = $id;
						break;
					}
				}	
			}
		}

		private function define_anexos_indice($arrIdItens){
			
			$query = "";

			foreach($arrIdItens as $key => $itemId){
				
				if(isset($_POST['indice_anexo_'.$itemId]) && is_array($_POST['indice_anexo_'.$itemId]) ){
					foreach($_POST['indice_anexo_'.$itemId] as $indice => $anexoId){

						$query .= "UPDATE laudo_item_anexo SET indice = '".$indice."' ";
						$query .= "WHERE cd_laudo_item_anexo = ". $anexoId.";";

					}	
				}
			}

			LaudoDAO::set_anexo_item_indice($query);
		}

		private function _sanitizeString($str) {
			    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
			    $str = preg_replace('/[éèêë]/ui', 'e', $str);
			    $str = preg_replace('/[íìîï]/ui', 'i', $str);
			    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
			    $str = preg_replace('/[úùûü]/ui', 'u', $str);
			    $str = preg_replace('/[ç]/ui', 'c', $str);
			    // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
			    $str = preg_replace('/[^a-z0-9]/i', '_', $str);
			    $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
			    return $str;
			}

		private function montar_anexos_pdf($anexos, $item){

			

			$nrImagesForPage 	= 4;
			$pageContent 		= "";
			$conteudo 			= "";

			$MainDiv 			= file_get_contents(DIR_SRC.'Includes/laudo-anexo-template.php');

			if(is_array($anexos) && count($anexos) > 0){

				foreach($anexos as $key => $anexo){

					$cabecalho 	= "";
					$footer 	= "";

					$anexos_dir = DIR_REQ.'public/laudosPDF/anexo_items/';
					$img_src = $anexos_dir.$item['cd_laudo_item'].'/'.$anexo['nm_anexo'];

					if(!file_exists($img_src)){
						continue;
					}

					$anexoEstrutura		= file_get_contents(DIR_SRC.'Includes/anexo-template.php');

					/* colocando titulo caso seja metodologia */
					if($key < 9){
						$nr = '0'.($key+1);
					}else{
						$nr = $key+1;
					}

					$ds_titulo = strtolower($this->_sanitizeString($item['ds_titulo']));

					$base = "";

					if($ds_titulo == "medicoes_ohmicas" || $ds_titulo == "metodologia"){
						$base = "<b>Medição Ôhmica: Foto ".$nr."</b><br>";	
					}else if($ds_titulo == "relatorio_fotografico"){
						$base = "<b>FOTO ".$nr.": </b>";
					}

					/* montando cabecalho. */
					$c = explode("\r\n",$anexo['ds_cabecalho']);
					$cabecalho .= "<p style='text-align:justify;'>".$base;
					
					if(is_array($c)){
						foreach($c as $k1 => $t){
							if($k1 > 0) $cabecalho .= "<br>";
							$cabecalho .= $t;
						}
					}

					$cabecalho .= "</p>";

					$anexoEstrutura 	= str_replace('{{ANX.HEADER}}',$cabecalho, $anexoEstrutura);

					/* montando footer */
					$c = explode("\r\n",$anexo['ds_rodape']);
					$footer .= "<p style='text-align:justify;'>";
					if(is_array($c)){
						foreach($c as $k1 => $t){
							if($k1 > 0) $footer .= "<br>";
							$footer .= $t;
						}	
					}

					$footer .= "</p>";

					$anexoEstrutura 	= str_replace('{{ANX.FOOTER}}',$footer, $anexoEstrutura);
					$anexoEstrutura 	= str_replace('{{ANX.IMG}}',$img_src, $anexoEstrutura);

					$anexo = "";

					if($key%2 == 0)$anexo = "<tr>";

					$anexo .= "<td class='anx-main-td'>".$anexoEstrutura."</td>";

					if($key%2 == 1)$anexo .= "</tr>";

					if(!array_key_exists($key+1,$anexos) && $key%2 == 0){
						if($key%2 == 1)$anexo .= "<td class='anx-main-td' ></td></tr>";
					}

					$conteudo .= $anexo;
				}

				return str_replace('{{ANEXO}}',$conteudo, $MainDiv);
			}
		}

		public function remove_laudo_item_anexo($post,$get, $param){
			
			$anexo = LaudoDAO::get_anexos_by_id($param[0]);

			$destino = DIR_REQ.'public/laudosPDF/anexo_items';

			if(!is_dir($destino)) mkdir($destino,0777);

			$destino .= '/'.$anexo['cd_laudo_item'];

			if(!is_dir($destino)) mkdir($destino,0777);

			if(file_exists($destino.'/'.$anexo['nm_anexo'])){
				unlink($destino.'/'.$anexo['nm_anexo']);
			}

			LaudoDAO::remove_laudo_item_anexo($param[0]);
		}

		private function criar_sumario($itens){
			$sumario = "";

			$T = "&nbsp;";

			foreach($itens as $k1 => $titulo){

				$sumario .= ($k1 + 1).". ". $titulo['ds_titulo']."<br>";

				if(isset($titulo['child']) && is_array($titulo['child'])){
					
					foreach($titulo['child'] as $k2 => $sub1){

						$sumario .= $T.$T.$T.($k1 + 1).". ".($k2 + 1).". ".$sub1['ds_titulo']."<br>";

						if(isset($sub1['child']) && is_array($sub1['child'])){
					
							foreach($sub1['child'] as $k3 => $sub2){
								$sumario .= $T.$T.$T.$T.$T." ".($k1 + 1).". ".($k2 + 1).".";
								$sumario .= ($k3 + 1).". ".$sub2['ds_titulo']."<br>";
							}	
						}	
					}
				}
			}

			return $sumario;
		}

		private function get_titulos_nivel($titulos){
			$niveis = [];

			foreach($titulos as $k => $titulo){

				if(isset($titulo['cd_laudo_item'])){
					$niveis[ $titulo['cd_laudo_item'] ] = '1';
				}

				if(isset($titulo['child'])){
					foreach($titulo['child'] as $k1 => $sub1){
						$niveis[ $sub1['cd_laudo_item'] ] = '2';

						if(isset($sub1['child'])){
							foreach($sub1['child'] as $k2 => $sub2){
								$niveis[$sub2['cd_laudo_item']] = '3';
							}
						}
					}
				}
			}

			return $niveis;
		}


		public function infoapp($post = null){



			$arrLaudoApp = LaudoDAO::findinfoapp();

			$render = new ClassRender;

            $render->setTitle('Info App Laudo');
            $render->setMenu($_SESSION['prev_user_permissao']);

			$render->list = ['infoapp' => $arrLaudoApp];

            $render->setView('laudo/info_app');
            $render->renderizar();

			//https://orangepmm.com.br/v2/Painel/laudo/infoapp

		}

	}