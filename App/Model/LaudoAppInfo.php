<?php
	namespace App\Model;

	class LaudoAppInfo extends Model {

		private $laudoId;
		private $artCd;
		private $conformidade;
		private $laudoTp;
		private $descida;

		public function __construct($data = []){
			if(isset($data['id'])) $this->setId($data['id']);
			if(isset($data['laudoId'])) $this->setLaudoId($data['laudoId']);
			if(isset($data['artCd'])) $this->setArtCd($data['artCd']);
			if(isset($data['conformidade'])) $this->setConformidade($data['conformidade']);
			if(isset($data['laudoTp'])) $this->setLaudoTp($data['laudoTp']);
			if(isset($data['descida'])) $this->setDescida($data['descida']);
		}

		public function getLaudoId(){ return $this->laudoId; }
		public function setLaudoId($nm){ $this->laudoId = $nm; }

		public function getsetArtCd(){ return $this->artCd; }
		public function setsetArtCd($nm){ $this->artCd = $nm; }

		public function getConformidade(){ return $this->conformidade; }
		public function setConformidade($nm){ $this->conformidade = $nm; }

		public function getLaudoTp(){ return $this->laudoTp; }
		public function setLaudoTp($s){ $this->laudoTp = $s; }

		public function getDescida(){ return $this->descida; }
		public function setDescida($cb){ $this->descida = $cb; }

	}