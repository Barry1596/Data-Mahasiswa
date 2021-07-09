<?php

require '../functions.php';

$mahasiswa = cari($_GET["keyword"]);



?>

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
    <td><?= $i;?></td>
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