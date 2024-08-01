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

// ตรวจสอบว่ามีการส่งค่า subjectClass มาหรือไม่
if (isset($_GET['subjectClass'])) {
    $selectedSubjectClass = $_GET['subjectClass'];

    // ถ้ามีการกรอง
    $sql = "SELECT subjectenrollments.*, subjectclass.SC_name
            FROM subjectenrollments
            LEFT JOIN subjectclass ON subjectenrollments.SubjectEnrollments_SubjectID = subjectclass.SC_ID
            WHERE subjectclass.SC_name = '$selectedSubjectClass'
            ORDER BY subjectenrollments.enrollment_count DESC
            LIMIT 5";
} else {
    // ถ้าไม่มีการกรอง
    $sql = "SELECT subjectenrollments.*, subjectclass.SC_name
            FROM subjectenrollments
            LEFT JOIN subjectclass ON subjectenrollments.SubjectEnrollments_SubjectID = subjectclass.SC_ID
            ORDER BY subjectenrollments.enrollment_count DESC
            LIMIT 5";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        // เพิ่มค่า enrollment_count ในแต่ละ row
        $row['enrollment_count'] += 1;
        $data[] = $row;
    }

    // ส่งข้อมูลเป็น JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo "No data found";
}

$conn->close();
?>