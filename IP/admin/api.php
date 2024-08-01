<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'total_students':
            getTotalStudents();
            break;
        case 'students_by_year':
            getStudentsByYear();
            break;
        case 'total_departments':
            getTotalDepartments();
            break;
        case 'total_majors':
            getTotalMajors();
            break;
        case 'getGenderStatistics':  // Add this case for gender statistics
            getGenderStatistics();
            break;
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
    } else {
        echo json_encode(['error' => 'Action parameter is missing']);
    }

function getTotalStudents() {
    global $conn;
    $result = $conn->query("SELECT COUNT(*) AS total_students FROM student");
    echo json_encode($result->fetch_assoc());
}

function getStudentsByYear() {
    global $conn;
    $result = $conn->query("SELECT Stu_year_of_study, COUNT(*) AS total_students FROM student GROUP BY Stu_year_of_study");
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

function getTotalDepartments() {
    global $conn;
    $result = $conn->query("SELECT COUNT(DISTINCT Dep_ID) AS total_departments FROM department");
    echo json_encode($result->fetch_assoc());
}

function getTotalMajors() {
    global $conn;
    $result = $conn->query("SELECT COUNT(DISTINCT Major_ID) AS total_majors FROM major");
    echo json_encode($result->fetch_assoc());
}

function getGenderStatistics() {
    global $conn;
    $result = $conn->query("SELECT student.Stu_Name, department.Dep_Name
                            FROM student
                            JOIN department ON student.Dep_ID = department.Dep_ID");
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    echo json_encode($data);
}

$conn->close();
?>
