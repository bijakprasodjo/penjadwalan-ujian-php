<?php
session_start();

$c = mysqli_connect('localhost','root','','sa');

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($c,"SELECT * FROM user WHERE username ='$username' and password='$password'");
    $hitung = mysqli_num_rows($check);

    if($hitung>0){
        $_SESSION['login'] = 'True';
        header('location:index.php');
    }else{
        echo '
        <script>alert("Username atau password salah");
        window.location.href="login.php"
        </script>
        ';
    }
}

if(isset($_POST['tambahmatkul'])){
    $namamatkul = $_POST['namamatkul'];
    $sks = $_POST['sks'];
    $kelas = $_POST['kelas'];

    $insert = mysqli_query($c,"insert into mata_kuliah (namamatkul,sks,kelas) values ('$namamatkul','$sks','$kelas')");

    if($insert){
        header('location:matkul.php');
    }else{
        echo '
        <script>alert("Gagal menambah mata kuliah baru");
        window.location.href="matkul.php"
        </script>
        ';
    }
}

if(isset($_POST['tambahdosen'])){
    $namadosen = $_POST['namadosen'];
    $namamatkul = $_POST['namamatkul'];
    $kelas = $_POST['kelas'];

    $insert = mysqli_query($c,"insert into dosen (namadosen,namamatkul,kelas) values ('$namadosen','$namamatkul','$kelas')");
    
    if($insert){
        header('location:dosen.php');
    }else{
        echo '
        <script>alert("Gagal menambah nama dosen baru");
        window.location.href="dosen.php"
        </script>
        ';
    }
}

if(isset($_POST['tambahgedung'])){
    $namagedung = $_POST['namagedung'];
    $nomorruangan = $_POST['nomorruangan'];
    $jam = $_POST['jam'];
    $sampai = $_POST['sampai'];
    $hari = $_POST['hari'];

    $insert = mysqli_query($c,"insert into ruangan_kosong (namagedung,nomorruangan,jam,sampai,hari) values ('$namagedung','$nomorruangan','$jam','$sampai','$hari')");
    
    if($insert){
        header('location:ruangan.php');
    }else{
        echo '
        <script>alert("Gagal menambah nama ruangan baru");
        window.location.href="ruangan.php"
        </script> 
        ';
    }
}
if(isset($_POST['tambahjadwal'])){
    $namamatkul = $_POST['namamatkul'];
    $sks = $_POST['sks'];
    $kelas = $_POST['kelas'];
    $namadosen = $_POST['namadosen'];

    $insert = mysqli_query($c,"insert into jadwal (namamatkul,sks,kelas,namadosen) values ('$namamatkul','$sks',' $kelas','$namadosen')");
    
    if($insert){
        header('location:index.php');
    }else{
        echo '
        <script>alert("Gagal menambah nama ruangan baru");
        window.location.href="index.php"
        </script>
        ';
    }
}
if(isset($_POST['hapusmatkul'])){
    $idmatkul = $_POST['idmatkul'];

    $hapus = mysqli_query($c,"delete from mata_kuliah where idmatkul='$idmatkul'");
    
    if($hapus){
        header('location:matkul.php?idmatkul='.$idmatkul);
    }else{
        echo '
        <script>alert("Gagal menghapus data);
        window.location.href="matkul.php?idmatkul='.$idmatkul.'"
        </script>
        ';
    }
}

if(isset($_POST['editmatkul'])){
    $idmatkul = $_POST['idmatkul'];
    $namamatkul = $_POST['namamatkul'];
    $sks = $_POST['sks'];
    $kelas = $_POST['kelas'];

    $query = mysqli_query($c,"update mata_kuliah set namamatkul='$namamatkul',sks='$sks',kelas='$kelas' where idmatkul='$idmatkul'");

    
    if($query){
        header('location:matkul.php');
    }else{
        echo '
        <script>alert("Gagal menghapus data);
        window.location.href="matkul.php"
        </script>
        ';
    }
}
if(isset($_POST['hapusdosen'])){
    $iddosen = $_POST['iddosen'];

    $hapus = mysqli_query($c,"delete from dosen where iddosen='$iddosen'");
    
    if($hapus){
        header('location:dosen.php?iddosen='.$iddosen);
    }else{
        echo '
        <script>alert("Gagal menghapus data);
        window.location.href="dosen.php?iddosen='.$iddosen.'"
        </script>
        ';
    }
}

if(isset($_POST['editdosen'])){
    $iddosen = $_POST['iddosen'];
    $namadosen = $_POST['namadosen'];
    $namamatkul = $_POST['namamatkul'];
    $kelas = $_POST['kelas'];

    $query = mysqli_query($c,"update dosen set namadosen='$namadosen',namamatkul='$namamatkul',kelas='$kelas' where iddosen='$iddosen'");

    
    if($query){
        header('location:dosen.php');
    }else{
        echo '
        <script>alert("Gagal menghapus data);
        window.location.href="dosen.php"
        </script>
        ';
    }
}

if(isset($_POST['hapusruangan'])){
    $idruangan = $_POST['idruangan'];

    $hapus = mysqli_query($c,"delete from ruangan_kosong where idruangan='$idruangan'");
    
    if($hapus){
        header('location:ruangan.php?idruangan='.$idruangan);
    }else{
        echo '
        <script>alert("Gagal menghapus data);
        window.location.href="idruangan.php?idruangan='.$idruangan.'"
        </script>
        ';
    }
}

if(isset($_POST['editruangan'])){
    $idruangan = $_POST['idruangan'];
    $namagedung = $_POST['namagedung'];
    $nomorruangan = $_POST['nomorruangan'];
    $jam = $_POST['jam'];
    $sampai = $_POST['sampai'];
    $hari = $_POST['hari'];

    $query = mysqli_query($c,"update ruangan_kosong set namagedung='$namagedung',nomorruangan='$nomorruangan',jam='$jam',sampai='$sampai',hari='$hari' where idruangan='$idruangan'");

    
    if($query){
        header('location:ruangan.php');
    }else{
        echo '
        <script>alert("Gagal menghapus data);
        window.location.href="ruangan.php"
        </script>
        ';
    }
}
?>