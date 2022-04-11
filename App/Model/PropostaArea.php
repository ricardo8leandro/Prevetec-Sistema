<?php 
	namespace App\Model;

	use App\Model\Model;
	use App\Model\Area;
	use App\Model\Proposta;
	use App\Model\Anexo;

	class PropostaArea extends Model{

		private $area;
		private $proposta;
		private $anexo; // nivel
		private $indice;
		private $telhadoM;
		private $estruturaM;
		private $usaCTA;

		public function __construct($data = null){

			if(is_array($data)){
				if(isset($data['id']) && !empty($data['id'])) 
					$this->setId($data['id']);
				
				if(isset($data['area'])){
					$area = new Area(['id' => $data['area']]);
					$this->setArea($area);
				}

				if(isset($data['proposta'])){
					$p = new Proposta(['id' => $data['proposta']]);
					$this->setProposta($p);
				}

				if(isset($data['anexo'])){
					$anexo = new Anexo(['id' => $data['anexo']]);
					$this->setAnexo($anexo);
				}

				if(isset($data['indice'])) $this->setIndice($data['indice']);
				if(isset($data['telhado'])) $this->setTelhado($data['telhado']);
				if(isset($data['estrutura'])) $this->setEstrutura($data['estrutura']);
				if(isset($data['usaCTA'])) $this->setUsaCTA($data['usaCTA']);
			}
		}

		public function getArea(){ return $this->area; }
		public function setArea(Area $area){ $this->area = $area; }
		
		public function getProposta(){ return $this->proposta; }
		public function setProposta(Proposta $p){ $this->proposta = $p; }

		public function getAnexo(){ return $this->anexo; }
		public function setAnexo(Anexo $a){ $this->anexo = $a; }

		public function getIndice(){ return $this->indice; }
		public function setIndice($i){ $this->indice = $i; }

		public function getTelhado(){ return $this->telhadoM; }
		public function setTelhado($t){ $this->telhadoM = $t; }

		public function getEstrutura(){ return $this->estruturaM; }
		public function setEstrutura($e){ $this->estruturaM = $e; }

		public function getUsaCTA(){ return $this->usaCTA; }
		public function setUsaCTA($cta){ $this->usaCTA = $cta; }
	}