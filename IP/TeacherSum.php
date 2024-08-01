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
        <h1>ผลการประเมินอาจารย์</h1>

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


// ตรวจสอบว่ามีการส่งฟอร์มหรือไม่
$selectedSubject = isset($_POST['subject']) ? $_POST['subject'] : 'all';  // ถ้าไม่ได้ตั้งค่าให้เป็น 'all'

// จัดเก็บค่าที่ถูกเลือกไว้ในตัวแปร
$storedSubject = $selectedSubject;

// ดึงรายวิชาที่อาจารย์คนนั้นสอน
$subjectOptions = [];
$subjectQuery = "SELECT DISTINCT Teacher_subject FROM teacher_eva WHERE Teacher_ID = $user_id";
$subjectResult = $mysqli->query($subjectQuery);
while ($row = $subjectResult->fetch_assoc()) {
    $subjectOptions[] = $row['Teacher_subject'];
}

// สร้างคำสั่ง SQL เพื่อดึงข้อมูลจากตาราง teacher_eva
$sql = "SELECT * FROM teacher_eva WHERE Teacher_ID = $user_id";

// เพิ่มเงื่อนไขการกรองตามรายวิชา หากไม่ใช่ 'all'
if ($selectedSubject !== 'all') {
    $sql .= " AND Teacher_subject = '$selectedSubject'";
}

// ดำเนินการคิวรี SQL
$result = $mysqli->query($sql);

// ตรวจสอบว่ามีข้อมูลหรือไม่
if ($result->num_rows > 0) {
    echo "<form method='post' action='' class='filter-form'>";  // เพิ่มฟอร์มสำหรับการเลือกปีและเทอม
    echo "<label for='subject'>เลือกรายวิชา:</label> <select name='subject'>
            <option value='all' " . ($storedSubject === 'all' ? 'selected' : '') . ">ทั้งหมด</option>";
    foreach ($subjectOptions as $subjectOption) {
        echo "<option value='$subjectOption' " . ($storedSubject == $subjectOption ? 'selected' : '') . ">$subjectOption</option>";
    }
    echo "</select>";
    echo "</form>";

    echo "<div class='result-container'>";
    // แสดงข้อมูลในตาราง
    while ($row = $result->fetch_assoc()) {
        echo "<div class='result-box'>";
        echo "<p><strong>คะแนนครู:</strong> {$row['Teacher_score']}</p>";
        echo "<p><strong>ความคิดเห็น:</strong> {$row['comment']}</p>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<form method='post' action='' class='filter-form'>";  // เพิ่มฟอร์มสำหรับการเลือกปีและเทอม
    echo "<label for='subject'>เลือกรายวิชา:</label> <select name='subject'>
            <option value='all' " . ($storedSubject === 'all' ? 'selected' : '') . ">ทั้งหมด</option>";
    foreach ($subjectOptions as $subjectOption) {
        echo "<option value='$subjectOption' " . ($storedSubject == $subjectOption ? 'selected' : '') . ">$subjectOption</option>";
    }
    echo "</select>";
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
            <li><a href="TeacherIndex.html">หน้าหลัก</a></li>
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