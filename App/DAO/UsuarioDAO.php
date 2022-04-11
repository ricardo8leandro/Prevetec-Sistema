<?php 

	namespace App\DAO;



	use App\DAO\DAO;

	use App\Model\Usuario;



	class UsuarioDAO extends DAO {



		static public function create(Usuario $usuario){



			$cols  = "cd_grupo, cd_chefia, cd_regiao, cd_cargo, cd_cidade,";

			$cols .= "ic_usuario,nm_usuario, nm_email, cd_senha,";

			$cols .= "ds_telefone, ds_celular, cd_cpf, cd_cnpj, dt_nascimento,";

			$cols .= "ds_endereco, nm_bairro, cd_cep, ds_crea, ds_foto_crea,";

			$cols .= "nm_responsavel, cd_inscricao_estadual, ds_material, dt_login,";

			$cols .= "cd_ip, updated_at, created_at, ";

			$cols .= "cd_ctps, cd_serie_ctps, cd_titulo_eleitor, ds_zona_eleitoral";



			$chefia = 'NULL';

			if(!empty($usuario->getChefia())){

				$chefia = $usuario->getChefia();

			}





			if(empty($usuario->getCPF())){

				$valsCPF = ",NULL";

			}else{

				$valsCPF = ",'".$usuario->getCPF()."' ";

			}



			if(empty($usuario->getCNPJ()) ){

				$valsCNPJ = ",NULL";

			}else{

				$valsCNPJ = ",'".$usuario->getCNPJ()."' ";

			}



			$vals  = "'".$usuario->getGrupo()."'";

			$vals .= ",'".$chefia."' ";

			$vals .= ",'".$usuario->getRegiao()."' ";

			$vals .= ",'".$usuario->getCargo()."' ";

			$vals .= ",'".$usuario->getCidade()."'";

			$vals .= ",'".$usuario->getStatus()."'";

			$vals .= ",'".$usuario->getNome()."'";

			$vals .= ",'".$usuario->getEmail()."'";

			// $vals .= ",NULL ";

			$vals .= ",'".$usuario->getSenha()."'";

			$vals .= ",'".$usuario->getTelefone()."' ";

			$vals .= ",'".$usuario->getCelular()."' ";

			$vals .= $valsCPF;

			$vals .= $valsCNPJ;

			// $vals .= ",'".$usuario->getRG()."' ";

			$vals .= ",'".$usuario->getDtNascimento()."' ";

			$vals .= ",'".$usuario->getEndereco()."' ";

			$vals .= ",'".$usuario->getBairro()."' ";

			$vals .= ",'".$usuario->getCEP()."' ";

			// $vals .= ",'".$usuario->getDtRegistro()."' ";

			$vals .= ",'".$usuario->getCREA()."' ";

			$vals .= ",'".$usuario->getFotoCREA()."' ";

			$vals .= ",'".$usuario->getResponsavel()."' ";

			$vals .= ",'".$usuario->getInscricaoEstadual()."' ";

			$vals .= ",'".$usuario->getMaterial()."' ";

			$vals .= ",'".$usuario->getDtLogin()."' ";

			$vals .= ",'".$usuario->getIP()."' ";

			$vals .= ",'".$usuario->getUpdatedAt()."'";

			$vals .= ",'".$usuario->getCreatedAt()."'";

			$vals .= ",'".$usuario->getCTPS()."' ";

			$vals .= ",'".$usuario->getSerieCTPS()."' ";

			$vals .= ",'".$usuario->getTituloEleitor()."' ";

			$vals .= ",'".$usuario->getZonaEleitoral()."' ";



			return parent::insert('usuario',$cols,$vals);

		}



		static public function find(Usuario $usuario = null, $cols = "cd_usuario" ,$join = null, 

			$order = null, $limit = false){



			$where = "cd_usuario > 0 ";



			if(!empty($usuario)){

				

				if(!empty($usuario->getId())){

					$where .= " AND cd_usuario = '".$usuario->getId()."' ";

				}



				if(!empty($usuario->getEmail())){

					$where .= " AND nm_email = '".$usuario->getEmail()."' ";

				}



				if(!empty($usuario->getSenha())){

					$where .= " AND cd_senha = '".$usuario->getSenha()."' ";

				}



				if( !empty($usuario->getStatus()) ){

					$where .= " AND ic_usuario = '".$usuario->getStatus()."' ";

				}



				if( !empty($usuario->getGrupo()) ){

					$where .= " AND usuario.cd_grupo = '".$usuario->getGrupo()."' ";	

				}



				if(!empty($usuario->getAuth())){

					$where .= " AND cd_auth = '".$usuario->getAuth()."' ";

				}



				$status = $usuario->getStatus();

				if($status != '' && $status != null){

					$where .= " AND usuario.ic_usuario = '{$usuario->getStatus()}' ";

				}



				if(!empty($usuario->getCargo())){

					$where .= " AND usuario.cd_cargo = '".$usuario->getCargo()."' ";

				}



				if(!empty($usuario->getNome())){

					$where .= " AND usuario.nm_usuario LIKE '".$usuario->getNome()."%' ";

				}



				if(!empty($usuario->getEstado())){

					$where .= " AND estado.cd_estado = '".$usuario->getEstado()."' ";

				}



				if(!empty($usuario->getRegiao())){

					$where .= " AND usuario.cd_regiao = '".$usuario->getRegiao()."' ";

				}



				if(!empty($usuario->getCdRecuperarSenha())){

					$where .= " AND usuario.cd_recuperar_senha = '".$usuario->getCdRecuperarSenha()."' ";

				}

			}



			/**

			 *	@method Select(tabela, colunas, join, where, order, limit)

			 */

			return parent::Select('usuario',$cols, $join,$where,$order,$limit);

		}



		static public function validaLogin(Usuario $usuario){

			$cols = "cd_usuario, cd_grupo, nm_usuario, nm_email, cd_auth,cd_regiao";

			$usuario->setStatus('1');

			$res = null;

			if($usuario->getEmail() != ""){
				$res = self::find($usuario, $cols);
			}

			if(is_array($res) && count($res) > 0){

				$res = $res[0];

				$auth = md5(date('Ymdhsi')).".".md5($res['nm_email']);



				$usuario->setAuth($auth);

				$usuario->setId($res['cd_usuario']);

				if(self::edit($usuario)){

					$res['cd_auth'] = $auth;

					return $res;

				}

			}

		}

		//valida se a hash da session existe no DB

		static public function validate(Usuario $usuario){

			if(is_array(self::find($usuario,'cd_auth',false,false,1))){

				return true;

			}

		}



		static public function edit(Usuario $usuario){

			$update = " cd_usuario = {$usuario->getId()} ";

			//=================================================

			$chefia = 'NULL';

			if(!empty($usuario->getChefia())){
				$chefia = $usuario->getChefia();
			}

			if(empty($usuario->getCPF())){
				$cpf = "NULL";
			}else{
				$cpf = " '".$usuario->getCPF()."' ";
			}

			if(empty($usuario->getCNPJ()) ){
				$cnpj = "NULL";
			}else{
				$cnpj = "'".$usuario->getCNPJ()."' ";
			}

			//==================================================

			$update .= ", cd_chefia = ".$chefia;
			$update .= ", cd_cpf = ".$cpf;
			$update .= ", cd_cnpj = ".$cnpj;

			
			if(!empty($usuario->getGrupo())){
				$update .= ", cd_grupo = '".$usuario->getGrupo()."' ";
			}

			if(!empty($usuario->getRegiao())){
				$update .= ", cd_regiao = '".$usuario->getRegiao()."' ";
			}

			if(!empty($usuario->getCargo())){
				$update .= ", cd_cargo = '".$usuario->getCargo()."' ";
			}

			if(!empty($usuario->getCidade())){
				$update .= ", cd_cidade = '".$usuario->getCidade()."' ";
			}

			if(!empty($usuario->getStatus())){
				$update .= ", ic_usuario = '".$usuario->getStatus()."' ";
			}

			if(!empty($usuario->getNome())){
				$update .= ", nm_usuario = '".$usuario->getNome()."' ";
			}

			if(!empty($usuario->getEmail())){
				$update .= ", nm_email = '".$usuario->getEmail()."' ";
			}

			if(!empty($usuario->getSenha())){
				$update .= ", cd_senha = '".$usuario->getSenha()."' ";
			}

			if(!empty($usuario->getTelefone())){
				$update .= ", ds_telefone = '".$usuario->getTelefone()."' ";
			}


			if(!empty($usuario->getCelular())){
				$update .= ", ds_celular = '".$usuario->getCelular()."' ";
			}

			if(!empty($usuario->getEndereco())){
				$update .= ", ds_endereco = '".$usuario->getEndereco()."' ";
			}



			if(!empty($usuario->getBairro())){
				$update .= ", nm_bairro = '".$usuario->getBairro()."' ";
			}

			if(!empty($usuario->getCEP())){
				$update .= ", cd_cep = '".$usuario->getCEP()."' ";
			}

			if(!empty($usuario->getCREA())){
				$update .= ", ds_crea = '".$usuario->getCREA()."' ";
			}


			if(!empty($usuario->getResponsavel())){
				$update .= ", nm_responsavel = '".$usuario->getResponsavel()."' ";
			}

			if(!empty($usuario->getInscricaoEstadual())){
				$update .= ", cd_inscricao_estadual = '".$usuario->getInscricaoEstadual()."' ";
			}

			if(!empty($usuario->getMaterial())){
				$update .= ", ds_material = '".$usuario->getmaterial()."' ";
			}

			if(!empty($usuario->getDtLogin())){
				$update .= ", dt_login = '".$usuario->getDtLogin()."' ";
			}

			$cd_rec_pw = $usuario->getCdRecuperarSenha();

			if(!empty($cd_rec_pw) || $cd_rec_pw == ""){
				$update .= ", cd_recuperar_senha = '".$cd_rec_pw."' ";
			}

			if(!empty($usuario->getAuth())){
				$update .= ", cd_auth = '".$usuario->getAuth()."' ";
			}

			if(!empty($usuario->getIP())){
				$update .= ", cd_ip = '".$usuario->getIP()."' ";
			}

			if(!empty($usuario->getUpdatedAt())){
				$update .= ", updated_at = '".$usuario->getUpdatedAt()."' ";
			}

			if(!empty($usuario->getCreatedAt())){
				$update .= ", created_at = '".$usuario->getCreatedAt()."' ";
			}

			if(!empty($usuario->getCTPS())){
				$update .= ", cd_ctps = '".$usuario->getCTPS()."' ";
			}

			if(!empty($usuario->getSerieCTPS())){
				$update .= ", cd_serie_ctps = '".$usuario->getSerieCTPS()."' ";
			}

			if(!empty($usuario->getTituloEleitor())){
				$update .= ", cd_titulo_eleitor = '".$usuario->getTituloEleitor()."' ";
			}

			if(!empty($usuario->getZonaEleitoral())){
				$update .= ", ds_zona_eleitoral = '".$usuario->getZonaEleitoral()."' ";
			}

			if(!empty($usuario->getStatus())){
				$update .= ", ic_usuario = '".$usuario->getStatus()."' ";
			}

			$where = " cd_usuario = {$usuario->getId()} ";

			return parent::Update('usuario',$update,$where);
		}



		static public function listChefia(){

			$cols 	= " cd_usuario, nm_usuario ";

			$join  	= " JOIN grupo ON grupo.cd_grupo = usuario.cd_grupo ";

			$where  = "ic_usuario = '1' AND nm_grupo <> 'Clientes'";

			$where .= " AND nm_grupo <> 'Fornecedores'";



			$order = 'nm_usuario';



			return parent::Select('usuario',$cols,$join,$where,$order);

		}



		static public function listEngenheiros($ativo = false){

			$cols =  " cd_usuario, nm_usuario ";

			$join =  " JOIN grupo ON grupo.cd_grupo = usuario.cd_grupo ";

			

			$where = "cd_usuario > 0 ";

			if($ativo){$where .= "AND usuario.ic_usuario = '1' "; }

			$where .= " AND usuario.cd_grupo = '11' ";



			$order = 'nm_usuario';



			return parent::Select('usuario',$cols,$join,$where,$order);

		}



		static public function listClientes($ativo = false){

			$cols =  " cd_usuario, nm_usuario ";

			$join =  " JOIN grupo ON grupo.cd_grupo = usuario.cd_grupo ";

			

			$where = "";

			if($ativo){$where = "ic_usuario = '1' "; }

			$where .= "AND nm_grupo = 'Clientes' ";



			$order = 'nm_usuario';



			return parent::Select('usuario',$cols,$join,$where,$order);

		}



		static public function remove(Usuario $usuario){



			if(!empty($usuario->getId())){

				$where = "cd_usuario = '".$usuario->getId()."' ";

				return parent::delete('usuario',$where);	

			}

		}



		static public function reset_password_request(Usuario $user){

			return self::edit($user);

		}



		static public function verify_request_password_code(Usuario $user){

			return self::find($user);

		}



		static public function redefine_pw(Usuario $user){

			$a_user = new Usuario();

			$a_user->setId($user->getId());

			$a_user->SetCdRecuperarSenha($user->getCdRecuperarSenha());



			$res = self::find($a_user);



			if(is_array($res) && count($res) > 0){

				$user->setCdRecuperarSenha('');

				return self::edit($user);

			}

		}

		static public function email_exists($email){
			$user = new Usuario(['email' => $email]);
			$res = self::find($user);
			if(is_array($res) && count($res) > 0) return 1;
		}

	}