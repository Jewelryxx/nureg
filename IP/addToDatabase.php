<?php
include "login.php";

$_SESSION['username'] = 64316084;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // เชื่อมต่อกับฐานข้อมูล
    $con = mysqli_connect("localhost", "root", "", "registration_system");

    if (!$con) {
        die("การเชื่อมต่อล้มเหลว: " . mysqli_connect_error());
    }

    // วนลูปผ่านทุกรายการในตะกร้า
    foreach ($_SESSION['cart'] as $itemId) {
        // ประโยค SQL สำหรับดึงข้อมูลที่ต้องการ
        $query = "SELECT Subject.Subject_ID, Employee.EM_ID 
                  FROM Subject 
                  INNER JOIN Employee ON Subject.Subject_teacher = Employee.EM_ID 
                  WHERE Subject.Subject_ID = '$itemId'";
        
        $result = mysqli_query($con, $query);

        // ตรวจสอบว่ามีข้อมูลที่ดึงได้หรือไม่
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $subjectId = $row['Subject_ID'];
            $teacherId = $row['EM_ID'];
            $studentId = getStudentIdFromItemId($con);

            // ตรวจสอบว่าจำนวนนักเรียนที่ลงทะเบียนในวิชานั้นมีมากกว่าหรือเท่ากับ 10 หรือไม่
            $countQuery = "SELECT COUNT(*) as enrolledCount FROM SubjectEnrollments WHERE SubjectEnrollments_SubjectID = '$subjectId'";
            $countResult = mysqli_query($con, $countQuery);
            $enrolledCount = mysqli_fetch_assoc($countResult)['enrolledCount'];

            if ($enrolledCount < 10) {
                // ตรวจสอบว่านักเรียนคนนั้นยังไม่ได้ลงทะเบียนในวิชานี้หรือไม่
                $checkEnrollmentQuery = "SELECT * FROM SubjectEnrollments 
                                         WHERE SubjectEnrollments_SubjectID = '$subjectId' 
                                         AND SubjectEnrollments_StudentID = '$studentId'";
                $checkEnrollmentResult = mysqli_query($con, $checkEnrollmentQuery);

                if ($checkEnrollmentResult && mysqli_num_rows($checkEnrollmentResult) == 0) {
                    // ประโยค SQL สำหรับการเพิ่มข้อมูลลงในตาราง SubjectEnrollments
                    $enrollQuery = "INSERT INTO SubjectEnrollments (SubjectEnrollments_SubjectID, SubjectEnrollments_TeacherID, SubjectEnrollments_StudentID) 
                                    VALUES ('$subjectId', '$teacherId', '$studentId')";

                    $enrollResult = mysqli_query($con, $enrollQuery);

                    // ตรวจสอบว่าการเพิ่มข้อมูลลงใน SubjectEnrollments สำเร็จหรือไม่
                    if (!$enrollResult) {
                        echo 'เกิดข้อผิดพลาดในการเพิ่มข้อมูลลงในตาราง SubjectEnrollments.';
                        mysqli_close($con);
                        exit; // หยุดการทำงานถ้าเกิดข้อผิดพลาด
                    }
                } else {
                    echo 'คุณได้ลงทะเบียนวิชานี้แล้ว';
                }
            } else {
                echo 'วิชานี้เต็มจำนวนแล้ว';
            }
        } else {
            echo 'ไม่พบข้อมูลวิชาที่มี Subject_ID = ' . $itemId;
        }
    }

    echo 'รายการถูกเพิ่มลงในฐานข้อมูลเรียบร้อยแล้ว!';
    mysqli_close($con);

    // ลบรายการใน Session หลังจากเพิ่มลงในฐานข้อมูล
    unset($_SESSION['cart']);
}

// ฟังก์ชันที่ใช้ดึง studentId จาก username
function getStudentIdFromItemId($con) {
    $username = $_SESSION["User"];
    $escapedUsername = mysqli_real_escape_string($con, $username);
    $query = "SELECT Stu_id FROM Student WHERE Stu_id = '$escapedUsername'";
    $result = mysqli_query($con, $query);

    // ตรวจสอบว่ามีข้อมูลที่ดึงได้หรือไม่
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['Stu_id'];
    } else {
        return null;
    }
}
?>

