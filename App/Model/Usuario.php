<?php 
	namespace App\Model;

	use App\Model\Model;
	use App\Model\TipoUsuario;

	class Usuario extends Model {

		//chaves estrangeiras
		private $grupo;
		private $chefia;
		private $regiao;
		private $cargo;
		private $cidade;
		private $estado;

		private $status;
		private $nome;
		private $email;
		// private $login;
		private $senha;
		private $telefone;
		private $celular;
		private $cpf;
		private $cnpj;
		private $rg;
		private $dtNascimento;
		private $endereco;
		private $bairro;
		private $cep;
		// private $dsRegistro;

		//crea apenas para engenheiro
		private $crea;
		private $fotoCrea;

		private $responsavel;
		private $inscricaoEstadual;
		private $material;
		private $dtLogin;
		private $cdRecuperarSenha;
		private $auth;
		private $ip;

		private $updated_at;
		private $created_at;

		private $ctps;
		private $serieCtps;
		private $tituloEleitor;
		private $zonaEleitoral;

		public function __construct($data = null){
			
			if(is_array($data)){
				isset($data['id'])? $this->setId($data['id']): false;
				isset($data['grupo'])? $this->setGrupo($data['grupo']): false;
				isset($data['chefia'])? $this->setChefia($data['chefia']): false;
				isset($data['regiao'])? $this->setRegiao($data['regiao']): false;
				isset($data['cargo'])? $this->setCargo($data['cargo']): false;
				isset($data['cidade'])? $this->setCidade($data['cidade']): false;
				isset($data['estado'])? $this->setEstado($data['estado']): false;
				isset($data['status'])? $this->setStatus($data['status']): false;
				isset($data['nome'])? $this->setNome($data['nome']): false;
				isset($data['email'])? $this->setEmail($data['email']): false;
				// isset($data['login'])? $this->setLogin($data['login']): false;
				isset($data['senha'])? $this->setSenha($data['senha']): false;
				isset($data['telefone'])? $this->setTelefone($data['telefone']): false;
				isset($data['celular'])? $this->setCelular($data['celular']): false;
				isset($data['cpf'])? $this->setCPF($data['cpf']): false;
				isset($data['cnpj'])? $this->setCNPJ($data['cnpj']): false;
				// isset($data['rg'])? $this->setRG($data['rg']): false;
				isset($data['dtNascimento'])? $this->setDtNascimento($data['dtNascimento']): false;
				isset($data['endereco'])? $this->setEndereco($data['endereco']): false;
				isset($data['bairro'])? $this->setBairro($data['bairro']): false;
				isset($data['cep'])? $this->setCEP($data['cep']): false;
				// isset($data['dtRegistro'])? $this->setDtRegistro($data['dtRegistro']): false;
				isset($data['crea'])? $this->setCREA($data['crea']): false;
				isset($data['fotoCrea'])? $this->setFotoCREA($data['fotoCrea']): false;
				isset($data['responsavel'])? $this->setResponsavel($data['responsavel']): false;
				isset($data['inscricaoEstadual'])? $this->setInscricaoEstadual($data['inscricaoEstadual']): false;
				isset($data['material'])? $this->setMaterial($data['material']): false;
				isset($data['dtLogin'])? $this->setDtLogin($data['dtLogin']): false;
				isset($data['cdRecuperarSenha'])? $this->setCdRecuperarSenha($data['cdRecuperarSenha']): false;
				isset($data['auth'])? $this->setAuth($data['auth']): false;
				isset($data['ip'])? $this->setIP($data['ip']): false;

				isset($data['updated_at'])? $this->setUpdatedAt($data['updated_at']): false;
				isset($data['created_at'])? $this->setCreatedAt($data['created_at']): false;
				isset($data['ctps'])? $this->setCTPS($data['ctps']): false;
				isset($data['serieCtps'])? $this->setSerieCTPS($data['serieCtps']): false;
				isset($data['tituloEleitor'])? $this->setTituloEleitor($data['tituloEleitor']): false;
				isset($data['zonaEleitoral'])? $this->setZonaEleitoral($data['zonaEleitoral']): false;			
			}
		}

		//chaves estrangeiras
		public function getGrupo(){ return $this->grupo; }
		public function setGrupo($grupo){ $this->grupo = $grupo; }

		public function getChefia(){ return $this->chefia; }
		public function setChefia($chefia){ 
			if(is_numeric($chefia)){
				$this->chefia = $chefia;	
			}else{
				$this->chefia = '';
			}
			
		}

		public function getRegiao(){ return $this->regiao; }
		public function setRegiao($r){ $this->regiao = $r; }

		public function getCargo(){ return $this->cargo; }
		public function setCargo($cargo){ 
			if(is_numeric($cargo)){
				if($cargo == '0'){
					$this->cargo = 'IS NULL';
				}else{
					$this->cargo = $cargo;
				}
				
			}else{
				$this->cargo = '';
			}
		}

		public function getCidade(){ return $this->cidade; }
		public function setCidade($cidade){ $this->cidade = $cidade; }

		public function getEstado(){ return $this->estado; }
		public function setEstado($estado){ $this->estado = $estado; }

		public function getStatus(){ return $this->status; }
		public function setStatus($status){ $this->status = "$status"; }

		public function getNome(){ return $this->nome; }
		public function setNome($nome){ $this->nome = $nome; }

		public function getEmail(){ return $this->email; }
		public function setEmail($email){ $this->email = $email; }

		// public function getLogin(){ return $this->login; }
		// public function setLogin($login){ $this->login = $login; }

		public function getSenha(){ return $this->senha; }
		public function setSenha($senha){ $this->senha = md5($senha); }

		public function getTelefone(){ return $this->telefone; }
		public function setTelefone($tel){ $this->telefone = $tel; }

		public function getCelular(){ return $this->celular; }
		public function setCelular($cel){ $this->celular = $cel; }

		public function getCPF(){ return $this->cpf; }
		public function setCPF($cpf){ $this->cpf = $cpf; }

		public function getCNPJ(){ return $this->cnpj; }
		public function setCNPJ($cnpj){ $this->cnpj = $cnpj; }

		// public function getRG(){ return $this->rg; }
		// public function setRG($rg){ $this->rg = $rg; }

		public function getDtNascimento(){ return $this->dtNascimento; }
		public function setDtNascimento($nasc){ $this->dtNascimento = $nasc; }

		public function getEndereco(){ return $this->endereco; }
		public function setEndereco($e){ $this->endereco = $e; }

		public function getBairro(){ return $this->bairro; }
		public function setBairro($b){ $this->bairro = $b; }

		public function getCEP(){ return $this->cep; }
		public function setCEP($cep){ $this->cep = $cep; }

		// public function getDtRegistro(){ return $this->dsRegistro; }
		// public function setDtRegistro($reg){ $this->dsRegistro = $reg; }

		public function getCREA(){ return $this->crea; }
		public function setCREA($crea){ $this->crea = $crea; }

		public function getFotoCREA(){ return $this->fotoCrea; }
		public function setFotoCREA($ft){ $this->fotoCrea = $ft; }

		public function getResponsavel(){ return $this->responsavel; }
		public function setResponsavel($r){ $this->responsavel = $r; }

		public function getInscricaoEstadual(){ return $this->inscricaoEstadual; }
		public function setInscricaoEstadual($ie){ $this->inscricaoEstadual = $ie; }

		public function getMaterial(){ return $this->material; }
		public function setMaterial($m){ $this->material = $m; }

		public function getDtLogin(){ return $this->dtLogin; }
		public function setDtLogin($dt){ $this->dtLogin = $dt; }

		public function getCdRecuperarSenha(){ return $this->cdRecuperarSenha; }
		public function setCdRecuperarSenha($cd){ $this->cdRecuperarSenha = $cd; }

		public function getAuth(){ return $this->auth; }
		public function setAuth($auth){ $this->auth = $auth; }

		public function getIP(){ return $this->ip; }
		public function setIP($ip){ $this->ip = $ip; }

		//controle de criacao e atualizacao da conta
		public function getUpdatedAt(){ return $this->updated_at; }
		public function setUpdatedAt($date){ $this->updated_at = $date; }

		public function getCreatedAt(){ return $this->created_at; }
		public function setCreatedAt($date){ $this->created_at = $date; }	

		public function getCTPS(){ return $this->ctps; }
		public function setCTPS($ctps){ $this->ctps = $ctps; }

		public function getSerieCTPS(){ return $this->serieCtps; }
		public function setSerieCTPS($serie){ $this->serieCtps = $serie; }

		public function getTituloEleitor(){ return $this->tituloEleitor; }
		public function setTituloEleitor($t){ $this->tituloEleitor = $t; }

		public function getZonaEleitoral(){ return $this->zonaEleitoral; }
		public function setZonaEleitoral($ze){ $this->zonaEleitoral = $ze; }
	}
