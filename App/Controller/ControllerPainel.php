<?php

    namespace App\Controller;
    
    use App\Controller\Controller;
    use App\Model\Usuario;
    use App\Model\Admin;
    use App\Model\Permissao;
    use App\DAO\PermissaoDAO;
    use App\Model\Cidade;
    use App\DAO\CidadeDAO;
    use Src\Classes\ClassRender;
    use Src\Classes\ClassEmail;
    use Src\Classes\GeradorLAUDOPDF;

    class ControllerPainel extends Controller {

        public function __construct(){
            parent::__construct();

            $res = PermissaoDAO::chat_permission($_SESSION['prev_user_group']);

            if($res){
                $_SESSION['prev_chat_active'] = 1;
            }else{
                $_SESSION['prev_chat_active'] = 0;
            }

            if(isset($_SESSION['prev_user_id'])){
                $usuario = new Usuario(['id' => $_SESSION['prev_user_id'] ]);
                $permissoes = PermissaoDAO::getPermissoes($usuario);
                $_SESSION['prev_user_permissao'] = $permissoes;
            }else{
                $_SESSION['prev_user_permissao'] = [];
            }
        }

    	private function callController($controller, $acao, $param1 = null,$param2 =null){
            $acao = str_replace('-','_', $acao);
            $params = [0 => $param1,1=>$param2];
            $post = isset($_POST) ? $_POST : null;
            $get = isset($_GET) ? $_GET  : null;

    		$controller = "App\\Controller\\". $controller;

    		$obj = new $controller;

    		if(method_exists($obj,$acao)){
        		call_user_func_array([$obj, $acao],['post' => $post, 'get' => $get,'param' => $params]);
        	}else{
        		header('Location: '.PAINEL);
        	}
    	}

        public function index(){
            $render = new ClassRender;
            $render->setTitle('Painel');
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->setView('painel/index');
            $render->list['nr_clients_waiting'] = 0;
            $render->renderizar();
        }

        public function vars(){
            $render = new ClassRender;
            $render->setTitle('variaveis');
            $render->setMenu($_SESSION['prev_user_permissao']);
            $render->setView('painel/vars');
            $render->list['load_scripts'] = [
                'datatable'
            ];

            $render->renderizar();
        }

        public function grupos($acao,$param1 = null){
        	$this->callController('ControllerGrupo',$acao,$param1);
        }

        public function usuarios($acao,$param1 = null){
        	$this->callController('ControllerUsuario',$acao,$param1);
        }

        public function estados($acao){
            $this->callController('ControllerEstado',$acao);
        }

        public function cidades($acao){
            $this->callController('ControllerCidade',$acao);   
        }

        public function cargos($acao, $param1 = null){
            $this->callController('ControllerCargo',$acao,$param1);
        }

        public function regiao($acao, $param1 = null){
            $this->callController('ControllerRegiao',$acao,$param1);
        }

        public function edificio($acao,$param1 = null){
            $this->callController('ControllerEdificio',$acao,$param1);   
        }

        public function condicao_de_pagamento($acao,$param1 = null){
            $this->callController('ControllerCondicaoDePagamento',$acao,$param1);
        }

        public function anexo($acao,$param1 = null){
            $this->callController('ControllerAnexo',$acao,$param1);
        }

        public function area($acao,$param1 = null){
            $this->callController('ControllerArea',$acao,$param1);
        }

        public function documento($acao,$param1 = null){
            $this->callController('ControllerDocumento',$acao,$param1);
        }

        public function configuracao_de_pdf($acao,$param1 = null){
            $this->callController('ControllerConfigPDF',$acao,$param1);
        }

        public function teste_corretor($acao,$param1 = null){
            $this->callController('ControllerConfigTESTE',$acao,$param1);
        }

        public function tipo_servico($acao,$param1 = null){
            $this->callController('ControllerTipoServico',$acao,$param1);   
        }

        public function servico($acao,$param1 = null){
            $this->callController('ControllerServico',$acao,$param1);
        }

        public function proposta($acao,$param1 = null){
            $this->callController('ControllerProposta',$acao,$param1);
        }

        public function modelo_laudo($acao,$param1 = null, $param2 = null){
            $this->callController('ControllerLaudoModelo',$acao,$param1,$param2);
        }

        public function laudo($acao,$param1 = null, $param2 = null){
            $this->callController('ControllerLaudo',$acao,$param1,$param2);
        }

        public function files($acao,$param1 = null, $param2 = null){
            $this->callController('ControllerFiles',$acao,$param1,$param2);
        }

        // public function chat($acao,$param1 = null, $param2 = null){
        //     $this->callController('ControllerChat',$acao,$param1,$param2);
        // }
    }