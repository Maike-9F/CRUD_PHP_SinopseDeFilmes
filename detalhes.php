<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes</title>
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="shortcut icon" href="icon/camera-de-cinema.png" type="image/x-icon">
</head>
<body>
    <?php include_once "header.php"; ?>
    <div class="container">
        <?php
           if(!isset($_GET['id'])){
            header("Location: index.php");
        } else {
            include_once "App/Banco.php";
            $banco = new Banco();
            $sql = "SELECT * FROM filmes WHERE id_filme = :id";
            $bind = [":id"=> $_GET['id']];
            $dados = $banco->select($sql, $bind);
            if($dados == false){
                echo "<div class='alert alert-danger' role='alert'>
                    Ops, Não foi encontrado nenhum filme!    
                </div>";
    
                echo "<a href='index.php' class='btn btn-sm btn-primary'>Voltar a pagina principal</a>";
                die();
            } else{
                $dados = $dados->fetch(PDO::FETCH_ASSOC);
            }
        }
        ?>
        <section>
            <div class="conteudo">
               <div class="card" style="background-color: #212529;">
                    <div class="card-header" style="background-color: #1d1f22;">
                        <h3 class="card-title" style="text-align: center;"><strong>Descrição</strong></h3>
                    </div>
                    <div class="row">
                       <div class="col-md-4">

                           <?php if($dados['capa'] != null): ?>
                                <img src="capa/<?= $dados['capa']?>" class="img-fluid">
                            <?php else: ?>
                                <img src="capa/sem capa.jpg" class="img-fluid">
                            <?php endif ?>
                            
                       </div>
                    <div class="col-md-8" style="background-color: #212529;">
                       
                        <div class="card-body">
                            <p><strong>Titulo: </strong> <?= $dados['nome_filme']?></p>
                            <p><strong>Gênero: </strong> <?= $dados['tipo_filme']?></p>
                            <p><strong>Ano de Lançamento: </strong> <?= $dados['ano']?></p>
                            <p><strong>Diretor: </strong> <?= $dados['diretor']?></p>
                            <p><strong>Classificação Indicativa: </strong> <img src="imgs/<?= $dados['idade_filme']?>.png" width="25px"> </p>
                            <p><strong>Descrição: </strong><?= $dados['descricao']?></p>
                            
                            <?php if(isset($_SESSION['id_usuario']) && isset($_SESSION['nome']) && isset($_SESSION['email'])): ?>

                                <?php if(($dados['id_usuario'] == $dados_usuario['id_usuario']) || $dados_usuario['tipo_usuario'] == "ADM"): ?>
                                    <p>
                                        <a href='edit_film_form.php?id=<?= $dados['id_filme'] ?>' class="btn btn-sm btn-success"><img src="icon/edit_note_white_18dp.svg"> Editar</a>
                                        <a href='delete_film.php?id=<?= $dados['id_filme'] ?>' class="btn btn-sm btn-danger"> <img src="icon/delete_white_18dp.svg"> Excluir</a>
                                    </p>
                                <?php endif ?>
                            <?php endif ?>
                        </div>
                    </div>
                   </div>
               </div>
            </div>
        </section>
    </div>

    
<script src="js/bootstrap.js"></script>
</body>
</html>