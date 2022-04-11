<?php 
	namespace App\Model;

	use App\Model;
	use App\Laudo;

	class LaudoMedicao extends Model {

		private $laudo;
		private $foto1;
		private $foto2;
		private $obs;

		public function __construct($data = null){

			if(is_array($data)){
				isset($data['id'])?$this->setId($data['id']) : false;
				isset($data['foto1'])?$this->setFoto1($data['foto1']) : false;
				isset($data['foto2'])?$this->setFoto2($data['foto2']) : false;
				isset($data['obs'])?$this->setObs($data['obs']) : false;
			}
		}

		public function getFoto1(){ return $this->foto1; }
		public function setFoto1($ft){ 
			if( $this->validarFoto($ft) ){
				$this->foto1 = $ft;
			}
		}

		public function getFoto2(){ return $this->foto2; }
		public function setFoto2($ft){
			if( $this->validarFoto($ft) ){
				$this->foto2 = $ft;
			}	
		}

		public function getObs(){ return $this->obs; }
		public function setObs($obs){ $this->obs = $obs; }

		private function validarFoto($ft){
			
			$tiposAceitos = ['image/png','image/jpg','image/jpeg','image/gif'];
			
			if(isset($ft['size']) && isset($ft['type'])){
				if(in_array(strtolower($ft['type']), $tiposAceitos)){
					return true;
				}
			}
			return false;
		}
	}