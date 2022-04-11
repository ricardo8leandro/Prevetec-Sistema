<?php
	namespace App\Model;

	use App\Model\Model;

	class Cidade extends Model{

		private $nome;
		private $estado;
		private $status;

		public function __construct($data = null){
			if(isset($data)  && is_array($data)){
				isset($data['id'])? $this->setId($data['id']) : false;
				isset($data['nome'])? $this->setNome($data['nome']) : false;
				isset($data['estado'])? $this->setEstado($data['estado']) : false;
				isset($data['status'])? $this->setStatus($data['status']) : false;
			}
		}

		public function getNome(){ return $this->nome; }
		public function setNome($nome){ $this->nome = $nome; }

		public function getEstado(){ return $this->estado; }
		public function setEstado($e){ $this->estado = $e; }

		public function getStatus(){ return $this->status; }
		public function setStatus($status){ $this->status = $status; }
	}