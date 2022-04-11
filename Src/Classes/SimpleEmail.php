<?php 
    namespace Src\Classes;

    class SimpleEmail {
        
        private $header;
        private $subject;
        private $message;
        private $from_mail;
        private $from_name;
        private $mail_to;

        public function __construct($user){
            // senha
            // Ni+_*%}k;~Cs
            if(function_exists('mail')){
                $this->from_mail = 'prevetec@orangepmm.com.br';
                $this->from_name = "Prevetec";
                $this->mail_to = $user;
            }else{
                echo 'mail() has been disabled';
            }
        }

        private function headers(){

            $encoding = "utf-8";

            // Preferences for Subject field
            $subject_preferences = array(
                "input-charset" => $encoding,
                "output-charset" => $encoding,
                "line-length" => 76,
                "line-break-chars" => "\r\n"
            );

            $this->header = "Content-type: text/html; charset=".$encoding." \r\n";
            $this->header .= "From: ".$this->from_name." <".$this->from_mail."> \r\n";
            $this->header .= "MIME-Version: 1.0 \r\n";
            $this->header .= "Content-Transfer-Encoding: 8bit \r\n";
            $this->header .= "Date: ".date("r (T)")." \r\n";
            $this->header .= iconv_mime_encode("Subject", $this->subject, $subject_preferences);
        }

        public function send_reset_password_request($code){
            
            $link = DIR_PAGE."Home/redefinir-senha?code=".$code;

            $this->subject  = "[REDEFINIR SENHA - PREVETEC]";
            $this->message  = "Voce enviou um pedido para redefinir sua senha!<br>";
            $this->message .= "Acesse: <a href='".$link."'>";
            $this->message .= "PREVETEC - REDEFINIR SENHA";
            $this->message .= "</a>";

            $this->send();
        }

        public function send_new_password($pw){
            $this->subject  = "[CONTA - PREVETEC]";

            $this->message  = "Sua conta foi criada com sucesso!<br>";
            $this->message .= "Aqui esta a sua senha: ".$pw;

            $this->send();
        }
        
        private function send(){
            $this->headers();
        
            if(mail($this->mail_to,$this->subject,$this->message, $this->header)){
                return true;
            }

        }
    }