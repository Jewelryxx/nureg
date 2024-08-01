<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "registration_system") or die("Error: " . mysqli_error($con));
mysqli_query($con, "SET NAMES 'utf8mb4' "); // Set charset to utf8mb4

if (isset($_POST['Username'])) {
  // Receive user & password
  $Username = $_POST['Username'];
  $Password = $_POST['Password'];

  // Query
  $sql = "SELECT * FROM User WHERE User_LOG='" . $Username . "' AND User_pass='" . $Password . "'";

  $result = mysqli_query($con, $sql);
  if (mysqli_num_rows($result) == 1) {

    $row = mysqli_fetch_array($result);

    $_SESSION["UserID"] = $row["User_ID"];  // แก้ตรงนี้
    $_SESSION["User"] = $row["User_LOG"];
    $_SESSION["User_Role"] = $row["User_Role"];

    if ($_SESSION["User_Role"] == "admin") { // Check for Admin role
      Header("Location: admin/main.html");
    } else if ($_SESSION["User_Role"] == "Teacher") {
      Header("Location: TeacherIndex.html");
    } else if ($_SESSION["User_Role"] == "Student") {
      Header("Location: StudentIndex.html");
    } else {
      echo "<script>";
      echo "alert(\"Username หรือ Password ไม่ถูกต้อง\");";
      echo "window.history.back()";
      echo "</script>";
    }
  } else {
    header("Location: index.html"); // User & password incorrect, back to login again
    exit();
  }
}
?>