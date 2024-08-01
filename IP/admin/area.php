
<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve data
$sql = "SELECT a.Area_name, COUNT(s.Stu_id) as num_students
        FROM student s
        INNER JOIN province p ON s.Stu_live = p.Province_ID
        INNER JOIN area a ON p.Province_Area = a.Area_id
        GROUP BY a.Area_name";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch data from the result
    while ($row = $result->fetch_assoc()) {
        $areas[] = $row['Area_name'];
        $num_students[] = $row['num_students'];
    }

    // Close the database connection
    $conn->close();

    // Prepare the JSON response
    $response = json_encode(['areas' => $areas, 'num_students' => $num_students]);

    // Set the appropriate content type header
    header('Content-Type: application/json');

    // Output the JSON response
    echo $response;
} else {
    echo json_encode(['error' => 'No data found']);
}
?>