<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
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
    <?php 
        include_once "header.php";
        
        if(!isset($_SESSION['id_usuario']) || !isset($_SESSION['nome']) || !isset($_SESSION['email'])){
            header("Location: index.php");
        } else if (isset($_POST['nome']) && isset($_POST['email'])){
            include_once "App/Banco.php";
            $Banco = new Banco();
            $sql = "UPDATE usuarios SET nome = :nome, email = :email WHERE id_usuario = :id";
            $bind = [":nome" => $_POST['nome'], ":email" => $_POST['email'], ":id" => $_SESSION['id_usuario']];
            $result = $Banco->update($sql, $bind);
            
            if($result){
                $_SESSION['success'] = "<div class='alert alert-success' role='alert'>
                <img src='icon/check_circle_black_18dp.svg'> Dados do usuário alterados com sucesso!
                </div>";

                #Atualizar sessão
                $sql = "SELECT nome, email FROM usuarios WHERE id_usuario = :id";      
                $bind = [":id" => $_SESSION['id_usuario']];          
                $dados = $Banco->select($sql, $bind)->fetch(PDO::FETCH_ASSOC);
                $_SESSION['nome'] = $dados['nome'];
                $_SESSION['email'] = $dados['email'];
                
                #Redirecionar para pagina principal
                header("Location: index.php");
            } else {
                echo "<div class='alert alert-danger' role='alert'>
                <img src='icon/error_black_18dp.svg'> Ocorreu um erro ao tentar alterar os dados!
                </div>";
            }
        }
    ?>
    <div class="container">
        <section>
            <div class="conteudo">
                <form action="edit-user.php" method="post">
                    <legend>Altere os dados</legend>
                    <div style="margin-bottom: 15px;">
                        <label for="nome" class="form-label">Nome: </label>
                        <input type="text" name="nome" id="nome" class="form-control form-control-sm" value="<?= $dados_usuario['nome']?>" required autocomplete="off">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= $dados_usuario['email']?>" required autocomplete="off">
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary">Alterar</button>
                </form>
            </div>
        </section>
    </div>

 
<script src="js/bootstrap.js"></script>
</body>
</html>