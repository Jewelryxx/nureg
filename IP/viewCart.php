<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
  <title>วิชาที่เลือก</title>
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-style.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <style>
  th {
    background-color: #d6915f;
    border-radius: 10px 0 0 0px; /* กำหนดมุมโค้งด้านขวาเท่านั้น */
  }
  th:last-child {
  border-radius: 0 10px 0px 0; /* กำหนดมุมโค้งด้านซ้ายเท่านั้น */
  }
</style>
</head>

<body class="is-preload">
  <!-- Wrapper -->
  <div id="wrapper">
    <!-- Main -->
    <div id="main">
      <div class="inner">
        <!-- Header -->
        <header id="header">
          <div class="logo">
            <a href="index.html">NU</a>
          </div>
        </header>
        <!-- Banner -->
        <!-- Banner -->
        <?php
        session_start();
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
          echo '<h1>รายวิชาที่เลือก</h1>';
          echo '<table class="table table-th">';
          echo '<thead><tr><th scope="col">รหัสวิชา</th><th scope="col">ลบ</th></tr></thead>';
          echo '<tbody>';
          foreach ($_SESSION['cart'] as $item) {
            echo '<tr><td>' . $item . '</td><td><button class="deleteBtn" data-item="' . $item . '">Delete</button></td></tr>';
          }
          echo '</tbody></table>';
        } else {
          echo '<h1>ไม่มีวิชาที่ลง</h1>';
        }
        ?>
        <?php
        if (isset($_GET['item']) && !empty($_GET['item'])) {
          $itemToRemove = $_GET['item'];
          if (isset($_SESSION['cart']) && in_array($itemToRemove, $_SESSION['cart'])) {
            $index = array_search($itemToRemove, $_SESSION['cart']);
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            echo 'ลบรหัสวิชา ' . $itemToRemove . ' ออกจากรถเข็นแล้ว';
          } else {
            echo 'ไม่พบรหัสวิชา ' . $itemToRemove . ' ในรถเข็น';
          }
        }
        ?>
        <button id="addToDatabaseBtn">Confirm</button>
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
            <li><a href="signin.html">ออกจากระบบ</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </div>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/deleteCourse.js"></script>
  <script src="assets/js/browser.min.js"></script>
  <script src="assets/js/breakpoints.min.js"></script>
  <script src="assets/js/transition.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/custom.js"></script>

  <script>
    // Function to handle Add to Database button click
    document.getElementById('addToDatabaseBtn').addEventListener('click', function () {
      // Perform AJAX request to addToDatabase.php
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          // Display a success message or perform additional actions if needed
          alert(xhr.responseText);
        }
      };
      xhr.open('GET', 'addToDatabase.php', true);
      xhr.send();
    });
  </script>
</body>

</html>