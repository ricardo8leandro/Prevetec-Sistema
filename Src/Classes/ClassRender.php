<?php
    namespace Src\Classes;
    
    class ClassRender {
        //define o diretório base
        private $dirBase;
        //define o diretório dos arquivos da página
        private $dir;
        //nome do arquivo que vai ser chamado na main
        private $view;
        //define o titulo da página
        private $title;
        //define as palavras chave da página
        private $keywords;
        //define a descrição da página
        private $description;
        //array para valores especificos das páginas
        public $list = [];
        //estrutura básica da página
        private $head;
        private $header;
        private $menu;
        private $main;
        private $footer;
        //Getters ===============================================================================
        public function getDirBase(){ return $this->dirBase; }
        public function getDir(){ return $this->dir; }
        public function getTitle(){ return $this->title; }
        public function getKeywords(){ return $this->keywords; }
        public function getDescription(){ return $this->description; }
        public function getView(){ return $this->view; }
        public function getMenu(){ return $this->menu; }
        //Setters ===============================================================================
        public function setDirBase($dirBase){ $this->dirBase = $dirBase."/"; }
        public function setDir($dir){ $this->dir = $dir."/"; }
        public function setTitle($title){ $this->title = $title; }
        public function setKeywords($keywords){ $this->keywords = $keywords; }
        public function setDescription($description){ $this->description = $description; }
        public function setView($view){ $this->view = $view; }
        public function setMenu($menu){ $this->menu = $menu; }
        
        public function renderizar(){
            //chama o arquivo principal
            require_once DIR_REQ ."App/View/Layout.php";
        }
        //verifica se tem conteudo para adicionar no head
        public function addHead(){
            
           if(file_exists(DIR_REQ."App/View/".$this->getDirBase().$this->getDir()."head.php")){
                include_once DIR_REQ."App/View/".$this->getDirBase().$this->getDir()."head.php";
           }
        }

        //verifica se tem conteudo para adicionar no header
        public function addHeader(){
            //verifica se existe um arquivo header.php na pasta
            if(file_exists(DIR_REQ."App/View/".$this->getDirBase()."header.php")){
                //se ele existir, da um include
                include_once DIR_REQ."App/View/".$this->getDirBase()."header.php";
            }
        }

        public function addMenu(){
            
            if(!empty($this->getMenu())){
                if(file_exists(DIR_VIEW.'menu_logado.php')){
                    include_once DIR_VIEW.'menu_logado.php';
                }
            }
        }
        //verifica se tem conteudo para adicionar no main
        public function addMain(){
           if(file_exists(DIR_VIEW.$this->getView().".php")){
                include_once DIR_VIEW.$this->getView().".php";
           } 
        }
        //verifica se tem conteudo para adicionar no footer
        public function addfooter(){
           if(file_exists(DIR_REQ."App/View/".$this->getDirBase().$this->getDir()."footer.php")){
                include_once DIR_REQ."App/View/".$this->getDirBase().$this->getDir()."footer.php";
           }
        }

        private function SlcStatus($status,$tipo){
            if( !empty($status) && $status == $tipo){
                echo "selected";  
            } 
        }

        private function consoleLog($string){
            echo "<script>";
            echo "console.log('".$string."') ";
            echo "</script>";
        }
    }