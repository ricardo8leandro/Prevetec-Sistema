<?php
	namespace App\Model;

	use App\Model\Model;

	class Estado extends Model {

		private $nome;
		private $sigla;
		private $status;

		public function __construct($data = null){

			if(!empty($data) && is_array($data)){
				isset($data['id']) ? $this->setId($data['id']): false;
				isset($data['nome']) ? $this->setNome($data['nome']): false;
				isset($data['sigla']) ? $this->setSigla($data['sigla']): false;
				isset($data['status']) ? $this->setStatus($data['status']): false;
			}
			
		}

		public function getNome(){ return $this->nome; }
		public function setNome($nome){ $this->nome = $nome; }

		public function getSigla(){ return $this->sigla; }
		public function setSigla($sg){ $this->sigla = $sg; }

		public function getStatus(){ return $this->status; }
		public function setStatus($status){ $this->status = $status; }
	}