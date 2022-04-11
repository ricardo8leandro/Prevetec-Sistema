<?php 
	namespace Src\Traits;

	use App\Model\Usuario;
	use App\Model\Laudo;
	use App\Model\Edificio;
	use App\Model\Proposta;
	use App\Model\Documento;

	use App\DAO\UsuarioDAO;
	use App\DAO\LaudoDAO;
	use App\DAO\EdificioDAO;
	use App\DAO\PropostaDAO;
	use App\DAO\DocumentoDAO;

	trait TraitVariaveisPDF {

		private $pdf_documento 	= null;
		private $pdf_cliente 	= null;
		private $pdf_engenheiro = null;
		private $pdf_diretor 	= null;
		private $pdf_edificio 	= null;
		private $array_vars 	= ['de' => [], 'para' => [] ];

		private function get_columns(){
			
			$cols  = "nm_usuario, nm_email, ds_telefone, ds_celular, cd_cpf, cd_cnpj";
			$cols .= ",cd_rg, ds_endereco,nm_bairro, cd_cep, nm_responsavel,cidade.nm_cidade";
			$cols .= ",estado.sg_estado, estado.nm_estado, ds_crea";

			return $cols;
		}

		private function get_tables(){
			
			$join  = " LEFT JOIN cidade ON usuario.cd_cidade = cidade.cd_cidade";
			$join .= " LEFT JOIN estado ON estado.cd_estado = cidade.cd_estado";
			
			return $join;
		}

		public function get_campos_basicos(){

			$dia 		= date('d');
			$mesExtenso = $this->getMes(date('m'));
			$anoLongo 	= date('Y');

			$de = array(
				'{{DIA}}',
				"{{MES.EXTENSO}}",
				"{{ANO}}"
			);

			$para = array(
				$dia,
				$mesExtenso,
				$anoLongo
			);

			$this->array_vars['de']   += $de;
			$this->array_vars['para'] += $para;
		}

		public function get_campos_documento($doc_id){
			
			if(empty($this->pdf_documento)){
				$this->pdf_documento = DocumentoDAO::find(new Documento(['id' => $doc_id]))[0];	
			}

			$de = array('{{DOCUMENTO.DESCRICAO}}');
			$para = array($this->pdf_documento['ds_descricao']);

			$this->array_vars['de'] 	= array_merge($this->array_vars['de'],$de);
			$this->array_vars['para'] 	= array_merge($this->array_vars['para'],$para);
		}

		public function get_campos_proposta($prop){

			$de 	= array('{{PROPOSTA.CD}}');
			$para 	= array($prop['cd_proposta']);

			$this->array_vars['de']   = array_merge($this->array_vars['de'],$de);
			$this->array_vars['para'] = array_merge($this->array_vars['para'],$para);
		}

		public function get_campos_laudo($laudo){

			$de   = array(
				"{{LAUDO.DT_INSPECAO}}",
				"{{LAUDO.ART}}"
			);
			
			$para = array(
				date('d/m/Y',strtotime($laudo['dt_inspecao'])),
				$laudo['cd_art']
			);

			$this->array_vars['de']   = array_merge($this->array_vars['de'],$de);
			$this->array_vars['para'] = array_merge($this->array_vars['para'],$para);
		}

		public function get_campos_diretoria(){

			if(empty($this->pdf_diretor)){
				$this->pdf_diretor = UsuarioDAO::find(new Usuario(['id' => 2]),'cd_usuario, nm_usuario')[0];
			}

			$de = array(
				"{{DIRETOR.NOME}}"
			);

			$para = array(
				$this->pdf_diretor['nm_usuario']
			);
			
			$this->array_vars['de']   = array_merge($this->array_vars['de'],$de);
			$this->array_vars['para'] = array_merge($this->array_vars['para'],$para);
		}

		public function get_campos_cliente($id){

			if(empty($this->pdf_cliente)){
				$cliente = new Usuario(['id'=> $id]);
				$this->pdf_cliente = UsuarioDAO::find($cliente, $this->get_columns(),$this->get_tables())[0];	
			}

			if(!empty($this->pdf_cliente['cd_cpf'])){
				$doc = $this->pdf_cliente['cd_cpf'];
			}else{
				$doc = $this->pdf_cliente['cd_cnpj'];
			}

			$de = array(
				"{{CLIENTE.DOCUMENTO}}",
				"{{CLIENTE.EMPRESA}}",
				"{{CLIENTE.EMAIL}}",
				"{{CLIENTE.TELEFONE}}",
				"{{CLIENTE.CELULAR}}",
				"{{CLIENTE.ENDERECO}}",
				"{{CLIENTE.BAIRRO}}",
				"{{CLIENTE.CEP}}",
				"{{CLIENTE.RESPONSAVEL}}",
				"{{CLIENTE.CIDADE}}",
				"{{CLIENTE.ESTADO.SIGLA}}"
			);

			$para = array(
				$doc,
				$this->pdf_cliente['nm_usuario'],
				$this->pdf_cliente['nm_email'],
				$this->pdf_cliente['ds_telefone'],
				$this->pdf_cliente['ds_celular'],
				$this->pdf_cliente['ds_endereco'],
				$this->pdf_cliente['nm_bairro'],
				$this->pdf_cliente['cd_cep'],
				$this->pdf_cliente['nm_responsavel'],
				$this->pdf_cliente['nm_cidade'],
				$this->pdf_cliente['sg_estado']
			);

			$this->array_vars['de']   = array_merge($this->array_vars['de'],$de);
			$this->array_vars['para'] = array_merge($this->array_vars['para'],$para);
		}

		public function get_campos_engenheiro($id){

			if(empty($this->pdf_engenheiro)){
				$eng = new Usuario(['id'=> $id]);
				$this->pdf_engenheiro = UsuarioDAO::find($eng,$this->get_columns(),$this->get_tables())[0];
			}

			$de = array(
				"{{ENGENHEIRO.NOME}}",
				"{{ENGENHEIRO.CREA}}"
			);
			
			$para = array(
				$this->pdf_engenheiro['nm_usuario'],
				$this->pdf_engenheiro['ds_crea']
			);

			$this->array_vars['de']   = array_merge($this->array_vars['de'],$de);
			$this->array_vars['para'] = array_merge($this->array_vars['para'],$para);
		}

		public function get_campos_edificio($id){

			if(empty($this->pdf_edificio)){
				$this->pdf_edificio = EdificioDAO::find(new Edificio(['id' => $id]))[0];
			}

			$de = array(
				'{{TIPO_EDIFICIO.NOME}}'
			);

			$para = array(
				$this->pdf_edificio['ds_titulo']
			);

			$this->array_vars['de']   = array_merge($this->array_vars['de'],$de);
			$this->array_vars['para'] = array_merge($this->array_vars['para'],$para);
		}

		private function getMes($m){

			$mes = "";

			switch ($m) {
				case 1: $mes = "Janeiro"; break;
				case 2:	$mes = "Fevereiro"; break;
				case 3:	$mes = "Março"; break;
				case 4:	$mes = "Abril"; break;
				case 5:	$mes = "Maio"; break;
				case 6:	$mes = "Junho"; break;
				case 7:	$mes = "Julho"; break;
				case 8:	$mes = "Agosto"; break;
				case 9:	$mes = "Setembro"; break;
				case 10: $mes = "Outubro"; break;
				case 11: $mes = "Novembro"; break;
				case 12: $mes = "Dezembro"; break;
			}
			return $mes;
		}

		public function get_campos_substituiveis($data = []){
			
			$this->get_campos_basicos();

			if(isset($data['documento'])){
				$this->get_campos_documento($data['documento']);
			}

			if(isset($data['proposta'])){
				$this->get_campos_proposta($data['proposta']);
			}

			if(isset($data['laudo'])){
				$this->get_campos_laudo($data['laudo']);
			}

			$this->get_campos_diretoria();
			$this->get_campos_cliente($data['cliente']);

			if(isset($data['engenheiro'])){
				$this->get_campos_engenheiro($data['engenheiro']);
			}

			if(isset($data['edificio'])){
				$this->get_campos_edificio($data['edificio']);
			}

			return $this->array_vars;
		}
	}