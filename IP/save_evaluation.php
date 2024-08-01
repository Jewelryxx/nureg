<?php
session_start();

// ตรวจสอบว่าฟอร์มถูกส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
    if (!isset($_SESSION['UserID'])) {
        echo "ผู้ใช้ไม่ได้ล็อกอิน";
        exit;
    }
    $enroll = $_POST['enroll'];
    // รับรหัสผู้ใช้จากเซสชัน
    $Stu_ID = $_SESSION['UserID'];
    // รับข้อมูลจากฟอร์ม
    $subject_id = $_POST['Subject_ID'];
    $teacher_id = $_POST['teacher_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    
    // เชื่อมต่อกับฐานข้อมูล
    $mysqli = new mysqli("localhost", "root", "", "registration_system");

    // ตรวจสอบการเชื่อมต่อ
    if ($mysqli->connect_error) {
        die("การเชื่อมต่อล้มเหลว: " . $mysqli->connect_error);
    }

    // เตรียมและผูกคำสั่ง SQL
    $stmt = $mysqli->prepare("INSERT INTO teacher_eva (enroll_ID, Stu_ID, Teacher_ID, Teacher_subject, Teacher_score, comment) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiis", $enroll, $Stu_ID, $teacher_id, $subject_id, $rating, $comment);

    // ดำเนินการคำสั่ง
    if ($stmt->execute()) {
        // ปิดคำสั่งและการเชื่อมต่อ
        $stmt->close();
        $mysqli->close();

        // แสดงเตือนและ redirect ไปยัง evaluation_page.php
        echo '<script>alert("เพิ่มข้อมูลเรียบร้อยแล้ว");';
        echo 'window.location.href = "evaluation_page.php";</script>';
        exit();
    } else {
        echo "ผิดพลาด: " . $stmt->error;
    }

    // ปิดคำสั่งและการเชื่อมต่อ
    $stmt->close();
    $mysqli->close();
} else {
    echo "ฟอร์มไม่ได้ถูกส่ง";
}
?>
