<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="shortcut icon" href="icon/camera-de-cinema.png" type="image/x-icon">
    <style>
        .conteudo{
            max-width: 600px;
            min-width: 200px;
            margin: auto;
            margin-top: 80px;  
            padding: 20px;
        }
    </style>
</head>
<body>

<?php include_once "header.php"; ?>
    <div class="container">

        <?php

            if(isset($_POST['email']) && isset($_POST['senha'])){
                include_once "App/Banco.php";

                $banco = new Banco();
                $email = $_POST['email'];
                $senha = md5($_POST['senha']);
                $sql = "SELECT id_usuario, nome, email, tipo_usuario FROM usuarios WHERE email = :email AND email IN (SELECT email FROM usuarios WHERE senha = :senha)";
                $bind = [":email" => $email, ":senha" => $senha];

                $dados = $banco->select($sql, $bind)->fetch(PDO::FETCH_ASSOC);
                
                if($dados != ""){
                    $_SESSION['id_usuario'] = $dados['id_usuario'];
                    $_SESSION['nome'] = $dados['nome'];
                    $_SESSION['email'] = $dados['email'];

                    $banco->desconectar();
                    header("Location: index.php");
                } else {
                    $banco->desconectar();
                    echo "<div class='alert alert-danger' role='alert'>
                    Os dados inseridos estão incorretos
                    </div>";
                  
                }
                
            }
        ?>

        <section>
            <div class="conteudo">
                <form action="entrar.php" method="post">
                    <legend>Insira os dados abaixo</legend>
                    <div style="margin-bottom: 15px;">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" class="form-control form-control-sm" name="email" id="email" required>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="senha" class="form-label">Senha:</label>
                        <input type="password" class="form-control form-control-sm" name="senha" id="senha" required>
                    </div>

                    <button type="submit" class="btn btn-sm btn-success">Entrar</button>

                </form>
            </div>
        </section>
    </div>


<script src="js/bootstrap.js"></script>
</body>
</html>