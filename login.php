<?php 

session_start();


if(isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
}

require 'functions.php';

if(isset($_POST["login"])){

    $login = login($_POST);

    
    if(isset($_POST["remember"])){
        setcookie('login','true', time()+60);
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<h3>Form Login</h3>
<?php if(isset($login["error"])) :?>

<p style="color: red; font-style:italic;"><?= $login["pesan"];?></p>

<?php endif;?>

<form action="" method="post">

    <ul>
            <li>
                <label for="username">Username :</label>
                <input type="text" name="username" required autofocus autocomplete="off" required>
            </li>

            <li>
                <label for="password">Password :</label>
                <input type="password" name="password" required>
            </li>

            <li>

                <input type="checkbox" name="remember" required>
                <label for="remember">Remember me</label>
                

            </li>

            <li>
                <button type="submit" name="login"> Login </button>
            </li>

            <li>
                <a href="registrasi.php">Registrasi</a>
            </li>
    </ul>

</form>
    
</body>
</html>