<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuário</title>
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/style.css">
    <style>
        .conteudo{
            max-width: 600px;
            min-width: 200px;
            margin: auto;
            margin-top: 80px;  
            margin-bottom: 200px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php include_once "header.php";?>
    <div class="container">
        <?php 
            if(isset($_SESSION['id_usuario']) && isset($_SESSION['nome']) && isset($_SESSION['email'])){

                if(isset($_GET['exit']) && $_GET['exit'] == true){
                    session_destroy();
                    header("Location: index.php");
                } else if(isset($_POST['senha'])){
                    include_once "App/Banco.php";

                    $banco = new Banco();

                    $sql_vefificaSenha = "SELECT id_usuario, nome, email, tipo_usuario FROM usuarios WHERE id_usuario = :id
                    AND id_usuario IN (SELECT id_usuario FROM usuarios WHERE senha = :senha)";
                    $bind = [":id" => $_SESSION['id_usuario'], ":senha" => md5($_POST['senha'])];

                    $dados = $banco->select($sql_vefificaSenha, $bind)->fetch(PDO::FETCH_ASSOC);
                    unset($bind);

                    if($dados != ""){
                        $sql_delete = "DELETE FROM usuarios WHERE id_usuario = :id
                        AND email = :email";
                        
                        $bind = [":id" => $_SESSION['id_usuario'], ":email" => $_SESSION['email']];

                        $excluir = $banco->delete($sql_delete, $bind);

                        if($excluir){
                            unset($_SESSION['id_usuario']);
                            $_SESSION['success'] = "<div class='alert alert-success' role='alert'>
                            Usuario excluido com sucesso!
                            </div>";

                            $banco->desconectar();
                            
                            header("Location: index.php");
                        } else {
                            echo "<div class='alert alert-danger' role='alert'>
                            Ocorreu algum erro ao excluir usuario!
                            </div>";
                            $banco->desconectar();
                        }


                    } else{
                        echo "<div class='alert alert-danger' role='alert'>
                        Senha Incorreta!
                        </div>";

                        $banco->desconectar();
                    }
                }

            } else {
                header("Location: index.php");
            }
        ?>
        <section>
            <div class="conteudo">
                <? if(isset($_GET['delete']) && $_GET['delete'] == true): ?>
                    <form action="user.php" method="post">
                        <legend>Caro(a) <strong><?= $_SESSION['nome']?>,</strong> para prosseguir com a exclusão de sua conta confirme sua senha</legend>
                        <div style="margin-bottom: 15px;">
                            <label for="senha" class="form-label">Senha: </label>
                            <input type="password" name="senha" id="senha" class="form-control form-control-sm" required>
                        </div>
                        <button type="submit" class="btn btn-sm btn-danger">Confirmar</button>
                    </form>
                <? endif ?>
            </div>
        </section>
    </div>


<script src="js/bootstrap.js"></script>
</body>
</html>