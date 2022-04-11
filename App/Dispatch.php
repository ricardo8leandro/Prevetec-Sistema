<?php
    namespace App;
    
    use Src\Classes\ClassRoutes; 
    
    class Dispatch extends ClassRoutes{
        /**
         * Aqui é bem simples:
         * https://exemplo.com.br/Home/Noticias/1
         * Com a trait sendo usada na ClassRoutes,a Url será quebrada onde tem /
         * gerando um array: array("Home","Noticias",1);
         * a primeira posição do array puxa a Controller
         * a segunda posição do array puxa o metodo do controller
         * da terceira posição para cima, são os parametros do metodo
         **/
        
        //receberá a instancia do controller
        private $obj;
        //receberá o nome do metodo
        private $method;
        //receberá um array com parametros do metodo
        private $param = [];
        //getters
        protected function getMethod(){ return $this->method; }
        protected function getParam(){ return $this->param; }
        //setters
        protected function setMethod($method){
            $method = str_replace("-","_",$method);
            $this->method = $method;
        }
        protected function setParam($param){ $this->param = $param; }
        
        public function __construct(){
            //ao instanciar o Dispatch já chama o AddController
            self::AddController();
        }
        
        //aqui vai instanciar o objeto do controller
        public function AddController(){
            
            //recebendo a string com o nome do controller
            //metodo vindo da ClassRoutes
            $routeController = $this->getRoute();
            //aqui a gente ta montando o caminho para instanciar o controller
            $controller = "App\\Controller\\". $routeController;
            //instanciando o controller
            $this->obj = new $controller;
            //verificando se a variavel da URl possui posicao 1
            //se possuir, quer dizer que estão chamando um metodo!
            if(isset($this->parseUrl()[1])){
                //vai adicionar o metodo que estão chamando
                self::addMethod();
            }
        }
        
        private function addMethod(){
            //se o metodo existir dentro desse objeto...
            if(method_exists($this->obj,str_replace('-','_',$this->parseUrl()[1]))){
                //seta o atributo method com o valor da posicao 1 do array
                if($this->parseUrl()[1] != ""){
                    $this->setMethod($this->parseUrl()[1]);
                    //adiciona todas as opcoes após a 1 como parametros
                    self::addParam();
                    //chama o method com o array de parametros
                    call_user_func_array([$this->obj,$this->getMethod()],$this->getParam());
                }
            }
        }
        
        private function addParam(){
            //conta quantas posições tem no array da URL
            $arrayCount = count($this->parseUrl());
            //se tiver mais de 2 pocisoes (0 e 1) significa que tem parametros
            if($arrayCount > 2){
                //para cada posicao dentro do array...
                foreach($this->parseUrl() as $key => $value){
                    //se a posicao for maior que 1 (1 = metodo)
                    if($key > 1){
                        //junta tudo no atributo "param"
                        $this->setParam($this->param += [$key => $value]);
                    }
                }
            }
        }
    }