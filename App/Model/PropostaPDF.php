<?php
	namespace App\Model;

	use App\Model\Model;
	use App\Model\Proposta;

	class PropostaPDF extends Model {

		private $proposta;
		private $path;
		private $dtRegistro;
		private $status;

		public function __construct($data = null){
			if(is_array($data)){

				if(isset($data['id'])){ $this->setId($data['id']); }
				if(isset($data['proposta'])) 
					$this->setProposta(new Proposta(['id' => $data['proposta'] ]));
				if(isset($data['path'])) $this->setPath($data['path']);
				if(isset($data['dtRegistro'])) $this->setDtRegistro($data['dtRegistro']);
				if(isset($data['status'])) $this->setStatus($data['status']);
			}
		}

		public function getProposta(){ return $this->proposta; }
		public function setProposta(Proposta $p){ $this->proposta = $p; }

		public function getPath(){ return $this->path; }
		public function setPath($p){ $this->path = $p; }

		public function getDtRegistro(){ return $this->dtRegistro; }
		public function setDtRegistro($dt){ $this->dtRegistro = $dt; }

		public function getStatus(){ return $this->status; }
		public function setStatus($s){ $this->status = $s; }

	}