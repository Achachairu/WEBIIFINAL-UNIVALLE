<?php
require_once 'db_con.php';
session_start();

if (isset($_SESSION['user_login'])) {
    header('Location: index.php');
    exit();
}

$input_arr = [];

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        $input_arr['input_user_error'] = "Username Is Required!";
    }

    if (empty($password)) {
        $input_arr['input_pass_error'] = "Password Is Required!";
    }

    if (count($input_arr) == 0) {
        $query = "SELECT * FROM `users` WHERE `username` = '$username';";
        $result = mysqli_query($db_con, $query);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row['password'] == sha1(md5($password))) {
                if ($row['status'] == 'activo') {
                    $_SESSION['user_login'] = $username;
                    header('Location: index.php');
                    exit();
                } else {
                    $status_inactive = "Su estado está inactivo, póngase en contacto con el administrador o el soporte";
                }
            } else {
                $wrong_pass = "Contraseña o Usuario Incorrectos!";
            }
        } else {
            $username_err = "Usuario no encontrado";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Acceso Administrativo</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="container">
        <br>
        <h1 class="text-center">Acceso Administrativo</h1>
        <hr>
        <br>
        <div class="d-flex justify-content-center">
            <?php if (isset($username_err)): ?>
                <div role="alert" aria-live="assertive" aria-atomic="true" align="center" class="toast alert alert-danger fade hide" data-delay="2000">
                    <?=$username_err;?>
                </div>
            <?php endif;?>
            <?php if (isset($wrong_pass)): ?>
                <div role="alert" aria-live="assertive" aria-atomic="true" align="center" class="toast alert alert-danger fade hide" data-delay="2000">
                    <?=$wrong_pass;?>
                </div>
            <?php endif;?>
            <?php if (isset($status_inactive)): ?>
                <div role="alert" aria-live="assertive" aria-atomic="true" align="center" class="toast alert alert-danger fade hide" data-delay="2000">
                    <?=$status_inactive;?>
                </div>
            <?php endif;?>
        </div>
        <div class="row animate__animated animate__pulse">
            <div class="col-md-4 offset-md-4">
                <form method="POST" action="">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="username" value="<?=isset($username) ? $username : '';?>" placeholder="Usuario" id="inputEmail3">
                            <?=isset($input_arr['input_user_error']) ? '<label>' . $input_arr['input_user_error'] . '</label>' : '';?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Contraseña">
                            <?=isset($input_arr['input_pass_error']) ? '<label>' . $input_arr['input_pass_error'] . '</label>' : '';?>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="login" class="btn btn-primary">Ingresar</button>
                        <button type="button" class="btn btn-secondary" onclick="history.back()">Volver</button>
                    </div>
                    <p>No tienes cuenta? <a href="register.php">Registrate aquí</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $('.toast').toast('show');
    </script>
</body>

</html>

