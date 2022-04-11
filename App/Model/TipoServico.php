<?php 
	namespace App\Model;

	use App\Model\Model;
	use App\Model\ConfigPDF;

	class TipoServico extends Model {

		//obj
		private $configPDF;

		private $titulo;
		private $status;
		private $conteudo;

		public function __construct($data = null){
			
			if(is_array($data)){
				isset($data['id'])? $this->setId($data['id']) : false;
				isset($data['titulo'])? $this->setTitulo($data['titulo']) : false;
				isset($data['status'])? $this->setStatus($data['status']) : false;
				isset($data['conteudo'])? $this->setConteudo($data['conteudo']) : false;
			}
		}

		public function getConfigPDF(){ return $this->configPDF; }
		public function setConfigPDF(ConfigPDF $cnfg){ $this->configPDF = $cnfg; }

		public function getTitulo(){ return $this->titulo; }
		public function setTitulo($titulo){ $this->titulo = $titulo; }

		public function getStatus(){ return $this->status; }
		public function setStatus($status){ $this->status = $status; }

		public function getConteudo(){ return $this->conteudo; }
		public function setConteudo($conteudo){ $this->conteudo = $conteudo; }	
	}
