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
    <?php include_once "header.php";?>
    <div class="container">

        <?php

            if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])){   //Verifica se os dados foram preenchidos
                if($_POST['senha'] != $_POST['confirmaSenha']){     //Vefifica se a senha foi digitada corretamente
                    echo ("<div class='alert alert-danger' role='alert'>
                    <img src='icon/error_black_18dp.svg'> As senhas estão diferentes!
                     </div>");
                } else if (strlen($_POST['senha']) <=5 ){   //Verifica se a senha possui acima de 6 caracteres
                    echo ("<div class='alert alert-danger' role='alert'>
                    <img src='icon/error_black_18dp.svg'> A senha deverá conter no mínimo 6 caracteres!
                        </div>");
                } else{
                    include_once "App/Banco.php";
                    $banco = new Banco();
                    
                    //Verifica se o email informado já está cadastrado
                    $bindEmail = [":email"=> $_POST['email']];
                    $verificaEmail = $banco->select("SELECT email FROM usuarios WHERE email = :email", $bindEmail)->fetch(PDO::FETCH_ASSOC);
                    if($verificaEmail != ""){
                        echo ("<div class='alert alert-danger' role='alert'>
                        <img src='icon/error_black_18dp.svg'> O E-mail informado já está cadastrado!
                        </div>");
                        $banco->desconectar();
                    /////////////////////////////////////////////////////////////////////////
                    
                    } else {
                        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
                        $bind = [":nome" => $_POST['nome'], ":email" => $_POST['email'], ":senha" => md5($_POST['senha'])];
                        $criarUsuario = $banco->insert($sql, $bind);

                        if($criarUsuario == true){
                            $sql_buscarUser = "SELECT id_usuario, nome, email FROM usuarios WHERE email = :email";
                            $bind = [":email" => $_POST['email']];
                            $dados = $banco->select($sql_buscarUser,$bind)->fetch(PDO::FETCH_ASSOC);

                            $_SESSION['id_usuario'] = $dados['id_usuario'];
                            $_SESSION['nome'] = $dados['nome'];
                            $_SESSION['email'] = $dados['email'];

                            $_SESSION['success'] = "<div class='alert alert-success' role='alert'>
                            <img src='icon/check_circle_black_18dp.svg'> Usuario cadastrado com sucesso!
                            </div>";

                            header("Location: index.php");
                        } else {
                           echo "<div class='alert alert-danger' role='alert'>
                           <img src='icon/error_black_18dp.svg'> Ocorreu algum erro ao cadastrar o usuario!
                            </div>";
                        }

                        $banco->desconectar();
                    }
                }
            }

           
        ?>
        
        <section>
            <div class="conteudo">
                <form action="criar-conta.php" method="post" name="form-criar-usuario">
                    <legend>Preencha as informações abaixo</legend>

                    <div style="margin-bottom: 15px;">
                        <label for="nome" class="form-label">Nome: </label>
                        <input type="text" name="nome" class="form-control form-control-sm" id="nome" size="40" required>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" name="email" id="email" class="form-control form-control-sm" aria-describedby="dica" autocomplete="off" required>
                        <small id="dica" class="form-text">Não precisa ser um e-mail real</small>
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <label for="senha" class="form-label">Senha: </label>
                        <input type="password" name="senha" id="senha" class="form-control form-control-sm" required>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="confirmaSenha" class="form-label">Repita a senha</label>
                        <input type="password" name="confirmaSenha" class="form-control form-control-sm" id="onfirmaSenha" required>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary" name="submit-criar">Criar conta</button>
                </form>
            </div>
        </section>
    </div>


<script src="js/bootstrap.js"></script>
</body>
</html>