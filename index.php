<?php 
require_once("conexao.php");

//RETIRAR ISSO DEPOIS
//Criar um Usuário Super com nivel de admin padrão
$query = $pdo->query("SELECT * FROM usuarios where nivel = 'Administrador'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = count($res);

if($total_reg == 0)
$pdo->query("INSERT INTO usuarios SET nome = 'Administrador', email = 'contato@gmail.com', cpf = '000.000.000-00', senha = '123', nivel = 'Administrador' ");

 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $nome_sistema ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="vendor/login/images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/login/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/login/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/login/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/login/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/login/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/login/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <!--<link rel="stylesheet" type="text/css" href="vendor/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="vendor/login/css/main.css"> -->

    <link rel="shortcut icon" href="img/favicon.ico" />

    <!--===============================================================================================-->
    <style>
    body,
    html {
        height: 100%;
        margin: 0;
        font-family: 'Poppins', sans-serif;
    }

    .limiter {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: url('vendor/login/images/bg-01.jpg') no-repeat center center/cover;
    }

    .wrap-login100 {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    .login100-form-title img {
        display: block;
        margin: 0 auto 20px;
    }

    .wrap-input100 {
        position: relative;
        margin-bottom: 20px;
    }

    .input100 {
        width: 100%;
        padding: 15px 40px 15px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .focus-input100 {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        color: #1370e1;
        /* Cor aplicada ao ícone de foco */
    }

    .login100-form-btn {
        background-color: #1370e1;
        /* Cor principal */
        color: white;
        border: none;
        border-radius: 5px;
        padding: 15px;
        width: 100%;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .login100-form-btn:hover {
        background-color: #0f5bbd;
        /* Cor mais escura para o hover */
    }
    </style>
</head>

<body>

    <div class="limiter">
        <div class="wrap-login100">
            <span class="login100-form-title">
                <img src="img/logotipo_sm.png" width="180" alt="Logo">
            </span>
            <form class="login100-form" method="POST" action="autenticar.php">
                <div class="wrap-input100">
                    <input class="input100" type="text" name="usuario" placeholder="Email ou CPF" required>
                    <span class="focus-input100"><i class="fas fa-user"></i></span>
                </div>
                <div class="wrap-input100">
                    <input class="input100" type="password" name="senha" placeholder="Senha" required>
                    <span class="focus-input100"><i class="fas fa-lock"></i></span>
                </div>
                <div class="container-login100-form-btn">
                    <button type="submit" class="login100-form-btn">Entrar</button>
                </div>
            </form>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="vendor/login/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/login/vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/login/vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/login/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/login/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/login/vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/login/vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/login/vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/login/js/main.js"></script>

</body>

</html>