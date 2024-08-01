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

            <hr class="sidebar-divider ">

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

            <hr class="sidebar-divider d-none d-md-block ">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow ">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars "></i>
                    </button>
                    <ul class="navbar-nav ml-auto ">
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
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                จำนวนนิสิตทั้งหมด</div>
                                            <div id="totalStudents">
                                                <h4 class="text-warning">Total Students: <span
                                                        id="totalStudentsCount"></span></h4>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                จำนวนนิสิตแต่ละชั้นปี(เลือกชั้นปีที่จะดูได้)
                                            </div>
                                            <div id="studentsByYear">
                                                <h4 class="text-warning">Students by Year</h4>
                                                <select id="yearFilter" class="form-control">
                                                    <option value="1">Year 1</option>
                                                    <option value="2">Year 2</option>
                                                    <option value="3">Year 3</option>
                                                    <option value="4">Year 4</option>
                                                    <option value="5">Year 5</option>
                                                    <option value="6">Year 6</option>
                                                    <option value="7">Year 7</option>
                                                    <option value="8">Year 8</option>
                                                    <option value="all">ALL</option>
                                                </select>
                                                <ul id="studentsByYearList"></ul>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                จำนวนคณะทั้งหมด
                                            </div>
                                            <div id="totalMajors">
                                                <h3 class="text-warning">Total Majors: <span
                                                        id="totalMajorsCount"></span></h3>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                จำนวนภาควิชาทั้งหมด
                                            </div>
                                            <div id="totalDepartments">
                                                <h4 class="text-warning">Total Departments: <span
                                                        id="totalDepartmentsCount"></span></h4>
                                            </div>
                                        </div>
                                        <div class="col-auto ml-auto">
                                            <i class="fas fa-comments fa-1x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header bg-orange py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0  font-weight-bold text-white">จำนวนนิสิตในแต่ละคณะ</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <canvas id="barChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5 ">
                            <div class="card  shadow mb-4">
                                <div
                                    class="card-header bg-orange py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-white">ภูมิลำเนาของนิสิต</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div style="width: 80%; margin: auto;">
                                        <canvas id="areaChart" width="400" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div
                            class="card-header bg-orange py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-white">จำนวนนิสิตแต่ละชั้นปี-แยกตามเพศ</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div
                            class="card-header bg-orange py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-white">จำนวนนิสิตในแต่ละคณะ-แยกตามภูมิภาค</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <canvas id="myChart2" style="width: 100%; height: 400px;"></canvas>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>งานทะเบียนนิสิตและประมวลผล กองบริการการศึกษา มหาวิทยาลัยนเรศวร<br><br>
                            เลขที่ 99 หมู่ 9 ตำบลท่าโพธิ์ อำเภอเมือง จังหวัดพิษณุโลก 65000
                            โทรศัพท์<br><br>
                            • 055-968-310 ถึง 11 (ฝ่ายระบบทะเบียนออนไลน์)<br><br>
                            • 055-968-312 (ฝ่ายจัดตารางเรียน/สอน)<br><br>
                            • 055-968-314 ถึง 15 (ฝ่ายทะเบียนนิสิต)<br><br>
                            • 055-968-324 (เคาน์เตอร์)</a></span>
                    </div>
                </div>
            </footer>
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/scripts1.js"></script>
    <script src="js/scripts2.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "registration_system";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
    }
    $sql = "SELECT Stu_year_of_study, Stu_gender, COUNT(*) AS count FROM student GROUP BY Stu_year_of_study, Stu_gender ORDER BY Stu_year_of_study";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $dataPointsMale = array();
        $dataPointsFemale = array();
        $dataPointsLGTVQ = array();
        while($row = $result->fetch_assoc()) {
            if ($row["Stu_gender"] == "1") {
                $dataPointMale = array("label" => $row["Stu_year_of_study"], "y" => $row["count"]);
                array_push($dataPointsMale, $dataPointMale);
            } elseif ($row["Stu_gender"] == "2") {
                $dataPointFemale = array("label" => $row["Stu_year_of_study"], "y" => $row["count"]);
                array_push($dataPointsFemale, $dataPointFemale);
            } elseif ($row["Stu_gender"] == "3") {
                $dataPointLGTVQ = array("label" => $row["Stu_year_of_study"], "y" => $row["count"]);
                array_push($dataPointsLGTVQ, $dataPointLGTVQ);
            }
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
    <script>
    window.onload = function() {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            axisY: {
                title: "จำนวนนักศึกษา"
            },
            data: [{
                    type: "column",
                    showInLegend: true,
                    name: "ชาย",
                    yValueFormatString: "#,##0 คน",
                    dataPoints: <?php echo json_encode($dataPointsMale, JSON_NUMERIC_CHECK); ?>
                },
                {
                    type: "column",
                    showInLegend: true,
                    name: "หญิง",
                    yValueFormatString: "#,##0 คน",
                    dataPoints: <?php echo json_encode($dataPointsFemale, JSON_NUMERIC_CHECK); ?>
                },
                {
                    type: "column",
                    showInLegend: true,
                    name: "อื่นๆ",
                    yValueFormatString: "#,##0 คน",
                    dataPoints: <?php echo json_encode($dataPointsLGTVQ, JSON_NUMERIC_CHECK); ?>
                }
            ]
        });
        chart.render();
    }
    </script>
    <script>
    // Fetch data from PHP script
    fetch('php_test.php')
        .then(response => response.json())
        .then(data => {
            // Extract unique faculties and areas
            const faculties = Array.from(new Set(data.map(item => item.Major)));
            const areas = Array.from(new Set(data.map(item => item.Area)));

            // Define color palette for areas
            const colors = [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ];

            // Create object to store total student counts by faculty and area
            const facultyAreaStudentCounts = {};
            faculties.forEach((faculty, index) => {
                facultyAreaStudentCounts[faculty] = {};
                areas.forEach((area, i) => {
                    facultyAreaStudentCounts[faculty][area] = 0;
                });
            });
            data.forEach(item => {
                facultyAreaStudentCounts[item.Major][item.Area] += parseInt(item.Student_Count);
            });

            // Create data object for Chart.js
            const chartData = {
                labels: faculties,
                datasets: areas.map((area, index) => ({
                    label: area,
                    data: faculties.map(faculty => facultyAreaStudentCounts[faculty][area]),
                    backgroundColor: colors[index % colors.length], // Use color from palette
                    borderColor: 'rgba(0, 0, 0, 1)',
                    borderWidth: 1
                }))
            };

            // Configuration options
            const chartOptions = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };

            // Get chart canvas
            const ctx = document.getElementById('myChart2').getContext('2d');

            // Create bar chart
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: chartOptions
            });
        });
    </script>
</body>

</html>