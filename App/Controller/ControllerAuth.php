<?php
    namespace App\Controller;

    use App\Controller\Controller;
    
    use App\Model\Usuario;
    use App\Model\Admin;
    use App\Model\Permissao;

    use App\DAO\UsuarioDAO;
    use App\DAO\PermissaoDAO;
    
    class ControllerAuth extends Controller{
        
        public function login(){
            if(isset($_POST['email']) && isset($_POST['senha'])){

                $usuario = new Usuario($_POST);

                $res = UsuarioDAO::validaLogin($usuario);

                if(is_array($res)){
                    $_SESSION['prev_user_id']       = $res['cd_usuario'];
                    $_SESSION['prev_user_group']    = $res['cd_grupo'];
                    $_SESSION['prev_user_auth']     = $res['cd_auth'];
                    $_SESSION['prev_user_nome']     = $res['nm_usuario'];
                    $_SESSION['prev_user_email']    = $res['nm_email'];
                    $_SESSION['prev_user_regiao']   = $res['cd_regiao'];

                    // print_r($res);
                    // exit;

                    $permissoes = PermissaoDAO::getPermissoes($usuario);
                    $_SESSION['prev_user_permissao'] = $permissoes;
                    echo json_encode(['status' => 1,'redirect' => PAINEL]);
                    
                }else{
                    echo json_encode(['status' => 0,'msg' => 'Email ou senha incorretos!']);
                }

            }else{
                header('Location: '.DIR_PAGE);
            }
        }

        public function logout(){
            unset($_SESSION['prev_user_id']);
            unset($_SESSION['prev_user_auth']);
            unset($_SESSION['prev_user_nome']);
            unset($_SESSION['prev_user_email']);
            session_destroy();
            header('Location: '.DIR_PAGE);
        }

        public function validate(Usuario $usuario){
            return UsuarioDAO::validate($usuario);
        }
    }