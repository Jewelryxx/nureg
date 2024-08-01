<?php
// Replace these database connection details with your own
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the number of students based on selected filters
$sql = "SELECT * FROM student WHERE 1";

$conditions = array();
$bindParams = '';
$paramValues = array();

$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$province = isset($_POST['province']) ? $_POST['province'] : '';
$type_of_study = isset($_POST['type_of_study']) ? $_POST['type_of_study'] : '';
$year_rank = isset($_POST['year_rank']) ? $_POST['year_rank'] : '';
$major = isset($_POST['major']) ? $_POST['major'] : '';
$department = isset($_POST['department']) ? $_POST['department'] : '';
$nationality = isset($_POST['nationality']) ? $_POST['nationality'] : '';


// Add more conditions as needed
if ($gender !== '') {
    $conditions[] = "Stu_gender = ?";
    $bindParams .= 's'; // Append 's' for string
    $paramValues[] = $gender;
}

if ($province !== '') {
    $conditions[] = "Stu_live = ?";
    $bindParams .= 's'; // Append 's' for string
    $paramValues[] = $province;
}

if ($type_of_study !== '') {
    $conditions[] = "Stu_type_of_study = ?";
    $bindParams .= 's'; // Append 's' for string
    $paramValues[] = $type_of_study;
}

if ($year_rank !== '') {
    $conditions[] = "Stu_year_rank = ?";
    $bindParams .= 's'; // Append 's' for string
    $paramValues[] = $year_rank;
}

if ($major !== '') {
    $conditions[] = "Stu_major = ?";
    $bindParams .= 's'; // Append 's' for string
    $paramValues[] = $major;
}

if ($department !== '') {
    $conditions[] = "Stu_department = ?";
    $bindParams .= 's'; // Append 's' for string
    $paramValues[] = $department;
}

if ($nationality !== '') {
    $conditions[] = "Stu_nationality = ?";
    $bindParams .= 's'; // Append 's' for string
    $paramValues[] = $nationality;
}


// Add more conditions...

// Check if there are any conditions
if (!empty($conditions)) {
    $sql .= " AND " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql);

if (!empty($bindParams)) {
    $stmt->bind_param($bindParams, ...$paramValues);
}

$stmt->execute();
$result = $stmt->get_result();

$numRows = $result->num_rows;

$stmt->close();
$conn->close();

// Output JSON
echo json_encode(array('num_rows' => $numRows));
?>