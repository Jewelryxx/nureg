<?php
session_start();

// ... (โค้ดในการเชื่อมต่อฐานข้อมูล)

if (isset($_POST['search'])) {
    $con = mysqli_connect("localhost", "root", "", "registration_system");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $search = mysqli_real_escape_string($con, $_POST['search']);

    // ตรวจสอบจำนวนนักเรียนที่ลงทะเบียนแล้วในวิชานั้น
    $countQuery = "SELECT COUNT(*) as enrolledCount FROM subjectenrollments WHERE SubjectEnrollments_SubjectID = ?";

    $countStmt = mysqli_prepare($con, $countQuery);
    mysqli_stmt_bind_param($countStmt, "s", $search);
    mysqli_stmt_execute($countStmt);
    $countResult = mysqli_stmt_get_result($countStmt);
    $enrolledCount = mysqli_fetch_assoc($countResult)['enrolledCount'];

    if ($enrolledCount < 10) {  // ตรวจสอบว่ายังมีที่ว่างในวิชานี้หรือไม่
        $query = "SELECT * FROM subject 
                  WHERE Subject_id LIKE ? AND Subject_ID NOT IN (
                      SELECT SubjectEnrollments_SubjectID FROM subjectenrollments 
                      WHERE SubjectEnrollments_StudentID = ? 
                  )";

        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "ss", $searchParam, $studentIDParam);

        $searchParam = "%$search%";
        $studentIDParam = $_SESSION["UserID"];  // ใช้ User_ID จาก Session แทนที่

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Generate HTML for the search results
        $output = '<table>';
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= '<tr><td>' . $row['Subject_ID'] . '</td><td>' . $row['Subject_name'] . '</td>';
            $output .= '<td><button class="addToCartBtn" data-item-id="' . $row['Subject_ID'] . '">Add to Cart</button></td></tr>';
        }
        $output .= '</table>';

        echo $output;
    } else {
        echo "This subject is full. You cannot enroll in this subject anymore.";
    }

    mysqli_close($con);
}
?>


