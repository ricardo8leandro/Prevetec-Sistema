<?php
	namespace App\Model;

	class LaudoModelo extends Model {

		private $nome;
		private $capa;
		private $texto;
		private $status;
		private $cabecalho;
		private $rodape;

		private $titulo;
		private $subtitulo1;
		private $subtitulo2;

		public function __construct($data = []){
			if(isset($data['id'])) $this->setId($data['id']);
			if(isset($data['nome'])) $this->setNome($data['nome']);
			if(isset($data['capa'])) $this->setCapa($data['capa']);
			if(isset($data['texto'])) $this->setTexto($data['texto']);
			if(isset($data['status'])) $this->setStatus($data['status']);
			if(isset($data['cabecalho'])) $this->setCabecalho($data['cabecalho']);
			if(isset($data['rodape'])) $this->setRodape($data['rodape']);

			if(isset($data['titulo'])) $this->setTitulo($data['titulo']);
			if(isset($data['subtitulo1'])) $this->setSubtitulo1($data['subtitulo1']);
			if(isset($data['subtitulo2'])) $this->setSubtitulo2($data['subtitulo2']);
		}

		public function getNome(){ return $this->nome; }
		public function setNome($nm){ $this->nome = $nm; }

		public function getCapa(){ return $this->capa; }
		public function setCapa($nm){ $this->capa = $nm; }

		public function getTexto(){ return $this->texto; }
		public function setTexto($nm){ $this->texto = $nm; }

		public function getStatus(){ return $this->status; }
		public function setStatus($s){ $this->status = $s; }

		public function getCabecalho(){ return $this->cabecalho; }
		public function setCabecalho($cb){ $this->cabecalho = $cb; }

		public function getRodape(){ return $this->rodape; }
		public function setRodape($rdp){ $this->rodape = $rdp; }

		public function getTitulo(){ return $this->titulo; }
		public function setTitulo($titulo){ $this->titulo = $titulo; }

		public function getSubtitulo1(){ return $this->subtitulo1; }
		public function setSubtitulo1($subtitulo1){ $this->subtitulo1 = $subtitulo1; }

		public function getSubtitulo2(){ return $this->subtitulo2; }
		public function setSubtitulo2($subtitulo2){ $this->subtitulo2 = $subtitulo2; }
	}