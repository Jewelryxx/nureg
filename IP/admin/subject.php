<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>NU DASHBOARD</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <style>
    .bg-orange {
        background-color: #fd7e14;
    }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient bg-orange sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="main.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-2">NU DASHBOARD</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="main.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">


            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="studentpage.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Students</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="teacherpage.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Teacher</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="subject.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Subject</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>


                    </ul>

                </nav>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>
                    <form id="yearForm" class="form-inline mr-auto" action="" method="get">
                        <div class="input-group">
                            <label for="selectYear" class="mr-2">เลือกปี:</label>
                            <select id="selectYear" class="form-control">
                                <?php
                                $currentYear = date("Y");
                                for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                                    $selected = ($i == $selectedYear) ? "selected" : "";
                                    echo "<option value='$i' $selected>$i</option>";
                                }
                                ?>
                            </select>
                            <button type="button" class="btn btn-primary ml-2" onclick="changeYear()">ตกลง</button>
                        </div>
                    </form>

                    <div class="row">
                        <!-- Bar Chart -->
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header bg-orange py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0  font-weight-bold text-white">Top 5 Subjects Enrollment- First Fetch
                                    </h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <canvas id="myChartFirst"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div
                                    class="card-header bg-orange py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-white">Top 5 Subjects Enrollment - Last Fetch
                                    </h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <canvas id="myChartLast"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <form id="yearForm" class="form-inline mr-auto" action="" method="get">
                    <div class="input-group">
                        <label for="selectYear" class="mr-2">เลือกปี:</label>
                        <select id="yearSelect" onchange="getData()">
                            <option value="2560">2560</option>
                            <option value="2561">2561</option>
                        </select>
                        <label for="selectYear" class="mr-2">เลือกเทอม:</label>
                        <select id="semesterSelect" onchange="getData()">
                            <option value="Semester1">เทอม 1</option>
                            <option value="Semester2">เทอม 2</option>
                        </select>
                        <button type="button" class="btn btn-primary ml-2" onclick="changeYear()">ตกลง</button>
                    </div>
                </form>

                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div
                            class="card-header bg-orange py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-white">ช่วงเวลาที่นิสิตลงทะเบียน</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div id="chart"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div
                            class="card-header bg-orange py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-white">คะแนนเฉลี่ยของแต่ละรายวิชา</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="js/sb-admin-2.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <?php

// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับค่าปีที่ต้องการกรอง
$selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');

$sql = "SELECT SubjectEnrollments_SubjectID, COUNT(*) as total_students, subject.Subject_name
        FROM subjectenrollments
        INNER JOIN subject ON subjectenrollments.SubjectEnrollments_SubjectID = subject.Subject_ID
        WHERE YEAR(subjectenrollments.Date_added) = $selectedYear
        GROUP BY SubjectEnrollments_SubjectID";


$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();

// แปลงข้อมูลเป็น JSON
$json_data = json_encode($data);

?>
        <!-- ... (your HTML code) ... -->
        <script>
        document.getElementById("selectYear").onchange = function() {
            var selectedYear = document.getElementById("selectYear").value;
            window.location.href = "subject.php?year=" + selectedYear;
        }

        function changeYear() {
            var selectedYear = document.getElementById("selectYear").value;
            window.location.href = "subject.php?year=" + selectedYear;
        }

        var jsonData = <?php echo $json_data; ?>;
        var labels = [];
        var data = [];

        // เรียงลำดับข้อมูลตามจำนวนนักเรียนจากมากไปน้อย
        jsonData.sort(function(a, b) {
            return b.total_students - a.total_students;
        });

        // แบ่งข้อมูลเป็น 5 อันดับแรก
        var top5_data_first = jsonData.slice(0, 5);

        top5_data_first.forEach(function(item) {
            labels.push(item.Subject_name);
            data.push(item.total_students);
        });

        var ctx = document.getElementById('myChartFirst').getContext('2d');
        var myChartFirst = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                legend: {
                    position: 'right'
                },
                title: {
                    display: true,
                    text: 'Top 5 Subjects Enrollment - First Fetch'
                }
            }
        });

        // แบ่งข้อมูลเป็น 5 อันดับสุดท้าย
        var top5_data_last = jsonData.slice(-5);

        labels = [];
        data = [];

        top5_data_last.forEach(function(item) {
            labels.push(item.Subject_name);
            data.push(item.total_students);
        });

        var ctxLast = document.getElementById('myChartLast').getContext('2d');
        var myChartLast = new Chart(ctxLast, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                legend: {
                    position: 'right'
                },
                title: {
                    display: true,
                    text: 'Top 5 Subjects Enrollment - Last Fetch'
                }
            }
        });
        </script>
        <script>
        // ดึงข้อมูลเมื่อเปลี่ยนเลือกปีหรือเทอม
        function getData() {
            var year = document.getElementById("yearSelect").value;
            var semester = document.getElementById("semesterSelect").value;

            // ส่งคำขอไปยังไฟล์ PHP เพื่อรับข้อมูลลงทะเบียนตามปีและเทอม
            fetch('subjectdatatime.php?year=' + year + '&semester=' + semester)
                .then(response => response.json())
                .then(data => {
                    // เรียกฟังก์ชันสร้างกราฟด้วยข้อมูลใหม่
                    drawChart(data);
                });
        }

        // ฟังก์ชันสร้างกราฟ
        function drawChart(data) {
            var times = [];
            var counts = [];

            for (var i = 0; i < data.length; i++) {
                times.push(data[i].Time);
                counts.push(data[i].Count);
            }

            var trace = {
                x: times,
                y: counts,
                type: 'scatter',
                mode: 'lines+markers'
            };

            var layout = {
                title: 'จำนวนการลงทะเบียนในแต่ละช่วงเวลาของปีและเทอมที่เลือก',
                xaxis: {
                    title: 'ช่วงเวลาที่ลงทะเบียน'
                },
                yaxis: {
                    title: 'จำนวนการลงทะเบียน'
                }
            };

            var config = {
                responsive: true
            };

            Plotly.newPlot('chart', [trace], layout, config);
        }

        // เรียกใช้งานฟังก์ชันเมื่อโหลดหน้าเว็บ
        getData();
        </script>
        <?php
// การเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT subject.Subject_name, COUNT(subjectenrollments.SubjectEnrollments_StudentID) AS num_students, AVG(subjectenrollments.SumSubject_point) AS avg_score FROM subjectenrollments 
        LEFT JOIN subject ON subject.Subject_ID = subjectenrollments.SubjectEnrollments_SubjectID
        GROUP BY subjectenrollments.SubjectEnrollments_SubjectID";
$result = $conn->query($sql);

$labels = [];
$num_students = [];
$avg_score = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($labels, $row['Subject_name']);
        array_push($num_students, $row['num_students']);
        array_push($avg_score, $row['avg_score']);
    }
}

$conn->close();
?>
        <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var data = {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Number of Students',
                data: <?php echo json_encode($num_students); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }, {
                label: 'Average Score',
                data: <?php echo json_encode($avg_score); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        </script>

</body>

</html>