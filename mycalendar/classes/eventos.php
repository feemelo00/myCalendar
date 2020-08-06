<?php
    class Evento
    {
        private $pdo;

//--------------CONSTRUTOR-faz a conexão com BD-----------
        public function __construct($nome, $host, $usuario, $senha){ 
            try {
                $this->pdo = new PDO("mysql:dbname=".$nome.";host=".$host,$usuario,$senha);
            } catch (PDOException $e) {
                echo "Erro com banco de dados: ".$e->getMessage();
                exit();
            } catch(Exception $e){
                echo "Erro generico: ".$e->getMessage();
                exit();
            }
            
        
        }

//--------------FUNÇÃO BUSCAR DADOS-busca todos os eventos salvos no BD-----------
        public function buscarDados(){
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM eventoss ORDER BY dia");
            $res = $cmd->fetchALL(PDO::FETCH_ASSOC);
            return $res;
        }

//--------------FUNÇÃO CADASTRAR-cadastra uma novo evento no BD-----------
        public function cadastrar($titulo,$dia,$horario_inicio,$horario_termino,$observacao){
            
            $cmd = $this->pdo->prepare("INSERT INTO eventoss (titulo, dia, horario_inicio, horario_termino, observacao)
                        VALUES (:t, :d, :hi, :ht, :o)");

            $cmd->bindValue(":t",$titulo);
            $cmd->bindValue(":d",$dia);
            $cmd->bindValue(":hi",$horario_inicio);
            $cmd->bindValue(":ht",$horario_termino);
            $cmd->bindValue(":o",$observacao);
            
            $cmd->execute();
        }

//--------------FUNÇÃO EXCLUIR-exclui um evento do BD-----------
        public function excluir($id){
            $cmd = $this->pdo->prepare("DELETE FROM eventoss WHERE id = :id");
            $cmd->bindValue(":id",$id);
            $cmd->execute();
        }

//--------------FUNÇÃO BUSCAR EVENTO-busca um único evento salvo no BD-----------
        public function buscarDadosEvento($id){
            $res = array();
            $cmd = $this->pdo->prepare("SELECT * FROM eventoss WHERE id = :id");
            $cmd->bindValue(":id",$id);
            $cmd->execute();
            $res = $cmd->fetch(PDO::FETCH_ASSOC);
            return $res;
        }

//--------------FUNÇÃO ATUALIZAR DADOS-atualiza os dados de um evento salvo no BD-----------
        public function atualizarDados($id, $titulo, $dia, $horario_inicio, $horario_termino, $observacao){
            $cmd = $this->pdo->prepare("UPDATE eventoss SET titulo = :t, dia = :d, horario_inicio = :hi, horario_termino = :ht, observacao = :o WHERE id = :id");
            $cmd->bindValue(':t', $titulo);
            $cmd->bindValue(':d', $dia);
            $cmd->bindValue(':hi', $horario_inicio);
            $cmd->bindValue(':ht', $horario_termino);
            $cmd->bindValue(':o', $observacao);
	        $cmd->bindValue(':id', $id);
            $cmd->execute();      
        }
        
    }
    
?>