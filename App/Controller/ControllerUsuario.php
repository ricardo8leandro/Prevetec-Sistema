<?php 

	namespace App\Controller;

	use App\Controller\Controller;

	use App\Model\Usuario;
	use App\Model\Grupo;
	use App\Model\Cargo;
	use App\Model\Regiao;
	use App\Model\Estado;
	use App\Model\Cidade;

	use App\DAO\UsuarioDAO;
	use App\DAO\GrupoDAO;
	use App\DAO\CidadeDAO;
	use App\DAO\EstadoDAO;
	use App\DAO\CargoDAO;
	use App\DAO\RegiaoDAO;

	use Src\Classes\ClassRender;
	use Src\Classes\SimpleEmail;

	class ControllerUsuario extends Controller {

		use \Src\Traits\TraitGetGruposECargos;

		public function listAll(){
			echo json_encode ( UsuarioDAO::find(null,'cd_usuario, nm_usuario') );
		}

		public function listar(){

			$cols   = 'cd_usuario, nm_usuario, nm_grupo, nm_cargo, ic_usuario, nm_email';
			$cols  .= ", cidade.*, regiao.* , estado.sg_estado";
			$join   = " JOIN grupo ON grupo.cd_grupo = usuario.cd_grupo ";
			$join  .= " LEFT JOIN cargo ON cargo.cd_cargo = usuario.cd_cargo ";
			$join  .= " LEFT JOIN cidade ON cidade.cd_cidade = usuario.cd_cidade ";
			$join  .= " LEFT JOIN estado ON estado.cd_estado = cidade.cd_estado ";
			$join  .= " LEFT JOIN regiao ON regiao.cd_regiao = usuario.cd_regiao ";

			$user   = $this->filterUsers();
			$res 	= UsuarioDAO::find($user,$cols,$join);

			$grupos = GrupoDAO::find(new Grupo(['status_grupo' => '1']));
			$cargos = CargoDAO::find(new Cargo(['ic_cargo' => '1']));

			if($user->getCargo() == "IS NULL"){
				$cargo_ativo = 'sem cargo';
			}else{
				$cargo_ativo = $user->getCargo();
			}



			$estado = 0;

			if(isset($_GET['estado'])){
				$estado = $_GET['estado'];
			}

			$filters = [
				'grupo'		=> $user->getGrupo(),
				'cargo'		=> $cargo_ativo,
				'status'	=> $user->getStatus(),
				'name'		=> $user->getNome(),
				'estado'    => $estado,
				'regiao'    => $user->getRegiao(),
				'cidade'	=> $user->getCidade(),
			];

			$regiao = new Regiao;
			$regiao->setStatus('1');

			$estado = new Estado;
			$estado->setStatus(1);

			$render = new ClassRender;
            $render->setTitle('Painel');
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->list['usuarios'] 	= $res;
            $render->list['grupos']		= $grupos;
            $render->list['cargos'] 	= $cargos;
            $render->list['regioes'] 	= RegiaoDAO::find($regiao);
	        $render->list['estados'] 	= EstadoDAO::find($estado);
            $render->list['filters']  	= $filters;
            $render->list['load_scripts'] = [
            	'datatable'
            ];

            $render->setView('usuario/listar');
            $render->renderizar();
		}

		public function novo($post = null){

			if(count($post) > 0){

				$json = ['status' => 0, 'msg' => 'Erro: não foi possivel cadastrar o usuario!'];
				$res = $this->validar_usuario($post);

				if($res != ""){
					$json['msg'] = $res;
				}else{

					$post['senha'] = '123';

					$usuario = new Usuario($post);

					$usuario->setUpdatedAt(date('Y-m-d h:i:s'));
					$usuario->setCreatedAt(date('Y-m-d h:i:s'));
					$res = UsuarioDAO::create($usuario);

					if( is_array($res) && $res['error'] == ""){
						$json['status'] = 1;
						$json['msg'] = 'Usuario cadastrado com sucesso!';
						$json['usuario'] = json_encode($res['data']);

						if($post['grupo'] != 6 && $post['grupo'] != 12){

							$json['msg'] .= "\r\nA senha da conta foi enviada para o email cadastrado";

							$this->enviar_senha($post['email'],$post['senha']);

						}

					}

				}

				echo json_encode($json);

			}else{

				$grupo = new Grupo;
				$grupo->setStatus('1');

				$cargo =  new Cargo;
				$cargo->setStatus('1');

				$regiao = new Regiao;
				$regiao->setStatus('1');

				$estado = new Estado;
				$estado->setStatus(1);

				$render = new ClassRender;
	            $render->setTitle('Novo usuario');
	            $render->setMenu($_SESSION['prev_user_permissao']);
	            $render->list += ['grupos' 	=> GrupoDAO::find($grupo)];
	            $render->list += ['cargos' 	=> CargoDAO::find($cargo)];
	            $render->list += ['chefias' => UsuarioDAO::listChefia()];
	            $render->list += ['regioes' => RegiaoDAO::find($regiao)];
	            $render->list += ['estados' => EstadoDAO::find($estado)];
	            $render->list['load_scripts'] = [
	            	''
	            ];

	            $render->setDir('usuario');
	            $render->setView('usuario/novo_edit');
	            $render->renderizar();
			}
		}

		public function editar($post,$get,$param){

			if(isset($post['editUsuario'])){

				$json = ['status' => 0, 'msg' => 'Ops, nao foi possivel editar este usuário'];

				$res = $this->validar_usuario($post);

				if($res != ""){
					$json['msg'] = $res;
				}else{

					$permissao_editar = $this->permissao_editar();

					if($permissao_editar){

						$statusOK = true;
						$usuario = new Usuario($post);

						if(isset($post['pw1'])){

							if(!$this->verifica_senha($post['pw1'],$post['pw2'])){
								$statusOK = false;
								$json['msg'] = "Os campos de senha devem ser iguais!";
							}else{
								$usuario->setSenha($post['pw1']);
								$statusOK = true;
							}
						}

						if($statusOK){
							if(UsuarioDAO::edit($usuario)){
								$json['status'] = 1;
								$json['msg'] = 'Usuário atualizado com sucesso!';
							}
						}

					}else{

						//alterando alguns dados da propria conta
						$usuario = new Usuario();
						$usuario->setId($_SESSION['prev_user_id']);
						$usuario->setNome(addslashes($post['nome']));

						if(!$this->verifica_senha($post['pw1'],$post['pw2'])){

							$json['msg'] = "Os campos de senha devem ser iguais!";

						}else{

							if(UsuarioDAO::edit($usuario)){
								$json['status'] = 1;
								$json['msg'] = 'Usuário atualizado com sucesso!';
							}
						}
					}
				}

				echo json_encode($json);	

			}else{

				$show_pw = false;

				$usuario = new Usuario();

				if(isset($post['profile'])){

					$usuario->setId($post['profile']);

					$show_pw = true;

				}else if($_SESSION['prev_user_group'] == 1 || $_SESSION['prev_user_group'] == 2){
					$usuario->setId($param[0]);
					$show_pw = true;
				}else{
					$usuario->setId($param[0]);
				}

				$grupo = new Grupo();

				$cols = "*";
				$join  = " JOIN grupo ON grupo.cd_grupo = usuario.cd_grupo ";
				$join .= " LEFT JOIN cargo on cargo.cd_cargo = usuario.cd_cargo ";
				$join .= " LEFT JOIN cidade ON cidade.cd_cidade = usuario.cd_cidade ";
				$join .= " LEFT JOIN estado ON estado.cd_estado  = cidade.cd_estado";

				$grupo = new Grupo;
				$grupo->setStatus('1');

				$cargo =  new Cargo;
				$cargo->setStatus('1');

				$regiao = new Regiao;
				$regiao->setStatus('1');

				$estado = new Estado;
				$estado->setStatus(1);

				$permissao_editar = false;

				$permissao_editar = $this->permissao_editar();

				$render = new ClassRender;

	            $render->setTitle('Editar Usuário');

	            $render->setMenu($_SESSION['prev_user_permissao']);

	            $render->list += ['editar' 	=> UsuarioDAO::find($usuario,$cols,$join)[0]];

	            $render->list += ['grupos'	=> GrupoDAO::find($grupo)];

	            $render->list += ['cargos'	=> CargoDAO::find($cargo)];

	            $render->list += ['chefias' => UsuarioDAO::listChefia()];

	            $render->list += ['regioes' => RegiaoDAO::find($regiao)];

	            $render->list += ['estados' => EstadoDAO::find($estado)];

	            $render->list += ['show_pw' => $show_pw];

	            $render->list += ['permissao_editar' => $permissao_editar];

	            

	            $render->setDir('usuario');

	            $render->setView('usuario/novo_edit');

	            $render->renderizar();

			}

		}

		private function validar_usuario($post){

			$msg = "";

			$user = new Usuario();

			if(!isset($post['email'])) return "";

			if(isset($post['id']) && is_numeric($post['id'])){
				
				$g_user = UsuarioDAO::find(new Usuario(['id' => $post['id']]),'*')[0];

				if($post['email'] != "" && UsuarioDAO::email_exists($post['email'])){
					if($g_user['nm_email'] != $post['email']){
						$msg .= "\r\nEste e-mail já está em uso!";
					}
				}	
			}
			

			$user->setEmail($post['email']);

			if( isset($post['cpf']) && !empty($post['cpf'])){

				if( $this->validarCPF($post['cpf'])){
					$user->setCPF($post['cpf']);	
				}else{
					$msg .= "\r\nO CPF informado é inválido";
				}

			}else if(isset($post['cnpj']) && !empty($post['cnpj'])){

				if($this->validarCNPJ($post['cnpj'])){
					$user->setCNPJ($post['cnpj']);
				}else{
					$msg .= "\r\O CNPJ informado é inválido";
				}
			}

			if(isset($post['crea']) && !empty($post['crea']) && $post['crea'] != ""){
				$user->setCREA($post['crea']);
			}

			$cols = "cd_usuario, cd_grupo, nm_email,  ds_crea, cd_cnpj, cd_cpf";

			$res = UsuarioDAO::find($user,$cols);
			$id = isset($post['id'])? $post['id'] : 0;

			if(is_array($res) && count($res) > 0){

				$user 	= $res[0];
				$uid 	= $user['cd_usuario'];
				$ucpf 	= $user['cd_cpf'];
				$ucnpj 	= $user['cd_cnpj'];
				$grupo  = $user['cd_grupo']; 

				if(!empty($user['ds_crea']) && $user['ds_crea'] == $post['crea'] && !($uid == $id)){
					$msg .= "\r\nEste código de CREA já está em uso!";
				}

				if(isset($post['cpf']) && $post['cpf'] != "" && $ucpf == $post['cpf'] && !($uid == $id)){
					$msg .= "\r\nEste CPF já está em uso!";
				}

				if(isset($post['cnpj']) && $post['cnpj'] != "" && ($ucnpj == $post['cnpj']) && !($uid == $id)){
					$msg .= "\r\nEste CNPJ já está em uso!";
				}
			}

			if($msg != "") $msg = "ATENÇÃO!".$msg;

			return $msg;

		}



		public function excluir($post){

			$json = ['status' => 0, 'msg' => 'Ops, nao foi possivel excluir este usuário'];

			$usuario = new Usuario($post);

			// print_r($grupo);

			if(UsuarioDAO::remove($usuario)){

				$json['status'] = 1;

				$json['msg'] = "Usuário deletado com sucesso";

			}

			echo json_encode($json);

		}



		private function filterUsers(){

			$grupo = $this->filter_exists('grupo');

			$status = $this->filter_exists('status');

			$cargo = $this->filter_exists('cargo');

			$name = $this->filter_exists('name');

			$regiao = $this->filter_exists('regiao');

			$estado = $this->filter_exists('estado');

			$cidade = $this->filter_exists('cidade');

			

			return new Usuario(

				[

				'grupo'	=> $grupo,

				'status'=> $status,

				'cargo'	=> $cargo,

				'nome' 	=> $name,

				'regiao'=> $regiao,

				'estado'=> $estado,

				'cidade'=> $cidade

				]

			);

		}



		private function filter_exists($filter){

			if(isset($_GET[$filter])){

				return addslashes($_GET[$filter]);

			}

			return null;

		}



		private function enviar_senha($email, $senha){

			$email = new SimpleEmail($email);

			return $email->send_new_password($senha);

		}



		public function perfil($post){



			if(isset($post['editUsuario'])){

				$post['id'] = $_SESSION['prev_user_id'];

				$this->editar($post,null,null);

			}else{

				$post = ['profile' => $_SESSION['prev_user_id'] ];

				$this->editar($post,null,null);

			}

		}



		private function validarCPF($cpf = null) {



			if(empty($cpf)) return false;



			$cpf = preg_replace("/[^0-9]/", "", $cpf);

			$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

			

			if (strlen($cpf) != 11) return false;

			

			if ($cpf == '00000000000' || 

				$cpf == '11111111111' || 

				$cpf == '22222222222' || 

				$cpf == '33333333333' || 

				$cpf == '44444444444' || 

				$cpf == '55555555555' || 

				$cpf == '66666666666' || 

				$cpf == '77777777777' || 

				$cpf == '88888888888' || 

				$cpf == '99999999999'){

				return false;



			 } else {   

				

				for ($t = 9; $t < 11; $t++) {

					

					for ($d = 0, $c = 0; $c < $t; $c++)  $d += $cpf{$c} * (($t + 1) - $c);



					$d = ((10 * $d) % 11) % 10;



					if ($cpf{$c} != $d) return false;

				}



				return true;

			}

		}



		private function validarCNPJ($cnpj){



			$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

			

			if (strlen($cnpj) != 14) return false;

			if (preg_match('/(\d)\1{13}/', $cnpj)) return false;



			for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++){

				$soma += $cnpj{$i} * $j;

				$j = ($j == 2) ? 9 : $j - 1;

			}



			$resto = $soma % 11;



			if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto)) return false;



			for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++){

				$soma += $cnpj{$i} * $j;

				$j = ($j == 2) ? 9 : $j - 1;

			}



			$resto = $soma % 11;



			return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);

		}



		private function permissao_editar(){

			if(isset($_SESSION['prev_user_permissao'])){

				$p = $_SESSION['prev_user_permissao'];



				foreach($p as $key => $value){

					if(in_array('usuarios',$value) && $value['nivel_acesso'] > 2){

						return true;

					}

				}

			}

		}



		private function verifica_senha($pw1,$pw2){

			if(isset($pw1) && !empty($pw1)){				

				if($pw1 != $pw2){

					return false;

				}else{

					return true;

				}

			}

		}

	}