<?php 
	namespace App\Model;

	use App\Model\Model;

	class Area extends Model {

		private $titulo;
		private $subtitulo;
		private $status;
		private $conteudo;

		public function __construct($data = null){

			if(is_array($data)){
				isset($data['id'])? $this->setId($data['id']) : false;
				isset($data['titulo'])? $this->setTitulo($data['titulo']) : false;
				isset($data['status'])? $this->setStatus($data['status']) : false;
				isset($data['conteudo'])? $this->setConteudo($data['conteudo']) : false;
				isset($data['subtitulo'])? $this->setSubTitulo($data['subtitulo']) : false;
			}

		}

		public function getTitulo(){ return $this->titulo; }
		public function setTitulo($titulo){ $this->titulo = $titulo; }

		public function getSubTitulo(){ return $this->subtitulo; }
		public function setSubTitulo($subtitulo){ $this->subtitulo = $subtitulo; }

		public function getStatus(){ return $this->status; }
		public function setStatus($status){ $this->status = $status; }

		public function getConteudo(){ return $this->conteudo; }
		public function setConteudo($conteudo){ $this->conteudo = $conteudo; }
	}