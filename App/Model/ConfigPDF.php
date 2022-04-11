<?php 
	namespace App\Model;

	use App\Model\Model;

	class ConfigPDF extends Model {

		private $titulo;
		private $status;
		private $cabecalho;
		private $conteudo;
		private $rodape;

		public function __construct($data = null){

			if(is_array($data)){
				isset($data['id'])? $this->setId($data['id']) : false;
				isset($data['titulo'])? $this->setTitulo($data['titulo']) : false;
				isset($data['status'])? $this->setStatus($data['status']) : false;
				isset($data['cabecalho'])? $this->setCabecalho($data['cabecalho']) : false;
				isset($data['conteudo'])? $this->setConteudo($data['conteudo']) : false;
				isset($data['rodape'])? $this->setRodape($data['rodape']) : false;
			}
		}

		public function getTitulo(){ return $this->titulo; }
		public function setTitulo($titulo){ $this->titulo = $titulo; }

		public function getStatus(){ return $this->status; }
		public function setStatus($status){ $this->status = $status; }

		public function getCabecalho(){ return $this->cabecalho; }
		public function setCabecalho($cbc){ $this->cabecalho = $cbc; }
		
		public function getConteudo(){ return $this->conteudo; }
		public function setConteudo($conteudo){ $this->conteudo = $conteudo; }

		public function getRodape(){ return $this->rodape; }
		public function setRodape($rdp){ $this->rodape = $rdp; }
	}