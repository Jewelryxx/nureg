<?php
// รับค่าที่ส่งมาจากฟอร์ม
session_start();
$search = $_POST['search'];
echo "UserID: " . $_SESSION["UserID"];
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

// คำสั่ง SQL สำหรับค้นหาข้อมูลนิสิต
$sql = "SELECT * FROM subjectenrollments WHERE SubjectEnrollments_SubjectID = '$search' AND SubjectEnrollments_TeacherID = '" . $_SESSION["UserID"] . "'";

// ทำการส่งคำสั่ง SQL
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // แสดงผลข้อมูล
    echo "<table border='1'>
            <tr>
                <th>Enrollment ID</th>
                <th>Subject ID</th>
                <th>Teacher ID</th>
                <th>Student ID</th>
                <th>Sum Subject Point</th>
                <th>Grade</th>
                <th>Date Added</th>
                <th>Action</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["SubjectEnrollments_ID"] . "</td>
                <td>" . $row["SubjectEnrollments_SubjectID"] . "</td>
                <td>" . $row["SubjectEnrollments_TeacherID"] . "</td>
                <td>" . $row["SubjectEnrollments_StudentID"] . "</td>
                <td>" . $row["SumSubject_point"] . "</td>
                <td>" . $row["SubjectEnrollments_grade"] . "</td>
                <td>" . $row["Date_added"] . "</td>
                <td><button onclick='editRecord(" . $row["SubjectEnrollments_ID"] . ")'>แก้ไข</button></td>
            </tr>";
    }

    echo "</table>";
} else {
    // ถ้าไม่พบข้อมูล
    echo "ไม่พบข้อมูลการลงทะเบียนรายวิชา";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
