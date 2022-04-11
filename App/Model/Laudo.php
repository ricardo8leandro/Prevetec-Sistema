<?php 
	namespace App\Model;

	use App\Model\Model;
	use App\Model\Usuario;
	use App\Model\TipoEdificio;
	use App\Model\Estado;
	use App\Model\Cidade;

	class Laudo extends Model {
		
		private $cd_laudo_modelo;
		private $cd_cliente;
		private $cd_profissional;
		private $cd_engenheiro;
		private $cd_cidade;
		private $cd_regiao;
		private $cd_tipo_edificio;
		
		private $dt_cadastro;
		private $dt_inspecao;
		private $ds_endereco;
		private $ds_bairro;
		private $cd_cep;
		private $dt_certificado;
		private $ds_path_laudo_pdf;
		private $ic_status;
		private $cd_art;

		private $items = [];

		public function __construct( $data = [] ){
			
			if(isset($data['id']))
				$this->setId($data['id']);

			if(isset($data['cd_laudo_modelo']))
				$this->setLaudoModelo($data['cd_laudo_modelo']);

			if(isset($data['cd_profissional']))	
				$this->setProfissional($data['cd_profissional']);

			if(isset($data['cd_cliente']))
				$this->setCliente($data['cd_cliente']);

			if(isset($data['cd_cidade']))
				$this->setCidade($data['cd_cidade']);

			if(isset($data['cd_regiao']))
				$this->setRegiao($data['cd_regiao']);

			if(isset($data['cd_tipo_edificio']))
				$this->setTipoEdificio($data['cd_tipo_edificio']);

			if(isset($data['cd_engenheiro']))
				$this->setEngenheiro($data['cd_engenheiro']);
			
			if(isset($data['dt_cadastro']))
				$this->setDtCadastro($data['dt_cadastro']);
			
			if(isset($data['dt_inspecao']))
				$this->setDtInspecao($data['dt_inspecao']);

			if(isset($data['ds_endereco']))
				$this->setEndereco($data['ds_endereco']);

			if(isset($data['ds_bairro']))
				$this->setBairro($data['ds_bairro']);

			if(isset($data['cd_cep']))
				$this->setCEP($data['cd_cep']);

			if(isset($data['dt_certificado']))
				$this->setDtCertificado($data['dt_certificado']);

			if(isset($data['ds_path_laudo_pdf']))
				$this->setPDF($data['ds_path_laudo_pdf']);

			if(isset($data['ic_status']))
				$this->setStatus($data['ic_status']);

			if(isset($data['items'])){
				$this->setItems($data['items']);				
			}

			if(isset($data['cd_art'])){
				$this->setCdArt($data['cd_art']);
			}
		}

		public function getLaudoModelo(){ return $this->cd_laudo_modelo; }
		public function setLaudoModelo($data){ $this->cd_laudo_modelo = $data; }

		public function getProfissional(){ return $this->cd_profissional; }
		public function setProfissional($data){ $this->cd_profissional = $data; }

		public function getCliente(){ return $this->cd_cliente; }
		public function setCliente($data){ $this->cd_cliente = $data; }

		public function getCidade(){ return $this->cd_cidade; }
		public function setCidade($data){ $this->cd_cidade = $data; }

		public function getRegiao(){ return $this->cd_regiao; }
		public function setRegiao($data){ $this->cd_regiao = $data; }

		public function getTipoEdificio(){ return $this->cd_tipo_edificio; }
		public function setTipoEdificio($data){ $this->cd_tipo_edificio = $data; }

		public function getEngenheiro(){ return $this->cd_engenheiro; }
		public function setEngenheiro($data){ $this->cd_engenheiro = $data; }

		public function getDtCadastro(){ return $this->dt_cadastro; }
		public function setDtCadastro($data){ $this->dt_cadastro = $data; }

		public function getDtInspecao(){ return $this->dt_inspecao; }
		public function setDtInspecao($data){ $this->dt_inspecao = $data; }

		public function getEndereco(){ return $this->ds_endereco; }
		public function setEndereco($data){ $this->ds_endereco = $data; }

		public function getBairro(){ return $this->ds_bairro; }
		public function setBairro($data){ $this->ds_bairro = $data; }

		public function getCEP(){ return $this->cd_cep; }
		public function setCEP($data){ $this->cd_cep = $data; }

		public function getDtCertificado(){ return $this->dt_certificado; }
		public function setDtCertificado($data){ $this->dt_certificado = $data; }

		public function getPDF(){ return $this->ds_path_laudo_pdf; }
		public function setPDF($data){ $this->ds_path_laudo_pdf = $data; }

		public function getStatus(){ return $this->ic_status; }
		public function setStatus($data){ $this->ic_status = $data; }

		public function getItems(){ return $this->items; }
		public function setItems($items){ $this->items = $items; }

		public function getCdArt(){ return $this->cd_art; }
		public function setCdArt($art){ $this->cd_art = $art; }
		
	}