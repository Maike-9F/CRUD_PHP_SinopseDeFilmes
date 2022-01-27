<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Inicial</title>
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="shortcut icon" href="icon/camera-de-cinema.png" type="image/x-icon">
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
    <?php include_once "header.php" ?>

    <div class="container">
    <?php  

        if(!isset($_SESSION['id_usuario']) || !isset($_SESSION['nome']) || !isset($_SESSION['email'])){
            header("Location: index.php");
        } else if(isset($_POST['senha-atual']) && isset($_POST['senha-nova'])){
            include_once "App/Banco.php";
            $banco = new Banco();
            $sql_verificar = "SELECT senha FROM usuarios WHERE id_usuario = :id";
            $bind_verficar = [":id" => $_SESSION['id_usuario']];

            $verificaSenha = $banco->select($sql_verificar,$bind_verficar)->fetch(PDO::FETCH_ASSOC);

            if($verificaSenha['senha'] != md5($_POST['senha-atual'])){
                echo ("<div class='alert alert-danger' role='alert'>
                    <img src='icon/error_black_18dp.svg'> Senha incorreta! Tente novamente
                     </div>");
                $banco->desconectar();
            } else if(strlen($_POST['senha-nova']) <=5){
                echo ("<div class='alert alert-danger' role='alert'>
                    <img src='icon/error_black_18dp.svg'> A nova senha deverá conter no minimo 6 caracteres!
                     </div>");
                $banco->desconectar();
            } else {
                $sql = "UPDATE usuarios SET senha = :senha WHERE id_usuario = :id";
                $bind = [":senha" => md5($_POST['senha-nova']), ":id" => $_SESSION['id_usuario']];

                $result = $banco->update($sql,$bind);
                if($result == true){
                    $_SESSION['success'] = "<div class='alert alert-success' role='alert'>
                    <img src='icon/check_circle_black_18dp.svg'>  Senha alterada com sucesso!
                    </div>";
                    $banco->desconectar();
                    header("Location: index.php");
                } else {
                    echo ("<div class='alert alert-danger' role='alert'>
                    <img src='icon/error_black_18dp.svg'> Ocorreu algum erro ao tentar alterar a senha!
                    </div>");
                     $banco->desconectar();
                }
            }
        }

    ?>
    
        <section>
            <div class="conteudo">
                <form action="alter-pass-user.php" method="post">
                    <legend>Alteração de senha</legend>
                    <div style="margin-bottom: 15px;">
                        <label for="senha-atual" class="form-label">Digite a sua senha atual: </label>
                        <input type="password" name="senha-atual" id="senha-atual" class="form-control" required>
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <label for="senha-nova" class="form-label">Digite a sua nova senha: </label>
                        <input type="password" name="senha-nova" id="senha-nova" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary">Alterar</button>
                </form>
            </div>
        </section>
    </div>

<script src="js/bootstrap.js"></script>
</body>
</html>