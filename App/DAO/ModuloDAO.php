<?php
	namespace App\DAO;

	use App\DAO\DAO;

	class ModuloDAO extends DAO {

		static public function find($ativo = false){
			$where = " cd_modulo > 0 ";
			if(is_numeric($ativo)){ $where = "ic_modulo = '{$ativo}'"; }
			return parent::Select('modulo','*',false,$where);
		}
	}