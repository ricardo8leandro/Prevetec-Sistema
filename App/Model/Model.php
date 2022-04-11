<?php 
	namespace App\Model;

	abstract class Model{
		private $id;

		public function getId(){ return $this->id; }
		public function setId(int $id){ $this->id = $id; }
	}