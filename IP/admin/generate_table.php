<?php
// Replace these database connection details with your own
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT student.*, 
               gender.Gender_name AS StudentGender, 
               major.Major_name AS StudentMajor, 
               department.Dep_name AS StudentDepartment,
               title.Title_name AS StudentTitle
        FROM student 
        LEFT JOIN title ON student.Stu_title = title.Title_ID
        LEFT JOIN gender ON student.Stu_gender = gender.Gender_ID
        LEFT JOIN major ON student.Stu_major = major.Major_ID
        LEFT JOIN department ON student.Stu_department = department.Dep_ID
        WHERE 1";




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

$resultsArray = array();

while ($row = $result->fetch_assoc()) {
    $resultsArray[] = $row;
}

$stmt->close();
$conn->close();

// Output the table
echo '<table border="1">
        <thead>
            <tr>
                <th>StudentID</th>
                <th>StudentTitle</th>    
                <th>First Name</th>
                <th>Last Name</th>
                <th>StudentGender</th>
                <th>StudentYear</th> 
                <th>StudentMajor</th> 
                <th>StudentDepartment</th>              
            </tr>
        </thead>
        <tbody>';

foreach ($resultsArray as $row) {
    echo "<tr>
            <td>{$row['Stu_id']}</td>
            <td>{$row['StudentTitle']}</td>
            <td>{$row['Stu_fname']}</td>
            <td>{$row['Stu_lname']}</td>
            <td>{$row['StudentGender']}</td>
            <td>{$row['Stu_year_rank']}</td>
            <td>{$row['StudentMajor']}</td>
            <td>{$row['StudentDepartment']}</td>
            <!-- Add columns as needed -->
        </tr>";
}


echo '</tbody>
        </table>';

?>