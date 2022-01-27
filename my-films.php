<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus filmes</title>
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="shortcut icon" href="icon/camera-de-cinema.png" type="image/x-icon">
</head>
<body>
    <?php include_once "header.php"; ?>
    <h1 style="text-align: center;">Sinopse de Filmes</h1>
    <div class="container">   
    <?php 
        #verificando se existe usuário logado
        if(isset($_SESSION['id_usuario']) && isset($_SESSION['nome']) && isset($_SESSION['email'])){
            include_once "App/Banco.php";

            $sql = "SELECT * FROM filmes WHERE id_usuario = ".$dados_usuario['id_usuario'];
            $bind = [];

            $filmes = $banco->select($sql, $bind)->fetchAll(PDO::FETCH_ASSOC);
            if(!$filmes){
            die("<div class='alert alert-danger' role='alert'>
                Sem filmes no momento, clique <strong> <a href='adc-filme.php'>Aqui</a> </strong> para adicionar um novo filme!
                </div>");
            }
        
        } else {
            header("Location: index.php");
        }
    ?>

        <section>
            <div class="conteudo">
            <a href="adc-filme.php" class="btn btn-sm btn-warning adc-filme"><img src="icon/plus-circle.svg"> Adicionar filmes</a>
                <table class="table table-dark table-striped">
                    <thead>
                        <th>Capa</th> <th>Titulo</th> <th>Gênero</th> <th>Opções</th>
                    </thead>

                    <tbody>
                        <?php
                            foreach($filmes as $filme){
                                echo "<tr>";
                                if($filme['capa'] != null){
                                    echo "<td class='dado_tabela'><img src='capa/{$filme['capa']}' height=80px></td>";
                                } else {
                                    echo "<td class='dado_tabela'> <img src='capa/sem capa.jpg' height=80px width=50px> </td>";
                                }
                                echo "<td class='dado_tabela'>{$filme['nome_filme']}</td>";
                                echo "<td class='dado_tabela'>{$filme['tipo_filme']}</td>";
                                echo "<td class='dado_tabela'>";
                                echo "<a href='detalhes.php?id={$filme['id_filme']}' class='btn btn-sm btn-primary'> <img src='icon/description_white_18dp.svg'>Descrição</a>";
                                echo "<br><a href='edit_film_form.php?id={$filme['id_filme']}' class='btn btn-sm btn-success'> <img src='icon/edit_note_white_18dp.svg'>Editar</a>";
                                echo "<br><a href='delete_film.php?id={$filme['id_filme']}' class='btn btn-sm btn-danger'> <img src='icon/delete_white_18dp.svg'>Excluir</a>";
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