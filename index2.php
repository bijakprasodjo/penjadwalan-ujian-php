<?php
require 'ceklogin.php';

class Exam {
    public $subject;
    public $lecturer;
    public $sks;
    public $classGroup;

    public function __construct($subject, $lecturer, $sks, $classGroup) {
        $this->subject = $subject;
        $this->lecturer = $lecturer;
        $this->sks = $sks;
        $this->classGroup = $classGroup;
    }
}class Room {
    public $name;
    public $status;
    public $time;

    public function __construct($name, $status, $time) {
        $this->name = $name;
        $this->status = $status;
        $this->time = $time;
    }
}

function isRoomAvailable($schedule, $time) {
    return !array_key_exists($time, $schedule);
}

function addToSchedule(&$schedule, $time, $examDetail) {
    if (!array_key_exists($time, $schedule)) {
        $schedule[$time] = [];
    }
    $schedule[$time][] = $examDetail;
}
function scheduleExams($rooms, $exams) {
    usort($exams, function($a, $b) {
        return $b->sks - $a->sks;
    });

    $schedule = [];

    foreach ($exams as $exam) {
        $scheduled = false;
        foreach ($rooms as $room) {
            if ($room->status === "Ready" && isRoomAvailable($schedule, $room->time)) {
                $examDetail = [
                    'subject' => $exam->subject,
                    'lecturer' => $exam->lecturer,
                    'sks' => $exam->sks,
                    'classGroup' => $exam->classGroup,
                    'time' => $room->time,
                    'room' => $room->name
                ];
                addToSchedule($schedule, $room->time, $examDetail);
                $scheduled = true;
                break;
            }
        }
        if (!$scheduled) {
            echo "Ujian " . $exam->subject . " untuk kelas " . $exam->classGroup . " tidak dapat dijadwalkan.\n";
        }
    }

    return $schedule;
}

$start_time = microtime(true);

$rooms = [ 
    new Room("TULT_0716", "Not_Ready", "Senin, 12.30-15.30"),
    new Room("TULT_0601", "Ready", "Selasa, 08.30-11.30"),
    new Room("TULT_0601", "Ready", "Selasa, 12.30-15.30"),
    new Room("KU3.04.19", "Not_Ready", "Rabu, 08.30-11.30"),
    new Room("KU3.04.19", "Ready", "Rabu, 12.30-15.30"),
    new Room("KU3.05.14", "Ready", "Kamis, 08.30-11.30"),
    new Room("KU3.05.14", "Ready", "Kamis, 12.30-15.30"),
    new Room("KU1.02.13", "Not_Ready", "Jumat, 08.30-11.30"),
    new Room("KU1.02.14", "Ready", "Senin, 11.30-15.30"),
    new Room("KU1.02.15", "Ready", "Kamis, 06.30-11.30"),
    new Room("KU1.02.16", "Ready", "Jumat, 12.30-15.30"),
    new Room("KU1.02.17", "Not_Ready", "Selasa, 09.30-12.30")
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $lecturer = $_POST['lecturer'];
    $sks = $_POST['sks'];
    $classGroup = $_POST['classGroup'];

    $stmt = $c->prepare("INSERT INTO jadwal2 (subject, lecturer, sks, classGroup) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $subject, $lecturer, $sks, $classGroup);

    if ($stmt->execute()) {
        echo "Data berhasil disimpan.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$exams = [];
$sql = "SELECT subject, lecturer, sks, classGroup FROM jadwal2";
$result = $c->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $exams[] = new Exam($row["subject"], $row["lecturer"], $row["sks"], $row["classGroup"]);
    }
}

$schedule = scheduleExams($rooms, $exams);

$totalScheduledExams = 0;
foreach ($schedule as $time => $examsAtTime) {
    $totalScheduledExams += count($examsAtTime);
}

$end_time = microtime(true);

$execution_time = $end_time - $start_time;

$c->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Jadwal Ujian Dynamic Programming</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="index.php">Aplikasi Penjadwalan</a>
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
                                    Jadwal Ujian Dynamic Programming
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
                        <h1 class="mt-4">Jadwal Ujian Dynamic Programming</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Semoga Hari Mu Menyenangkan!!!</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Jumlah Ujian: <?php echo count($exams); ?></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Total Ujian Dijadwalkan: <?php echo $totalScheduledExams; ?></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-info text-white mb-4">
                                    <div class="card-body">Waktu Eksekusi: <?php echo $execution_time; ?> detik</div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-info mb-4" data-toggle="modal" data-target="#myModal">
                                Tambah Jadwal Ujian
                            </button>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Ujian
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Mata Kuliah</th>
                                            <th>Nama Dosen</th>
                                            <th>Kelas</th>
                                            <th>Satuan Kredit Semester</th>
                                            <th>Jam</th>
                                            <th>Hari</th>
                                            <th>Ruangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($schedule as $time => $examsAtTime) {
                                            foreach ($examsAtTime as $examDetail) {
                                                $timeParts = explode(", ", $examDetail['time']);
                                                $day = $timeParts[0];
                                                $hour = $timeParts[1];
                                                echo "<tr>";
                                                echo "<td>".$no++."</td>";
                                                echo "<td>".$examDetail['subject']."</td>";
                                                echo "<td>".$examDetail['lecturer']."</td>";
                                                echo "<td>".$examDetail['classGroup']."</td>";
                                                echo "<td>".$examDetail['sks']."</td>";
                                                echo "<td>".$hour."</td>";
                                                echo "<td>".$day."</td>";
                                                echo "<td>".$examDetail['room']."</td>";
                                                echo "</tr>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">&copy; Your Website 2023</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Jadwal Ujian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="subject">Nama Mata Kuliah</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>
                            <div class="form-group">
                                <label for="lecturer">Nama Dosen</label>
                                <input type="text" class="form-control" id="lecturer" name="lecturer" required>
                            </div>
                            <div class="form-group">
                                <label for="sks">Satuan Kredit Semester</label>
                                <input type="number" class="form-control" id="sks" name="sks" required>
                            </div>
                            <div class="form-group">
                                <label for="classGroup">Kelas</label>
                                <input type="text" class="form-control" id="classGroup" name="classGroup" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
