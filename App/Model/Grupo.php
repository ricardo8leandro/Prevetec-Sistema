<?php 
	namespace App\Model;

	use App\Model\Model;

	class Grupo extends Model {
		private $nome;
		private $status; // 0 || 1
		private $profissional; // sim || nao
		private $descricao;
		private $created_at;
		private $updated_at;

		public function __construct($data = null ){
			if(isset($data['id']) && is_numeric($data['id'])){
				$this->setId($data['id']);
			}
			isset($data['nome'])?$this->setNome($data['nome']):false;
			isset($data['status'])?$this->setStatus($data['status']):false;
			isset($data['profissional'])?$this->setProfissional($data['profissional']):false;
			isset($data['descricao'])?$this->setDescricao($data['descricao']):false;
			isset($data['created_at'])?$this->setCreatedAt($data['created_at']):false;
			isset($data['updated_at'])?$this->setUpdatedAt($data['updated_at']):false;
		}

		public function getNome(){ return $this->nome; }
		public function setNome($nome){ $this->nome = $nome; }

		public function getStatus(){ return $this->status; }
		public function setStatus($status){ $this->status = $status; }

		public function getProfissional(){ return $this->profissional; }
		public function setProfissional($p){ $this->profissional = $p; }

		public function getDescricao(){ return $this->descricao; }
		public function setDescricao($ds){ $this->descricao = $ds; }

		public function getCreatedAt(){ return $this->created_at; }
		public function setCreatedAt($dthr){ $this->created_at = $dthr; }

		public function getUpdatedAt(){ return $this->created_at; }
		public function setUpdatedAt($dthr){ $this->created_at = $dthr; }
	}