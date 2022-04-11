<?php 
	namespace App\Model;

	use App\Model\Model;

	class Chat extends Model {

		private $cliente;
		private $atendimento;
		private $historico = [];

		public function __construct($data = null){

			if(is_array($data)){
				isset($data['id'])? $this->setId($data['id']) : false;
				isset($data['cliente'])? $this->setTitulo($data['cliente']) : false;
				isset($data['atendimento'])? $this->setStatus($data['atendimento']) : false;
				isset($data['status'])? $this->setConteudo($data['status']) : false;
				isset($data['historico'])? $this->setConteudo($data['historico']) : false;
			}

		}

		public function getCliente(){ return $this->cliente; }
		public function setCliente($cliente){ $this->cliente = $cliente; }

		public function getAtendimento(){ return $this->atendimento; }
		public function setAtendimento($at){ $this->atendimento = $at; }

		public function getStatus(){ return $this->status; }
		public function setStatus($status){ $this->status = $status; }

		public function getHisorico(){ return $this->historico; }
		public function setHisorico($historico){ $this->historico = $historico; }
	}