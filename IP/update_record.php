<?php
session_start();

// ตรวจสอบว่ามี session UserID หรือไม่
if (!isset($_SESSION["UserID"])) {
    header("Location: login.php"); // ถ้าไม่มีให้ redirect ไปที่หน้า login.php
    exit();
}

// ข้อมูลเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_system";

// ทำการเชื่อมต่อกับฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// รับค่าจากฟอร์ม
$enrollmentId = $_POST['enrollmentId'];
$sumSubjectPoint = $_POST['sumSubjectPoint'];
$grade = $_POST['grade'];

// คำสั่ง SQL สำหรับอัปเดตข้อมูล
$sql = "UPDATE subjectenrollments SET SumSubject_point = '$sumSubjectPoint', SubjectEnrollments_grade = '$grade' WHERE SubjectEnrollments_ID = '$enrollmentId'";

if ($conn->query($sql) === TRUE) {
    echo "อัปเดตข้อมูลเรียบร้อย";
} else {
    echo "Error updating record: " . $conn->error;
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
