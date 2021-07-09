<?php


$conn = mysqli_connect("localhost", "root", "", "mahasiswa");

function query($query){

    global $conn;
    
    $result = mysqli_query($conn, $query);

    $rows = [];

    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }

    return $rows;
}

function upload(){
    
    $nama_file = $_FILES["gambar"]["name"];

    $tipe_file = $_FILES["gambar"]["type"];

    $ukuran_file = $_FILES["gambar"]["size"];

    $error = $_FILES["gambar"]["error"];

    $tmp_file = $_FILES["gambar"]["tmp_name"];

    //ketika tidak ada gambar yang dipilih
    if($error == 4){
        echo "<script>
                alert('Pilih Gambar Terlebih Dahulu !');
        </script>";

        return false;
    }

    //cek ekstensi file

    $daftar_gambar = ['jpg', 'jpeg', 'png', 'gif'];

    $ekstensi_file = explode('.', $nama_file);

    $ekstensi_file = end($ekstensi_file);

    $ekstensi_file = strtolower($ekstensi_file);

    if(!in_array($ekstensi_file, $daftar_gambar)){
        echo "<script>
                alert('File yang Anda Pilih Bukan GAMBAR !');
        </script>";
        return false;
    }

    //cek type file
    if($tipe_file != 'image/jpeg' && $tipe_file != 'image/png'){

        echo "<script>
                alert('File yang Anda Pilih Bukan GAMBAR !');
        </script>";
        return false;

    }

    //cek ukuran file
    //maksimal 5 MB == 5000000 Byte
    if($ukuran_file > 5000000){

        echo "<script>
                alert('Ukuran File Terlalu Besar!');
        </script>";
        return false;

    }

    //lolos pengecekan
    //generate nama file baru
    $nama_file_baru = uniqid();

    $nama_file_baru .= '.';

    $nama_file_baru .= $ekstensi_file;

    move_uploaded_file($tmp_file, 'img/' . $nama_file_baru);

    return $nama_file_baru;


}



function tambah($data){

    global $conn;

    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    // $gambar = htmlspecialchars($data["gambar"]);

    $gambar = upload();

    if(!$gambar){
        return false;
    }

    $query = "INSERT INTO mahasiswa VALUES ('', '$nama', '$nrp', '$email', '$jurusan', '$gambar')";


    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function hapus($id){
    global $conn;

    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id=$id");

    return mysqli_affected_rows($conn);
}


function ubah($data){

    global $conn;

    $id = $data["id"];
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    $gambarLama = htmlspecialchars($data["gambarLama"]);

    //cek apakah user pilih gambar baru atau tidak
    if($_FILES["gambar"]["error"] === 4){
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    $query = "UPDATE mahasiswa SET 
                    nrp = '$nrp', 
                    nama = '$nama',
                    email = '$email',
                    jurusan = '$jurusan',
                    gambar = '$gambar'
            WHERE id=$id";


    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}



function cari($keyword){

    global $conn;

    $query = "SELECT * FROM mahasiswa 
                WHERE 
                nama LIKE '%$keyword%' OR

                nrp LIKE '%$keyword%' OR

                email LIKE '%$keyword%' OR

                jurusan LIKE '%$keyword%' OR

                gambar LIKE '%$keyword%' 
                
                ";

    $result = mysqli_query($conn, $query);


    $rows = [];

    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }

    return $rows;
}

function login($data){

    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);



    if(query("SELECT * FROM user WHERE username = '$username' && passwords = '$password'")){

        //Set Sesion
        $_SESSION["login"] = true;
        header("Location: index.php");
        exit;

        
    } else {
        return [
            'error' => true,
            'pesan' => 'Username / Password Salah!'
        ];
    }
}

function registrasi($data){
    global $conn;

    $username = htmlspecialchars($data["username"]);

    $password = htmlspecialchars($data["password"]);

    $password1 = htmlspecialchars($data["password2"]);

    if(empty($username) || empty($password) || empty($password1)){
        echo "
            <script>
                alert('username / password tidak boleh kosong !');
                document.location.href = 'registrasi.php';
            </script>
        ";
        return false;
    }

    if(query("SELECT * FROM user WHERE username = '$username'")){

        echo "
            <script>
                alert('Username sudah terdaftar!');
                document.location.href = 'registrasi.php';
            </script>
        ";
        return false;

    }

    if( $password !== $password1){

        echo "
            <script>
                alert('Konfirmasi Password Tidak Sesuai!');
                document.location.href = 'registrasi.php';
            </script>
        ";
        return false;

    }

    //Jika password < 5 digit

    if( strlen($password) < 5){

        echo "
            <script>
                alert('Password Terlalu Pendek!');
                document.location.href = 'registrasi.php';
            </script>
        ";
        return false;

    }

    //Jika password dan username sudah sesuai

    $password_baru = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO user VALUES ('','$username','$password')";

    mysqli_query($conn, $query) or die(mysqli_error($conn));

    return mysqli_affected_rows($conn);

}



?>