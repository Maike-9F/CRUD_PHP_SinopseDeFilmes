<?php
    include_once "App/Banco.php";

    $banco = new Banco();
    $sql = "SELECT * FROM filmes ORDER BY nome_filme";
    $bind = [];
    $dados = $banco->select($sql, $bind)->fetchAll(PDO::FETCH_ASSOC);

?>

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
</head>
<body>
    <?php include "header.php"; ?>
   
    <div class="container">
    <section>
    <?php 
        if(isset($_SESSION['success'])){
            echo $_SESSION['success'];
            unset($_SESSION['success']);
        } 
    ?> 
        <h1 style="text-align: center;">Sinopse de Filmes</h1>
        <div class="conteudo">
           
            <?php if(isset($_SESSION['id_usuario']) && isset($_SESSION['nome']) && isset($_SESSION['email'])): ?>
                <a href="adc-filme.php" class="btn btn-sm btn-warning adc-filme"><img src="icon/plus-circle.svg">Adicionar filmes</a>
            <?php else: ?>
                <p style="text-align: right; margin-bottom: 8px;">Para adicionar filmes crie uma conta ou faça login</p>
            <?php endif ?>

            <table class="table table-dark table-striped">
                <thead>
                    <th>Capa</th> <th>Titulo</th> <th>Gênero</th> <th>Opções</th>
                </thead>

                <tbody>
                    <?php
                        foreach($dados as $dado){
                            echo "<tr>";

                            if($dado['capa'] != null){
                                echo "<td class='dado_tabela'><img src='capa/{$dado['capa']}' height=80px></td>";
                            } else {
                                echo "<td class='dado_tabela'> <img src='capa/sem capa.jpg' height=80px width=50px> </td>";
                            }
                            echo "<td class='dado_tabela'>{$dado['nome_filme']}</td>";
                            echo "<td class='dado_tabela'>{$dado['tipo_filme']}</td>";
                            echo "<td class='dado_tabela opcoes'>";
                            echo "<a href='detalhes.php?id={$dado['id_filme']}' class='btn btn-sm btn-primary'> <img src='icon/description_white_18dp.svg'>Descrição</a>";
                            if(isset($_SESSION['id_usuario'])){
                                if(($_SESSION['id_usuario'] == $dado['id_usuario']) || ($dados_usuario['tipo_usuario'] == "ADM")){
                                    echo "<br><a href='edit_film_form.php?id={$dado['id_filme']}' class='btn btn-sm btn-success'> <img src='icon/edit_note_white_18dp.svg'>Editar</a>";
                                    echo "<br><a href='delete_film.php?id={$dado['id_filme']}' class='btn btn-sm btn-danger'> <img src='icon/delete_white_18dp.svg'>Excluir</a>";
                                }
                                
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>

            
        </div>
        
    </section>
    </div>

<script src="js/bootstrap.js"></script>
</body>
</html>