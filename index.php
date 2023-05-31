<?php
require_once 'classe-pessoa.php';
$p = new Pessoa("crudpdo", "localhost","root","");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
 
    <title>Cadastro Pessoa</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <?php
    if(isset($_POST['nome']))
    //--------------quando a pessoa clicou no botão cadastrar ou editar.
    {
        //-----------editar a informação
        if(isset($_GET['id_up']) && !empty($_GET['id_up'])){
            $id_upd = addslashes($_GET['id_up']);
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            if(!empty($nome) && !empty($telefone) && !empty($email))
            {
                //----------------------editar
                $p->atualizarDados($id_upd,$nome,$telefone,$email);
                header("location: index.php");
            } 
            
            else
        {
            ?>
                <div class="aviso">
                    <img src="aviso.jpg">
                    <h4>"Prencha todos os campos"</h4>
                </div>
                <?php
                           
            }
        }
        
        //---------------cadastrar
        else
        
        {
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            if(!empty($nome) && !empty($telefone) && !empty($email)){
                //----------------------cadastrar
                if(!$p->cadastrarPessoa($nome,$telefone,$email))
                {
                    ?>
                <div class="aviso">
                    <img src="aviso.jpg">
                    <h4>"echo "Email já está cadastrado""</h4>
                </div>
                <?php
                    
                }
            }
            else
            {
                ?>
                <div class="aviso">
                    <img src="aviso.jpg">
                    <h4>"Prencha todos os campos"</h4>
                </div>
                <?php
                
            }
        }
         
        }
     
 ?>   
//<!-para craiar formulario usa a tag form, dentro dest form cria alguns albos e input ->
    <?php
    if(isset($_GET['id_up'])) //Se a pessoa clicou em editar
    {
        $id_update = addslashes($_GET['id_up']);
        $res = $p->buscarDadosPessoa($id_update);
    }

    ?>
<section id="esquerda">;
    <form method="post">
        <h2>CADASTRAR PESSOA</h2>
        <label FOR="NOME">NOME</label>
        <input type="text" name="nome" ID="NOME"
        value="<?php if (isset($res)){echo $res['nome'];}?>">
        <label FOR="telefone">TELEFONE</label>
        <input type="text" name="telefone" ID="telefone"
        value="<?php if (isset($res)){echo $res['telefone'];}?>">
        <label FOR="email">EMAIL</label>
        <input type="text" name="email" ID="email"
        value="<?php if (isset($res)){echo $res['email'];}?>">
        <input type="SUBMIT" 
        value="<?php if(isset($res)){echo "Atualizar";}else{
           echo "Cadastrar"; } ?>">
        
    </form>

    </section>

    <section id="direita">
    <table>
            <tr id="titulo">
                <td>NOME</td>
                <TD>TELEFONE</TD>
                <TD colspan="2">EMAIL</TD>
            </tr>
        
        <?php
        $dados = $p->buscarDados();
        if(count($dados) > 0) //tem pessoas no banco de dados
        {
            for ($i=0; $i < count($dados); $i++)
            {
                echo "<TR>";

                foreach ($dados[$i] as $k => $v)
                {
                    if($k != "id"){
                        echo "<td>".$v."</td>";
                    }                                              
                } 
                ?>
                <TD>
                    <a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">EDITAR</a>
                    <a href="index.php?id=<?php echo $dados[$i]['id'];?>">EXCLUIR</a></TD>
                <?php
                 echo "</tr>";
            }
        }
        else  //significa que o banco está vazio..
        {  
        ?>         
        </table>
        
        <div class="aviso">
           <h4>Ainda não há pessoas cadastradas!</h4></div>
     <?php
    }      
    
    ?>  
    </section>
        
</body>
</html>
<?php
if(isset($_GET['id']))
{
    $id_pessoa = addslashes($_GET['id']);
    $p->excluirPessoa($id_pessoa);
    header("location: index.php");  //header atualizar

}