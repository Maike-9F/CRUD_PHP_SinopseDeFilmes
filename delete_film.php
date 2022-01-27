<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir filme</title>
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
            text-align: center;
        }
    </style>
</head>
<body>
    <?php 
        include_once "header.php"; 

        #Verifica se tem usuario logado e se tem o GET com o id do filme
        if((!isset($_SESSION['id_usuario']) || !isset($_SESSION['email'])) || !isset($_GET['id'])){ 
            header("Location: index.php");
        } else{
            include_once "App/Banco.php";
            $banco = new Banco();

            #Verificar se o filme existe
            $sql = "SELECT * FROM filmes WHERE id_filme = :id";
            $bind = [":id" => $_GET['id']];
            $dados_filme = $banco->select($sql,$bind)->fetch(PDO::FETCH_ASSOC);
            if($dados_filme == ""){
                die("<div class='alert alert-danger' role='alert'>
                <img src='icon/error_black_18dp.svg'> Filme não encontrado!
                </div>");
            }

            #caso tenha Submit o filme será excluido ou não
            if(isset($_POST['S'])){
                $sql_delete = "DELETE FROM filmes WHERE id_filme = :id";
                $exclusao = $banco->delete($sql_delete, $bind);
                if($exclusao){
                    $_SESSION['success'] = "<div class='alert alert-success' role='alert'>
                        <img src='icon/check_circle_black_18dp.svg'> Filme excluido com sucesso!
                        </div>";
                            
                    header("Location: index.php");
                } else {
                    echo "<div class='alert alert-danger' role='alert'>
                    <img src='icon/error_black_18dp.svg'> Ocorreu um erro ao excluir o filme
                    </div>";
                }
            } else if(isset($_POST['N'])){
                header("Location: index.php");
            }

        }

        
    ?>

    <div class="container">
        <section>
            <div class="conteudo">

                <!--Verificar se o filme pertence ao usuario logado ou se o usuario é ADM -->
                <?php if(($dados_usuario['id_usuario'] == $dados_filme['id_usuario']) || $dados_usuario['tipo_usuario'] == "ADM"): ?>
                    <p>Deseja excluir o filme <strong> <?= $dados_filme['nome_filme']?>?</strong> </p>
                    <form method="post">
                        <button type="submit" name="S" class="btn btn-sm btn-danger">Sim</button>
                        <button type="submit" name="N" class="btn btn-sm btn-success">Não</button>
                    </form>

                <?php else: ?>
                    <div class='alert alert-danger' role='alert'>Acesso Indevido!</div>
                <?php endif ?>
            </div>
        </section>
    </div>
<script src="js/bootstrap.js"></script>
</body>
</html>