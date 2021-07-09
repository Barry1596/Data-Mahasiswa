
<?php


$conn = mysqli_connect("localhost", "root", "", "mahasiswa");

require 'functions.php';


if(isset($_POST["registrasi"])){

    if(registrasi($_POST) > 0){
        echo "
        <script>
            alert('data akun berhasil ditambahkan !');
            document.location.href = 'login.php';
        </script>";
    } else {
        echo "
        <script>
            alert('data akun gagal ditambahkan !');
            document.location.href = 'login.php';
        </script>";
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrai</title>
</head>
<body>

<h1>Registrasi AKun</h1>



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
                <label for="password2">Konfirmasi Password :</label>
                <input type="password" name="password2" required>
            </li>

            <li>
                <button type="submit" name="registrasi"> Registrasi </button>
            </li>
</ul>

</form>
    
</body>
</html>