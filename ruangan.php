<?php
require 'ceklogin.php';

$h1 = mysqli_query($c,"select * from ruangan_kosong");
$h2 = mysqli_num_rows($h1);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Ruangan</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <head>
        <title>Bootstrap Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Aplikasi Penjadwalan</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav">
                 <div id="layoutSidenav_nav">
                     <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                        <div class="sb-sidenav-menu">
                            <div class="nav">
                                <div class="sb-sidenav-menu-heading">Menu</div>
                                <a class="nav-link" href="index.php">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-file"></i></div>
                                    Jadwal Ujian Greedy
                                </a>
                                <a class="nav-link" href="index2.php">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-file"></i></div>
                                    Jadwal Ujian
                                </a>
                                <a class="nav-link" href="matkul.php">
                                     <div class="sb-nav-link-icon"><i class="fa-solid fa-person"></i></div>
                                    Mata Kuliah 
                                </a>
                                <a class="nav-link" href="dosen.php">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                                    Dosen
                                </a>
                                <a class="nav-link" href="ruangan.php">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-landmark"></i></div>
                                    Ruangan
                                </a>
                                <a class="nav-link" href="logout.php">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </nav>
                </div> 
            </div>

            <script>
                // Fungsi untuk menghapus kelas active dari semua link dan menambahkannya ke yang diklik
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.addEventListener('click', function() {
                        document.querySelectorAll('.nav-link').forEach(nav => {
                            nav.classList.remove('active');
                        });
                        this.classList.add('active');
                    });
                });

                // Fungsi untuk menambahkan kelas active berdasarkan URL saat ini
                window.addEventListener('load', function() {
                    const currentPath = window.location.pathname.split("/").pop();
                    document.querySelectorAll('.nav-link').forEach(link => {
                        if (link.getAttribute('href') === currentPath) {
                            link.classList.add('active');
                        }
                    });
                });
            </script>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Ruangan</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Semoga Hari Mu Menyenangkan!!!</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Ruangan Tersedia: <?=$h2;?></div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-info mb-4" data-toggle="modal" data-target="#myModal">
                                Tambah Ruangan Kosong
                             </button>

                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Ruangan Kosong
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Gedung</th>
                                            <th>Nomor Ruangan</th>
                                            <th>Jam</th>
                                            <th>Hari</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                    $get = mysqli_query($c,"select * from ruangan_kosong");
                                    $i = 1;    
                                    while($p=mysqli_fetch_array($get)){
                                        $idruangan = $p['idruangan'];
                                        $namagedung = $p['namagedung'];
                                        $nomorruangan = $p['nomorruangan'];
                                        $jam = $p['jam'];
                                        $sampai = $p['sampai'];
                                        $hari = $p['hari'];
                                    
                                    ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$namagedung;?></td>
                                            <td><?=$nomorruangan;?></td>
                                            <td><?=$jam;?>-<?=$sampai;?></td>
                                            <td><?=$hari;?></td>
                                            <td>
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idruangan;?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idruangan;?>">
                                                Hapus
                                            </button>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="delete<?=$idruangan;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Data</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <form method="post">
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        Apakah Anda Yakin Ingin Menghapus Data Ini?
                                                        <input type="hidden" name="idruangan" value="<?=$idruangan;?>">
                                                    </div>
                                                    
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="sumbit" class="btn btn-success" name="hapusruangan">Ya</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="modal fade" id="edit<?=$idruangan;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Tambah Mata Kuliah Baru</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <form method="post">
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <input type="text" name="namagedung" class="form-control" placeholder="Nama Gedung" value="<?=$namagedung?>">
                                                        <input type="num" name="nomorruangan" class="form-control mt-2" placeholder="Nomor Ruangan" value="<?=$nomorruangan?>">
                                                        <input type="text" name="hari" class="form-control" placeholder="Hari" value="<?=$hari?>">
                                                        <input type="time" name="jam" class="form-control mt-2" placeholder="Waktu Yang Tersedia" value="<?$jam?>">
                                                        <input type="time" name="sampai" class="form-control mt-2" placeholder="Sampai Pukul" value="<?=$sampai?>">
                                                        <input type="hidden" name="idruangan" value="<?=$idruangan;?>">
                                                    </div>
                                                    
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="sumbit" class="btn btn-success" name="editruangan">Sumbit</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    };
                                    ?>                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>

  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Ruangan Kosong</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="post">
        <!-- Modal body -->
        <div class="modal-body">
            <input type="text" name="namagedung" class="form-control" placeholder="Nama Gedung">
            <input type="num" name="nomorruangan" class="form-control mt-2" placeholder="Nomor Ruangan">
            <input type="text" name="hari" class="form-control" placeholder="Hari">
            <input type="time" name="jam" class="form-control mt-2" placeholder="Waktu Yang Tersedia">
            <input type="time" name="sampai" class="form-control mt-2" placeholder="Sampai Pukul">
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="sumbit" class="btn btn-success" name="tambahgedung">Sumbit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>

</html>
