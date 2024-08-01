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

// รับค่าปีและเทอมจากการร้องขอ
$year = $_GET['year'];
$semester = $_GET['semester'];

// สร้าง query เพื่อดึงข้อมูล
$sql = "SELECT TIME(Date_added) as Time, COUNT(*) as Count FROM subjectenrollments WHERE Year = '$year' AND Semester = '$semester' GROUP BY TIME(Date_added)";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // แปลงข้อมูลเป็นรูปแบบของ array เพื่อส่งให้กับ JavaScript
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}

$conn->close();

// ส่งข้อมูลในรูปแบบ JSON กลับไปยัง JavaScript
echo json_encode($data);
?>
