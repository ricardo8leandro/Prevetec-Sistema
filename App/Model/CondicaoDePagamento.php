<?php 
	namespace App\Model;

	use App\Model\Model;

	class CondicaoDePagamento extends Model {

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

		public function getTitulo(){ return $this->titulo; }
		public function setTitulo($titulo){ $this->titulo = $titulo; }

		public function getStatus(){ return $this->status; }
		public function setStatus($status){ $this->status = $status; }

		public function getConteudo(){ return $this->conteudo; }
		public function setConteudo($conteudo){ $this->conteudo = $conteudo; }
	}