<?php
    class Usuario
    {
        private $pdo;
        public $msgErro = "";

//--------------FUNÇÃO CONECTAR-faz a conexão com BD-----------
        public function conectar($nome, $host, $usuario, $senha){
            global $pdo;
            try {
                $pdo = new PDO("mysql:dbname=".$nome.";host=".$host,$usuario,$senha);
            } catch (PDOException $e) {
                $msgErro = $e->getMessage();
            }
            
        
        }

//--------------FUNÇÃO CADASTRAR-cadastra uma pessoa no BD-----------
        public function cadastrar($nome, $email, $senha){
            global $pdo;
            //verificação de email cadastrado
            $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");
            $sql->bindValue(":e",$email);
            $sql->execute();
            if($sql->rowCount() > 0){ //conta as linhas que veio do BD, se vier algo é pq tem um ID cadastrado
                return false;
            }
            else{ //cadastrar
                $sql = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:n, :e, :s)");

                $sql->bindValue(":n",$nome);
                $sql->bindValue(":e",$email);
                $sql->bindValue(":s",md5($senha));
                $sql->execute();

                return true;
            }

            
        }
        
    }
    
?>