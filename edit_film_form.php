<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar filmes</title>
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="shortcut icon" href="icon/camera-de-cinema.png" type="image/x-icon">
    <style>
        .conteudo{
            max-width: 800px;
            min-width: 200px;
            margin: auto;
            margin-top: 80px; 
            padding: 20px; 
        }

        .form{
            display: flex;
            align-items: center;
            padding: 3px;
            margin-bottom: 10px;
        }

        .form input{
            width: 400px;
            height: 10px;
        }
    </style>
</head>
<body>
    <?php include_once "header.php" ?>
    <div class="container">
    <?php
        # É executado quando tem o SUBMIT
        if(!empty($_POST['titulo']) && !empty($_POST['ano']) && !empty($_POST['diretor']) && !empty($_POST['descricao'])){
    
            $titulo = $_POST['titulo'];
            $ano = $_POST['ano'];
            $genero = $_POST['genero'];
            $diretor = $_POST['diretor'];
            $idade = $_POST['idade'];
            $descricao = $_POST['descricao'];
            $capa = basename($_FILES['img']['name']);
            $dir = "capa/".$capa;

            if($_FILES['img']['name'] != ""){

                if(!getimagesize($_FILES['img']['tmp_name'])){ //verifica se o arquivo é uma imagem
                    echo "<div class='alert alert-danger' role='alert'>
                    <img src='icon/error_black_18dp.svg'> O arquivo enviado não é uma imagem!
                    </div>";

                    $capa = "error";
                } else if($_FILES['img']['size'] >= 1000000){ // Verfifca o tamanho da imagem
                    echo "<div class='alert alert-danger' role='alert'>
                    <img src='icon/error_black_18dp.svg'> O arquivo enviado excede 1MB e não pode ser utilizado
                    </div>";

                    $capa = "error";

                } else if(file_exists($dir)){ //verfica se já existe um arquivo com mesmo nome
                    echo "<div class='alert alert-danger' role='alert'>
                    <img src='icon/error_black_18dp.svg'> Nome do arquivo já existe, altere o para salvar
                    </div>";

                    $capa = "error";
                }
            
            } else{
                $capa = $_POST['capa_original'];
            }

            if($capa == null || $capa != "error"){
                $sql = "UPDATE filmes SET nome_filme = :titulo, ano = :ano, tipo_filme = :genero, idade_filme  = :idade, 
                descricao = :descricao, capa = :capa WHERE id_filme = :id_filme";

                $bind = [":titulo" => $titulo, ":ano" => $ano, ":genero" => $genero,":idade" =>$idade, ":descricao" => $descricao, 
                ":capa" => $capa, ":id_filme" => $_GET['id']];

                $update = $banco->update($sql,$bind);

                if($update){
                    if($capa != null || $capa != $_POST['capa_original']){ // Caso tenha uma imagem, será salva
                        move_uploaded_file($_FILES['img']['tmp_name'],$dir);
                    }

                    $_SESSION['success'] = "<div class='alert alert-success' role='alert'>
                        <img src='icon/check_circle_black_18dp.svg'> Filme editado com sucesso!
                            </div>";
                    header("Location: index.php");
                } else {
                    echo ("<div class='alert alert-danger' role='alert'>
                            <img src='icon/error_black_18dp.svg'> Parece que ocorreu um erro ao cadastrar o filme!
                            </div>");
                }
            }
        }
    
        # Verificando se tem usuário logado e se é ADM
        if(isset($_SESSION['id_usuario']) && isset($_SESSION['nome']) && isset($_SESSION['email']) && isset($_GET['id'])){
            
            if($dados_usuario['tipo_usuario'] === "ADM"){
                $sql_buscaFilme = "SELECT * FROM filmes WHERE id_filme = :id_filme";
                $bind_buscaFilme = [":id_filme" => $_GET['id']];
                $filme = $banco->select($sql_buscaFilme,$bind_buscaFilme)->fetch(PDO::FETCH_ASSOC);
            } else{
                $sql_buscaFilme = "SELECT * FROM filmes WHERE id_usuario = :id_usuario AND id_filme = :id_filme";
                $bind_buscaFilme = [":id_usuario" => $dados_usuario['id_usuario'], ":id_filme" => $_GET['id']];
                $filme = $banco->select($sql_buscaFilme,$bind_buscaFilme)->fetch(PDO::FETCH_ASSOC); 
            }

            
            if(!$filme){
                die("<div class='alert alert-danger' role='alert'>
                <img src='icon/error_black_18dp.svg'> Acesso Indevido!
                </div>");
            } 

        } else {    
            header("Location: index.php");
        }
    ?>
        <section>
            <div class="conteudo">
                <form action="edit_film_form.php?id=<?= $filme['id_filme']?>" enctype="multipart/form-data" method="post">
                    <legend>Editar dados do filme</legend> 

                    <div class="form">
                        <label for="titulo" class="form-label">Titulo :</label>
                        <input type="text" name="titulo" id="titulo" class="form-control form-control-sm" required value="<?= $filme['nome_filme']?>">
                    </div>

                    <div class="form">
                        <label for="ano" class="form-label">Ano de Lançamento: </label>
                        <input type="number" name="ano" id="ano" min="1900" max="2022" class="form-control form-control-sm" required value="<?= $filme['ano']?>"> 
                    </div>

                    <div class="form">
                        <label for="genero">Gênero: </label>
                        <select class="form-select form-select-sm" name="genero" id="genero">
                            <option value="<?= $filme['tipo_filme']?>" default><?= $filme['tipo_filme']?></option>
                            <option value="Ação">Ação</option>
                            <option value="Drama">Drama</option>
                            <option value="Suspense">Suspense</option>
                            <option value="Infantil">Infantil</option>
                            <option value="Ficção Ciêntifica">Ficção Ciêntifica</option>
                            <option value="Aventura">Aventura</option>
                            <option value="Outros">Outros</option>
                        </select>
                    </div>

                    <div class="form">
                        <label for="diretor" class="form-label">Diretor: </label>
                        <input type="text" name="diretor" id="diretor" class="form-control form-control-sm" required value="<?= $filme['diretor']?>">
                    </div>

                    <div class="form">
                        <label for="idade">Classificação Indicativa: </label>
                        <select class="form-select form-select-sm" name="idade" id="idade">
                            <option value="<?= $filme['idade_filme']?>" selected> <?= $filme['idade_filme']?></option>
                            <option value="L">Livre para todos os públicos</option>
                            <option value="10">Não recomendado para menores de 10 anos</option>
                            <option value="12">Não recomendado para menores de 12 anos</option>
                            <option value="14">Não recomendado para menores de 14 anos</option>
                            <option value="16">Não recomendado para menores de 16 anos </option>
                            <option value="18">Não recomendado para menores de 18 anos</option>
                        </select>
                    </div>

                    <div style="margin-top: 3px; margin-bottom: 10px">
                        <label for="img">Capa</label>
                        <div style="width: 600px;">
                            <input type="file" name="img" id="img" class="form-control form-control-sm">
                        </div>
                    </div>

                    <input type="hidden" name="capa_original" value="<?= $filme['capa']?>">

                    <?php if($filme['capa'] != null): ?>
                        <p style="margin-bottom: 0px;"> <strong>Capa padrão</strong> </p>
                        <img src="capa/<?= $filme['capa']?>" height="150px">
                    <?php else: ?>
                        <p style="margin-bottom: 0px;"> <strong>Sem capa</strong> </p>
                    <?php endif ?>
                    
                    <div> 
                        <p style="margin-top: 12px; margin-bottom: 0px;">Descrição</p>
                        <textarea class="form-control" name="descricao" required><?= $filme['descricao']?></textarea>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-sm btn-success">Alterar</button>
                </form>
            </div>
        </section>
    </div>
<script src="js/bootstrap.js"></script>
</body>
</html>