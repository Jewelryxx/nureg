<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query เพื่อดึงข้อมูลสำหรับกราฟ
$query = "SELECT m.Major_name AS Major,
a.Area_name AS Area,
COUNT(s.Stu_id) AS Student_Count
FROM student s
JOIN major m ON s.Stu_major = m.Major_ID
JOIN province p ON s.Stu_live = p.Province_ID
JOIN area a ON p.Province_Area = a.Area_id
GROUP BY m.Major_name, a.Area_name
ORDER BY a.Area_name, Major, Student_Count DESC";

$result = $conn->query($query); // Fixed: Use $conn instead of $mysqli

// สร้าง array เพื่อเก็บข้อมูลที่ได้จาก query
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// ส่งข้อมูลกลับเป็น JSON
echo json_encode($data);

// ปิดการเชื่อมต่อ MySQL
$conn->close();
?>