<?php
// ทำการเชื่อมต่อกับ MySQL Database
$servername = "localhost";
$username = "root";
$password = "";
$database = "registration_system";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// คำสั่ง SQL สำหรับดึงข้อมูลนักศึกษาแบ่งตามชั้นปีและเพศ
$sql = "SELECT Stu_year_of_study, Stu_gender, COUNT(*) AS count FROM student GROUP BY Stu_year_of_study, Stu_gender ORDER BY Stu_year_of_study";

// ทำการดึงข้อมูล
$result = $conn->query($sql);

// ตรวจสอบว่ามีข้อมูลหรือไม่
if ($result->num_rows > 0) {
    $dataPointsMale = array();
    $dataPointsFemale = array();
    $dataPointsLGTVQ = array();
    while($row = $result->fetch_assoc()) {
        if ($row["Stu_gender"] == "1") {
            $dataPointMale = array("label" => $row["Stu_year_of_study"], "y" => $row["count"]);
            array_push($dataPointsMale, $dataPointMale);
        } elseif ($row["Stu_gender"] == "2") {
            $dataPointFemale = array("label" => $row["Stu_year_of_study"], "y" => $row["count"]);
            array_push($dataPointsFemale, $dataPointFemale);
        } elseif ($row["Stu_gender"] == "3") {
            $dataPointLGTVQ = array("label" => $row["Stu_year_of_study"], "y" => $row["count"]);
            array_push($dataPointsLGTVQ, $dataPointLGTVQ);
        }
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<!DOCTYPE HTML>
<html>

<head>
    <script>
    window.onload = function() {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "จำนวนนักศึกษาต่อชั้นปีแยกตามเพศ"
            },
            axisY: {
                title: "จำนวนนักศึกษา"
            },
            data: [{
                    type: "column",
                    showInLegend: true,
                    name: "ชาย",
                    yValueFormatString: "#,##0 คน",
                    dataPoints: <?php echo json_encode($dataPointsMale, JSON_NUMERIC_CHECK); ?>
                },
                {
                    type: "column",
                    showInLegend: true,
                    name: "หญิง",
                    yValueFormatString: "#,##0 คน",
                    dataPoints: <?php echo json_encode($dataPointsFemale, JSON_NUMERIC_CHECK); ?>
                },
                {
                    type: "column",
                    showInLegend: true,
                    name: "อื่นๆ",
                    yValueFormatString: "#,##0 คน",
                    dataPoints: <?php echo json_encode($dataPointsLGTVQ, JSON_NUMERIC_CHECK); ?>
                }
            ]
        });
        chart.render();
    }
    </script>
</head>

<body>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html>