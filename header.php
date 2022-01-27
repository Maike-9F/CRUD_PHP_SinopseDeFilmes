<?php session_start();?>
<header>
    <div class="container">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a href="index.php" class="nav-link" style="color: white;"><img src="icon/home.svg"> Pagina Inicial</a>
            </li>
            <?php if(isset($_SESSION['id_usuario']) && isset($_SESSION['nome']) && isset($_SESSION['email'])): ?>
                <li class="nav-item">
                    
                    <a href="my-films.php" class="nav-link" style="color: white;"><img src="icon/movie_white_18dp.svg"> Meus filmes</a>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" style="color: white;" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                        <img src="icon/person_white_18dp.svg">
                        <span>Olá </span> <?= $_SESSION['nome']?>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="edit-user.php"> <img src="icon/edit_black_18dp.svg"> Editar dados</a></li>
                        <li><a class="dropdown-item" href="alter-pass-user.php"> <img src="icon/password_black_18dp.svg"> Alterar senha</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="user.php?delete=true"><img src="icon/delete_black_18dp.svg">  Excluir usuário</a></li>
                        <li><a class="dropdown-item" href="user.php?exit=true"><img src="icon/logout_black_18dp.svg" style="margin-left: 3px;"> Sair</a></li>
                    </ul>
                </li>

              

                <?php
                    include_once "App/Banco.php";
                    $banco = new Banco();
                    $sql = "SELECT id_usuario, email, nome ,tipo_usuario FROM usuarios WHERE email = :email AND id_usuario = :id";
                    $bind = [":email" => $_SESSION['email'], ":id" => $_SESSION['id_usuario']];
                    $dados_usuario = $banco->select($sql,$bind)->fetch(PDO::FETCH_ASSOC);
                ?>
            <?php else: ?>
                <li class="nav-item">
                    <a href="entrar.php" class="nav-link" style="color: white;"> <img src="icon/login_white_24dp.svg"> Entrar</a>
                </li>

                <li class="nav-item">
                    <a href="criar-conta.php" class="nav-link" style="color: white;"> <img src="icon/add_white_24dp.svg"> Criar Conta</a>
                </li>
            <?php endif ?>
            </ul>
    </div>
</header>