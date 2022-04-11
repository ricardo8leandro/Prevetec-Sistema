<?php 
	namespace App\DAO;

	use App\DAO\DAO;
	use App\Model\Cidade;

	class CidadeDAO extends DAO {

		static public function find(Cidade $cidade){
			$where = "cd_cidade > 0 ";

			if(!empty($cidade->getId())){
				$where = "cd_cidade = {$cidade->getId()} ";
			}

			if(!empty($cidade->getNome())){
				$where .= " AND nm_cidade = '{$cidade->getNome()}' ";
			}

			if(!empty($cidade->getEstado())){
				$where .= " AND cd_estado = '{$cidade->getEstado()}' ";
			}

			if(!empty($cidade->getStatus())){
				$where .= " AND ic_cidade = '{$cidade->getStatus()}' ";
			}

			return parent::Select('cidade','*',false,$where,'nm_cidade');
		}
	}