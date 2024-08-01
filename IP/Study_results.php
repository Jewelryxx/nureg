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
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
        margin-bottom: 10px;
    }

    .filter-form select, .filter-form input {
        padding: 8px;
        margin-right: 10px;
        border: 1px solid #000;
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
        <h1>ผลการศึกษา</h1>

        <?php
session_start();
echo "UserID: " . $_SESSION["UserID"];
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

// สร้างคำสั่ง SQL เพื่อดึงข้อมูลจากตาราง subjectenrollments, subject และ employee
$sql = "SELECT se.SubjectEnrollments_SubjectID, s.Subject_name, se.SubjectEnrollments_StudentID, se.SumSubject_point, se.SubjectEnrollments_grade, e.EM_fname, e.EM_lname, se.Year, se.Semester
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
  echo "<label for='year'>Select Year:</label> <select name='year'>
                  <option value='all' " . ($storedYear === 'all' ? 'selected' : '') . ">ทั้งหมด</option>";
  foreach ($yearOptions as $yearOption) {
      echo "<option value='$yearOption' " . ($storedYear === $yearOption ? 'selected' : '') . ">$yearOption</option>";
  }
  echo "</select>";
  echo "<label for='semester'>Select Semester:</label> <select name='semester'>
                      <option value='all' " . ($storedSemester === 'all' ? 'selected' : '') . ">ทั้งหมด</option>
                      <option value='Semester1' " . ($storedSemester === 'Semester1' ? 'selected' : '') . ">Semester 1</option>
                      <option value='Semester2' " . ($storedSemester === 'Semester2' ? 'selected' : '') . ">Semester 2</option>
                  </select>";
  echo "<input type='submit' value='Submit'>";
  echo "</form>";

  echo "<div class='result-container'>";
  // แสดงข้อมูลในตาราง
  while ($row = $result->fetch_assoc()) {
      echo "<div class='result-box'>";
      echo "<p><strong>Year:</strong> {$row['Year']}</p>";
      echo "<p><strong>Semester:</strong> {$row['Semester']}</p>";
      echo "<p><strong>Subject:</strong> {$row['Subject_name']}</p>";
      echo "<p><strong>Student ID:</strong> {$row['SubjectEnrollments_StudentID']}</p>";
      echo "<p><strong>Sum Subject Point:</strong> {$row['SumSubject_point']}</p>";
      echo "<p><strong>Grade:</strong> {$row['SubjectEnrollments_grade']}</p>";
      echo "<p><strong>Teacher Name:</strong> {$row['EM_fname']} {$row['EM_lname']}</p>";
      echo "</div>";
  }
  echo "</div>";
} else {
  echo "<form method='post' action='' class='filter-form'>";  // Add a form for year and semester selection
  echo "<label for='year'>Select Year:</label> <select name='year'>
                  <option value='all' " . ($storedYear === 'all' ? 'selected' : '') . ">All</option>";
  foreach ($yearOptions as $yearOption) {
      echo "<option value='$yearOption' " . ($storedYear === $yearOption ? 'selected' : '') . ">$yearOption</option>";
  }
  echo "</select>";
  echo "<label for='semester'>Select Semester:</label><select name='semester'>
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
      <footer class="w3-center w3-light-grey w3-padding-32" style="font-size: 5px;">
        <p>
          งานทะเบียนนิสิตและประมวลผล กองบริการการศึกษา มหาวิทยาลัยนเรศวร<br>
          เลขที่ 99 หมู่ 9 ตำบลท่าโพธิ์ อำเภอเมือง จังหวัดพิษณุโลก 65000
          โทรศัพท์<br>
          • 055-968-310 ถึง 11 (ฝ่ายระบบทะเบียนออนไลน์)<br>
          • 055-968-312 (ฝ่ายจัดตารางเรียน/สอน)<br>
          • 055-968-314 ถึง 15 (ฝ่ายทะเบียนนิสิต)<br>
          • 055-968-324 (เคาน์เตอร์)</a>
        </p>
      </footer>
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