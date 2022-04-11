<?php 
	namespace App\Model;

	use App\Model\Model;
	use App\Model\Proposta;
	use App\Model\Area;
	use App\Model\PropostaArea;
	use App\Model\Servico;

	class PropostaAreaServico extends Model {

		private $servico;
		private $propostaArea;
		private $qtd;
		private $dimensao;
		private $obs;
		private $indice;

		public function __construct( $data = null){

			if(is_array($data)){
				if(isset($data['id']) && !empty($data['id']))
					$this->setId($data['id']);

				if(isset($data['servico'])){
					$this->setServico( new Servico( ['id' => $data['servico'] ]));
				}
				
				if(isset($data['propostaArea'])){
					$this->setPropostaArea(new PropostaArea(['id' => $data['propostaArea']]));
				}

				if(isset($data['qtd'])){ $this->setQtd($data['qtd']); }
				if(isset($data['dimensao'])){ $this->setDimensao($data['dimensao']); }
				if(isset($data['obs'])){ $this->setObs($data['obs']); }
				if(isset($data['indice'])){ $this->setIndice($data['indice']); }
			}
		}

		public function getServico(){ return $this->servico; }
		public function setServico(Servico $s){ $this->servico = $s; }

		public function getPropostaArea(){ return $this->propostaArea; }
		public function setPropostaArea(PropostaArea $p){ $this->propostaArea = $p; }

		public function getQtd(){ return $this->qtd; }
		public function setQtd($qtd){ $this->qtd = $qtd; }

		public function getDimensao(){ return $this->dimensao; }
		public function setDimensao($d){ $this->dimensao = $d; }

		public function getObs(){ return $this->obs; }
		public function setObs($obs){ $this->obs = $obs; }

		public function getIndice(){ return $this->indice; }
		public function setIndice($i){ $this->indice = $i; }
	}