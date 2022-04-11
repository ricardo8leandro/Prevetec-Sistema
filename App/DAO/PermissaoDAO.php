<?php 
	namespace App\DAO;

	use App\DAO\DAO;

	use App\Model\Usuario;

	class PermissaoDAO extends DAO {

		static public function getPermissoes(Usuario $usuario = null, $id = null){
			$join = " JOIN modulo ON modulo.cd_modulo = grupo_modulo.cd_modulo ";
			$where = null;

			if(!empty($usuario) && is_numeric($usuario->getId())){
				
				$where = "cd_usuario = '".$usuario->getId()."'";
				$user = parent::Select('usuario','*',false,$where);

				if(is_array($user) && count($user) > 0){
					$where = "cd_grupo = '".$user[0]['cd_grupo']."' ";
				}

			}else if(is_numeric($id)){
				if(!empty($id)) $where = "cd_grupo = {$id} ";
			}

			if(!empty($where))
				return parent::Select('grupo_modulo','*',$join,$where);
		}

		static public function chat_permission($grupo_id){
			$join = " JOIN modulo ON modulo.cd_modulo = grupo_modulo.cd_modulo ";
			$where = null;

			$where = "cd_grupo = {$grupo_id} AND nivel_acesso = '1'";
			
			if(!empty($where)) return parent::Select('grupo_modulo','*',$join,$where);
		}

		static public function exists($grupo, $modulo){
			$where = "cd_grupo = '{$grupo}' AND cd_modulo = '{$modulo}' ";
			if(is_array(parent::Select('grupo_modulo','*',null,$where))){
				return true;
			}
		}

		static public function create($grupo, $modulo, $nivel){
			$cols = "cd_grupo_modulo, cd_grupo, cd_modulo, nivel_acesso";
			$vals = "NULL, '{$grupo}','{$modulo}','{$nivel}'";
			// echo $vals."\r\n";
			return parent::insert('grupo_modulo',$cols, $vals);
		}

		static public function edit($grupo, $modulo, $nivel){
			$set = "nivel_acesso = '{$nivel}' ";
			$where = "cd_grupo = '{$grupo}' AND cd_modulo = '{$modulo}' ";
			return parent::Update('grupo_modulo',$set,$where);
		}
	}