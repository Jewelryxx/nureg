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

// รับค่าที่ผู้ใช้กรอกจากฟอร์ม
$defaultYear = $_POST['defaultYear'];
$defaultSemester = $_POST['defaultSemester'];

// เปลี่ยนค่า DEFAULT ของคอลัมน์ `Year` และ `Semester`
$sql = "ALTER TABLE `subjectenrollments` MODIFY COLUMN `Year` int(10) DEFAULT $defaultYear";
$conn->query($sql);

$sql = "ALTER TABLE `subjectenrollments` MODIFY COLUMN `Semester` varchar(10) DEFAULT '$defaultSemester'";
$conn->query($sql);

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();

// ให้ผู้ใช้กลับไปที่หน้าหลัก
header("Location: index.html");
?>
