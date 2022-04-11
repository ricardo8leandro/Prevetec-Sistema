<?php
    namespace App\DAO;
    
    use App\DB;
    //Essa classe contem metodos básicos usados por todas as classes DAO.
    class DAO extends DB{
        
        static private $DB;
        static private $arr_retorno = ["error" =>""];
        
        use \Src\Traits\TraitCrypt;
        
        //metodo para insert, todo insert do sistema passa por este metodo
        static protected function insert($tabela, $colunas, $valores){
            if( !self::ConectaComDB() ) return false;

            //monta a query
            $sql = "INSERT INTO $tabela ({$colunas}) VALUES ({$valores})";
            
            // echo $sql."\r\n";

            //tenta executar o trecho de codigo
            try{
                self::$DB = self::$DB->prepare($sql);
                self::$DB->execute();

                /* transforna a variavel $colunas em array, separando onde tem virgula */
                $cols = explode(",",$colunas);
                
                /* chama o metodo privado para puxar o ultimo registro da tabelas
                 * a primeira coluna é sempre o ID da linha
                 * por isso pegamos o indice 0 do array
                 * retorna o array com os campos (encriptados)
                 */
                self::$arr_retorno['data'] = self::returnLastInsert( $tabela, $cols[0]);

                return self::$arr_retorno;

            //se nao conseguir executar o codigo acima, captura o erro
            }catch(\PDOException $e){
                //mostra o erro
                self::$arr_retorno = ["error" => $e];
                return self::$arr_retorno;
            } 
        }
        //metodo para retornar o ultimo registro inserido.
        static private function returnLastInsert($tabela, $col){
            if( !self::ConectaComDB() ) return false;

            $sql = "SELECT * FROM $tabela ORDER BY $col DESC LIMIT 1";
            self::$DB = self::$DB->prepare($sql);
            self::$DB->execute();
            $fetch = self::$DB->fetch(\PDO::FETCH_ASSOC);
            return $fetch;
        }
        
        static protected function Select($tabela, $colunas, $join = false,$condicao = false, $ordenar = false, $alcance = false){

            if( !self::ConectaComDB() ) return false;

            $res = false;
            //começa montando a query apenas com as colunas e o nome da tabela
            $sql = "SELECT $colunas FROM $tabela ";
            //se tiver tabelas para "juntar"...
            if($join){ $sql .= " ".$join." "; }
            //se houver condição para o select, adiciona a condição na query.
            if($condicao){ $sql .= " WHERE {$tabela}.$condicao "; }
            //se houver uma ordenação no select, a adiciona na query.
            if($ordenar){ $sql .= " ORDER BY $ordenar "; }
            //se houver um limite para a quantidade de linhas selecionadas, a adiciona na query.
            if($alcance){ $sql .= " LIMIT $alcance "; }
            //o atributo DB recebe a conexao com o DB e prepara a query

            /**
             *Ponto de debug
             */
            // echo '<script>console.log("'.$sql.'");</script>';
            // if($tabela == "laudo_item_anexo"){ echo $sql."<br>"; }
            
            self::$DB = self::$DB->prepare($sql);
            self::$DB->execute();
            //se a query retornar 1 ou mais linhas...
            if(self::$DB->rowCount() > 0){
                //enquanto houver "linha", adicione o conteudo dela no array $res;
                while($fetch = self::$DB->fetch(\PDO::FETCH_ASSOC)){
                    //cada "linha" que retornar da query, é inserida em um novo indice do array.
                    $res[] = $fetch;
                }
            }
            //retorna o array com as informações do DB.
            return $res;
        }
        
        static protected function Update($tabela, $atualizacao, $condicao = 0){
            if( !self::ConectaComDB() ) return false;

            $res = false;
            $sql = "UPDATE $tabela SET $atualizacao WHERE $condicao";
            // if($tabela == 'usuario') echo $sql;
            self::$DB = self::$DB->prepare($sql);
            if(self::$DB->execute()) $res = true;
            return $res;  
        }
        
        static protected function Delete($tabela, $condicao = 0){
            if( !self::ConectaComDB() ) return false;
            $res = false;
            $sql = "DELETE FROM $tabela WHERE $condicao";
            // echo $sql."\r\n";
            self::$DB = self::$DB->prepare($sql);
            if(self::$DB->execute()){ $res = true; }
            return $res;
        }

        static private function ConectaComDB(){
            self::$DB = self::connectDB();
            if(is_object(self::$DB)){
                return true;
            }
        }

        static protected function query($query){
            if( !self::ConectaComDB() ) return false;

            $res = false;
            self::$DB = self::$DB->prepare($query);
            if(self::$DB->execute()) $res = true;
            return $res;  
        }
    }
