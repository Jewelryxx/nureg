<?php
session_start();

if(isset($_GET['enrollmentID']) && isset($_GET['newScore']) && isset($_GET['newGrade'])) {
    $con = mysqli_connect("localhost", "root", "", "registration_system");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $enrollmentID = $_GET['enrollmentID'];
    $newScore = $_GET['newScore'];
    $newGrade = $_GET['newGrade'];

    $sql = "UPDATE subjectenrollments SET SumSubject_point = ?, SubjectEnrollments_grade = ? WHERE SubjectEnrollments_ID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sss", $newScore, $newGrade, $enrollmentID);

    if ($stmt->execute()) {
        echo "อัปเดตข้อมูลสำเร็จ";
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
}
?>