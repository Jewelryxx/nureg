<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Data Chart</title>
<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<canvas id="myChart" width="800" height="400"></canvas>
<script>
// Fetch data from PHP script
fetch('php_test.php')
  .then(response => response.json())
  .then(data => {
    // Extract unique faculties and areas
    const faculties = Array.from(new Set(data.map(item => item.Major)));
    const areas = Array.from(new Set(data.map(item => item.Area)));

    // Define color palette for areas
    const colors = [
      'rgba(255, 99, 132, 0.5)',
      'rgba(54, 162, 235, 0.5)',
      'rgba(255, 206, 86, 0.5)',
      'rgba(75, 192, 192, 0.5)',
      'rgba(153, 102, 255, 0.5)',
      'rgba(255, 159, 64, 0.5)'
    ];

    // Create object to store total student counts by faculty and area
    const facultyAreaStudentCounts = {};
    faculties.forEach((faculty, index) => {
      facultyAreaStudentCounts[faculty] = {};
      areas.forEach((area, i) => {
        facultyAreaStudentCounts[faculty][area] = 0;
      });
    });
    data.forEach(item => {
      facultyAreaStudentCounts[item.Major][item.Area] += parseInt(item.Student_Count);
    });

    // Create data object for Chart.js
    const chartData = {
      labels: faculties,
      datasets: areas.map((area, index) => ({
        label: area,
        data: faculties.map(faculty => facultyAreaStudentCounts[faculty][area]),
        backgroundColor: colors[index % colors.length], // Use color from palette
        borderColor: 'rgba(0, 0, 0, 1)',
        borderWidth: 1
      }))
    };

    // Configuration options
    const chartOptions = {
      scales: {
        xAxes: [{
          stacked: true
        }],
        yAxes: [{
          stacked: true,
          ticks: {
            beginAtZero: true
          }
        }]
      }
    };

    // Get chart canvas
    const ctx = document.getElementById('myChart').getContext('2d');

    // Create bar chart
    const myChart = new Chart(ctx, {
      type: 'bar',
      data: chartData,
      options: chartOptions
    });
  });
</script>
</body>
</html>
