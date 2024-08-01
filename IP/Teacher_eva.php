<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
  <title>Student Page</title>
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-style.css">
  <link rel="stylesheet" href="assets/css/owl.css">

</head>
<style>
    .result-container {
        display: flex;
        flex-wrap: wrap;
    }

    .result-box {
        border: 1px solid #f9f9f9;
        padding: 15px;
        margin: 10px;
        width: 200%;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        background-color: #d6915f;
        border-radius: 8px;
    }

    .result-box p {
        margin: 5px 0;
        color: black;
    }

    .filter-form {
        margin-bottom: 20px;
    }

    .filter-form select, .filter-form input {
        padding: 8px;
        margin-right: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .filter-form input[type="submit"] {
        background-color: #000;
        color: #fff;
        cursor: pointer;
        border-radius: 20px;
      }
    .filter-form label {
        font-weight: bold; /* ตั้งค่าให้ข้อความใน <label> เป็นตัวหนา */
    }
    .btn-dark {
        background-color: black; /* เปลี่ยนสีพื้นหลังเป็นสีดำ */
        color: white; /* เปลี่ยนสีข้อความเป็นสีขาว */
    }
</style>
</style>


<body class="is-preload">
  <div id="wrapper">
    <div id="main">
      <div class="inner">
        <header id="header">
          <div class="logo">
            <a href="StudentIndex.html">NU STUDENT</a>
          </div>
        </header>
        <h1>ประเมินอาจารย์-ผู้สอน</h1>

        <?php
session_start();
// เชื่อมต่อฐานข้อมูล
$mysqli = new mysqli("localhost", "root", "", "registration_system");

// ตรวจสอบการเชื่อมต่อ
if ($mysqli->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $mysqli->connect_error);
}

// ดึง User_ID จาก session
if (isset($_SESSION['UserID'])) {
    $user_id = $_SESSION['UserID'];
    echo "User ID: $user_id"; // แสดงค่า user_id
} else {
    echo "ไม่พบข้อมูล User ID"; // กรณีที่ไม่มีค่า user_id ใน session
}

// Check if form is submitted
$selectedYear = isset($_POST['year']) ? $_POST['year'] : 'all';  // Default to 'all' if not set
$selectedSemester = isset($_POST['semester']) ? $_POST['semester'] : 'all';  // Default to 'all' if not set

// Store selected values in variables to retain them
$storedYear = $selectedYear;
$storedSemester = $selectedSemester;

// Construct SQL query to select enrollments not used in teacher_eva table
$sql = "SELECT *
        FROM subjectenrollments se
        JOIN subject s ON se.SubjectEnrollments_SubjectID = s.Subject_ID
        JOIN employee e ON se.SubjectEnrollments_TeacherID = e.EM_ID
        WHERE se.SubjectEnrollments_StudentID = $user_id";

// Add year and semester filtering if not 'all'
if ($selectedYear !== 'all') {
    $sql .= " AND se.Year = '$selectedYear'";
}
if ($selectedSemester !== 'all') {
    $sql .= " AND se.Semester = '$selectedSemester'";
}

// Subquery to select enrollments not present in teacher_eva table
$sql .= " AND se.SubjectEnrollments_ID NOT IN (
            SELECT enroll_ID FROM teacher_eva
        )";

// ดึงข้อมูลจากฐานข้อมูล
$result = $mysqli->query($sql);

// Fetch distinct years from the database for the dropdown
$yearOptions = [];
$yearQuery = "SELECT DISTINCT Year FROM subjectenrollments";
$yearResult = $mysqli->query($yearQuery);
while ($row = $yearResult->fetch_assoc()) {
    $yearOptions[] = $row['Year'];
}

// ตรวจสอบว่ามีข้อมูลหรือไม่
if ($result->num_rows > 0) {
  echo "<form method='post' action='' class='filter-form'>";  // Add a form for year and semester selection
  echo "Select Year: <select name='year'>
                  <option value='all' " . ($storedYear === 'all' ? 'selected' : '') . ">All</option>";
  foreach ($yearOptions as $yearOption) {
      echo "<option value='$yearOption' " . ($storedYear === $yearOption ? 'selected' : '') . ">$yearOption</option>";
  }
  echo "</select>";
  echo "Select Semester: <select name='semester'>
                      <option value='all' " . ($storedSemester === 'all' ? 'selected' : '') . ">All</option>
                      <option value='Semester1' " . ($storedSemester === 'Semester1' ? 'selected' : '') . ">Semester 1</option>
                      <option value='Semester2' " . ($storedSemester === 'Semester2' ? 'selected' : '') . ">Semester 2</option>
                  </select>";
  echo "<input type='submit' value='Filter'>";
  echo "</form>";

  echo "<div class='result-container'>";
  // แสดงข้อมูลในตาราง
  while ($row = $result->fetch_assoc()) {
    echo "<div class='result-box'>";
    echo "<p><strong>Year:</strong> {$row['Year']}</p>";
    echo "<p><strong>Semester:</strong> {$row['Semester']}</p>";
    echo "<p><strong>Subject:</strong> {$row['Subject_name']}</p>";
    echo "<p><strong>Teacher Name:</strong> {$row['EM_fname']} {$row['EM_lname']}</p>";

    // เพิ่ม Query String ในลิงก์ Evaluate
    echo "<a href='evaluation_page.php?subject_id={$row['SubjectEnrollments_SubjectID']}&teacher_id={$row['SubjectEnrollments_TeacherID']}' class='btn btn-dark'>Evaluate</a>";
    echo "</div>";
  } 
  echo "</div>";
} else {
  echo "<form method='post' action='' class='filter-form'>";  // Add a form for year and semester selection
  echo "Select Year: <select name='year'>
                  <option value='all' " . ($storedYear === 'all' ? 'selected' : '') . ">All</option>";
  foreach ($yearOptions as $yearOption) {
      echo "<option value='$yearOption' " . ($storedYear === $yearOption ? 'selected' : '') . ">$yearOption</option>";
  }
  echo "</select>";
  echo "Select Semester: <select name='semester'>
                      <option value='all' " . ($storedSemester === 'all' ? 'selected' : '') . ">All</option>
                      <option value='Semester1' " . ($storedSemester === 'Semester1' ? 'selected' : '') . ">Semester 1</option>
                      <option value='Semester2' " . ($storedSemester === 'Semester2' ? 'selected' : '') . ">Semester 2</option>
                  </select>";
  echo "<input type='submit' value='Filter'>";
  echo "</form>";
  echo "<div class='result-container'>";
  echo "<p>ไม่พบข้อมูล</p>";
  echo "</div>";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$mysqli->close();
?>

<!-- Add JavaScript to submit form on dropdown change -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('form').addEventListener('change', function () {
            this.submit();
        });
    });
</script>




      </div>
    </div>

    <!-- Sidebar -->
    <div id="sidebar">

      <div class="inner">

        <!-- Search Box -->
        <img class="nulogo" src="assets/images/NU_LOGO.png">

        <!-- Menu -->
        <nav id="menu">
          <ul>
            <li><a href="StudentIndex.html">หน้าหลัก</a></li>
            <li><a href="StudentIndex.html">ย้อนกลับ</a></li>
            <li><a href="signin.html">ออกจากระบบ</a></li>

          </ul>
        </nav>

      </div>
      
    </div>

  </div>

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="assets/js/browser.min.js"></script>
  <script src="assets/js/breakpoints.min.js"></script>
  <script src="assets/js/transition.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/custom.js"></script>
</body>


</body>
</html>