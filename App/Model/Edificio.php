<?php 
	namespace App\Model;

	use App\Model\Model;

	class Edificio extends Model {

		private $nome;
		private $status;
		private $DAO;

		public function __construct( $data = null){
			if(is_array($data)){
				isset($data['id'])? $this->setId($data['id']) : false;
				isset($data['nome'])? $this->setNome($data['nome']) : false;
				isset($data['status'])? $this->setStatus($data['status']) : false;
			} 
		}

		public function getNome(){ return $this->nome; }
		public function setNome($nome){ $this->nome = $nome; }

		public function getStatus(){ return $this->status; }
		public function setStatus($status){ $this->status = $status; }
	}