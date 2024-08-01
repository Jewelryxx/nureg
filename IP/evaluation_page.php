<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Student Page</title>
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-style.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <style>
    .result-container {
        display: block;
        flex-wrap: wrap;
    }

    .result-box {
        border: 1px solid #ddd;
        padding: 15px;
        margin: 10px;
        width: 200px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        border-radius: 8px;
    }

    .result-box p {
        margin: 5px 0;
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
        background-color: #4CAF50;
        color: #fff;
        cursor: pointer;
    }
  </style>
</head>
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
        <div class="result-container">
          <?php
          session_start();

          // Connect to the database
          $mysqli = new mysqli("localhost", "root", "", "registration_system");

          // Check connection
          if ($mysqli->connect_error) {
              die("Connection failed: " . $mysqli->connect_error);
          }

          // Get user ID from session
          if (isset($_SESSION['UserID'])) {
              $user_id = $_SESSION['UserID'];
              echo "User ID: $user_id"; // Display user ID
          } else {
              echo "User ID not found"; // If user ID is not found in session
          }
          // Check if form is submitted
          $selectedYear = isset($_POST['year']) ? $_POST['year'] : 'all';  // Default to 'all' if not set
          $selectedSemester = isset($_POST['semester']) ? $_POST['semester'] : 'all';  // Default to 'all' if not set

          // Store selected values in variables to retain them
          $storedYear = $selectedYear;
          $storedSemester = $selectedSemester;

          // ดึงข้อมูล Subject ID และ Teacher ID จาก Query String
          $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : '';
          $teacher_id = isset($_GET['teacher_id']) ? $_GET['teacher_id'] : '';

          // Construct SQL query to select enrollments not used in teacher_eva table
          $sql = "SELECT *
          FROM subjectenrollments se
          JOIN subject s ON se.SubjectEnrollments_SubjectID = s.Subject_ID
          JOIN employee e ON se.SubjectEnrollments_TeacherID = e.EM_ID
          WHERE se.SubjectEnrollments_StudentID = $user_id
          AND se.SubjectEnrollments_SubjectID = '$subject_id'
          AND se.SubjectEnrollments_TeacherID = '$teacher_id'";

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


          // Fetch data from the database
          $result = $mysqli->query($sql);

          // Fetch distinct years from the database for the dropdown
          $yearOptions = [];
          $yearQuery = "SELECT DISTINCT Year FROM subjectenrollments";
          $yearResult = $mysqli->query($yearQuery);
          while ($row = $yearResult->fetch_assoc()) {
              $yearOptions[] = $row['Year'];
          }

          // Check if data exists
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

              // Display data in result boxes
              while ($row = $result->fetch_assoc()) {
                  echo "<div class='result-box'>";
                  echo "<p><strong>Year:</strong> {$row['Year']}</p>";
                  echo "<p><strong>Semester:</strong> {$row['Semester']}</p>";
                  echo "<p><strong>Subject:</strong> {$row['Subject_name']}</p>";
                  echo "<p><strong>Teacher Name:</strong> {$row['EM_fname']} {$row['EM_lname']}</p>";
                  echo "<form action='save_evaluation.php' method='post'>";
                  // Hidden input field to store subjectenrollments ID
                  echo "<input type='hidden' name='enroll' value='" . $row['SubjectEnrollments_ID'] . "'>";
                  // Hidden input field to store enrollment ID
                  echo "<input type='hidden' name='Stu_id' value='" . (isset($row['$user_id']) ? $row['$user_id'] : '') . "'>";
                  // Hidden input field to store subject ID
                  echo "<input type='hidden' name='Subject_ID' value='{$row['SubjectEnrollments_SubjectID']}'>";
                  // Hidden input field to store teacher ID
                  echo "<input type='hidden' name='teacher_id' value='" . $row['SubjectEnrollments_TeacherID'] . "'>";
                  // Input field to enter comment
                  echo "<input type='number' name='rating' min='0' max='100' placeholder='Rate 1-100' required style='width: 100px;'>";

                  echo "<div class='form-group'>";
                  echo "<label for='comment'>Comment:</label>";
                  echo "<textarea class='form-control' id='comment' name='comment' rows='3' required></textarea>";
                  echo "</div>";
                  // Submit button
                  echo "<button type='submit' class='btn btn-primary'>Submit</button>";
                  // Close the form tag
                  echo "</form>";
                  echo "</div>";
              }

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
              echo "<p>No data found</p>";
              echo "</div>";
          }          

          // Close database connection
          $mysqli->close();
          ?>
        </div>
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
            <li><a href="Teacher_eva.php">ย้อนกลับ</a></li>
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
  <!-- Add JavaScript to submit form on dropdown change -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('.filter-form').addEventListener('change', function () {
            this.submit();
        });
    });
  </script>
</body>
</html>
