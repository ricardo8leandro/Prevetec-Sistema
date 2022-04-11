<?php
    //define o fuso-horario
    date_default_timezone_set('America/Sao_Paulo');
    // mostrar erros
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    error_reporting(E_ALL);
    
   $dirIgnore = "public";

    function getDocumentRoot($dirIgnore){
        $root = getcwd();
        return str_replace("\\","/",substr($root, 0, -strlen($dirIgnore) ));
    }

    function getSubPasta($root){
        $cRoot = strlen($root);
        $cDocRoot =  strlen($_SERVER['DOCUMENT_ROOT']);
        $limit1 = $cRoot - $cDocRoot;
        return substr($root, $cDocRoot, $limit1);
    }
        
    /**
     * ROTAS BASE
     */
        define("DIR_PAGE","http://". $_SERVER['HTTP_HOST'].getSubPasta(getDocumentRoot($dirIgnore)));

        if(substr($_SERVER['DOCUMENT_ROOT'],-1) == '/'){
            define('DIR_REQ',$_SERVER['DOCUMENT_ROOT'].$subpasta);
        }else{
            define('DIR_REQ', getDocumentRoot($dirIgnore) );
        }
    /*
     * DIRETORIOS BASE PUBLICOS (public)
     */
        define('DIR_CSS',       DIR_PAGE .'public/css/');
        define('DIR_JS',        DIR_PAGE .'public/js/');
        define('DIR_TEMPLATE',  DIR_PAGE .'public/template/');
        define('DIR_IMG',       DIR_PAGE .'public/img/');
        define('DIR_LAUDO_PDF', DIR_PAGE .'public/laudosPDF/');
        define('DIR_LAUDO_ANEXO', DIR_PAGE .'public/PDFs/laudo_anexos/');


            
    /**
     * URL DE CONTROLLERS
     */
        define('PAINEL', DIR_PAGE.'Painel/');
        define('HOME', DIR_PAGE.'Home/');
        define('AUTH', DIR_PAGE.'Auth/');

    /**
     *  DIRETORIOS DA APLICAÇÃO
     **/
        define('DIR_APP',        DIR_REQ .'App/');
        define('DIR_CONTROLLER', DIR_APP .'Controller/');
        define('DIR_MODEL',      DIR_APP .'Model/');
        define('DIR_VIEW',       DIR_APP .'View/');
        define('DIR_DAO',        DIR_APP .'DAO/');
        define('DIR_SRC',        DIR_REQ .'Src/');
        define('DIR_PDFs',       DIR_REQ .'public/PDFs/');
        define('REQ_LAUDO_PDF',  DIR_REQ .'public/laudosPDF');

    /**
     * DADOS DO EDITOR DE TEXTO
     * opcoes:
     *   - name: tinymce        | key: 5jftj49ur9o15t3n4mk811qecesm2lh5hsrf11eqp0hmvie7
     *   - name: tinymce_free   | key: 
     *   - name: ckeditor       | key:
     *
     *  obs: chave temporaria adicionada dia 23/06/2020 e precisará ser trocada dia 7/07/2020
     */
        define('WYSIWYG_NAME','ckeditor');
        define('WYSIWYG_API_KEY','');
    
    /**
     * DADOS DE ACESSO AO BANCO DE DADOS
     **/
        define('DB_NAME','orang651_casosclinicos');
        define('DB_HOST','localhost');
        define('DB_USER','orang651_usercasosclinicos');
        define('DB_PW','sp5RcHSTt3&?');
    
    /**
     * DADOS DE ENVIO DE MAIL
     **/
        define("MAIL_HOST",'');
        define('MAIL_ADDRESS','');
        define('MAIL_OWNER','');
        define('MAIL_PW','');
        define('MAIL_PORT','587'); 
        define('MAIL_TYPE','tls'); // ssl ou tls
        
    /**
     * CHAVE DE ENCRIPTAÇÃO
     **/
        define("CRYPT_KEY","82fy6bg9h5jn6h0hgyvlvkjv8h126wbuvnb94741rnv61b6c");