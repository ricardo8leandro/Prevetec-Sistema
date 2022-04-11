<?php 
	namespace App\Model;

	use App\Model\Model;

	class Servico extends Model {

		private $titulo;
		private $telhadoM;
		private $estruturaM;
		private $usaCTA;
		private $status;
		private $conteudo;
		private $ignoreIDs;

		public function __construct($data = null){
			
			if(is_array($data)){
				isset($data['id'])? $this->setId($data['id']) : false;
				isset($data['titulo'])? $this->setTitulo($data['titulo']) : false;
				isset($data['telhadoM'])? $this->setTelhadoM($data['telhadoM']) : false;
				isset($data['estruturaM'])? $this->setEstruturaM($data['estruturaM']) : false;
				isset($data['usaCTA'])? $this->setUsaCTA($data['usaCTA']) : false;
				isset($data['status'])? $this->setStatus($data['status']) : false;
				isset($data['conteudo'])? $this->setConteudo($data['conteudo']) : false;
			}
		}

		public function getConfigPDF(){ return $this->configPDF; }
		public function setConfigPDF(ConfigPDF $cnfg){ $this->configPDF = $cnfg; }

		public function getTitulo(){ return $this->titulo; }
		public function setTitulo($titulo){ $this->titulo = $titulo; }

		public function getTelhadoM(){ return $this->telhadoM; }
		public function setTelhadoM(int $m){ $this->telhadoM = $m; }

		public function getEstruturaM(){ return $this->estruturaM; }
		public function setEstruturaM(int $m){ $this->estruturaM = $m; }

		public function getUsaCTA(){ return $this->usaCTA; }
		public function setUsaCTA(int $cta){ $this->usaCTA = $cta; }

		public function getStatus(){ return $this->status; }
		public function setStatus($status){ $this->status = $status; }

		public function getConteudo(){ return $this->conteudo; }
		public function setConteudo($conteudo){ $this->conteudo = $conteudo; }

		public function getIgnoredIds(){ return $this->ignoreIDs; }
		public function setIgnoredIds(int $id){ $this->ignoreIDs[] = $id; }
	}
