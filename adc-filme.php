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
    <?php include_once "header.php"; ?>
    <div class="container">

        <?php
            //Verifica se tem usuario logado
            if(isset($_SESSION['id_usuario']) && isset($_SESSION['nome']) && isset($_SESSION['email'])){ 
                include_once "App/Banco.php";

                $banco = new Banco();
                $sql = "SELECT id_usuario, nome,email,tipo_usuario FROM usuarios WHERE id_usuario = :id AND email = :email";
                $bind = [":id" => $_SESSION['id_usuario'], ":email" => $_SESSION['email']];

                $usuario = $banco->select($sql, $bind)->fetch(PDO::FETCH_ASSOC);

                if($usuario == ""){
                    header("Location: entrar.php");
                } 

                if(isset($_POST['titulo']) && isset($_POST['ano']) && isset($_POST['diretor']) && isset($_POST['descricao'])){

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
                            <img src='icon/error_black_18dp.svg'> Nome do arquivo já existe, altere o nome para salvar
                            </div>";

                            $capa = "error";
                        } 

                    } else {
                        $capa = null;
                    }

                    if($capa == null || $capa != "error"){ 

                        $sql = "INSERT INTO filmes (nome_filme, ano, tipo_filme,diretor,idade_filme,descricao,capa,id_usuario) VALUES
                        (:titulo, :ano, :genero, :diretor, :idade, :descricao, :capa, :id_usuario)";

                        $bind = [
                            ":titulo" => $_POST['titulo'], ":ano" => $_POST['ano'], ":genero" => $_POST['genero'], 
                            ":diretor" => $_POST['diretor'], ":idade" => $_POST['idade'], ":descricao" => $_POST['descricao'],
                            ":capa" => $capa, ":id_usuario" => $_SESSION['id_usuario']];

                        $salvar = $banco->insert($sql, $bind);
                        
                        if($salvar){
                            if($capa != null){ // Caso tenha uma imagem, será salva
                               move_uploaded_file($_FILES['img']['tmp_name'],$dir);
                            }
                            
                            $_SESSION['success'] = "<div class='alert alert-success' role='alert'>
                            <img src='icon/check_circle_black_18dp.svg'> Filme cadastrado com sucesso!
                            </div>";
                            header("Location: index.php");
                        } else {
                            echo ("<div class='alert alert-danger' role='alert'>
                            <img src='icon/error_black_18dp.svg'> Parece que ocorreu um erro ao cadastrar o filme!
                            </div>");
                        }

                    }

                }

            } else{
                header("Location: index.php");
            }

        ?>

        <section>
            <div class="conteudo">
                <form action="adc-filme.php" enctype="multipart/form-data" method="POST">
                    <legend>Dados do filme</legend>
                    <div class="form">
                        <label for="titulo" class="form-label">Titulo :</label>
                        <input type="text" name="titulo" id="titulo" class="form-control form-control-sm" required>
                    </div>
                    
                    <div class="form">
                        <label for="ano" class="form-label">Ano de Lançamento: </label>
                        <input type="number" name="ano" id="ano" min="1900" max="2022" class="form-control form-control-sm" required>
                    </div>

                    <div class="form">
                        <label for="genero">Gênero: </label>
                        <select class="form-select form-select-sm" name="genero" id="genero">
                            <option value="Ação" selected>Ação</option>
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
                        <input type="text" name="diretor" id="diretor" class="form-control form-control-sm" required>
                    </div>
                    
                    <div class="form">
                        <label for="idade">Classificação Indicativa: </label>
                        <select class="form-select form-select-sm" name="idade" id="idade">
                            <option value="L" selected>Livre para todos os públicos</option>
                            <option value="10">Não recomendado para menores de 10 anos</option>
                            <option value="12">Não recomendado para menores de 12 anos</option>
                            <option value="14">Não recomendado para menores de 14 anos</option>
                            <option value="16">Não recomendado para menores de 16 anos </option>
                            <option value="18">Não recomendado para menores de 18 anos</option>
                        </select>
                    </div>

                    <div style="margin-top: 3px; margin-bottom: 10px">
                        <label for="img">Adicione uma capa ao seu filme</label>
                        <div style="width: 600px;">
                            <input type="file" name="img" id="img" class="form-control form-control-sm">
                        </div>
                        <small>Não é obrigatorio</small>
                    </div>

                    <div class="form-floating form"> 
                        <textarea class="form-control" name="descricao" id="floatingTextarea" required></textarea>
                        <label for="floatingTextarea">Descrição</label>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary">Adicionar</button>
                </form>
            </div>
        </section>
    </div>

<script src="js/bootstrap.js"></script>
</body>
</html>