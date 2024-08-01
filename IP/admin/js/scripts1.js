document.addEventListener('DOMContentLoaded', function () {
    // Use Fetch API to retrieve data from PHP
    fetch('area.php')
        .then(response => response.json())
        .then(data => {
            // Data from PHP
            var areas = data.areas;
            var num_students = data.num_students;

            // Use Chart.js to create a pie chart
            var ctx = document.getElementById('areaChart').getContext('2d');
            ctx.canvas.width = 800; // กำหนดความกว้างของ canvas
            ctx.canvas.height = 600; // กำหนดความสูงของ canvas
            var areaChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: areas,
                    datasets: [{
                        label: 'Number of Students',
                        data: num_students,
                        backgroundColor: ['red', 'blue', 'green', 'yellow', 'orange'], // สีตามที่คุณต้องการ
                    }]
                },
            });
        })
        .catch(error => console.error('Error:', error));
});
