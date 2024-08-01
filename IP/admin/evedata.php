<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_system";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$selectedFaculty = isset($_GET['faculty']) ? $_GET['faculty'] : 'all';

// Modified SQL query to include a JOIN with the subject and employee tables
$query = "SELECT te.*, CONCAT(e.EM_fname, ' ', e.EM_lname) AS Teacher_Name, s.Subject_name
          FROM teacher_eva te
          INNER JOIN employee e ON te.Teacher_ID = e.EM_ID
          INNER JOIN subject s ON te.Teacher_subject = s.Subject_ID";

// Add a condition to filter by faculty if a specific faculty is selected
if ($selectedFaculty !== 'all') { 
    $query .= " WHERE e.EM_major = '$selectedFaculty'"; 
}

$result = mysqli_query($conn, $query);

// Check for errors
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

// Create an array to store the data
$data = array();

// Fetch rows and add to the data array
while ($row = mysqli_fetch_assoc($result)) {
    // Replace Subject_ID with Subject_name
    $row['Teacher_subject'] = $row['Subject_name'];
    unset($row['Subject_name']); // Remove the Subject_name column
    $data[] = $row;
}

// Close the database connection
mysqli_close($conn);

// Send the data as JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>