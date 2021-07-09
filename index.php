<?php 

session_start();

if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

//koneksi ke database
require 'functions.php';

//pagination

//konfigurasi
$jumlah_data_per_halaman = 2;

$jumlah_data = count(query("SELECT * FROM mahasiswa"));

$jumlah_halaman = ceil($jumlah_data/$jumlah_data_per_halaman);

$halaman_aktif = ( isset($_GET["halaman"])) ? $_GET["halaman"] : 1;

$awal_data = ($jumlah_data_per_halaman*$halaman_aktif) - $jumlah_data_per_halaman;


$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awal_data, $jumlah_data_per_halaman");

//ketika tombol cari di klik

if(isset($_POST["cari"])){

    $mahasiswa = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>

    <style>
        .loader {
            width: 150px;
            position: absolute;
            top: 100px;
            z-index: -1;
            left: 300px;
            display: none;
        }

        .tombol-cetak{
            text-decoration: none;
            font-weight: bold;
            color: black;
            margin: 10px auto;
        }



       
        

        @media print {
            .logout ,.tambah, .form-cari, .aksi {
                display: none;
            }
        }
    
    </style>
</head>
<body>

<a href="logout.php" class="logout">Logout</a>  | <button class="tombol-cetak" class="print"><a href="cetak.php" target="_blank" class="tombol-cetak" class="print"><img src="img/print.png" class="print" style="width: 30px;"></img>Cetak</a></button>

<h1>Daftar Mahasiswa</h1>

<a href="tambah.php" class="tambah">Tambah Data Mahasiswa</a>
<br><br>

<form action="" method="post" class="form-cari">
    <input type="text" name="keyword" size="40" placeholder="masukkan keyword pencarian... " autocomplete="off" autofocus class="keyword">
    <button type="submit" name="cari" class="tombol-cari"> Cari !</button>

    <img src="img/loader.gif" alt="" class="loader">
</form>

<br>

<!--- navigasi ---->
<?php if($halaman_aktif > 1) : ?>
    <a href="?halaman=<?= $halaman_aktif - 1; ?>">&laquo;</a>
<?php endif;?>


<?php for($i = 1; $i<$jumlah_halaman;$i++):?>

    <?php if($i == $halaman_aktif) : ?>
        <a href="?halaman=<?=$i;?>" style="font-weight: bold; color: red;"><?=$i;?></a>
    <?php  else :?>
        <a href="?halaman=<?=$i;?>"><?=$i;?></a>
    <?php  endif;?>

    

<?php endfor;?>

<?php if($halaman_aktif < $jumlah_halaman) : ?>
    <a href="?halaman=<?= $halaman_aktif + 1; ?>">&raquo;</a>
<?php endif;?>

<br>


<br>



<div class="container">

    <table border="1" cellpadding="10" cellspacing="0">

        <tr>
            <th>No. </th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>NRP</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>

        <?php if(empty($mahasiswa)) :?>

        <tr>
            <td colspan="7"><p>Data mahasiswa tak ditemukan!</p></td>
        </tr>

        <?php endif;?>


        <?php $i=1; ?>

        <?php foreach($mahasiswa as $row) : ?>
        <tr>
            <td class="aksi"><?= $i;?></td>
            <td>
                <a href="ubah.php?id=<?=$row["id"];?>" onclick= "return confirm('Apakah Anda Yakin Akan mengubah datanya ?');">ubah</a> |   
                <a href="hapus.php?id=<?= $row["id"];?>"  onclick= "return confirm('Apakah Anda Yakin Akan menghapus datanya ?');">hapus</a>
            </td>
                
            <td><img src="img/barry.jpg" alt="" width="100"> |<?= $row['gambar'];?></td>
            <td><?= $row['nrp'];?></td>
            <td><?= $row['nama'];?></td>
            <td><?= $row['email'];?></td>
            <td><?= $row['jurusan'];?></td>

        </tr>
        <?php $i++;?>
        <?php endforeach;?>


    </table>
</div>
    <script src="js/script.js"></script>
</body>
</html>