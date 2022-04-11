<?php
    namespace App\Controller;
    
    use Src\Classes\ClassRender;
    use App\Controller\Controller;

    use App\Model\Usuario;

    use App\DAO\UsuarioDAO;

    use Src\Classes\ClassEmail;
    use Src\Classes\SimpleEmail;
        
    class ControllerHome extends Controller{
        
        public function index(){

            // echo "<center><h1>EM MANUTENÇÃO</h1><center>";
            // exit;

            $render = new ClassRender;
            $render->setTitle('Home');
            $render->setView('index');
            $render->renderizar();
        }

        public function login(){
            $render = new ClassRender;
            $render->setTitle('Home');
            $render->setView('index');
            $render->renderizar();
        }

        public function esqueci_minha_senha(){
            $render = new ClassRender;
            $render->setTitle('Esqueci minha senha');
            $render->setView('esqueci_minha_senha');
            $render->renderizar();
        }

        public function recuperar_senha(){
            
            if(isset($_POST['email'])){
                
                $email  = addslashes($_POST['email']);
                $user   = new Usuario(['email' => $email]);

                $cols   = "cd_usuario, nm_email";
                $res    = UsuarioDAO::find($user,$cols);

                if(is_array($res) && count($res) > 0 ){
                    
                    $arr_user = $res[0];

                    $code = md5('mYhdis');
                    $user->setCdRecuperarSenha($code);
                    $user->setId($arr_user['cd_usuario']);

                    if(UsuarioDAO::reset_password_request($user)){

                        $email = new SimpleEmail($arr_user['nm_email']);
                        
                        $email->send_reset_password_request($code);

                        $json['msg'] = "Pedido enviado com sucesso!";
                        $json['msg'] .= "\r\n Verifique seu E-mail.";

                    }else{
                        $json['msg'] = 'Erro: Não foi possivel enviar o pedido!';
                    }

                }else{
                    $json['msg'] ='Erro: E-mail nao encontrado!';
                }

                echo json_encode($json);

            }else{
                $render = new ClassRender;
                $render->setTitle('Recuperar Senha');
                $render->setView('recuperar_senha');
                $render->renderizar();    
            }
        }

        public function redefinir_senha(){
            
            $json['status'] = 0;

            if(isset($_SESSION['prev_user_id']) && isset($_POST['senha1']) ){

                $pw1 = $_POST['senha1'];
                $pw2 = $_POST['senha2'];

                if($pw1 == $pw2){
                    
                    $code = addslashes($_POST['code']);

                    $user =  new Usuario();
                    $user->setId($_SESSION['prev_user_id']);
                    $user->setCdRecuperarSenha($code);
                    $user->setSenha($pw1);

                    if(UsuarioDAO::redefine_pw($user)){
                        $json['status'] = 1;
                        $json['msg'] = "Senha redefinida com sucesso!";
                    }else{
                        $json['msg'] = "Erro: não foi possivel redefinir a senha!";
                    }

                }else{
                    $json['msg'] = "Erro: as senhas não são iguais!";
                }

                echo json_encode($json);

            }else if(isset($_GET['code'])){
                
                $code = addslashes($_GET['code']);

                $user = new Usuario(['cdRecuperarSenha' => $code]);

                $res  = UsuarioDAO::verify_request_password_code($user); 

                if(is_array($res) && count($res) > 0){
                    
                    $res = $res[0];

                    $_SESSION['prev_user_id'] = $res['cd_usuario'];

                    $render = new ClassRender;
                    $render->setTitle('Redefinir Senha');
                    $render->list += ['code' => $code];
                    $render->setView('redefinir_senha');
                    $render->renderizar();

                }else{
                    echo "CÓDIGO INVÁLIDO";
                }

            }else{
                echo "Acesso negado!";
            }
        }
    }