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

$selectedTeacher = isset($_GET['teacher']) ? $_GET['teacher'] : 'all';

// Modified SQL query to include a JOIN with the employee table
$query = "SELECT e.EM_ID, CONCAT(e.EM_fname, ' ', e.EM_lname) AS Teacher_Name, 
          AVG(te.Teacher_score) AS Average_Score
          FROM teacher_eva te
          INNER JOIN employee e ON te.Teacher_ID = e.EM_ID";

// Add a condition to filter by Teacher_ID if a specific teacher is selected
if ($selectedTeacher !== 'all') {
    $query .= " WHERE te.Teacher_ID = '$selectedTeacher'";
}

$query .= " GROUP BY e.EM_ID";

$result = mysqli_query($conn, $query);

// Check for errors
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

// Create an array to store the data
$data = array();

// Fetch rows and add to the data array
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Close the database connection
mysqli_close($conn);

// Send the data as JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
