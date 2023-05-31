<?php

//iremos utilizar 6 funções
//conexao com banco de dados
class Pessoa{
    private $pdo;
    //funcao para buscar addos e colocar no canto direito da tela
    public function __construct($dbname,$host,$user,$senha)
    {
        try
        {
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);

        }
        catch(PDOException $e){
            echo "Erro com banco de dados: ".$e->getMessage();
            exit();
        }
        catch(Exception $e){
            echo "Erro generico: ".$e->getMessage();
            exit();
        }
        }
        public function buscarDados()
        {
            $res = array();
            $cmd = $this->pdo->query("select * from pessoa order by nome");
            $cmd->execute();
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
            
        }
        //-------função de cadastrar pessoa no banco de dados
        public function cadastrarPessoa($nome,$telefone,$email)
        //-------antes de cadastrar verificar se existe email cadastrado.
        {
            $cmd = $this->pdo->prepare("select id from pessoa where email = :e");
            $cmd->bindValue(":e",$email);
            $cmd->execute();
            if($cmd->rowCount() > 0)//email já existe no banco
            {
            return false;
            }else  //não foi encontrado email
            {
            $cmd = $this->pdo->prepare("insert into pessoa (nome, telefone, email) values (:n, :t,:e)");
            $cmd->bindValue(":n",$nome);
            $cmd->bindValue(":t",$telefone);
            $cmd->bindValue(":e",$email);
            $cmd->execute();
            return true;
            }
        }
        public function excluirPessoa($id)
        {
            $cmd = $this->pdo->prepare("delete from pessoa where id = :id");
            $cmd->bindValue(":id" ,$id);
            $cmd->execute();
        }
        //buscar dados de uma pessoa
        public function buscarDadosPessoa($id)
        {
            $res = array();
            $cmd = $this->pdo->prepare("select * from pessoa where id = :id");
            $cmd->bindValue(":id",$id);
            $cmd->execute();
            $res = $cmd->fetch(pdo::FETCH_ASSOC);
            return $res;
            

        }
        //atualizar dados no banco de dados
        public function atualizarDados($id,$nome,$telefone,$email)
        {
            $cmd = $this->pdo->prepare("update pessoa set nome = :n, telefone = :t, email = :e where id = :id");
            $cmd->bindValue(":n",$nome);
            $cmd->bindValue(":t",$telefone);
            $cmd->bindValue(":e",$email);
            $cmd->bindValue(":id",$id);
            $cmd->execute();
            
        }
    }

        
           