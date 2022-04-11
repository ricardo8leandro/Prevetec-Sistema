<?php
    //é o caminho até este arquivo.
    namespace Src\Classes;

    use App\Controller\ControllerAuth;
    use App\Model\Usuario;

    class ClassRoutes {
        //atributo que receberá um array.
        private $route;
        //contem uma funcao que retorna um array da URL
        use \Src\Traits\TraitUrlParser;
        //metodo para retornar o controller baseado na url (array[0])
        public function getRoute(){
            //passa o array para a $url
            $url = $this->parseUrl();
            //recupera o valor do primeiro indice
            $i = $url[0];
                       
            $this->route = array(
                "Home"  => ["Controller" => "ControllerHome"],
                'Login' => ["Auth" => true, "Controller" => 'ControllerHome'],
                'Painel'=> ['Auth' => true, "Controller" => 'ControllerPainel'],
                //Controlador de login e logout
                'Auth'  => ["Controller" => 'ControllerAuth'],
                'Cidades' =>["Controller" => 'ControllerCidade']
            );

            if($i == "Home" && isset($_SESSION['prev_user_auth'])){
                header('Location:'.PAINEL);
            }

            //o caminnho que o usuário está chamando existe na lista acima?
            if(array_key_exists($i, $this->route)){
                if(!array_key_exists('Auth',$this->route[$i])){
                    //o arquivo desse controller existe?
                    if(file_exists(DIR_CONTROLLER.$this->route[$i]['Controller'].".php")){
                        //retorne o nome do controller
                        return $this->route[$i]['Controller'];
                    }else{
                        //senao existir o arquivo, retorna para a tela inicial.
                       header("Location: ". DIR_PAGE.'Home');
                    }    
                }else{
                    
                    if(isset($_SESSION['prev_user_auth']) && isset($_SESSION['prev_user_id']) ){
                        $usuario = new Usuario;
                        $usuario->setAuth($_SESSION['prev_user_auth']);
                        $usuario->setId($_SESSION['prev_user_id']);

                        $auth = new ControllerAuth;

                        if($auth->validate($usuario) && file_exists(DIR_CONTROLLER.$this->route[$i]['Controller'].".php")){
                            return $this->route[$i]['Controller'];
                        }else{
                            $auth->logout();
                            header("Location: ". DIR_PAGE.'Home');
                        }

                    }else{
                        header("Location: ". DIR_PAGE.'Home');
                    }
                }
                
            //se nao existir essa rota na lista...
            }else{
                //retorna para a tela inicial
                header("Location: ". DIR_PAGE.'Home');
            }
        }
    }