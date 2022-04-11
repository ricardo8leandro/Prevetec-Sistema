<?php 
	namespace App\DAO;

	use App\DAO\DAO;
	use App\Model\Servico;

	class ServicoDAO extends DAO {

		static public function create(Servico $servico){

			$cols = "cd_servico, ds_titulo, ds_descricao, cd_situacao, lg_telhado_metalico,
					 lg_estrutura_metalica, lg_terminal_aereo";

			$vals = "NULL";
			$vals .= ",'".$servico->getTitulo()."' ";
			$vals .= ",'".$servico->getConteudo()."' ";
			$vals .= ",'".$servico->getStatus()."' ";
			$vals .= ",'".$servico->getTelhadoM()."' ";
			$vals .= ",'".$servico->getEstruturaM()."' ";
			$vals .= ",'".$servico->getUsaCTA()."' ";

			return parent::Insert('servico', $cols, $vals);
		}

		static public function find(Servico $servico,$order = false){
			
			$where = " cd_servico > 0 ";

			$telhadoM 	= $servico->getTelhadoM();
			$estruturaM = $servico->getEstruturaM();
			$usaCTA 	= $servico->getUsaCTA();

			if(!empty($servico->getId())) $where = " cd_servico = '{$servico->getId()}'";
			if(!empty($servico->getTitulo())) $where .= " AND ds_titulo = '{$servico->getTitulo()}'";
			if(!empty($servico->getStatus())) $where .= " AND cd_situacao = '{$servico->getStatus()}'";
			if(!empty($telhadoM)) $where .= " AND lg_telhado_metalico = '{$telhadoM}'";
			if(!empty($estruturaM)) $where .= " AND lg_estrutura_metalica = '{$estruturaM}'";
			if(!empty($usaCTA)) $where .= " AND lg_terminal_aereo = '{$usaCTA}'";

			return parent::Select('servico','*',false,$where,$order);
		}

		static public function find_in($where){
			return parent::Select('servico','*',false,$where);
		}

		static public function FilterIgnoredIds(Servico $servico,$order = false){
			
			$where = " cd_servico > 0 ";

			$telhadoM 	= $servico->getTelhadoM();
			$estruturaM = $servico->getEstruturaM();
			$usaCTA 	= $servico->getUsaCTA();

			$ids = $servico->getIgnoredIds();
			if(!empty($servico->getId())) $where = " cd_servico = '{$servico->getId()}'";

			for($i = 0; $i < count($ids); $i++ ){
				$where .= " AND cd_servico <> '{$ids[$i]}'";
			}

			
			if(!empty($servico->getTitulo())) $where .= " AND ds_titulo = '{$servico->getTitulo()}'";
			if(!empty($servico->getStatus())) $where .= " AND cd_situacao = '{$servico->getStatus()}'";
			if(!empty($telhadoM)) $where .= " AND lg_telhado_metalico = '{$telhadoM}'";
			if(!empty($estruturaM)) $where .= " AND lg_estrutura_metalica = '{$estruturaM}'";
			if(!empty($usaCTA)) $where .= " AND lg_terminal_aereo = '{$usaCTA}'";

			return parent::Select('servico','*',false,$where, $order);
		}

		static public function edit(Servico $servico){

			if(!empty($servico->getId())){

				$set = "cd_servico = '".$servico->getId()."' ";

				if(!empty($servico->getTitulo())) 
					$set .= ", ds_titulo = '".$servico->getTitulo()."' ";

				if(is_numeric($servico->getStatus()))
					$set .= ", cd_situacao = '".$servico->getStatus()."' ";

				if(!empty($servico->getConteudo()))
					$set .= ", ds_descricao = '".$servico->getConteudo()."' ";

				if(!empty($servico->getTelhadoM()))
					$set .= ", lg_telhado_metalico = '".$servico->getTelhadoM()."' ";

				if(!empty($servico->getEstruturaM()))
					$set .= ", lg_estrutura_metalica = '".$servico->getEstruturaM()."' ";

				if(!empty($servico->getUsaCTA()))
					$set .= ", lg_terminal_aereo = '".$servico->getUsaCTA()."' ";

				$where = "cd_servico = '".$servico->getId()."' ";

				return parent::Update('servico',$set,$where);
			}
		}

		static public function remove(Servico $servico){
			
			if(!empty($servico->getId())){
				$where = "cd_servico = '".$servico->getId()."' ";
				return parent::delete('servico',$where);	
			}
		}
	}