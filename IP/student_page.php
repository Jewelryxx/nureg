<?php
// กำหนดข้อมูลการเชื่อมต่อกับฐานข้อมูล
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

// ดึงรหัสนักเรียนจากพารามิเตอร์
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;

// คำสั่ง SQL เพื่อดึงข้อมูลนักเรียนและเกรด
$sql = "SELECT students.first_name, students.last_name, subjects.subject_name, grades.grade
        FROM students
        JOIN grades ON students.student_id = grades.student_id
        JOIN subjects ON grades.subject_id = subjects.subject_id
        WHERE students.student_id = $student_id";

$result = $conn->query($sql);

// แสดงผลลัพธ์ในรูปแบบตาราง
echo "<h2>ข้อมูลนักเรียน</h2>";
echo "<table border='1'>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Subject</th>
            <th>Grade</th>
        </tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["first_name"] . "</td>
                <td>" . $row["last_name"] . "</td>
                <td>" . $row["subject_name"] . "</td>
                <td>" . $row["grade"] . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>ไม่พบข้อมูล</td></tr>";
}

echo "</table>";

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>