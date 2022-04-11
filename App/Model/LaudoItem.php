<?php
	namespace App\Model;

	use App\Model\LaudoModelo;

	class LaudoItem extends Model {

		private $laudoModelo;
		private $laudo;
		private $titulo;
		private $conteudo;
		private $status;
		private $editavel;
		private $indice;
		private $em;
		private $parent;


		public function __construct($data = []){
			if(isset($data['id'])) $this->setId($data['id']);
			if(isset($data['LaudoModelo'])) $this->setLaudoModelo($data['LaudoModelo']);
			if(isset($data['laudo'])) $this->setLaudoModelo($data['laudo']);
			if(isset($data['titulo'])) $this->setTitulo($data['titulo']);
			if(isset($data['conteudo'])) $this->setConteudo($data['conteudo']);
			if(isset($data['status'])) $this->setStatus($data['status']);
			if(isset($data['editavel'])) $this->setEditavel($data['editavel']);
			if(isset($data['indice'])) $this->setIndice($data['indice']);
			if(isset($data['em'])) $this->setEstruturaModelo($data['em']);
			if(isset($data['parent'])) $this->setParent($data['parent']);

		}

		public function getLaudoModelo(){ return $this->laudoModelo; }
		public function setLaudoModelo($lm){ $this->laudoModelo = $lm; }

		public function getLaudo(){ return $this->laudo; }
		public function setLaudo($id){ $this->laudo = $id; }

		public function getTitulo(){ return $this->titulo; }
		public function setTitulo($nm){ $this->titulo = $nm; }

		public function getStatus(){ return $this->status; }
		public function setStatus($s){ $this->status = $s; }

		public function getConteudo(){ return $this->conteudo; }
		public function setConteudo($cb){ $this->conteudo = $cb; }

		public function getEditavel(){ return $this->editavel; }
		public function setEditavel($edt){ $this->editavel = $edt; }

		public function getIndice(){ return $this->indice; }
		public function setIndice($i){ $this->indice = $i; }

		public function getEstruturaModelo(){ return $this->em; }
		public function setEstruturaModelo($i){ $this->em = $i; }

		public function getParent(){ return $this->parent; }
		public function setParent($parent){ $this->parent = $parent; }
	}