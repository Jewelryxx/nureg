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

// Query to get the number of students in each major
$sql = "SELECT Major_name, COUNT(student.Stu_major) AS StudentCount FROM major LEFT JOIN student ON major.Major_ID = student.Stu_major GROUP BY Major_name";
$result = $conn->query($sql);

// Fetch the data as an associative array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close the connection
$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
